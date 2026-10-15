<?php

namespace App\Models;

use CodeIgniter\Model;

class PengaturanModel extends Model
{
    protected $table            = 'pengaturan';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = ['kunci', 'nilai'];
    protected $useTimestamps    = false;

    public function getSetting(string $key, $default = null)
    {
        $row = $this->where('kunci', $key)->first();
        return $row ? $row['nilai'] : $default;
    }

    public function setSetting(string $key, string $value): void
    {
        $existing = $this->where('kunci', $key)->first();
        if ($existing) {
            $this->update($existing['id'], ['nilai' => $value]);
        } else {
            $this->insert(['kunci' => $key, 'nilai' => $value]);
        }
    }

    public function getAllAsMap(): array
    {
        $rows = $this->findAll();
        $map = [];
        foreach ($rows as $r) {
            $map[$r['kunci']] = $r['nilai'];
        }
        return $map;
    }
}
