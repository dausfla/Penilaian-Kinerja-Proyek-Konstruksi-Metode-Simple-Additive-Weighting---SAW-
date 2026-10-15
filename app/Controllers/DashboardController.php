<?php

namespace App\Controllers;

use App\Models\HasilSawModel;
use App\Models\PeriodePenilaianModel;
use App\Models\ProyekModel;

class DashboardController extends BaseController
{
    protected ProyekModel $proyekModel;
    protected PeriodePenilaianModel $periodeModel;
    protected HasilSawModel $hasilSawModel;

    public function __construct()
    {
        $this->proyekModel   = new ProyekModel();
        $this->periodeModel  = new PeriodePenilaianModel();
        $this->hasilSawModel = new HasilSawModel();
    }

    public function index()
    {
        $totalProyek = $this->proyekModel->countAllResults();
        $totalPeriode = $this->periodeModel->countAllResults();

        // Find latest calculated period
        $latestCalculatedPeriode = $this->periodeModel
            ->where('status', 'terhitung')
            ->orderBy('tanggal_penilaian', 'DESC')
            ->first();

        $hasilTerbaru = [];
        $tigaTerbawah = [];
        $kategoriCount = ['Baik' => 0, 'Perlu Perhatian' => 0, 'Berisiko/Terlambat' => 0];

        if ($latestCalculatedPeriode) {
            $hasilTerbaru = $this->hasilSawModel->getHasilWithProyek($latestCalculatedPeriode['id']);

            foreach ($hasilTerbaru as $h) {
                $kat = $h['kategori'];
                if (isset($kategoriCount[$kat])) {
                    $kategoriCount[$kat]++;
                }
            }

            // Bottom 3 projects (last 3 in ranking order)
            if (count($hasilTerbaru) >= 3) {
                $tigaTerbawah = array_slice($hasilTerbaru, -3);
            } else {
                $tigaTerbawah = $hasilTerbaru;
            }
            // Reverse so lowest rank is at top or keep as list
            usort($tigaTerbawah, function ($a, $b) {
                return $b['peringkat'] <=> $a['peringkat'];
            });
        }

        return view('dashboard/index', [
            'title'          => 'Dashboard SPK Proyek',
            'page_title'     => 'Dashboard Kinerja Proyek',
            'totalProyek'    => $totalProyek,
            'totalPeriode'   => $totalPeriode,
            'latestPeriode'  => $latestCalculatedPeriode,
            'hasilTerbaru'   => $hasilTerbaru,
            'tigaTerbawah'   => $tigaTerbawah,
            'kategoriCount'  => $kategoriCount,
        ]);
    }
}
