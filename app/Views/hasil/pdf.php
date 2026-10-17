<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>Laporan Penilaian Kinerja Proyek - PT Rancang Bangun Sedaya</title>
  <style>
    body {
      font-family: 'Helvetica', Arial, sans-serif;
      font-size: 11px;
      color: #1e293b;
      line-height: 1.4;
      margin: 20px;
    }
    .header-table {
      width: 100%;
      border-bottom: 2px solid #0f172a;
      padding-bottom: 8px;
      margin-bottom: 15px;
    }
    .company-name {
      font-size: 16px;
      font-weight: bold;
      color: #0f172a;
      text-transform: uppercase;
      letter-spacing: 0.5px;
    }
    .company-sub {
      font-size: 9px;
      color: #475569;
    }
    .doc-title {
      text-align: center;
      font-size: 13px;
      font-weight: bold;
      color: #0f172a;
      margin-bottom: 3px;
      text-transform: uppercase;
    }
    .doc-sub {
      text-align: center;
      font-size: 10px;
      color: #64748b;
      margin-bottom: 15px;
    }
    .meta-table {
      width: 100%;
      margin-bottom: 15px;
      font-size: 10px;
      border: 1px solid #e2e8f0;
      background-color: #f8fafc;
      padding: 6px;
    }
    .meta-table td {
      padding: 3px 5px;
    }
    .data-table {
      width: 100%;
      border-collapse: collapse;
      margin-bottom: 20px;
    }
    .data-table th {
      background-color: #0f172a;
      color: #ffffff;
      font-size: 9px;
      font-weight: bold;
      text-transform: uppercase;
      padding: 6px 5px;
      border: 1px solid #0f172a;
      text-align: center;
    }
    .data-table td {
      padding: 6px 5px;
      border: 1px solid #cbd5e1;
      font-size: 10px;
    }
    .data-table tr:nth-child(even) {
      background-color: #f8fafc;
    }
    .badge-baik {
      background-color: #ecfdf5;
      color: #059669;
      font-weight: bold;
      padding: 2px 5px;
      border: 1px solid #a7f3d0;
      border-radius: 3px;
    }
    .badge-perhatian {
      background-color: #fffbeb;
      color: #d97706;
      font-weight: bold;
      padding: 2px 5px;
      border: 1px solid #fde68a;
      border-radius: 3px;
    }
    .badge-berisiko {
      background-color: #fef2f2;
      color: #dc2626;
      font-weight: bold;
      padding: 2px 5px;
      border: 1px solid #fecdd3;
      border-radius: 3px;
    }
    .recommendation-box {
      border: 1px solid #e2e8f0;
      background-color: #f8fafc;
      padding: 10px;
      margin-bottom: 25px;
      border-radius: 4px;
    }
    .recommendation-title {
      font-weight: bold;
      font-size: 11px;
      color: #0f172a;
      margin-bottom: 6px;
    }
    .sig-table {
      width: 100%;
      margin-top: 30px;
      page-break-inside: avoid;
    }
    .sig-table td {
      width: 50%;
      text-align: center;
      vertical-align: top;
      font-size: 10px;
    }
    .sig-space {
      height: 60px;
    }
    .text-center { text-align: center; }
    .text-right { text-align: right; }
    .fw-bold { font-weight: bold; }
  </style>
</head>
<body>

  <!-- Kop Surat -->
  <table class="header-table">
    <tr>
      <td style="width: 70%;">
        <div class="company-name"><?= esc($settings['nama_perusahaan'] ?? 'PT RANCANG BANGUN SEDAYA') ?></div>
        <div class="company-sub">General Contractor, Architecture & Project Management</div>
        <div class="company-sub"><?= esc($settings['alamat_perusahaan'] ?? '(Head Quarter): Pasirmulya, Kecamatan Bogor Barat, Kota Bogor, Jawa Barat 16118') ?></div>
      </td>
      <td style="width: 30%; text-align: right;">
        <div style="font-size: 11px; font-weight: bold; color: #d97706;">SISTEM PENDUKUNG KEPUTUSAN</div>
        <div style="font-size: 9px; color: #64748b;">Metode Simple Additive Weighting (SAW)</div>
      </td>
    </tr>
  </table>

  <!-- Judul Laporan -->
  <div class="doc-title">Laporan Penilaian & Perangkingan Kinerja Proyek</div>
  <div class="doc-sub">Portofolio Evaluasi Kinerja Seluruh Proyek Konstruksi</div>

  <!-- Metadata Laporan -->
  <table class="meta-table">
    <tr>
      <td style="width: 20%; font-weight: bold;">Tanggal Dokumen</td>
      <td style="width: 30%;">: <?= $printDate ?></td>
      <td style="width: 20%; font-weight: bold;">Dicetak Oleh</td>
      <td style="width: 30%;">: <?= !empty($printedBy) && $printedBy !== 'Administrator' ? esc($printedBy) : 'Muhamad Firdaus' ?></td>
    </tr>
    <tr>
      <td style="font-weight: bold;">Jumlah Proyek</td>
      <td>: <?= count($hasilList) ?> Proyek Dinilai</td>
      <td style="font-weight: bold;">Status Evaluasi</td>
      <td>: Terkalkulasi Otomatis (Metode SAW)</td>
    </tr>
    <tr>
      <td style="font-weight: bold;">Ambang Batas</td>
      <td colspan="3">: Baik (Skor <?= number_format($batasBaik, 2) ?> ke atas) &bull; Perlu Perhatian (Skor <?= number_format($batasPerhatian, 2) ?> s.d. <?= number_format($batasBaik - 0.01, 2) ?>) &bull; Berisiko (Skor di bawah <?= number_format($batasPerhatian, 2) ?>)</td>
    </tr>
  </table>

  <!-- Tabel Hasil Perangkingan -->
  <table class="data-table">
    <thead>
      <tr>
        <th style="width: 20px;">No</th>
        <th style="width: 40px;">Kode</th>
        <th>Nama Proyek</th>
        <th style="width: 50px;">Jenis</th>
        <th style="width: 70px;" class="text-right">RAB (Rp)</th>
        <th style="width: 32px;">C1 (%)</th>
        <th style="width: 32px;">C2 (%)</th>
        <th style="width: 20px;">C3</th>
        <th style="width: 20px;">C4</th>
        <th style="width: 25px;">C5 (hr)</th>
        <th style="width: 20px;">C6</th>
        <th style="width: 20px;">C7</th>
        <th style="width: 45px;">Skor Akhir</th>
        <th style="width: 75px;">Kategori</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($hasilList as $h): ?>
        <tr>
          <td class="text-center fw-bold"><?= $h['peringkat'] ?></td>
          <td class="text-center"><?= esc($h['proyek_kode']) ?></td>
          <td class="fw-bold"><?= esc($h['proyek_nama']) ?></td>
          <td class="text-center" style="text-transform: capitalize;"><?= esc($h['jenis']) ?></td>
          <td class="text-right"><?= number_format((float)$h['nilai_rab'], 0, ',', '.') ?></td>
          <td class="text-center"><?= number_format((float)$h['c1'], 1) ?></td>
          <td class="text-center"><?= number_format((float)$h['c2'], 1) ?></td>
          <td class="text-center"><?= $h['c3'] ?></td>
          <td class="text-center"><?= $h['c4'] ?></td>
          <td class="text-center"><?= $h['c5'] ?></td>
          <td class="text-center"><?= (int)($h['c6'] ?? 5) ?></td>
          <td class="text-center"><?= (int)($h['c7'] ?? 5) ?></td>
          <td class="text-center fw-bold" style="font-size: 11px;"><?= number_format((float)$h['vi'], 2) ?></td>
          <td class="text-center">
            <?php if ($h['kategori'] === 'Baik'): ?>
              <span class="badge-baik">Baik</span>
            <?php elseif ($h['kategori'] === 'Perlu Perhatian'): ?>
              <span class="badge-perhatian">Perlu Perhatian</span>
            <?php else: ?>
              <span class="badge-berisiko">Berisiko/Terlambat</span>
            <?php endif; ?>
          </td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>

  <!-- Rekomendasi Manajemen -->
  <div class="recommendation-box">
    <div class="recommendation-title">Catatan & Rekomendasi Manajerial:</div>
    <table style="width: 100%; font-size: 9.5px;">
      <tr>
        <td style="width: 25%; font-weight: bold; color: #059669; vertical-align: top;">Kategori Baik:</td>
        <td style="color: #334155;">Kinerja proyek berjalan prima sesuai jadwal Kurva S dan batasan anggaran RAB. Pertahankan kontrol kualitas dan hubungan dengan pemilik proyek.</td>
      </tr>
      <tr>
        <td style="font-weight: bold; color: #d97706; vertical-align: top; padding-top: 4px;">Kategori Perlu Perhatian:</td>
        <td style="color: #334155; padding-top: 4px;">Ditemukan indikasi deviasi biaya atau keterlambatan ringan. Diperlukan peninjauan berkala pada site meeting dan kelengkapan dokumen pendukung.</td>
      </tr>
      <tr>
        <td style="font-weight: bold; color: #dc2626; vertical-align: top; padding-top: 4px;">Kategori Berisiko/Terlambat:</td>
        <td style="color: #334155; padding-top: 4px;">Diperlukan intervensi segera oleh Project Manager dan Direksi: percepatan fisik di lapangan (crashing/fast-tracking), penambahan tenaga kerja, dan restrukturisasi anggaran.</td>
      </tr>
    </table>
  </div>

  <!-- Tanda Tangan -->
  <table class="sig-table">
    <tr>
      <td>
        <div>Dibuat Oleh,</div>
        <div style="font-weight: bold;">Administrator SPK</div>
        <div class="sig-space"></div>
        <div style="font-weight: bold; text-decoration: underline;"><?= !empty($printedBy) && $printedBy !== 'Administrator' ? esc($printedBy) : 'Muhamad Firdaus' ?></div>
        <div style="color: #64748b;">Pengelola Sistem SPK</div>
      </td>
      <td>
        <div>Mengetahui & Menyetujui,</div>
        <div style="font-weight: bold;">Direksi / Manajemen Proyek</div>
        <div class="sig-space"></div>
        <div style="font-weight: bold; text-decoration: underline;">Ir. Hendra Gunawan, MT.</div>
        <div style="color: #64748b;">Direktur Operasional Proyek</div>
      </td>
    </tr>
  </table>

</body>
</html>
