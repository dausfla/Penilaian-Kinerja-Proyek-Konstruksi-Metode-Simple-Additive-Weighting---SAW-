<?php

namespace App\Models;

use CodeIgniter\Model;

class ProyekModel extends Model
{
    protected $table            = 'proyek';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = [
        'kode',
        'nama',
        'jenis',
        'klien',
        'lokasi',
        'tanggal_mulai',
        'tanggal_selesai_rencana',
        'nilai_rab',
    ];
    protected $useTimestamps    = false;
}
