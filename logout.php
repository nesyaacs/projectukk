<?php
// Logout: hapus session lalu kembali ke halaman login
session_start();
session_destroy();
header("Location: login.php");
exit;
