<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>
<div class="row justify-content-center">
  <div class="col-lg-6">
    <div class="d-flex align-items-center justify-content-between mb-3">
      <div>
        <h4 class="fw-bold mb-1">Edit Periode Penilaian</h4>
        <p class="text-muted small mb-0">Ubah informasi nama dan tanggal penilaian periode</p>
      </div>
      <a href="<?= site_url('periode') ?>" class="btn btn-outline-secondary btn-sm">
        <i class="bi bi-arrow-left me-1"></i> Kembali
      </a>
    </div>

    <div class="card card-modern">
      <div class="card-body p-4">
        <form action="<?= site_url('periode/update/' . $periode['id']) ?>" method="post">
          <?= csrf_field() ?>

          <div class="mb-3">
            <label class="form-label small fw-bold">Nama Periode Penilaian <span class="text-danger">*</span></label>
            <input type="text" name="nama" class="form-control" required value="<?= old('nama', $periode['nama']) ?>">
          </div>

          <div class="mb-4">
            <label class="form-label small fw-bold">Tanggal Penilaian <span class="text-danger">*</span></label>
            <input type="date" name="tanggal_penilaian" class="form-control" required value="<?= old('tanggal_penilaian', $periode['tanggal_penilaian']) ?>">
          </div>

          <div class="d-flex justify-content-end gap-2 pt-3 border-top">
            <a href="<?= site_url('periode') ?>" class="btn btn-outline-secondary">Batal</a>
            <button type="submit" class="btn btn-navy px-4">
              <i class="bi bi-save me-1"></i> Perbarui Periode
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<?= $this->endSection() ?>
