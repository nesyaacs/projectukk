<?php
// Tabel daftar buku (admin & siswa)
?>
<div class="card">
  <div class="card-header">
    <div class="card-title"><?= bi('journal', 18); ?> Daftar Buku Perpustakaan</div>
    <span class="text-muted-sm">Total: <?= count($daftar); ?> Judul Buku</span>
  </div>

  <div class="filter-bar">
    <div class="search-input-wrapper">
      <input type="text" id="tableSearch" class="form-control"
             placeholder="Ketik untuk mencari judul, kode, pengarang, penerbit...">
    </div>
  </div>

  <div class="table-responsive">
    <table class="live-table">
      <thead>
        <tr>
          <th>No</th>
          <th style="width: 55px; text-align: center;">Cover</th>
          <th>Kode</th>
          <th>Judul Buku</th>
          <th>Kategori</th>
          <th>Pengarang & Penerbit</th>
          <th>Tahun</th>
          <th>Rak</th>
          <th>Stok (Sisa)</th>
          <th style="text-align: center;">Aksi</th>
        </tr>
      </thead>
      <tbody>
        <?php if (!$daftar): ?>
          <?php baris_kosong(10, 'Belum ada data buku yang tersimpan.'); ?>
        <?php else: $no = 1; foreach ($daftar as $b): ?>
          <tr>
            <td><?= $no++; ?></td>
            <td style="text-align: center;">
              <img src="assets/uploads/<?= !empty($b['gambar']) ? e($b['gambar']) : 'default-book.svg'; ?>"
                   alt="Cover"
                   style="width: 40px; height: 54px; object-fit: cover; border-radius: 4px; border: 1px solid var(--border); box-shadow: var(--shadow-sm);"
                   onerror="this.src='assets/uploads/default-book.svg';">
            </td>
            <td><code><?= e($b['kode_buku']); ?></code></td>
            <td>
              <strong><?= e($b['judul']); ?></strong>
              <?php if ($b['isbn']): ?>
                <br><small class="text-muted">ISBN: <?= e($b['isbn']); ?></small>
              <?php endif; ?>
            </td>
            <td><span class="badge badge-menunggu"><?= e($b['nama_kategori'] ?? 'Umum'); ?></span></td>
            <td>
              <?= e($b['pengarang']); ?><br>
              <small class="text-muted">Penerbit: <?= e($b['penerbit']); ?></small>
            </td>
            <td><?= $b['tahun_terbit']; ?></td>
            <td><strong><?= e($b['lokasi_rak']); ?></strong></td>
            <td>
              <span class="badge <?= $b['sisa_buku'] > 0 ? 'badge-dikembalikan' : 'badge-ditolak'; ?>">
                <?= $b['sisa_buku']; ?> / <?= $b['jumlah_buku']; ?>
              </span>
            </td>
            <td class="td-aksi">
              <?php if ($role === 'admin'): ?>
                <a href="buku.php?aksi=edit&id=<?= $b['id_buku']; ?>" class="btn btn-warning btn-sm">
                  <?= bi('pencil', 12); ?> Edit
                </a>
                <a href="buku.php?aksi=hapus&id=<?= $b['id_buku']; ?>" class="btn btn-danger btn-sm"
                   data-confirm="Hapus buku ini?">
                  <?= bi('trash', 12); ?> Hapus
                </a>
              <?php elseif ($b['sisa_buku'] > 0): ?>
                <a href="pinjam.php?id_buku=<?= $b['id_buku']; ?>" class="btn btn-primary btn-sm">
                  <?= bi('download', 12); ?> Pinjam
                </a>
              <?php else: ?>
                <button class="btn btn-outline btn-sm" disabled>Habis</button>
              <?php endif; ?>
            </td>
          </tr>
        <?php endforeach; endif; ?>
      </tbody>
    </table>
  </div>
</div>
