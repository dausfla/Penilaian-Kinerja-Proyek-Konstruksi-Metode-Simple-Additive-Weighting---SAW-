<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>
<div class="d-flex align-items-center justify-content-between mb-4">
  <div>
    <h3 class="fw-bold mb-1">Daftar Proyek Konstruksi</h3>
    <p class="text-muted small mb-0">Kelola informasi proyek, klien, jadwal, dan nilai RAB</p>
  </div>
  <?php if (session()->get('user_role') === 'admin'): ?>
    <a href="<?= site_url('proyek/create') ?>" class="btn btn-amber shadow-sm d-flex align-items-center gap-2">
      <i class="bi bi-plus-lg"></i>
      <span>Tambah Proyek</span>
    </a>
  <?php endif; ?>
</div>

<div class="card card-modern">
  <div class="card-header-modern bg-white">
    <!-- Filter & Search Form -->
    <form action="<?= site_url('proyek') ?>" method="get" class="row g-2 w-100 align-items-center">
      <div class="col-md-5">
        <div class="input-group input-group-sm">
          <span class="input-group-text bg-light text-muted"><i class="bi bi-search"></i></span>
          <input type="text" name="search" class="form-control" placeholder="Cari nama, kode, klien, lokasi..." value="<?= esc($search) ?>">
        </div>
      </div>
      <div class="col-md-4">
        <select name="jenis" class="form-select form-select-sm">
          <option value="">-- Semua Jenis Proyek --</option>
          <?php foreach ($jenisList as $j): ?>
            <option value="<?= $j ?>" <?= ($jenis === $j) ? 'selected' : '' ?>><?= ucfirst($j) ?></option>
          <?php endforeach; ?>
        </select>
      </div>
      <div class="col-md-3 d-flex gap-2">
        <button type="submit" class="btn btn-sm btn-navy w-100">Filter</button>
        <?php if (!empty($search) || !empty($jenis)): ?>
          <a href="<?= site_url('proyek') ?>" class="btn btn-sm btn-outline-secondary">Reset</a>
        <?php endif; ?>
      </div>
    </form>
  </div>

  <div class="table-responsive">
    <table class="table table-modern table-hover align-middle mb-0">
      <thead>
        <tr>
          <th style="width: 50px;">No</th>
          <th>Kode</th>
          <th>Nama Proyek</th>
          <th>Jenis</th>
          <th>Klien & Lokasi</th>
          <th>Jadwal Pelaksanaan</th>
          <th class="text-end">Nilai RAB (Rp)</th>
          <?php if (session()->get('user_role') === 'admin'): ?>
            <th class="text-center" style="width: 120px;">Aksi</th>
          <?php endif; ?>
        </tr>
      </thead>
      <tbody>
        <?php if (empty($proyeks)): ?>
          <tr>
            <td colspan="<?= (session()->get('user_role') === 'admin') ? '8' : '7' ?>" class="text-center py-5 text-muted">
              <i class="bi bi-folder-x fs-1 d-block mb-2 text-secondary"></i>
              Belum ada data proyek yang ditemukan.
            </td>
          </tr>
        <?php else: ?>
          <?php $no = 1; foreach ($proyeks as $p): ?>
            <tr>
              <td class="text-muted small"><?= $no++ ?></td>
              <td><span class="badge bg-dark-subtle text-dark border font-monospace"><?= esc($p['kode']) ?></span></td>
              <td>
                <div class="fw-bold text-dark"><?= esc($p['nama']) ?></div>
              </td>
              <td>
                <span class="badge bg-light text-secondary border text-capitalize"><?= esc($p['jenis']) ?></span>
              </td>
              <td>
                <div class="small fw-semibold"><?= esc($p['klien']) ?></div>
                <div class="text-muted" style="font-size: 0.78rem;"><i class="bi bi-geo-alt me-1"></i><?= esc($p['lokasi']) ?></div>
              </td>
              <td class="small">
                <div><span class="text-muted">Mulai:</span> <?= date('d M Y', strtotime($p['tanggal_mulai'])) ?></div>
                <div><span class="text-muted">Rencana Selesai:</span> <strong><?= date('d M Y', strtotime($p['tanggal_selesai_rencana'])) ?></strong></div>
              </td>
              <td class="text-end mono-num fw-bold text-dark">
                Rp <?= number_format((float)$p['nilai_rab'], 0, ',', '.') ?>
              </td>
              <?php if (session()->get('user_role') === 'admin'): ?>
                <td class="text-center">
                  <div class="btn-group btn-group-sm">
                    <a href="<?= site_url('proyek/edit/' . $p['id']) ?>" class="btn btn-outline-primary" title="Ubah">
                      <i class="bi bi-pencil-square"></i>
                    </a>
                    <button type="button" class="btn btn-outline-danger" title="Hapus" onclick="confirmDelete(<?= $p['id'] ?>, '<?= esc($p['nama']) ?>')">
                      <i class="bi bi-trash"></i>
                    </button>
                  </div>
                </td>
              <?php endif; ?>
            </tr>
          <?php endforeach; ?>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
</div>

<!-- Modal Konfirmasi Hapus -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-sm">
    <div class="modal-content">
      <div class="modal-body text-center p-4">
        <i class="bi bi-exclamation-triangle-fill text-danger fs-1 mb-2"></i>
        <h5 class="fw-bold mb-1">Hapus Proyek?</h5>
        <p class="text-muted small mb-3">Apakah Anda yakin ingin menghapus proyek <span id="delProjectName" class="fw-bold text-dark"></span>? Tindakan ini tidak dapat dibatalkan.</p>
        <div class="d-flex justify-content-center gap-2">
          <button type="button" class="btn btn-sm btn-light border px-3" data-bs-dismiss="modal">Batal</button>
          <a href="#" id="delConfirmBtn" class="btn btn-sm btn-danger px-3">Hapus</a>
        </div>
      </div>
    </div>
  </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
  function confirmDelete(id, name) {
    document.getElementById('delProjectName').innerText = name;
    document.getElementById('delConfirmBtn').href = '<?= site_url('proyek/delete/') ?>' + id;
    const modal = new bootstrap.Modal(document.getElementById('deleteModal'));
    modal.show();
  }
</script>
<?= $this->endSection() ?>
