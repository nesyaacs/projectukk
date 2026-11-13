<?php
// Tabel riwayat pengembalian terakhir
?>
<div class="card">
  <div class="card-header">
    <div class="card-title"><?= bi('journal', 18); ?> Riwayat Pengembalian Terakhir</div>
    <span class="text-muted-sm">10 Riwayat Terakhir</span>
  </div>

  <div class="table-responsive">
    <table>
      <thead>
        <tr>
          <th>Kode Transaksi</th>
          <?php if ($role === 'admin'): ?><th>Nama Siswa</th><?php endif; ?>
          <th>Judul Buku</th>
          <th>Tgl Pinjam</th>
          <th>Tgl Dikembalikan</th>
          <th>Denda</th>
          <th>Status</th>
        </tr>
      </thead>
      <tbody>
        <?php if (!$riwayat): ?>
          <?php baris_kosong($role === 'admin' ? 7 : 6, 'Belum ada riwayat pengembalian buku.', 'td-kosong-sm'); ?>
        <?php else: foreach ($riwayat as $r): ?>
          <tr>
            <td><code><?= e($r['kode_transaksi']); ?></code></td>
            <?php if ($role === 'admin'): ?><td><?= e($r['nama_lengkap']); ?></td><?php endif; ?>
            <td><?= e($r['judul']); ?></td>
            <td><?= tgl($r['tgl_pinjam']); ?></td>
            <td><?= tgl($r['tgl_kembali']); ?></td>
            <td>
              <?= $r['denda'] > 0
                  ? '<strong style="color:var(--danger);">' . rp($r['denda']) . '</strong>'
                  : 'Rp 0'; ?>
            </td>
            <td><span class="badge badge-dikembalikan">Dikembalikan</span></td>
          </tr>
        <?php endforeach; endif; ?>
      </tbody>
    </table>
  </div>
</div>
