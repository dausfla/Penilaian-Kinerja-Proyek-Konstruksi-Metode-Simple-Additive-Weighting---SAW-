# Sistem Pendukung Keputusan (SPK) Penilaian Kinerja Proyek Konstruksi
## Metode Simple Additive Weighting (SAW) &bull; PT Rancang Bangun Sedaya

![Banner SPK PT Rancang Bangun Sedaya](public/images/logo-rbs.png)

Aplikasi berbasis web resmi untuk mengevaluasi, membandingkan, serta merangking kinerja proyek konstruksi secara objektif, transparan, dan akurat menggunakan algoritma **Simple Additive Weighting (SAW)** dengan konsep antarmuka terpadu (*All-in-One Dashboard*).

---

## 🏢 Identitas Resmi Perusahaan
- **Nama Perusahaan**: PT Rancang Bangun Sedaya
- **Alamat Kantor (Head Quarter)**: Pasirmulya, Kecamatan Bogor Barat, Kota Bogor, Jawa Barat 16118
- **Administrator Penanggung Jawab**: Muhamad Firdaus

---

## 🌟 Fitur Utama Sistem (Versi Terbaru)

1. **Dashboard Terpadu (*All-in-One Dashboard*)**:
   - Seluruh operasional penilaian proyek dipusatkan pada satu halaman (`/dashboard`).
   - Penilaian proyek bersifat universal langsung untuk seluruh proyek aktif tanpa sistem periode yang berbelit.
2. **Form Modal Input Cepat & Scrollable**:
   - Menambah proyek baru dan menginput nilai riil 7 kriteria dalam **1 form terpadu**.
   - Input tanggal praktis: **Tanggal Mulai** dan **Tanggal Selesai Proyek** (sistem otomatis menghitung durasi waktu C5).
   - Penilaian mutu fisik (C1) praktis menggunakan **Skor 1 s.d. 5** tanpa input persen rumit.
3. **Kalkulasi Otomatis Metode SAW**:
   - Normalisasi matriks untuk kriteria Keuntungan (*Benefit*) dan Biaya/Waktu (*Cost*).
   - Pengurutan peringkat otomatis (*Live Re-ranking*) setiap kali ada data baru atau perubahan nilai.
   - Pengelompokan status kinerja secara instan: **Baik**, **Perlu Perhatian**, atau **Berisiko / Terlambat**.
4. **Antarmuka Bersih Bebas Notasi Rumus Akademis**:
   - Dirancang untuk lingkungan produksi enterprise (*client-ready*).
   - Label kolom tertulis rapi sebagai **"Skor Kinerja"** tanpa simbol LaTeX/skripsi seperti `$V_i$` atau `$X_{ij}$`.
5. **Master Data Proyek & Pengaturan Bobot**:
   - Menu **Data Proyek** (`/proyek`) untuk mengelola inventaris proyek.
   - Menu **Pengaturan & Bobot** (`/pengaturan`) untuk menyesuaikan bobot kriteria (total 100%) dan ambang batas kategori.
6. **Ekspor Laporan PDF Resmi Standar A4**:
   - Dokumen siap cetak terintegrasi Dompdf lengkap dengan kop surat PT Rancang Bangun Sedaya, alamat Pasirmulya Bogor, ringkasan skor C1–C7, dan pengesahan oleh Muhamad Firdaus.

---

## 📊 Struktur 7 Kriteria Penilaian

Total pembobotan seluruh kriteria wajib tepat **100% (1,00)**:

| Kode | Kriteria Penilaian | Sifat / Atribut | Bobot | Parameter Input |
| :---: | :--- | :---: | :---: | :--- |
| **C1** | **Mutu & Kualitas Hasil Fisik** | *Benefit* | **20% (0,20)** | Kerapihan Finishing & Struktur (**Skor 1 – 5**) |
| **C2** | **Realisasi Biaya terhadap RAB** | *Cost* | **20% (0,20)** | Biaya Pengeluaran Realisasi (Rp) vs RAB |
| **C3** | **Dokumentasi Foto Progres Lapangan** | *Benefit* | **15% (0,15)** | Kerapihan & Kelengkapan Arsip Foto (**Skor 1 – 5**) |
| **C4** | **Ketepatan & Kualitas BAST** | *Benefit* | **15% (0,15)** | Kualitas Berita Acara Serah Terima (**Skor 1 – 5**) |
| **C5** | **Waktu / Durasi Penyelesaian Proyek** | *Cost* | **10% (0,10)** | Durasi Pelaksanaan Proyek (**Tanggal Selesai - Mulai**) |
| **C6** | **Tingkat Kepuasan Klien / Owner** | *Benefit* | **10% (0,10)** | Rating Kepuasan Pelanggan / Owner (**Skor 1 – 5**) |
| **C7** | **Penerapan K3 & Keselamatan Kerja** | *Benefit* | **10% (0,10)** | Kepatuhan SMKK & Zero Accident (**Skor 1 – 5**) |

### Ambang Batas Kategori Kinerja:
- **Baik**: Skor Akhir $\ge 0{,}80$
- **Perlu Perhatian**: Skor Akhir $0{,}60$ s/d $0{,}79$
- **Berisiko / Terlambat**: Skor Akhir $< 0{,}60$

---

## 🛠️ Kebutuhan Sistem & Teknologi

- **Bahasa Pemrograman**: PHP 8.0 / 8.1 / 8.2
- **Framework**: CodeIgniter 4.4+
- **Database**: PostgreSQL (port 5432, database: `spk_konstruksi`)
- **Frontend**: Bootstrap 5.3, Bootstrap Icons, Vanilla CSS Design System (*Navy & Gold*)
- **PDF Engine**: Dompdf 2.0+
- **Dependency Manager**: Composer

---

## 🚀 Panduan Menjalankan Aplikasi

### 1. Kloning & Dependensi
```bash
git clone https://github.com/dausfla/Penilaian-Kinerja-Proyek-Konstruksi-Metode-Simple-Additive-Weighting---SAW-.git
cd Penilaian-Kinerja-Proyek-Konstruksi-Metode-Simple-Additive-Weighting---SAW-
composer install
```

### 2. Konfigurasi Environment (`.env`)
```ini
CI_ENVIRONMENT = production
app.baseURL = 'http://localhost:8080/'

database.default.hostname = localhost
database.default.database = spk_konstruksi
database.default.username = firdaus
database.default.password = 
database.default.DBDriver = Postgre
database.default.port = 5432
```

### 3. Migrasi Database
```bash
php spark migrate
```

### 4. Jalankan Server Lokal
```bash
php spark serve --port 8080
```
Buka peramban pada: **[http://localhost:8080/](http://localhost:8080/)**

---

## 🔑 Akses Masuk & Otentikasi Keamanan (Passkey PIN & OTP)

Sistem menggunakan otentikasi ganda modern setara sistem perbankan/ATM dengan dukungan pemulihan kode OTP:

1. **Akses PIN Utama (6-Digit PIN)**:
   - **Halaman Login**: [http://localhost:8080/login](http://localhost:8080/login)
   - **PIN Akses**: `080905`
   - Dilengkapi 6-box input dinamis, auto-focus, paste support, dan proteksi anti-cache riwayat browser.

2. **Akses Cadangan (Username & Password)**:
   - **Username**: `admin`
   - **Password**: `admin123`

3. **Pemulihan PIN (Lupa PIN & Gmail OTP)**:
   - **Alur**: Input Email Terdaftar $\rightarrow$ Kirim 6-Digit OTP via Gmail $\rightarrow$ Validasi OTP (masa berlaku 5 menit) $\rightarrow$ Tentukan 6-Digit PIN Baru.
   - **Integrasi SMTP**: Terintegrasi langsung dengan server resmi Google Mail SMTP.

---

## 🧪 Pengujian Otomatis (Unit Testing)

Jalankan rangkaian pengujian PHPUnit:
```bash
./vendor/bin/phpunit --testdox
```
*Hasil uji: 17/17 tes lulus (77 assertions).*

---

## 📄 Lisensi & Hak Cipta

&copy; 2026 **PT Rancang Bangun Sedaya**. Hak Cipta Dilindungi Undang-Undang.
