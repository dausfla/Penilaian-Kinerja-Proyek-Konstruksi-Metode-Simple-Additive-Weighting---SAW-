<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate">
  <meta http-equiv="Pragma" content="no-cache">
  <meta http-equiv="Expires" content="0">
  <title>Verifikasi OTP &bull; SPK PT Rancang Bangun Sedaya</title>
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
    .otp-card {
      background: #ffffff;
      border-radius: var(--radius-lg, 16px);
      box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
      width: 100%;
      max-width: 440px;
      overflow: hidden;
      border: 1px solid rgba(255, 255, 255, 0.1);
    }
    .otp-header {
      background: linear-gradient(180deg, #0f172a 0%, #1e293b 100%);
      padding: 2rem 2rem 1.5rem;
      text-align: center;
      color: #fff;
      border-bottom: 3px solid #f59e0b;
    }
    .otp-body {
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

    /* 6 OTP Boxes */
    .otp-inputs {
      display: flex;
      gap: 8px;
      justify-content: center;
      margin: 1.5rem 0;
    }
    .otp-field {
      width: 48px;
      height: 56px;
      border: 2px solid #cbd5e1;
      border-radius: 10px;
      text-align: center;
      font-size: 24px;
      font-weight: 700;
      color: #0f172a;
      background: #f8fafc;
      transition: all 0.2s ease;
    }
    .otp-field:focus {
      border-color: #f59e0b;
      background: #ffffff;
      box-shadow: 0 0 0 4px rgba(245, 158, 11, 0.18);
      outline: none;
      transform: translateY(-2px);
    }

    .timer-badge {
      display: inline-flex;
      align-items: center;
      gap: 6px;
      background: #fef3c7;
      color: #92400e;
      border: 1px solid #fde68a;
      padding: 0.35rem 0.85rem;
      border-radius: 20px;
      font-weight: 700;
      font-size: 0.9rem;
    }
  </style>
</head>
<body>

<div class="otp-card">
  <div class="otp-header">
    <div class="mb-3 text-center">
      <div class="d-inline-flex p-2 rounded-3" style="background: rgba(255,255,255,0.06); border: 1px solid rgba(245,158,11,0.28); box-shadow: 0 8px 16px rgba(0,0,0,0.3);">
        <img src="<?= base_url('images/logo-rbs.png') ?>" alt="Logo PT Rancang Bangun Sedaya" style="max-height: 56px; width: auto; object-fit: contain;">
      </div>
    </div>
    <h4 class="fw-bold mb-1 text-white">Verifikasi OTP</h4>
    <p class="mb-0 text-white-50 small">PT Rancang Bangun Sedaya</p>
  </div>

  <div class="otp-body">
    <!-- Stepper indicator (Step 2 of 3) -->
    <div class="step-indicator">
      <div class="step-dot completed" title="Langkah 1: Masukkan Email Selesai"></div>
      <div class="step-dot active" title="Langkah 2: Verifikasi OTP"></div>
      <div class="step-dot" title="Langkah 3: Buat PIN Baru"></div>
    </div>

    <div class="text-center mb-3">
      <h6 class="fw-bold text-dark mb-1">Langkah 2: Masukkan 6-Digit Kode OTP</h6>
      <p class="text-muted small mb-1">
        Kode verifikasi dikirimkan ke:
      </p>
      <span class="badge bg-light text-dark border px-3 py-1 font-monospace"><?= esc($email) ?></span>
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

    <form action="<?= site_url('verifikasi-otp/proses') ?>" method="post" id="formOtp">
      <?= csrf_field() ?>
      <input type="hidden" name="otp" id="hiddenOtp" value="">

      <!-- 6 Input Fields -->
      <div class="otp-inputs">
        <input type="text" maxlength="1" class="otp-field" pattern="[0-9]" inputmode="numeric" autofocus data-idx="0">
        <input type="text" maxlength="1" class="otp-field" pattern="[0-9]" inputmode="numeric" data-idx="1">
        <input type="text" maxlength="1" class="otp-field" pattern="[0-9]" inputmode="numeric" data-idx="2">
        <input type="text" maxlength="1" class="otp-field" pattern="[0-9]" inputmode="numeric" data-idx="3">
        <input type="text" maxlength="1" class="otp-field" pattern="[0-9]" inputmode="numeric" data-idx="4">
        <input type="text" maxlength="1" class="otp-field" pattern="[0-9]" inputmode="numeric" data-idx="5">
      </div>

      <!-- Countdown Timer -->
      <div class="text-center mb-3">
        <div class="timer-badge">
          <i class="bi bi-stopwatch-fill"></i>
          <span>Berlaku hingga: <span id="countdown">05:00</span></span>
        </div>
      </div>

      <button type="submit" id="btnSubmitOtp" class="btn btn-navy w-100 py-2 fw-bold shadow-sm d-flex align-items-center justify-content-center gap-2 mb-3" disabled>
        <span>Verifikasi Kode OTP</span>
        <i class="bi bi-check-lg text-warning"></i>
      </button>
    </form>

    <div class="d-flex align-items-center justify-content-between pt-2 border-top">
      <a href="<?= site_url('lupa-pin') ?>" class="text-decoration-none text-muted small d-inline-flex align-items-center gap-1">
        <i class="bi bi-arrow-left"></i>
        <span>Kirim Ulang / Ganti Email</span>
      </a>
      <a href="<?= site_url('login') ?>" class="text-decoration-none text-danger small fw-semibold">
        Batal
      </a>
    </div>
  </div>
</div>

<script>
  const inputs = document.querySelectorAll('.otp-field');
  const hiddenOtp = document.getElementById('hiddenOtp');
  const submitBtn = document.getElementById('btnSubmitOtp');

  function checkComplete() {
    let code = '';
    inputs.forEach(input => code += input.value);
    hiddenOtp.value = code;

    if (code.length === 6 && /^\d{6}$/.test(code)) {
      submitBtn.removeAttribute('disabled');
      submitBtn.classList.remove('btn-navy');
      submitBtn.classList.add('btn-warning', 'text-dark');
      // Auto submit saat 6 digit lengkap
      setTimeout(() => {
        document.getElementById('formOtp').submit();
      }, 200);
    } else {
      submitBtn.setAttribute('disabled', 'disabled');
      submitBtn.classList.add('btn-navy');
      submitBtn.classList.remove('btn-warning', 'text-dark');
    }
  }

  inputs.forEach((input, index) => {
    input.addEventListener('input', (e) => {
      const val = e.target.value.replace(/[^0-9]/g, '');
      e.target.value = val;

      if (val.length === 1 && index < inputs.length - 1) {
        inputs[index + 1].focus();
      }
      checkComplete();
    });

    input.addEventListener('keydown', (e) => {
      if (e.key === 'Backspace' && !input.value && index > 0) {
        inputs[index - 1].focus();
      }
    });

    input.addEventListener('paste', (e) => {
      e.preventDefault();
      const pasteData = (e.clipboardData || window.clipboardData).getData('text').trim();
      if (/^\d{6}$/.test(pasteData)) {
        fillOtp(pasteData);
      }
    });
  });

  function fillOtp(otp) {
    if (otp && otp.length === 6) {
      otp.split('').forEach((digit, i) => {
        if (inputs[i]) inputs[i].value = digit;
      });
      checkComplete();
    }
  }

  // 5 Minutes Countdown Timer
  <?php 
    $expiresTimestamp = !empty($expiresAt) ? strtotime($expiresAt) : (time() + 300);
    $remainingSeconds = max(0, $expiresTimestamp - time());
  ?>
  let remaining = <?= (int)$remainingSeconds ?>;
  const countdownEl = document.getElementById('countdown');

  function updateTimer() {
    if (remaining <= 0) {
      countdownEl.textContent = '00:00 (Kadaluarsa)';
      countdownEl.classList.add('text-danger');
      return;
    }
    const mins = Math.floor(remaining / 60);
    const secs = remaining % 60;
    countdownEl.textContent = `${String(mins).padStart(2, '0')}:${String(secs).padStart(2, '0')}`;
    remaining--;
    setTimeout(updateTimer, 1000);
  }
  updateTimer();

  window.addEventListener('pageshow', function (event) {
    if (event.persisted || (window.performance && window.performance.navigation && window.performance.navigation.type === 2)) {
      window.location.reload();
    }
  });
</script>
</body>
</html>
