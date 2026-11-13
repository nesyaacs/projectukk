# 📚 Perpustakaan Sekolah Digital Berbasis Web
**Tugas Praktik:** Pengembangan Aplikasi Peminjaman Buku  
**Paket Kejuruan:** Paket 4 Rekayasa Perangkat Lunak (UKK RPL)  
**Teknologi:** PHP (Native), HTML5, CSS3, JavaScript (Java/JS), MariaDB / MySQL  
**Koleksi Aset:** Dipisah di folder `assets/css/` dan `assets/js/`  
**Tema Antarmuka:** Solid Blue (Bersih, Rapi, Profesional, Tanpa Gradasi)  

---

## 📂 Struktur File Proyek

```text
projectukk/
├── assets/
│   ├── css/
│   │   └── style.css          # Desain Solid Blue Bersih, Rapi, Responsif Desktop & Mobile
│   ├── js/
│   │   └── script.js          # Live Search interaktif, validasi tanggal +7 hari, pratinjau cover buku
│   └── uploads/               # Direktori berkas gambar cover buku perpustakaan
├── config/
│   └── koneksi.php            # Koneksi database MySQLi (localhost, root, "", dbn_perpustakaan)
├── includes/
│   ├── header.php             # Navigasi atas otomatis sesuai Role (Admin / Siswa / Tamu)
│   └── footer.php             # Footer informasi dan pemanggilan script JS
├── index.php                  # Halaman Beranda & Katalog Buku Terbuka untuk umum
├── login.php                  # Autentikasi Pengguna (Admin & Siswa)
├── daftar.php                 # Pendaftaran Akun Siswa Baru
├── logout.php                 # Proses Logout aman
├── dashboard.php              # Dashboard Utama (Menyesuaikan Hak Akses Admin / Siswa)
├── buku.php                   # CRUD Data Buku Lengkap (Admin) & Pencarian Buku (Siswa)
├── anggota.php                # CRUD Data Anggota Siswa & Petugas (Admin)
├── pinjam.php                 # Formulir Peminjaman Buku (Pengurangan stok otomatis)
├── pengembalian.php           # Pengembalian Buku (Pemulihan stok otomatis + kalkulasi denda)
├── transaksi.php              # Kelola Sirkulasi Seluruh Transaksi & Perpanjang Waktu (Admin)
├── laporan.php                # Rekapitulasi Laporan Peminjaman + Cetak (Print Preview)
├── database.sql               # Skrip database MySQL lengkap dengan data contoh
└── DOKUMENTASI_UKK.md         # Dokumen ERD, Deskripsi Program, Fungsi & Prosedur, Debugging, Evaluasi
```

---

## 🚀 Cara Menjalankan Aplikasi

1. Nyalakan **Apache** dan **MySQL** di **XAMPP Control Panel**.
2. Buat database baru bernama `dbn_perpustakaan` di `http://localhost/phpmyadmin/`.
3. Import file `database.sql` yang berada di dalam folder proyek ini.
4. Buka browser dan akses alamat:
   ```text
   http://localhost/NESYA_XII_RPL1/projectukk/
   ```

---

## 🔑 Akun Uji Coba untuk Penguji UKK

| Hak Akses | Username | Password | Keterangan |
|---|---|---|---|
| **Admin** | `admin` | `admin123` | Hak akses penuh: CRUD Buku, Anggota, Transaksi, Laporan |
| **Siswa** | `siswa` | `siswa123` | Hak akses siswa: Pinjam Buku, Pengembalian Buku, Lihat Katalog |
