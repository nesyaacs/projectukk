<?php
// Tampilan dashboard admin
$aksi = '<a href="buku.php" class="btn btn-primary">' . bi('book', 15) . ' Kelola Data Buku</a>'
      . '<a href="anggota.php" class="btn btn-outline">' . bi('people', 15) . ' Kelola Anggota Siswa</a>'
      . '<a href="transaksi.php" class="btn btn-primary">' . bi('arrow-repeat', 15) . ' Kelola Transaksi</a>'
      . '<a href="laporan.php" class="btn btn-outline">' . bi('printer', 15) . ' Cetak Rekap Laporan</a>';

hero('speedometer', 'Selamat Datang, ' . e($_SESSION['nama_lengkap']) . ' (Admin)',
    'Kelola katalog buku, keanggotaan siswa, serta pemantauan sirkulasi peminjaman secara real-time.', $aksi);

kartu_statistik($stat);
?>

<div class="card">
  <div class="card-header">
    <div class="card-title"><?= bi('arrow-repeat', 18); ?> 5 Transaksi Peminjaman Terkini</div>
    <a href="transaksi.php" class="btn btn-outline btn-sm">Lihat Semua &rarr;</a>
  </div>

  <div class="table-responsive">
    <table>
      <thead>
        <tr>
          <th>Kode Transaksi</th>
          <th>Nama Siswa</th>
          <th>Kelas</th>
          <th>Judul Buku</th>
          <th>Tgl Pinjam</th>
          <th>Jatuh Tempo</th>
          <th>Status</th>
        </tr>
      </thead>
      <tbody>
        <?php if (!$terbaru): ?>
          <?php baris_kosong(7, 'Belum ada transaksi peminjaman.', 'td-kosong-sm'); ?>
        <?php else: foreach ($terbaru as $row): ?>
          <tr>
            <td><strong><?= e($row['kode_transaksi']); ?></strong></td>
            <td><?= e($row['nama_lengkap']); ?></td>
            <td><?= e($row['kelas'] ?? '-'); ?></td>
            <td><?= e($row['judul']); ?></td>
            <td><?= tgl($row['tgl_pinjam']); ?></td>
            <td><?= tgl($row['tgl_jatuh_tempo']); ?></td>
            <td><?php badge($row['status']); ?></td>
          </tr>
        <?php endforeach; endif; ?>
      </tbody>
    </table>
  </div>
</div>
