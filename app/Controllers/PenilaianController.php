<?php

namespace App\Controllers;

use App\Models\PenilaianModel;
use App\Models\PeriodePenilaianModel;
use App\Models\ProyekModel;
use App\Services\SawService;

class PenilaianController extends BaseController
{
    protected PenilaianModel $penilaianModel;
    protected PeriodePenilaianModel $periodeModel;
    protected ProyekModel $proyekModel;
    protected SawService $sawService;

    public function __construct()
    {
        $this->penilaianModel = new PenilaianModel();
        $this->periodeModel   = new PeriodePenilaianModel();
        $this->proyekModel    = new ProyekModel();
        $this->sawService     = new SawService();
    }

    public function index(int $periodeId)
    {
        $periode = $this->periodeModel->find($periodeId);
        if (! $periode) {
            return redirect()->to(site_url('periode'))->with('error', 'Periode penilaian tidak ditemukan.');
        }

        $penilaians = $this->penilaianModel->getPenilaianWithProyek($periodeId);

        // Precompute preview criteria values for display
        foreach ($penilaians as &$p) {
            $p['kriteria_preview'] = $this->sawService->calculateCriteriaValues([
                'progres_rencana'        => $p['progres_rencana'],
                'progres_aktual'         => $p['progres_aktual'],
                'nilai_rab'              => $p['nilai_rab'],
                'biaya_realisasi'        => $p['biaya_realisasi'],
                'skor_foto_progres'      => (int)($p['skor_foto_progres'] ?? 5),
                'skor_bast'              => $p['skor_bast'],
                'tanggal_selesai_rencana'=> $p['tanggal_selesai_rencana'],
                'tanggal_selesai_aktual' => $p['tanggal_selesai_aktual'],
            ]);
        }
        unset($p);

        // All projects for adding new project to this period
        $assignedProyekIds = array_column($penilaians, 'proyek_id');
        $availableProyeks = $this->proyekModel
            ->whereNotIn('id', !empty($assignedProyekIds) ? $assignedProyekIds : [0])
            ->orderBy('kode', 'ASC')
            ->findAll();

        return view('penilaian/index', [
            'title'            => 'Input Penilaian Proyek',
            'page_title'       => 'Input Data Mentah: ' . esc($periode['nama']),
            'periode'          => $periode,
            'penilaians'       => $penilaians,
            'availableProyeks' => $availableProyeks,
        ]);
    }

    public function edit(int $periodeId, int $proyekId)
    {
        $periode = $this->periodeModel->find($periodeId);
        if (! $periode) {
            return redirect()->to(site_url('periode'))->with('error', 'Periode tidak ditemukan.');
        }

        $penilaian = $this->penilaianModel
            ->select('penilaian.*, proyek.kode as proyek_kode, proyek.nama as proyek_nama, proyek.jenis, proyek.klien, proyek.lokasi, proyek.tanggal_mulai, proyek.tanggal_selesai_rencana, proyek.nilai_rab')
            ->join('proyek', 'proyek.id = penilaian.proyek_id')
            ->where('penilaian.periode_id', $periodeId)
            ->where('penilaian.proyek_id', $proyekId)
            ->first();

        if (! $penilaian) {
            return redirect()->to(site_url('penilaian/' . $periodeId))->with('error', 'Data penilaian proyek tidak ditemukan.');
        }

        $preview = $this->sawService->calculateCriteriaValues([
            'progres_rencana'        => $penilaian['progres_rencana'],
            'progres_aktual'         => $penilaian['progres_aktual'],
            'nilai_rab'              => $penilaian['nilai_rab'],
            'biaya_realisasi'        => $penilaian['biaya_realisasi'],
            'skor_foto_progres'      => (int)($penilaian['skor_foto_progres'] ?? 5),
            'skor_bast'              => $penilaian['skor_bast'],
            'tanggal_selesai_rencana'=> $penilaian['tanggal_selesai_rencana'],
            'tanggal_selesai_aktual' => $penilaian['tanggal_selesai_aktual'],
        ]);

        return view('penilaian/form', [
            'title'      => 'Edit Nilai Proyek',
            'page_title' => 'Input Penilaian: ' . esc($penilaian['proyek_nama']),
            'periode'    => $periode,
            'penilaian'  => $penilaian,
            'preview'    => $preview,
        ]);
    }

    public function save(int $periodeId, int $proyekId)
    {
        $rules = [
            'progres_rencana'        => 'required|numeric|greater_than[0]|less_than_equal_to[100]',
            'progres_aktual'         => 'required|numeric|greater_than_equal_to[0]|less_than_equal_to[100]',
            'biaya_realisasi'        => 'required|numeric|greater_than_equal_to[0]',
            'skor_foto_progres'      => 'required|in_list[1,2,3,4,5]',
            'skor_bast'              => 'required|in_list[1,2,3,4,5]',
            'tanggal_selesai_aktual' => 'required|valid_date[Y-m-d]',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $existing = $this->penilaianModel
            ->where('periode_id', $periodeId)
            ->where('proyek_id', $proyekId)
            ->first();

        $data = [
            'periode_id'             => $periodeId,
            'proyek_id'              => $proyekId,
            'progres_rencana'        => (float)$this->request->getPost('progres_rencana'),
            'progres_aktual'         => (float)$this->request->getPost('progres_aktual'),
            'biaya_realisasi'        => (float)$this->request->getPost('biaya_realisasi'),
            'skor_foto_progres'      => (int)$this->request->getPost('skor_foto_progres'),
            'skor_bast'              => (int)$this->request->getPost('skor_bast'),
            'tanggal_selesai_aktual' => $this->request->getPost('tanggal_selesai_aktual'),
        ];

        if ($existing) {
            $this->penilaianModel->update($existing['id'], $data);
        } else {
            $this->penilaianModel->insert($data);
        }

        // Set status periode to draft (needs re-calculation)
        $this->periodeModel->update($periodeId, ['status' => 'draft']);

        return redirect()->to(site_url('penilaian/' . $periodeId))->with('success', 'Data penilaian proyek berhasil disimpan.');
    }

    public function saveBatch(int $periodeId)
    {
        $periode = $this->periodeModel->find($periodeId);
        if (! $periode) {
            return redirect()->to(site_url('periode'))->with('error', 'Periode tidak ditemukan.');
        }

        $items = $this->request->getPost('items');
        if (! is_array($items) || empty($items)) {
            return redirect()->to(site_url('penilaian/' . $periodeId))->with('error', 'Tidak ada data penilaian yang dikirim.');
        }

        $db = \Config\Database::connect();
        $db->transStart();

        foreach ($items as $proyekId => $data) {
            $progresRencana = 100.00;
            $progresAktual  = (float)($data['progres_aktual'] ?? 0);
            $biayaRealisasi = (float)($data['biaya_realisasi'] ?? 0);
            $skorFoto       = (int)($data['skor_foto_progres'] ?? 5);
            $skorBast       = (int)($data['skor_bast'] ?? 5);
            $tglAktual      = $data['tanggal_selesai_aktual'] ?? date('Y-m-d');

            $existing = $this->penilaianModel
                ->where('periode_id', $periodeId)
                ->where('proyek_id', (int)$proyekId)
                ->first();

            $saveData = [
                'periode_id'             => $periodeId,
                'proyek_id'              => (int)$proyekId,
                'progres_rencana'        => $progresRencana,
                'progres_aktual'         => $progresAktual,
                'biaya_realisasi'        => $biayaRealisasi,
                'skor_foto_progres'      => $skorFoto,
                'skor_bast'              => $skorBast,
                'tanggal_selesai_aktual' => $tglAktual,
            ];

            if ($existing) {
                $this->penilaianModel->update($existing['id'], $saveData);
            } else {
                $this->penilaianModel->insert($saveData);
            }
        }

        $this->periodeModel->update($periodeId, ['status' => 'draft']);
        $db->transComplete();

        if ($db->transStatus() === false) {
            return redirect()->to(site_url('penilaian/' . $periodeId))->with('error', 'Gagal menyimpan perubahan batch.');
        }

        return redirect()->to(site_url('penilaian/' . $periodeId))->with('success', 'Semua data penilaian proyek berhasil disimpan sekaligus.');
    }

    public function addProyek(int $periodeId)
    {
        $proyekId = (int)$this->request->getPost('proyek_id');
        $proyek = $this->proyekModel->find($proyekId);

        if (! $proyek) {
            return redirect()->back()->with('error', 'Proyek tidak valid.');
        }

        $existing = $this->penilaianModel
            ->where('periode_id', $periodeId)
            ->where('proyek_id', $proyekId)
            ->first();

        if (! $existing) {
            $this->penilaianModel->insert([
                'periode_id'             => $periodeId,
                'proyek_id'              => $proyekId,
                'progres_rencana'        => 100.00,
                'progres_aktual'         => 0.00,
                'biaya_realisasi'        => (float)$proyek['nilai_rab'],
                'skor_foto_progres'      => 5,
                'skor_bast'              => 5,
                'tanggal_selesai_aktual' => $proyek['tanggal_selesai_rencana'],
            ]);
            $this->periodeModel->update($periodeId, ['status' => 'draft']);
        }

        return redirect()->to(site_url('penilaian/' . $periodeId))->with('success', 'Proyek ' . esc($proyek['nama']) . ' berhasil ditambahkan ke periode.');
    }

    public function removeProyek(int $periodeId, int $proyekId)
    {
        $this->penilaianModel
            ->where('periode_id', $periodeId)
            ->where('proyek_id', $proyekId)
            ->delete();

        // Also remove from hasil_saw if present
        $db = \Config\Database::connect();
        $db->table('hasil_saw')
            ->where('periode_id', $periodeId)
            ->where('proyek_id', $proyekId)
            ->delete();

        $this->periodeModel->update($periodeId, ['status' => 'draft']);

        return redirect()->to(site_url('penilaian/' . $periodeId))->with('success', 'Proyek berhasil dihapus dari periode ini.');
    }
}
