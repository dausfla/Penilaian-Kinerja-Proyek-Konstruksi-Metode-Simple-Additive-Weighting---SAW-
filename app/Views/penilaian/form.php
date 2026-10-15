<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>
<div class="row g-4">
  <!-- Kolom Kiri: Form Input Data Mentah Dokumen -->
  <div class="col-lg-8">
    <div class="d-flex align-items-center justify-content-between mb-3">
      <div>
        <h4 class="fw-bold mb-1">Input Data Mentah Proyek</h4>
        <p class="text-muted small mb-0">
          Periode: <strong><?= esc($periode['nama']) ?></strong> &bull; Proyek: <strong class="text-dark"><?= esc($penilaian['proyek_nama']) ?> (<?= esc($penilaian['proyek_kode']) ?>)</strong>
        </p>
      </div>
      <a href="<?= site_url('penilaian/' . $periode['id']) ?>" class="btn btn-outline-secondary btn-sm">
        <i class="bi bi-arrow-left me-1"></i> Kembali ke Periode
      </a>
    </div>

    <div class="card card-modern">
      <div class="card-body p-4">
        <form action="<?= site_url('penilaian/' . $periode['id'] . '/' . $penilaian['proyek_id']) ?>" method="post" id="formPenilaian">
          <?= csrf_field() ?>

          <!-- 1. Kurva S Progres Fisik -->
          <div class="p-3 bg-light rounded border mb-4">
            <h6 class="fw-bold mb-3 text-dark d-flex align-items-center gap-2">
              <span class="preview-badge-code">C1</span>
              <span>Kurva S & Capaian Progres Fisik</span>
            </h6>
            <div class="row g-3">
              <div class="col-md-6">
                <label class="form-label small fw-bold">Progres Rencana (%) <span class="text-danger">*</span></label>
                <div class="input-group input-group-sm">
                  <input type="number" step="0.01" min="0.01" max="100" name="progres_rencana" id="inputProgresRencana" class="form-control mono-num" required value="<?= old('progres_rencana', $penilaian['progres_rencana']) ?>">
                  <span class="input-group-text">%</span>
                </div>
                <div class="form-text small" style="font-size:0.75rem;">Target kumulatif Kurva S pada tanggal penilaian.</div>
              </div>
              <div class="col-md-6">
                <label class="form-label small fw-bold">Progres Aktual (%) <span class="text-danger">*</span></label>
                <div class="input-group input-group-sm">
                  <input type="number" step="0.01" min="0" max="100" name="progres_aktual" id="inputProgresAktual" class="form-control mono-num" required value="<?= old('progres_aktual', $penilaian['progres_aktual']) ?>">
                  <span class="input-group-text">%</span>
                </div>
                <div class="form-text small" style="font-size:0.75rem;">Realisasi progres fisik aktual di lapangan.</div>
              </div>
            </div>
          </div>

          <!-- 2. Biaya terhadap RAB -->
          <div class="p-3 bg-light rounded border mb-4">
            <h6 class="fw-bold mb-3 text-dark d-flex align-items-center gap-2">
              <span class="preview-badge-code">C2</span>
              <span>Anggaran & Realisasi Biaya Proyek</span>
            </h6>
            <div class="row g-3">
              <div class="col-md-6">
                <label class="form-label small fw-bold text-muted">Nilai RAB Terkontrak (Referensi)</label>
                <div class="input-group input-group-sm">
                  <span class="input-group-text bg-white">Rp</span>
                  <input type="text" id="refNilaiRab" class="form-control bg-white mono-num" readonly value="<?= number_format((float)$penilaian['nilai_rab'], 0, ',', '.') ?>" data-raw="<?= (float)$penilaian['nilai_rab'] ?>">
                </div>
              </div>
              <div class="col-md-6">
                <label class="form-label small fw-bold">Biaya Realisasi Pengeluaran (Rp) <span class="text-danger">*</span></label>
                <div class="input-group input-group-sm">
                  <span class="input-group-text">Rp</span>
                  <input type="number" step="0.01" min="0" name="biaya_realisasi" id="inputBiayaRealisasi" class="form-control mono-num" required value="<?= old('biaya_realisasi', $penilaian['biaya_realisasi']) ?>">
                </div>
                <div class="form-text small" style="font-size:0.75rem;">Total biaya pengeluaran aktual yang telah dikeluarkan.</div>
              </div>
            </div>
          </div>

          <!-- 3. Dokumentasi Foto Progres Lapangan -->
          <div class="p-3 bg-light rounded border mb-4">
            <h6 class="fw-bold mb-3 text-dark d-flex align-items-center gap-2">
              <span class="preview-badge-code">C3</span>
              <span>Dokumentasi Foto Progres Lapangan</span>
            </h6>
            <div class="mb-2">
              <label class="form-label small fw-bold">Kelengkapan & Kerapihan Foto Progres Fisik <span class="text-danger">*</span></label>
              <select name="skor_foto_progres" id="inputSkorFoto" class="form-select" required>
                <option value="5" <?= ((int)old('skor_foto_progres', $penilaian['skor_foto_progres'] ?? 5) === 5) ? 'selected' : '' ?>>
                  Skor 5 - Sangat Lengkap & Rutin (setiap tahapan/zona terdokumentasi jelas & terarsip rapi)
                </option>
                <option value="4" <?= ((int)old('skor_foto_progres', $penilaian['skor_foto_progres'] ?? 5) === 4) ? 'selected' : '' ?>>
                  Skor 4 - Lengkap (foto pekerjaan utama rutin ada, catatan minor)
                </option>
                <option value="3" <?= ((int)old('skor_foto_progres', $penilaian['skor_foto_progres'] ?? 5) === 3) ? 'selected' : '' ?>>
                  Skor 3 - Cukup (hanya pekerjaan tertentu / area tertentu yang difoto)
                </option>
                <option value="2" <?= ((int)old('skor_foto_progres', $penilaian['skor_foto_progres'] ?? 5) === 2) ? 'selected' : '' ?>>
                  Skor 2 - Kurang (foto jarang / tidak teratur, hanya saat ada kendala)
                </option>
                <option value="1" <?= ((int)old('skor_foto_progres', $penilaian['skor_foto_progres'] ?? 5) === 1) ? 'selected' : '' ?>>
                  Skor 1 - Tidak Ada / Sangat Minim dokumentasi foto
                </option>
              </select>
            </div>
            <div class="form-text small" style="font-size:0.75rem;">
              Bukti opname fisik visual lapangan tanpa memerlukan dokumen rahasia kontrak/finansial kantor.
            </div>
          </div>

          <!-- 4. Ketepatan Serah Terima (Rubrik BAST) -->
          <div class="p-3 bg-light rounded border mb-4">
            <h6 class="fw-bold mb-3 text-dark d-flex align-items-center gap-2">
              <span class="preview-badge-code">C4</span>
              <span>Ketepatan Serah Terima (Rubrik BAST)</span>
            </h6>
            <div class="mb-2">
              <label class="form-label small fw-bold">Kondisi Berita Acara Serah Terima (BAST) <span class="text-danger">*</span></label>
              <select name="skor_bast" id="inputSkorBast" class="form-select" required>
                <option value="5" <?= ((int)old('skor_bast', $penilaian['skor_bast']) === 5) ? 'selected' : '' ?>>
                  Skor 5 - BAST lengkap, tepat waktu, tanpa catatan perbaikan
                </option>
                <option value="4" <?= ((int)old('skor_bast', $penilaian['skor_bast']) === 4) ? 'selected' : '' ?>>
                  Skor 4 - BAST lengkap, tepat waktu, ada catatan ringan
                </option>
                <option value="3" <?= ((int)old('skor_bast', $penilaian['skor_bast']) === 3) ? 'selected' : '' ?>>
                  Skor 3 - BAST ada, terlambat ringan
                </option>
                <option value="2" <?= ((int)old('skor_bast', $penilaian['skor_bast']) === 2) ? 'selected' : '' ?>>
                  Skor 2 - BAST ada, terlambat dan ada catatan perbaikan
                </option>
                <option value="1" <?= ((int)old('skor_bast', $penilaian['skor_bast']) === 1) ? 'selected' : '' ?>>
                  Skor 1 - BAST belum ada
                </option>
              </select>
            </div>
          </div>

          <!-- 5. Keterlambatan Waktu -->
          <div class="p-3 bg-light rounded border mb-4">
            <div class="d-flex align-items-center justify-content-between mb-3">
              <h6 class="fw-bold mb-0 text-dark d-flex align-items-center gap-2">
                <span class="preview-badge-code">C5</span>
                <span>Jadwal Penyelesaian & Keterlambatan</span>
              </h6>
              <div class="form-check form-switch m-0">
                <input class="form-check-input" type="checkbox" id="chkOnTime">
                <label class="form-check-label small fw-bold text-success" for="chkOnTime">
                  <i class="bi bi-check-circle-fill me-1"></i> Tepat Waktu (0 Hari)
                </label>
              </div>
            </div>
            <div class="row g-3">
              <div class="col-md-6">
                <label class="form-label small fw-bold text-muted">Tanggal Rencana Selesai (Kontrak)</label>
                <input type="date" id="refTglRencana" class="form-control bg-white mono-num form-control-sm" readonly value="<?= $penilaian['tanggal_selesai_rencana'] ?>">
              </div>
              <div class="col-md-6">
                <label class="form-label small fw-bold">Tanggal Selesai Aktual (Tanggal BAST) <span class="text-danger">*</span></label>
                <input type="date" name="tanggal_selesai_aktual" id="inputTglAktual" class="form-control form-control-sm mono-num" required value="<?= old('tanggal_selesai_aktual', $penilaian['tanggal_selesai_aktual']) ?>">
                <div class="form-text small" style="font-size:0.75rem;">Aktifkan toggle "Tepat Waktu" di atas jika proyek selesai sesuai jadwal rencana.</div>
              </div>
            </div>
          </div>

          <div class="d-flex justify-content-end gap-2 pt-3 border-top">
            <a href="<?= site_url('penilaian/' . $periode['id']) ?>" class="btn btn-outline-secondary">Batal</a>
            <button type="submit" class="btn btn-navy px-4">
              <i class="bi bi-save me-1"></i> Simpan Penilaian Proyek
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <!-- Kolom Kanan: Pratinjau Nilai Kriteria (Live Computation Preview) -->
  <div class="col-lg-4">
    <div class="preview-kriteria-box sticky-top" style="top: 85px;">
      <div class="d-flex align-items-center justify-content-between mb-3 border-bottom pb-2 border-secondary">
        <h6 class="fw-bold mb-0 text-white"><i class="bi bi-lightning-charge-fill text-warning me-2"></i>Pratinjau Nilai ($X_{ij}$)</h6>
        <span class="badge bg-warning text-dark font-monospace fw-bold">LIVE PREVIEW</span>
      </div>

      <p class="small text-white-50 mb-3">Nilai kriteria terhitung otomatis secara instan berdasarkan data mentah yang Anda input.</p>

      <div class="d-flex flex-column gap-3">
        <!-- Preview C1 -->
        <div class="preview-kriteria-item">
          <div class="d-flex align-items-center justify-content-between">
            <div>
              <span class="preview-badge-code me-1">C1</span>
              <span class="small fw-semibold">Capaian Progres</span>
            </div>
            <div class="fs-5 fw-bold mono-num text-warning" id="prevC1">
              <?= number_format((float)$preview['C1'], 2) ?>%
            </div>
          </div>
          <div class="text-white-50 small mt-1" style="font-size:0.72rem;" id="prevC1Sub">
            Formula: aktual / rencana &times; 100%
          </div>
        </div>

        <!-- Preview C2 -->
        <div class="preview-kriteria-item">
          <div class="d-flex align-items-center justify-content-between">
            <div>
              <span class="preview-badge-code me-1">C2</span>
              <span class="small fw-semibold">Biaya thd RAB</span>
            </div>
            <div class="fs-5 fw-bold mono-num text-warning" id="prevC2">
              <?= number_format((float)$preview['C2'], 2) ?>%
            </div>
          </div>
          <div class="text-white-50 small mt-1" style="font-size:0.72rem;" id="prevC2Sub">
            Formula: realisasi / RAB &times; 100%
          </div>
        </div>

        <!-- Preview C3 -->
        <div class="preview-kriteria-item">
          <div class="d-flex align-items-center justify-content-between">
            <div>
              <span class="preview-badge-code me-1">C3</span>
              <span class="small fw-semibold">Foto Progres</span>
            </div>
            <div class="fs-5 fw-bold mono-num text-warning" id="prevC3">
              Skor <?= $preview['C3'] ?>
            </div>
          </div>
          <div class="text-white-50 small mt-1" style="font-size:0.72rem;" id="prevC3Sub">
            Skor rubrik foto fisik (1 - 5)
          </div>
        </div>

        <!-- Preview C4 -->
        <div class="preview-kriteria-item">
          <div class="d-flex align-items-center justify-content-between">
            <div>
              <span class="preview-badge-code me-1">C4</span>
              <span class="small fw-semibold">Serah Terima BAST</span>
            </div>
            <div class="fs-5 fw-bold mono-num text-warning" id="prevC4">
              Skor <?= $preview['C4'] ?>
            </div>
          </div>
          <div class="text-white-50 small mt-1" style="font-size:0.72rem;">
            Skor rubrik BAST (1 - 5)
          </div>
        </div>

        <!-- Preview C5 -->
        <div class="preview-kriteria-item">
          <div class="d-flex align-items-center justify-content-between">
            <div>
              <span class="preview-badge-code me-1">C5</span>
              <span class="small fw-semibold">Keterlambatan</span>
            </div>
            <div class="fs-5 fw-bold mono-num text-warning" id="prevC5">
              <?= $preview['C5'] ?> Hari
            </div>
          </div>
          <div class="text-white-50 small mt-1" style="font-size:0.72rem;" id="prevC5Sub">
            max(0, tgl aktual - rencana)
          </div>
        </div>
      </div>

      <div class="mt-4 p-2 bg-dark rounded border border-secondary text-white-50 small" style="font-size:0.75rem;">
        <i class="bi bi-info-circle me-1 text-warning"></i> Nilai-nilai di atas akan dikalkulasikan secara otomatis saat Anda menekan tombol <strong>Hitung SAW</strong> pada periode evaluasi.
      </div>
    </div>
  </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
  function updateLivePreview() {
    // 1. C1: Progres
    const pRencana = parseFloat(document.getElementById('inputProgresRencana').value) || 100;
    const pAktual  = parseFloat(document.getElementById('inputProgresAktual').value) || 0;
    const c1 = (pRencana > 0) ? ((pAktual / pRencana) * 100) : 0;
    document.getElementById('prevC1').innerText = c1.toFixed(2) + '%';
    document.getElementById('prevC1Sub').innerText = `${pAktual}% / ${pRencana}% = ${c1.toFixed(2)}%`;

    // 2. C2: Biaya vs RAB
    const rab = parseFloat(document.getElementById('refNilaiRab').getAttribute('data-raw')) || 1;
    const realisasi = parseFloat(document.getElementById('inputBiayaRealisasi').value) || 0;
    const c2 = (rab > 0) ? ((realisasi / rab) * 100) : 0;
    document.getElementById('prevC2').innerText = c2.toFixed(2) + '%';
    document.getElementById('prevC2Sub').innerText = `Rp ${realisasi.toLocaleString('id-ID')} / Rp ${rab.toLocaleString('id-ID')}`;

    // 3. C3: Dokumentasi Foto Progres Lapangan
    const c3 = parseInt(document.getElementById('inputSkorFoto').value) || 1;
    document.getElementById('prevC3').innerText = 'Skor ' + c3;
    document.getElementById('prevC3Sub').innerText = `Rubrik Foto Progres: Skor ${c3} / 5`;

    // 4. C4: BAST
    const c4 = parseInt(document.getElementById('inputSkorBast').value) || 1;
    document.getElementById('prevC4').innerText = 'Skor ' + c4;

    // 5. C5: Keterlambatan
    const tglRencanaStr = document.getElementById('refTglRencana').value;
    const tglAktualStr  = document.getElementById('inputTglAktual').value;
    let c5 = 0;
    if (tglRencanaStr && tglAktualStr) {
      const dtR = new Date(tglRencanaStr);
      const dtA = new Date(tglAktualStr);
      const diffTime = dtA - dtR;
      const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
      c5 = Math.max(0, diffDays);
    }
    document.getElementById('prevC5').innerText = c5 + ' Hari';
    document.getElementById('prevC5Sub').innerText = (c5 === 0) ? 'Tepat waktu / lebih awal' : `Terlambat ${c5} hari kalender`;
  }

  // Handle On-Time Checkbox toggle
  const chkOnTime = document.getElementById('chkOnTime');
  const inputTglAktual = document.getElementById('inputTglAktual');
  const refTglRencana = document.getElementById('refTglRencana');

  if (chkOnTime && inputTglAktual && refTglRencana) {
    if (inputTglAktual.value === refTglRencana.value || !inputTglAktual.value) {
      chkOnTime.checked = true;
    }

    chkOnTime.addEventListener('change', function() {
      if (this.checked) {
        inputTglAktual.value = refTglRencana.value;
      }
      updateLivePreview();
    });

    inputTglAktual.addEventListener('change', function() {
      if (this.value !== refTglRencana.value) {
        chkOnTime.checked = false;
      } else {
        chkOnTime.checked = true;
      }
    });
  }

  // Attach event listeners
  const formFields = [
    'inputProgresRencana', 'inputProgresAktual',
    'inputBiayaRealisasi',
    'inputSkorFoto',
    'inputSkorBast',
    'inputTglAktual'
  ];

  formFields.forEach(id => {
    const el = document.getElementById(id);
    if (el) {
      el.addEventListener('input', updateLivePreview);
      el.addEventListener('change', updateLivePreview);
    }
  });

  updateLivePreview();
</script>
<?= $this->endSection() ?>
