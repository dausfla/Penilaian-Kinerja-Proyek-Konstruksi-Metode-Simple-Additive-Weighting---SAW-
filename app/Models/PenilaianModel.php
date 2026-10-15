<?php

namespace App\Models;

use CodeIgniter\Model;

class PenilaianModel extends Model
{
    protected $table            = 'penilaian';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = [
        'periode_id',
        'proyek_id',
        'progres_rencana',
        'progres_aktual',
        'biaya_realisasi',
        'skor_foto_progres',
        'skor_bast',
        'tanggal_selesai_aktual',
    ];
    protected $useTimestamps    = false;

    public function getPenilaianWithProyek(int $periodeId): array
    {
        return $this->select('penilaian.*, proyek.kode as proyek_kode, proyek.nama as proyek_nama, proyek.jenis, proyek.klien, proyek.lokasi, proyek.tanggal_mulai, proyek.tanggal_selesai_rencana, proyek.nilai_rab')
            ->join('proyek', 'proyek.id = penilaian.proyek_id')
            ->where('penilaian.periode_id', $periodeId)
            ->orderBy('proyek.kode', 'ASC')
            ->findAll();
    }
}
