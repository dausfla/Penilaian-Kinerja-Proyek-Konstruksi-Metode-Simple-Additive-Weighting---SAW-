<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate">
  <meta http-equiv="Pragma" content="no-cache">
  <meta http-equiv="Expires" content="0">
  <title>Lupa PIN Keamanan &bull; SPK PT Rancang Bangun Sedaya</title>
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
      font-family: system-ui, -apple-system, "Segoe UI", Roboto, sans-serif;
    }
    .recovery-card {
      background: #ffffff;
      border-radius: var(--radius-lg, 16px);
      box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
      width: 100%;
      max-width: 440px;
      overflow: hidden;
      border: 1px solid rgba(255, 255, 255, 0.1);
    }
    .recovery-header {
      background: linear-gradient(180deg, #0f172a 0%, #1e293b 100%);
      padding: 2rem 2rem 1.5rem;
      text-align: center;
      color: #fff;
      border-bottom: 3px solid #f59e0b;
    }
    .recovery-body {
      padding: 2rem;
    }
    .step-indicator {
      display: flex;
      justify-content: center;
      align-items: center;
      gap: 8px;
      margin-bottom: 1.5rem;
    }
    .step-dot {
      width: 10px;
      height: 10px;
      border-radius: 50%;
      background: #e2e8f0;
    }
    .step-dot.active {
      background: #f59e0b;
      width: 24px;
      border-radius: 12px;
    }
  </style>
</head>
<body>

<div class="recovery-card">
  <div class="recovery-header">
    <div class="mb-3 text-center">
      <div class="d-inline-flex p-2 rounded-3" style="background: rgba(255,255,255,0.06); border: 1px solid rgba(245,158,11,0.28); box-shadow: 0 8px 16px rgba(0,0,0,0.3);">
        <img src="<?= base_url('images/logo-rbs.png') ?>" alt="Logo PT Rancang Bangun Sedaya" style="max-height: 56px; width: auto; object-fit: contain;">
      </div>
    </div>
    <h4 class="fw-bold mb-1 text-white">Pemulihan PIN</h4>
    <p class="mb-0 text-white-50 small">PT Rancang Bangun Sedaya</p>
  </div>

  <div class="recovery-body">
    <!-- Stepper indicator (Step 1 of 3) -->
    <div class="step-indicator">
      <div class="step-dot active" title="Langkah 1: Masukkan Email"></div>
      <div class="step-dot" title="Langkah 2: Verifikasi OTP"></div>
      <div class="step-dot" title="Langkah 3: Buat PIN Baru"></div>
    </div>

    <div class="text-center mb-3">
      <h6 class="fw-bold text-dark mb-1">Langkah 1: Masukkan Email Terdaftar</h6>
      <p class="text-muted small">Sistem akan mengirimkan 6-digit kode OTP ke akun Gmail Anda untuk mereset PIN keamanan.</p>
    </div>

    <?php if (session()->getFlashdata('error')): ?>
      <div class="alert alert-danger py-2 small d-flex align-items-center gap-2 mb-3" role="alert">
        <i class="bi bi-exclamation-circle-fill text-danger flex-shrink-0"></i>
        <div><?= session()->getFlashdata('error') ?></div>
      </div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('success')): ?>
      <div class="alert alert-success py-2 small d-flex align-items-center gap-2 mb-3" role="alert">
        <i class="bi bi-check-circle-fill text-success flex-shrink-0"></i>
        <div><?= session()->getFlashdata('success') ?></div>
      </div>
    <?php endif; ?>

    <form action="<?= site_url('lupa-pin/kirim-otp') ?>" method="post" id="formForgotPin">
      <?= csrf_field() ?>

      <div class="mb-3">
        <label for="email" class="form-label small fw-bold text-secondary">Alamat Email Terdaftar</label>
        <div class="input-group">
          <span class="input-group-text bg-light border-end-0 text-muted"><i class="bi bi-envelope"></i></span>
          <input type="email" class="form-control border-start-0" id="email" name="email" required placeholder="Contoh: nama@gmail.com" value="<?= old('email') ?>" autofocus>
        </div>
      </div>

      <button type="submit" class="btn btn-navy w-100 py-2 fw-bold shadow-sm d-flex align-items-center justify-content-center gap-2 mb-3">
        <span>Kirim Kode OTP</span>
        <i class="bi bi-send-fill text-warning"></i>
      </button>
    </form>

    <div class="text-center pt-2 border-top">
      <a href="<?= site_url('login') ?>" class="text-decoration-none text-muted small d-inline-flex align-items-center gap-1">
        <i class="bi bi-arrow-left"></i>
        <span>Batal, Kembali ke Login PIN</span>
      </a>
    </div>
  </div>
</div>

<script>
  window.addEventListener('pageshow', function (event) {
    if (event.persisted || (window.performance && window.performance.navigation && window.performance.navigation.type === 2)) {
      window.location.reload();
    }
  });
</script>
</body>
</html>
