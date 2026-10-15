<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>
<div class="row g-4">
  <!-- Kolom Kiri: Pilihan Proyek & Ringkasan -->
  <div class="col-lg-4">
    <div class="card card-modern mb-4">
      <div class="card-header-modern bg-white">
        <h6 class="fw-bold mb-0"><i class="bi bi-filter me-2 text-warning"></i>Pilih Proyek Konstruksi</h6>
      </div>
      <div class="card-body p-3">
        <form action="<?= site_url('riwayat') ?>" method="get">
          <div class="mb-3">
            <label class="form-label small fw-bold text-muted">Proyek yang Diperbandingkan:</label>
            <select name="proyek_id" class="form-select" onchange="this.form.submit()">
              <?php foreach ($proyeks as $pr): ?>
                <option value="<?= $pr['id'] ?>" <?= ($pr['id'] == $selectedProyekId) ? 'selected' : '' ?>>
                  <?= esc($pr['nama']) ?> (<?= esc($pr['kode']) ?>)
                </option>
              <?php endforeach; ?>
            </select>
          </div>
        </form>

        <?php if ($selectedProyek): ?>
          <div class="p-3 bg-light rounded border small">
            <div class="fw-bold fs-6 text-dark mb-1"><?= esc($selectedProyek['nama']) ?></div>
            <div class="text-muted mb-2 font-monospace"><?= esc($selectedProyek['kode']) ?> &bull; <?= ucfirst($selectedProyek['jenis']) ?></div>
            
            <div class="mb-1"><span class="text-muted">Klien:</span> <strong><?= esc($selectedProyek['klien']) ?></strong></div>
            <div class="mb-1"><span class="text-muted">Lokasi:</span> <?= esc($selectedProyek['lokasi']) ?></div>
            <div class="mb-1"><span class="text-muted">Jadwal Selesai:</span> <?= date('d M Y', strtotime($selectedProyek['tanggal_selesai_rencana'])) ?></div>
            <div class="mb-0"><span class="text-muted">Nilai RAB:</span> <strong>Rp <?= number_format((float)$selectedProyek['nilai_rab'], 0, ',', '.') ?></strong></div>
          </div>
        <?php endif; ?>
      </div>
    </div>
  </div>

  <!-- Kolom Kanan: Tabel Komparasi Antar Periode -->
  <div class="col-lg-8">
    <div class="card card-modern">
      <div class="card-header-modern bg-white">
        <div>
          <h5 class="fw-bold mb-1"><i class="bi bi-clock-history text-primary me-2"></i>Histori Kinerja Antar Periode</h5>
          <p class="text-muted small mb-0">Evaluasi perkembangan skor kinerja dan peringkat pada setiap sesi penilaian</p>
        </div>
      </div>

      <?php if (empty($riwayatList)): ?>
        <div class="card-body text-center py-5 text-muted">
          <i class="bi bi-calendar-x fs-1 d-block mb-2 text-secondary"></i>
          Belum ada riwayat hasil penilaian SAW untuk proyek ini.
        </div>
      <?php else: ?>
        <div class="table-responsive">
          <table class="table table-modern table-hover align-middle mb-0">
            <thead>
              <tr>
                <th>Periode & Tanggal</th>
                <th class="text-center">C1 (%)</th>
                <th class="text-center">C2 (%)</th>
                <th class="text-center">C3</th>
                <th class="text-center">C4</th>
                <th class="text-center">C5</th>
                <th class="text-center">Skor Akhir</th>
                <th class="text-center">Peringkat</th>
                <th class="text-center">Kategori</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($riwayatList as $r): ?>
                <tr>
                  <td>
                    <div class="fw-bold text-dark"><?= esc($r['periode_nama']) ?></div>
                    <div class="text-muted small" style="font-size:0.75rem;"><i class="bi bi-calendar3 me-1"></i><?= date('d M Y', strtotime($r['tanggal_penilaian'])) ?></div>
                  </td>
                  <td class="text-center mono-num small"><?= number_format((float)$r['c1'], 1) ?>%</td>
                  <td class="text-center mono-num small"><?= number_format((float)$r['c2'], 1) ?>%</td>
                  <td class="text-center mono-num small"><?= $r['c3'] ?></td>
                  <td class="text-center mono-num small"><?= $r['c4'] ?></td>
                  <td class="text-center mono-num small"><?= $r['c5'] ?> hr</td>
                  <td class="text-center mono-num fw-bold fs-6 text-dark"><?= number_format((float)$r['vi'], 2) ?></td>
                  <td class="text-center fw-bold">#<?= $r['peringkat'] ?></td>
                  <td class="text-center">
                    <?php if ($r['kategori'] === 'Baik'): ?>
                      <span class="badge-kategori badge-baik small py-1">Baik</span>
                    <?php elseif ($r['kategori'] === 'Perlu Perhatian'): ?>
                      <span class="badge-kategori badge-perhatian small py-1">Perhatian</span>
                    <?php else: ?>
                      <span class="badge-kategori badge-berisiko small py-1">Berisiko</span>
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
</div>
<?= $this->endSection() ?>
