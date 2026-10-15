<?php

namespace App\Controllers;

use App\Models\HasilSawModel;
use App\Models\KriteriaModel;
use App\Models\PengaturanModel;
use App\Models\PenilaianModel;
use App\Models\PeriodePenilaianModel;
use App\Models\ProyekModel;
use App\Services\SawService;
use Throwable;

class PeriodeController extends BaseController
{
    protected PeriodePenilaianModel $periodeModel;
    protected ProyekModel $proyekModel;
    protected PenilaianModel $penilaianModel;
    protected HasilSawModel $hasilSawModel;
    protected KriteriaModel $kriteriaModel;
    protected PengaturanModel $pengaturanModel;
    protected SawService $sawService;

    public function __construct()
    {
        $this->periodeModel    = new PeriodePenilaianModel();
        $this->proyekModel     = new ProyekModel();
        $this->penilaianModel  = new PenilaianModel();
        $this->hasilSawModel   = new HasilSawModel();
        $this->kriteriaModel   = new KriteriaModel();
        $this->pengaturanModel = new PengaturanModel();
        $this->sawService      = new SawService();
    }

    public function index()
    {
        $periodes = $this->periodeModel->orderBy('tanggal_penilaian', 'DESC')->findAll();

        // Attach counts
        foreach ($periodes as &$p) {
            $p['jumlah_proyek'] = $this->penilaianModel->where('periode_id', $p['id'])->countAllResults();
            $p['jumlah_hasil']  = $this->hasilSawModel->where('periode_id', $p['id'])->countAllResults();
        }
        unset($p);

        return view('periode/index', [
            'title'      => 'Periode Penilaian',
            'page_title' => 'Kelola Periode Penilaian Kinerja',
            'periodes'   => $periodes,
        ]);
    }

    public function create()
    {
        $proyeks = $this->proyekModel->orderBy('kode', 'ASC')->findAll();

        return view('periode/create', [
            'title'      => 'Buat Periode Baru',
            'page_title' => 'Tambah Periode Penilaian Proyek',
            'proyeks'    => $proyeks,
        ]);
    }

    public function store()
    {
        $rules = [
            'nama'              => 'required|min_length[3]|max_length[100]',
            'tanggal_penilaian' => 'required|valid_date[Y-m-d]',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $selectedProyekIds = $this->request->getPost('proyek_ids');
        if (empty($selectedProyekIds) || ! is_array($selectedProyekIds)) {
            return redirect()->back()->withInput()->with('error', 'Pilih minimal satu proyek untuk dinilai pada periode ini.');
        }

        $userId = session()->get('user_id');

        $periodeId = $this->periodeModel->insert([
            'nama'              => trim((string)$this->request->getPost('nama')),
            'tanggal_penilaian' => $this->request->getPost('tanggal_penilaian'),
            'status'            => 'draft',
            'created_by'        => $userId,
        ], true);

        // Pre-populate empty assessment entries for selected projects
        foreach ($selectedProyekIds as $pId) {
            $proyek = $this->proyekModel->find((int)$pId);
            if ($proyek) {
                $this->penilaianModel->insert([
                    'periode_id'             => $periodeId,
                    'proyek_id'              => $proyek['id'],
                    'progres_rencana'        => 100.00,
                    'progres_aktual'         => 0.00,
                    'biaya_realisasi'        => (float)$proyek['nilai_rab'],
                    'skor_foto_progres'      => 5,
                    'skor_bast'              => 5,
                    'tanggal_selesai_aktual' => $proyek['tanggal_selesai_rencana'],
                ]);
            }
        }

        return redirect()->to(site_url('penilaian/' . $periodeId))->with('success', 'Periode penilaian berhasil dibuat. Silakan lengkapi data mentah proyek.');
    }

    public function edit(int $id)
    {
        $periode = $this->periodeModel->find($id);
        if (! $periode) {
            return redirect()->to(site_url('periode'))->with('error', 'Periode tidak ditemukan.');
        }

        return view('periode/edit', [
            'title'      => 'Ubah Periode',
            'page_title' => 'Edit Periode: ' . esc($periode['nama']),
            'periode'    => $periode,
        ]);
    }

    public function update(int $id)
    {
        $periode = $this->periodeModel->find($id);
        if (! $periode) {
            return redirect()->to(site_url('periode'))->with('error', 'Periode tidak ditemukan.');
        }

        $rules = [
            'nama'              => 'required|min_length[3]|max_length[100]',
            'tanggal_penilaian' => 'required|valid_date[Y-m-d]',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->periodeModel->update($id, [
            'nama'              => trim((string)$this->request->getPost('nama')),
            'tanggal_penilaian' => $this->request->getPost('tanggal_penilaian'),
        ]);

        return redirect()->to(site_url('periode'))->with('success', 'Informasi periode berhasil diperbarui.');
    }

    public function delete(int $id)
    {
        $periode = $this->periodeModel->find($id);
        if (! $periode) {
            return redirect()->to(site_url('periode'))->with('error', 'Periode tidak ditemukan.');
        }

        $this->periodeModel->delete($id);
        return redirect()->to(site_url('periode'))->with('success', 'Periode penilaian dan seluruh data hasil terkait berhasil dihapus.');
    }

    public function hitungSaw(int $id)
    {
        $periode = $this->periodeModel->find($id);
        if (! $periode) {
            return redirect()->to(site_url('periode'))->with('error', 'Periode tidak ditemukan.');
        }

        $penilaians = $this->penilaianModel->getPenilaianWithProyek($id);
        if (empty($penilaians)) {
            return redirect()->to(site_url('penilaian/' . $id))->with('error', 'Belum ada data proyek yang dinilai pada periode ini.');
        }

        $kriterias = $this->kriteriaModel->findAll();
        $settings  = $this->pengaturanModel->getAllAsMap();

        // Prepare alternatives for SawService
        $alternatives = [];
        foreach ($penilaians as $pen) {
            $rawValues = [
                'progres_rencana'        => $pen['progres_rencana'],
                'progres_aktual'         => $pen['progres_aktual'],
                'nilai_rab'              => $pen['nilai_rab'],
                'biaya_realisasi'        => $pen['biaya_realisasi'],
                'skor_foto_progres'      => (int)($pen['skor_foto_progres'] ?? 5),
                'skor_bast'              => $pen['skor_bast'],
                'tanggal_selesai_rencana'=> $pen['tanggal_selesai_rencana'],
                'tanggal_selesai_aktual' => $pen['tanggal_selesai_aktual'],
            ];

            $critValues = $this->sawService->calculateCriteriaValues($rawValues);

            $alternatives[] = [
                'id'       => $pen['proyek_id'],
                'nama'     => $pen['proyek_nama'],
                'kode'     => $pen['proyek_kode'],
                'criteria' => $critValues,
                'raw'      => $rawValues,
            ];
        }

        try {
            $sawOutput = $this->sawService->calculateSaw($alternatives, $kriterias, [
                'batas_baik'      => (float)($settings['batas_baik'] ?? 0.80),
                'batas_perhatian' => (float)($settings['batas_perhatian'] ?? 0.60),
            ]);
        } catch (Throwable $e) {
            return redirect()->to(site_url('penilaian/' . $id))->with('error', $e->getMessage());
        }

        // Save results in transaction
        $db = \Config\Database::connect();
        $db->transStart();

        // Clear previous results for this period
        $this->hasilSawModel->where('periode_id', $id)->delete();

        foreach ($sawOutput['results'] as $altId => $item) {
            $this->hasilSawModel->insert([
                'periode_id'  => $id,
                'proyek_id'   => $altId,
                'c1'          => $item['c1'],
                'c2'          => $item['c2'],
                'c3'          => $item['c3'],
                'c4'          => $item['c4'],
                'c5'          => $item['c5'],
                'vi'          => $item['vi'],
                'peringkat'   => $item['peringkat'],
                'kategori'    => $item['kategori'],
                'detail_json' => json_encode([
                    'matrix_r' => $item['matrix_r'],
                    'matrix_w' => $item['matrix_w'],
                ]),
            ]);
        }

        // Update status periode
        $this->periodeModel->update($id, ['status' => 'terhitung']);

        $db->transComplete();

        if ($db->transStatus() === false) {
            return redirect()->to(site_url('penilaian/' . $id))->with('error', 'Gagal menyimpan hasil perhitungan SAW.');
        }

        return redirect()->to(site_url('hasil/' . $id))->with('success', 'Kalkulasi SAW berhasil diselesaikan! Peringkat proyek telah diperbarui.');
    }
}
