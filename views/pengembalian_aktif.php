<?php
// Tabel buku yang sedang dipinjam
?>
<div class="card">
  <div class="card-header">
    <div class="card-title"><?= bi('book', 18); ?> Buku yang Sedang Dipinjam</div>
    <span class="text-muted-sm">Total: <?= count($pinjam); ?> Buku Aktif</span>
  </div>

  <div class="filter-bar">
    <div class="search-input-wrapper">
      <input type="text" id="tableSearch" class="form-control"
             placeholder="Cari judul buku, nama siswa, kode transaksi...">
    </div>
  </div>

  <div class="table-responsive">
    <table class="live-table">
      <thead>
        <tr>
          <th>No</th>
          <th>Kode Transaksi</th>
          <?php if ($role === 'admin'): ?><th>Nama Siswa (Kelas)</th><?php endif; ?>
          <th>Judul Buku</th>
          <th>Tgl Pinjam</th>
          <th>Jatuh Tempo</th>
          <th>Status Keterlambatan</th>
          <th style="text-align: center;">Aksi</th>
        </tr>
      </thead>
      <tbody>
        <?php if (!$pinjam): ?>
          <?php baris_kosong($role === 'admin' ? 8 : 7, 'Tidak ada buku yang sedang dipinjam saat ini.'); ?>
        <?php else: $no = 1; foreach ($pinjam as $row): ?>
          <?php [$hari, $denda] = hitung_denda($row['tgl_jatuh_tempo']); ?>
          <tr>
            <td><?= $no++; ?></td>
            <td><code><?= e($row['kode_transaksi']); ?></code></td>
            <?php if ($role === 'admin'): ?>
              <td>
                <strong><?= e($row['nama_lengkap']); ?></strong><br>
                <small class="text-muted">
                  <?= e($row['nis_nip']); ?> - <?= e($row['kelas'] ?? '-'); ?>
                </small>
              </td>
            <?php endif; ?>
            <td>
              <strong><?= e($row['judul']); ?></strong><br>
              <small class="text-muted">
                Kode: <?= e($row['kode_buku']); ?> | Rak: <?= e($row['lokasi_rak']); ?>
              </small>
            </td>
            <td><?= tgl($row['tgl_pinjam']); ?></td>
            <td><strong><?= tgl($row['tgl_jatuh_tempo']); ?></strong></td>
            <td>
              <?php if ($hari > 0): ?>
                <span class="badge badge-ditolak">
                  <?= bi('exclamation', 12); ?> Telat <?= $hari; ?> Hari (<?= rp($denda); ?>)
                </span>
              <?php else: ?>
                <span class="badge badge-dikembalikan">Tepat Waktu</span>
              <?php endif; ?>
            </td>
            <td class="td-aksi">
              <a href="pengembalian.php?id=<?= $row['id_transaksi']; ?>" class="btn btn-warning btn-sm"
                 data-confirm="Proses pengembalian buku ini?">
                <?= bi('upload', 12); ?> Kembalikan Buku
              </a>
            </td>
          </tr>
        <?php endforeach; endif; ?>
      </tbody>
    </table>
  </div>
</div>
