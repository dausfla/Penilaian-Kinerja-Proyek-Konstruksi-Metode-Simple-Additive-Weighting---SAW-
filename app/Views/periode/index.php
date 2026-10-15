<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>
<div class="d-flex align-items-center justify-content-between mb-4">
  <div>
    <h3 class="fw-bold mb-1">Periode Penilaian Kinerja</h3>
    <p class="text-muted small mb-0">Daftar sesi evaluasi berkala dan akhir proyek konstruksi</p>
  </div>
  <?php if (session()->get('user_role') === 'admin'): ?>
    <a href="<?= site_url('periode/create') ?>" class="btn btn-amber shadow-sm d-flex align-items-center gap-2">
      <i class="bi bi-plus-lg"></i>
      <span>Buat Periode Baru</span>
    </a>
  <?php endif; ?>
</div>

<div class="card card-modern">
  <div class="table-responsive">
    <table class="table table-modern table-hover align-middle mb-0">
      <thead>
        <tr>
          <th style="width: 50px;">No</th>
          <th>Nama Periode</th>
          <th>Tanggal Penilaian</th>
          <th class="text-center">Jumlah Proyek</th>
          <th class="text-center">Status</th>
          <th class="text-center" style="width: 250px;">Aksi</th>
        </tr>
      </thead>
      <tbody>
        <?php if (empty($periodes)): ?>
          <tr>
            <td colspan="6" class="text-center py-5 text-muted">
              <i class="bi bi-calendar-x fs-1 d-block mb-2 text-secondary"></i>
              Belum ada periode penilaian. Silakan buat periode baru.
            </td>
          </tr>
        <?php else: ?>
          <?php $no = 1; foreach ($periodes as $p): ?>
            <tr>
              <td class="text-muted small"><?= $no++ ?></td>
              <td>
                <div class="fw-bold text-dark"><?= esc($p['nama']) ?></div>
                <div class="text-muted small" style="font-size: 0.75rem;">ID Periode: #<?= $p['id'] ?></div>
              </td>
              <td>
                <div class="small fw-semibold"><i class="bi bi-calendar3 me-1 text-muted"></i><?= date('d F Y', strtotime($p['tanggal_penilaian'])) ?></div>
              </td>
              <td class="text-center">
                <span class="badge bg-light text-dark border px-2 py-1 fs-6">
                  <i class="bi bi-building me-1 text-primary"></i> <?= $p['jumlah_proyek'] ?> Proyek
                </span>
              </td>
              <td class="text-center">
                <?php if ($p['status'] === 'terhitung'): ?>
                  <span class="badge bg-success-subtle text-success border border-success-subtle px-3 py-1">
                    <i class="bi bi-check-all me-1"></i> Terhitung
                  </span>
                <?php else: ?>
                  <span class="badge bg-warning-subtle text-warning border border-warning-subtle px-3 py-1">
                    <i class="bi bi-hourglass-split me-1"></i> Draft (Belum Hitung)
                  </span>
                <?php endif; ?>
              </td>
              <td class="text-center">
                <div class="d-flex align-items-center justify-content-center gap-1">
                  <!-- Input / Edit Data Mentah -->
                  <?php if (session()->get('user_role') === 'admin'): ?>
                    <a href="<?= site_url('penilaian/' . $p['id']) ?>" class="btn btn-sm btn-outline-primary" title="Kelola Data Penilaian">
                      <i class="bi bi-pencil-square me-1"></i> Input Data
                    </a>
                  <?php endif; ?>

                  <!-- Lihat Hasil -->
                  <a href="<?= site_url('hasil/' . $p['id']) ?>" class="btn btn-sm <?= ($p['status'] === 'terhitung') ? 'btn-navy' : 'btn-outline-secondary disabled' ?>" title="Lihat Peringkat & Matriks">
                    <i class="bi bi-trophy me-1"></i> Hasil
                  </a>

                  <?php if (session()->get('user_role') === 'admin'): ?>
                    <div class="dropdown">
                      <button class="btn btn-sm btn-light border" type="button" data-bs-toggle="dropdown">
                        <i class="bi bi-three-dots-vertical"></i>
                      </button>
                      <ul class="dropdown-menu dropdown-menu-end shadow-sm">
                        <li>
                          <a class="dropdown-item small" href="<?= site_url('periode/edit/' . $p['id']) ?>">
                            <i class="bi bi-gear me-2"></i> Edit Nama/Tanggal
                          </a>
                        </li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                          <a class="dropdown-item small text-danger" href="javascript:void(0)" onclick="confirmDeletePeriode(<?= $p['id'] ?>, '<?= esc($p['nama']) ?>')">
                            <i class="bi bi-trash me-2"></i> Hapus Periode
                          </a>
                        </li>
                      </ul>
                    </div>
                  <?php endif; ?>
                </div>
              </td>
            </tr>
          <?php endforeach; ?>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
</div>

<!-- Modal Konfirmasi Hapus Periode -->
<div class="modal fade" id="deletePeriodeModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-sm">
    <div class="modal-content">
      <div class="modal-body text-center p-4">
        <i class="bi bi-exclamation-triangle-fill text-danger fs-1 mb-2"></i>
        <h5 class="fw-bold mb-1">Hapus Periode?</h5>
        <p class="text-muted small mb-3">Seluruh data penilaian dan hasil SAW untuk periode <span id="delPeriodeName" class="fw-bold text-dark"></span> akan ikut terhapus.</p>
        <div class="d-flex justify-content-center gap-2">
          <button type="button" class="btn btn-sm btn-light border px-3" data-bs-dismiss="modal">Batal</button>
          <a href="#" id="delPeriodeConfirmBtn" class="btn btn-sm btn-danger px-3">Hapus</a>
        </div>
      </div>
    </div>
  </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
  function confirmDeletePeriode(id, name) {
    document.getElementById('delPeriodeName').innerText = name;
    document.getElementById('delPeriodeConfirmBtn').href = '<?= site_url('periode/delete/') ?>' + id;
    const modal = new bootstrap.Modal(document.getElementById('deletePeriodeModal'));
    modal.show();
  }
</script>
<?= $this->endSection() ?>
