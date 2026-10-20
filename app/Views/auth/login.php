<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate">
  <meta http-equiv="Pragma" content="no-cache">
  <meta http-equiv="Expires" content="0">
  <title>Masuk Sistem &bull; SPK Penilaian Kinerja Proyek PT Rancang Bangun Sedaya</title>
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
    .login-card {
      background: #ffffff;
      border-radius: var(--radius-lg, 16px);
      box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
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
      border-bottom: 3px solid #f59e0b;
    }
    .login-body {
      padding: 2rem;
    }

    /* 6 PIN Display Boxes */
    .pin-wrapper {
      position: relative;
      cursor: text;
    }
    .pin-display-group {
      display: flex;
      gap: 10px;
      justify-content: center;
      margin-bottom: 0.5rem;
    }
    .pin-box {
      width: 48px;
      height: 58px;
      border: 2px solid #cbd5e1;
      border-radius: 12px;
      text-align: center;
      font-size: 28px;
      font-weight: 700;
      color: #0f172a;
      background: #f8fafc;
      transition: all 0.2s ease;
      display: flex;
      align-items: center;
      justify-content: center;
      user-select: none;
    }
    .pin-box.active {
      border-color: #f59e0b;
      background: #ffffff;
      box-shadow: 0 0 0 4px rgba(245, 158, 11, 0.18);
      transform: translateY(-2px);
    }
    .pin-box.filled {
      border-color: #0f172a;
      background: #ffffff;
      color: #0f172a;
    }

    /* Real Hidden Native Input */
    .pin-real-input {
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      opacity: 0;
      cursor: default;
      pointer-events: all;
    }

    .nav-pills .nav-link {
      font-size: 0.85rem;
      font-weight: 600;
      color: #64748b;
      border-radius: 8px;
      padding: 0.45rem 0.8rem;
    }
    .nav-pills .nav-link.active {
      background: #0f172a;
      color: #ffffff;
    }
  </style>
</head>
<body>

<div class="login-card">
  <div class="login-header">
    <div class="mb-3 text-center">
      <div class="d-inline-flex p-2 rounded-3" style="background: rgba(255,255,255,0.06); border: 1px solid rgba(245,158,11,0.28); box-shadow: 0 8px 16px rgba(0,0,0,0.3);">
        <img src="<?= base_url('images/logo-rbs.png') ?>" alt="Logo PT Rancang Bangun Sedaya" style="max-height: 60px; width: auto; object-fit: contain;">
      </div>
    </div>
    <h4 class="fw-bold mb-1 text-white">SPK Kinerja Proyek</h4>
    <p class="mb-0 text-white-50 small">PT Rancang Bangun Sedaya</p>
    <div class="badge bg-warning text-dark mt-2 px-3 py-1 fw-bold">
      <i class="bi bi-shield-lock-fill me-1"></i> Otentikasi Keamanan PIN
    </div>
  </div>

  <div class="login-body">
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

    <!-- Tabs Nav: PIN vs Password Cadangan -->
    <ul class="nav nav-pills nav-fill bg-light p-1 rounded-3 mb-4" id="loginTab" role="tablist">
      <li class="nav-item" role="presentation">
        <button class="nav-link active" id="pin-tab" data-bs-toggle="pill" data-bs-target="#pin-pane" type="button" role="tab">
          <i class="bi bi-key-fill me-1 text-warning"></i> Akses PIN
        </button>
      </li>
      <li class="nav-item" role="presentation">
        <button class="nav-link" id="password-tab" data-bs-toggle="pill" data-bs-target="#password-pane" type="button" role="tab">
          <i class="bi bi-person-lock me-1"></i> Kata Sandi
        </button>
      </li>
    </ul>

    <div class="tab-content" id="loginTabContent">
      <!-- PANE 1: 6-DIGIT PIN PASSKEY -->
      <div class="tab-pane fade show active" id="pin-pane" role="tabpanel">
        <form action="<?= site_url('login/pin') ?>" method="post" id="pinForm">
          <?= csrf_field() ?>

          <div class="text-center mb-3">
            <span class="text-muted small fw-semibold">Masukkan 6 Digit PIN Akses Anda:</span>
          </div>

          <!-- 6 PIN Boxes Wrapper -->
          <div class="pin-wrapper" onclick="focusPinInput()">
            <input type="password" 
                   name="pin" 
                   id="realPinInput" 
                   class="pin-real-input" 
                   maxlength="6" 
                   pattern="[0-9]{6}" 
                   inputmode="numeric" 
                   autocomplete="one-time-code" 
                   autofocus 
                   required>

            <div class="pin-display-group">
              <div class="pin-box active" data-index="0">-</div>
              <div class="pin-box" data-index="1">-</div>
              <div class="pin-box" data-index="2">-</div>
              <div class="pin-box" data-index="3">-</div>
              <div class="pin-box" data-index="4">-</div>
              <div class="pin-box" data-index="5">-</div>
            </div>
          </div>

          <div class="d-flex justify-content-center align-items-center gap-2 mb-4">
            <button type="button" class="btn btn-sm btn-link text-decoration-none text-muted p-0 small" onclick="togglePinVisibility()">
              <i class="bi bi-eye" id="visIcon"></i> <span id="visText">Tampilkan PIN</span>
            </button>
          </div>

          <button type="submit" id="btnSubmitPin" class="btn btn-navy w-100 py-2 fw-bold shadow-sm d-flex align-items-center justify-content-center gap-2 mb-3" disabled>
            <span>Verifikasi & Masuk</span>
            <i class="bi bi-arrow-right"></i>
          </button>
        </form>

        <div class="text-center pt-2 border-top">
          <a href="<?= site_url('lupa-pin') ?>" class="text-decoration-none small text-danger fw-semibold d-inline-flex align-items-center gap-1">
            <i class="bi bi-question-circle"></i>
            <span>Lupa PIN? Reset melalui Email OTP</span>
          </a>
        </div>
      </div>

      <!-- PANE 2: USERNAME & PASSWORD -->
      <div class="tab-pane fade" id="password-pane" role="tabpanel">
        <form action="<?= site_url('login/process') ?>" method="post">
          <?= csrf_field() ?>

          <div class="mb-3">
            <label for="username" class="form-label small fw-bold text-secondary">Username</label>
            <div class="input-group">
              <span class="input-group-text bg-light border-end-0 text-muted"><i class="bi bi-person"></i></span>
              <input type="text" class="form-control border-start-0" id="username" name="username" placeholder="Masukkan username" value="<?= old('username') ?>" required>
            </div>
          </div>

          <div class="mb-4">
            <label for="password" class="form-label small fw-bold text-secondary">Kata Sandi</label>
            <div class="input-group">
              <span class="input-group-text bg-light border-end-0 text-muted"><i class="bi bi-lock"></i></span>
              <input type="password" class="form-control border-start-0" id="password" name="password" placeholder="Masukkan kata sandi" required>
            </div>
          </div>

          <button type="submit" class="btn btn-navy w-100 py-2 fw-bold shadow-sm d-flex align-items-center justify-content-center gap-2">
            <span>Masuk ke Dashboard</span>
            <i class="bi bi-arrow-right"></i>
          </button>
        </form>
      </div>
    </div>

    <div class="text-center mt-3 pt-2">
      <a href="<?= site_url('/') ?>" class="text-decoration-none text-muted small d-inline-flex align-items-center gap-1">
        <i class="bi bi-arrow-left"></i>
        <span>Kembali ke Halaman Depan</span>
      </a>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
  const pinInput = document.getElementById('realPinInput');
  const boxes = document.querySelectorAll('.pin-box');
  const submitBtn = document.getElementById('btnSubmitPin');
  let isVisible = false;

  function focusPinInput() {
    pinInput.focus();
  }

  function togglePinVisibility() {
    isVisible = !isVisible;
    const icon = document.getElementById('visIcon');
    const text = document.getElementById('visText');
    if (isVisible) {
      icon.classList.remove('bi-eye');
      icon.classList.add('bi-eye-slash');
      text.textContent = 'Sembunyikan PIN';
    } else {
      icon.classList.remove('bi-eye-slash');
      icon.classList.add('bi-eye');
      text.textContent = 'Tampilkan PIN';
    }
    renderBoxes();
  }

  function renderBoxes() {
    const val = pinInput.value;
    boxes.forEach((box, index) => {
      if (index < val.length) {
        box.textContent = isVisible ? val[index] : '●';
        box.classList.add('filled');
        box.classList.remove('active');
      } else if (index === val.length) {
        box.textContent = '-';
        box.classList.remove('filled');
        box.classList.add('active');
      } else {
        box.textContent = '-';
        box.classList.remove('filled', 'active');
      }
    });

    if (val.length === 6) {
      submitBtn.removeAttribute('disabled');
      submitBtn.classList.remove('btn-navy');
      submitBtn.classList.add('btn-warning', 'text-dark');
      setTimeout(() => {
        document.getElementById('pinForm').submit();
      }, 200);
    } else {
      submitBtn.setAttribute('disabled', 'disabled');
      submitBtn.classList.add('btn-navy');
      submitBtn.classList.remove('btn-warning', 'text-dark');
    }
  }

  pinInput.addEventListener('input', (e) => {
    e.target.value = e.target.value.replace(/[^0-9]/g, '').slice(0, 6);
    renderBoxes();
  });

  // Re-focus on click anywhere inside pin container
  document.querySelector('.pin-wrapper').addEventListener('click', focusPinInput);

  // Focus on load if pin tab active
  window.addEventListener('DOMContentLoaded', () => {
    focusPinInput();
  });

  // Keamanan Sesi: Cegah halaman login dimuat dari cache jika user menekan back
  window.addEventListener('pageshow', function (event) {
    if (event.persisted || (window.performance && window.performance.navigation && window.performance.navigation.type === 2)) {
      window.location.reload();
    }
  });
</script>
</body>
</html>
