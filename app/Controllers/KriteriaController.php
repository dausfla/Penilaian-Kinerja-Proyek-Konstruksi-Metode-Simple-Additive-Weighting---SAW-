<?php

namespace App\Controllers;

use App\Models\KriteriaModel;
use App\Models\PengaturanModel;

class KriteriaController extends BaseController
{
    protected KriteriaModel $kriteriaModel;
    protected PengaturanModel $pengaturanModel;

    public function __construct()
    {
        $this->kriteriaModel   = new KriteriaModel();
        $this->pengaturanModel = new PengaturanModel();
    }

    public function index()
    {
        $kriteria = $this->kriteriaModel->orderBy('kode', 'ASC')->findAll();
        $settings = $this->pengaturanModel->getAllAsMap();

        $totalBobot = 0.0;
        foreach ($kriteria as $k) {
            $totalBobot += (float)$k['bobot'];
        }

        return view('kriteria/index', [
            'title'          => 'Kriteria & Bobot Penilaian',
            'page_title'     => 'Kriteria, Bobot & Batas Kategori',
            'kriteria'       => $kriteria,
            'totalBobot'     => round($totalBobot, 4),
            'batasBaik'      => (float)($settings['batas_baik'] ?? 0.80),
            'batasPerhatian' => (float)($settings['batas_perhatian'] ?? 0.60),
        ]);
    }

    public function update()
    {
        $items = $this->request->getPost('kriteria');
        if (! is_array($items) || empty($items)) {
            return redirect()->back()->with('error', 'Data kriteria tidak valid.');
        }

        // Calculate total weight
        $totalBobot = 0.0;
        foreach ($items as $item) {
            $bobot = (float)($item['bobot'] ?? 0);
            if ($bobot <= 0) {
                return redirect()->back()->withInput()->with('error', 'Bobot setiap kriteria harus lebih besar dari 0.');
            }
            $totalBobot += $bobot;
        }

        // Strictly check if total weight is 1.00 (tolerance 0.0001)
        if (abs($totalBobot - 1.00) > 0.0001) {
            return redirect()->back()->withInput()->with(
                'error',
                sprintf('Total bobot harus tepat 1,00 (100%%). Total saat ini: %.4f. Perubahan tidak dapat disimpan.', $totalBobot)
            );
        }

        // Save criteria updates
        foreach ($items as $id => $data) {
            $this->kriteriaModel->update((int)$id, [
                'nama'    => trim((string)$data['nama']),
                'atribut' => strtolower(trim((string)$data['atribut'])),
                'bobot'   => (float)$data['bobot'],
            ]);
        }

        return redirect()->to(site_url('kriteria'))->with('success', 'Kriteria dan bobot penilaian berhasil diperbarui. Total bobot valid: 1,00.');
    }

    public function updatePengaturan()
    {
        $rules = [
            'batas_baik'      => 'required|numeric|greater_than[0]|less_than[1]',
            'batas_perhatian' => 'required|numeric|greater_than[0]|less_than[1]',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $batasBaik      = (float)$this->request->getPost('batas_baik');
        $batasPerhatian = (float)$this->request->getPost('batas_perhatian');

        if ($batasPerhatian >= $batasBaik) {
            return redirect()->back()->withInput()->with('error', 'Batas kategori "Perlu Perhatian" harus lebih kecil dari batas "Baik".');
        }

        $this->pengaturanModel->setSetting('batas_baik', (string)$batasBaik);
        $this->pengaturanModel->setSetting('batas_perhatian', (string)$batasPerhatian);

        return redirect()->to(site_url('kriteria'))->with('success', 'Batas nilai kategori kinerja berhasil diperbarui.');
    }
}
