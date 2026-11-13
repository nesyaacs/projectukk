<?php
// Tampilan dashboard siswa
$aksi = '<a href="pinjam.php" class="btn btn-primary">' . bi('download', 14) . ' Ajukan Pinjam Buku</a>'
      . '<a href="buku.php" class="btn btn-outline">' . bi('journal', 14) . ' Lihat Katalog Buku</a>'
      . '<a href="pengembalian.php" class="btn btn-outline">' . bi('upload', 14) . ' Kembalikan Buku</a>';

hero('person', 'Halo, ' . e($_SESSION['nama_lengkap']),
    'Anda login sebagai siswa kelas <strong>' . e($_SESSION['kelas'] ?? '-') . '</strong>. '
    . 'Silakan cari buku favoritmu atau kelola buku yang sedang kamu pinjam.', $aksi);

kartu_statistik($stat);
?>

<div class="card">
  <div class="card-header">
    <div class="card-title"><?= bi('book', 18); ?> Buku yang Sedang Anda Pinjam</div>
    <a href="pengembalian.php" class="btn btn-outline btn-sm">Menu Pengembalian &rarr;</a>
  </div>

  <div class="table-responsive">
    <table>
      <thead>
        <tr>
          <th>Kode Pinjam</th>
          <th>Kode Buku</th>
          <th>Judul Buku</th>
          <th>Tgl Pinjam</th>
          <th>Jatuh Tempo</th>
          <th>Status</th>
          <th>Aksi</th>
        </tr>
      </thead>
      <tbody>
        <?php if (!$dipinjam): ?>
          <?php baris_kosong(7, 'Tidak ada buku yang sedang Anda pinjam. Silakan kunjungi '
              . '<a href="pinjam.php" style="color: var(--primary-dark); font-weight: bold;">Katalog Buku</a>'
              . ' untuk meminjam buku.'); ?>
        <?php else: foreach ($dipinjam as $row): ?>
          <?php [$hari, $denda] = hitung_denda($row['tgl_jatuh_tempo']); ?>
          <tr>
            <td><strong><?= e($row['kode_transaksi']); ?></strong></td>
            <td><?= e($row['kode_buku']); ?></td>
            <td>
              <strong><?= e($row['judul']); ?></strong><br>
              <small class="text-muted">
                Penulis: <?= e($row['pengarang']); ?> | Rak: <?= e($row['lokasi_rak']); ?>
              </small>
            </td>
            <td><?= tgl($row['tgl_pinjam']); ?></td>
            <td>
              <?= tgl($row['tgl_jatuh_tempo']); ?>
              <?php if ($hari > 0): ?>
                <br><span style="color: var(--danger); font-size: 0.75rem; font-weight: bold;">
                  <?= bi('exclamation', 12); ?> Terlambat
                </span>
              <?php endif; ?>
            </td>
            <td><?php badge($row['status']); ?></td>
            <td>
              <?php if ($row['status'] === 'dipinjam'): ?>
                <a href="pengembalian.php?id=<?= $row['id_transaksi']; ?>" class="btn btn-warning btn-sm"
                   data-confirm="Kembalikan buku ini sekarang?">
                  <?= bi('upload', 12); ?> Kembalikan
                </a>
              <?php elseif ($row['status'] === 'menunggu'): ?>
                <span style="font-size: 0.78rem; color: var(--text-muted); font-style: italic;">
                  Menunggu Konfirmasi Admin
                </span>
              <?php else: ?>
                <span style="font-size: 0.78rem; color: var(--danger); font-style: italic;">
                  Permohonan Ditolak
                </span>
              <?php endif; ?>
            </td>
          </tr>
        <?php endforeach; endif; ?>
      </tbody>
    </table>
  </div>
</div>
