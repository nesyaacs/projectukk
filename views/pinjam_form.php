<?php
// Tampilan form peminjaman buku
$pilihan_siswa = ['' => '-- Pilih Nama Siswa --'];
foreach ($siswa_list as $s) {
    $pilihan_siswa[$s['id_user']] = $s['nama_lengkap'] . ' (NIS: ' . $s['nis_nip'] . ' - ' . $s['kelas'] . ')';
}

$pilihan_buku = ['' => '-- Pilih Buku yang Tersedia --'];
foreach ($buku_tersedia as $b) {
    $pilihan_buku[$b['id_buku']] = $b['judul'] . ' | [Rak: ' . $b['lokasi_rak'] . '] | (Sisa: ' . $b['sisa_buku'] . ' unit)';
}

hero('download', 'Form Peminjaman Buku Digital',
    'Lakukan peminjaman buku secara mandiri. Batas peminjaman standar adalah 7 hari.');
alert($pesan_sukses, $pesan_error);
?>

<div class="card" style="max-width: 750px; margin: 0 auto 30px auto;">
  <div class="card-header">
    <div class="card-title"><?= bi('journal', 18); ?> Formulir Peminjaman Buku</div>
    <a href="buku.php" class="btn btn-outline btn-sm"><?= bi('book', 14); ?> Lihat Katalog Buku</a>
  </div>

  <form action="pinjam.php" method="POST">
    <?php if ($role === 'admin'): ?>
      <?php select_form('Pilih Siswa Peminjam *', 'id_user', $pilihan_siswa, '', ['wajib' => true]); ?>
    <?php else: ?>
      <div class="form-group">
        <label class="form-label">Nama Peminjam</label>
        <input type="text" class="form-control" readonly style="background: var(--primary-subtle);"
               value="<?= e($_SESSION['nama_lengkap']); ?> (NIS: <?= e($_SESSION['nis_nip']); ?>)">
      </div>
    <?php endif; ?>

    <?php select_form('Pilih Buku yang Ingin Dipinjam *', 'id_buku', $pilihan_buku, $pilih, ['wajib' => true]); ?>

    <div class="form-row">
      <?php
      input_form('Tanggal Peminjaman *', 'tgl_pinjam', date('Y-m-d'), ['tipe' => 'date', 'wajib' => true]);
      input_form('Tanggal Jatuh Tempo *', 'tgl_jatuh_tempo', date('Y-m-d', strtotime('+7 days')), [
          'tipe' => 'date', 'wajib' => true, 'bantuan' => '* Standar waktu peminjaman adalah 7 hari',
      ]);
      ?>
    </div>

    <?php textarea_form('Catatan / Keperluan (Opsional)', 'catatan', '', [
        'placeholder' => 'Contoh: Referensi tugas praktikum...',
    ]); ?>

    <div style="margin-top: 20px; display: flex; gap: 10px;">
      <button type="submit" name="proses_pinjam" class="btn btn-primary" style="flex: 1;">
        <?= bi('download', 14); ?> Ajukan Peminjaman Sekarang
      </button>
      <?php if ($role === 'siswa'): ?>
        <a href="pengembalian.php" class="btn btn-outline"><?= bi('upload', 13); ?> Lihat Buku Dipinjam</a>
      <?php else: ?>
        <a href="transaksi.php" class="btn btn-outline"><?= bi('arrow-repeat', 13); ?> Buka Data Transaksi</a>
      <?php endif; ?>
    </div>
  </form>
</div>
