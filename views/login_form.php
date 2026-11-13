<?php
// Tampilan form login
?>
<div class="auth-container">
  <div class="auth-card">
    <div class="auth-header">
      <div style="margin-bottom: 6px;"><?= bi('book', 34); ?></div>
      <h2>Masuk ke Perpustakaan</h2>
      <p>Silakan masuk menggunakan akun Admin atau Siswa</p>
    </div>

    <div class="auth-body">
      <?php alert($pesan_sukses, $pesan_error); ?>

      <form action="login.php" method="POST" autocomplete="off">
        <?php
        input_form('Username', 'username', '', [
            'wajib' => true, 'placeholder' => 'Masukkan username',
            'autocomplete' => 'off', 'extra' => 'autofocus',
        ]);
        input_form('Password', 'password', '', [
            'tipe' => 'password', 'wajib' => true, 'placeholder' => 'Masukkan password',
            'autocomplete' => 'new-password',
        ]);
        ?>

        <div style="margin-top: 20px;">
          <button type="submit" class="btn btn-primary" style="width: 100%;">
            <?= bi('box-arrow-in-right', 15); ?> Masuk Sekarang
          </button>
        </div>
      </form>

      <div class="auth-footer">
        Belum terdaftar sebagai anggota siswa?<br>
        <a href="daftar.php"><?= bi('card-checklist', 14); ?> Klik di sini untuk Daftar Anggota</a>
      </div>
    </div>
  </div>
</div>
