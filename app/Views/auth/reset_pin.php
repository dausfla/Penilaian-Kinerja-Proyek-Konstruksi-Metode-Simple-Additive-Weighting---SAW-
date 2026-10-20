<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate">
  <meta http-equiv="Pragma" content="no-cache">
  <meta http-equiv="Expires" content="0">
  <title>Buat PIN Baru &bull; SPK PT Rancang Bangun Sedaya</title>
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
    .reset-card {
      background: #ffffff;
      border-radius: var(--radius-lg, 16px);
      box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
      width: 100%;
      max-width: 440px;
      overflow: hidden;
      border: 1px solid rgba(255, 255, 255, 0.1);
    }
    .reset-header {
      background: linear-gradient(180deg, #0f172a 0%, #1e293b 100%);
      padding: 2rem 2rem 1.5rem;
      text-align: center;
      color: #fff;
      border-bottom: 3px solid #f59e0b;
    }
    .reset-body {
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
    .step-dot.completed {
      background: #10b981;
    }
  </style>
</head>
<body>

<div class="reset-card">
  <div class="reset-header">
    <div class="mb-3 text-center">
      <div class="d-inline-flex p-2 rounded-3" style="background: rgba(255,255,255,0.06); border: 1px solid rgba(245,158,11,0.28); box-shadow: 0 8px 16px rgba(0,0,0,0.3);">
        <img src="<?= base_url('images/logo-rbs.png') ?>" alt="Logo PT Rancang Bangun Sedaya" style="max-height: 56px; width: auto; object-fit: contain;">
      </div>
    </div>
    <h4 class="fw-bold mb-1 text-white">Buat PIN Baru</h4>
    <p class="mb-0 text-white-50 small">PT Rancang Bangun Sedaya</p>
  </div>

  <div class="reset-body">
    <!-- Stepper indicator (Step 3 of 3) -->
    <div class="step-indicator">
      <div class="step-dot completed" title="Langkah 1: Masukkan Email Selesai"></div>
      <div class="step-dot completed" title="Langkah 2: Verifikasi OTP Selesai"></div>
      <div class="step-dot active" title="Langkah 3: Buat PIN Baru"></div>
    </div>

    <div class="text-center mb-3">
      <h6 class="fw-bold text-dark mb-1">Langkah 3: Tentukan 6-Digit PIN Baru</h6>
      <p class="text-muted small">Buat kombinasi 6 angka unik yang mudah Anda ingat namun aman.</p>
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

    <form action="<?= site_url('buat-pin-baru/proses') ?>" method="post" id="formResetPin">
      <?= csrf_field() ?>

      <div class="mb-3">
        <label for="pin" class="form-label small fw-bold text-secondary">PIN Baru (6 Digit Angka)</label>
        <div class="input-group">
          <span class="input-group-text bg-light border-end-0 text-muted"><i class="bi bi-key-fill text-warning"></i></span>
          <input type="password" maxlength="6" pattern="[0-9]{6}" inputmode="numeric" class="form-control border-start-0 font-monospace fs-5 text-center" id="pin" name="pin" required placeholder="Contoh: 080905" autofocus>
          <button class="btn btn-outline-secondary border-start-0" type="button" onclick="toggleVisibility('pin', this)">
            <i class="bi bi-eye"></i>
          </button>
        </div>
        <div class="form-text small" style="font-size: 0.75rem;">Harus berupa 6 digit angka numerik.</div>
      </div>

      <div class="mb-4">
        <label for="pin_confirmation" class="form-label small fw-bold text-secondary">Ulangi PIN Baru (Konfirmasi)</label>
        <div class="input-group">
          <span class="input-group-text bg-light border-end-0 text-muted"><i class="bi bi-shield-check text-success"></i></span>
          <input type="password" maxlength="6" pattern="[0-9]{6}" inputmode="numeric" class="form-control border-start-0 font-monospace fs-5 text-center" id="pin_confirmation" name="pin_confirmation" required placeholder="Ulangi 6 angka di atas">
          <button class="btn btn-outline-secondary border-start-0" type="button" onclick="toggleVisibility('pin_confirmation', this)">
            <i class="bi bi-eye"></i>
          </button>
        </div>
        <div id="matchMessage" class="small mt-1 fw-semibold"></div>
      </div>

      <button type="submit" id="btnSubmitNewPin" class="btn btn-navy w-100 py-2 fw-bold shadow-sm d-flex align-items-center justify-content-center gap-2 mb-3">
        <i class="bi bi-save2-fill text-warning"></i>
        <span>Simpan PIN Baru & Selesai</span>
      </button>
    </form>

    <div class="text-center pt-2 border-top">
      <a href="<?= site_url('login') ?>" class="text-decoration-none text-muted small d-inline-flex align-items-center gap-1">
        <i class="bi bi-arrow-left"></i>
        <span>Batal, Kembali ke Login</span>
      </a>
    </div>
  </div>
</div>

<script>
  function toggleVisibility(inputId, btn) {
    const input = document.getElementById(inputId);
    const icon = btn.querySelector('i');
    if (input.type === 'password') {
      input.type = 'text';
      icon.classList.remove('bi-eye');
      icon.classList.add('bi-eye-slash');
    } else {
      input.type = 'password';
      icon.classList.remove('bi-eye-slash');
      icon.classList.add('bi-eye');
    }
  }

  const pinInput = document.getElementById('pin');
  const confirmInput = document.getElementById('pin_confirmation');
  const matchMsg = document.getElementById('matchMessage');
  const submitBtn = document.getElementById('btnSubmitNewPin');

  function validatePins() {
    const p1 = pinInput.value.replace(/[^0-9]/g, '');
    const p2 = confirmInput.value.replace(/[^0-9]/g, '');
    pinInput.value = p1;
    confirmInput.value = p2;

    if (!p2) {
      matchMsg.textContent = '';
      return;
    }

    if (p1 === p2 && p1.length === 6) {
      matchMsg.innerHTML = '<span class="text-success"><i class="bi bi-check-circle-fill me-1"></i>PIN Cocok!</span>';
      submitBtn.removeAttribute('disabled');
      submitBtn.classList.remove('btn-navy');
      submitBtn.classList.add('btn-warning', 'text-dark');
    } else {
      matchMsg.innerHTML = '<span class="text-danger"><i class="bi bi-exclamation-circle-fill me-1"></i>PIN belum cocok atau belum 6 digit.</span>';
      submitBtn.classList.add('btn-navy');
      submitBtn.classList.remove('btn-warning', 'text-dark');
    }
  }

  pinInput.addEventListener('input', validatePins);
  confirmInput.addEventListener('input', validatePins);

  window.addEventListener('pageshow', function (event) {
    if (event.persisted || (window.performance && window.performance.navigation && window.performance.navigation.type === 2)) {
      window.location.reload();
    }
  });
</script>
</body>
</html>
