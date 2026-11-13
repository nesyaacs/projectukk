<?php
// Tampilan beranda + katalog buku
$aksi = '';
if (!$login) {
    $aksi .= '<a href="login.php" class="btn btn-primary">' . bi('box-arrow-in-right', 15) . ' Masuk / Login</a>';
    $aksi .= '<a href="daftar.php" class="btn btn-outline">' . bi('card-checklist', 15) . ' Daftar Anggota Siswa</a>';
} else {
    $aksi .= '<a href="dashboard.php" class="btn btn-primary">' . bi('speedometer', 15) . ' Buka Dashboard Saya</a>';
    if ($level === 'siswa') {
        $aksi .= '<a href="pinjam.php" class="btn btn-outline">' . bi('download', 15) . ' Ajukan Pinjam Buku</a>';
    }
}

hero('book', 'Selamat Datang di Perpustakaan Digital Sekolah',
    'Temukan buku pelajaran, sains, sastra, dan referensi lainnya dengan mudah dan cepat.', $aksi);

kartu_statistik($stat);
?>

<div class="card">
  <div class="card-header">
    <div class="card-title"><?= bi('journal', 18); ?> Koleksi Buku Perpustakaan</div>
    <span class="text-muted-sm">Tersedia untuk seluruh warga sekolah</span>
  </div>

  <div class="filter-bar">
    <div class="search-input-wrapper">
      <input type="text" id="bookCatalogSearch" class="form-control"
             placeholder="Cari judul, pengarang, penerbit, atau kategori...">
    </div>
  </div>

  <div class="book-grid">
    <?php if (!$daftar_buku): ?>
      <p class="book-empty">Belum ada koleksi buku yang ditambahkan.</p>
    <?php else: foreach ($daftar_buku as $buku): ?>
      <div class="book-card">
        <span class="book-badge"><?= e($buku['lokasi_rak']); ?></span>
        <div class="book-cover">
          <img src="assets/uploads/<?= !empty($buku['gambar']) ? e($buku['gambar']) : 'default-book.svg'; ?>"
               alt="<?= e($buku['judul']); ?>" class="book-cover-img"
               onerror="this.src='assets/uploads/default-book.svg';">
        </div>
        <div class="book-body">
          <span class="book-category"><?= e($buku['nama_kategori'] ?? 'Umum'); ?></span>
          <h4 class="book-title"><?= e($buku['judul']); ?></h4>
          <div class="book-meta">
            Penulis: <?= e($buku['pengarang']); ?><br>
            Penerbit: <?= e($buku['penerbit']); ?> (<?= $buku['tahun_terbit']; ?>)
          </div>
          <div class="book-footer">
            <span class="book-stock">
              <?= $buku['sisa_buku'] > 0 ? 'Tersedia: ' . $buku['sisa_buku'] : 'Stok Habis'; ?>
            </span>
            <?php if ($login && $level === 'siswa'): ?>
              <?php if ($buku['sisa_buku'] > 0): ?>
                <a href="pinjam.php?id_buku=<?= $buku['id_buku']; ?>" class="btn btn-primary btn-sm">
                  <?= bi('download', 13); ?> Pinjam
                </a>
              <?php else: ?>
                <button class="btn btn-outline btn-sm" disabled>Habis</button>
              <?php endif; ?>
            <?php elseif (!$login): ?>
              <a href="login.php" class="btn btn-outline btn-sm">
                <?= bi('box-arrow-in-right', 13); ?> Login
              </a>
            <?php endif; ?>
          </div>
        </div>
      </div>
    <?php endforeach; endif; ?>
  </div>
</div>
