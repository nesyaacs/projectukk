<?php
// Pengembalian buku + perhitungan denda
require_once __DIR__ . '/config/koneksi.php';
cek_login();

$role         = $_SESSION['level'];
$user_id      = $_SESSION['id_user'];
$pesan_sukses = '';
$pesan_error  = '';

// Proses pengembalian
if (isset($_GET['id'])) {
    $id  = (int)$_GET['id'];
    $trx = db("SELECT t.*, b.judul, b.id_buku
               FROM transaksi t
               JOIN buku b ON t.id_buku = b.id_buku
               WHERE t.id_transaksi=$id AND t.status='dipinjam'");

    if ($trx) {
        if ($role !== 'admin' && $trx['id_user'] != $user_id) {
            $pesan_error = "Anda tidak berhak memproses transaksi milik siswa lain!";
        } else {
            [$hari, $denda] = hitung_denda($trx['tgl_jatuh_tempo']);
            $tgl_kembali    = date('Y-m-d');

            mysqli_begin_transaction($koneksi);

            $q1 = q("UPDATE transaksi SET tgl_kembali='$tgl_kembali', status='dikembalikan', denda=$denda
                     WHERE id_transaksi=$id");
            $q2 = q("UPDATE buku SET sisa_buku = sisa_buku + 1 WHERE id_buku={$trx['id_buku']}");

            if ($q1 && $q2) {
                mysqli_commit($koneksi);
                $info = $denda > 0 ? " Terlambat $hari hari, denda " . rp($denda) . "." : " Tepat waktu, bebas denda.";
                $pesan_sukses = "Buku \"{$trx['judul']}\" berhasil dikembalikan.$info";
            } else {
                mysqli_rollback($koneksi);
                $pesan_error = "Gagal memproses pengembalian: " . mysqli_error($koneksi);
            }
        }
    }
}

$where = $role === 'admin' ? "" : "AND t.id_user = $user_id";

$pinjam = semua("SELECT t.*, u.nama_lengkap, u.nis_nip, u.kelas, b.judul, b.kode_buku, b.lokasi_rak
                 FROM transaksi t
                 JOIN users u ON t.id_user = u.id_user
                 JOIN buku b ON t.id_buku = b.id_buku
                 WHERE t.status = 'dipinjam' $where
                 ORDER BY t.tgl_jatuh_tempo ASC");

$riwayat = semua("SELECT t.*, u.nama_lengkap, b.judul
                  FROM transaksi t
                  JOIN users u ON t.id_user = u.id_user
                  JOIN buku b ON t.id_buku = b.id_buku
                  WHERE t.status = 'dikembalikan' $where
                  ORDER BY t.tgl_kembali DESC LIMIT 10");

$page_title = "Pengembalian Buku";
require_once __DIR__ . '/includes/layout.php';

hero('upload', 'Pengembalian Buku Perpustakaan',
    'Kembalikan buku sebelum jatuh tempo. Tarif denda keterlambatan <strong>Rp 1.000 / hari</strong>.');
alert($pesan_sukses, $pesan_error);

require __DIR__ . '/views/pengembalian_aktif.php';
require __DIR__ . '/views/pengembalian_riwayat.php';
tampil_bawah();
