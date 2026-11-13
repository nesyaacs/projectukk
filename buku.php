<?php
// Kelola buku (admin: CRUD) / katalog buku (siswa)
require_once __DIR__ . '/config/koneksi.php';
require_once __DIR__ . '/includes/upload.php';
cek_login();

$role         = $_SESSION['level'];
$pesan_sukses = '';
$pesan_error  = '';
$edit         = null;

if ($role === 'admin') {
    // Hapus buku + cover custom
    if (($_GET['aksi'] ?? '') === 'hapus' && isset($_GET['id'])) {
        $id   = (int)$_GET['id'];
        $lama = db("SELECT gambar FROM buku WHERE id_buku=$id");
        hapus_cover($lama['gambar'] ?? '');
        q("DELETE FROM buku WHERE id_buku=$id");
        $pesan_sukses = "Data buku berhasil dihapus!";
    }

    // Tambah buku
    if (isset($_POST['tambah_buku'])) {
        $kode      = esc($_POST['kode_buku'] ?? '');
        $judul     = esc($_POST['judul'] ?? '');
        $kategori  = (int)($_POST['id_kategori'] ?? 0);
        $pengarang = esc($_POST['pengarang'] ?? '');
        $penerbit  = esc($_POST['penerbit'] ?? '');
        $tahun     = (int)($_POST['tahun_terbit'] ?? 0);
        $isbn      = esc($_POST['isbn'] ?? '');
        $jumlah    = (int)($_POST['jumlah_buku'] ?? 0);
        $rak       = esc($_POST['lokasi_rak'] ?? '');
        $deskripsi = esc($_POST['deskripsi'] ?? '');

        if (nilai("SELECT COUNT(*) FROM buku WHERE kode_buku='$kode'") > 0) {
            $pesan_error = "Kode buku sudah digunakan! Gunakan kode lain.";
        } else {
            $cover = upload_cover('gambar', 'default-book.svg');
            if ($cover === false) {
                $pesan_error = "Gagal mengunggah cover! Ukuran file maksimal 2 MB.";
            } elseif ($cover === null) {
                $pesan_error = "Format file tidak valid! Gunakan format gambar JPG, PNG, WEBP, atau SVG.";
            } else {
                q("INSERT INTO buku (kode_buku, judul, id_kategori, pengarang, penerbit, tahun_terbit, isbn, jumlah_buku, sisa_buku, lokasi_rak, deskripsi, gambar)
                   VALUES ('$kode', '$judul', $kategori, '$pengarang', '$penerbit', $tahun, '$isbn', $jumlah, $jumlah, '$rak', '$deskripsi', '$cover')");
                $pesan_sukses = "Data buku baru berhasil ditambahkan beserta gambar cover!";
            }
        }
    }

    // Edit buku
    if (isset($_POST['edit_buku'])) {
        $id        = (int)$_POST['id_buku'];
        $kode      = esc($_POST['kode_buku'] ?? '');
        $judul     = esc($_POST['judul'] ?? '');
        $kategori  = (int)($_POST['id_kategori'] ?? 0);
        $pengarang = esc($_POST['pengarang'] ?? '');
        $penerbit  = esc($_POST['penerbit'] ?? '');
        $tahun     = (int)($_POST['tahun_terbit'] ?? 0);
        $isbn      = esc($_POST['isbn'] ?? '');
        $jumlah    = (int)($_POST['jumlah_buku'] ?? 0);
        $sisa      = (int)($_POST['sisa_buku'] ?? 0);
        $rak       = esc($_POST['lokasi_rak'] ?? '');
        $deskripsi = esc($_POST['deskripsi'] ?? '');
        $gambar    = esc($_POST['gambar_lama'] ?? 'default-book.svg');

        $cover = upload_cover('gambar', $gambar);
        if ($cover === false) {
            $pesan_error = "Gagal mengunggah cover! Ukuran file maksimal 2 MB.";
        } elseif ($cover === null) {
            $pesan_error = "Format file tidak valid! Gunakan format gambar JPG, PNG, WEBP, atau SVG.";
        } else {
            q("UPDATE buku SET kode_buku='$kode', judul='$judul', id_kategori=$kategori,
               pengarang='$pengarang', penerbit='$penerbit', tahun_terbit=$tahun,
               isbn='$isbn', jumlah_buku=$jumlah, sisa_buku=$sisa,
               lokasi_rak='$rak', deskripsi='$deskripsi', gambar='$cover'
               WHERE id_buku=$id");
            $pesan_sukses = "Data buku dan cover berhasil diperbarui!";
        }
    }

    // Ambil data untuk form edit
    if (($_GET['aksi'] ?? '') === 'edit' && isset($_GET['id'])) {
        $edit = db("SELECT * FROM buku WHERE id_buku=" . (int)$_GET['id']);
    }
}

$kategori = semua("SELECT * FROM kategori ORDER BY nama_kategori ASC");
$daftar   = semua("SELECT b.*, k.nama_kategori
                   FROM buku b
                   LEFT JOIN kategori k ON b.id_kategori = k.id_kategori
                   ORDER BY b.id_buku DESC");

$page_title = $role === 'admin' ? "Kelola Data Buku" : "Katalog Buku Perpustakaan";
require_once __DIR__ . '/includes/layout.php';

hero('book',
    $role === 'admin' ? 'Kelola Data Buku Perpustakaan' : 'Katalog Buku Perpustakaan',
    $role === 'admin'
        ? 'Admin memiliki hak akses penuh untuk melakukan Create, Read, Update, dan Delete (CRUD) data buku.'
        : 'Temukan berbagai referensi buku menarik dan ajukan peminjaman secara digital.');
alert($pesan_sukses, $pesan_error);

if ($role === 'admin') {
    require __DIR__ . '/views/buku_form.php';
}
require __DIR__ . '/views/buku_tabel.php';
tampil_bawah();
