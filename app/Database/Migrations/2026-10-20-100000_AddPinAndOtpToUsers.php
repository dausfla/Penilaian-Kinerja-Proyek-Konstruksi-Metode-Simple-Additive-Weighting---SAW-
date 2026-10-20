<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddPinAndOtpToUsers extends Migration
{
    public function up()
    {
        $this->db->query("
            ALTER TABLE users 
            ADD COLUMN IF NOT EXISTS email VARCHAR(150) DEFAULT 'admin@rancangbangunsedaya.com',
            ADD COLUMN IF NOT EXISTS pin_hash VARCHAR(255) NULL,
            ADD COLUMN IF NOT EXISTS otp_code VARCHAR(10) NULL,
            ADD COLUMN IF NOT EXISTS otp_expires_at TIMESTAMP WITH TIME ZONE NULL
        ");

        // Set default PIN '080905' for existing users
        $defaultPinHash = password_hash('080905', PASSWORD_BCRYPT);
        $this->db->table('users')
            ->where('pin_hash IS NULL', null, false)
            ->update([
                'pin_hash' => $defaultPinHash,
                'email'    => 'admin@rancangbangunsedaya.com'
            ]);
    }

    public function down()
    {
        $this->db->query("
            ALTER TABLE users 
            DROP COLUMN IF EXISTS email,
            DROP COLUMN IF EXISTS pin_hash,
            DROP COLUMN IF EXISTS otp_code,
            DROP COLUMN IF EXISTS otp_expires_at
        ");
    }
}
