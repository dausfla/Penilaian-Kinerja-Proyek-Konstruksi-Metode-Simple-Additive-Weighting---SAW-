<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class SpkSeeder extends Seeder
{
    public function run()
    {
        $db = \Config\Database::connect();

        // 1. Users
        $userCheck = $db->table('users')->countAllResults();
        if ($userCheck === 0) {
            $users = [
                [
                    'nama'          => 'Muhamad Firdaus',
                    'username'      => 'admin',
                    'password_hash' => password_hash('admin123', PASSWORD_BCRYPT),
                    'role'          => 'admin',
                    'aktif'         => true,
                ],
            ];
            $db->table('users')->insertBatch($users);
        }

        // 2. Kriteria
        $kriteriaCheck = $db->table('kriteria')->countAllResults();
        if ($kriteriaCheck === 0) {
            $kriteria = [
                [
                    'kode'    => 'C1',
                    'nama'    => 'Capaian progres',
                    'atribut' => 'benefit',
                    'bobot'   => 0.30,
                ],
                [
                    'kode'    => 'C2',
                    'nama'    => 'Biaya terhadap RAB',
                    'atribut' => 'cost',
                    'bobot'   => 0.25,
                ],
                [
                    'kode'    => 'C3',
                    'nama'    => 'Dokumentasi Foto Progres Lapangan',
                    'atribut' => 'benefit',
                    'bobot'   => 0.20,
                ],
                [
                    'kode'    => 'C4',
                    'nama'    => 'Ketepatan serah terima',
                    'atribut' => 'benefit',
                    'bobot'   => 0.15,
                ],
                [
                    'kode'    => 'C5',
                    'nama'    => 'Keterlambatan',
                    'atribut' => 'cost',
                    'bobot'   => 0.10,
                ],
            ];
            $db->table('kriteria')->insertBatch($kriteria);
        }

        // 3. Pengaturan
        $pengaturanCheck = $db->table('pengaturan')->countAllResults();
        if ($pengaturanCheck === 0) {
            $pengaturan = [
                ['kunci' => 'batas_baik', 'nilai' => '0.80'],
                ['kunci' => 'batas_perhatian', 'nilai' => '0.60'],
                ['kunci' => 'nama_perusahaan', 'nilai' => 'PT Rancang Bangun Sedaya'],
                ['kunci' => 'keterangan_aplikasi', 'nilai' => 'Sistem Pendukung Keputusan Penilaian Kinerja Proyek Konstruksi (Metode SAW)'],
            ];
            $db->table('pengaturan')->insertBatch($pengaturan);
        }

        // 4. Data Uji Bagian 9 (Proyek)
        $proyekCheck = $db->table('proyek')->countAllResults();
        if ($proyekCheck === 0) {
            $proyekData = [
                [
                    'kode'                    => 'PRJ-RUMAH-01',
                    'nama'                    => 'A. Rumah',
                    'jenis'                   => 'rumah',
                    'klien'                   => 'Bpk. Hendra Gunawan',
                    'lokasi'                  => 'Kebayoran Baru, Jakarta Selatan',
                    'tanggal_mulai'           => '2026-01-01',
                    'tanggal_selesai_rencana' => '2026-06-30',
                    'nilai_rab'               => 500000000.00,
                ],
                [
                    'kode'                    => 'PRJ-KOST-01',
                    'nama'                    => 'B. Kost',
                    'jenis'                   => 'kost',
                    'klien'                   => 'Ibu Ratna Sari',
                    'lokasi'                  => 'Margonda, Depok',
                    'tanggal_mulai'           => '2026-01-01',
                    'tanggal_selesai_rencana' => '2026-06-30',
                    'nilai_rab'               => 300000000.00,
                ],
                [
                    'kode'                    => 'PRJ-KANTOR-01',
                    'nama'                    => 'C. Kantor',
                    'jenis'                   => 'kantor',
                    'klien'                   => 'PT Dinamika Prima',
                    'lokasi'                  => 'BSD City, Tangerang',
                    'tanggal_mulai'           => '2026-01-01',
                    'tanggal_selesai_rencana' => '2026-06-30',
                    'nilai_rab'               => 1000000000.00,
                ],
                [
                    'kode'                    => 'PRJ-RENOV-01',
                    'nama'                    => 'D. Renovasi',
                    'jenis'                   => 'renovasi',
                    'klien'                   => 'Bpk. Bambang Wijaya',
                    'lokasi'                  => 'Sentul, Bogor',
                    'tanggal_mulai'           => '2026-01-01',
                    'tanggal_selesai_rencana' => '2026-06-30',
                    'nilai_rab'               => 200000000.00,
                ],
            ];
            $db->table('proyek')->insertBatch($proyekData);

            // Fetch admin user ID
            $admin = $db->table('users')->where('username', 'admin')->get()->getRowArray();
            $adminId = $admin ? $admin['id'] : null;

            // 5. Periode Penilaian Data Uji
            $db->table('periode_penilaian')->insert([
                'nama'              => 'Evaluasi Semester I 2026 (Data Uji PRD)',
                'tanggal_penilaian' => '2026-07-31',
                'status'            => 'draft',
                'created_by'        => $adminId,
            ]);
            $periodeId = $db->insertID();

            // Map project codes to IDs
            $proyeks = $db->table('proyek')->get()->getResultArray();
            $projMap = [];
            foreach ($proyeks as $p) {
                $projMap[$p['kode']] = $p['id'];
            }

            // 6. Penilaian Data Uji Raw Inputs (C3: Dokumentasi Foto Progres)
            $penilaianData = [
                [
                    'periode_id'             => $periodeId,
                    'proyek_id'              => $projMap['PRJ-RUMAH-01'],
                    'progres_rencana'        => 100.00,
                    'progres_aktual'         => 95.00,
                    'biaya_realisasi'        => 490000000.00,
                    'skor_foto_progres'      => 5,
                    'skor_bast'              => 4,
                    'tanggal_selesai_aktual' => '2026-07-05',
                ],
                [
                    'periode_id'             => $periodeId,
                    'proyek_id'              => $projMap['PRJ-KOST-01'],
                    'progres_rencana'        => 100.00,
                    'progres_aktual'         => 80.00,
                    'biaya_realisasi'        => 330000000.00,
                    'skor_foto_progres'      => 3,
                    'skor_bast'              => 3,
                    'tanggal_selesai_aktual' => '2026-07-20',
                ],
                [
                    'periode_id'             => $periodeId,
                    'proyek_id'              => $projMap['PRJ-KANTOR-01'],
                    'progres_rencana'        => 100.00,
                    'progres_aktual'         => 90.00,
                    'biaya_realisasi'        => 1000000000.00,
                    'skor_foto_progres'      => 4,
                    'skor_bast'              => 5,
                    'tanggal_selesai_aktual' => '2026-07-10',
                ],
                [
                    'periode_id'             => $periodeId,
                    'proyek_id'              => $projMap['PRJ-RENOV-01'],
                    'progres_rencana'        => 100.00,
                    'progres_aktual'         => 70.00,
                    'biaya_realisasi'        => 210000000.00,
                    'skor_foto_progres'      => 1,
                    'skor_bast'              => 2,
                    'tanggal_selesai_aktual' => '2026-07-30',
                ],
            ];
            $db->table('penilaian')->insertBatch($penilaianData);
        }
    }
}
