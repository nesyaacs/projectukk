<?php
// Kelola seluruh transaksi (khusus admin)
require_once __DIR__ . '/config/koneksi.php';
cek_login('admin');

$pesan_sukses = '';
$pesan_error  = '';
$aksi         = $_GET['aksi'] ?? '';
$id           = (int)($_GET['id'] ?? 0);

// 1. Setujui peminjaman (menunggu -> dipinjam)
if ($aksi === 'setujui' && $id) {
    $trx = db("SELECT * FROM transaksi WHERE id_transaksi=$id AND status='menunggu'");
    if ($trx) {
        q("UPDATE transaksi SET status='dipinjam' WHERE id_transaksi=$id");
        $pesan_sukses = "Permohonan peminjaman buku berhasil DISETUJUI!";
    }
}

// 2. Tolak peminjaman (menunggu/dipinjam -> ditolak, stok dikembalikan)
if ($aksi === 'tolak' && $id) {
    $trx = db("SELECT * FROM transaksi WHERE id_transaksi=$id");
    if ($trx && in_array($trx['status'], ['menunggu', 'dipinjam'])) {
        mysqli_begin_transaction($koneksi);
        $q1 = q("UPDATE buku SET sisa_buku = sisa_buku + 1 WHERE id_buku={$trx['id_buku']}");
        $q2 = q("UPDATE transaksi SET status='ditolak', catatan=CONCAT(IFNULL(catatan, ''), ' [Ditolak oleh Admin]') WHERE id_transaksi=$id");
        if ($q1 && $q2) {
            mysqli_commit($koneksi);
            $pesan_sukses = "Peminjaman buku berhasil DITOLAK dan stok buku telah dikembalikan!";
        } else {
            mysqli_rollback($koneksi);
            $pesan_error = "Gagal memproses penolakan: " . mysqli_error($koneksi);
        }
    }
}

// 3. Hapus transaksi
if ($aksi === 'hapus' && $id) {
    $trx = db("SELECT * FROM transaksi WHERE id_transaksi=$id");
    if ($trx) {
        if ($trx['status'] === 'dipinjam' || $trx['status'] === 'menunggu') {
            q("UPDATE buku SET sisa_buku = sisa_buku + 1 WHERE id_buku={$trx['id_buku']}");
        }
        q("DELETE FROM transaksi WHERE id_transaksi=$id");
        $pesan_sukses = "Data transaksi berhasil dihapus!";
    }
}

// 4. Perpanjang 7 hari
if ($aksi === 'perpanjang' && $id) {
    q("UPDATE transaksi SET
         tgl_jatuh_tempo = DATE_ADD(tgl_jatuh_tempo, INTERVAL 7 DAY),
         catatan = CONCAT(IFNULL(catatan, ''), ' [Diperpanjang 7 hari]')
       WHERE id_transaksi=$id AND status='dipinjam'");
    $pesan_sukses = "Masa peminjaman berhasil diperpanjang 7 hari!";
}

// Filter status
$status = $_GET['status'] ?? '';
$where  = in_array($status, ['menunggu', 'dipinjam', 'dikembalikan', 'ditolak'])
    ? "WHERE t.status = '$status'"
    : '';

$daftar = semua("SELECT t.*, u.nama_lengkap, u.nis_nip, u.kelas, b.judul, b.kode_buku
                 FROM transaksi t
                 JOIN users u ON t.id_user = u.id_user
                 JOIN buku b ON t.id_buku = b.id_buku
                 $where
                 ORDER BY t.id_transaksi DESC");

$page_title = "Kelola Seluruh Transaksi";
require_once __DIR__ . '/includes/layout.php';

$tombol = '<a href="pinjam.php" class="btn btn-primary">' . bi('plus') . ' Catat Peminjaman Baru</a>'
        . '<a href="pengembalian.php" class="btn btn-outline">' . bi('upload') . ' Menu Pengembalian Cepat</a>'
        . '<a href="laporan.php" class="btn btn-outline">' . bi('printer') . ' Cetak Laporan Peminjaman</a>';

hero('arrow-repeat', 'Kelola Sirkulasi Transaksi Peminjaman & Pengembalian',
    'Pantau seluruh transaksi, perpanjangan masa pinjam, konfirmasi pengembalian, dan denda keterlambatan.', $tombol);
alert($pesan_sukses, $pesan_error);

require __DIR__ . '/views/transaksi_tabel.php';
tampil_bawah();
