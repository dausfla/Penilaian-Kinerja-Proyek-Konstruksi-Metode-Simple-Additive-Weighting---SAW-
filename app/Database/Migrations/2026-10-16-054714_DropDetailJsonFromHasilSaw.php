<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class DropDetailJsonFromHasilSaw extends Migration
{
    public function up()
    {
        if ($this->db->fieldExists('detail_json', 'hasil_saw')) {
            $this->forge->dropColumn('hasil_saw', 'detail_json');
        }
    }

    public function down()
    {
        if (! $this->db->fieldExists('detail_json', 'hasil_saw')) {
            $this->forge->addColumn('hasil_saw', [
                'detail_json' => [
                    'type' => 'TEXT',
                    'null' => true,
                ],
            ]);
        }
    }
}
