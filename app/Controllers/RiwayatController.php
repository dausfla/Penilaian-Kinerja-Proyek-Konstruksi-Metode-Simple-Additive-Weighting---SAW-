<?php

namespace App\Controllers;

use App\Models\HasilSawModel;
use App\Models\PeriodePenilaianModel;
use App\Models\ProyekModel;

class RiwayatController extends BaseController
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
        $proyeks = $this->proyekModel->orderBy('nama', 'ASC')->findAll();
        $selectedProyekId = (int)$this->request->getGet('proyek_id');

        $selectedProyek = null;
        $riwayatList = [];

        if ($selectedProyekId > 0) {
            $selectedProyek = $this->proyekModel->find($selectedProyekId);

            if ($selectedProyek) {
                // Fetch all hasil_saw entries for this project ordered by period date ascending
                $riwayatList = $this->hasilSawModel
                    ->select('hasil_saw.*, periode_penilaian.nama as periode_nama, periode_penilaian.tanggal_penilaian')
                    ->join('periode_penilaian', 'periode_penilaian.id = hasil_saw.periode_id')
                    ->where('hasil_saw.proyek_id', $selectedProyekId)
                    ->orderBy('periode_penilaian.tanggal_penilaian', 'ASC')
                    ->findAll();
            }
        } elseif (!empty($proyeks)) {
            // Default select first project
            $selectedProyekId = $proyeks[0]['id'];
            $selectedProyek = $proyeks[0];

            $riwayatList = $this->hasilSawModel
                ->select('hasil_saw.*, periode_penilaian.nama as periode_nama, periode_penilaian.tanggal_penilaian')
                ->join('periode_penilaian', 'periode_penilaian.id = hasil_saw.periode_id')
                ->where('hasil_saw.proyek_id', $selectedProyekId)
                ->orderBy('periode_penilaian.tanggal_penilaian', 'ASC')
                ->findAll();
        }

        return view('riwayat/index', [
            'title'            => 'Riwayat Evaluasi Proyek',
            'page_title'       => 'Riwayat Komparasi Kinerja Proyek',
            'proyeks'          => $proyeks,
            'selectedProyekId' => $selectedProyekId,
            'selectedProyek'   => $selectedProyek,
            'riwayatList'      => $riwayatList,
        ]);
    }
}
