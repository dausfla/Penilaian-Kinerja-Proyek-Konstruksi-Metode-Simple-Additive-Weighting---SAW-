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

    public function login()
    {
        if (session()->get('is_logged_in')) {
            return redirect()->to(site_url('dashboard'));
        }
        return view('auth/login');
    }

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

    public function logout()
    {
        session()->destroy();
        return redirect()->to(site_url('login'))->with('success', 'Anda telah berhasil keluar.');
    }
}
