<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class UpdateAdminNameAndAddress extends Migration
{
    public function up()
    {
        $this->db->table('users')->where('username', 'admin')->update(['nama' => 'Muhamad Firdaus']);

        $existing = $this->db->table('pengaturan')->where('kunci', 'alamat_perusahaan')->get()->getRowArray();
        if (! $existing) {
            $this->db->table('pengaturan')->insert([
                'kunci' => 'alamat_perusahaan',
                'nilai' => '(Head Quarter): Pasirmulya, Kecamatan Bogor Barat, Kota Bogor, Jawa Barat 16118',
            ]);
        } else {
            $this->db->table('pengaturan')->where('kunci', 'alamat_perusahaan')->update([
                'nilai' => '(Head Quarter): Pasirmulya, Kecamatan Bogor Barat, Kota Bogor, Jawa Barat 16118',
            ]);
        }
    }

    public function down()
    {
        $this->db->table('users')->where('username', 'admin')->update(['nama' => 'Administrator SPK']);
    }
}
