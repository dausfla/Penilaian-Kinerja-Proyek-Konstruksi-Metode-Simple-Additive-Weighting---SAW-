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
        'vi',
        'peringkat',
        'kategori',
        'detail_json',
    ];
    protected $useTimestamps    = false;

    public function getHasilWithProyek(int $periodeId): array
    {
        return $this->select('hasil_saw.*, proyek.kode as proyek_kode, proyek.nama as proyek_nama, proyek.jenis, proyek.klien, proyek.lokasi, proyek.nilai_rab, proyek.tanggal_selesai_rencana')
            ->join('proyek', 'proyek.id = hasil_saw.proyek_id')
            ->where('hasil_saw.periode_id', $periodeId)
            ->orderBy('hasil_saw.peringkat', 'ASC')
            ->findAll();
    }
}
