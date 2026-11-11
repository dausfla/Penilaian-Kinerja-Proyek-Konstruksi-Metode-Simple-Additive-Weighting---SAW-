<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>SIPEKO &bull; Sistem Penilaian Kinerja Konstruksi &bull; PT Rancang Bangun Sedaya</title>
  
  <!-- Favicon Logo RBS -->
  <link rel="icon" type="image/png" href="<?= base_url('images/logo-rbs-favicon.png') ?>">

  <!-- Bootstrap 5.3 CSS -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
  <!-- Bootstrap Icons -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
  <!-- Google Fonts: Plus Jakarta Sans -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

  <style>
    :root {
      --bg-white: #ffffff;
      --bg-warm: #fdfcf9;
      --yellow-primary: #eab308;
      --yellow-hover: #ca8a04;
      --yellow-light: #fef9c3;
      --yellow-border: #fde047;
      --text-main: #1e293b;
      --text-muted: #64748b;
      --border-color: #e2e8f0;
    }

    body {
      font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
      background-color: var(--bg-white);
      color: var(--text-main);
      line-height: 1.6;
    }

    /* Minimalist Navbar */
    .sipeko-nav {
      background-color: var(--bg-white);
      border-bottom: 1px solid var(--border-color);
      padding: 0.9rem 0;
    }

    .brand-logo-img {
      height: 40px;
      width: auto;
      object-fit: contain;
    }

    .brand-title {
      font-size: 1.15rem;
      font-weight: 800;
      color: var(--text-main);
      letter-spacing: -0.3px;
      line-height: 1.1;
    }

    .brand-sub {
      font-size: 0.75rem;
      font-weight: 600;
      color: var(--yellow-hover);
      text-transform: uppercase;
      letter-spacing: 0.5px;
    }

    .nav-link-item {
      color: var(--text-muted);
      font-weight: 500;
      font-size: 0.92rem;
      padding: 0.45rem 0.85rem !important;
      text-decoration: none;
      border-radius: 6px;
      transition: color 0.15s ease;
    }

    .nav-link-item:hover {
      color: var(--text-main);
    }

    /* Yellow Minimalist Buttons */
    .btn-sipeko-primary {
      background-color: var(--yellow-primary);
      color: #000000 !important;
      font-weight: 600;
      font-size: 0.9rem;
      padding: 0.55rem 1.25rem;
      border-radius: 8px;
      border: 1px solid var(--yellow-primary);
      transition: background-color 0.15s ease, border-color 0.15s ease;
      text-decoration: none;
      display: inline-flex;
      align-items: center;
      gap: 0.45rem;
    }

    .btn-sipeko-primary:hover {
      background-color: var(--yellow-hover);
      border-color: var(--yellow-hover);
      color: #000000 !important;
    }

    .btn-sipeko-secondary {
      background-color: var(--bg-white);
      color: var(--text-main) !important;
      font-weight: 600;
      font-size: 0.9rem;
      padding: 0.55rem 1.25rem;
      border-radius: 8px;
      border: 1px solid var(--border-color);
      transition: all 0.15s ease;
      text-decoration: none;
      display: inline-flex;
      align-items: center;
      gap: 0.45rem;
    }

    .btn-sipeko-secondary:hover {
      border-color: var(--yellow-primary);
      background-color: var(--yellow-light);
    }

    /* Hero Section */
    .hero-section {
      background-color: var(--bg-white);
      border-bottom: 1px solid var(--border-color);
    }

    /* Banner Full Width */
    .banner-top-full {
      width: 100%;
      background-color: #ffffff;
      border-bottom: 1px solid var(--border-color);
      overflow: hidden;
    }

    .banner-img-full {
      width: 100%;
      height: auto;
      max-height: 480px;
      object-fit: cover;
      object-position: center;
      display: block;
    }

    .system-badge {
      display: inline-flex;
      align-items: center;
      gap: 0.4rem;
      background-color: var(--yellow-light);
      border: 1px solid var(--yellow-border);
      color: #854d0e;
      font-size: 0.8rem;
      font-weight: 600;
      padding: 0.3rem 0.85rem;
      border-radius: 9999px;
      margin-bottom: 1.25rem;
    }

    .hero-title {
      font-size: clamp(2.2rem, 4vw, 3.25rem);
      font-weight: 800;
      letter-spacing: -0.8px;
      color: var(--text-main);
      line-height: 1.15;
      margin-bottom: 0.6rem;
    }

    .hero-subtitle {
      font-size: 1.25rem;
      font-weight: 600;
      color: var(--yellow-hover);
      margin-bottom: 1.25rem;
    }

    .hero-desc {
      font-size: 1.05rem;
      color: var(--text-muted);
      max-width: 680px;
      margin: 0 auto 2rem;
      line-height: 1.6;
    }

    /* Minimalist Highlight Boxes */
    .highlight-card {
      background-color: var(--bg-white);
      border: 1px solid var(--border-color);
      border-radius: 12px;
      padding: 1.5rem;
      height: 100%;
      text-align: left;
      transition: border-color 0.2s ease;
    }

    .highlight-card:hover {
      border-color: var(--yellow-primary);
    }

    .highlight-icon {
      width: 40px;
      height: 40px;
      background-color: var(--yellow-light);
      color: #854d0e;
      border-radius: 8px;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      font-size: 1.2rem;
      margin-bottom: 1rem;
    }

    /* Section Styling */
    .section-py {
      padding: 4rem 0;
    }

    .section-bg-warm {
      background-color: var(--bg-warm);
      border-bottom: 1px solid var(--border-color);
    }

    .section-title {
      font-size: 1.85rem;
      font-weight: 800;
      color: var(--text-main);
      letter-spacing: -0.5px;
      margin-bottom: 0.4rem;
    }

    .section-subtitle {
      color: var(--text-muted);
      font-size: 0.98rem;
      max-width: 600px;
      margin: 0 auto 2.5rem;
    }

    /* Table Minimalist */
    .table-custom {
      border: 1px solid var(--border-color);
      background-color: var(--bg-white);
      border-radius: 10px;
      overflow: hidden;
    }

    .table-custom table {
      margin-bottom: 0;
    }

    .table-custom th {
      background-color: var(--bg-warm);
      font-size: 0.82rem;
      text-transform: uppercase;
      letter-spacing: 0.5px;
      color: var(--text-muted);
      font-weight: 700;
      border-bottom: 1px solid var(--border-color);
      padding: 0.85rem 1rem;
    }

    .table-custom td {
      padding: 0.85rem 1rem;
      font-size: 0.92rem;
      vertical-align: middle;
      border-bottom: 1px solid var(--border-color);
    }

    .badge-benefit {
      background-color: #f0fdf4;
      color: #166534;
      border: 1px solid #bbf7d0;
      font-weight: 600;
      font-size: 0.75rem;
      padding: 0.25rem 0.6rem;
      border-radius: 6px;
    }

    .badge-cost {
      background-color: #fff1f2;
      color: #9f1239;
      border: 1px solid #fecdd3;
      font-weight: 600;
      font-size: 0.75rem;
      padding: 0.25rem 0.6rem;
      border-radius: 6px;
    }

    .weight-tag {
      background-color: var(--yellow-light);
      color: #854d0e;
      font-weight: 700;
      font-size: 0.85rem;
      padding: 0.2rem 0.55rem;
      border-radius: 6px;
      display: inline-block;
    }

    /* Step Card */
    .step-box {
      background-color: var(--bg-white);
      border: 1px solid var(--border-color);
      border-radius: 12px;
      padding: 1.75rem 1.5rem;
      height: 100%;
      text-align: left;
    }

    .step-number {
      font-weight: 800;
      font-size: 1.15rem;
      color: var(--yellow-hover);
      margin-bottom: 0.75rem;
    }

    /* Status Strip */
    .status-strip-card {
      border: 1px solid var(--border-color);
      border-radius: 10px;
      padding: 1rem 1.25rem;
      background-color: var(--bg-white);
      height: 100%;
    }

    /* Minimalist Footer */
    .sipeko-footer {
      background-color: var(--bg-white);
      border-top: 1px solid var(--border-color);
      padding: 2.5rem 0 1.75rem;
      font-size: 0.88rem;
      color: var(--text-muted);
    }

    .footer-link {
      color: var(--text-muted);
      text-decoration: none;
      transition: color 0.15s ease;
    }

    .footer-link:hover {
      color: var(--text-main);
    }
  </style>
</head>
<body>

  <!-- Minimalist Navbar -->
  <nav class="sipeko-nav sticky-top">
    <div class="container d-flex align-items-center justify-content-between">
      <a href="<?= site_url('/') ?>" class="d-flex align-items-center gap-3 text-decoration-none">
        <img src="<?= base_url('images/logo-rbs.png') ?>" alt="Logo PT Rancang Bangun Sedaya" class="brand-logo-img">
        <div>
          <div class="brand-title">SIPEKO</div>
          <div class="brand-sub">PT Rancang Bangun Sedaya</div>
        </div>
      </a>

      <div class="d-none d-md-flex align-items-center gap-1">
        <a href="#tentang" class="nav-link-item">Tentang</a>
        <a href="#kriteria" class="nav-link-item">7 Kriteria</a>
        <a href="#alur" class="nav-link-item">Alur Evaluasi</a>
        <a href="https://rancangbangunkreasi.id/" target="_blank" rel="noopener noreferrer" class="nav-link-item">
          <span>Profil Perusahaan</span>
          <i class="bi bi-box-arrow-up-right ms-1" style="font-size: 0.75rem;"></i>
        </a>
      </div>

      <div>
        <?php if ($isLoggedIn): ?>
          <a href="<?= site_url('dashboard') ?>" class="btn-sipeko-primary">
            <i class="bi bi-speedometer2"></i>
            <span>Buka Dashboard</span>
          </a>
        <?php else: ?>
          <a href="<?= site_url('login') ?>" class="btn-sipeko-primary">
            <i class="bi bi-box-arrow-in-right"></i>
            <span>Masuk ke Sistem</span>
          </a>
        <?php endif; ?>
      </div>
    </div>
  </nav>

  <!-- Hero Section (Clean White & Yellow) -->
  <section class="hero-section text-center p-0" id="tentang">
    <!-- Banner Tim Full Width di Paling Atas (Edge-to-Edge) -->
    <div class="banner-top-full">
      <img src="<?= base_url('images/banner-tim-rbk.jpg') ?>" alt="Tim Rancang Bangun Kreasi - Anda Impikan, Kami Wujudkan" class="banner-img-full">
    </div>

    <div class="container py-4">
      <h1 class="hero-title">SIPEKO</h1>
      <div class="hero-subtitle">Sistem Penilaian Kinerja Konstruksi</div>

      <p class="hero-desc">
        Sistem resmi <strong>PT Rancang Bangun Sedaya</strong> untuk mengevaluasi, membandingkan, serta merangking kinerja proyek konstruksi secara objektif, transparan, dan terukur berdasarkan 7 kriteria teknis.
      </p>

      <div class="d-flex flex-wrap justify-content-center gap-2 mb-4">
        <?php if ($isLoggedIn): ?>
          <a href="<?= site_url('dashboard') ?>" class="btn-sipeko-primary">
            <i class="bi bi-speedometer2"></i>
            <span>Buka Dashboard Utama (<?= esc($userNama) ?>)</span>
          </a>
        <?php else: ?>
          <a href="<?= site_url('login') ?>" class="btn-sipeko-primary">
            <i class="bi bi-box-arrow-in-right"></i>
            <span>Masuk ke Sistem (Login)</span>
          </a>
        <?php endif; ?>
        <a href="#kriteria" class="btn-sipeko-secondary">
          <i class="bi bi-table"></i>
          <span>Lihat 7 Kriteria Penilaian</span>
        </a>
        <a href="https://rancangbangunkreasi.id/" target="_blank" rel="noopener noreferrer" class="btn-sipeko-secondary">
          <i class="bi bi-globe"></i>
          <span>Profil Perusahaan</span>
          <i class="bi bi-box-arrow-up-right small ms-1" style="font-size: 0.75rem;"></i>
        </a>
      </div>

      <!-- 3 Poin Keunggulan Minimalis -->
      <div class="row g-3 justify-content-center pt-2">
        <div class="col-md-4">
          <div class="highlight-card">
            <div class="highlight-icon">
              <i class="bi bi-bar-chart-steps"></i>
            </div>
            <h6 class="fw-bold mb-1">Metode SAW Terkalibrasi</h6>
            <p class="text-muted small mb-0">Normalisasi matematis kriteria keuntungan (*benefit*) dan biaya (*cost*) dengan total bobot tepat 100%.</p>
          </div>
        </div>
        <div class="col-md-4">
          <div class="highlight-card">
            <div class="highlight-icon">
              <i class="bi bi-lightning-charge"></i>
            </div>
            <h6 class="fw-bold mb-1">Perangkingan Otomatis</h6>
            <p class="text-muted small mb-0">Setiap perubahan data fisik atau anggaran langsung memperbarui urutan rangking kinerja proyek secara *real-time*.</p>
          </div>
        </div>
        <div class="col-md-4">
          <div class="highlight-card">
            <div class="highlight-icon">
              <i class="bi bi-file-earmark-pdf"></i>
            </div>
            <h6 class="fw-bold mb-1">Laporan Resmi A4</h6>
            <p class="text-muted small mb-0">Ekspor hasil evaluasi ke format PDF siap cetak dengan kop surat, legalitas, dan format standar perusahaan.</p>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Section 7 Kriteria Penilaian -->
  <section class="section-py section-bg-warm" id="kriteria">
    <div class="container">
      <div class="text-center">
        <h2 class="section-title">7 Kriteria Penilaian Kinerja</h2>
        <p class="section-subtitle">
          Evaluasi proyek dihitung berdasarkan 7 parameter terukur dengan pembobotan total 100% (1,00).
        </p>
      </div>

      <!-- Tabel Minimalis Kriteria -->
      <div class="table-custom mb-4 shadow-sm">
        <div class="table-responsive">
          <table class="table align-middle">
            <thead>
              <tr>
                <th style="width: 10%;">Kode</th>
                <th style="width: 35%;">Kriteria Penilaian</th>
                <th style="width: 15%;">Sifat</th>
                <th style="width: 15%;">Bobot</th>
                <th style="width: 25%;">Parameter Penilaian</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td class="fw-bold text-dark">C1</td>
                <td class="fw-semibold">Mutu & Kualitas Hasil Fisik</td>
                <td><span class="badge-benefit">Benefit</span></td>
                <td><span class="weight-tag">20% (0,20)</span></td>
                <td class="text-muted">Kerapihan Finishing & Struktur (Skor 1 - 3)</td>
              </tr>
              <tr>
                <td class="fw-bold text-dark">C2</td>
                <td class="fw-semibold">Realisasi Biaya terhadap RAB</td>
                <td><span class="badge-cost">Cost</span></td>
                <td><span class="weight-tag">20% (0,20)</span></td>
                <td class="text-muted">Pengeluaran Riil (Rp) vs Pagu RAB</td>
              </tr>
              <tr>
                <td class="fw-bold text-dark">C3</td>
                <td class="fw-semibold">Dokumentasi Foto Progres Lapangan</td>
                <td><span class="badge-benefit">Benefit</span></td>
                <td><span class="weight-tag">15% (0,15)</span></td>
                <td class="text-muted">Kelengkapan & Kerapihan Arsip Foto (Skor 1 - 3)</td>
              </tr>
              <tr>
                <td class="fw-bold text-dark">C4</td>
                <td class="fw-semibold">Ketepatan & Kualitas BAST</td>
                <td><span class="badge-benefit">Benefit</span></td>
                <td><span class="weight-tag">15% (0,15)</span></td>
                <td class="text-muted">Kualitas Berita Acara Serah Terima (Skor 1 - 3)</td>
              </tr>
              <tr>
                <td class="fw-bold text-dark">C5</td>
                <td class="fw-semibold">Waktu / Durasi Penyelesaian Proyek</td>
                <td><span class="badge-cost">Cost</span></td>
                <td><span class="weight-tag">10% (0,10)</span></td>
                <td class="text-muted">Durasi Hari (Tanggal Selesai - Mulai)</td>
              </tr>
              <tr>
                <td class="fw-bold text-dark">C6</td>
                <td class="fw-semibold">Tingkat Kepuasan Klien / Owner</td>
                <td><span class="badge-benefit">Benefit</span></td>
                <td><span class="weight-tag">10% (0,10)</span></td>
                <td class="text-muted">Rating Kepuasan Pengguna / Owner (Skor 1 - 3)</td>
              </tr>
              <tr>
                <td class="fw-bold text-dark">C7</td>
                <td class="fw-semibold">Penerapan K3 & Keselamatan Kerja</td>
                <td><span class="badge-benefit">Benefit</span></td>
                <td><span class="weight-tag">10% (0,10)</span></td>
                <td class="text-muted">Kepatuhan Standar SMKK & Zero Accident (Skor 1 - 3)</td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>

      <!-- Ambang Batas Kinerja Ringkas -->
      <div class="row g-3">
        <div class="col-md-4">
          <div class="status-strip-card d-flex align-items-center justify-content-between">
            <div>
              <div class="fw-bold text-success mb-1">Kategori: Baik</div>
              <div class="text-muted small">Skor Preferensi Akhir &ge; 0,80</div>
            </div>
            <i class="bi bi-check-circle-fill text-success fs-4"></i>
          </div>
        </div>
        <div class="col-md-4">
          <div class="status-strip-card d-flex align-items-center justify-content-between">
            <div>
              <div class="fw-bold text-warning mb-1" style="color: #b45309 !important;">Kategori: Perlu Perhatian</div>
              <div class="text-muted small">Skor Preferensi Akhir 0,60 s/d 0,79</div>
            </div>
            <i class="bi bi-exclamation-triangle-fill text-warning fs-4"></i>
          </div>
        </div>
        <div class="col-md-4">
          <div class="status-strip-card d-flex align-items-center justify-content-between">
            <div>
              <div class="fw-bold text-danger mb-1">Kategori: Berisiko</div>
              <div class="text-muted small">Skor Preferensi Akhir &lt; 0,60</div>
            </div>
            <i class="bi bi-x-circle-fill text-danger fs-4"></i>
          </div>
        </div>
      </div>

    </div>
  </section>

  <!-- Section Alur Penggunaan Sederhana -->
  <section class="section-py" id="alur">
    <div class="container">
      <div class="text-center">
        <h2 class="section-title">Alur Evaluasi Sederhana</h2>
        <p class="section-subtitle">
          Proses penilaian terintegrasi pada satu halaman tanpa konfigurasi periode yang rumit.
        </p>
      </div>

      <div class="row g-4">
        <div class="col-md-4">
          <div class="step-box">
            <div class="step-number">Langkah 01</div>
            <h6 class="fw-bold mb-2">Input Data Proyek</h6>
            <p class="text-muted small mb-0">
              Admin memasukkan nama proyek, pagu RAB, tanggal mulai & selesai, serta skor 7 kriteria dalam satu form modal terpadu.
            </p>
          </div>
        </div>
        <div class="col-md-4">
          <div class="step-box">
            <div class="step-number">Langkah 02</div>
            <h6 class="fw-bold mb-2">Kalkulasi Otomatis SAW</h6>
            <p class="text-muted small mb-0">
              Sistem memproses normalisasi matriks kriteria *Benefit* dan *Cost*, kemudian menjumlahkan skor terbobot secara instan.
            </p>
          </div>
        </div>
        <div class="col-md-4">
          <div class="step-box">
            <div class="step-number">Langkah 03</div>
            <h6 class="fw-bold mb-2">Lihat Ranking & Cetak PDF</h6>
            <p class="text-muted small mb-0">
              Hasil perankingan langsung ditampilkan pada tabel utama dan dapat diekspor menjadi laporan cetak PDF standar A4.
            </p>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Minimalist Footer -->
  <footer class="sipeko-footer">
    <div class="container">
      <div class="row gy-3 align-items-center">
        <div class="col-md-6 text-center text-md-start">
          <div class="fw-bold text-dark">SIPEKO &bull; PT Rancang Bangun Sedaya</div>
          <div class="small text-muted mt-1">
            Pasirmulya, Kec. Bogor Barat, Kota Bogor, Jawa Barat 16118
          </div>
        </div>
        <div class="col-md-6 text-center text-md-end">
          <div class="d-flex justify-content-center justify-content-md-end gap-3 small mb-1 flex-wrap">
            <a href="#tentang" class="footer-link">Tentang</a>
            <a href="#kriteria" class="footer-link">Kriteria</a>
            <a href="#alur" class="footer-link">Alur</a>
            <a href="https://rancangbangunkreasi.id/" target="_blank" rel="noopener noreferrer" class="footer-link">
              Profil Perusahaan <i class="bi bi-box-arrow-up-right small"></i>
            </a>
            <a href="<?= site_url('login') ?>" class="footer-link">Login Admin</a>
          </div>
          <div class="small text-muted">
            &copy; <?= date('Y') ?> PT Rancang Bangun Sedaya. All rights reserved.
          </div>
        </div>
      </div>
    </div>
  </footer>

  <!-- Bootstrap 5.3 JS Bundle -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
