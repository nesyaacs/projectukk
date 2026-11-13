<?php
// Layout: header otomatis saat di-include + footer lewat tampil_bawah()
require_once __DIR__ . '/../config/koneksi.php';

$halaman = basename($_SERVER['PHP_SELF']);
$login   = isset($_SESSION['id_user']);
$level   = $_SESSION['level'] ?? '';
$nama    = $_SESSION['nama_lengkap'] ?? '';

// Menu berbeda untuk tamu, admin, dan siswa
if (!$login) {
    $menu = [
        ['index.php', 'house', 'Beranda'],
        ['login.php', 'box-arrow-in-right', 'Masuk (Login)'],
        ['daftar.php', 'card-checklist', 'Daftar Anggota'],
    ];
} elseif ($level === 'admin') {
    $menu = [
        ['dashboard.php', 'speedometer', 'Dashboard'],
        ['buku.php', 'book', 'Kelola Data Buku'],
        ['anggota.php', 'people', 'Kelola Anggota'],
        ['transaksi.php', 'arrow-repeat', 'Transaksi'],
        ['laporan.php', 'printer', 'Laporan'],
    ];
} else {
    $menu = [
        ['dashboard.php', 'speedometer', 'Dashboard'],
        ['buku.php', 'journal', 'Katalog Buku'],
        ['pinjam.php', 'download', 'Peminjaman Buku'],
        ['pengembalian.php', 'upload', 'Pengembalian'],
    ];
}

// Footer halaman
function tampil_bawah() {
    ?>
</main>

<footer class="footer">
  <div class="footer-inner">
    <div>
      <strong><?= bi('book', 16); ?> Perpustakaan Digital</strong>
      &copy; <?= date('Y'); ?> - Sistem Informasi Peminjaman Buku Sekolah
    </div>
    <div class="footer-credit">
      UKK Rekayasa Perangkat Lunak (Paket 4) | Nesya XII RPL 1
    </div>
  </div>
</footer>

<script src="assets/js/script.js"></script>
</body>
</html>
    <?php
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= isset($page_title) ? e($page_title) . ' - Perpustakaan Digital' : 'Perpustakaan Digital Sekolah'; ?></title>
  <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

<header class="navbar">
  <a href="index.php" class="brand">
    <div class="brand-icon"><?= bi('book', 20); ?></div>
    <div class="brand-text">
      <h1>Perpustakaan Digital</h1>
      <p>SMK Negeri 3 Kendal</p>
    </div>
  </a>

  <button class="nav-toggle" id="navToggle" aria-label="Toggle Menu">&#9776;</button>

  <nav>
    <ul class="nav-menu" id="navMenu">
      <?php foreach ($menu as [$url, $ikon, $label]): ?>
        <li>
          <a href="<?= $url; ?>" class="nav-link <?= $halaman === $url ? 'active' : ''; ?>">
            <?= bi($ikon, 16); ?> <?= $label; ?>
          </a>
        </li>
      <?php endforeach; ?>

      <?php if ($login): ?>
        <li class="nav-user">
          <span><?= bi('person', 15); ?> <?= $level === 'admin' ? 'Admin' : 'Siswa'; ?>:
            <strong><?= e($nama); ?></strong></span>
        </li>
        <li>
          <a href="logout.php" class="nav-link btn-danger btn-sm"
             data-confirm="Keluar dari sistem?">
            <?= bi('box-arrow-right', 14); ?> Logout
          </a>
        </li>
      <?php endif; ?>
    </ul>
  </nav>
</header>

<main class="main-wrapper">
