<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>
<div class="row justify-content-center">
  <div class="col-lg-8">
    <div class="d-flex align-items-center justify-content-between mb-3">
      <div>
        <h4 class="fw-bold mb-1">Buat Periode Penilaian Baru</h4>
        <p class="text-muted small mb-0">Tentukan nama periode dan pilih proyek konstruksi yang akan dinilai</p>
      </div>
      <a href="<?= site_url('periode') ?>" class="btn btn-outline-secondary btn-sm">
        <i class="bi bi-arrow-left me-1"></i> Kembali
      </a>
    </div>

    <div class="card card-modern">
      <div class="card-body p-4">
        <form action="<?= site_url('periode/store') ?>" method="post">
          <?= csrf_field() ?>

          <div class="row g-3">
            <div class="col-md-7">
              <label class="form-label small fw-bold">Nama Periode Penilaian <span class="text-danger">*</span></label>
              <input type="text" name="nama" class="form-control" placeholder="Contoh: Evaluasi Proyek Q3 2026" required value="<?= old('nama') ?>">
            </div>

            <div class="col-md-5">
              <label class="form-label small fw-bold">Tanggal Penilaian <span class="text-danger">*</span></label>
              <input type="date" name="tanggal_penilaian" class="form-control" required value="<?= old('tanggal_penilaian', date('Y-m-d')) ?>">
            </div>

            <div class="col-12 pt-3">
              <label class="form-label small fw-bold d-flex justify-content-between align-items-center">
                <span>Pilih Proyek yang Akan Dinilai <span class="text-danger">*</span></span>
                <button type="button" class="btn btn-link btn-sm p-0 text-decoration-none" onclick="toggleSelectAll()">Pilih Semua / Batal</button>
              </label>

              <?php if (empty($proyeks)): ?>
                <div class="alert alert-warning small">
                  Belum ada master data proyek. Silakan buat data proyek terlebih dahulu di menu <strong>Data Proyek</strong>.
                </div>
              <?php else: ?>
                <div class="border rounded p-3 bg-light" style="max-height: 280px; overflow-y: auto;">
                  <div class="row g-2">
                    <?php foreach ($proyeks as $p): ?>
                      <div class="col-md-6">
                        <div class="form-check p-2 bg-white rounded border">
                          <input class="form-check-input check-proyek ms-1 me-2" type="checkbox" name="proyek_ids[]" value="<?= $p['id'] ?>" id="p_<?= $p['id'] ?>" checked>
                          <label class="form-check-label w-100" for="p_<?= $p['id'] ?>">
                            <div class="fw-bold small text-dark"><?= esc($p['nama']) ?></div>
                            <div class="text-muted" style="font-size: 0.75rem;">
                              <span class="badge bg-light text-secondary border"><?= esc($p['kode']) ?></span> &bull; <?= ucfirst($p['jenis']) ?> &bull; Rp <?= number_format((float)$p['nilai_rab'], 0, ',', '.') ?>
                            </div>
                          </label>
                        </div>
                      </div>
                    <?php endforeach; ?>
                  </div>
                </div>
              <?php endif; ?>
            </div>

            <div class="col-12 pt-3 border-top d-flex justify-content-end gap-2">
              <a href="<?= site_url('periode') ?>" class="btn btn-outline-secondary">Batal</a>
              <button type="submit" class="btn btn-navy px-4">
                <i class="bi bi-arrow-right me-1"></i> Simpan & Lanjut ke Input Data
              </button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
  let allChecked = true;
  function toggleSelectAll() {
    allChecked = !allChecked;
    document.querySelectorAll('.check-proyek').forEach(ch => {
      ch.checked = allChecked;
    });
  }
</script>
<?= $this->endSection() ?>
