<?php

namespace App\Controllers;

use App\Models\HasilSawModel;
use App\Models\KriteriaModel;
use App\Models\PengaturanModel;
use App\Models\PeriodePenilaianModel;
use Dompdf\Dompdf;
use Dompdf\Options;

class HasilController extends BaseController
{
    protected PeriodePenilaianModel $periodeModel;
    protected HasilSawModel $hasilSawModel;
    protected KriteriaModel $kriteriaModel;
    protected PengaturanModel $pengaturanModel;

    public function __construct()
    {
        $this->periodeModel    = new PeriodePenilaianModel();
        $this->hasilSawModel   = new HasilSawModel();
        $this->kriteriaModel   = new KriteriaModel();
        $this->pengaturanModel = new PengaturanModel();
    }

    public function index(?int $periodeId = null)
    {
        $allPeriodes = $this->periodeModel->orderBy('tanggal_penilaian', 'DESC')->findAll();

        if (empty($allPeriodes)) {
            return view('hasil/empty', [
                'title'      => 'Hasil Perangkingan SAW',
                'page_title' => 'Hasil Penilaian Kinerja Proyek',
                'message'    => 'Belum ada periode penilaian yang dibuat.',
            ]);
        }

        // Determine active period
        if ($periodeId === null) {
            // Find latest calculated period, or fallback to first
            $activePeriode = null;
            foreach ($allPeriodes as $p) {
                if ($p['status'] === 'terhitung') {
                    $activePeriode = $p;
                    break;
                }
            }
            if (! $activePeriode) {
                $activePeriode = $allPeriodes[0];
            }
        } else {
            $activePeriode = $this->periodeModel->find($periodeId);
            if (! $activePeriode) {
                return redirect()->to(site_url('hasil'))->with('error', 'Periode penilaian tidak ditemukan.');
            }
        }

        // Check if this period has results
        $hasilList = $this->hasilSawModel->getHasilWithProyek($activePeriode['id']);
        $kriterias = $this->kriteriaModel->orderBy('kode', 'ASC')->findAll();
        $settings  = $this->pengaturanModel->getAllAsMap();

        // Decode details
        $matrixR = [];
        $matrixW = [];
        $kategoriCount = ['Baik' => 0, 'Perlu Perhatian' => 0, 'Berisiko/Terlambat' => 0];

        foreach ($hasilList as &$h) {
            $details = json_decode($h['detail_json'] ?? '{}', true);
            $h['matrix_r'] = $details['matrix_r'] ?? [];
            $h['matrix_w'] = $details['matrix_w'] ?? [];

            $kat = $h['kategori'];
            if (isset($kategoriCount[$kat])) {
                $kategoriCount[$kat]++;
            }
        }
        unset($h);

        return view('hasil/index', [
            'title'          => 'Hasil Perangkingan SAW',
            'page_title'     => 'Hasil & Perangkingan Kinerja Proyek',
            'allPeriodes'    => $allPeriodes,
            'activePeriode'  => $activePeriode,
            'hasilList'      => $hasilList,
            'kriterias'      => $kriterias,
            'kategoriCount'  => $kategoriCount,
            'batasBaik'      => (float)($settings['batas_baik'] ?? 0.80),
            'batasPerhatian' => (float)($settings['batas_perhatian'] ?? 0.60),
        ]);
    }

    public function pdf(int $periodeId)
    {
        $periode = $this->periodeModel->find($periodeId);
        if (! $periode) {
            return redirect()->to(site_url('hasil'))->with('error', 'Periode tidak ditemukan.');
        }

        $hasilList = $this->hasilSawModel->getHasilWithProyek($periodeId);
        if (empty($hasilList)) {
            return redirect()->to(site_url('hasil/' . $periodeId))->with('error', 'Periode ini belum memiliki hasil perhitungan SAW.');
        }

        $kriterias = $this->kriteriaModel->orderBy('kode', 'ASC')->findAll();
        $settings  = $this->pengaturanModel->getAllAsMap();

        // Prepare HTML for Dompdf
        $html = view('hasil/pdf', [
            'periode'        => $periode,
            'hasilList'      => $hasilList,
            'kriterias'      => $kriterias,
            'settings'       => $settings,
            'batasBaik'      => (float)($settings['batas_baik'] ?? 0.80),
            'batasPerhatian' => (float)($settings['batas_perhatian'] ?? 0.60),
            'printedBy'      => session()->get('user_nama') ?? 'Administrator',
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
}
