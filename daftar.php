<?php
// Pendaftaran anggota siswa baru (mandiri)
$page_title = "Daftar Anggota Siswa Baru";
require_once __DIR__ . '/config/koneksi.php';

if (isset($_SESSION['id_user'])) {
    header("Location: dashboard.php");
    exit;
}

$pesan_error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nis        = esc($_POST['nis'] ?? '');
    $nama       = esc($_POST['nama_lengkap'] ?? '');
    $kelas      = esc($_POST['kelas'] ?? '');
    $jurusan    = esc($_POST['jurusan'] ?? '');
    $telepon    = esc($_POST['telepon'] ?? '');
    $alamat     = esc($_POST['alamat'] ?? '');
    $username   = esc($_POST['username'] ?? '');
    $password   = trim($_POST['password'] ?? '');
    $konfirmasi = trim($_POST['konfirmasi_password'] ?? '');

    if (!$nis || !$nama || !$username || !$password) {
        $pesan_error = "Harap lengkapi semua kolom bertanda wajib (*)!";
    } elseif ($password !== $konfirmasi) {
        $pesan_error = "Konfirmasi password tidak cocok!";
    } elseif (strlen($password) < 4) {
        $pesan_error = "Password minimal terdiri dari 4 karakter!";
    } elseif (nilai("SELECT COUNT(*) FROM users WHERE username='$username' OR nis_nip='$nis'") > 0) {
        $pesan_error = "Username atau NIS sudah terdaftar sebelumnya!";
    } else {
        $pass = md5($password);
        q("INSERT INTO users (nis_nip, nama_lengkap, username, password, level, kelas, jurusan, telepon, alamat, status_aktif)
           VALUES ('$nis', '$nama', '$username', '$pass', 'siswa', '$kelas', '$jurusan', '$telepon', '$alamat', 'aktif')");
        header("Location: login.php?daftar=berhasil");
        exit;
    }
}

require_once __DIR__ . '/includes/layout.php';
require __DIR__ . '/views/daftar_form.php';
tampil_bawah();
