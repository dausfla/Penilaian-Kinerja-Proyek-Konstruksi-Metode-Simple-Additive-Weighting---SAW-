<?php

namespace App\Controllers;

use App\Models\ProyekModel;

class ProyekController extends BaseController
{
    protected ProyekModel $proyekModel;

    public function __construct()
    {
        $this->proyekModel = new ProyekModel();
    }

    public function index()
    {
        $keyword = trim((string)$this->request->getGet('search'));
        $jenis   = trim((string)$this->request->getGet('jenis'));

        $builder = $this->proyekModel;

        if (! empty($keyword)) {
            $builder = $builder->groupStart()
                ->like('kode', $keyword, 'both', null, true)
                ->orLike('nama', $keyword, 'both', null, true)
                ->orLike('klien', $keyword, 'both', null, true)
                ->orLike('lokasi', $keyword, 'both', null, true)
                ->groupEnd();
        }

        if (! empty($jenis)) {
            $builder = $builder->where('jenis', $jenis);
        }

        $proyeks = $builder->orderBy('id', 'DESC')->findAll();

        return view('proyek/index', [
            'title'      => 'Data Proyek',
            'page_title' => 'Kelola Data Proyek',
            'proyeks'    => $proyeks,
            'search'     => $keyword,
            'jenis'      => $jenis,
            'jenisList'  => ['rumah', 'gedung', 'kantor', 'kost', 'apartemen', 'interior', 'landscape', 'renovasi'],
        ]);
    }

    public function create()
    {
        return view('proyek/form', [
            'title'      => 'Tambah Proyek Baru',
            'page_title' => 'Tambah Proyek Konstruksi',
            'proyek'     => null,
            'jenisList'  => ['rumah', 'gedung', 'kantor', 'kost', 'apartemen', 'interior', 'landscape', 'renovasi'],
        ]);
    }

    public function store()
    {
        $rules = [
            'kode'                    => 'required|min_length[3]|max_length[50]|is_unique[proyek.kode]',
            'nama'                    => 'required|min_length[3]|max_length[150]',
            'jenis'                   => 'required|in_list[rumah,gedung,kantor,kost,apartemen,interior,landscape,renovasi]',
            'klien'                   => 'required|min_length[2]|max_length[150]',
            'lokasi'                  => 'required|min_length[2]|max_length[255]',
            'tanggal_mulai'           => 'required|valid_date[Y-m-d]',
            'tanggal_selesai_rencana' => 'required|valid_date[Y-m-d]',
            'nilai_rab'               => 'required|numeric|greater_than[0]',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->proyekModel->insert([
            'kode'                    => strtoupper(trim((string)$this->request->getPost('kode'))),
            'nama'                    => trim((string)$this->request->getPost('nama')),
            'jenis'                   => trim((string)$this->request->getPost('jenis')),
            'klien'                   => trim((string)$this->request->getPost('klien')),
            'lokasi'                  => trim((string)$this->request->getPost('lokasi')),
            'tanggal_mulai'           => $this->request->getPost('tanggal_mulai'),
            'tanggal_selesai_rencana' => $this->request->getPost('tanggal_selesai_rencana'),
            'nilai_rab'               => (float)$this->request->getPost('nilai_rab'),
        ]);

        return redirect()->to(site_url('proyek'))->with('success', 'Data proyek berhasil ditambahkan.');
    }

    public function edit(int $id)
    {
        $proyek = $this->proyekModel->find($id);
        if (! $proyek) {
            return redirect()->to(site_url('proyek'))->with('error', 'Data proyek tidak ditemukan.');
        }

        return view('proyek/form', [
            'title'      => 'Ubah Data Proyek',
            'page_title' => 'Edit Proyek: ' . esc($proyek['nama']),
            'proyek'     => $proyek,
            'jenisList'  => ['rumah', 'gedung', 'kantor', 'kost', 'apartemen', 'interior', 'landscape', 'renovasi'],
        ]);
    }

    public function update(int $id)
    {
        $proyek = $this->proyekModel->find($id);
        if (! $proyek) {
            return redirect()->to(site_url('proyek'))->with('error', 'Data proyek tidak ditemukan.');
        }

        $rules = [
            'kode'                    => "required|min_length[3]|max_length[50]|is_unique[proyek.kode,id,{$id}]",
            'nama'                    => 'required|min_length[3]|max_length[150]',
            'jenis'                   => 'required|in_list[rumah,gedung,kantor,kost,apartemen,interior,landscape,renovasi]',
            'klien'                   => 'required|min_length[2]|max_length[150]',
            'lokasi'                  => 'required|min_length[2]|max_length[255]',
            'tanggal_mulai'           => 'required|valid_date[Y-m-d]',
            'tanggal_selesai_rencana' => 'required|valid_date[Y-m-d]',
            'nilai_rab'               => 'required|numeric|greater_than[0]',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->proyekModel->update($id, [
            'kode'                    => strtoupper(trim((string)$this->request->getPost('kode'))),
            'nama'                    => trim((string)$this->request->getPost('nama')),
            'jenis'                   => trim((string)$this->request->getPost('jenis')),
            'klien'                   => trim((string)$this->request->getPost('klien')),
            'lokasi'                  => trim((string)$this->request->getPost('lokasi')),
            'tanggal_mulai'           => $this->request->getPost('tanggal_mulai'),
            'tanggal_selesai_rencana' => $this->request->getPost('tanggal_selesai_rencana'),
            'nilai_rab'               => (float)$this->request->getPost('nilai_rab'),
        ]);

        return redirect()->to(site_url('proyek'))->with('success', 'Data proyek berhasil diperbarui.');
    }

    public function delete(int $id)
    {
        $proyek = $this->proyekModel->find($id);
        if (! $proyek) {
            return redirect()->to(site_url('proyek'))->with('error', 'Data proyek tidak ditemukan.');
        }

        $this->proyekModel->delete($id);
        return redirect()->to(site_url('proyek'))->with('success', 'Data proyek berhasil dihapus.');
    }
}
