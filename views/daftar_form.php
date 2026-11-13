<?php
// Tampilan form pendaftaran anggota siswa
?>
<div class="auth-container" style="min-height: 90vh;">
  <div class="auth-card" style="max-width: 550px;">
    <div class="auth-header">
      <div style="margin-bottom: 6px;"><?= bi('card-checklist', 34); ?></div>
      <h2>Pendaftaran Anggota Siswa</h2>
      <p>Isi formulir berikut untuk menjadi anggota perpustakaan sekolah</p>
    </div>

    <div class="auth-body">
      <?php alert('', $pesan_error); ?>

      <form action="daftar.php" method="POST" autocomplete="off">
        <div class="form-row">
          <?php
          input_form('NIS (Nomor Induk Siswa) *', 'nis', $_POST['nis'] ?? '', [
              'wajib' => true, 'placeholder' => 'Contoh: 202410101', 'autocomplete' => 'off',
          ]);
          input_form('Nama Lengkap Siswa *', 'nama_lengkap', $_POST['nama_lengkap'] ?? '', [
              'wajib' => true, 'placeholder' => 'Nama lengkap Anda', 'autocomplete' => 'off',
          ]);
          ?>
        </div>

        <div class="form-row">
          <?php
          input_form('Kelas *', 'kelas', $_POST['kelas'] ?? '', [
              'wajib' => true, 'placeholder' => 'Contoh: XII RPL 1', 'autocomplete' => 'off',
          ]);
          input_form('Jurusan / Kompetensi Keahlian', 'jurusan', $_POST['jurusan'] ?? '', [
              'placeholder' => 'Contoh: Rekayasa Perangkat Lunak', 'autocomplete' => 'off',
          ]);
          ?>
        </div>

        <div class="form-row">
          <?php
          input_form('No. Telepon / WhatsApp', 'telepon', $_POST['telepon'] ?? '', [
              'placeholder' => '08xxxxxxxxxx', 'autocomplete' => 'off',
          ]);
          input_form('Username Akun *', 'username', $_POST['username'] ?? '', [
              'wajib' => true, 'baca' => true, 'placeholder' => 'Username untuk login',
              'autocomplete' => 'off',
          ]);
          ?>
        </div>

        <?php textarea_form('Alamat Tinggal', 'alamat', $_POST['alamat'] ?? '', [
            'placeholder' => 'Alamat tempat tinggal',
        ]); ?>

        <div class="form-row">
          <?php
          input_form('Password *', 'password', '', [
              'tipe' => 'password', 'wajib' => true, 'baca' => true,
              'placeholder' => 'Minimal 4 karakter', 'autocomplete' => 'new-password',
          ]);
          input_form('Ulangi Password *', 'konfirmasi_password', '', [
              'tipe' => 'password', 'wajib' => true, 'baca' => true,
              'placeholder' => 'Konfirmasi password', 'autocomplete' => 'new-password',
          ]);
          ?>
        </div>

        <div style="margin-top: 15px;">
          <button type="submit" class="btn btn-primary" style="width: 100%;">
            <?= bi('card-checklist', 15); ?> Daftarkan Akun Saya
          </button>
        </div>
      </form>

      <div class="auth-footer">
        Sudah memiliki akun perpustakaan?<br>
        <a href="login.php"><?= bi('box-arrow-in-right', 14); ?> Kembali ke Halaman Login</a>
      </div>
    </div>
  </div>
</div>
