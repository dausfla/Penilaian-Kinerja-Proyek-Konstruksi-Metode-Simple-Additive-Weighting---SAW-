<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Kode OTP Reset PIN</title>
  <style>
    body {
      font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
      background-color: #f1f5f9;
      margin: 0;
      padding: 24px;
      color: #1e293b;
    }
    .email-container {
      max-width: 560px;
      margin: 0 auto;
      background: #ffffff;
      border-radius: 12px;
      overflow: hidden;
      border: 1px solid #e2e8f0;
      box-shadow: 0 4px 12px rgba(0,0,0,0.06);
    }
    .header {
      background: linear-gradient(135deg, #090d16 0%, #0f172a 100%);
      padding: 32px 24px;
      text-align: center;
      color: #ffffff;
      border-bottom: 3px solid #f59e0b;
    }
    .header h2 {
      margin: 0 0 6px;
      font-size: 20px;
      letter-spacing: 0.5px;
    }
    .header p {
      margin: 0;
      color: #94a3b8;
      font-size: 13px;
    }
    .content {
      padding: 32px 28px;
    }
    .greeting {
      font-size: 15px;
      font-weight: 600;
      color: #0f172a;
      margin-bottom: 12px;
    }
    .message {
      font-size: 14px;
      line-height: 1.6;
      color: #475569;
      margin-bottom: 24px;
    }
    .otp-box {
      background: #f8fafc;
      border: 2px dashed #f59e0b;
      border-radius: 10px;
      padding: 20px;
      text-align: center;
      margin: 24px 0;
    }
    .otp-label {
      font-size: 12px;
      text-transform: uppercase;
      letter-spacing: 1px;
      color: #64748b;
      font-weight: 600;
      margin-bottom: 6px;
    }
    .otp-code {
      font-size: 36px;
      font-weight: 800;
      letter-spacing: 10px;
      color: #0f172a;
      font-family: 'Courier New', Courier, monospace;
    }
    .expiry-note {
      font-size: 12px;
      color: #dc2626;
      font-weight: 600;
      margin-top: 8px;
    }
    .footer {
      background: #f8fafc;
      padding: 20px 28px;
      text-align: center;
      font-size: 12px;
      color: #94a3b8;
      border-top: 1px solid #e2e8f0;
      line-height: 1.5;
    }
  </style>
</head>
<body>
  <div class="email-container">
    <div class="header">
      <h2>PT RANCANG BANGUN SEDAYA</h2>
      <p>Sistem Pendukung Keputusan Penilaian Kinerja Proyek Konstruksi (Metode SAW)</p>
    </div>
    <div class="content">
      <div class="greeting">Halo, <?= esc($user['nama']) ?></div>
      <p class="message">
        Kami menerima permintaan untuk mereset 6-digit PIN keamanan pada akun Anda. Gunakan kode verifikasi OTP (One-Time Password) di bawah ini untuk melanjutkan pembuatan PIN baru:
      </p>

      <div class="otp-box">
        <div class="otp-label">Kode Verifikasi OTP Anda</div>
        <div class="otp-code"><?= esc($otp) ?></div>
        <div class="expiry-note">&bull; Berlaku selama 5 menit &bull;</div>
      </div>

      <p class="message" style="font-size: 13px; color: #64748b;">
        <strong>Perhatian:</strong> Jangan bagikan kode ini kepada siapapun demi keamanan sistem. Jika Anda tidak merasa melakukan permintaan ini, silakan abaikan email ini atau segera hubungi Administrator.
      </p>
    </div>
    <div class="footer">
      Email otomatis dari Sistem SPK PT Rancang Bangun Sedaya.<br>
      Tidak perlu membalas email ini.
    </div>
  </div>
</body>
</html>
