<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>
<!-- Top Selector & Controls -->
<div class="card card-modern mb-4 bg-white">
  <div class="card-body p-4 d-flex flex-wrap align-items-center justify-content-between gap-3">
    <div>
      <div class="d-flex align-items-center gap-2 mb-1">
        <span class="badge bg-dark-subtle text-dark border">Hasil Metode SAW</span>
        <?php if ($activePeriode['status'] === 'terhitung'): ?>
          <span class="badge bg-success-subtle text-success border border-success-subtle"><i class="bi bi-check-circle-fill me-1"></i> Terhitung</span>
        <?php else: ?>
          <span class="badge bg-warning-subtle text-warning border border-warning-subtle"><i class="bi bi-hourglass-split me-1"></i> Draft</span>
        <?php endif; ?>
      </div>
      <h3 class="fw-bold mb-1 text-dark"><?= esc($activePeriode['nama']) ?></h3>
      <div class="text-muted small">
        <i class="bi bi-calendar-event me-1"></i> Tanggal Penilaian: <strong><?= date('d F Y', strtotime($activePeriode['tanggal_penilaian'])) ?></strong>
        &bull; Presisi Hitung: 4 Desimal &bull; Tampilan: 2 Desimal
      </div>
    </div>

    <div class="d-flex align-items-center gap-2">
      <!-- Period Switcher Dropdown -->
      <div class="dropdown">
        <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
          <i class="bi bi-calendar3 me-1"></i> Ganti Periode
        </button>
        <ul class="dropdown-menu dropdown-menu-end shadow-sm" style="max-height: 250px; overflow-y: auto;">
          <?php foreach ($allPeriodes as $p): ?>
            <li>
              <a class="dropdown-item small d-flex justify-content-between align-items-center <?= ($p['id'] == $activePeriode['id']) ? 'active' : '' ?>" href="<?= site_url('hasil/' . $p['id']) ?>">
                <span><?= esc($p['nama']) ?></span>
                <span class="badge <?= ($p['status'] === 'terhitung') ? 'bg-success' : 'bg-secondary' ?> ms-2" style="font-size:0.65rem;"><?= $p['status'] ?></span>
              </a>
            </li>
          <?php endforeach; ?>
        </ul>
      </div>

      <a href="<?= site_url('penilaian/' . $activePeriode['id']) ?>" class="btn btn-sm btn-outline-primary">
        <i class="bi bi-pencil me-1"></i> Data Mentah
      </a>
      <a href="<?= site_url('periode/hitung/' . $activePeriode['id']) ?>" class="btn btn-sm btn-amber fw-semibold">
        <i class="bi bi-arrow-repeat me-1"></i> Hitung Ulang
      </a>

      <?php if (!empty($hasilList)): ?>
        <a href="<?= site_url('hasil/pdf/' . $activePeriode['id']) ?>" target="_blank" class="btn btn-sm btn-danger d-flex align-items-center gap-1 shadow-sm">
          <i class="bi bi-file-earmark-pdf-fill"></i>
          <span>Cetak PDF</span>
        </a>
      <?php endif; ?>
    </div>
  </div>
</div>

<?php if (empty($hasilList)): ?>
  <div class="alert alert-warning d-flex align-items-center gap-2 p-3 shadow-sm">
    <i class="bi bi-exclamation-triangle-fill fs-4 text-warning"></i>
    <div>
      <strong>Periode ini belum memiliki hasil perhitungan SAW.</strong>
      <?php if (session()->get('user_role') === 'admin'): ?>
        Silakan klik tombol <a href="<?= site_url('periode/hitung/' . $activePeriode['id']) ?>" class="alert-link fw-bold">Hitung SAW Sekarang</a> untuk memulai perhitungan preferensi.
      <?php else: ?>
        Silakan hubungi Administrator untuk memproses perhitungan kinerja proyek periode ini.
      <?php endif; ?>
    </div>
  </div>
<?php else: ?>

  <!-- Stat Summary Cards Kategori -->
  <div class="row g-3 mb-4">
    <div class="col-sm-6 col-xl-3">
      <div class="stat-card">
        <div class="stat-card-inner">
          <div>
            <div class="stat-label">Total Proyek</div>
            <div class="stat-value"><?= count($hasilList) ?></div>
          </div>
          <div class="stat-icon stat-icon-primary">
            <i class="bi bi-buildings"></i>
          </div>
        </div>
      </div>
    </div>

    <div class="col-sm-6 col-xl-3">
      <div class="stat-card">
        <div class="stat-card-inner">
          <div>
            <div class="stat-label">Kategori Baik</div>
            <div class="stat-value text-success"><?= $kategoriCount['Baik'] ?? 0 ?></div>
          </div>
          <div class="stat-icon stat-icon-green">
            <i class="bi bi-check-circle-fill"></i>
          </div>
        </div>
      </div>
    </div>

    <div class="col-sm-6 col-xl-3">
      <div class="stat-card">
        <div class="stat-card-inner">
          <div>
            <div class="stat-label">Perlu Perhatian</div>
            <div class="stat-value text-warning"><?= $kategoriCount['Perlu Perhatian'] ?? 0 ?></div>
          </div>
          <div class="stat-icon stat-icon-amber">
            <i class="bi bi-exclamation-triangle-fill"></i>
          </div>
        </div>
      </div>
    </div>

    <div class="col-sm-6 col-xl-3">
      <div class="stat-card">
        <div class="stat-card-inner">
          <div>
            <div class="stat-label">Berisiko / Terlambat</div>
            <div class="stat-value text-danger"><?= $kategoriCount['Berisiko/Terlambat'] ?? 0 ?></div>
          </div>
          <div class="stat-icon stat-icon-red">
            <i class="bi bi-shield-slash-fill"></i>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Tabel Hasil: Peringkat & Kategori -->
  <div class="card card-modern">
    <div class="card-header bg-white py-3 px-4 border-bottom d-flex flex-wrap align-items-center justify-content-between gap-2">
      <div class="d-flex align-items-center gap-2">
        <i class="bi bi-trophy-fill text-warning fs-5"></i>
        <h5 class="fw-bold mb-0 text-dark">Peringkat & Kategori Kinerja Proyek</h5>
      </div>
      <span class="badge bg-light text-secondary border">Total: <?= count($hasilList) ?> Proyek Terdaftar</span>
    </div>

    <div class="card-body p-0">
      <div class="table-responsive">
        <table class="table table-modern table-hover align-middle mb-0">
          <thead>
            <tr>
              <th style="width: 80px;" class="text-center">Peringkat</th>
              <th>Kode & Nama Proyek</th>
              <th>Jenis</th>
              <th>Klien & Lokasi</th>
              <th class="text-end">Nilai RAB (Rp)</th>
              <th class="text-center">Skor Kinerja Akhir</th>
              <th class="text-center">Kategori Kinerja</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($hasilList as $h): ?>
              <tr>
                <!-- Rank Badge -->
                <td class="text-center">
                  <?php if ($h['peringkat'] == 1): ?>
                    <span class="rank-badge rank-gold" title="Peringkat 1">1</span>
                  <?php elseif ($h['peringkat'] == 2): ?>
                    <span class="rank-badge rank-silver" title="Peringkat 2">2</span>
                  <?php elseif ($h['peringkat'] == 3): ?>
                    <span class="rank-badge rank-bronze" title="Peringkat 3">3</span>
                  <?php else: ?>
                    <span class="rank-badge rank-normal"><?= $h['peringkat'] ?></span>
                  <?php endif; ?>
                </td>

                <!-- Nama Proyek -->
                <td>
                  <div class="fw-bold text-dark fs-6"><?= esc($h['proyek_nama']) ?></div>
                  <span class="badge bg-light text-secondary border font-monospace"><?= esc($h['proyek_kode']) ?></span>
                </td>

                <!-- Jenis -->
                <td>
                  <span class="badge bg-light text-dark border text-capitalize"><?= esc($h['jenis']) ?></span>
                </td>

                <!-- Klien & Lokasi -->
                <td class="small">
                  <div class="fw-semibold text-dark"><?= esc($h['klien']) ?></div>
                  <div class="text-muted" style="font-size:0.75rem;"><i class="bi bi-geo-alt me-1"></i><?= esc($h['lokasi']) ?></div>
                </td>

                <!-- RAB -->
                <td class="text-end mono-num text-dark fw-bold">
                  Rp <?= number_format((float)$h['nilai_rab'], 0, ',', '.') ?>
                </td>

                <!-- Vi -->
                <td class="text-center">
                  <div class="fs-5 fw-bold mono-num text-dark">
                    <?= number_format((float)$h['vi'], 2) ?>
                  </div>
                  <div class="text-muted" style="font-size:0.72rem;">(<?= number_format((float)$h['vi'], 4) ?>)</div>
                </td>

                <!-- Kategori Badge -->
                <td class="text-center">
                  <?php if ($h['kategori'] === 'Baik'): ?>
                    <span class="badge-kategori badge-baik">
                      <i class="bi bi-check-circle-fill"></i> Baik
                    </span>
                  <?php elseif ($h['kategori'] === 'Perlu Perhatian'): ?>
                    <span class="badge-kategori badge-perhatian">
                      <i class="bi bi-exclamation-triangle-fill"></i> Perlu Perhatian
                    </span>
                  <?php else: ?>
                    <span class="badge-kategori badge-berisiko">
                      <i class="bi bi-x-circle-fill"></i> Berisiko/Terlambat
                    </span>
                  <?php endif; ?>
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>

      <!-- Rekomendasi Singkat Manajemen -->
      <div class="p-4 bg-light border-top">
        <h6 class="fw-bold mb-3 text-dark"><i class="bi bi-lightbulb-fill text-warning me-2"></i>Rekomendasi Tindakan Manajemen (Berdasarkan Kategori)</h6>
        <div class="row g-3">
          <div class="col-md-4">
            <div class="p-3 bg-white rounded border border-success-subtle h-100">
              <div class="d-flex align-items-center gap-2 mb-2 text-success fw-bold">
                <i class="bi bi-check-circle-fill"></i> Kategori Baik (Skor Minimal <?= number_format($batasBaik, 2) ?> ke Atas)
              </div>
              <p class="small text-muted mb-0">
                Proyek berjalan sesuai Kurva S, efisiensi anggaran terjaga, dan dokumentasi foto lapangan lengkap. Pertahankan ritme kerja dan koordinasi mitra.
              </p>
            </div>
          </div>
          <div class="col-md-4">
            <div class="p-3 bg-white rounded border border-warning-subtle h-100">
              <div class="d-flex align-items-center gap-2 mb-2 text-warning fw-bold">
                <i class="bi bi-exclamation-triangle-fill"></i> Perlu Perhatian (Skor <?= number_format($batasPerhatian, 2) ?> s/d <?= number_format($batasBaik - 0.01, 2) ?>)
              </div>
              <p class="small text-muted mb-0">
                Terdapat deviasi ringan pada progres fisik, kenaikan pengeluaran biaya, atau keterlambatan waktu serah terima. Lakukan rapat evaluasi berkala segera.
              </p>
            </div>
          </div>
          <div class="col-md-4">
            <div class="p-3 bg-white rounded border border-danger-subtle h-100">
              <div class="d-flex align-items-center gap-2 mb-2 text-danger fw-bold">
                <i class="bi bi-exclamation-octagon-fill"></i> Berisiko / Terlambat (Skor di Bawah <?= number_format($batasPerhatian, 2) ?>)
              </div>
              <p class="small text-muted mb-0">
                Prioritas intervensi penanganan segera! Terapkan percepatan jadwal, penambahan tenaga kerja, evaluasi hambatan teknis, dan audit pengeluaran RAB.
              </p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

<?php endif; ?>

<?= $this->endSection() ?>
