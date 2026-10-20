<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>
<div class="row g-4">
  <!-- Kolom Kiri: Form Kriteria dan Bobot -->
  <div class="col-lg-8">
    <div class="card card-modern">
      <div class="card-header-modern bg-white">
        <div>
          <h5 class="fw-bold mb-1">Pengaturan Kriteria & Bobot SAW</h5>
          <p class="text-muted small mb-0">Total bobot seluruh kriteria wajib berjumlah tepat <strong>1,00 (100%)</strong></p>
        </div>
        <div class="text-end">
          <span id="totalBobotBadge" class="badge bg-success-subtle text-success border border-success-subtle px-3 py-2 fs-6">
            Total Bobot: <span id="totalBobotText" class="mono-num fw-bold"><?= number_format($totalBobot, 2) ?></span>
          </span>
        </div>
      </div>

      <div class="card-body p-4">
        <form action="<?= site_url('kriteria/update') ?>" method="post" id="formKriteria">
          <?= csrf_field() ?>

          <div class="table-responsive">
            <table class="table table-modern table-bordered align-middle">
              <thead class="table-light">
                <tr>
                  <th style="width: 70px;">Kode</th>
                  <th>Nama Kriteria</th>
                  <th style="width: 140px;">Atribut</th>
                  <th style="width: 140px;">Bobot (W)</th>
                  <th style="width: 80px;" class="text-center">%</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($kriteria as $k): ?>
                  <tr>
                    <td class="text-center">
                      <span class="preview-badge-code fw-bold"><?= esc($k['kode']) ?></span>
                    </td>
                    <td>
                      <input type="text" name="kriteria[<?= $k['id'] ?>][nama]" class="form-control form-control-sm" value="<?= esc($k['nama']) ?>" required>
                      <div class="small text-muted mt-1" style="font-size: 0.75rem;">
                        <?php if ($k['kode'] === 'C1'): ?>
                          <i class="bi bi-info-circle me-1"></i> Skor Mutu Finishing & Struktur Fisik (1 - 5)
                        <?php elseif ($k['kode'] === 'C2'): ?>
                          <i class="bi bi-info-circle me-1"></i> (Realisasi / RAB) &times; 100%
                        <?php elseif ($k['kode'] === 'C3'): ?>
                          <i class="bi bi-info-circle me-1"></i> Skor rubrik foto progres fisik (1 - 5)
                        <?php elseif ($k['kode'] === 'C4'): ?>
                          <i class="bi bi-info-circle me-1"></i> Skor BAST rubrik 1 - 5
                        <?php elseif ($k['kode'] === 'C5'): ?>
                          <i class="bi bi-info-circle me-1"></i> Durasi Waktu Penyelesaian (Selesai - Mulai dalam Hari)
                        <?php endif; ?>
                      </div>
                    </td>
                    <td>
                      <select name="kriteria[<?= $k['id'] ?>][atribut]" class="form-select form-select-sm" required>
                        <option value="benefit" <?= ($k['atribut'] === 'benefit') ? 'selected' : '' ?>>Benefit</option>
                        <option value="cost" <?= ($k['atribut'] === 'cost') ? 'selected' : '' ?>>Cost</option>
                      </select>
                    </td>
                    <td>
                      <div class="input-group input-group-sm">
                        <input type="number" step="0.01" min="0.01" max="1" name="kriteria[<?= $k['id'] ?>][bobot]" class="form-control form-control-sm mono-num input-bobot" value="<?= (float)$k['bobot'] ?>" required>
                      </div>
                    </td>
                    <td class="text-center mono-num small text-muted span-pct">
                      <?= number_format((float)$k['bobot'] * 100, 0) ?>%
                    </td>
                  </tr>
                <?php endforeach; ?>
              </tbody>
              <tfoot>
                <tr class="table-light fw-bold">
                  <td colspan="3" class="text-end">TOTAL BOBOT:</td>
                  <td>
                    <span id="footerTotalBobot" class="mono-num fs-6"><?= number_format($totalBobot, 4) ?></span>
                  </td>
                  <td class="text-center mono-num" id="footerTotalPct">100%</td>
                </tr>
              </tfoot>
            </table>
          </div>

          <div id="bobotWarning" class="alert alert-warning py-2 small d-none mt-3" role="alert">
            <i class="bi bi-exclamation-triangle-fill me-1"></i>
            <strong>Perhatian:</strong> Total bobot belum sama dengan 1,00. Tombol simpan dinonaktifkan hingga total bobot tepat 1,00.
          </div>

          <div class="d-flex justify-content-end gap-2 mt-4 pt-3 border-top">
            <button type="submit" id="btnSimpanBobot" class="btn btn-navy px-4">
              <i class="bi bi-check2-circle me-1"></i> Simpan Kriteria & Bobot
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <!-- Kolom Kanan: Pengaturan Batas Kategori & Panduan -->
  <div class="col-lg-4">
    <!-- Card Batas Kategori -->
    <div class="card card-modern mb-4">
      <div class="card-header-modern bg-white">
        <h6 class="fw-bold mb-0"><i class="bi bi-gear-fill me-2 text-warning"></i>Batas Nilai Kategori Kinerja</h6>
      </div>
      <div class="card-body p-3">
        <p class="text-muted small mb-3">Atur ambang batas skor kinerja untuk klasifikasi kategori proyek (Baik, Perlu Perhatian, Berisiko).</p>
        
        <form action="<?= site_url('pengaturan/update') ?>" method="post">
          <?= csrf_field() ?>

          <div class="mb-3">
            <label class="form-label small fw-bold d-flex justify-content-between align-items-center">
              <span>Batas Kategori "Baik"</span>
              <span class="badge badge-kategori badge-baik small py-1">Minimal <span id="lblBaik"><?= $batasBaik ?></span></span>
            </label>
            <div class="input-group input-group-sm">
              <span class="input-group-text bg-light">&ge;</span>
              <input type="number" step="0.01" min="0.01" max="0.99" name="batas_baik" id="inputBatasBaik" class="form-control mono-num" value="<?= $batasBaik ?>" required>
            </div>
            <div class="form-text small" style="font-size:0.75rem;">Proyek dengan skor minimal angka ini ke atas dikategorikan Baik.</div>
          </div>

          <div class="mb-3">
            <label class="form-label small fw-bold d-flex justify-content-between align-items-center">
              <span>Batas "Perlu Perhatian"</span>
              <span class="badge badge-kategori badge-perhatian small py-1">Minimal <span id="lblPerhatian"><?= $batasPerhatian ?></span></span>
            </label>
            <div class="input-group input-group-sm">
              <span class="input-group-text bg-light">&ge;</span>
              <input type="number" step="0.01" min="0.01" max="0.99" name="batas_perhatian" id="inputBatasPerhatian" class="form-control mono-num" value="<?= $batasPerhatian ?>" required>
            </div>
            <div class="form-text small" style="font-size:0.75rem;">Skor di bawah batas ini otomatis masuk Berisiko / Terlambat.</div>
          </div>

          <div class="p-2 rounded bg-light border small mb-3">
            <div class="fw-bold mb-1 text-secondary">Rentang Kategori:</div>
            <div class="d-flex align-items-center justify-content-between text-muted" style="font-size:0.78rem;">
              <span>&bull; Baik:</span>
              <strong class="text-success">Skor &ge; <?= number_format($batasBaik, 2) ?></strong>
            </div>
            <div class="d-flex align-items-center justify-content-between text-muted" style="font-size:0.78rem;">
              <span>&bull; Perlu Perhatian:</span>
              <strong class="text-warning"><?= number_format($batasPerhatian, 2) ?> s.d. <?= number_format($batasBaik - 0.01, 2) ?></strong>
            </div>
            <div class="d-flex align-items-center justify-content-between text-muted" style="font-size:0.78rem;">
              <span>&bull; Berisiko / Terlambat:</span>
              <strong class="text-danger">&lt; <?= number_format($batasPerhatian, 2) ?></strong>
            </div>
          </div>

          <button type="submit" class="btn btn-sm btn-navy w-100">
            <i class="bi bi-save me-1"></i> Perbarui Batas Kategori
          </button>
        </form>
      </div>
    </div>

    <!-- Card Panduan Rubrik Skor Dokumen -->
    <div class="card card-modern mb-3">
      <div class="card-header-modern bg-white">
        <h6 class="fw-bold mb-0"><i class="bi bi-camera me-2 text-info"></i>Rubrik Foto Progres (C3)</h6>
      </div>
      <div class="card-body p-3">
        <ul class="list-group list-group-flush small" style="font-size: 0.78rem;">
          <li class="list-group-item px-0 py-1"><strong>Skor 5:</strong> Sangat Lengkap (tiap tahapan, timestamp GPS/tanggal jelas)</li>
          <li class="list-group-item px-0 py-1"><strong>Skor 4:</strong> Lengkap (foto progres rutin pekerjaan utama terverifikasi)</li>
          <li class="list-group-item px-0 py-1"><strong>Skor 3:</strong> Cukup (sebagian besar ada, beberapa item minor terlewat)</li>
          <li class="list-group-item px-0 py-1"><strong>Skor 2:</strong> Kurang (foto minim, sudut visual kurang jelas)</li>
          <li class="list-group-item px-0 py-1"><strong>Skor 1:</strong> Sangat Kurang / Tidak Ada bukti foto</li>
        </ul>
      </div>
    </div>

    <!-- Card Panduan Rubrik Skor BAST -->
    <div class="card card-modern">
      <div class="card-header-modern bg-white">
        <h6 class="fw-bold mb-0"><i class="bi bi-journal-text me-2 text-primary"></i>Rubrik Kualitas BAST (C4)</h6>
      </div>
      <div class="card-body p-3">
        <ul class="list-group list-group-flush small" style="font-size: 0.78rem;">
          <li class="list-group-item px-0 py-1"><strong>Skor 5:</strong> Lengkap, tepat waktu, tanpa catatan revisi</li>
          <li class="list-group-item px-0 py-1"><strong>Skor 4:</strong> Lengkap, tepat waktu, ada catatan minor tuntas</li>
          <li class="list-group-item px-0 py-1"><strong>Skor 3:</strong> BAST ada, terlambat ringan</li>
          <li class="list-group-item px-0 py-1"><strong>Skor 2:</strong> BAST ada, terlambat & ada catatan belum tuntas</li>
          <li class="list-group-item px-0 py-1"><strong>Skor 1:</strong> BAST belum ada / belum disetujui klien</li>
        </ul>
      </div>
    </div>
  </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
  function recalculateWeights() {
    const inputs = document.querySelectorAll('.input-bobot');
    let sum = 0;
    inputs.forEach(input => {
      const val = parseFloat(input.value) || 0;
      sum += val;
      const pctCell = input.closest('tr').querySelector('.span-pct');
      if (pctCell) {
        pctCell.innerText = Math.round(val * 100) + '%';
      }
    });

    const sumRounded = Math.round(sum * 10000) / 10000;
    const footerTotal = document.getElementById('footerTotalBobot');
    const footerPct = document.getElementById('footerTotalPct');
    const badgeText = document.getElementById('totalBobotText');
    const badge = document.getElementById('totalBobotBadge');
    const warning = document.getElementById('bobotWarning');
    const submitBtn = document.getElementById('btnSimpanBobot');

    footerTotal.innerText = sumRounded.toFixed(4);
    footerPct.innerText = Math.round(sumRounded * 100) + '%';
    badgeText.innerText = sumRounded.toFixed(2);

    const isValid = Math.abs(sumRounded - 1.00) <= 0.0001;

    if (isValid) {
      badge.className = 'badge bg-success-subtle text-success border border-success-subtle px-3 py-2 fs-6';
      warning.classList.add('d-none');
      submitBtn.removeAttribute('disabled');
    } else {
      badge.className = 'badge bg-danger-subtle text-danger border border-danger-subtle px-3 py-2 fs-6';
      warning.classList.remove('d-none');
      submitBtn.setAttribute('disabled', 'disabled');
    }
  }

  document.querySelectorAll('.input-bobot').forEach(inp => {
    inp.addEventListener('input', recalculateWeights);
  });

  recalculateWeights();
</script>
<?= $this->endSection() ?>
