<?php
// Filter laporan
$pilihan_status = [
    '' => '-- Semua Status --',
    'dipinjam' => 'Sedang Dipinjam',
    'dikembalikan' => 'Sudah Dikembalikan',
    'menunggu' => 'Menunggu Persetujuan',
    'ditolak' => 'Ditolak',
];
?>
<div class="card no-print">
  <div class="card-header">
    <div class="card-title"><?= bi('search'); ?> Filter Laporan Peminjaman</div>
    <button type="button" class="btn btn-primary btn-sm" data-print>
      <?= bi('printer'); ?> Cetak / Print Laporan
    </button>
  </div>

  <form action="laporan.php" method="GET">
    <div class="form-row">
      <?php
      input_form('Tanggal Awal', 'tgl_awal', $awal, ['tipe' => 'date']);
      input_form('Tanggal Akhir', 'tgl_akhir', $akhir, ['tipe' => 'date']);
      select_form('Status Peminjaman', 'status', $pilihan_status, $status);
      ?>
    </div>
    <div style="display: flex; gap: 10px; align-items: center; flex-wrap: wrap;">
      <button type="submit" class="btn btn-primary"><?= bi('search'); ?> Terapkan Filter</button>
      <a href="laporan.php" class="btn btn-outline">Reset Filter</a>
      <span style="font-size: 0.8rem; color: var(--text-muted); margin-left: auto;">
        * Tips Cetak: Gunakan orientasi <strong>Landscape</strong> agar tabel tidak terpotong.
      </span>
    </div>
  </form>
</div>
