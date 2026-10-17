<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddC6AndC7ToSpk extends Migration
{
    public function up()
    {
        // 1. Add columns to penilaian table
        $this->db->query("
            ALTER TABLE penilaian 
            ADD COLUMN IF NOT EXISTS skor_kepuasan_klien INT NOT NULL DEFAULT 5 CHECK (skor_kepuasan_klien BETWEEN 1 AND 5),
            ADD COLUMN IF NOT EXISTS skor_k3 INT NOT NULL DEFAULT 5 CHECK (skor_k3 BETWEEN 1 AND 5)
        ");

        // 2. Add columns to hasil_saw table
        $this->db->query("
            ALTER TABLE hasil_saw 
            ADD COLUMN IF NOT EXISTS c6 NUMERIC(10, 4) NOT NULL DEFAULT 5.0000,
            ADD COLUMN IF NOT EXISTS c7 NUMERIC(10, 4) NOT NULL DEFAULT 5.0000
        ");

        // 3. Update existing criteria weights
        $this->db->table('kriteria')->where('kode', 'C1')->update(['bobot' => 0.2000]);
        $this->db->table('kriteria')->where('kode', 'C2')->update(['bobot' => 0.2000]);
        $this->db->table('kriteria')->where('kode', 'C3')->update(['bobot' => 0.1500]);
        $this->db->table('kriteria')->where('kode', 'C4')->update(['bobot' => 0.1500]);
        $this->db->table('kriteria')->where('kode', 'C5')->update(['bobot' => 0.1000]);

        // 4. Insert C6 if not exists
        $checkC6 = $this->db->table('kriteria')->where('kode', 'C6')->countAllResults();
        if ($checkC6 === 0) {
            $this->db->table('kriteria')->insert([
                'kode'    => 'C6',
                'nama'    => 'Tingkat Kepuasan Klien',
                'atribut' => 'benefit',
                'bobot'   => 0.1000,
            ]);
        } else {
            $this->db->table('kriteria')->where('kode', 'C6')->update([
                'nama'    => 'Tingkat Kepuasan Klien',
                'atribut' => 'benefit',
                'bobot'   => 0.1000,
            ]);
        }

        // 5. Insert C7 if not exists
        $checkC7 = $this->db->table('kriteria')->where('kode', 'C7')->countAllResults();
        if ($checkC7 === 0) {
            $this->db->table('kriteria')->insert([
                'kode'    => 'C7',
                'nama'    => 'Penerapan K3 & Keselamatan Kerja',
                'atribut' => 'benefit',
                'bobot'   => 0.1000,
            ]);
        } else {
            $this->db->table('kriteria')->where('kode', 'C7')->update([
                'nama'    => 'Penerapan K3 & Keselamatan Kerja',
                'atribut' => 'benefit',
                'bobot'   => 0.1000,
            ]);
        }
    }

    public function down()
    {
        // 1. Remove C6 & C7
        $this->db->table('kriteria')->whereIn('kode', ['C6', 'C7'])->delete();

        // 2. Restore 5 criteria weights
        $this->db->table('kriteria')->where('kode', 'C1')->update(['bobot' => 0.3000]);
        $this->db->table('kriteria')->where('kode', 'C2')->update(['bobot' => 0.2500]);
        $this->db->table('kriteria')->where('kode', 'C3')->update(['bobot' => 0.2000]);
        $this->db->table('kriteria')->where('kode', 'C4')->update(['bobot' => 0.1500]);
        $this->db->table('kriteria')->where('kode', 'C5')->update(['bobot' => 0.1000]);

        // 3. Drop columns
        $this->db->query("
            ALTER TABLE hasil_saw 
            DROP COLUMN IF EXISTS c6,
            DROP COLUMN IF EXISTS c7
        ");

        $this->db->query("
            ALTER TABLE penilaian 
            DROP COLUMN IF EXISTS skor_kepuasan_klien,
            DROP COLUMN IF EXISTS skor_k3
        ");
    }
}
