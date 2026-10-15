<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>
<div class="card card-modern text-center py-5">
  <div class="card-body">
    <i class="bi bi-bar-chart-line fs-1 text-secondary mb-3 d-block"></i>
    <h4 class="fw-bold text-dark mb-2">Belum Ada Hasil Penilaian</h4>
    <p class="text-muted small mb-4"><?= esc($message ?? 'Silakan buat periode penilaian dan jalankan perhitungan SAW terlebih dahulu.') ?></p>
    <?php if (session()->get('user_role') === 'admin'): ?>
      <a href="<?= site_url('periode') ?>" class="btn btn-navy px-4">
        <i class="bi bi-calendar-plus me-1"></i> Buka Menu Periode Penilaian
      </a>
    <?php endif; ?>
  </div>
</div>
<?= $this->endSection() ?>
