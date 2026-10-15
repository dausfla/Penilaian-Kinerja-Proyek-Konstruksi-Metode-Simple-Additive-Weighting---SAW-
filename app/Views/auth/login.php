<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Masuk &bull; SPK Penilaian Kinerja Proyek PT Rancang Bangun Sedaya</title>
  <link rel="icon" type="image/png" href="<?= base_url('images/logo-rbs-favicon.png') ?>">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
  <link rel="stylesheet" href="<?= base_url('css/custom.css') ?>">
  <style>
    body {
      background: linear-gradient(135deg, #090d16 0%, #0f172a 50%, #1e293b 100%);
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 1.5rem;
    }
    .login-card {
      background: #ffffff;
      border-radius: var(--radius-lg);
      box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.45);
      width: 100%;
      max-width: 440px;
      overflow: hidden;
      border: 1px solid rgba(255, 255, 255, 0.1);
    }
    .login-header {
      background: linear-gradient(180deg, #0f172a 0%, #1e293b 100%);
      padding: 2.25rem 2rem 1.75rem;
      text-align: center;
      color: #fff;
      border-bottom: 3px solid var(--amber-500);
    }
    .login-body {
      padding: 2rem;
    }
  </style>
</head>
<body>

<div class="login-card">
  <div class="login-header">
    <div class="mb-3 text-center">
      <div class="d-inline-flex p-2 rounded-3" style="background: rgba(255,255,255,0.06); border: 1px solid rgba(245,158,11,0.28); box-shadow: 0 8px 16px rgba(0,0,0,0.3);">
        <img src="<?= base_url('images/logo-rbs.png') ?>" alt="Logo PT Rancang Bangun Sedaya" style="max-height: 68px; width: auto; object-fit: contain;">
      </div>
    </div>
    <h4 class="fw-bold mb-1 text-white">SPK Kinerja Proyek</h4>
    <p class="mb-0 text-white-50 small">PT Rancang Bangun Sedaya</p>
    <div class="badge bg-warning text-dark mt-2 px-3 py-1 fw-bold">Masuk Administrator</div>
  </div>

  <div class="login-body">
    <?php if (session()->getFlashdata('error')): ?>
      <div class="alert alert-danger py-2 small d-flex align-items-center gap-2 mb-3" role="alert">
        <i class="bi bi-exclamation-circle-fill text-danger"></i>
        <div><?= session()->getFlashdata('error') ?></div>
      </div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('success')): ?>
      <div class="alert alert-success py-2 small d-flex align-items-center gap-2 mb-3" role="alert">
        <i class="bi bi-check-circle-fill text-success"></i>
        <div><?= session()->getFlashdata('success') ?></div>
      </div>
    <?php endif; ?>

    <form action="<?= site_url('login/process') ?>" method="post">
      <?= csrf_field() ?>

      <div class="mb-3">
        <label for="username" class="form-label small fw-bold text-secondary">Username</label>
        <div class="input-group">
          <span class="input-group-text bg-light border-end-0 text-muted"><i class="bi bi-person"></i></span>
          <input type="text" class="form-control border-start-0" id="username" name="username" required placeholder="Masukkan username" value="<?= old('username') ?>" autofocus>
        </div>
      </div>

      <div class="mb-4">
        <label for="password" class="form-label small fw-bold text-secondary">Password</label>
        <div class="input-group">
          <span class="input-group-text bg-light border-end-0 text-muted"><i class="bi bi-lock"></i></span>
          <input type="password" class="form-control border-start-0" id="password" name="password" required placeholder="Masukkan kata sandi">
        </div>
      </div>

      <button type="submit" class="btn btn-navy w-100 py-2 fw-bold shadow-sm d-flex align-items-center justify-content-center gap-2">
        <span>Masuk ke Dashboard</span>
        <i class="bi bi-arrow-right"></i>
      </button>
    </form>

    <div class="mt-4 pt-3 border-top">
      <div class="text-muted small text-center mb-2 fw-semibold">Bantuan Masuk:</div>
      <button type="button" class="btn btn-sm btn-outline-dark w-100 py-2 d-flex align-items-center justify-content-center gap-2" onclick="fillCredentials('admin', 'admin123')">
        <i class="bi bi-shield-lock-fill text-warning"></i>
        <span>Isi Akun Administrator Otomatis</span>
      </button>
    </div>

    <div class="text-center mt-3 pt-2">
      <a href="<?= site_url('/') ?>" class="text-decoration-none text-muted small d-inline-flex align-items-center gap-1">
        <i class="bi bi-arrow-left"></i>
        <span>Kembali ke Halaman Depan</span>
      </a>
    </div>
  </div>
</div>

<script>
  function fillCredentials(user, pass) {
    document.getElementById('username').value = user;
    document.getElementById('password').value = pass;
  }
</script>
</body>
</html>
