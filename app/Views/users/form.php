<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>
<div class="row justify-content-center">
  <div class="col-lg-6">
    <div class="d-flex align-items-center justify-content-between mb-3">
      <div>
        <h4 class="fw-bold mb-1"><?= $user ? 'Edit Pengguna' : 'Tambah Pengguna Baru' ?></h4>
        <p class="text-muted small mb-0">Atur kredensial dan hak akses akun</p>
      </div>
      <a href="<?= site_url('users') ?>" class="btn btn-outline-secondary btn-sm">
        <i class="bi bi-arrow-left me-1"></i> Kembali
      </a>
    </div>

    <div class="card card-modern">
      <div class="card-body p-4">
        <form action="<?= $user ? site_url('users/update/' . $user['id']) : site_url('users/store') ?>" method="post">
          <?= csrf_field() ?>

          <div class="mb-3">
            <label class="form-label small fw-bold">Nama Lengkap <span class="text-danger">*</span></label>
            <input type="text" name="nama" class="form-control" placeholder="Nama personel / direksi" required value="<?= old('nama', $user['nama'] ?? '') ?>">
          </div>

          <div class="mb-3">
            <label class="form-label small fw-bold">Username <span class="text-danger">*</span></label>
            <input type="text" name="username" class="form-control" placeholder="username_login" required value="<?= old('username', $user['username'] ?? '') ?>">
          </div>

          <div class="mb-3">
            <label class="form-label small fw-bold">Alamat Email Gmail / Pemulihan <span class="text-danger">*</span></label>
            <input type="email" name="email" class="form-control" placeholder="admin@rancangbangunsedaya.com" required value="<?= old('email', $user['email'] ?? 'admin@rancangbangunsedaya.com') ?>">
            <div class="form-text small">Digunakan untuk menerima kode OTP jika terjadi lupa PIN.</div>
          </div>

          <div class="row g-2 mb-3">
            <div class="col-md-6">
              <label class="form-label small fw-bold">
                Password <?= $user ? '<span class="text-muted fw-normal">(Kosongkan jika tetap)</span>' : '<span class="text-danger">*</span>' ?>
              </label>
              <input type="password" name="password" class="form-control" placeholder="Minimal 5 karakter" <?= $user ? '' : 'required' ?>>
            </div>
            <div class="col-md-6">
              <label class="form-label small fw-bold">
                PIN Akses 6-Digit <?= $user ? '<span class="text-muted fw-normal">(Kosongkan jika tetap)</span>' : '<span class="text-muted fw-normal">(Default: 080905)</span>' ?>
              </label>
              <input type="text" name="pin" maxlength="6" pattern="[0-9]{6}" inputmode="numeric" class="form-control font-monospace" placeholder="Contoh: 080905">
            </div>
          </div>

          <div class="mb-4">
            <label class="form-label small fw-bold">Hak Akses Sistem</label>
            <input type="hidden" name="role" value="admin">
            <div class="p-3 bg-light rounded border d-flex align-items-center gap-2">
              <i class="bi bi-shield-lock-fill text-primary fs-5"></i>
              <div>
                <div class="fw-bold text-dark small">Administrator SPK</div>
                <div class="text-muted" style="font-size: 0.75rem;">Memiliki hak akses penuh mengelola master proyek, kriteria, penilaian lapangan, dan laporan.</div>
              </div>
            </div>
          </div>

          <div class="d-flex justify-content-end gap-2 pt-3 border-top">
            <a href="<?= site_url('users') ?>" class="btn btn-outline-secondary">Batal</a>
            <button type="submit" class="btn btn-navy px-4">
              <i class="bi bi-save me-1"></i> <?= $user ? 'Perbarui Pengguna' : 'Simpan Pengguna' ?>
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<?= $this->endSection() ?>
