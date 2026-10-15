# Sistem Pendukung Keputusan (SPK) Penilaian Kinerja Proyek Konstruksi
## Metode Simple Additive Weighting (SAW) &bull; PT Rancang Bangun Sedaya

![Banner SPK PT Rancang Bangun Sedaya](public/images/logo-rbs.png)

Aplikasi berbasis web resmi untuk mengevaluasi, membandingkan, serta merangking kinerja proyek konstruksi secara objektif, transparan, dan akurat menggunakan algoritma **Simple Additive Weighting (SAW)**.

---

## 🌟 Fitur Utama Sistem

1. **Halaman Welcome / Landing Page Modern**:
   - Tampilan depan (*executive corporate landing page*) berdesain *glassmorphism* dengan identitas resmi PT Rancang Bangun Sedaya.
   - Penjelasan interaktif 5 kriteria evaluasi, 3 kategori kinerja, dan alur proses penilaian.
2. **Peran Tunggal Administrator (*Admin-Only*)**:
   - Disederhanakan untuk operasional praktis tanpa hambatan hak akses multi-level.
   - Administrator memiliki kendali penuh: mengelola master data proyek, kriteria bobot, sesi periode, input penilaian, dan ekspor laporan.
3. **Kerahasiaan Data Terlindungi (Bebas Isu NDA Dokumen Kontrak)**:
   - Tidak lagi memerlukan dokumen kontrak sensitif (SP, PKS, PPJB).
   - Evaluasi lapangan dialihkan ke bukti fisik visual riil: **Dokumentasi Foto Progres Lapangan**.
4. **Mode Input Fleksibel**:
   - **Input Satuan (Form Lengkap)** dengan kalkulator pratinjau langsung (*live preview*) dan tombol instan *"Tepat Waktu (0 Hari)"*.
   - **Mode Edit Cepat (Batch Modal)** untuk mengisi seluruh proyek dalam satu tabel sekaligus.
5. **Kalkulasi Matematis Presisi (Metode SAW)**:
   - Normalisasi matriks untuk kriteria Keuntungan (*Benefit*) dan Biaya/Waktu (*Cost*).
   - Penanganan pembagian nol (*zero-division safe*).
   - Pengelompokan status kinerja secara otomatis: **Baik**, **Perlu Perhatian**, atau **Berisiko / Terlambat**.
6. **Ekspor Laporan PDF Resmi Berstandar A4**:
   - Terintegrasi Dompdf untuk menghasilkan dokumen siap cetak lengkap dengan kop surat PT Rancang Bangun Sedaya, rangkuman nilai, catatan rekomendasi, dan kolom tanda tangan pimpinan.

---

## 📊 Struktur 5 Kriteria Penilaian

Total pembobotan seluruh kriteria wajib tepat **100% (1,00)**:

| Kode | Kriteria Penilaian | Sifat / Atribut | Bobot | Parameter Input |
| :---: | :--- | :---: | :---: | :--- |
| **C1** | **Capaian Progres Kurva S** | *Benefit* | **30% (0,30)** | $\frac{\text{Aktual (\%) } } {\text{Rencana (\%)}} \times 100\%$ |
| **C2** | **Realisasi Biaya terhadap RAB** | *Cost* | **25% (0,25)** | $\frac{\text{Biaya Realisasi}}{\text{Nilai RAB}} \times 100\%$ |
| **C3** | **Dokumentasi Foto Progres Lapangan** | *Benefit* | **20% (0,20)** | Skala Rubrik Kerapihan Foto (**Skor 1 – 5**) |
| **C4** | **Ketepatan & Kualitas BAST** | *Benefit* | **15% (0,15)** | Skala Rubrik Mutu Serah Terima (**Skor 1 – 5**) |
| **C5** | **Keterlambatan Waktu Penyelesaian** | *Cost* | **10% (0,10)** | Selisih hari kalender (**0 Hari jika tepat waktu**) |

### Ambang Batas Kategori Kinerja:
- **Baik**: Skor Akhir $\ge 0{,}80$
- **Perlu Perhatian**: Skor Akhir $0{,}60$ s/d $0{,}79$
- **Berisiko / Terlambat**: Skor Akhir $< 0{,}60$

---

## 🛠️ Kebutuhan Sistem & Teknologi

- **Bahasa Pemrograman**: PHP 8.0 / 8.1 / 8.2
- **Framework**: CodeIgniter 4
- **Database**: PostgreSQL (port 5432)
- **Frontend**: Bootstrap 5.3, Bootstrap Icons, Vanilla CSS Design System, Google Fonts (*Plus Jakarta Sans*)
- **PDF Engine**: Dompdf 2.0+
- **Dependency Manager**: Composer

---

## 🚀 Panduan Instalasi & Menjalankan Aplikasi

### 1. Kloning Repositori
```bash
git clone https://github.com/dausfla/Penilaian-Kinerja-Proyek-Konstruksi-Metode-Simple-Additive-Weighting---SAW-.git
cd Penilaian-Kinerja-Proyek-Konstruksi-Metode-Simple-Additive-Weighting---SAW-
```

### 2. Pasang Dependensi PHP
```bash
composer install
```

### 3. Konfigurasi Environment (`.env`)
Salin file `.env.example` menjadi `.env`:
```bash
cp .env.example .env
```
Sesuaikan kredensial database PostgreSQL Anda pada file `.env`:
```ini
CI_ENVIRONMENT = production
app.baseURL = 'http://localhost:8080/'

database.default.hostname = localhost
database.default.database = spk_konstruksi
database.default.username = postgres
database.default.password = rahasia
database.default.DBDriver = Postgre
database.default.port = 5432
```

### 4. Migrasi Database & Seeder Data Awal
```bash
php spark migrate
php spark db:seed SpkSeeder
```

### 5. Jalankan Server Pengembangan
```bash
php spark serve --port 8080
```
Buka peramban pada alamat: **[http://localhost:8080/](http://localhost:8080/)**

---

## 🔑 Kredensial Default Masuk Sistem

- **Halaman Login**: [http://localhost:8080/login](http://localhost:8080/login)
- **Username**: `admin`
- **Password**: `admin123`
*(Tersedia tombol "Isi Akun Administrator Otomatis" pada form login).*

---

## 🧪 Pengujian Otomatis (Unit Testing)

Jalankan rangkaian pengujian PHPUnit untuk memverifikasi kalkulasi SAW, normalisasi, dan fungsionalitas sistem:
```bash
./vendor/bin/phpunit --testdox
```
*Hasil uji: 13/13 tes lulus (42 assertions).*

---

## 📄 Lisensi & Hak Cipta

&copy; 2026 **PT Rancang Bangun Sedaya**. Hak Cipta Dilindungi Undang-Undang.
