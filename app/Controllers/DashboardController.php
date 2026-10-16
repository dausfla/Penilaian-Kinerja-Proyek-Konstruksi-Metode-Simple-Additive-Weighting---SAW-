<?php

namespace App\Controllers;

use App\Models\HasilSawModel;
use App\Models\KriteriaModel;
use App\Models\PengaturanModel;
use App\Models\PenilaianModel;
use App\Models\PeriodePenilaianModel;
use App\Models\ProyekModel;
use App\Models\UserModel;
use App\Services\SawService;
use Dompdf\Dompdf;
use Dompdf\Options;
use Throwable;

class DashboardController extends BaseController
{
    protected ProyekModel $proyekModel;
    protected PeriodePenilaianModel $periodeModel;
    protected PenilaianModel $penilaianModel;
    protected HasilSawModel $hasilSawModel;
    protected KriteriaModel $kriteriaModel;
    protected PengaturanModel $pengaturanModel;
    protected SawService $sawService;

    public function __construct()
    {
        $this->proyekModel     = new ProyekModel();
        $this->periodeModel    = new PeriodePenilaianModel();
        $this->penilaianModel  = new PenilaianModel();
        $this->hasilSawModel   = new HasilSawModel();
        $this->kriteriaModel   = new KriteriaModel();
        $this->pengaturanModel = new PengaturanModel();
        $this->sawService      = new SawService();
    }

    public function index(?int $periodeId = null)
    {
        $allPeriodes = $this->periodeModel->orderBy('tanggal_penilaian', 'DESC')->findAll();

        if ($periodeId === null) {
            $activePeriode = $this->getOrCreateActivePeriode();
        } else {
            $activePeriode = $this->periodeModel->find($periodeId);
            if (! $activePeriode) {
                return redirect()->to(site_url('dashboard'))->with('error', 'Sesi evaluasi tidak ditemukan.');
            }
        }

        // Fetch or auto-calculate results
        $hasilList = $this->hasilSawModel->getHasilWithProyek($activePeriode['id']);
        $penilaians = $this->penilaianModel->getPenilaianWithProyek($activePeriode['id']);

        if (empty($hasilList) && ! empty($penilaians)) {
            $this->executeSawCalculation($activePeriode['id']);
            $hasilList = $this->hasilSawModel->getHasilWithProyek($activePeriode['id']);
        }

        // Map raw penilaian data to project ID
        $penMap = [];
        foreach ($penilaians as $pen) {
            $penMap[$pen['proyek_id']] = $pen;
        }

        foreach ($hasilList as &$h) {
            $h['raw'] = $penMap[$h['proyek_id']] ?? null;
        }
        unset($h);

        // Category counters
        $kategoriCount = ['Baik' => 0, 'Perlu Perhatian' => 0, 'Berisiko/Terlambat' => 0];
        foreach ($hasilList as $h) {
            $kat = $h['kategori'];
            if (isset($kategoriCount[$kat])) {
                $kategoriCount[$kat]++;
            }
        }

        $allProyeks = $this->proyekModel->orderBy('nama', 'ASC')->findAll();
        $settings   = $this->pengaturanModel->getAllAsMap();

        return view('dashboard/index', [
            'title'          => 'Evaluasi & Peringkat Proyek',
            'page_title'     => 'Evaluasi & Peringkat Proyek',
            'allPeriodes'    => $allPeriodes,
            'activePeriode'  => $activePeriode,
            'hasilList'      => $hasilList,
            'kategoriCount'  => $kategoriCount,
            'allProyeks'     => $allProyeks,
            'settings'       => $settings,
            'batasBaik'      => (float)($settings['batas_baik'] ?? 0.80),
            'batasPerhatian' => (float)($settings['batas_perhatian'] ?? 0.60),
            'jenisList'      => ['rumah', 'gedung', 'kantor', 'kost', 'apartemen', 'interior', 'landscape', 'renovasi'],
        ]);
    }

    public function simpanProyekDanNilai()
    {
        $proyekId = (int)$this->request->getPost('proyek_id');
        $nama     = trim((string)$this->request->getPost('nama'));
        $kode     = trim((string)$this->request->getPost('kode'));
        $jenis    = trim((string)$this->request->getPost('jenis'));
        $klien    = trim((string)$this->request->getPost('klien'));
        $lokasi   = trim((string)$this->request->getPost('lokasi'));
        $nilaiRab = (float)$this->request->getPost('nilai_rab');

        $tglMulai   = $this->request->getPost('tanggal_mulai') ?: date('Y-m-d');
        $tglRencana = $this->request->getPost('tanggal_selesai_rencana') ?: date('Y-m-d', strtotime('+3 months'));

        if (empty($nama)) {
            return redirect()->back()->withInput()->with('error', 'Nama proyek wajib diisi.');
        }

        if (empty($kode)) {
            $kode = 'PRJ-' . strtoupper(substr($jenis ?: 'GEN', 0, 3)) . '-' . sprintf('%02d', mt_rand(1, 99));
        }

        // 1. Save or Update Proyek
        $proyekData = [
            'nama'                    => $nama,
            'kode'                    => $kode,
            'jenis'                   => $jenis ?: 'rumah',
            'klien'                   => $klien ?: '-',
            'lokasi'                  => $lokasi ?: 'Bogor',
            'nilai_rab'               => $nilaiRab > 0 ? $nilaiRab : 100000000,
            'tanggal_mulai'           => $tglMulai,
            'tanggal_selesai_rencana' => $tglRencana,
        ];

        if ($proyekId > 0) {
            $this->proyekModel->update($proyekId, $proyekData);
        } else {
            $this->proyekModel->insert($proyekData);
            $proyekId = $this->proyekModel->getInsertID();
        }

        // 2. Active Periode
        $periodeId = (int)$this->request->getPost('periode_id');
        if ($periodeId <= 0) {
            $activePeriode = $this->getOrCreateActivePeriode();
            $periodeId     = $activePeriode['id'];
        }

        // 3. Raw Evaluation Values
        $progresRencana = 100.00;
        $progresAktual  = (float)$this->request->getPost('progres_aktual');
        $biayaRealisasi = (float)$this->request->getPost('biaya_realisasi');
        $skorFoto       = (int)$this->request->getPost('skor_foto_progres') ?: 5;
        $skorBast       = (int)$this->request->getPost('skor_bast') ?: 5;

        $isOnTime      = $this->request->getPost('is_on_time');
        $hariTerlambat = $this->request->getPost('hari_terlambat');
        $tglAktual     = $this->request->getPost('tanggal_selesai_aktual');

        if ($isOnTime === '1' || ($hariTerlambat !== null && $hariTerlambat !== '' && (int)$hariTerlambat === 0)) {
            $tglAktual = $tglRencana;
        } elseif ($hariTerlambat !== null && $hariTerlambat !== '' && (int)$hariTerlambat > 0) {
            $tglAktual = date('Y-m-d', strtotime($tglRencana . ' + ' . (int)$hariTerlambat . ' days'));
        } elseif (empty($tglAktual)) {
            $tglAktual = $tglRencana;
        }

        $penilaianData = [
            'periode_id'             => $periodeId,
            'proyek_id'              => $proyekId,
            'progres_rencana'        => $progresRencana,
            'progres_aktual'         => $progresAktual,
            'biaya_realisasi'        => $biayaRealisasi > 0 ? $biayaRealisasi : $nilaiRab,
            'skor_foto_progres'      => $skorFoto,
            'skor_bast'              => $skorBast,
            'tanggal_selesai_aktual' => $tglAktual,
        ];

        $existing = $this->penilaianModel
            ->where('periode_id', $periodeId)
            ->where('proyek_id', $proyekId)
            ->first();

        if ($existing) {
            $this->penilaianModel->update($existing['id'], $penilaianData);
        } else {
            $this->penilaianModel->insert($penilaianData);
        }

        // 4. Calculate SAW Rankings Immediately
        $this->executeSawCalculation($periodeId);

        return redirect()->to(site_url('dashboard/' . $periodeId))
            ->with('success', 'Data proyek "' . esc($nama) . '" dan nilai evaluasi berhasil disimpan! Peringkat telah otomatis diperbarui.');
    }

    public function hitungUlang(?int $periodeId = null)
    {
        if ($periodeId === null) {
            $activePeriode = $this->getOrCreateActivePeriode();
            $periodeId     = $activePeriode['id'];
        }

        $this->executeSawCalculation($periodeId);

        return redirect()->to(site_url('dashboard/' . $periodeId))
            ->with('success', 'Kalkulasi SAW berhasil diselesaikan! Peringkat kinerja proyek telah diperbarui.');
    }

    public function hapusProyek(int $proyekId)
    {
        $activePeriode = $this->getOrCreateActivePeriode();
        $periodeId     = $activePeriode['id'];

        $this->penilaianModel->where('periode_id', $periodeId)->where('proyek_id', $proyekId)->delete();
        $this->hasilSawModel->where('periode_id', $periodeId)->where('proyek_id', $proyekId)->delete();

        $this->executeSawCalculation($periodeId);

        return redirect()->to(site_url('dashboard/' . $periodeId))
            ->with('success', 'Proyek berhasil dihapus dari evaluasi dan peringkat telah diperbarui.');
    }

    public function pdf(?int $periodeId = null)
    {
        if ($periodeId === null) {
            $periode = $this->getOrCreateActivePeriode();
            $periodeId = $periode['id'];
        } else {
            $periode = $this->periodeModel->find($periodeId);
            if (! $periode) {
                return redirect()->to(site_url('dashboard'))->with('error', 'Sesi evaluasi tidak ditemukan.');
            }
        }

        $hasilList = $this->hasilSawModel->getHasilWithProyek($periodeId);
        if (empty($hasilList)) {
            return redirect()->to(site_url('dashboard/' . $periodeId))->with('error', 'Belum ada data proyek pada periode ini.');
        }

        $kriterias = $this->kriteriaModel->orderBy('kode', 'ASC')->findAll();
        $settings  = $this->pengaturanModel->getAllAsMap();

        $html = view('hasil/pdf', [
            'periode'        => $periode,
            'hasilList'      => $hasilList,
            'kriterias'      => $kriterias,
            'settings'       => $settings,
            'batasBaik'      => (float)($settings['batas_baik'] ?? 0.80),
            'batasPerhatian' => (float)($settings['batas_perhatian'] ?? 0.60),
            'printedBy'      => session()->get('user_nama') ?: 'Muhamad Firdaus',
            'printDate'      => date('d F Y H:i'),
        ]);

        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isRemoteEnabled', true);
        $options->set('defaultFont', 'Helvetica');

        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        $filename = 'Laporan_SPK_' . preg_replace('/[^A-Za-z0-9_-]/', '_', $periode['nama']) . '.pdf';
        $dompdf->stream($filename, ['Attachment' => false]);
        exit;
    }

    protected function executeSawCalculation(int $periodeId): array
    {
        $penilaians = $this->penilaianModel->getPenilaianWithProyek($periodeId);
        if (empty($penilaians)) {
            $this->hasilSawModel->where('periode_id', $periodeId)->delete();
            return [];
        }

        $kriterias = $this->kriteriaModel->findAll();
        $settings  = $this->pengaturanModel->getAllAsMap();

        $alternatives = [];
        foreach ($penilaians as $pen) {
            $rawValues = [
                'progres_rencana'         => $pen['progres_rencana'],
                'progres_aktual'          => $pen['progres_aktual'],
                'nilai_rab'               => $pen['nilai_rab'],
                'biaya_realisasi'         => $pen['biaya_realisasi'],
                'skor_foto_progres'       => (int)($pen['skor_foto_progres'] ?? 5),
                'skor_bast'               => $pen['skor_bast'],
                'tanggal_selesai_rencana' => $pen['tanggal_selesai_rencana'],
                'tanggal_selesai_aktual'  => $pen['tanggal_selesai_aktual'],
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
            return [];
        }

        $db = \Config\Database::connect();
        $db->transStart();

        $this->hasilSawModel->where('periode_id', $periodeId)->delete();

        foreach ($sawOutput['results'] as $altId => $item) {
            $this->hasilSawModel->insert([
                'periode_id'  => $periodeId,
                'proyek_id'   => $altId,
                'c1'          => $item['c1'],
                'c2'          => $item['c2'],
                'c3'          => $item['c3'],
                'c4'          => $item['c4'],
                'c5'          => $item['c5'],
                'vi'          => $item['vi'],
                'peringkat'   => $item['peringkat'],
                'kategori'    => $item['kategori'],
            ]);
        }

        $this->periodeModel->update($periodeId, ['status' => 'terhitung']);
        $db->transComplete();

        return $sawOutput;
    }

    protected function getOrCreateActivePeriode(): array
    {
        $periode = $this->periodeModel
            ->orderBy('id', 'DESC')
            ->first();

        if (! $periode) {
            $admin   = (new UserModel())->where('username', 'admin')->first();
            $adminId = $admin['id'] ?? 1;

            $this->periodeModel->insert([
                'nama'              => 'Evaluasi Kinerja Proyek ' . date('Y'),
                'tanggal_penilaian' => date('Y-m-d'),
                'status'            => 'draft',
                'created_by'        => $adminId,
            ]);
            $periodeId = $this->periodeModel->getInsertID();
            $periode   = $this->periodeModel->find($periodeId);
        }

        return $periode;
    }
}
