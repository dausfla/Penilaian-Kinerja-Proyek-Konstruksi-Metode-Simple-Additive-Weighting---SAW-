<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>
<div class="d-flex align-items-center justify-content-between mb-4">
  <div>
    <h3 class="fw-bold mb-1">Manajemen Pengguna</h3>
    <p class="text-muted small mb-0">Kelola akun administrator dan status keaktifan sistem</p>
  </div>
  <a href="<?= site_url('users/create') ?>" class="btn btn-amber shadow-sm d-flex align-items-center gap-2">
    <i class="bi bi-person-plus-fill"></i>
    <span>Tambah Pengguna</span>
  </a>
</div>

<div class="card card-modern">
  <div class="table-responsive">
    <table class="table table-modern table-hover align-middle mb-0">
      <thead>
        <tr>
          <th style="width: 50px;">No</th>
          <th>Nama Lengkap</th>
          <th>Username</th>
          <th>Hak Akses</th>
          <th class="text-center">Status</th>
          <th class="text-center" style="width: 150px;">Aksi</th>
        </tr>
      </thead>
      <tbody>
        <?php $no = 1; foreach ($users as $u): ?>
          <tr>
            <td class="text-muted small"><?= $no++ ?></td>
            <td>
              <div class="fw-bold text-dark"><?= esc($u['nama']) ?></div>
            </td>
            <td>
              <span class="badge bg-light text-dark border font-monospace"><?= esc($u['username']) ?></span>
            </td>
            <td>
              <span class="badge bg-primary-subtle text-primary border border-primary-subtle px-2 py-1">
                <i class="bi bi-shield-fill-check me-1"></i> Administrator
              </span>
            </td>
            <td class="text-center">
              <?php if ($u['aktif']): ?>
                <span class="badge bg-success-subtle text-success border border-success-subtle">Aktif</span>
              <?php else: ?>
                <span class="badge bg-danger-subtle text-danger border border-danger-subtle">Nonaktif</span>
              <?php endif; ?>
            </td>
            <td class="text-center">
              <div class="btn-group btn-group-sm">
                <a href="<?= site_url('users/edit/' . $u['id']) ?>" class="btn btn-outline-primary" title="Ubah Pengguna">
                  <i class="bi bi-pencil-square"></i>
                </a>
                <?php if ($u['id'] != session()->get('user_id')): ?>
                  <a href="<?= site_url('users/toggle/' . $u['id']) ?>" class="btn <?= $u['aktif'] ? 'btn-outline-warning' : 'btn-outline-success' ?>" title="<?= $u['aktif'] ? 'Nonaktifkan' : 'Aktifkan' ?>">
                    <i class="bi <?= $u['aktif'] ? 'bi-person-slash' : 'bi-person-check' ?>"></i>
                  </a>
                <?php endif; ?>
              </div>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</div>
<?= $this->endSection() ?>
