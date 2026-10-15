<?php

namespace App\Controllers;

use App\Models\UserModel;

class UserController extends BaseController
{
    protected UserModel $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    public function index()
    {
        $users = $this->userModel->orderBy('id', 'ASC')->findAll();

        return view('users/index', [
            'title'      => 'Manajemen Pengguna',
            'page_title' => 'Kelola Akun Pengguna & Hak Akses',
            'users'      => $users,
        ]);
    }

    public function create()
    {
        return view('users/form', [
            'title'      => 'Tambah Pengguna',
            'page_title' => 'Tambah Akun Pengguna Baru',
            'user'       => null,
        ]);
    }

    public function store()
    {
        $rules = [
            'nama'     => 'required|min_length[3]|max_length[100]',
            'username' => 'required|min_length[3]|max_length[50]|is_unique[users.username]',
            'password' => 'required|min_length[5]',
            'role'     => 'permit_empty|in_list[admin]',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->userModel->insert([
            'nama'          => trim((string)$this->request->getPost('nama')),
            'username'      => trim((string)$this->request->getPost('username')),
            'password_hash' => password_hash((string)$this->request->getPost('password'), PASSWORD_BCRYPT),
            'role'          => 'admin',
            'aktif'         => true,
        ]);

        return redirect()->to(site_url('users'))->with('success', 'Akun pengguna berhasil ditambahkan.');
    }

    public function edit(int $id)
    {
        $user = $this->userModel->find($id);
        if (! $user) {
            return redirect()->to(site_url('users'))->with('error', 'Pengguna tidak ditemukan.');
        }

        return view('users/form', [
            'title'      => 'Ubah Pengguna',
            'page_title' => 'Edit Pengguna: ' . esc($user['nama']),
            'user'       => $user,
        ]);
    }

    public function update(int $id)
    {
        $user = $this->userModel->find($id);
        if (! $user) {
            return redirect()->to(site_url('users'))->with('error', 'Pengguna tidak ditemukan.');
        }

        $rules = [
            'nama'     => 'required|min_length[3]|max_length[100]',
            'username' => "required|min_length[3]|max_length[50]|is_unique[users.username,id,{$id}]",
            'role'     => 'permit_empty|in_list[admin]',
        ];

        $newPassword = (string)$this->request->getPost('password');
        if (! empty($newPassword)) {
            $rules['password'] = 'min_length[5]';
        }

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $updateData = [
            'nama'     => trim((string)$this->request->getPost('nama')),
            'username' => trim((string)$this->request->getPost('username')),
            'role'     => 'admin',
        ];

        if (! empty($newPassword)) {
            $updateData['password_hash'] = password_hash($newPassword, PASSWORD_BCRYPT);
        }

        $this->userModel->update($id, $updateData);

        return redirect()->to(site_url('users'))->with('success', 'Data pengguna berhasil diperbarui.');
    }

    public function toggle(int $id)
    {
        $user = $this->userModel->find($id);
        if (! $user) {
            return redirect()->to(site_url('users'))->with('error', 'Pengguna tidak ditemukan.');
        }

        // Prevent deactivating own account
        if ($user['id'] == session()->get('user_id')) {
            return redirect()->to(site_url('users'))->with('error', 'Anda tidak dapat menonaktifkan akun Anda sendiri.');
        }

        $newStatus = ! $user['aktif'];
        $this->userModel->update($id, ['aktif' => $newStatus]);

        $statusMsg = $newStatus ? 'diaktifkan' : 'dinonaktifkan';
        return redirect()->to(site_url('users'))->with('success', "Akun pengguna {$user['nama']} berhasil {$statusMsg}.");
    }
}
