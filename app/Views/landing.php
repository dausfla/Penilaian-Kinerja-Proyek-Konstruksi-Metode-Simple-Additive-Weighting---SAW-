<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Selamat Datang &bull; SPK Kinerja Proyek PT Rancang Bangun Sedaya</title>
  
  <!-- Favicon Logo RBS -->
  <link rel="icon" type="image/png" href="<?= base_url('images/logo-rbs-favicon.png') ?>">

  <!-- Bootstrap 5.3 CSS -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
  <!-- Bootstrap Icons -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
  <!-- Google Fonts: Plus Jakarta Sans -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
  <!-- Custom Design System -->
  <link rel="stylesheet" href="<?= base_url('css/custom.css') ?>">

  <style>
    :root {
      --primary-navy: #0f172a;
      --deep-navy: #090d16;
      --card-navy: #1e293b;
      --gold-500: #f59e0b;
      --gold-600: #d97706;
      --gold-soft: #fef3c7;
      --gold-border: rgba(245, 158, 11, 0.35);
      --slate-muted: #64748b;
      --slate-dark: #1e293b;
      --slate-body: #334155;
      --benefit-green: #059669;
      --benefit-bg: #ecfdf5;
      --cost-rose: #e11d48;
      --cost-bg: #fff1f2;
    }

    html {
      scroll-behavior: smooth;
    }

    body {
      font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
      background-color: #f8fafc;
      color: var(--slate-body);
      overflow-x: hidden;
    }

    /* Navbar Styling */
    .landing-navbar {
      background: rgba(9, 13, 22, 0.94);
      backdrop-filter: blur(16px);
      -webkit-backdrop-filter: blur(16px);
      border-bottom: 1px solid rgba(255, 255, 255, 0.08);
      transition: all 0.3s ease;
      z-index: 1050;
    }

    .nav-brand-container {
      display: flex;
      align-items: center;
      gap: 0.85rem;
      text-decoration: none;
    }

    .nav-logo-box {
      background: rgba(255, 255, 255, 0.04);
      border: 1px solid rgba(245, 158, 11, 0.25);
      padding: 4px 8px;
      border-radius: 10px;
      display: flex;
      align-items: center;
      justify-content: center;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.25);
    }

    .nav-logo-img {
      height: 44px;
      width: auto;
      object-fit: contain;
    }

    .nav-brand-title {
      font-weight: 800;
      color: #ffffff;
      font-size: 1.05rem;
      letter-spacing: 0.5px;
      line-height: 1.2;
    }

    .nav-brand-sub {
      color: var(--gold-500);
      font-size: 0.72rem;
      font-weight: 700;
      letter-spacing: 0.75px;
      text-transform: uppercase;
    }

    .nav-link-custom {
      color: #cbd5e1 !important;
      font-weight: 500;
      font-size: 0.9rem;
      padding: 0.5rem 0.9rem !important;
      border-radius: 8px;
      transition: all 0.2s ease;
    }

    .nav-link-custom:hover {
      color: #ffffff !important;
      background: rgba(255, 255, 255, 0.06);
    }

    .btn-gold-cta {
      background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
      color: #090d16 !important;
      font-weight: 700;
      font-size: 0.875rem;
      padding: 0.55rem 1.35rem;
      border-radius: 10px;
      border: none;
      box-shadow: 0 4px 14px rgba(245, 158, 11, 0.35);
      transition: all 0.25s ease;
      display: inline-flex;
      align-items: center;
      gap: 0.5rem;
      text-decoration: none;
    }

    .btn-gold-cta:hover {
      background: linear-gradient(135deg, #fbbf24 0%, #f59e0b 100%);
      transform: translateY(-2px);
      box-shadow: 0 6px 20px rgba(245, 158, 11, 0.45);
      color: #000000 !important;
    }

    /* Hero Section */
    .landing-hero {
      background: 
        radial-gradient(circle at 50% 15%, rgba(245, 158, 11, 0.15) 0%, transparent 60%),
        radial-gradient(circle at 80% 80%, rgba(14, 165, 233, 0.08) 0%, transparent 50%),
        linear-gradient(180deg, #090d16 0%, #0f172a 65%, #1e293b 100%);
      color: #ffffff;
      padding: 5rem 1rem 5.5rem;
      position: relative;
    }

    .hero-badge {
      display: inline-flex;
      align-items: center;
      gap: 0.5rem;
      background: rgba(245, 158, 11, 0.12);
      border: 1px solid rgba(245, 158, 11, 0.35);
      color: #fbbf24;
      padding: 0.45rem 1.25rem;
      border-radius: 9999px;
      font-size: 0.825rem;
      font-weight: 600;
      letter-spacing: 0.3px;
      margin-bottom: 2rem;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
    }

    .hero-logo-card {
      display: inline-flex;
      align-items: center;
      justify-content: center;
      background: rgba(255, 255, 255, 0.04);
      border: 1px solid rgba(245, 158, 11, 0.28);
      border-radius: 20px;
      padding: 1.25rem 2.25rem;
      box-shadow: 0 20px 45px -10px rgba(0, 0, 0, 0.6), 0 0 35px rgba(245, 158, 11, 0.12);
      backdrop-filter: blur(12px);
      -webkit-backdrop-filter: blur(12px);
      margin-bottom: 2.25rem;
      transition: transform 0.3s ease;
    }

    .hero-logo-card:hover {
      transform: scale(1.02);
    }

    .hero-logo-img {
      max-height: 95px;
      width: auto;
      object-fit: contain;
      filter: drop-shadow(0 6px 14px rgba(0, 0, 0, 0.45));
    }

    .hero-title {
      font-size: clamp(2rem, 4.5vw, 3.25rem);
      font-weight: 800;
      letter-spacing: -0.75px;
      line-height: 1.2;
      color: #ffffff;
      max-width: 860px;
      margin: 0 auto 1.25rem;
    }

    .text-gradient-gold {
      background: linear-gradient(135deg, #ffffff 30%, #fcd34d 70%, #f59e0b 100%);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
    }

    .hero-subtitle {
      font-size: 1.1rem;
      color: #94a3b8;
      max-width: 740px;
      margin: 0 auto 2.25rem;
      line-height: 1.65;
    }

    .btn-hero-primary {
      background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
      color: #090d16 !important;
      font-weight: 700;
      font-size: 1.05rem;
      padding: 0.85rem 2rem;
      border-radius: 12px;
      border: none;
      box-shadow: 0 8px 25px rgba(245, 158, 11, 0.4);
      transition: all 0.25s ease;
      display: inline-flex;
      align-items: center;
      gap: 0.6rem;
      text-decoration: none;
    }

    .btn-hero-primary:hover {
      background: linear-gradient(135deg, #fbbf24 0%, #f59e0b 100%);
      transform: translateY(-2px);
      box-shadow: 0 12px 30px rgba(245, 158, 11, 0.5);
      color: #000000 !important;
    }

    .btn-hero-secondary {
      background: rgba(255, 255, 255, 0.08);
      color: #ffffff !important;
      font-weight: 600;
      font-size: 1.05rem;
      padding: 0.85rem 1.85rem;
      border-radius: 12px;
      border: 1px solid rgba(255, 255, 255, 0.2);
      transition: all 0.25s ease;
      display: inline-flex;
      align-items: center;
      gap: 0.6rem;
      text-decoration: none;
      backdrop-filter: blur(8px);
    }

    .btn-hero-secondary:hover {
      background: rgba(255, 255, 255, 0.15);
      border-color: rgba(255, 255, 255, 0.4);
      color: #ffffff !important;
      transform: translateY(-2px);
    }

    /* Stats Quick Bar */
    .hero-stats-bar {
      margin-top: 3.5rem;
      padding-top: 2.25rem;
      border-top: 1px solid rgba(255, 255, 255, 0.1);
    }

    .stat-pill {
      background: rgba(255, 255, 255, 0.03);
      border: 1px solid rgba(255, 255, 255, 0.08);
      border-radius: 14px;
      padding: 1rem 1.25rem;
      text-align: center;
      height: 100%;
      transition: transform 0.2s ease, border-color 0.2s ease;
    }

    .stat-pill:hover {
      border-color: rgba(245, 158, 11, 0.35);
      background: rgba(255, 255, 255, 0.05);
      transform: translateY(-2px);
    }

    .stat-pill-num {
      font-size: 1.4rem;
      font-weight: 800;
      color: #f8fafc;
      margin-bottom: 0.2rem;
    }

    .stat-pill-label {
      font-size: 0.775rem;
      color: #94a3b8;
      font-weight: 500;
      text-transform: uppercase;
      letter-spacing: 0.5px;
    }

    /* Section Headers */
    .section-badge {
      display: inline-flex;
      align-items: center;
      gap: 0.4rem;
      background: var(--gold-soft);
      border: 1px solid #fde68a;
      color: #92400e;
      font-size: 0.75rem;
      font-weight: 700;
      text-transform: uppercase;
      letter-spacing: 0.75px;
      padding: 0.35rem 1rem;
      border-radius: 9999px;
      margin-bottom: 0.85rem;
    }

    .section-title {
      font-size: clamp(1.75rem, 3vw, 2.35rem);
      font-weight: 800;
      color: var(--primary-navy);
      letter-spacing: -0.5px;
      margin-bottom: 0.75rem;
    }

    .section-desc {
      font-size: 1rem;
      color: var(--slate-muted);
      max-width: 650px;
      margin: 0 auto;
      line-height: 1.6;
    }

    /* Criteria Cards */
    .criteria-card {
      background: #ffffff;
      border-radius: 16px;
      border: 1px solid #e2e8f0;
      padding: 1.85rem;
      height: 100%;
      display: flex;
      flex-direction: column;
      position: relative;
      overflow: hidden;
      box-shadow: 0 4px 6px -1px rgba(15, 23, 42, 0.04), 0 2px 4px -2px rgba(15, 23, 42, 0.03);
      transition: all 0.25s ease;
    }

    .criteria-card:hover {
      transform: translateY(-5px);
      box-shadow: 0 20px 25px -5px rgba(15, 23, 42, 0.08), 0 8px 10px -6px rgba(15, 23, 42, 0.04);
      border-color: #cbd5e1;
    }

    .criteria-card::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      height: 4px;
    }

    .card-benefit::before {
      background: linear-gradient(90deg, #059669 0%, #10b981 100%);
    }

    .card-cost::before {
      background: linear-gradient(90deg, #e11d48 0%, #f43f5e 100%);
    }

    .criteria-header {
      display: flex;
      align-items: center;
      justify-content: space-between;
      margin-bottom: 1.25rem;
    }

    .criteria-code-badge {
      background: #0f172a;
      color: #f59e0b;
      font-weight: 800;
      font-size: 0.85rem;
      padding: 0.35rem 0.75rem;
      border-radius: 8px;
      display: inline-flex;
      align-items: center;
      gap: 0.35rem;
    }

    .criteria-weight-badge {
      background: #fef3c7;
      color: #92400e;
      border: 1px solid #fde68a;
      font-weight: 700;
      font-size: 0.8rem;
      padding: 0.35rem 0.85rem;
      border-radius: 9999px;
    }

    .criteria-title {
      font-size: 1.15rem;
      font-weight: 700;
      color: #0f172a;
      margin-bottom: 0.5rem;
      line-height: 1.35;
    }

    .criteria-type-badge {
      display: inline-flex;
      align-items: center;
      gap: 0.35rem;
      font-size: 0.75rem;
      font-weight: 600;
      padding: 0.25rem 0.65rem;
      border-radius: 6px;
      margin-bottom: 1rem;
    }

    .type-benefit {
      background: var(--benefit-bg);
      color: var(--benefit-green);
      border: 1px solid #a7f3d0;
    }

    .type-cost {
      background: var(--cost-bg);
      color: var(--cost-rose);
      border: 1px solid #fecdd3;
    }

    .criteria-text {
      font-size: 0.9rem;
      color: #475569;
      line-height: 1.6;
      margin-bottom: 1.25rem;
      flex-grow: 1;
    }

    .criteria-formula-box {
      background: #f8fafc;
      border: 1px dashed #cbd5e1;
      border-radius: 10px;
      padding: 0.65rem 0.85rem;
      font-size: 0.8rem;
      color: #334155;
      display: flex;
      align-items: center;
      gap: 0.5rem;
    }

    /* Category Cards */
    .category-card {
      background: #ffffff;
      border-radius: 16px;
      padding: 1.75rem;
      height: 100%;
      border: 1px solid #e2e8f0;
      transition: transform 0.2s ease;
    }

    .category-card:hover {
      transform: translateY(-4px);
    }

    .category-icon {
      width: 48px;
      height: 48px;
      border-radius: 12px;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 1.35rem;
      margin-bottom: 1.15rem;
    }

    /* Workflow Cards */
    .step-card {
      background: #ffffff;
      border: 1px solid #e2e8f0;
      border-radius: 16px;
      padding: 2.25rem 1.5rem;
      text-align: center;
      height: 100%;
      position: relative;
      box-shadow: 0 2px 4px rgba(15, 23, 42, 0.03);
      transition: all 0.25s ease;
    }

    .step-card:hover {
      transform: translateY(-4px);
      box-shadow: 0 15px 30px -5px rgba(15, 23, 42, 0.08);
      border-color: #cbd5e1;
    }

    .step-badge {
      width: 48px;
      height: 48px;
      border-radius: 14px;
      background: #0f172a;
      color: #f59e0b;
      font-size: 1.25rem;
      font-weight: 800;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      margin-bottom: 1.25rem;
      box-shadow: 0 4px 10px rgba(15, 23, 42, 0.2);
    }

    /* CTA Section */
    .cta-banner {
      background: linear-gradient(135deg, #090d16 0%, #0f172a 60%, #1e293b 100%);
      color: #ffffff;
      padding: 4.5rem 1rem;
      position: relative;
      border-top: 1px solid rgba(255, 255, 255, 0.08);
      border-bottom: 1px solid rgba(255, 255, 255, 0.08);
    }

    /* Footer */
    .landing-footer {
      background: linear-gradient(180deg, #0b1120 0%, #050811 100%);
      color: #e2e8f0;
      padding: 3.5rem 1rem 2.25rem;
      font-size: 0.9rem;
      border-top: 1px solid rgba(255, 255, 255, 0.12);
    }

    .footer-desc-text {
      color: #cbd5e1 !important;
      font-size: 0.885rem;
      line-height: 1.6;
    }

    .footer-link {
      color: #f1f5f9 !important;
      font-weight: 500;
      text-decoration: none;
      transition: all 0.2s ease;
      padding: 0.25rem 0.5rem;
      border-radius: 6px;
    }

    .footer-link:hover {
      color: #fbbf24 !important;
      background: rgba(255, 255, 255, 0.08);
    }

    .footer-link-admin {
      color: #090d16 !important;
      background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
      padding: 0.35rem 0.9rem;
      border-radius: 8px;
      font-weight: 700;
      text-decoration: none;
      box-shadow: 0 2px 8px rgba(245, 158, 11, 0.3);
      display: inline-flex;
      align-items: center;
      gap: 0.35rem;
      transition: all 0.2s ease;
    }

    .footer-link-admin:hover {
      background: linear-gradient(135deg, #fbbf24 0%, #f59e0b 100%);
      transform: translateY(-1px);
      box-shadow: 0 4px 12px rgba(245, 158, 11, 0.45);
      color: #000000 !important;
    }

    .footer-bullet {
      color: #f59e0b;
      font-weight: bold;
      opacity: 0.85;
      padding: 0 0.15rem;
    }

    .footer-policy-note {
      color: #cbd5e1 !important;
      font-size: 0.8rem;
    }

    .footer-copyright {
      color: #e2e8f0 !important;
      font-size: 0.85rem;
      border-top: 1px solid rgba(255, 255, 255, 0.12) !important;
      padding-top: 1.25rem;
      text-align: center;
    }
  </style>
</head>
<body>

  <!-- Sticky Navbar -->
  <nav class="navbar navbar-expand-lg landing-navbar sticky-top">
    <div class="container py-1">
      <a class="nav-brand-container" href="<?= site_url('/') ?>">
        <div class="nav-logo-box">
          <img src="<?= base_url('images/logo-rbs.png') ?>" alt="Logo PT Rancang Bangun Sedaya" class="nav-logo-img">
        </div>
        <div>
          <div class="nav-brand-title">SPK KINERJA PROYEK</div>
          <div class="nav-brand-sub">PT Rancang Bangun Sedaya</div>
        </div>
      </a>

      <button class="navbar-toggler border-0 text-white" type="button" data-bs-toggle="collapse" data-bs-target="#landingNav" aria-controls="landingNav" aria-expanded="false" aria-label="Toggle navigation">
        <i class="bi bi-list fs-2 text-warning"></i>
      </button>

      <div class="collapse navbar-collapse" id="landingNav">
        <ul class="navbar-nav mx-auto mb-2 mb-lg-0 py-2 py-lg-0">
          <li class="nav-item">
            <a class="nav-link nav-link-custom" href="<?= site_url('/') ?>">Beranda</a>
          </li>
          <li class="nav-item">
            <a class="nav-link nav-link-custom" href="#kriteria">7 Kriteria</a>
          </li>
          <li class="nav-item">
            <a class="nav-link nav-link-custom" href="#kategori">Kategori Kinerja</a>
          </li>
          <li class="nav-item">
            <a class="nav-link nav-link-custom" href="#alur-kerja">Alur Evaluasi</a>
          </li>
        </ul>

        <div class="d-flex align-items-center gap-2 pt-2 pt-lg-0">
          <?php if ($isLoggedIn): ?>
            <a href="<?= site_url('dashboard') ?>" class="btn-gold-cta">
              <i class="bi bi-speedometer2"></i>
              <span>Buka Dashboard</span>
            </a>
          <?php else: ?>
            <a href="<?= site_url('login') ?>" class="btn-gold-cta">
              <i class="bi bi-shield-lock-fill"></i>
              <span>Masuk ke Sistem</span>
            </a>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </nav>

  <!-- Hero Section -->
  <section class="landing-hero text-center">
    <div class="container position-relative">
      <div class="hero-badge">
        <i class="bi bi-patch-check-fill text-warning"></i>
        <span>Sistem Pendukung Keputusan Resmi &bull; Metode SAW (Simple Additive Weighting)</span>
      </div>

      <!-- Featured Logo Showcase -->
      <div class="d-block">
        <div class="hero-logo-card">
          <img src="<?= base_url('images/logo-rbs.png') ?>" alt="Logo PT Rancang Bangun Sedaya" class="hero-logo-img">
        </div>
      </div>

      <h1 class="hero-title">
        Evaluasi Objektif & Terukur <br class="d-none d-md-block">
        <span class="text-gradient-gold">Kinerja Proyek Konstruksi</span>
      </h1>

      <p class="hero-subtitle">
        Platform evaluasi kinerja proyek konstruksi di lingkungan <strong>PT Rancang Bangun Sedaya</strong>. Menilai realisasi Kurva S, efisiensi pagu RAB, dokumentasi foto fisik lapangan, kualitas BAST, dan ketepatan waktu serah terima secara transparan, akurat, dan dapat dipertanggungjawabkan.
      </p>

      <div class="d-flex flex-wrap justify-content-center gap-3">
        <?php if ($isLoggedIn): ?>
          <a href="<?= site_url('dashboard') ?>" class="btn-hero-primary">
            <i class="bi bi-speedometer2 fs-5"></i>
            <span>Buka Dashboard Utama (<?= esc($userNama) ?>)</span>
          </a>
        <?php else: ?>
          <a href="<?= site_url('login') ?>" class="btn-hero-primary">
            <i class="bi bi-box-arrow-in-right fs-5"></i>
            <span>Masuk ke Sistem (Administrator)</span>
          </a>
        <?php endif; ?>
        <a href="#kriteria" class="btn-hero-secondary">
          <i class="bi bi-sliders fs-5"></i>
          <span>Pelajari Kriteria Evaluasi</span>
        </a>
      </div>

      <!-- Quick Metrics Bar -->
      <div class="hero-stats-bar">
        <div class="row g-3 justify-content-center">
          <div class="col-6 col-md-3">
            <div class="stat-pill">
              <div class="stat-pill-num text-warning">5 Aspek</div>
              <div class="stat-pill-label">Kriteria Terukur</div>
            </div>
          </div>
          <div class="col-6 col-md-3">
            <div class="stat-pill">
              <div class="stat-pill-num text-success">100%</div>
              <div class="stat-pill-label">Total Bobot SAW</div>
            </div>
          </div>
          <div class="col-6 col-md-3">
            <div class="stat-pill">
              <div class="stat-pill-num text-info">3 Status</div>
              <div class="stat-pill-label">Kategori Kinerja</div>
            </div>
          </div>
          <div class="col-6 col-md-3">
            <div class="stat-pill">
              <div class="stat-pill-num text-white">Format A4</div>
              <div class="stat-pill-label">Ekspor Laporan PDF</div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- 7 Kriteria Section -->
  <section class="py-5" id="kriteria">
    <div class="container py-4">
      <div class="text-center mb-5">
        <div class="section-badge">
          <i class="bi bi-clipboard2-check-fill me-1"></i> Standar Evaluasi Objektif
        </div>
        <h2 class="section-title">7 Kriteria Penilaian Kinerja Proyek</h2>
        <p class="section-desc">
          Evaluasi berpedoman pada data kuantitatif jadwal, efisiensi anggaran, mutu visual, kepuasan klien, dan keselamatan kerja (K3) dengan total pembobotan tepat 100%.
        </p>
      </div>

      <!-- Row 1: C1, C2, C3 -->
      <div class="row g-4 mb-4">
        <!-- C1 -->
        <div class="col-lg-4 col-md-6">
          <div class="criteria-card card-benefit">
            <div class="criteria-header">
              <span class="criteria-code-badge"><i class="bi bi-graph-up-arrow"></i> C1</span>
              <span class="criteria-weight-badge">Bobot: 20%</span>
            </div>
            <h3 class="criteria-title">Mutu & Kualitas Hasil Fisik</h3>
            <div>
              <span class="criteria-type-badge type-benefit">
                <i class="bi bi-arrow-up-circle-fill"></i> Jenis: Keuntungan (Benefit)
              </span>
            </div>
            <p class="criteria-text">
              Mengukur tingkat kerapihan finishing, presisi struktur, dan mutu fisik hasil pekerjaan konstruksi (Skala 1 s.d. 5). Semakin tinggi mutu fisik bangunan, skor penilaian kinerja semakin maksimal.
            </p>
            <div class="criteria-formula-box">
              <i class="bi bi-star-fill text-warning"></i>
              <span>Skala: <strong>Skor 1 - 5 (Finishing & Struktur)</strong></span>
            </div>
          </div>
        </div>

        <!-- C2 -->
        <div class="col-lg-4 col-md-6">
          <div class="criteria-card card-cost">
            <div class="criteria-header">
              <span class="criteria-code-badge"><i class="bi bi-cash-stack"></i> C2</span>
              <span class="criteria-weight-badge">Bobot: 20%</span>
            </div>
            <h3 class="criteria-title">Realisasi Biaya terhadap RAB</h3>
            <div>
              <span class="criteria-type-badge type-cost">
                <i class="bi bi-arrow-down-circle-fill"></i> Jenis: Biaya / Risiko (Cost)
              </span>
            </div>
            <p class="criteria-text">
              Rasio pengeluaran riil terhadap pagu anggaran biaya rencana (RAB). Proyek yang mampu mengendalikan biaya secara efisien tanpa pemborosan memperoleh nilai tertinggi.
            </p>
            <div class="criteria-formula-box">
              <i class="bi bi-calculator text-muted"></i>
              <span>Rumus: <strong>(Realisasi / Pagu RAB) &times; 100%</strong></span>
            </div>
          </div>
        </div>

        <!-- C3 -->
        <div class="col-lg-4 col-md-12">
          <div class="criteria-card card-benefit">
            <div class="criteria-header">
              <span class="criteria-code-badge"><i class="bi bi-camera-fill"></i> C3</span>
              <span class="criteria-weight-badge">Bobot: 15%</span>
            </div>
            <h3 class="criteria-title">Dokumentasi Foto Progres Lapangan</h3>
            <div>
              <span class="criteria-type-badge type-benefit">
                <i class="bi bi-arrow-up-circle-fill"></i> Jenis: Keuntungan (Benefit)
              </span>
            </div>
            <p class="criteria-text">
              Bukti visual autentik pelaksanaan fisik di lapangan (Skala 1–5). Menggantikan dokumen kontrak legal guna melindungi kerahasiaan operasional klien dan mitra kerja.
            </p>
            <div class="criteria-formula-box">
              <i class="bi bi-award text-muted"></i>
              <span>Standar: <strong>Rubrik Kerapihan Foto (Skor 1 - 5)</strong></span>
            </div>
          </div>
        </div>
      </div>

      <!-- Row 2: C4, C5 -->
      <div class="row g-4 mb-4">
        <!-- C4 -->
        <div class="col-lg-6 col-md-6">
          <div class="criteria-card card-benefit">
            <div class="criteria-header">
              <span class="criteria-code-badge"><i class="bi bi-file-earmark-check-fill"></i> C4</span>
              <span class="criteria-weight-badge">Bobot: 15%</span>
            </div>
            <h3 class="criteria-title">Ketepatan & Kualitas BAST</h3>
            <div>
              <span class="criteria-type-badge type-benefit">
                <i class="bi bi-arrow-up-circle-fill"></i> Jenis: Keuntungan (Benefit)
              </span>
            </div>
            <p class="criteria-text">
              Kualitas Berita Acara Serah Terima pekerjaan (Skala 1–5), mengukur apakah serah terima ditandatangani sesuai jadwal dan bebas dari catatan perbaikan cacat mutu.
            </p>
            <div class="criteria-formula-box">
              <i class="bi bi-check-circle text-muted"></i>
              <span>Standar: <strong>Rubrik Mutu Administrasi (Skor 1 - 5)</strong></span>
            </div>
          </div>
        </div>

        <!-- C5 -->
        <div class="col-lg-6 col-md-6">
          <div class="criteria-card card-cost">
            <div class="criteria-header">
              <span class="criteria-code-badge"><i class="bi bi-clock-history"></i> C5</span>
              <span class="criteria-weight-badge">Bobot: 10%</span>
            </div>
            <h3 class="criteria-title">Waktu / Durasi Penyelesaian Proyek</h3>
            <div>
              <span class="criteria-type-badge type-cost">
                <i class="bi bi-arrow-down-circle-fill"></i> Jenis: Biaya / Risiko (Cost)
              </span>
            </div>
            <p class="criteria-text">
              Jumlah hari pelaksanaan proyek dihitung otomatis dari Tanggal Mulai ke Tanggal Selesai. Proyek yang selesai lebih cepat dan efisien memperoleh nilai kinerja waktu lebih tinggi.
            </p>
            <div class="criteria-formula-box">
              <i class="bi bi-hourglass-split text-muted"></i>
              <span>Rumus: <strong>(Tanggal Selesai - Tanggal Mulai) Hari</strong></span>
            </div>
          </div>
        </div>
      </div>

      <!-- Row 3: C6, C7 -->
      <div class="row g-4">
        <!-- C6 -->
        <div class="col-lg-6 col-md-6">
          <div class="criteria-card card-benefit">
            <div class="criteria-header">
              <span class="criteria-code-badge"><i class="bi bi-star-fill text-warning"></i> C6</span>
              <span class="criteria-weight-badge">Bobot: 10%</span>
            </div>
            <h3 class="criteria-title">Tingkat Kepuasan Klien / Owner</h3>
            <div>
              <span class="criteria-type-badge type-benefit">
                <i class="bi bi-arrow-up-circle-fill"></i> Jenis: Keuntungan (Benefit)
              </span>
            </div>
            <p class="criteria-text">
              Evaluasi kepuasan pemilik proyek terhadap kualitas hasil fisik bangunan, kerapihan pengerjaan, dan pelayanan komunikasi kontraktor.
            </p>
            <div class="criteria-formula-box">
              <i class="bi bi-emoji-smile text-muted"></i>
              <span>Standar: <strong>Rating Kepuasan Klien (Skor 1 - 5)</strong></span>
            </div>
          </div>
        </div>

        <!-- C7 -->
        <div class="col-lg-6 col-md-6">
          <div class="criteria-card card-benefit">
            <div class="criteria-header">
              <span class="criteria-code-badge"><i class="bi bi-shield-fill-check text-success"></i> C7</span>
              <span class="criteria-weight-badge">Bobot: 10%</span>
            </div>
            <h3 class="criteria-title">Penerapan K3 & Keselamatan Kerja</h3>
            <div>
              <span class="criteria-type-badge type-benefit">
                <i class="bi bi-arrow-up-circle-fill"></i> Jenis: Keuntungan (Benefit)
              </span>
            </div>
            <p class="criteria-text">
              Kepatuhan terhadap Sistem Manajemen Keselamatan Konstruksi (SMKK): pencapaian Zero Accident, kedisiplinan pemakaian APD, dan keamanan area tapak proyek.
            </p>
            <div class="criteria-formula-box">
              <i class="bi bi-shield-check text-muted"></i>
              <span>Standar: <strong>Rubrik Kepatuhan K3 & HSE (Skor 1 - 5)</strong></span>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Kategori Kinerja Section -->
  <section class="py-5 bg-white border-top border-bottom" id="kategori">
    <div class="container py-4">
      <div class="text-center mb-5">
        <div class="section-badge">
          <i class="bi bi-bar-chart-steps me-1"></i> Klasifikasi Kinerja
        </div>
        <h2 class="section-title">3 Kategori Pemetaan Kinerja Proyek</h2>
        <p class="section-desc">
          Setelah seluruh nilai kriteria dikalkulasikan dengan metode SAW, proyek dipetakan ke dalam 3 status kinerja untuk menentukan rekomendasi tindak lanjut manajerial.
        </p>
      </div>

      <div class="row g-4">
        <!-- Kategori Baik -->
        <div class="col-md-4">
          <div class="category-card" style="border-top: 4px solid #059669;">
            <div class="category-icon bg-success-subtle text-success">
              <i class="bi bi-check-circle-fill"></i>
            </div>
            <span class="badge bg-success-subtle text-success border border-success-subtle px-3 py-1 mb-2 fw-bold">Skor 0,80 ke Atas</span>
            <h4 class="fw-bold text-dark mt-2 mb-2">Kategori Baik</h4>
            <p class="text-muted small mb-0">
              Proyek berjalan optimal sesuai kurva S, pengeluaran terkendali di bawah pagu RAB, dokumentasi foto lapangan lengkap, dan serah terima tepat waktu.
            </p>
          </div>
        </div>

        <!-- Kategori Perhatian -->
        <div class="col-md-4">
          <div class="category-card" style="border-top: 4px solid #d97706;">
            <div class="category-icon bg-warning-subtle text-warning-emphasis">
              <i class="bi bi-exclamation-triangle-fill"></i>
            </div>
            <span class="badge bg-warning-subtle text-warning-emphasis border border-warning-subtle px-3 py-1 mb-2 fw-bold">Skor 0,60 s/d 0,79</span>
            <h4 class="fw-bold text-dark mt-2 mb-2">Perlu Perhatian</h4>
            <p class="text-muted small mb-0">
              Ditemukan deviasi ringan pada progres fisik, kenaikan biaya, atau keterlambatan waktu. Diperlukan evaluasi berkala pada site meeting mingguan.
            </p>
          </div>
        </div>

        <!-- Kategori Berisiko -->
        <div class="col-md-4">
          <div class="category-card" style="border-top: 4px solid #dc2626;">
            <div class="category-icon bg-danger-subtle text-danger">
              <i class="bi bi-shield-slash-fill"></i>
            </div>
            <span class="badge bg-danger-subtle text-danger border border-danger-subtle px-3 py-1 mb-2 fw-bold">Skor di Bawah 0,60</span>
            <h4 class="fw-bold text-dark mt-2 mb-2">Berisiko / Terlambat</h4>
            <p class="text-muted small mb-0">
              Prioritas penanganan segera! Perlu percepatan fisik (crashing jadwal), penambahan tenaga kerja, evaluasi kendala vendor, dan audit anggaran RAB.
            </p>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Alur Evaluasi Section -->
  <section class="py-5" id="alur-kerja">
    <div class="container py-4">
      <div class="text-center mb-5">
        <div class="section-badge">
          <i class="bi bi-diagram-3-fill me-1"></i> Alur Kerja Praktis
        </div>
        <h2 class="section-title">3 Langkah Mudah Proses Penilaian</h2>
        <p class="section-desc">
          Alur kerja sistematis yang dirancang untuk mempercepat pengawasan proyek dan mendukung pengambilan keputusan manajemen secara cepat.
        </p>
      </div>

      <div class="row g-4">
        <div class="col-md-4">
          <div class="step-card">
            <div class="step-badge">1</div>
            <h4 class="fw-bold text-dark mb-2">Input Data Lapangan</h4>
            <p class="text-muted small mb-0">
              Masukkan realisasi Kurva S, biaya riil, pilihan rubrik foto progres (1–5), mutu BAST (1–5), serta tanggal selesai melalui form praktis atau fitur edit cepat massal.
            </p>
          </div>
        </div>

        <div class="col-md-4">
          <div class="step-card">
            <div class="step-badge">2</div>
            <h4 class="fw-bold text-dark mb-2">Kalkulasi Otomatis SAW</h4>
            <p class="text-muted small mb-0">
              Cukup 1-klik tombol "Hitung SAW", algoritma otomatis menormalisasi skala kriteria keuntungan/biaya, menerapkan bobot, dan menyusun peringkat proyek.
            </p>
          </div>
        </div>

        <div class="col-md-4">
          <div class="step-card">
            <div class="step-badge">3</div>
            <h4 class="fw-bold text-dark mb-2">Rekomendasi & Cetak PDF</h4>
            <p class="text-muted small mb-0">
              Tinjau status proyek pada dashboard dan unduh laporan resmi berstandar kertas A4 lengkap dengan kop perusahaan dan kolom tanda tangan direksi.
            </p>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- CTA Banner Section -->
  <section class="cta-banner text-center">
    <div class="container position-relative">
      <div class="mb-3">
        <div class="hero-logo-card p-3 mb-0" style="background: rgba(255,255,255,0.06);">
          <img src="<?= base_url('images/logo-rbs.png') ?>" alt="Logo RBS" style="max-height: 60px;">
        </div>
      </div>
      <h2 class="display-6 fw-bold text-white mb-3">Siap Mengelola Evaluasi Kinerja Proyek?</h2>
      <p class="text-white-50 mx-auto mb-4" style="max-width: 620px; font-size: 1.05rem;">
        Masuk ke sistem menggunakan kredensial Administrator resmi untuk mengelola data proyek, mengatur periode penilaian, dan menerbitkan laporan evaluasi.
      </p>
      <div>
        <?php if ($isLoggedIn): ?>
          <a href="<?= site_url('dashboard') ?>" class="btn-hero-primary px-5 py-3">
            <i class="bi bi-speedometer2 fs-5"></i>
            <span>Buka Dashboard Utama</span>
          </a>
        <?php else: ?>
          <a href="<?= site_url('login') ?>" class="btn-hero-primary px-5 py-3">
            <i class="bi bi-shield-lock-fill fs-5"></i>
            <span>Masuk ke Halaman Login</span>
          </a>
        <?php endif; ?>
      </div>
    </div>
  </section>

  <!-- Footer -->
  <footer class="landing-footer">
    <div class="container">
      <div class="row g-4 align-items-center mb-4">
        <div class="col-lg-6 text-center text-lg-start">
          <div class="d-flex align-items-center justify-content-center justify-content-lg-start gap-3 mb-2">
            <div class="p-1 rounded-2" style="background: rgba(255, 255, 255, 0.08); border: 1px solid rgba(245, 158, 11, 0.35);">
              <img src="<?= base_url('images/logo-rbs.png') ?>" alt="Logo RBS" style="max-height: 46px; width: auto; object-fit: contain;">
            </div>
            <div>
              <div class="fw-bold text-white fs-6">PT RANCANG BANGUN SEDAYA</div>
              <div class="text-warning small fw-bold" style="font-size:0.78rem; letter-spacing: 0.5px;">Sistem Pendukung Keputusan Kinerja Proyek Konstruksi</div>
            </div>
          </div>
          <p class="footer-desc-text mb-0 mt-2">
            General Contractor, Architecture & Project Management. Evaluasi kinerja proyek berbasis metode Simple Additive Weighting (SAW).
          </p>
        </div>

        <div class="col-lg-6 text-center text-lg-end">
          <div class="d-flex flex-wrap justify-content-center justify-content-lg-end align-items-center gap-1 mb-2">
            <a href="<?= site_url('/') ?>" class="footer-link">Beranda</a>
            <span class="footer-bullet">&bull;</span>
            <a href="#kriteria" class="footer-link">7 Kriteria Evaluasi</a>
            <span class="footer-bullet">&bull;</span>
            <a href="#kategori" class="footer-link">Kategori Kinerja</a>
            <span class="footer-bullet">&bull;</span>
            <a href="#alur-kerja" class="footer-link">Alur Kerja</a>
            <span class="footer-bullet">&bull;</span>
            <a href="<?= site_url('login') ?>" class="footer-link-admin ms-1">
              <i class="bi bi-shield-lock-fill"></i>
              <span>Login Administrator</span>
            </a>
          </div>
          <div class="footer-policy-note mt-2">
            <i class="bi bi-patch-check-fill text-warning me-1"></i> Versi Produksi &bull; Dilindungi Kebijakan Kerahasiaan Perusahaan
          </div>
        </div>
      </div>

      <div class="footer-copyright">
        &copy; <?= date('Y') ?> PT Rancang Bangun Sedaya. Hak Cipta Dilindungi Undang-Undang.
      </div>
    </div>
  </footer>

  <!-- Bootstrap 5.3 Bundle JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
