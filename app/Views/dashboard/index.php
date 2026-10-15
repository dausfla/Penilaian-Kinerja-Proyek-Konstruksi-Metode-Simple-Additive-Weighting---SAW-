<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>
<!-- Welcome Banner -->
<div class="card card-modern mb-4 text-white" style="background: linear-gradient(135deg, #0f172a 0%, #1e293b 60%, #090d16 100%); border-left: 5px solid var(--amber-500);">
  <div class="card-body p-4 d-flex flex-wrap align-items-center justify-content-between gap-3">
    <div>
      <span class="badge bg-warning text-dark px-3 py-1 fw-bold mb-2">PT RANCANG BANGUN SEDAYA</span>
      <h3 class="fw-bold mb-1 text-white">Sistem Penilaian Kinerja Proyek Konstruksi</h3>
      <p class="text-white-50 small mb-0">
        Monitoring berkala berbasis Kurva S, efisiensi RAB, dokumentasi foto progres lapangan, dan Berita Acara Serah Terima (Metode SAW).
      </p>
    </div>
    <div class="d-flex align-items-center gap-2">
      <a href="<?= site_url('periode/create') ?>" class="btn btn-amber fw-semibold shadow-sm">
        <i class="bi bi-calendar-plus me-1"></i> Buat Periode Baru
      </a>
      <?php if ($latestPeriode): ?>
        <a href="<?= site_url('hasil/' . $latestPeriode['id']) ?>" class="btn btn-light fw-semibold shadow-sm">
          <i class="bi bi-trophy me-1 text-warning"></i> Lihat Hasil Periode Terbaru
        </a>
      <?php endif; ?>
    </div>
  </div>
</div>

<!-- Stat Cards -->
<div class="row g-3 mb-4">
  <div class="col-sm-6 col-xl-3">
    <div class="stat-card">
      <div class="stat-card-inner">
        <div>
          <div class="stat-label">Total Proyek</div>
          <div class="stat-value"><?= $totalProyek ?></div>
          <div class="text-muted small mt-1">Proyek Terdaftar</div>
        </div>
        <div class="stat-icon stat-icon-primary">
          <i class="bi bi-building"></i>
        </div>
      </div>
    </div>
  </div>

  <div class="col-sm-6 col-xl-3">
    <div class="stat-card">
      <div class="stat-card-inner">
        <div>
          <div class="stat-label">Sesi Periode</div>
          <div class="stat-value"><?= $totalPeriode ?></div>
          <div class="text-muted small mt-1">Evaluasi Terjadwal</div>
        </div>
        <div class="stat-icon stat-icon-amber">
          <i class="bi bi-calendar-check"></i>
        </div>
      </div>
    </div>
  </div>

  <div class="col-sm-6 col-xl-3">
    <div class="stat-card">
      <div class="stat-card-inner">
        <div>
          <div class="stat-label">Kinerja Baik</div>
          <div class="stat-value text-success"><?= $kategoriCount['Baik'] ?? 0 ?></div>
          <div class="text-muted small mt-1">Skor Kinerja 0,80 ke Atas</div>
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
          <div class="stat-label">Perlu Tindakan</div>
          <div class="stat-value text-danger"><?= ($kategoriCount['Perlu Perhatian'] ?? 0) + ($kategoriCount['Berisiko/Terlambat'] ?? 0) ?></div>
          <div class="text-muted small mt-1">Deviasi & Terlambat</div>
        </div>
        <div class="stat-icon stat-icon-red">
          <i class="bi bi-exclamation-triangle-fill"></i>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="row g-4">
  <!-- Kolom Kiri: Peringkat Periode Terbaru -->
  <div class="col-lg-8">
    <div class="card card-modern h-100">
      <div class="card-header-modern bg-white">
        <div>
          <h5 class="fw-bold mb-1">
            <i class="bi bi-trophy-fill text-warning me-2"></i>Peringkat Periode Terbaru
          </h5>
          <?php if ($latestPeriode): ?>
            <p class="text-muted small mb-0">
              Periode: <strong><?= esc($latestPeriode['nama']) ?></strong> (<?= date('d M Y', strtotime($latestPeriode['tanggal_penilaian'])) ?>)
            </p>
          <?php endif; ?>
        </div>
        <?php if ($latestPeriode): ?>
          <a href="<?= site_url('hasil/' . $latestPeriode['id']) ?>" class="btn btn-sm btn-outline-secondary">
            Detail Lengkap <i class="bi bi-arrow-right ms-1"></i>
          </a>
        <?php endif; ?>
      </div>

      <?php if (empty($hasilTerbaru)): ?>
        <div class="card-body text-center py-5 text-muted">
          <i class="bi bi-bar-chart-line fs-1 d-block mb-2 text-secondary"></i>
          Belum ada hasil penilaian yang dihitung. Silakan masuk ke menu Periode Penilaian untuk memproses data.
        </div>
      <?php else: ?>
        <div class="table-responsive">
          <table class="table table-modern table-hover align-middle mb-0">
            <thead>
              <tr>
                <th style="width: 70px;" class="text-center">Rank</th>
                <th>Nama Proyek</th>
                <th>Jenis</th>
                <th class="text-end">RAB (Rp)</th>
                <th class="text-center">Skor Akhir</th>
                <th class="text-center">Kategori</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($hasilTerbaru as $h): ?>
                <tr>
                  <td class="text-center">
                    <?php if ($h['peringkat'] == 1): ?>
                      <span class="rank-badge rank-gold">1</span>
                    <?php elseif ($h['peringkat'] == 2): ?>
                      <span class="rank-badge rank-silver">2</span>
                    <?php elseif ($h['peringkat'] == 3): ?>
                      <span class="rank-badge rank-bronze">3</span>
                    <?php else: ?>
                      <span class="rank-badge rank-normal"><?= $h['peringkat'] ?></span>
                    <?php endif; ?>
                  </td>
                  <td>
                    <div class="fw-bold text-dark"><?= esc($h['proyek_nama']) ?></div>
                    <div class="text-muted small font-monospace"><?= esc($h['proyek_kode']) ?></div>
                  </td>
                  <td>
                    <span class="badge bg-light text-secondary border text-capitalize"><?= esc($h['jenis']) ?></span>
                  </td>
                  <td class="text-end mono-num text-dark small fw-semibold">
                    Rp <?= number_format((float)$h['nilai_rab'], 0, ',', '.') ?>
                  </td>
                  <td class="text-center mono-num fw-bold fs-6 text-dark">
                    <?= number_format((float)$h['vi'], 2) ?>
                  </td>
                  <td class="text-center">
                    <?php if ($h['kategori'] === 'Baik'): ?>
                      <span class="badge-kategori badge-baik">
                        <i class="bi bi-check-circle-fill"></i> Baik
                      </span>
                    <?php elseif ($h['kategori'] === 'Perlu Perhatian'): ?>
                      <span class="badge-kategori badge-perhatian">
                        <i class="bi bi-exclamation-triangle-fill"></i> Perhatian
                      </span>
                    <?php else: ?>
                      <span class="badge-kategori badge-berisiko">
                        <i class="bi bi-x-circle-fill"></i> Berisiko
                      </span>
                    <?php endif; ?>
                  </td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      <?php endif; ?>
    </div>
  </div>

  <!-- Kolom Kanan: Tiga Proyek Peringkat Terbawah & Distribusi -->
  <div class="col-lg-4">
    <!-- Card 3 Proyek Peringkat Terbawah -->
    <div class="card card-modern mb-4 border-danger-subtle">
      <div class="card-header bg-danger-subtle p-3 border-danger-subtle d-flex align-items-center justify-content-between">
        <h6 class="fw-bold mb-0 text-danger d-flex align-items-center gap-2">
          <i class="bi bi-exclamation-octagon-fill"></i>
          <span>Perlu Perhatian / Penanganan Segera</span>
        </h6>
        <span class="badge bg-danger text-white">Prioritas</span>
      </div>
      <div class="card-body p-3">
        <?php if (empty($tigaTerbawah)): ?>
          <p class="text-muted small mb-0">Belum ada data untuk dievaluasi.</p>
        <?php else: ?>
          <p class="text-muted small mb-3" style="font-size:0.78rem;">
            Daftar proyek peringkat terbawah yang memerlukan penanganan intervensi cepat dari manajemen:
          </p>
          <div class="d-flex flex-column gap-2">
            <?php foreach ($tigaTerbawah as $bot): ?>
              <div class="p-2 rounded border bg-light d-flex align-items-center justify-content-between">
                <div>
                  <div class="fw-bold small text-dark"><?= esc($bot['proyek_nama']) ?></div>
                  <div class="text-muted" style="font-size:0.72rem;">
                    Peringkat #<?= $bot['peringkat'] ?> &bull; Skor Kinerja: <strong><?= number_format((float)$bot['vi'], 2) ?></strong>
                  </div>
                </div>
                <div>
                  <?php if ($bot['kategori'] === 'Baik'): ?>
                    <span class="badge-kategori badge-baik small py-1">Baik</span>
                  <?php elseif ($bot['kategori'] === 'Perlu Perhatian'): ?>
                    <span class="badge-kategori badge-perhatian small py-1">Perhatian</span>
                  <?php else: ?>
                    <span class="badge-kategori badge-berisiko small py-1">Berisiko</span>
                  <?php endif; ?>
                </div>
              </div>
            <?php endforeach; ?>
          </div>
        <?php endif; ?>
      </div>
    </div>

    <!-- Card Distribusi Kategori -->
    <div class="card card-modern">
      <div class="card-header-modern bg-white">
        <h6 class="fw-bold mb-0"><i class="bi bi-pie-chart-fill me-2 text-primary"></i>Distribusi Kategori Kinerja</h6>
      </div>
      <div class="card-body p-3">
        <?php
          $tot = count($hasilTerbaru);
          $pctBaik = $tot > 0 ? round(($kategoriCount['Baik'] / $tot) * 100) : 0;
          $pctPerhatian = $tot > 0 ? round(($kategoriCount['Perlu Perhatian'] / $tot) * 100) : 0;
          $pctBerisiko = $tot > 0 ? round(($kategoriCount['Berisiko/Terlambat'] / $tot) * 100) : 0;
        ?>

        <!-- Progress Bar Multi-Segment -->
        <div class="progress mb-3" style="height: 14px;">
          <div class="progress-bar bg-success" role="progressbar" style="width: <?= $pctBaik ?>%" title="Baik: <?= $pctBaik ?>%"></div>
          <div class="progress-bar bg-warning" role="progressbar" style="width: <?= $pctPerhatian ?>%" title="Perhatian: <?= $pctPerhatian ?>%"></div>
          <div class="progress-bar bg-danger" role="progressbar" style="width: <?= $pctBerisiko ?>%" title="Berisiko: <?= $pctBerisiko ?>%"></div>
        </div>

        <ul class="list-group list-group-flush small">
          <li class="list-group-item px-0 py-2 d-flex justify-content-between align-items-center">
            <span><i class="bi bi-circle-fill text-success me-2"></i>Baik (Skor 0,80 ke Atas)</span>
            <span class="fw-bold mono-num"><?= $kategoriCount['Baik'] ?? 0 ?> Proyek (<?= $pctBaik ?>%)</span>
          </li>
          <li class="list-group-item px-0 py-2 d-flex justify-content-between align-items-center">
            <span><i class="bi bi-circle-fill text-warning me-2"></i>Perlu Perhatian (Skor 0,60 - 0,79)</span>
            <span class="fw-bold mono-num"><?= $kategoriCount['Perlu Perhatian'] ?? 0 ?> Proyek (<?= $pctPerhatian ?>%)</span>
          </li>
          <li class="list-group-item px-0 py-2 d-flex justify-content-between align-items-center">
            <span><i class="bi bi-circle-fill text-danger me-2"></i>Berisiko / Terlambat (Skor di Bawah 0,60)</span>
            <span class="fw-bold mono-num"><?= $kategoriCount['Berisiko/Terlambat'] ?? 0 ?> Proyek (<?= $pctBerisiko ?>%)</span>
          </li>
        </ul>
      </div>
    </div>
  </div>
</div>
<?= $this->endSection() ?>
