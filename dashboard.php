<?php
// Dashboard admin & siswa
require_once __DIR__ . '/config/koneksi.php';
cek_login();

$level   = $_SESSION['level'];
$user_id = $_SESSION['id_user'];

if ($level === 'admin') {
    $stat = [
        ['book', nilai("SELECT COUNT(*) FROM buku"), 'Judul Buku (' . nilai("SELECT SUM(jumlah_buku) FROM buku") . ' Unit)'],
        ['people', nilai("SELECT COUNT(*) FROM users WHERE level='siswa'"), 'Siswa Terdaftar'],
        ['arrow-repeat', nilai("SELECT COUNT(*) FROM transaksi WHERE status='dipinjam'"), 'Sedang Dipinjam'],
        ['card-checklist', nilai("SELECT COUNT(*) FROM transaksi WHERE status='menunggu'"), 'Menunggu Persetujuan'],
    ];

    $terbaru = semua("SELECT t.*, u.nama_lengkap, u.kelas, b.judul
                      FROM transaksi t
                      JOIN users u ON t.id_user = u.id_user
                      JOIN buku b ON t.id_buku = b.id_buku
                      ORDER BY t.id_transaksi DESC LIMIT 5");
} else {
    $stat = [
        ['book', nilai("SELECT COUNT(*) FROM transaksi WHERE id_user=$user_id AND status='dipinjam'"), 'Buku Sedang Dipinjam'],
        ['journal', nilai("SELECT COUNT(*) FROM transaksi WHERE id_user=$user_id"), 'Total Riwayat Pinjam'],
        ['check', nilai("SELECT COUNT(*) FROM transaksi WHERE id_user=$user_id AND status='dikembalikan'"), 'Buku Telah Kembali'],
    ];

    $dipinjam = semua("SELECT t.*, b.judul, b.pengarang, b.kode_buku, b.lokasi_rak
                       FROM transaksi t
                       JOIN buku b ON t.id_buku = b.id_buku
                       WHERE t.id_user = $user_id AND t.status IN ('dipinjam', 'menunggu', 'ditolak')
                       ORDER BY t.id_transaksi DESC");
}

$page_title = $level === 'admin' ? "Dashboard Admin Perpustakaan" : "Dashboard Siswa";
require_once __DIR__ . '/includes/layout.php';

require __DIR__ . '/views/' . ($level === 'admin' ? 'dashboard_admin.php' : 'dashboard_siswa.php');
tampil_bawah();
