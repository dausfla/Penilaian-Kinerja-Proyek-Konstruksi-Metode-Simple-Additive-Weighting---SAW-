<?php

namespace App\Controllers;

use App\Models\UserModel;

class AuthController extends BaseController
{
    protected UserModel $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    /**
     * Tampilan Halaman Login (PIN Keypad & Password Alternatif)
     */
    public function login()
    {
        if (session()->get('is_logged_in')) {
            return redirect()->to(site_url('dashboard'));
        }

        $this->response->setHeader('Cache-Control', 'no-store, no-cache, must-revalidate, max-age=0, post-check=0, pre-check=0');
        $this->response->setHeader('Pragma', 'no-cache');
        $this->response->setHeader('Expires', 'Sat, 01 Jan 2000 00:00:00 GMT');

        return view('auth/login');
    }

    /**
     * Proses Login Menggunakan 6-Digit PIN Passkey
     */
    public function processPin()
    {
        $pin = trim((string)$this->request->getPost('pin'));

        if (strlen($pin) !== 6 || ! ctype_digit($pin)) {
            return redirect()->back()->with('error', 'PIN harus berupa 6 digit angka.');
        }

        // Cari pengguna aktif yang PIN-nya cocok
        $users = $this->userModel->where('aktif', true)->findAll();
        $authenticatedUser = null;

        foreach ($users as $user) {
            if (! empty($user['pin_hash']) && password_verify($pin, $user['pin_hash'])) {
                $authenticatedUser = $user;
                break;
            }
        }

        if (! $authenticatedUser) {
            return redirect()->back()->with('error', 'Kode PIN yang Anda masukkan tidak sesuai. Silakan coba lagi atau pilih "Lupa PIN".');
        }

        // Set session login
        session()->set([
            'is_logged_in'  => true,
            'user_id'       => $authenticatedUser['id'],
            'user_nama'     => $authenticatedUser['nama'],
            'user_username' => $authenticatedUser['username'],
            'user_role'     => $authenticatedUser['role'],
        ]);

        return redirect()->to(site_url('dashboard'))->with('success', 'Akses PIN berhasil diverifikasi! Selamat datang kembali, ' . esc($authenticatedUser['nama']) . '.');
    }

    /**
     * Proses Login Menggunakan Username & Password (Metode Alternatif/Cadangan)
     */
    public function process()
    {
        $rules = [
            'username' => 'required|min_length[3]|max_length[50]',
            'password' => 'required|min_length[4]',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $username = trim((string)$this->request->getPost('username'));
        $password = (string)$this->request->getPost('password');

        $user = $this->userModel->where('username', $username)->first();

        if (! $user || ! password_verify($password, $user['password_hash'])) {
            return redirect()->back()->withInput()->with('error', 'Username atau password tidak sesuai.');
        }

        if (! $user['aktif']) {
            return redirect()->back()->withInput()->with('error', 'Akun Anda dinonaktifkan. Silakan hubungi Administrator.');
        }

        // Set session
        session()->set([
            'is_logged_in'  => true,
            'user_id'       => $user['id'],
            'user_nama'     => $user['nama'],
            'user_username' => $user['username'],
            'user_role'     => $user['role'],
        ]);

        return redirect()->to(site_url('dashboard'))->with('success', 'Selamat datang kembali, ' . esc($user['nama']) . '!');
    }

    /**
     * Halaman Input Email Lupa PIN
     */
    public function forgotPin()
    {
        if (session()->get('is_logged_in')) {
            return redirect()->to(site_url('dashboard'));
        }

        // Ambil default email untuk mempermudah saat demo / presentasi
        $defaultUser = $this->userModel->where('aktif', true)->orderBy('id', 'ASC')->first();
        $defaultEmail = $defaultUser['email'] ?? 'admin@rancangbangunsedaya.com';

        return view('auth/forgot_pin', [
            'defaultEmail' => $defaultEmail,
        ]);
    }

    /**
     * Kirim Kode OTP ke Email
     */
    public function sendOtp()
    {
        $email = trim((string)$this->request->getPost('email'));

        if (empty($email) || ! filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return redirect()->back()->withInput()->with('error', 'Silakan masukkan alamat email yang valid.');
        }

        $user = $this->userModel->where('email', $email)->where('aktif', true)->first();

        if (! $user) {
            return redirect()->back()->withInput()->with('error', 'Alamat email tidak terdaftar dalam sistem PT Rancang Bangun Sedaya.');
        }

        // Generate 6-digit OTP
        $otp = (string)random_int(100000, 999999);
        $expiresAt = date('Y-m-d H:i:s', time() + 300); // 5 menit kedepan

        // Update database
        $this->userModel->update($user['id'], [
            'otp_code'       => $otp,
            'otp_expires_at' => $expiresAt,
        ]);

        // Simpan sesi reset
        session()->set([
            'reset_user_id' => $user['id'],
            'reset_email'   => $user['email'],
        ]);

        // Kirim email via Gmail SMTP
        $emailConfig = config('Email');
        $emailService = \Config\Services::email();
        $emailService->setFrom($emailConfig->fromEmail, $emailConfig->fromName);
        $emailService->setTo($user['email']);
        $emailService->setSubject('Kode OTP Reset PIN - SPK PT Rancang Bangun Sedaya');

        $htmlMessage = view('auth/email_otp', [
            'user'      => $user,
            'otp'       => $otp,
            'expiresAt' => $expiresAt,
        ]);
        $emailService->setMessage($htmlMessage);

        $sent = false;
        try {
            $sent = $emailService->send(false);
        } catch (\Throwable $e) {
            log_message('error', 'Pengiriman SMTP OTP Gagal: ' . $e->getMessage());
        }

        if (! $sent) {
            return redirect()->back()->withInput()->with('error', 'Gagal mengirim email OTP ke ' . esc($user['email']) . '. Silakan periksa koneksi internet server atau hubungi Administrator.');
        }

        return redirect()->to(site_url('verifikasi-otp'))->with('success', 'Kode OTP 6-digit telah berhasil dikirimkan ke kotak masuk Gmail ' . esc($user['email']) . '. Silakan periksa pesan masuk atau folder spam Anda.');
    }

    /**
     * Halaman Input Verifikasi OTP
     */
    public function verifyOtpPage()
    {
        $userId = session()->get('reset_user_id');
        if (! $userId) {
            return redirect()->to(site_url('lupa-pin'))->with('error', 'Sesi verifikasi telah berakhir. Silakan masukkan email kembali.');
        }

        $user = $this->userModel->find($userId);
        if (! $user) {
            return redirect()->to(site_url('lupa-pin'))->with('error', 'Pengguna tidak ditemukan.');
        }

        return view('auth/verify_otp', [
            'user'       => $user,
            'email'      => session()->get('reset_email'),
            'expiresAt'  => $user['otp_expires_at'],
        ]);
    }

    /**
     * Proses Validasi Kode OTP
     */
    public function processVerifyOtp()
    {
        $userId = session()->get('reset_user_id');
        if (! $userId) {
            return redirect()->to(site_url('lupa-pin'))->with('error', 'Sesi telah habis. Silakan ulangi proses.');
        }

        $user = $this->userModel->find($userId);
        if (! $user) {
            return redirect()->to(site_url('lupa-pin'))->with('error', 'Pengguna tidak valid.');
        }

        $inputOtp = trim((string)$this->request->getPost('otp'));

        if (empty($inputOtp) || strlen($inputOtp) !== 6 || ! ctype_digit($inputOtp)) {
            return redirect()->back()->with('error', 'Masukkan 6 digit kode OTP angka secara lengkap.');
        }

        if (empty($user['otp_code'])) {
            return redirect()->to(site_url('lupa-pin'))->with('error', 'Tidak ada permintaan OTP aktif. Silakan kirim ulang kode.');
        }

        if (strtotime($user['otp_expires_at']) < time()) {
            return redirect()->to(site_url('lupa-pin'))->with('error', 'Kode OTP telah kadaluarsa (melewati batas 5 menit). Silakan minta kode baru.');
        }

        if ($user['otp_code'] !== $inputOtp) {
            return redirect()->back()->with('error', 'Kode OTP yang Anda masukkan salah. Silakan periksa kembali email Anda.');
        }

        // OTP Valid! Tandai verifikasi berhasil di sesi
        session()->set('otp_verified', true);

        return redirect()->to(site_url('buat-pin-baru'))->with('success', 'Kode OTP berhasil diverifikasi! Silakan buat 6 digit PIN baru.');
    }

    /**
     * Halaman Buat PIN Baru
     */
    public function resetPinPage()
    {
        $userId = session()->get('reset_user_id');
        $isVerified = session()->get('otp_verified');

        if (! $userId || ! $isVerified) {
            return redirect()->to(site_url('lupa-pin'))->with('error', 'Akses ditolak. Anda harus memverifikasi kode OTP terlebih dahulu.');
        }

        return view('auth/reset_pin');
    }

    /**
     * Simpan PIN Baru ke Database
     */
    public function processResetPin()
    {
        $userId = session()->get('reset_user_id');
        $isVerified = session()->get('otp_verified');

        if (! $userId || ! $isVerified) {
            return redirect()->to(site_url('lupa-pin'))->with('error', 'Sesi tidak valid.');
        }

        $pin = trim((string)$this->request->getPost('pin'));
        $pinConfirm = trim((string)$this->request->getPost('pin_confirmation'));

        if (strlen($pin) !== 6 || ! ctype_digit($pin)) {
            return redirect()->back()->with('error', 'PIN harus tepat 6 digit angka.');
        }

        if ($pin !== $pinConfirm) {
            return redirect()->back()->with('error', 'Konfirmasi PIN tidak cocok dengan PIN baru.');
        }

        // Update PIN hash dan bersihkan data OTP
        $this->userModel->update($userId, [
            'pin_hash'       => password_hash($pin, PASSWORD_BCRYPT),
            'otp_code'       => null,
            'otp_expires_at' => null,
        ]);

        // Bersihkan sesi pemulihan
        session()->remove(['reset_user_id', 'reset_email', 'otp_verified']);

        return redirect()->to(site_url('login'))->with('success', 'PIN baru berhasil diperbarui! Silakan masuk menggunakan PIN 6-digit Anda yang baru.');
    }

    /**
     * Keluar dari Sistem
     */
    public function logout()
    {
        session()->destroy();
        $this->response->setHeader('Cache-Control', 'no-store, no-cache, must-revalidate, max-age=0, post-check=0, pre-check=0');
        $this->response->setHeader('Pragma', 'no-cache');
        $this->response->setHeader('Expires', 'Sat, 01 Jan 2000 00:00:00 GMT');

        return redirect()->to(site_url('login'))->with('success', 'Anda telah berhasil keluar dari sistem.');
    }
}
