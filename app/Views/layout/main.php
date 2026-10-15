<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= esc($title ?? 'SPK Kinerja Proyek') ?> &bull; PT Rancang Bangun Sedaya</title>
  
  <!-- Favicon / Brand Icon -->
  <link rel="icon" type="image/png" href="<?= base_url('images/logo-rbs-favicon.png') ?>">

  <!-- Bootstrap 5.3 CSS -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
  <!-- Bootstrap Icons -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
  <!-- Custom Design System -->
  <link rel="stylesheet" href="<?= base_url('css/custom.css') ?>">
</head>
<body>

  <!-- Sidebar -->
  <aside class="app-sidebar" id="appSidebar">
    <a href="<?= site_url('dashboard') ?>" class="sidebar-brand">
      <div class="p-1 rounded-2 me-1" style="background: rgba(255,255,255,0.06); border: 1px solid rgba(245,158,11,0.25);">
        <img src="<?= base_url('images/logo-rbs.png') ?>" alt="Logo PT Rancang Bangun Sedaya" style="max-height: 38px; width: auto; object-fit: contain;">
      </div>
      <div class="ms-1">
        <div class="brand-text-main">SPK PROYEK</div>
        <div class="brand-text-sub">Rancang Bangun Sedaya</div>
      </div>
    </a>

    <div class="sidebar-nav-container">
      <div class="nav-section-title">Menu Utama</div>
      
      <a href="<?= site_url('dashboard') ?>" class="nav-item-link <?= (url_is('dashboard') || url_is('')) ? 'active' : '' ?>">
        <i class="bi bi-speedometer2"></i>
        <span>Dashboard</span>
      </a>

      <div class="nav-section-title mt-2">Master Data</div>
      
      <a href="<?= site_url('proyek') ?>" class="nav-item-link <?= url_is('proyek*') ? 'active' : '' ?>">
        <i class="bi bi-buildings"></i>
        <span>Data Proyek</span>
      </a>

      <a href="<?= site_url('kriteria') ?>" class="nav-item-link <?= url_is('kriteria*') ? 'active' : '' ?>">
        <i class="bi bi-sliders"></i>
        <span>Kriteria & Bobot</span>
      </a>

      <div class="nav-section-title mt-2">Proses Penilaian</div>

      <a href="<?= site_url('periode') ?>" class="nav-item-link <?= (url_is('periode*') || url_is('penilaian*')) ? 'active' : '' ?>">
        <i class="bi bi-calendar-check"></i>
        <span>Periode Penilaian</span>
      </a>

      <div class="nav-section-title mt-2">Laporan & Analisis</div>

      <a href="<?= site_url('hasil') ?>" class="nav-item-link <?= url_is('hasil*') ? 'active' : '' ?>">
        <i class="bi bi-trophy"></i>
        <span>Hasil & Peringkat</span>
      </a>

      <a href="<?= site_url('riwayat') ?>" class="nav-item-link <?= url_is('riwayat*') ? 'active' : '' ?>">
        <i class="bi bi-clock-history"></i>
        <span>Riwayat Komparasi</span>
      </a>

      <div class="nav-section-title mt-2">Sistem</div>

      <a href="<?= site_url('users') ?>" class="nav-item-link <?= url_is('users*') ? 'active' : '' ?>">
        <i class="bi bi-people"></i>
        <span>Manajemen Pengguna</span>
      </a>
    </div>

    <div class="sidebar-footer">
      <div class="d-flex align-items-center justify-content-between">
        <div class="d-flex align-items-center gap-2">
          <div class="rounded-circle bg-warning text-dark fw-bold d-flex align-items-center justify-content-center" style="width:34px; height:34px; font-size:0.85rem;">
            <?= strtoupper(substr(session()->get('user_nama') ?? 'A', 0, 1)) ?>
          </div>
          <div>
            <div class="text-white small fw-bold text-truncate" style="max-width: 130px;"><?= esc(session()->get('user_nama') ?? 'Admin') ?></div>
            <div class="text-warning text-uppercase" style="font-size: 0.68rem; font-weight: 700;">Administrator</div>
          </div>
        </div>
        <a href="<?= site_url('logout') ?>" class="text-danger p-1" title="Keluar / Logout">
          <i class="bi bi-box-arrow-right fs-5"></i>
        </a>
      </div>
    </div>
  </aside>

  <!-- App Wrapper -->
  <div class="app-wrapper">
    <!-- Topbar -->
    <header class="app-topbar">
      <div class="d-flex align-items-center gap-3">
        <button class="btn btn-sm btn-outline-secondary d-lg-none" id="sidebarToggleBtn" type="button">
          <i class="bi bi-list fs-5"></i>
        </button>
        <div>
          <h1 class="topbar-title"><?= esc($page_title ?? 'SPK Kinerja Proyek') ?></h1>
          <p class="topbar-subtitle">Metode Simple Additive Weighting (SAW) &bull; PT Rancang Bangun Sedaya</p>
        </div>
      </div>

      <div class="d-flex align-items-center gap-3">
        <span class="badge bg-light text-dark border px-3 py-2 d-none d-md-inline-flex align-items-center gap-2">
          <i class="bi bi-shield-check text-primary"></i>
          <span>Peran: <strong>Administrator</strong></span>
        </span>
        <a href="<?= site_url('logout') ?>" class="btn btn-sm btn-outline-danger">
          <i class="bi bi-box-arrow-right me-1"></i> Keluar
        </a>
      </div>
    </header>

    <!-- Main Content Area -->
    <main class="app-content">
      <!-- Alerts -->
      <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success alert-dismissible fade show d-flex align-items-center gap-2 shadow-sm border-success-subtle" role="alert">
          <i class="bi bi-check-circle-fill fs-5 text-success"></i>
          <div><?= session()->getFlashdata('success') ?></div>
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
      <?php endif; ?>

      <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger alert-dismissible fade show d-flex align-items-center gap-2 shadow-sm border-danger-subtle" role="alert">
          <i class="bi bi-exclamation-triangle-fill fs-5 text-danger"></i>
          <div><?= session()->getFlashdata('error') ?></div>
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
      <?php endif; ?>

      <?php if (session()->getFlashdata('errors')): ?>
        <div class="alert alert-danger alert-dismissible fade show shadow-sm border-danger-subtle" role="alert">
          <div class="fw-bold mb-1"><i class="bi bi-exclamation-octagon-fill me-1"></i> Terjadi Kesalahan Validasi:</div>
          <ul class="mb-0 ps-3">
            <?php foreach (session()->getFlashdata('errors') as $err): ?>
              <li><?= esc($err) ?></li>
            <?php endforeach; ?>
          </ul>
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
      <?php endif; ?>

      <?= $this->renderSection('content') ?>
    </main>

    <!-- Footer -->
    <footer class="py-3 px-4 text-center text-muted border-top bg-white small">
      &copy; <?= date('Y') ?> PT Rancang Bangun Sedaya &bull; Sistem Pendukung Keputusan Kinerja Proyek Konstruksi
    </footer>
  </div>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    // Toggle sidebar on mobile
    const sidebarToggleBtn = document.getElementById('sidebarToggleBtn');
    const appSidebar = document.getElementById('appSidebar');
    if (sidebarToggleBtn && appSidebar) {
      sidebarToggleBtn.addEventListener('click', () => {
        appSidebar.classList.toggle('show');
      });
    }
  </script>
  <?= $this->renderSection('scripts') ?>
</body>
</html>
