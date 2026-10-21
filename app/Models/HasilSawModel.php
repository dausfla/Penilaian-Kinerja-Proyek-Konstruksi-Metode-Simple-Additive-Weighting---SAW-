<?php

namespace App\Models;

use CodeIgniter\Model;

class HasilSawModel extends Model
{
    protected $table            = 'hasil_saw';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = [
        'periode_id',
        'proyek_id',
        'c1',
        'c2',
        'c3',
        'c4',
        'c5',
        'c6',
        'c7',
        'vi',
        'peringkat',
        'kategori',
    ];
    protected $useTimestamps    = false;

    public function getHasilWithProyek(int $periodeId): array
    {
        return $this->select('hasil_saw.*, 
            proyek.kode as proyek_kode, 
            proyek.nama as proyek_nama, 
            proyek.jenis, 
            proyek.klien, 
            proyek.lokasi, 
            proyek.nilai_rab, 
            proyek.tanggal_mulai, 
            proyek.tanggal_selesai_rencana,
            penilaian.biaya_realisasi,
            penilaian.progres_rencana,
            penilaian.progres_aktual,
            penilaian.skor_foto_progres,
            penilaian.skor_bast,
            penilaian.tanggal_selesai_aktual,
            penilaian.skor_kepuasan_klien,
            penilaian.skor_k3')
            ->join('proyek', 'proyek.id = hasil_saw.proyek_id')
            ->join('penilaian', 'penilaian.proyek_id = hasil_saw.proyek_id AND penilaian.periode_id = hasil_saw.periode_id', 'left')
            ->where('hasil_saw.periode_id', $periodeId)
            ->orderBy('hasil_saw.peringkat', 'ASC')
            ->findAll();
    }
}
