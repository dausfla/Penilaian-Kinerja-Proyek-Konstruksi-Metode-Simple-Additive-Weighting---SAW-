<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>
<div class="row justify-content-center">
  <div class="col-lg-8">
    <div class="d-flex align-items-center justify-content-between mb-3">
      <div>
        <h4 class="fw-bold mb-1"><?= $proyek ? 'Edit Proyek' : 'Tambah Proyek Baru' ?></h4>
        <p class="text-muted small mb-0">Isi kelengkapan data informasi proyek konstruksi</p>
      </div>
      <a href="<?= site_url('proyek') ?>" class="btn btn-outline-secondary btn-sm">
        <i class="bi bi-arrow-left me-1"></i> Kembali ke Daftar
      </a>
    </div>

    <div class="card card-modern">
      <div class="card-body p-4">
        <form action="<?= $proyek ? site_url('proyek/update/' . $proyek['id']) : site_url('proyek/store') ?>" method="post">
          <?= csrf_field() ?>

          <div class="row g-3">
            <div class="col-md-4">
              <label class="form-label small fw-bold">Kode Proyek <span class="text-danger">*</span></label>
              <input type="text" name="kode" class="form-control" placeholder="Contoh: PRJ-001" required value="<?= old('kode', $proyek['kode'] ?? '') ?>">
              <div class="form-text small">Kode unik identifikasi proyek.</div>
            </div>

            <div class="col-md-8">
              <label class="form-label small fw-bold">Nama Proyek <span class="text-danger">*</span></label>
              <input type="text" name="nama" class="form-control" placeholder="Contoh: Pembangunan Rumah Tinggal 2 Lantai" required value="<?= old('nama', $proyek['nama'] ?? '') ?>">
            </div>

            <div class="col-md-6">
              <label class="form-label small fw-bold">Jenis Proyek <span class="text-danger">*</span></label>
              <select name="jenis" class="form-select" required>
                <option value="">-- Pilih Jenis Proyek --</option>
                <?php foreach ($jenisList as $j): ?>
                  <option value="<?= $j ?>" <?= (old('jenis', $proyek['jenis'] ?? '') === $j) ? 'selected' : '' ?>>
                    <?= ucfirst($j) ?>
                  </option>
                <?php endforeach; ?>
              </select>
            </div>

            <div class="col-md-6">
              <label class="form-label small fw-bold">Nama Klien / Pemilik <span class="text-danger">*</span></label>
              <input type="text" name="klien" class="form-control" placeholder="Contoh: Bpk. Hendra Gunawan" required value="<?= old('klien', $proyek['klien'] ?? '') ?>">
            </div>

            <div class="col-12">
              <label class="form-label small fw-bold">Lokasi Proyek <span class="text-danger">*</span></label>
              <input type="text" name="lokasi" class="form-control" placeholder="Contoh: Kebayoran Baru, Jakarta Selatan" required value="<?= old('lokasi', $proyek['lokasi'] ?? '') ?>">
            </div>

            <div class="col-md-6">
              <label class="form-label small fw-bold">Tanggal Mulai <span class="text-danger">*</span></label>
              <input type="date" name="tanggal_mulai" class="form-control" required value="<?= old('tanggal_mulai', $proyek['tanggal_mulai'] ?? '') ?>">
            </div>

            <div class="col-md-6">
              <label class="form-label small fw-bold">Tanggal Selesai Rencana <span class="text-danger">*</span></label>
              <input type="date" name="tanggal_selesai_rencana" class="form-control" required value="<?= old('tanggal_selesai_rencana', $proyek['tanggal_selesai_rencana'] ?? '') ?>">
            </div>

            <div class="col-12">
              <label class="form-label small fw-bold">Nilai Rencana Anggaran Biaya (RAB) <span class="text-danger">*</span></label>
              <div class="input-group">
                <span class="input-group-text bg-light fw-bold text-muted">Rp</span>
                <input type="number" step="0.01" min="1" name="nilai_rab" class="form-control mono-num" placeholder="0" required value="<?= old('nilai_rab', $proyek['nilai_rab'] ?? '') ?>">
              </div>
              <div class="form-text small">Nominal RAB disepakati dalam kontrak (rupiah).</div>
            </div>

            <div class="col-12 pt-3 border-top d-flex justify-content-end gap-2">
              <a href="<?= site_url('proyek') ?>" class="btn btn-outline-secondary">Batal</a>
              <button type="submit" class="btn btn-navy px-4">
                <i class="bi bi-save me-1"></i> <?= $proyek ? 'Perbarui Proyek' : 'Simpan Proyek' ?>
              </button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<?= $this->endSection() ?>
