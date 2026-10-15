<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>
<!-- Header Banner Periode -->
<div class="card card-modern mb-4 bg-white">
  <div class="card-body p-4 d-flex flex-wrap align-items-center justify-content-between gap-3">
    <div>
      <div class="d-flex align-items-center gap-2 mb-1">
        <span class="badge bg-dark-subtle text-dark border">Periode Evaluasi</span>
        <?php if ($periode['status'] === 'terhitung'): ?>
          <span class="badge bg-success-subtle text-success border border-success-subtle"><i class="bi bi-check-all me-1"></i> Terhitung</span>
        <?php else: ?>
          <span class="badge bg-warning-subtle text-warning border border-warning-subtle"><i class="bi bi-hourglass-split me-1"></i> Draft (Perlu Dihitung)</span>
        <?php endif; ?>
      </div>
      <h3 class="fw-bold mb-1 text-dark"><?= esc($periode['nama']) ?></h3>
      <div class="text-muted small">
        <i class="bi bi-calendar3 me-1"></i> Tanggal Penilaian: <strong><?= date('d F Y', strtotime($periode['tanggal_penilaian'])) ?></strong>
        &bull; Total Proyek Terdaftar: <strong><?= count($penilaians) ?> Proyek</strong>
      </div>
    </div>

    <div class="d-flex align-items-center gap-2 flex-wrap">
      <a href="<?= site_url('periode') ?>" class="btn btn-outline-secondary btn-sm">
        <i class="bi bi-arrow-left me-1"></i> Daftar Periode
      </a>

      <?php if (!empty($availableProyeks)): ?>
        <button type="button" class="btn btn-outline-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addProyekModal">
          <i class="bi bi-plus-circle me-1"></i> Tambah Proyek
        </button>
      <?php endif; ?>

      <?php if (!empty($penilaians)): ?>
        <button type="button" class="btn btn-outline-success btn-sm fw-semibold" data-bs-toggle="modal" data-bs-target="#batchEditModal">
          <i class="bi bi-table me-1"></i> Edit Cepat Semua Proyek
        </button>
      <?php endif; ?>

      <!-- Tombol Eksekusi Hitung SAW -->
      <a href="<?= site_url('periode/hitung/' . $periode['id']) ?>" class="btn btn-amber fw-bold shadow-sm d-flex align-items-center gap-2">
        <i class="bi bi-calculator-fill"></i>
        <span><?= ($periode['status'] === 'terhitung') ? 'Hitung Ulang SAW' : 'Hitung SAW Sekarang' ?></span>
      </a>

      <?php if ($periode['status'] === 'terhitung'): ?>
        <a href="<?= site_url('hasil/' . $periode['id']) ?>" class="btn btn-navy fw-bold shadow-sm d-flex align-items-center gap-2">
          <i class="bi bi-trophy-fill"></i>
          <span>Lihat Hasil</span>
        </a>
      <?php endif; ?>
    </div>
  </div>
</div>

<!-- Table Data Mentah dan Pratinjau Kriteria -->
<div class="card card-modern">
  <div class="card-header-modern bg-white">
    <div>
      <h5 class="fw-bold mb-1">Data Mentah & Nilai Kriteria Proyek</h5>
      <p class="text-muted small mb-0">Klik tombol <strong>Input Data</strong> per proyek atau gunakan tombol <strong>Edit Cepat Semua Proyek</strong> untuk mengisi tabel sekaligus.</p>
    </div>
  </div>

  <div class="table-responsive">
    <table class="table table-modern table-hover align-middle mb-0">
      <thead>
        <tr>
          <th style="width: 45px;">No</th>
          <th>Proyek Konstruksi</th>
          <th>C1: Progres</th>
          <th>C2: Biaya / RAB</th>
          <th>C3: Foto Progres</th>
          <th>C4: BAST</th>
          <th>C5: Keterlambatan</th>
          <th class="text-center" style="width: 140px;">Aksi</th>
        </tr>
      </thead>
      <tbody>
        <?php if (empty($penilaians)): ?>
          <tr>
            <td colspan="8" class="text-center py-5 text-muted">
              <i class="bi bi-folder-x fs-1 d-block mb-2 text-secondary"></i>
              Belum ada proyek yang dipilih pada periode ini.
            </td>
          </tr>
        <?php else: ?>
          <?php $no = 1; foreach ($penilaians as $p): ?>
            <tr>
              <td class="text-muted small"><?= $no++ ?></td>
              <td>
                <div class="fw-bold text-dark"><?= esc($p['proyek_nama']) ?></div>
                <div class="small text-muted font-monospace"><?= esc($p['proyek_kode']) ?> &bull; <?= ucfirst($p['jenis']) ?></div>
              </td>

              <!-- C1: Capaian Progres -->
              <td>
                <div class="fw-bold mono-num text-dark">
                  <?= number_format((float)$p['kriteria_preview']['C1'], 2) ?>%
                </div>
                <div class="small text-muted" style="font-size:0.75rem;">
                  Aktual: <?= (float)$p['progres_aktual'] ?>% / <?= (float)$p['progres_rencana'] ?>%
                </div>
              </td>

              <!-- C2: Biaya terhadap RAB -->
              <td>
                <div class="fw-bold mono-num text-dark">
                  <?= number_format((float)$p['kriteria_preview']['C2'], 2) ?>%
                </div>
                <div class="small text-muted" style="font-size:0.75rem;">
                  Realisasi: Rp <?= number_format((float)$p['biaya_realisasi'], 0, ',', '.') ?>
                </div>
              </td>

              <!-- C3: Dokumentasi Foto Progres -->
              <td>
                <div class="d-flex align-items-center gap-1">
                  <span class="badge bg-secondary-subtle text-secondary border px-2 py-1 mono-num fw-bold">
                    Skor <?= $p['kriteria_preview']['C3'] ?> / 5
                  </span>
                </div>
                <div class="text-muted" style="font-size:0.72rem;">
                  Rubrik Foto Progres
                </div>
              </td>

              <!-- C4: BAST -->
              <td>
                <span class="badge bg-primary-subtle text-primary border px-2 py-1 mono-num fw-bold">
                  Skor <?= $p['kriteria_preview']['C4'] ?> / 5
                </span>
                <div class="text-muted" style="font-size:0.72rem;">
                  Rubrik BAST
                </div>
              </td>

              <!-- C5: Keterlambatan -->
              <td>
                <div class="fw-bold mono-num <?= ($p['kriteria_preview']['C5'] > 0) ? 'text-danger' : 'text-success' ?>">
                  <?= $p['kriteria_preview']['C5'] ?> Hari
                </div>
                <div class="text-muted" style="font-size:0.72rem;">
                  Aktual: <?= date('d/m/Y', strtotime($p['tanggal_selesai_aktual'])) ?>
                </div>
              </td>

              <!-- Aksi -->
              <td class="text-center">
                <div class="btn-group btn-group-sm">
                  <a href="<?= site_url('penilaian/' . $periode['id'] . '/' . $p['proyek_id']) ?>" class="btn btn-outline-primary" title="Input / Edit Data Mentah">
                    <i class="bi bi-pencil-square me-1"></i> Input
                  </a>
                  <button type="button" class="btn btn-outline-danger" title="Keluarkan dari Periode" onclick="confirmRemoveProyek(<?= $p['proyek_id'] ?>, '<?= esc($p['proyek_nama']) ?>')">
                    <i class="bi bi-x-lg"></i>
                  </button>
                </div>
              </td>
            </tr>
          <?php endforeach; ?>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
</div>

<!-- Modal Tambah Proyek ke Periode -->
<?php if (!empty($availableProyeks)): ?>
  <div class="modal fade" id="addProyekModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <form action="<?= site_url('penilaian/' . $periode['id'] . '/add') ?>" method="post">
          <?= csrf_field() ?>
          <div class="modal-header">
            <h5 class="modal-title fw-bold">Tambah Proyek ke Periode</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
          </div>
          <div class="modal-body">
            <div class="mb-3">
              <label class="form-label small fw-bold">Pilih Proyek:</label>
              <select name="proyek_id" class="form-select" required>
                <option value="">-- Pilih Proyek --</option>
                <?php foreach ($availableProyeks as $ap): ?>
                  <option value="<?= $ap['id'] ?>"><?= esc($ap['kode']) ?> - <?= esc($ap['nama']) ?> (<?= ucfirst($ap['jenis']) ?>)</option>
                <?php endforeach; ?>
              </select>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-sm btn-light border" data-bs-dismiss="modal">Batal</button>
            <button type="submit" class="btn btn-sm btn-navy">Tambahkan</button>
          </div>
        </form>
      </div>
    </div>
  </div>
<?php endif; ?>

<!-- Modal Edit Cepat Semua Proyek (Batch Input Table) -->
<?php if (!empty($penilaians)): ?>
  <div class="modal fade" id="batchEditModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-fullscreen-lg-down modal-xl modal-dialog-scrollable">
      <div class="modal-content">
        <form action="<?= site_url('penilaian/' . $periode['id'] . '/batch') ?>" method="post">
          <?= csrf_field() ?>
          <div class="modal-header bg-navy text-white">
            <div>
              <h5 class="modal-title fw-bold text-white mb-0"><i class="bi bi-table me-2 text-warning"></i>Mode Edit Cepat: <?= esc($periode['nama']) ?></h5>
              <small class="text-white-50">Isi seluruh data proyek sekaligus dalam satu tabel lalu klik simpan.</small>
            </div>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
          </div>

          <div class="modal-body p-3">
            <div class="table-responsive">
              <table class="table table-bordered table-sm align-middle mb-0" style="font-size: 0.85rem;">
                <thead class="table-light">
                  <tr class="text-center align-middle">
                    <th style="min-width: 150px;">Proyek</th>
                    <th style="min-width: 110px;">Progres Aktual (%)</th>
                    <th style="min-width: 140px;">Realisasi Biaya (Rp)</th>
                    <th style="min-width: 150px;">C3: Foto Progres</th>
                    <th style="min-width: 120px;">C4: BAST</th>
                    <th style="min-width: 150px;">Tgl Selesai Aktual</th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach ($penilaians as $p): ?>
                    <tr>
                      <td>
                        <div class="fw-bold text-dark"><?= esc($p['proyek_nama']) ?></div>
                        <div class="text-muted small" style="font-size:0.75rem;">
                          <?= esc($p['proyek_kode']) ?> &bull; RAB: Rp <?= number_format((float)$p['nilai_rab'], 0, ',', '.') ?>
                        </div>
                      </td>
                      <td>
                        <div class="input-group input-group-sm">
                          <input type="number" step="0.01" min="0" max="100" name="items[<?= $p['proyek_id'] ?>][progres_aktual]" class="form-control form-control-sm text-end" value="<?= (float)$p['progres_aktual'] ?>" required>
                          <span class="input-group-text">%</span>
                        </div>
                      </td>
                      <td>
                        <input type="number" step="0.01" min="0" name="items[<?= $p['proyek_id'] ?>][biaya_realisasi]" class="form-control form-control-sm text-end" value="<?= (float)$p['biaya_realisasi'] ?>" required>
                      </td>
                      <td>
                        <select name="items[<?= $p['proyek_id'] ?>][skor_foto_progres]" class="form-select form-select-sm" required>
                          <option value="5" <?= ((int)($p['skor_foto_progres'] ?? 5) === 5) ? 'selected' : '' ?>>5 - Sangat Lengkap</option>
                          <option value="4" <?= ((int)($p['skor_foto_progres'] ?? 5) === 4) ? 'selected' : '' ?>>4 - Lengkap</option>
                          <option value="3" <?= ((int)($p['skor_foto_progres'] ?? 5) === 3) ? 'selected' : '' ?>>3 - Cukup</option>
                          <option value="2" <?= ((int)($p['skor_foto_progres'] ?? 5) === 2) ? 'selected' : '' ?>>2 - Kurang</option>
                          <option value="1" <?= ((int)($p['skor_foto_progres'] ?? 5) === 1) ? 'selected' : '' ?>>1 - Tidak Ada</option>
                        </select>
                      </td>
                      <td>
                        <select name="items[<?= $p['proyek_id'] ?>][skor_bast]" class="form-select form-select-sm" required>
                          <option value="5" <?= ((int)$p['skor_bast'] === 5) ? 'selected' : '' ?>>5 - Sempurna</option>
                          <option value="4" <?= ((int)$p['skor_bast'] === 4) ? 'selected' : '' ?>>4 - Ringan</option>
                          <option value="3" <?= ((int)$p['skor_bast'] === 3) ? 'selected' : '' ?>>3 - Sedang</option>
                          <option value="2" <?= ((int)$p['skor_bast'] === 2) ? 'selected' : '' ?>>2 - Catatan</option>
                          <option value="1" <?= ((int)$p['skor_bast'] === 1) ? 'selected' : '' ?>>1 - Belum</option>
                        </select>
                      </td>
                      <td>
                        <input type="date" name="items[<?= $p['proyek_id'] ?>][tanggal_selesai_aktual]" id="batch_tgl_<?= $p['proyek_id'] ?>" class="form-control form-control-sm mb-1" value="<?= $p['tanggal_selesai_aktual'] ?>" required>
                        <button type="button" class="btn btn-link btn-sm p-0 text-decoration-none text-success" style="font-size:0.72rem;" onclick="document.getElementById('batch_tgl_<?= $p['proyek_id'] ?>').value = '<?= $p['tanggal_selesai_rencana'] ?>'">
                          <i class="bi bi-clock-history"></i> Set Tepat Waktu
                        </button>
                      </td>
                    </tr>
                  <?php endforeach; ?>
                </tbody>
              </table>
            </div>
          </div>

          <div class="modal-footer bg-light">
            <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Tutup</button>
            <button type="submit" class="btn btn-navy btn-sm fw-bold px-3">
              <i class="bi bi-save me-1"></i> Simpan Semua Data Sekaligus
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
<?php endif; ?>

<!-- Modal Konfirmasi Keluarkan Proyek -->
<div class="modal fade" id="removeProyekModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-sm">
    <div class="modal-content">
      <div class="modal-body text-center p-4">
        <i class="bi bi-exclamation-circle-fill text-danger fs-1 mb-2"></i>
        <h5 class="fw-bold mb-1">Keluarkan Proyek?</h5>
        <p class="text-muted small mb-3">Keluarkan proyek <span id="remProyekName" class="fw-bold text-dark"></span> dari periode penilaian ini?</p>
        <div class="d-flex justify-content-center gap-2">
          <button type="button" class="btn btn-sm btn-light border px-3" data-bs-dismiss="modal">Batal</button>
          <a href="#" id="remProyekConfirmBtn" class="btn btn-sm btn-danger px-3">Keluarkan</a>
        </div>
      </div>
    </div>
  </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
  function confirmRemoveProyek(proyekId, name) {
    document.getElementById('remProyekName').innerText = name;
    document.getElementById('remProyekConfirmBtn').href = '<?= site_url('penilaian/' . $periode['id'] . '/remove/') ?>' + proyekId;
    const modal = new bootstrap.Modal(document.getElementById('removeProyekModal'));
    modal.show();
  }
</script>
<?= $this->endSection() ?>
