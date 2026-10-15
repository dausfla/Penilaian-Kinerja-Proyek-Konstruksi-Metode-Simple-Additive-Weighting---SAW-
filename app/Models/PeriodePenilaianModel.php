<?php

namespace App\Models;

use CodeIgniter\Model;

class PeriodePenilaianModel extends Model
{
    protected $table            = 'periode_penilaian';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = ['nama', 'tanggal_penilaian', 'status', 'created_by'];
    protected $useTimestamps    = false;
}
