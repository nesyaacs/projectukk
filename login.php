<?php
// Login admin & siswa
$page_title = "Masuk Sistem";
require_once __DIR__ . '/config/koneksi.php';

if (isset($_SESSION['id_user'])) {
    header("Location: dashboard.php");
    exit;
}

$pesan_error  = '';
$pesan_sukses = isset($_GET['daftar']) ? "Pendaftaran berhasil! Silakan masuk dengan akun Anda." : '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = esc($_POST['username'] ?? '');
    $password = md5(trim($_POST['password'] ?? ''));

    $user = db("SELECT * FROM users WHERE username='$username' AND password='$password' LIMIT 1");

    if (!$user) {
        $pesan_error = "Username atau Password salah! Silakan coba lagi.";
    } elseif ($user['status_aktif'] !== 'aktif') {
        $pesan_error = "Akun Anda berstatus non-aktif. Silakan hubungi admin perpustakaan.";
    } else {
        $_SESSION['id_user']      = $user['id_user'];
        $_SESSION['nis_nip']      = $user['nis_nip'];
        $_SESSION['username']     = $user['username'];
        $_SESSION['nama_lengkap'] = $user['nama_lengkap'];
        $_SESSION['level']        = $user['level'];
        $_SESSION['kelas']        = $user['kelas'];
        header("Location: dashboard.php");
        exit;
    }
}

require_once __DIR__ . '/includes/layout.php';
require __DIR__ . '/views/login_form.php';
tampil_bawah();
