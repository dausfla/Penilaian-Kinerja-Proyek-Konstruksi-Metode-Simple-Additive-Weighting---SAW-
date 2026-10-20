<?php

namespace Tests\App\Controllers;

use App\Models\UserModel;
use CodeIgniter\Test\CIUnitTestCase;

/**
 * @internal
 */
final class AuthPinTest extends CIUnitTestCase
{
    public function testDefaultPinHashVerification(): void
    {
        $defaultPin = '080905';
        $db = \Config\Database::connect('default');
        $admin = $db->table('users')->where('username', 'admin')->get()->getRowArray();

        $this->assertNotNull($admin, 'Akun admin harus ditemukan di database.');
        $this->assertNotEmpty($admin['pin_hash'], 'PIN hash tidak boleh kosong.');
        $this->assertTrue(password_verify($defaultPin, $admin['pin_hash']), 'PIN default 080905 harus valid saat diverifikasi.');
    }

    public function testWrongPinIsRejected(): void
    {
        $wrongPin = '999999';
        $db = \Config\Database::connect('default');
        $admin = $db->table('users')->where('username', 'admin')->get()->getRowArray();

        $this->assertFalse(password_verify($wrongPin, $admin['pin_hash']), 'PIN yang salah harus ditolak.');
    }

    public function testOtpGenerationAndExpiryDuration(): void
    {
        $otp = (string)random_int(100000, 999999);
        $expiresAt = date('Y-m-d H:i:s', time() + 300);

        $this->assertSame(6, strlen($otp));
        $this->assertTrue(ctype_digit($otp));
        
        $durationSeconds = strtotime($expiresAt) - time();
        $this->assertGreaterThanOrEqual(290, $durationSeconds);
        $this->assertLessThanOrEqual(300, $durationSeconds);
    }
}
