<?php
// Beranda + katalog buku (bisa diakses tanpa login)
$page_title = "Beranda & Katalog Koleksi";
require_once __DIR__ . '/config/koneksi.php';

$stat = [
    ['book', nilai("SELECT COUNT(*) FROM buku"), 'Judul Buku'],
    ['journal', nilai("SELECT SUM(sisa_buku) FROM buku"), 'Buku Siap Pinjam'],
    ['tag', nilai("SELECT COUNT(*) FROM kategori"), 'Kategori Koleksi'],
    ['people', nilai("SELECT COUNT(*) FROM users WHERE level='siswa'"), 'Siswa Terdaftar'],
];

$daftar_buku = semua("SELECT b.*, k.nama_kategori
                      FROM buku b
                      LEFT JOIN kategori k ON b.id_kategori = k.id_kategori
                      ORDER BY b.id_buku DESC");

require_once __DIR__ . '/includes/layout.php';
require __DIR__ . '/views/index_katalog.php';
tampil_bawah();
