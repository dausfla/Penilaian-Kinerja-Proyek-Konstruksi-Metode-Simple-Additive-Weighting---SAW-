<?php

namespace Tests\App\Views;

use CodeIgniter\Test\CIUnitTestCase;

/**
 * @internal
 */
final class HasilViewTest extends CIUnitTestCase
{
    public function testHasilIndexViewRendersLeaderboardOnly(): void
    {
        $data = [
            'title'          => 'Hasil Perangkingan SAW',
            'page_title'     => 'Hasil & Perangkingan Kinerja Proyek',
            'allPeriodes'    => [
                ['id' => 1, 'nama' => 'Periode 2026', 'status' => 'terhitung', 'tanggal_penilaian' => '2026-07-31'],
            ],
            'activePeriode'  => [
                'id'                => 1,
                'nama'              => 'Periode 2026',
                'status'            => 'terhitung',
                'tanggal_penilaian' => '2026-07-31',
            ],
            'hasilList'      => [
                [
                    'peringkat'   => 1,
                    'proyek_kode' => 'PRJ-01',
                    'proyek_nama' => 'Proyek Gedung A',
                    'jenis'       => 'kantor',
                    'klien'       => 'PT Sukses Mandiri',
                    'lokasi'      => 'Jakarta',
                    'nilai_rab'   => 500000000,
                    'vi'          => 0.9542,
                    'kategori'    => 'Baik',
                ],
            ],
            'kategoriCount'  => ['Baik' => 1, 'Perlu Perhatian' => 0, 'Berisiko/Terlambat' => 0],
            'batasBaik'      => 0.80,
            'batasPerhatian' => 0.60,
        ];

        $html = view('hasil/index', $data);

        // Leaderboard table exists
        $this->assertStringContainsString('Peringkat & Kategori Kinerja Proyek', $html);
        $this->assertStringContainsString('Proyek Gedung A', $html);
        $this->assertStringContainsString('0.95', $html);

        // Removed tabs and matrix tables should NOT exist
        $this->assertStringNotContainsString('1. Tabel Nilai Lapangan Terkonversi', $html);
        $this->assertStringNotContainsString('2. Tabel Skala Standar (0 - 1)', $html);
        $this->assertStringNotContainsString('3. Tabel Kontribusi Nilai Kriteria', $html);
        $this->assertStringNotContainsString('tab-matriks-x', $html);
        $this->assertStringNotContainsString('tab-matriks-r', $html);
        $this->assertStringNotContainsString('tab-matriks-w', $html);
    }

    public function testPdfViewRendersCorrectAddressAndAdminName(): void
    {
        $data = [
            'periode'        => [
                'id'                => 1,
                'nama'              => 'Evaluasi Semester I 2026',
                'tanggal_penilaian' => '2026-07-31',
            ],
            'hasilList'      => [
                [
                    'peringkat'   => 1,
                    'proyek_kode' => 'PRJ-A',
                    'proyek_nama' => 'A. Rumah',
                    'jenis'       => 'rumah',
                    'nilai_rab'   => 500000000,
                    'c1'          => 95.0,
                    'c2'          => 98.0,
                    'c3'          => 5,
                    'c4'          => 4,
                    'c5'          => 5,
                    'vi'          => 0.95,
                    'kategori'    => 'Baik',
                ],
            ],
            'kriterias'      => [],
            'settings'       => [
                'nama_perusahaan'   => 'PT Rancang Bangun Sedaya',
                'alamat_perusahaan' => '(Head Quarter): Pasirmulya, Kecamatan Bogor Barat, Kota Bogor, Jawa Barat 16118',
            ],
            'batasBaik'      => 0.80,
            'batasPerhatian' => 0.60,
            'printedBy'      => 'Muhamad Firdaus',
            'printDate'      => '16 October 2026 13:00',
        ];

        $html = view('hasil/pdf', $data);

        // Verify Address and Admin Name
        $this->assertStringContainsString('(Head Quarter): Pasirmulya, Kecamatan Bogor Barat, Kota Bogor, Jawa Barat 16118', $html);
        $this->assertStringContainsString('Muhamad Firdaus', $html);
        $this->assertStringContainsString('Administrator SPK', $html);
        $this->assertStringNotContainsString('Jl. Konstruksi Raya No. 88, Jakarta Selatan', $html);
    }

    public function testDashboardViewRendersAllInOneFeatures(): void
    {
        $data = [
            'title'          => 'Evaluasi & Peringkat Proyek',
            'page_title'     => 'Evaluasi & Peringkat Proyek',
            'allPeriodes'    => [
                ['id' => 1, 'nama' => 'Periode 2026', 'status' => 'terhitung', 'tanggal_penilaian' => '2026-07-31'],
            ],
            'activePeriode'  => [
                'id'                => 1,
                'nama'              => 'Periode 2026',
                'status'            => 'terhitung',
                'tanggal_penilaian' => '2026-07-31',
            ],
            'hasilList'      => [
                [
                    'proyek_id'   => 1,
                    'peringkat'   => 1,
                    'proyek_kode' => 'PRJ-BOGOR-01',
                    'proyek_nama' => 'Villa Modern 2 Lantai',
                    'jenis'       => 'rumah',
                    'klien'       => 'Bpk. Arya',
                    'lokasi'      => 'Pasirmulya, Bogor',
                    'nilai_rab'   => 850000000,
                    'tanggal_selesai_rencana' => '2026-11-30',
                    'vi'          => 0.9820,
                    'kategori'    => 'Baik',
                    'c1'          => 98.5,
                    'c2'          => 96.0,
                    'c3'          => 5,
                    'c4'          => 5,
                    'c5'          => 0,
                    'raw'         => [
                        'progres_aktual'         => 98.5,
                        'biaya_realisasi'        => 816000000,
                        'skor_foto_progres'      => 5,
                        'skor_bast'              => 5,
                        'tanggal_selesai_aktual' => '2026-11-30',
                    ],
                ],
            ],
            'kategoriCount'  => ['Baik' => 1, 'Perlu Perhatian' => 0, 'Berisiko/Terlambat' => 0],
            'allProyeks'     => [],
            'settings'       => ['batas_baik' => '0.80', 'batas_perhatian' => '0.60'],
            'batasBaik'      => 0.80,
            'batasPerhatian' => 0.60,
            'jenisList'      => ['rumah', 'gedung', 'kantor', 'kost'],
        ];

        $html = view('dashboard/index', $data);

        // All-in-one features exist
        $this->assertStringContainsString('Tambah & Nilai Proyek', $html);
        $this->assertStringContainsString('Peringkat & Kategori Kinerja Proyek', $html);
        $this->assertStringContainsString('Skor Kinerja', $html);
        $this->assertStringNotContainsString('$V_i$', $html);
        $this->assertStringContainsString('Villa Modern 2 Lantai', $html);
        $this->assertStringContainsString('modalTambahProyek', $html);
        $this->assertStringContainsString('modalEditProyek', $html);
    }
}

