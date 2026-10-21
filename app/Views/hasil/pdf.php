<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>Laporan Eksekutif Penilaian Kinerja Proyek - PT Rancang Bangun Sedaya</title>
  <style>
    @page {
      margin: 18px 22px;
    }
    body {
      font-family: 'Helvetica', Arial, sans-serif;
      font-size: 9.5px;
      color: #1e293b;
      line-height: 1.35;
      margin: 0;
      padding: 0;
    }
    .header-table {
      width: 100%;
      border-bottom: 2px solid #0f172a;
      padding-bottom: 6px;
      margin-bottom: 12px;
    }
    .company-name {
      font-size: 15px;
      font-weight: bold;
      color: #0f172a;
      text-transform: uppercase;
      letter-spacing: 0.5px;
    }
    .company-sub {
      font-size: 8.5px;
      color: #475569;
      line-height: 1.25;
    }
    .doc-title {
      text-align: center;
      font-size: 12.5px;
      font-weight: bold;
      color: #0f172a;
      margin-bottom: 2px;
      text-transform: uppercase;
      letter-spacing: 0.3px;
    }
    .doc-sub {
      text-align: center;
      font-size: 9px;
      color: #64748b;
      margin-bottom: 10px;
    }
    .meta-table {
      width: 100%;
      margin-bottom: 12px;
      font-size: 8.5px;
      border: 1px solid #cbd5e1;
      background-color: #f8fafc;
      border-collapse: collapse;
    }
    .meta-table td {
      padding: 4px 6px;
      border: 1px solid #e2e8f0;
    }
    .section-title {
      font-size: 10px;
      font-weight: bold;
      color: #0f172a;
      text-transform: uppercase;
      letter-spacing: 0.4px;
      border-bottom: 1.5px solid #0f172a;
      padding-bottom: 3px;
      margin-top: 14px;
      margin-bottom: 8px;
    }
    .data-table {
      width: 100%;
      border-collapse: collapse;
      margin-bottom: 12px;
    }
    .data-table th {
      background-color: #0f172a;
      color: #ffffff;
      font-size: 8px;
      font-weight: bold;
      text-transform: uppercase;
      padding: 5px 4px;
      border: 1px solid #0f172a;
      text-align: center;
    }
    .data-table td {
      padding: 4px 5px;
      border: 1px solid #cbd5e1;
      font-size: 8.5px;
    }
    .data-table tr:nth-child(even) {
      background-color: #f8fafc;
    }
    .project-card {
      width: 100%;
      border: 1px solid #cbd5e1;
      margin-bottom: 10px;
      border-collapse: collapse;
      page-break-inside: avoid;
      background-color: #ffffff;
    }
    .project-card-header {
      background-color: #0f172a;
      color: #ffffff;
      padding: 5px 8px;
      font-weight: bold;
      font-size: 9px;
      border-bottom: 1px solid #0f172a;
    }
    .project-card-body-table {
      width: 100%;
      border-collapse: collapse;
    }
    .project-card-col-left {
      width: 53%;
      padding: 6px 8px;
      vertical-align: top;
      border-right: 1px solid #cbd5e1;
      background-color: #ffffff;
    }
    .project-card-col-right {
      width: 47%;
      padding: 6px 8px;
      vertical-align: top;
      background-color: #fcfdfe;
    }
    .inner-table {
      width: 100%;
      border-collapse: collapse;
      font-size: 8.5px;
    }
    .inner-table td {
      padding: 2px 3px;
      vertical-align: top;
    }
    .inner-table td.lbl {
      color: #475569;
      width: 32%;
      font-weight: 500;
    }
    .inner-table td.val {
      color: #0f172a;
      font-weight: 600;
    }
    .score-table {
      width: 100%;
      border-collapse: collapse;
      font-size: 8px;
    }
    .score-table th {
      background-color: #f1f5f9;
      color: #334155;
      font-weight: bold;
      text-align: left;
      padding: 2.5px 4px;
      border: 1px solid #e2e8f0;
      font-size: 7.5px;
      text-transform: uppercase;
    }
    .score-table td {
      padding: 2.5px 4px;
      border: 1px solid #e2e8f0;
    }
    .badge-baik {
      background-color: #ecfdf5;
      color: #047857;
      font-weight: bold;
      padding: 1.5px 5px;
      border: 1px solid #a7f3d0;
      border-radius: 2px;
      font-size: 8px;
      display: inline-block;
    }
    .badge-perhatian {
      background-color: #fffbeb;
      color: #b45309;
      font-weight: bold;
      padding: 1.5px 5px;
      border: 1px solid #fde68a;
      border-radius: 2px;
      font-size: 8px;
      display: inline-block;
    }
    .badge-berisiko {
      background-color: #fef2f2;
      color: #b91c1c;
      font-weight: bold;
      padding: 1.5px 5px;
      border: 1px solid #fecdd3;
      border-radius: 2px;
      font-size: 8px;
      display: inline-block;
    }
    .recommendation-box {
      border: 1px solid #cbd5e1;
      background-color: #f8fafc;
      padding: 8px;
      margin-top: 14px;
      margin-bottom: 16px;
      border-radius: 3px;
      page-break-inside: avoid;
    }
    .recommendation-title {
      font-weight: bold;
      font-size: 9.5px;
      color: #0f172a;
      margin-bottom: 5px;
      text-transform: uppercase;
      letter-spacing: 0.3px;
    }
    .sig-table {
      width: 100%;
      margin-top: 18px;
      page-break-inside: avoid;
      border-collapse: collapse;
    }
    .sig-table td {
      width: 50%;
      text-align: center;
      vertical-align: top;
      font-size: 9px;
    }
    .sig-space {
      height: 52px;
    }
    .text-center { text-align: center; }
    .text-right { text-align: right; }
    .text-left { text-align: left; }
    .fw-bold { font-weight: bold; }
    .text-success { color: #047857; }
    .text-danger { color: #b91c1c; }
    .text-muted { color: #64748b; }
  </style>
</head>
<body>

  <!-- Kop Surat Resmi -->
  <table class="header-table">
    <tr>
      <td style="width: 68%;">
        <div class="company-name"><?= esc($settings['nama_perusahaan'] ?? 'PT RANCANG BANGUN SEDAYA') ?></div>
        <div class="company-sub" style="font-weight: bold; color: #1e293b;">General Contractor, Architecture & Project Management</div>
        <div class="company-sub"><?= esc($settings['alamat_perusahaan'] ?? '(Head Quarter): Pasirmulya, Kecamatan Bogor Barat, Kota Bogor, Jawa Barat 16118') ?></div>
      </td>
      <td style="width: 32%; text-align: right; vertical-align: middle;">
        <div style="font-size: 10px; font-weight: bold; color: #d97706; text-transform: uppercase;">Sistem Pendukung Keputusan</div>
        <div style="font-size: 8px; color: #475569;">Metode Simple Additive Weighting (SAW)</div>
        <div style="font-size: 7.5px; color: #64748b; margin-top: 2px;">Dokumen Eksekutif Resmi</div>
      </td>
    </tr>
  </table>

  <!-- Judul Dokumen -->
  <div class="doc-title">Laporan Penilaian & Perangkingan Kinerja Proyek</div>
  <div class="doc-sub">Ringkasan Evaluasi Multikriteria (C1&ndash;C7), Realisasi Biaya (RAB), Jadwal, & Skor Lapangan</div>

  <!-- Metadata Laporan -->
  <table class="meta-table">
    <tr>
      <td style="width: 18%; font-weight: bold;">Sesi Evaluasi</td>
      <td style="width: 32%;">: <?= esc($periode['nama'] ?? 'Periode Aktif') ?></td>
      <td style="width: 18%; font-weight: bold;">Tanggal Dokumen</td>
      <td style="width: 32%;">: <?= $printDate ?></td>
    </tr>
    <tr>
      <td style="font-weight: bold;">Dicetak Oleh</td>
      <td>: <?= !empty($printedBy) && $printedBy !== 'Administrator' ? esc($printedBy) : 'Muhamad Firdaus' ?> (Administrator SPK)</td>
      <td style="font-weight: bold;">Status Evaluasi</td>
      <td>: Terkalkulasi Otomatis (Metode SAW)</td>
    </tr>
    <tr>
      <td style="font-weight: bold;">Jumlah Proyek</td>
      <td>: <?= count($hasilList) ?> Proyek Konstruksi</td>
      <td style="font-weight: bold;">Kriteria Standar</td>
      <td>: 7 Parameter (Mutu, Biaya, Foto, BAST, Waktu, Kepuasan, K3)</td>
    </tr>
    <tr>
      <td style="font-weight: bold;">Ambang Batas</td>
      <td colspan="3">: 
        <span class="badge-baik">Baik &ge; <?= number_format($batasBaik, 2) ?></span> &bull; 
        <span class="badge-perhatian">Perlu Perhatian <?= number_format($batasPerhatian, 2) ?> &ndash; <?= number_format($batasBaik - 0.01, 2) ?></span> &bull; 
        <span class="badge-berisiko">Berisiko/Terlambat &lt; <?= number_format($batasPerhatian, 2) ?></span>
      </td>
    </tr>
  </table>

  <!-- BAGIAN 1: REKAPITULASI EKSEKUTIF -->
  <div class="section-title">I. Rekapitulasi Eksekutif Hasil Penilaian Proyek</div>
  <table class="data-table">
    <thead>
      <tr>
        <th style="width: 24px;">Rank</th>
        <th style="width: 48px;">Kode</th>
        <th>Nama Proyek & Klien</th>
        <th style="width: 45px;">Jenis</th>
        <th style="width: 78px;" class="text-right">RAB (Rp)</th>
        <th style="width: 78px;" class="text-right">Realisasi (Rp)</th>
        <th style="width: 38px;">C2 (%)</th>
        <th style="width: 36px;">C5 (Hr)</th>
        <th style="width: 46px;">Skor SAW</th>
        <th style="width: 76px;">Kategori</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($hasilList as $h): ?>
        <?php 
          $rab       = (float)($h['nilai_rab'] ?? 0);
          $realisasi = !empty($h['biaya_realisasi']) 
                        ? (float)$h['biaya_realisasi'] 
                        : ($rab * ((float)($h['c2'] ?? 100) / 100));
        ?>
        <tr>
          <td class="text-center fw-bold" style="font-size: 9px;"><?= $h['peringkat'] ?></td>
          <td class="text-center fw-bold"><?= esc($h['proyek_kode']) ?></td>
          <td>
            <div class="fw-bold"><?= esc($h['proyek_nama']) ?></div>
            <div style="font-size: 7.5px; color: #64748b;"><?= esc($h['klien'] ?? '-') ?> &bull; <?= esc($h['lokasi'] ?? '-') ?></div>
          </td>
          <td class="text-center" style="text-transform: capitalize;"><?= esc($h['jenis']) ?></td>
          <td class="text-right"><?= number_format($rab, 0, ',', '.') ?></td>
          <td class="text-right"><?= number_format($realisasi, 0, ',', '.') ?></td>
          <td class="text-center"><?= number_format((float)$h['c2'], 1) ?>%</td>
          <td class="text-center"><?= (int)$h['c5'] ?></td>
          <td class="text-center fw-bold" style="font-size: 9.5px; color: #0f172a;"><?= number_format((float)$h['vi'], 4) ?></td>
          <td class="text-center">
            <?php if ($h['kategori'] === 'Baik'): ?>
              <span class="badge-baik">Baik</span>
            <?php elseif ($h['kategori'] === 'Perlu Perhatian'): ?>
              <span class="badge-perhatian">Perlu Perhatian</span>
            <?php else: ?>
              <span class="badge-berisiko">Berisiko</span>
            <?php endif; ?>
          </td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>

  <!-- BAGIAN 2: RINGKASAN RINCI PERFORMA PROYEK LAPANGAN -->
  <div class="section-title">II. Ringkasan Rinci Performa Proyek & Realisasi Lapangan</div>

  <?php foreach ($hasilList as $h): ?>
    <?php 
      $rab       = (float)($h['nilai_rab'] ?? 0);
      $realisasi = !empty($h['biaya_realisasi']) 
                    ? (float)$h['biaya_realisasi'] 
                    : ($rab * ((float)($h['c2'] ?? 100) / 100));
      $selisih   = $rab - $realisasi;
      $rasioBiaya = (float)($h['c2'] ?? 0);

      // Tanggal & Jadwal
      $tglMulai    = !empty($h['tanggal_mulai']) ? date('d/m/Y', strtotime($h['tanggal_mulai'])) : '-';
      $tglRencana  = !empty($h['tanggal_selesai_rencana']) ? date('d/m/Y', strtotime($h['tanggal_selesai_rencana'])) : '-';
      $tglAktual   = !empty($h['tanggal_selesai_aktual']) ? date('d/m/Y', strtotime($h['tanggal_selesai_aktual'])) : '-';
      
      $statusJadwal = 'Sesuai Jadwal';
      if (!empty($h['tanggal_selesai_rencana']) && !empty($h['tanggal_selesai_aktual'])) {
        $diffDays = (int)round((strtotime($h['tanggal_selesai_aktual']) - strtotime($h['tanggal_selesai_rencana'])) / 86400);
        if ($diffDays > 0) {
          $statusJadwal = 'Terlambat ' . $diffDays . ' Hari';
        } elseif ($diffDays < 0) {
          $statusJadwal = 'Lebih Cepat ' . abs($diffDays) . ' Hari';
        } else {
          $statusJadwal = 'Tepat Waktu';
        }
      }
    ?>

    <div class="project-card">
      <!-- Header Bar Proyek -->
      <table style="width: 100%; border-collapse: collapse;">
        <tr>
          <td class="project-card-header" style="width: 65%;">
            <span style="color: #f59e0b; margin-right: 4px;">#<?= $h['peringkat'] ?></span> 
            [<?= esc($h['proyek_kode']) ?>] <?= esc($h['proyek_nama']) ?>
          </td>
          <td class="project-card-header text-right" style="width: 35%;">
            <span style="font-weight: normal; font-size: 8px; margin-right: 5px;">Skor SAW (V): <strong><?= number_format((float)$h['vi'], 4) ?></strong></span>
            <?php if ($h['kategori'] === 'Baik'): ?>
              <span class="badge-baik">Baik</span>
            <?php elseif ($h['kategori'] === 'Perlu Perhatian'): ?>
              <span class="badge-perhatian">Perlu Perhatian</span>
            <?php else: ?>
              <span class="badge-berisiko">Berisiko</span>
            <?php endif; ?>
          </td>
        </tr>
      </table>

      <!-- Body 2 Kolom -->
      <table class="project-card-body-table">
        <tr>
          <!-- Sisi Kiri: Identitas & Realisasi Finansial/Jadwal -->
          <td class="project-card-col-left">
            <div style="font-size: 8px; font-weight: bold; color: #0f172a; text-transform: uppercase; margin-bottom: 4px; border-bottom: 1px dashed #cbd5e1; padding-bottom: 2px;">
              Identitas & Realisasi Lapangan
            </div>
            <table class="inner-table">
              <tr>
                <td class="lbl">Klien / Owner</td>
                <td class="val">: <?= esc($h['klien'] ?? '-') ?></td>
              </tr>
              <tr>
                <td class="lbl">Lokasi Proyek</td>
                <td class="val">: <?= esc($h['lokasi'] ?? '-') ?></td>
              </tr>
              <tr>
                <td class="lbl">Jenis Bangunan</td>
                <td class="val">: <?= ucfirst(esc($h['jenis'] ?? '-')) ?></td>
              </tr>
              <tr>
                <td class="lbl">Anggaran (RAB)</td>
                <td class="val">: Rp <?= number_format($rab, 0, ',', '.') ?></td>
              </tr>
              <tr>
                <td class="lbl">Realisasi Biaya</td>
                <td class="val">: Rp <?= number_format($realisasi, 0, ',', '.') ?></td>
              </tr>
              <tr>
                <td class="lbl">Deviasi Anggaran</td>
                <td class="val">: 
                  <?php if ($selisih >= 0): ?>
                    <span class="text-success fw-bold">Efisien Rp <?= number_format($selisih, 0, ',', '.') ?> (<?= number_format($rasioBiaya, 1) ?>%)</span>
                  <?php else: ?>
                    <span class="text-danger fw-bold">Overbudget Rp <?= number_format(abs($selisih), 0, ',', '.') ?> (<?= number_format($rasioBiaya, 1) ?>%)</span>
                  <?php endif; ?>
                </td>
              </tr>
              <tr>
                <td class="lbl">Jadwal Rencana</td>
                <td class="val">: <?= $tglMulai ?> s.d. <?= $tglRencana ?></td>
              </tr>
              <tr>
                <td class="lbl">Selesai Aktual</td>
                <td class="val">: <?= $tglAktual ?> (<?= $statusJadwal ?>)</td>
              </tr>
              <tr>
                <td class="lbl">Durasi Lapangan</td>
                <td class="val">: <?= (int)$h['c5'] ?> Hari Kalender</td>
              </tr>
            </table>
          </td>

          <!-- Sisi Kanan: Skor Poin 7 Kriteria (C1 - C7) -->
          <td class="project-card-col-right">
            <div style="font-size: 8px; font-weight: bold; color: #0f172a; text-transform: uppercase; margin-bottom: 4px; border-bottom: 1px dashed #cbd5e1; padding-bottom: 2px;">
              Poin & Skor Kriteria Lapangan (C1&ndash;C7)
            </div>
            <table class="score-table">
              <thead>
                <tr>
                  <th style="width: 22px;">Kode</th>
                  <th>Kriteria Penilaian</th>
                  <th style="width: 32px;" class="text-center">Sifat</th>
                  <th style="width: 48px;" class="text-right">Nilai Lapangan</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td class="text-center fw-bold">C1</td>
                  <td>Mutu & Kualitas Hasil Fisik</td>
                  <td class="text-center" style="font-size: 7px; color: #047857;">Benefit</td>
                  <td class="text-right fw-bold"><?= (int)($h['progres_aktual'] ?? $h['c1']) ?> / 5</td>
                </tr>
                <tr>
                  <td class="text-center fw-bold">C2</td>
                  <td>Pengendalian Biaya vs RAB</td>
                  <td class="text-center" style="font-size: 7px; color: #b91c1c;">Cost</td>
                  <td class="text-right fw-bold"><?= number_format((float)$h['c2'], 1) ?>%</td>
                </tr>
                <tr>
                  <td class="text-center fw-bold">C3</td>
                  <td>Dokumentasi Foto Progres Lapangan</td>
                  <td class="text-center" style="font-size: 7px; color: #047857;">Benefit</td>
                  <td class="text-right fw-bold"><?= (int)($h['skor_foto_progres'] ?? $h['c3']) ?> / 5</td>
                </tr>
                <tr>
                  <td class="text-center fw-bold">C4</td>
                  <td>Ketepatan Berita Acara (BAST)</td>
                  <td class="text-center" style="font-size: 7px; color: #047857;">Benefit</td>
                  <td class="text-right fw-bold"><?= (int)($h['skor_bast'] ?? $h['c4']) ?> / 5</td>
                </tr>
                <tr>
                  <td class="text-center fw-bold">C5</td>
                  <td>Durasi Waktu Pelaksanaan</td>
                  <td class="text-center" style="font-size: 7px; color: #b91c1c;">Cost</td>
                  <td class="text-right fw-bold"><?= (int)$h['c5'] ?> Hari</td>
                </tr>
                <tr>
                  <td class="text-center fw-bold">C6</td>
                  <td>Tingkat Kepuasan Klien / Owner</td>
                  <td class="text-center" style="font-size: 7px; color: #047857;">Benefit</td>
                  <td class="text-right fw-bold"><?= (int)($h['skor_kepuasan_klien'] ?? $h['c6'] ?? 5) ?> / 5</td>
                </tr>
                <tr>
                  <td class="text-center fw-bold">C7</td>
                  <td>Penerapan Disiplin K3 Lapangan</td>
                  <td class="text-center" style="font-size: 7px; color: #047857;">Benefit</td>
                  <td class="text-right fw-bold"><?= (int)($h['skor_k3'] ?? $h['c7'] ?? 5) ?> / 5</td>
                </tr>
              </tbody>
            </table>
          </td>
        </tr>
      </table>
    </div>
  <?php endforeach; ?>

  <!-- BAGIAN 3: REKOMENDASI MANAJERIAL -->
  <div class="recommendation-box">
    <div class="recommendation-title">III. Catatan & Rekomendasi Manajerial (Direksi):</div>
    <table style="width: 100%; font-size: 8.5px; border-collapse: collapse;">
      <tr>
        <td style="width: 24%; font-weight: bold; color: #047857; vertical-align: top; padding: 2px 0;">Kategori Baik:</td>
        <td style="color: #334155; vertical-align: top; padding: 2px 0;">Kinerja proyek berjalan prima sesuai jadwal kurva rencana dan anggaran RAB terkendali efisien. Pertahankan SOP pengawasan mutu fisik dan kepuasan klien sebagai standar acuan portofolio perusahaan.</td>
      </tr>
      <tr>
        <td style="font-weight: bold; color: #b45309; vertical-align: top; padding: 3px 0;">Kategori Perlu Perhatian:</td>
        <td style="color: #334155; vertical-align: top; padding: 3px 0;">Terdapat deviasi ringan pada serapan anggaran RAB atau penundaan jadwal serah terima (BAST). Direkomendasikan evaluasi berkala mingguan (site meeting) dan pengetatan pengawasan material.</td>
      </tr>
      <tr>
        <td style="font-weight: bold; color: #b91c1c; vertical-align: top; padding: 3px 0;">Kategori Berisiko:</td>
        <td style="color: #334155; vertical-align: top; padding: 3px 0;">Memerlukan intervensi manajemen segera: percepatan durasi kerja (crashing / fast-tracking), audit biaya realisasi lapangan, audit kepatuhan K3 keselamatan kerja, serta evaluasi mandor / subkontraktor pelaksana.</td>
      </tr>
    </table>
  </div>

  <!-- BAGIAN 4: PENGESAHAN DOKUMEN -->
  <table class="sig-table">
    <tr>
      <td>
        <div>Bogor, <?= $printDate ?></div>
        <div style="margin-top: 3px;">Dibuat Oleh,</div>
        <div style="font-weight: bold; color: #0f172a;">Administrator SPK</div>
        <div class="sig-space"></div>
        <div style="font-weight: bold; text-decoration: underline; color: #0f172a;"><?= !empty($printedBy) && $printedBy !== 'Administrator' ? esc($printedBy) : 'Muhamad Firdaus' ?></div>
        <div style="color: #64748b; font-size: 8px;">Pengelola Sistem SPK Konstruksi</div>
      </td>
      <td>
        <div style="visibility: hidden;">Tanggal Pengesahan</div>
        <div style="margin-top: 3px;">Mengetahui & Menyetujui,</div>
        <div style="font-weight: bold; color: #0f172a;">Direksi / Manajemen Proyek</div>
        <div class="sig-space"></div>
        <div style="font-weight: bold; text-decoration: underline; color: #0f172a;">Ir. Hendra Gunawan, MT.</div>
        <div style="color: #64748b; font-size: 8px;">Direktur Operasional Proyek</div>
      </td>
    </tr>
  </table>

</body>
</html>
