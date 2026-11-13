<?php
// Tabel seluruh transaksi + filter status
?>
<div class="card">
  <div class="card-header">
    <div class="card-title"><?= bi('journal'); ?> Seluruh Data Transaksi Perpustakaan</div>
    <span class="text-muted-sm">Total: <?= count($daftar); ?> Transaksi</span>
  </div>

  <div class="filter-bar">
    <div class="search-input-wrapper">
      <input type="text" id="tableSearch" class="form-control"
             placeholder="Cari kode transaksi, nama siswa, NIS, judul buku...">
    </div>
    <div style="display: flex; gap: 8px; flex-wrap: wrap;">
      <a href="transaksi.php" class="btn btn-sm <?= !$status ? 'btn-primary' : 'btn-outline'; ?>">Semua</a>
      <a href="transaksi.php?status=menunggu" class="btn btn-sm <?= $status === 'menunggu' ? 'btn-primary' : 'btn-outline'; ?>">Menunggu Persetujuan</a>
      <a href="transaksi.php?status=dipinjam" class="btn btn-sm <?= $status === 'dipinjam' ? 'btn-primary' : 'btn-outline'; ?>">Sedang Dipinjam</a>
      <a href="transaksi.php?status=dikembalikan" class="btn btn-sm <?= $status === 'dikembalikan' ? 'btn-primary' : 'btn-outline'; ?>">Sudah Kembali</a>
      <a href="transaksi.php?status=ditolak" class="btn btn-sm <?= $status === 'ditolak' ? 'btn-primary' : 'btn-outline'; ?>">Ditolak</a>
    </div>
  </div>

  <div class="table-responsive">
    <table class="live-table">
      <thead>
        <tr>
          <th>No</th>
          <th>Kode Transaksi</th>
          <th>Siswa Peminjam</th>
          <th>Buku</th>
          <th>Tgl Pinjam</th>
          <th>Jatuh Tempo</th>
          <th>Tgl Kembali</th>
          <th>Denda</th>
          <th>Status</th>
          <th style="text-align: center;">Aksi Admin</th>
        </tr>
      </thead>
      <tbody>
        <?php if (!$daftar): ?>
          <?php baris_kosong(10, 'Belum ada data transaksi yang sesuai filter.'); ?>
        <?php else: $no = 1; foreach ($daftar as $trx): ?>
          <?php $telat = $trx['status'] === 'dipinjam' && date('Y-m-d') > $trx['tgl_jatuh_tempo']; ?>
          <tr>
            <td><?= $no++; ?></td>
            <td><code><?= e($trx['kode_transaksi']); ?></code></td>
            <td>
              <strong><?= e($trx['nama_lengkap']); ?></strong><br>
              <small class="text-muted">
                <?= e($trx['nis_nip']); ?> (<?= e($trx['kelas'] ?? '-'); ?>)
              </small>
            </td>
            <td>
              <strong><?= e($trx['judul']); ?></strong><br>
              <small class="text-muted"><?= e($trx['kode_buku']); ?></small>
            </td>
            <td><?= tgl($trx['tgl_pinjam']); ?></td>
            <td>
              <?= tgl($trx['tgl_jatuh_tempo']); ?>
              <?php if ($telat): ?>
                <br><span style="color: var(--danger); font-size: 0.72rem; font-weight: bold;">
                  <?= bi('exclamation', 12); ?> Lewat Waktu!
                </span>
              <?php endif; ?>
            </td>
            <td><?= tgl($trx['tgl_kembali']); ?></td>
            <td>
              <?= $trx['denda'] > 0
                  ? '<strong style="color:var(--danger);">' . rp($trx['denda']) . '</strong>'
                  : 'Rp 0'; ?>
            </td>
            <td><?php badge($trx['status']); ?></td>
            <td class="td-aksi">
              <?php if ($trx['status'] === 'menunggu'): ?>
                <a href="transaksi.php?aksi=setujui&id=<?= $trx['id_transaksi']; ?>" class="btn btn-primary btn-sm"
                   data-confirm="Setujui permohonan peminjaman buku ini?" title="Setujui Peminjaman">
                  <?= bi('check', 13); ?> Setujui
                </a>
                <a href="transaksi.php?aksi=tolak&id=<?= $trx['id_transaksi']; ?>" class="btn btn-danger btn-sm"
                   data-confirm="Tolak permohonan peminjaman buku ini? Stok buku akan dikembalikan." title="Tolak Peminjaman">
                  <?= bi('x', 13); ?> Tolak
                </a>
              <?php elseif ($trx['status'] === 'dipinjam'): ?>
                <a href="pengembalian.php?id=<?= $trx['id_transaksi']; ?>" class="btn btn-warning btn-sm"
                   data-confirm="Proses pengembalian buku ini?" title="Kembalikan Buku">
                  <?= bi('upload', 13); ?> Kembali
                </a>
                <a href="transaksi.php?aksi=perpanjang&id=<?= $trx['id_transaksi']; ?>" class="btn btn-outline btn-sm"
                   data-confirm="Perpanjang masa pinjam 7 hari?" title="Perpanjang 7 Hari">
                  <?= bi('plus', 13); ?> 7 Hari
                </a>
                <a href="transaksi.php?aksi=tolak&id=<?= $trx['id_transaksi']; ?>" class="btn btn-outline btn-sm"
                   style="color: var(--danger); border-color: var(--danger);"
                   data-confirm="Tolak / batalkan peminjaman buku ini? Stok buku akan dikembalikan." title="Tolak / Batalkan Peminjaman">
                  <?= bi('x', 13); ?> Tolak
                </a>
              <?php endif; ?>
              <a href="transaksi.php?aksi=hapus&id=<?= $trx['id_transaksi']; ?>" class="btn btn-danger btn-sm"
                 data-confirm="Hapus transaksi ini?" title="Hapus Data">
                <?= bi('trash', 13); ?>
              </a>
            </td>
          </tr>
        <?php endforeach; endif; ?>
      </tbody>
    </table>
  </div>
</div>
