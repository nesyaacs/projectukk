<?php
// Kelola anggota & petugas (khusus admin)
require_once __DIR__ . '/config/koneksi.php';
cek_login('admin');

$pesan_sukses = '';
$pesan_error  = '';
$edit         = null;

// Hapus anggota
if (($_GET['aksi'] ?? '') === 'hapus' && isset($_GET['id'])) {
    $id = (int)$_GET['id'];
    if ($id === (int)$_SESSION['id_user']) {
        $pesan_error = "Anda tidak dapat menghapus akun sendiri!";
    } else {
        q("DELETE FROM users WHERE id_user=$id");
        $pesan_sukses = "Data anggota berhasil dihapus!";
    }
}

// Tambah anggota
if (isset($_POST['tambah_anggota'])) {
    $nis      = esc($_POST['nis_nip'] ?? '');
    $nama     = esc($_POST['nama_lengkap'] ?? '');
    $username = esc($_POST['username'] ?? '');
    $pass     = md5(trim($_POST['password'] ?? ''));
    $level    = esc($_POST['level'] ?? 'siswa');
    $kelas    = esc($_POST['kelas'] ?? '');
    $jurusan  = esc($_POST['jurusan'] ?? '');
    $telepon  = esc($_POST['telepon'] ?? '');
    $alamat   = esc($_POST['alamat'] ?? '');
    $status   = esc($_POST['status_aktif'] ?? 'aktif');

    if (nilai("SELECT COUNT(*) FROM users WHERE username='$username' OR nis_nip='$nis'") > 0) {
        $pesan_error = "Username atau NIS/NIP sudah terdaftar!";
    } else {
        q("INSERT INTO users (nis_nip, nama_lengkap, username, password, level, kelas, jurusan, telepon, alamat, status_aktif)
           VALUES ('$nis', '$nama', '$username', '$pass', '$level', '$kelas', '$jurusan', '$telepon', '$alamat', '$status')");
        $pesan_sukses = "Data anggota baru berhasil ditambahkan!";
    }
}

// Edit anggota
if (isset($_POST['edit_anggota'])) {
    $id        = (int)$_POST['id_user'];
    $nis       = esc($_POST['nis_nip'] ?? '');
    $nama      = esc($_POST['nama_lengkap'] ?? '');
    $username  = esc($_POST['username'] ?? '');
    $level     = esc($_POST['level'] ?? 'siswa');
    $kelas     = esc($_POST['kelas'] ?? '');
    $jurusan   = esc($_POST['jurusan'] ?? '');
    $telepon   = esc($_POST['telepon'] ?? '');
    $alamat    = esc($_POST['alamat'] ?? '');
    $status    = esc($_POST['status_aktif'] ?? 'aktif');
    $pass_baru = trim($_POST['password_baru'] ?? '');

    if (nilai("SELECT COUNT(*) FROM users WHERE username='$username' AND id_user != $id") > 0) {
        $pesan_error = "Username sudah digunakan oleh akun lain!";
    } else {
        $ganti_pass = $pass_baru ? ", password='" . md5($pass_baru) . "'" : "";
        q("UPDATE users SET nis_nip='$nis', nama_lengkap='$nama', username='$username',
           level='$level', kelas='$kelas', jurusan='$jurusan', telepon='$telepon',
           alamat='$alamat', status_aktif='$status' $ganti_pass
           WHERE id_user=$id");
        $pesan_sukses = "Data anggota berhasil diperbarui!";
    }
}

// Ambil data untuk form edit
if (($_GET['aksi'] ?? '') === 'edit' && isset($_GET['id'])) {
    $edit = db("SELECT * FROM users WHERE id_user=" . (int)$_GET['id']);
}

$daftar     = semua("SELECT * FROM users ORDER BY level ASC, nama_lengkap ASC");
$page_title = "Kelola Data Anggota";
require_once __DIR__ . '/includes/layout.php';

hero('people', 'Kelola Data Anggota Perpustakaan',
    'Pendaftaran siswa, pengelolaan akun petugas/admin, serta kontrol status keanggotaan aktif/non-aktif.');
alert($pesan_sukses, $pesan_error);

require __DIR__ . '/views/anggota_form.php';
require __DIR__ . '/views/anggota_tabel.php';
tampil_bawah();
