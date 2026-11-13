<?php
// Peminjaman buku (siswa mengajukan, admin mencatat langsung)
require_once __DIR__ . '/config/koneksi.php';
cek_login();

$role         = $_SESSION['level'];
$user_id      = $_SESSION['id_user'];
$pesan_sukses = '';
$pesan_error  = '';
$pilih        = (int)($_GET['id_buku'] ?? 0);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['proses_pinjam'])) {
    $id_buku = (int)($_POST['id_buku'] ?? 0);
    $id_user = $role === 'admin' ? (int)($_POST['id_user'] ?? 0) : $user_id;
    $tanggal = esc($_POST['tgl_pinjam'] ?? '');
    $tempo   = esc($_POST['tgl_jatuh_tempo'] ?? '');
    $catatan = esc($_POST['catatan'] ?? '');

    $buku = db("SELECT * FROM buku WHERE id_buku=$id_buku");

    if (!$id_buku || !$id_user || !$tanggal || !$tempo) {
        $pesan_error = "Harap isi semua kolom formulir peminjaman!";
    } elseif (!$buku) {
        $pesan_error = "Data buku tidak ditemukan!";
    } elseif ($buku['sisa_buku'] < 1) {
        $pesan_error = "Maaf, stok buku \"" . e($buku['judul']) . "\" sedang habis!";
    } elseif (nilai("SELECT COUNT(*) FROM transaksi WHERE id_user=$id_user AND id_buku=$id_buku AND status IN ('dipinjam', 'menunggu')") > 0) {
        $pesan_error = "Siswa ini masih meminjam atau memiliki permohonan aktif untuk buku tersebut!";
    } else {
        $prefix = "TRX-" . date('Ymd') . "-";
        $urut   = nilai("SELECT COUNT(*) FROM transaksi WHERE kode_transaksi LIKE '$prefix%'") + 1;
        $kode   = $prefix . str_pad($urut, 3, "0", STR_PAD_LEFT);
        $status = $role === 'admin' ? 'dipinjam' : 'menunggu';

        mysqli_begin_transaction($koneksi);

        $q1 = q("INSERT INTO transaksi (kode_transaksi, id_user, id_buku, tgl_pinjam, tgl_jatuh_tempo, status, denda, catatan)
                 VALUES ('$kode', $id_user, $id_buku, '$tanggal', '$tempo', '$status', 0, '$catatan')");
        $q2 = q("UPDATE buku SET sisa_buku = sisa_buku - 1 WHERE id_buku=$id_buku");

        if ($q1 && $q2) {
            mysqli_commit($koneksi);
            if ($status === 'menunggu') {
                $pesan_sukses = "Permohonan pinjam dengan kode $kode berhasil diajukan! Harap menunggu persetujuan admin perpustakaan.";
            } else {
                $pesan_sukses = "Peminjaman berhasil dicatat dengan kode $kode. Harap kembalikan sebelum jatuh tempo!";
            }
        } else {
            mysqli_rollback($koneksi);
            $pesan_error = "Gagal memproses peminjaman: " . mysqli_error($koneksi);
        }
    }
}

$buku_tersedia = semua("SELECT * FROM buku WHERE sisa_buku > 0 ORDER BY judul ASC");
$siswa_list    = $role === 'admin'
    ? semua("SELECT * FROM users WHERE level='siswa' AND status_aktif='aktif' ORDER BY nama_lengkap ASC")
    : [];

$page_title = "Peminjaman Buku";
require_once __DIR__ . '/includes/layout.php';
require __DIR__ . '/views/pinjam_form.php';
tampil_bawah();
