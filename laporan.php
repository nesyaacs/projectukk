<?php
// Laporan sirkulasi + cetak (khusus admin)
require_once __DIR__ . '/config/koneksi.php';
cek_login('admin');

$awal   = esc($_GET['tgl_awal'] ?? date('Y-m-01'));
$akhir  = esc($_GET['tgl_akhir'] ?? date('Y-m-d'));
$status = $_GET['status'] ?? '';

$where = "WHERE t.tgl_pinjam BETWEEN '$awal' AND '$akhir'";
if (in_array($status, ['dipinjam', 'dikembalikan', 'menunggu', 'ditolak'])) {
    $where .= " AND t.status = '$status'";
}

$data = semua("SELECT t.*, u.nama_lengkap, u.nis_nip, u.kelas, b.judul
               FROM transaksi t
               JOIN users u ON t.id_user = u.id_user
               JOIN buku b ON t.id_buku = b.id_buku
               $where
               ORDER BY t.tgl_pinjam ASC");

// Hitung ringkasan
$jumlah      = ['dipinjam' => 0, 'dikembalikan' => 0, 'menunggu' => 0, 'ditolak' => 0];
$total_denda = 0;
foreach ($data as $row) {
    $total_denda += (int)$row['denda'];
    if (isset($jumlah[$row['status']])) {
        $jumlah[$row['status']]++;
    }
}
$total_trx = count($data);

$page_title = "Laporan Transaksi Perpustakaan";
require_once __DIR__ . '/includes/layout.php';

hero('printer', 'Laporan Sirkulasi Buku Perpustakaan',
    'Gunakan filter tanggal dan status untuk melihat serta mencetak rekapitulasi peminjaman buku.',
    '', 'page-hero hero-compact no-print');

require __DIR__ . '/views/laporan_filter.php';
require __DIR__ . '/views/laporan_cetak.php';
tampil_bawah();
