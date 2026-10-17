<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>
<!-- Top Banner Evaluasi Proyek -->
<div class="card card-modern mb-4 text-white" style="background: linear-gradient(135deg, #0f172a 0%, #1e293b 60%, #090d16 100%); border-left: 5px solid var(--amber-500);">
  <div class="card-body p-4 d-flex flex-wrap align-items-center justify-content-between gap-3">
    <div>
      <div class="d-flex align-items-center gap-2 mb-2">
        <span class="badge bg-warning text-dark px-3 py-1 fw-bold">PT RANCANG BANGUN SEDAYA</span>
        <span class="badge bg-secondary text-light px-2 py-1 small">Portfolio Proyek</span>
      </div>
      <h3 class="fw-bold mb-1 text-white">Evaluasi & Peringkat Kinerja Proyek</h3>
      <p class="text-white-50 small mb-0">
        Metode Simple Additive Weighting (SAW) &bull; Evaluasi Kurva S, efisiensi RAB, dokumentasi foto, dan Berita Acara Serah Terima.
      </p>
    </div>

    <!-- Tombol Aksi Utama -->
    <div class="d-flex align-items-center gap-2 flex-wrap">
      <!-- Tombol Tambah & Nilai Proyek -->
      <button type="button" class="btn btn-amber fw-bold shadow-sm d-flex align-items-center gap-2 px-3 py-2" data-bs-toggle="modal" data-bs-target="#modalTambahProyek">
        <i class="bi bi-plus-circle-fill fs-5"></i>
        <span>Tambah & Nilai Proyek</span>
      </button>

      <!-- Tombol Hitung Ulang -->
      <a href="<?= site_url('dashboard/hitung') ?>" class="btn btn-outline-light btn-sm fw-semibold d-flex align-items-center gap-1 py-2">
        <i class="bi bi-arrow-repeat"></i>
        <span>Hitung Ulang</span>
      </a>

      <!-- Tombol Cetak PDF -->
      <?php if (!empty($hasilList)): ?>
        <a href="<?= site_url('dashboard/pdf') ?>" target="_blank" class="btn btn-danger btn-sm fw-semibold shadow-sm d-flex align-items-center gap-1 py-2">
          <i class="bi bi-file-earmark-pdf-fill"></i>
          <span>Cetak Laporan PDF</span>
        </a>
      <?php endif; ?>
    </div>
  </div>
</div>

<!-- Stat Cards Ringkasan Kategori -->
<div class="row g-3 mb-4">
  <div class="col-sm-6 col-xl-3">
    <div class="stat-card">
      <div class="stat-card-inner">
        <div>
          <div class="stat-label">Total Proyek Dinilai</div>
          <div class="stat-value"><?= count($hasilList) ?></div>
          <div class="text-muted small mt-1">Seluruh Proyek Aktif</div>
        </div>
        <div class="stat-icon stat-icon-primary">
          <i class="bi bi-buildings"></i>
        </div>
      </div>
    </div>
  </div>

  <div class="col-sm-6 col-xl-3">
    <div class="stat-card">
      <div class="stat-card-inner">
        <div>
          <div class="stat-label">Kategori Baik</div>
          <div class="stat-value text-success"><?= $kategoriCount['Baik'] ?? 0 ?></div>
          <div class="text-muted small mt-1">Skor Minimal <?= number_format($batasBaik, 2) ?> ke Atas</div>
        </div>
        <div class="stat-icon stat-icon-green">
          <i class="bi bi-check-circle-fill"></i>
        </div>
      </div>
    </div>
  </div>

  <div class="col-sm-6 col-xl-3">
    <div class="stat-card">
      <div class="stat-card-inner">
        <div>
          <div class="stat-label">Perlu Perhatian</div>
          <div class="stat-value text-warning"><?= $kategoriCount['Perlu Perhatian'] ?? 0 ?></div>
          <div class="text-muted small mt-1">Skor <?= number_format($batasPerhatian, 2) ?> s/d <?= number_format($batasBaik - 0.01, 2) ?></div>
        </div>
        <div class="stat-icon stat-icon-amber">
          <i class="bi bi-exclamation-triangle-fill"></i>
        </div>
      </div>
    </div>
  </div>

  <div class="col-sm-6 col-xl-3">
    <div class="stat-card">
      <div class="stat-card-inner">
        <div>
          <div class="stat-label">Berisiko / Terlambat</div>
          <div class="stat-value text-danger"><?= $kategoriCount['Berisiko/Terlambat'] ?? 0 ?></div>
          <div class="text-muted small mt-1">Skor di Bawah <?= number_format($batasPerhatian, 2) ?></div>
        </div>
        <div class="stat-icon stat-icon-red">
          <i class="bi bi-shield-slash-fill"></i>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Main Table: Tabel Peringkat & Kategori -->
<div class="card card-modern mb-4">
  <div class="card-header bg-white py-3 px-4 border-bottom d-flex flex-wrap align-items-center justify-content-between gap-2">
    <div class="d-flex align-items-center gap-2">
      <i class="bi bi-trophy-fill text-warning fs-5"></i>
      <h5 class="fw-bold mb-0 text-dark">Peringkat & Kategori Kinerja Proyek</h5>
    </div>
    <div class="d-flex align-items-center gap-2">
      <span class="badge bg-light text-secondary border">Total: <?= count($hasilList) ?> Proyek</span>
      <button type="button" class="btn btn-sm btn-navy fw-semibold" data-bs-toggle="modal" data-bs-target="#modalTambahProyek">
        <i class="bi bi-plus-lg me-1"></i> Tambah Proyek
      </button>
    </div>
  </div>

  <div class="card-body p-0">
    <?php if (empty($hasilList)): ?>
      <div class="text-center py-5 px-3">
        <i class="bi bi-folder-plus text-muted" style="font-size: 3.5rem;"></i>
        <h5 class="fw-bold mt-3 text-dark">Belum Ada Proyek yang Dinilai</h5>
        <p class="text-muted small mb-3">Klik tombol di bawah ini untuk memasukkan proyek pertama dan langsung melihat peringkat kinerjanya.</p>
        <button type="button" class="btn btn-amber fw-bold px-4 py-2" data-bs-toggle="modal" data-bs-target="#modalTambahProyek">
          <i class="bi bi-plus-circle me-1"></i> Tambah & Nilai Proyek Sekarang
        </button>
      </div>
    <?php else: ?>
      <div class="table-responsive">
        <table class="table table-modern table-hover align-middle mb-0">
          <thead>
            <tr>
              <th style="width: 75px;" class="text-center">Peringkat</th>
              <th>Kode & Nama Proyek</th>
              <th>Jenis</th>
              <th>Klien & Lokasi</th>
              <th class="text-end">Nilai RAB (Rp)</th>
              <th class="text-center">Skor Kinerja</th>
              <th class="text-center">Kategori Kinerja</th>
              <th class="text-center" style="width: 130px;">Aksi</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($hasilList as $h): ?>
              <tr>
                <!-- Rank Badge -->
                <td class="text-center">
                  <?php if ($h['peringkat'] == 1): ?>
                    <span class="rank-badge rank-gold" title="Peringkat 1">1</span>
                  <?php elseif ($h['peringkat'] == 2): ?>
                    <span class="rank-badge rank-silver" title="Peringkat 2">2</span>
                  <?php elseif ($h['peringkat'] == 3): ?>
                    <span class="rank-badge rank-bronze" title="Peringkat 3">3</span>
                  <?php else: ?>
                    <span class="rank-badge rank-normal"><?= $h['peringkat'] ?></span>
                  <?php endif; ?>
                </td>

                <!-- Nama Proyek -->
                <td>
                  <div class="fw-bold text-dark fs-6"><?= esc($h['proyek_nama']) ?></div>
                  <span class="badge bg-light text-secondary border font-monospace"><?= esc($h['proyek_kode']) ?></span>
                </td>

                <!-- Jenis -->
                <td>
                  <span class="badge bg-light text-dark border text-capitalize"><?= esc($h['jenis']) ?></span>
                </td>

                <!-- Klien & Lokasi -->
                <td class="small">
                  <div class="fw-semibold text-dark"><?= esc($h['klien']) ?></div>
                  <div class="text-muted" style="font-size:0.75rem;"><i class="bi bi-geo-alt me-1"></i><?= esc($h['lokasi']) ?></div>
                </td>

                <!-- RAB -->
                <td class="text-end mono-num text-dark fw-bold">
                  Rp <?= number_format((float)$h['nilai_rab'], 0, ',', '.') ?>
                </td>

                <!-- Vi -->
                <td class="text-center">
                  <div class="fs-5 fw-bold mono-num text-dark">
                    <?= number_format((float)$h['vi'], 2) ?>
                  </div>
                  <div class="text-muted" style="font-size:0.72rem;">(<?= number_format((float)$h['vi'], 4) ?>)</div>
                </td>

                <!-- Kategori Badge -->
                <td class="text-center">
                  <?php if ($h['kategori'] === 'Baik'): ?>
                    <span class="badge-kategori badge-baik">
                      <i class="bi bi-check-circle-fill"></i> Baik
                    </span>
                  <?php elseif ($h['kategori'] === 'Perlu Perhatian'): ?>
                    <span class="badge-kategori badge-perhatian">
                      <i class="bi bi-exclamation-triangle-fill"></i> Perlu Perhatian
                    </span>
                  <?php else: ?>
                    <span class="badge-kategori badge-berisiko">
                      <i class="bi bi-x-circle-fill"></i> Berisiko/Terlambat
                    </span>
                  <?php endif; ?>
                </td>

                <!-- Tombol Aksi Edit & Hapus -->
                <td class="text-center">
                  <div class="btn-group btn-group-sm">
                    <button type="button" class="btn btn-outline-primary" title="Edit Nilai Proyek Ini" 
                      onclick='bukaModalEdit(<?= json_encode([
                        'proyek_id'              => $h['proyek_id'],
                        'nama'                   => $h['proyek_nama'],
                        'kode'                   => $h['proyek_kode'],
                        'jenis'                  => $h['jenis'],
                        'klien'                  => $h['klien'],
                        'lokasi'                 => $h['lokasi'],
                        'nilai_rab'              => (float)$h['nilai_rab'],
                        'tanggal_selesai_rencana'=> $h['tanggal_selesai_rencana'],
                        'progres_aktual'         => (float)($h['raw']['progres_aktual'] ?? $h['c1']),
                        'biaya_realisasi'        => (float)($h['raw']['biaya_realisasi'] ?? ($h['nilai_rab'] * $h['c2'] / 100)),
                        'skor_foto_progres'      => (int)($h['raw']['skor_foto_progres'] ?? $h['c3']),
                        'skor_bast'              => (int)($h['raw']['skor_bast'] ?? $h['c4']),
                        'skor_kepuasan_klien'    => (int)($h['raw']['skor_kepuasan_klien'] ?? $h['c6'] ?? 5),
                        'skor_k3'                => (int)($h['raw']['skor_k3'] ?? $h['c7'] ?? 5),
                        'tanggal_selesai_aktual' => $h['raw']['tanggal_selesai_aktual'] ?? $h['tanggal_selesai_rencana'],
                      ], JSON_HEX_APOS | JSON_HEX_QUOT) ?>)'>
                      <i class="bi bi-pencil-square me-1"></i> Edit
                    </button>
                    <a href="<?= site_url('dashboard/hapus/' . $h['proyek_id']) ?>" class="btn btn-outline-danger" title="Hapus dari Evaluasi" onclick="return confirm('Apakah Anda yakin ingin menghapus proyek <?= esc($h['proyek_nama']) ?> dari evaluasi?')">
                      <i class="bi bi-trash"></i>
                    </a>
                  </div>
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>

      <!-- Rekomendasi Singkat Manajemen -->
      <div class="p-4 bg-light border-top">
        <h6 class="fw-bold mb-3 text-dark"><i class="bi bi-lightbulb-fill text-warning me-2"></i>Rekomendasi Tindakan Manajemen (Berdasarkan Kategori)</h6>
        <div class="row g-3">
          <div class="col-md-4">
            <div class="p-3 bg-white rounded border border-success-subtle h-100">
              <div class="d-flex align-items-center gap-2 mb-2 text-success fw-bold">
                <i class="bi bi-check-circle-fill"></i> Kategori Baik (Skor Minimal <?= number_format($batasBaik, 2) ?> ke Atas)
              </div>
              <p class="small text-muted mb-0">
                Proyek berjalan sesuai Kurva S, efisiensi anggaran terjaga, dan dokumentasi foto lapangan lengkap. Pertahankan ritme kerja dan koordinasi mitra.
              </p>
            </div>
          </div>
          <div class="col-md-4">
            <div class="p-3 bg-white rounded border border-warning-subtle h-100">
              <div class="d-flex align-items-center gap-2 mb-2 text-warning fw-bold">
                <i class="bi bi-exclamation-triangle-fill"></i> Perlu Perhatian (Skor <?= number_format($batasPerhatian, 2) ?> s/d <?= number_format($batasBaik - 0.01, 2) ?>)
              </div>
              <p class="small text-muted mb-0">
                Terdapat deviasi ringan pada progres fisik, kenaikan pengeluaran biaya, atau keterlambatan waktu serah terima. Lakukan rapat evaluasi berkala segera.
              </p>
            </div>
          </div>
          <div class="col-md-4">
            <div class="p-3 bg-white rounded border border-danger-subtle h-100">
              <div class="d-flex align-items-center gap-2 mb-2 text-danger fw-bold">
                <i class="bi bi-exclamation-octagon-fill"></i> Berisiko / Terlambat (Skor di Bawah <?= number_format($batasPerhatian, 2) ?>)
              </div>
              <p class="small text-muted mb-0">
                Prioritas intervensi penanganan segera! Terapkan percepatan jadwal, penambahan tenaga kerja, evaluasi hambatan teknis, dan audit pengeluaran RAB.
              </p>
            </div>
          </div>
        </div>
      </div>
    <?php endif; ?>
  </div>
</div>

<!-- ========================================== -->
<!-- ========================================== -->
<!-- MODAL 1: TAMBAH & NILAI PROYEK BARU        -->
<!-- ========================================== -->
<div class="modal fade" id="modalTambahProyek" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
    <form action="<?= site_url('dashboard/simpan') ?>" method="post" class="modal-content border-0 shadow" style="max-height: 90vh;">
      <?= csrf_field() ?>

      <div class="modal-header bg-navy text-white py-3 px-4" style="background-color: #0f172a !important;">
        <div class="d-flex align-items-center gap-2">
          <i class="bi bi-plus-circle-fill text-warning fs-5"></i>
          <div>
            <h5 class="modal-title fw-bold text-white mb-0">Tambah & Nilai Proyek</h5>
            <small class="text-white-50">Isi data proyek dan kondisi lapangan langsung dalam 1 form</small>
          </div>
        </div>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>

      <div class="modal-body p-4" style="overflow-y: auto; max-height: calc(88vh - 130px);">
        <!-- BAGIAN 1: IDENTITAS PROYEK -->
        <div class="mb-4">
          <h6 class="fw-bold text-dark border-bottom pb-2 d-flex align-items-center gap-2">
            <span class="badge bg-primary">1</span>
            <span>Identitas & Anggaran Proyek</span>
          </h6>
          <div class="row g-3 mt-1">
            <div class="col-md-8">
              <label class="form-label small fw-bold">Nama Proyek <span class="text-danger">*</span></label>
              <input type="text" name="nama" class="form-control" placeholder="Contoh: Pembangunan Villa Modern 2 Lantai" required>
            </div>
            <div class="col-md-4">
              <label class="form-label small fw-bold">Kode Proyek</label>
              <input type="text" name="kode" class="form-control font-monospace" placeholder="Contoh: PRJ-001 (Opsional)">
            </div>
            <div class="col-md-4">
              <label class="form-label small fw-bold">Jenis Proyek <span class="text-danger">*</span></label>
              <select name="jenis" class="form-select" required>
                <?php foreach ($jenisList as $j): ?>
                  <option value="<?= $j ?>"><?= ucfirst($j) ?></option>
                <?php endforeach; ?>
              </select>
            </div>
            <div class="col-md-4">
              <label class="form-label small fw-bold">Klien / Pemilik <span class="text-danger">*</span></label>
              <input type="text" name="klien" class="form-control" placeholder="Contoh: Bpk. Arya Pratama" required>
            </div>
            <div class="col-md-4">
              <label class="form-label small fw-bold">Lokasi Proyek <span class="text-danger">*</span></label>
              <input type="text" name="lokasi" class="form-control" placeholder="Contoh: Pasirmulya, Bogor Barat" required>
            </div>
            <div class="col-md-6">
              <label class="form-label small fw-bold">Nilai RAB Disepakati (Rp) <span class="text-danger">*</span></label>
              <div class="input-group">
                <span class="input-group-text bg-light fw-bold text-muted">Rp</span>
                <input type="number" step="0.01" min="1" name="nilai_rab" id="addNilaiRab" class="form-control mono-num fw-bold text-dark" placeholder="850000000" required>
              </div>
            </div>
            <div class="col-md-6">
              <label class="form-label small fw-bold">Target Rencana Selesai <span class="text-danger">*</span></label>
              <input type="date" name="tanggal_selesai_rencana" id="addTglRencana" class="form-control mono-num" required value="<?= date('Y-m-d', strtotime('+3 months')) ?>" onchange="syncAddDelay(document.getElementById('addHariTerlambat').value)">
            </div>
          </div>
        </div>

        <!-- BAGIAN 2: NILAI LAPANGAN (SAW C1 s/d C5) -->
        <div>
          <h6 class="fw-bold text-dark border-bottom pb-2 d-flex align-items-center gap-2">
            <span class="badge bg-warning text-dark">2</span>
            <span>Realisasi Lapangan & Kinerja (Kriteria C1 - C5)</span>
          </h6>
          <div class="row g-3 mt-1">
            <!-- C1: Progres Aktual -->
            <div class="col-md-6">
              <label class="form-label small fw-bold">C1: Progres Fisik Aktual (%) <span class="text-danger">*</span></label>
              <div class="input-group">
                <input type="number" step="0.01" min="0" max="100" name="progres_aktual" class="form-control mono-num" placeholder="95.50" required>
                <span class="input-group-text">%</span>
              </div>
              <div class="form-text small" style="font-size:0.75rem;">Realisasi fisik di lapangan saat penilaian.</div>
            </div>

            <!-- C2: Biaya Realisasi -->
            <div class="col-md-6">
              <label class="form-label small fw-bold">C2: Biaya Pengeluaran Realisasi (Rp) <span class="text-danger">*</span></label>
              <div class="input-group">
                <span class="input-group-text">Rp</span>
                <input type="number" step="0.01" min="0" name="biaya_realisasi" class="form-control mono-num" placeholder="816000000" required>
              </div>
              <div class="form-text small" style="font-size:0.75rem;">Total biaya pengeluaran riil aktual.</div>
            </div>

            <!-- C3: Foto Progres -->
            <div class="col-md-6">
              <label class="form-label small fw-bold">C3: Dokumentasi Foto Progres Lapangan <span class="text-danger">*</span></label>
              <select name="skor_foto_progres" class="form-select" required>
                <option value="5" selected>Skor 5 - Sangat Lengkap (Rutin & Terarsip Rapih)</option>
                <option value="4">Skor 4 - Lengkap (Pekerjaan Utama Rutin Ada)</option>
                <option value="3">Skor 3 - Cukup (Hanya Zona Tertentu)</option>
                <option value="2">Skor 2 - Kurang (Jarang Difoto)</option>
                <option value="1">Skor 1 - Tidak Ada / Sangat Minim</option>
              </select>
            </div>

            <!-- C4: BAST -->
            <div class="col-md-6">
              <label class="form-label small fw-bold">C4: Ketepatan Serah Terima / BAST <span class="text-danger">*</span></label>
              <select name="skor_bast" class="form-select" required>
                <option value="5" selected>Skor 5 - Sempurna (Tepat Waktu Tanpa Catatan)</option>
                <option value="4">Skor 4 - Catatan Ringan</option>
                <option value="3">Skor 3 - Terlambat Ringan</option>
                <option value="2">Skor 2 - Ada Catatan Perbaikan</option>
                <option value="1">Skor 1 - Belum Ada BAST</option>
              </select>
            </div>

            <!-- C5: Keterlambatan Waktu -->
            <div class="col-12">
              <div class="p-3 bg-light rounded border">
                <label class="form-label small fw-bold mb-1 text-dark">C5: Keterlambatan Waktu Penyelesaian <span class="text-danger">*</span></label>
                <div class="row g-2 align-items-center">
                  <div class="col-sm-6">
                    <div class="input-group">
                      <input type="number" min="0" name="hari_terlambat" id="addHariTerlambat" class="form-control mono-num fw-bold text-dark" value="0" placeholder="0" required oninput="syncAddDelay(this.value)">
                      <span class="input-group-text bg-white">Hari Terlambat</span>
                    </div>
                    <div class="form-text small" style="font-size:0.75rem;">Ketik <strong>0</strong> jika selesai tepat waktu, atau isi jumlah hari keterlambatan.</div>
                  </div>
                  <div class="col-sm-6">
                    <div class="input-group input-group-sm">
                      <span class="input-group-text bg-white small text-muted">Tanggal Selesai:</span>
                      <input type="date" name="tanggal_selesai_aktual" id="addTglAktual" class="form-control mono-num" onchange="syncAddDate(this.value)">
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- C6: Kepuasan Klien -->
            <div class="col-md-6">
              <label class="form-label small fw-bold">C6: Tingkat Kepuasan Klien / Owner <span class="text-danger">*</span></label>
              <select name="skor_kepuasan_klien" class="form-select" required>
                <option value="5" selected>Skor 5 - Sangat Puas (Puas Tanpa Catatan / Komplain)</option>
                <option value="4">Skor 4 - Puas (Ada Masukan / Catatan Minor)</option>
                <option value="3">Skor 3 - Cukup Puas</option>
                <option value="2">Skor 2 - Kurang Puas (Ada Keluhan Signifikan)</option>
                <option value="1">Skor 1 - Tidak Puas / Sangat Kecewa</option>
              </select>
            </div>

            <!-- C7: Penerapan K3 -->
            <div class="col-md-6">
              <label class="form-label small fw-bold">C7: Penerapan K3 & Keselamatan Kerja <span class="text-danger">*</span></label>
              <select name="skor_k3" class="form-select" required>
                <option value="5" selected>Skor 5 - Sangat Baik (Zero Accident + APD 100% Tertib)</option>
                <option value="4">Skor 4 - Baik (Zero Accident + Teguran Lisan Ringan)</option>
                <option value="3">Skor 3 - Cukup (Disiplin APD Sedang)</option>
                <option value="2">Skor 2 - Kurang (Ada Cedera Ringan / APD Jarang Dipakai)</option>
                <option value="1">Skor 1 - Buruk (Insiden Berat / K3 Diabaikan)</option>
              </select>
            </div>
          </div>
        </div>
      </div>

      <div class="modal-footer bg-light py-3 px-4 border-top">
        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
        <button type="submit" class="btn btn-navy px-4 fw-bold">
          <i class="bi bi-save-fill me-1 text-warning"></i> Simpan & Hitung Peringkat
        </button>
      </div>
    </form>
  </div>
</div>

<!-- ========================================== -->
<!-- MODAL 2: EDIT NILAI PROYEK                 -->
<!-- ========================================== -->
<div class="modal fade" id="modalEditProyek" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
    <form action="<?= site_url('dashboard/simpan') ?>" method="post" class="modal-content border-0 shadow" style="max-height: 90vh;">
      <?= csrf_field() ?>
      <input type="hidden" name="proyek_id" id="editProyekId">

      <div class="modal-header bg-navy text-white py-3 px-4" style="background-color: #0f172a !important;">
        <div class="d-flex align-items-center gap-2">
          <i class="bi bi-pencil-square text-warning fs-5"></i>
          <div>
            <h5 class="modal-title fw-bold text-white mb-0">Edit Data & Nilai Proyek</h5>
            <small class="text-white-50">Perbarui data atau angka evaluasi lapangan proyek ini</small>
          </div>
        </div>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>

      <div class="modal-body p-4" style="overflow-y: auto; max-height: calc(88vh - 130px);">
        <!-- BAGIAN 1: IDENTITAS PROYEK -->
        <div class="mb-4">
          <h6 class="fw-bold text-dark border-bottom pb-2 d-flex align-items-center gap-2">
            <span class="badge bg-primary">1</span>
            <span>Identitas & Anggaran Proyek</span>
          </h6>
          <div class="row g-3 mt-1">
            <div class="col-md-8">
              <label class="form-label small fw-bold">Nama Proyek <span class="text-danger">*</span></label>
              <input type="text" name="nama" id="editNama" class="form-control" required>
            </div>
            <div class="col-md-4">
              <label class="form-label small fw-bold">Kode Proyek</label>
              <input type="text" name="kode" id="editKode" class="form-control font-monospace" required>
            </div>
            <div class="col-md-4">
              <label class="form-label small fw-bold">Jenis Proyek <span class="text-danger">*</span></label>
              <select name="jenis" id="editJenis" class="form-select" required>
                <?php foreach ($jenisList as $j): ?>
                  <option value="<?= $j ?>"><?= ucfirst($j) ?></option>
                <?php endforeach; ?>
              </select>
            </div>
            <div class="col-md-4">
              <label class="form-label small fw-bold">Klien / Pemilik <span class="text-danger">*</span></label>
              <input type="text" name="klien" id="editKlien" class="form-control" required>
            </div>
            <div class="col-md-4">
              <label class="form-label small fw-bold">Lokasi Proyek <span class="text-danger">*</span></label>
              <input type="text" name="lokasi" id="editLokasi" class="form-control" required>
            </div>
            <div class="col-md-6">
              <label class="form-label small fw-bold">Nilai RAB Disepakati (Rp) <span class="text-danger">*</span></label>
              <div class="input-group">
                <span class="input-group-text bg-light fw-bold text-muted">Rp</span>
                <input type="number" step="0.01" min="1" name="nilai_rab" id="editNilaiRab" class="form-control mono-num fw-bold text-dark" required>
              </div>
            </div>
            <div class="col-md-6">
              <label class="form-label small fw-bold">Target Rencana Selesai <span class="text-danger">*</span></label>
              <input type="date" name="tanggal_selesai_rencana" id="editTglRencana" class="form-control mono-num" required onchange="syncEditDelay(document.getElementById('editHariTerlambat').value)">
            </div>
          </div>
        </div>

        <!-- BAGIAN 2: NILAI LAPANGAN (SAW C1 s/d C5) -->
        <div>
          <h6 class="fw-bold text-dark border-bottom pb-2 d-flex align-items-center gap-2">
            <span class="badge bg-warning text-dark">2</span>
            <span>Realisasi Lapangan & Kinerja (Kriteria C1 - C5)</span>
          </h6>
          <div class="row g-3 mt-1">
            <!-- C1: Progres Aktual -->
            <div class="col-md-6">
              <label class="form-label small fw-bold">C1: Progres Fisik Aktual (%) <span class="text-danger">*</span></label>
              <div class="input-group">
                <input type="number" step="0.01" min="0" max="100" name="progres_aktual" id="editProgresAktual" class="form-control mono-num" required>
                <span class="input-group-text">%</span>
              </div>
            </div>

            <!-- C2: Biaya Realisasi -->
            <div class="col-md-6">
              <label class="form-label small fw-bold">C2: Biaya Pengeluaran Realisasi (Rp) <span class="text-danger">*</span></label>
              <div class="input-group">
                <span class="input-group-text">Rp</span>
                <input type="number" step="0.01" min="0" name="biaya_realisasi" id="editBiayaRealisasi" class="form-control mono-num" required>
              </div>
            </div>

            <!-- C3: Foto Progres -->
            <div class="col-md-6">
              <label class="form-label small fw-bold">C3: Dokumentasi Foto Progres Lapangan <span class="text-danger">*</span></label>
              <select name="skor_foto_progres" id="editSkorFoto" class="form-select" required>
                <option value="5">Skor 5 - Sangat Lengkap (Rutin & Terarsip Rapih)</option>
                <option value="4">Skor 4 - Lengkap (Pekerjaan Utama Rutin Ada)</option>
                <option value="3">Skor 3 - Cukup (Hanya Zona Tertentu)</option>
                <option value="2">Skor 2 - Kurang (Jarang Difoto)</option>
                <option value="1">Skor 1 - Tidak Ada / Sangat Minim</option>
              </select>
            </div>

            <!-- C4: BAST -->
            <div class="col-md-6">
              <label class="form-label small fw-bold">C4: Ketepatan Serah Terima / BAST <span class="text-danger">*</span></label>
              <select name="skor_bast" id="editSkorBast" class="form-select" required>
                <option value="5">Skor 5 - Sempurna (Tepat Waktu Tanpa Catatan)</option>
                <option value="4">Skor 4 - Catatan Ringan</option>
                <option value="3">Skor 3 - Terlambat Ringan</option>
                <option value="2">Skor 2 - Ada Catatan Perbaikan</option>
                <option value="1">Skor 1 - Belum Ada BAST</option>
              </select>
            </div>

            <!-- C5: Keterlambatan Waktu -->
            <div class="col-12">
              <div class="p-3 bg-light rounded border">
                <label class="form-label small fw-bold mb-1 text-dark">C5: Keterlambatan Waktu Penyelesaian <span class="text-danger">*</span></label>
                <div class="row g-2 align-items-center">
                  <div class="col-sm-6">
                    <div class="input-group">
                      <input type="number" min="0" name="hari_terlambat" id="editHariTerlambat" class="form-control mono-num fw-bold text-dark" value="0" placeholder="0" required oninput="syncEditDelay(this.value)">
                      <span class="input-group-text bg-white">Hari Terlambat</span>
                    </div>
                    <div class="form-text small" style="font-size:0.75rem;">Ketik <strong>0</strong> jika tepat waktu, atau isi jumlah hari keterlambatan.</div>
                  </div>
                  <div class="col-sm-6">
                    <div class="input-group input-group-sm">
                      <span class="input-group-text bg-white small text-muted">Tanggal Selesai:</span>
                      <input type="date" name="tanggal_selesai_aktual" id="editTglAktual" class="form-control mono-num" onchange="syncEditDate(this.value)">
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- C6: Kepuasan Klien -->
            <div class="col-md-6">
              <label class="form-label small fw-bold">C6: Tingkat Kepuasan Klien / Owner <span class="text-danger">*</span></label>
              <select name="skor_kepuasan_klien" id="editSkorKepuasan" class="form-select" required>
                <option value="5">Skor 5 - Sangat Puas (Puas Tanpa Catatan / Komplain)</option>
                <option value="4">Skor 4 - Puas (Ada Masukan / Catatan Minor)</option>
                <option value="3">Skor 3 - Cukup Puas</option>
                <option value="2">Skor 2 - Kurang Puas (Ada Keluhan Signifikan)</option>
                <option value="1">Skor 1 - Tidak Puas / Sangat Kecewa</option>
              </select>
            </div>

            <!-- C7: Penerapan K3 -->
            <div class="col-md-6">
              <label class="form-label small fw-bold">C7: Penerapan K3 & Keselamatan Kerja <span class="text-danger">*</span></label>
              <select name="skor_k3" id="editSkorK3" class="form-select" required>
                <option value="5">Skor 5 - Sangat Baik (Zero Accident + APD 100% Tertib)</option>
                <option value="4">Skor 4 - Baik (Zero Accident + Teguran Lisan Ringan)</option>
                <option value="3">Skor 3 - Cukup (Disiplin APD Sedang)</option>
                <option value="2">Skor 2 - Kurang (Ada Cedera Ringan / APD Jarang Dipakai)</option>
                <option value="1">Skor 1 - Buruk (Insiden Berat / K3 Diabaikan)</option>
              </select>
            </div>
          </div>
        </div>
      </div>

      <div class="modal-footer bg-light py-3 px-4 border-top">
        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
        <button type="submit" class="btn btn-navy px-4 fw-bold">
          <i class="bi bi-save-fill me-1 text-warning"></i> Perbarui & Hitung Ulang
        </button>
      </div>
    </form>
  </div>
</div>

<script>
function syncAddDelay(days) {
  const tglRencana = document.getElementById('addTglRencana').value;
  if (!tglRencana) return;
  const d = new Date(tglRencana);
  d.setDate(d.getDate() + parseInt(days || 0));
  document.getElementById('addTglAktual').value = d.toISOString().split('T')[0];
}

function syncAddDate(val) {
  const tglRencana = document.getElementById('addTglRencana').value;
  if (!tglRencana || !val) return;
  const dR = new Date(tglRencana);
  const dA = new Date(val);
  const diff = Math.max(0, Math.ceil((dA - dR) / (1000 * 60 * 60 * 24)));
  document.getElementById('addHariTerlambat').value = diff;
}

function syncEditDelay(days) {
  const tglRencana = document.getElementById('editTglRencana').value;
  if (!tglRencana) return;
  const d = new Date(tglRencana);
  d.setDate(d.getDate() + parseInt(days || 0));
  document.getElementById('editTglAktual').value = d.toISOString().split('T')[0];
}

function syncEditDate(val) {
  const tglRencana = document.getElementById('editTglRencana').value;
  if (!tglRencana || !val) return;
  const dR = new Date(tglRencana);
  const dA = new Date(val);
  const diff = Math.max(0, Math.ceil((dA - dR) / (1000 * 60 * 60 * 24)));
  document.getElementById('editHariTerlambat').value = diff;
}

function bukaModalEdit(data) {
  document.getElementById('editProyekId').value = data.proyek_id || '';
  document.getElementById('editNama').value = data.nama || '';
  document.getElementById('editKode').value = data.kode || '';
  document.getElementById('editJenis').value = data.jenis || 'rumah';
  document.getElementById('editKlien').value = data.klien || '';
  document.getElementById('editLokasi').value = data.lokasi || '';
  document.getElementById('editNilaiRab').value = data.nilai_rab || '';
  document.getElementById('editTglRencana').value = data.tanggal_selesai_rencana || '';
  document.getElementById('editProgresAktual').value = data.progres_aktual || '';
  document.getElementById('editBiayaRealisasi').value = data.biaya_realisasi || '';
  document.getElementById('editSkorFoto').value = data.skor_foto_progres || 5;
  document.getElementById('editSkorBast').value = data.skor_bast || 5;
  document.getElementById('editSkorKepuasan').value = data.skor_kepuasan_klien || 5;
  document.getElementById('editSkorK3').value = data.skor_k3 || 5;

  const tglRencana = data.tanggal_selesai_rencana || '';
  const tglAktual  = data.tanggal_selesai_aktual || tglRencana;
  document.getElementById('editTglAktual').value = tglAktual;

  let delay = 0;
  if (tglRencana && tglAktual) {
    const dR = new Date(tglRencana);
    const dA = new Date(tglAktual);
    delay = Math.max(0, Math.ceil((dA - dR) / (1000 * 60 * 60 * 24)));
  }
  document.getElementById('editHariTerlambat').value = delay;

  const modal = new bootstrap.Modal(document.getElementById('modalEditProyek'));
  modal.show();
}

// Initial sync on load
document.addEventListener('DOMContentLoaded', () => {
  const addTgl = document.getElementById('addTglRencana');
  if (addTgl && addTgl.value) {
    syncAddDelay(0);
  }
});
</script>

<?= $this->endSection() ?>
