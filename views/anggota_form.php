<?php
// Form tambah / edit anggota & petugas
$pilihan_level = [
    'siswa' => 'Siswa (User Biasa)',
    'admin' => 'Admin (Petugas Perpustakaan)',
];
$pilihan_status = [
    'aktif' => 'Aktif',
    'nonaktif' => 'Non-Aktif',
];
?>
<div class="card">
  <div class="card-header">
    <div class="card-title">
      <?= $edit ? bi('pencil', 16) . ' Edit Data Anggota' : bi('plus', 16) . ' Tambah Anggota / Petugas Baru'; ?>
    </div>
    <?php if ($edit): ?>
      <a href="anggota.php" class="btn btn-outline btn-sm">Batal Edit</a>
    <?php endif; ?>
  </div>

  <form action="anggota.php" method="POST" autocomplete="off">
    <?php if ($edit): ?>
      <input type="hidden" name="id_user" value="<?= $edit['id_user']; ?>">
    <?php endif; ?>

    <div class="form-row">
      <?php
      input_form('NIS / NIP *', 'nis_nip', $edit['nis_nip'] ?? '', [
          'wajib' => true, 'placeholder' => 'Nomor induk siswa / petugas', 'autocomplete' => 'off',
      ]);
      input_form('Nama Lengkap *', 'nama_lengkap', $edit['nama_lengkap'] ?? '', [
          'wajib' => true, 'placeholder' => 'Nama lengkap', 'autocomplete' => 'off',
      ]);
      ?>
    </div>

    <div class="form-row">
      <?php
      input_form('Username *', 'username', $edit['username'] ?? '', [
          'wajib' => true, 'baca' => true, 'placeholder' => 'Username login baru',
          'autocomplete' => 'off',
      ]);
      select_form('Role / Hak Akses *', 'level', $pilihan_level, $edit['level'] ?? '', ['wajib' => true]);
      ?>
    </div>

    <div class="form-row">
      <?php
      input_form('Kelas', 'kelas', $edit['kelas'] ?? '', ['placeholder' => 'Contoh: XII RPL 1']);
      input_form('Jurusan', 'jurusan', $edit['jurusan'] ?? '', ['placeholder' => 'Contoh: Rekayasa Perangkat Lunak']);
      ?>
    </div>

    <div class="form-row">
      <?php
      input_form('No. Telepon / WA', 'telepon', $edit['telepon'] ?? '', ['placeholder' => '08xxxxxxxxxx']);
      select_form('Status Keaktifan *', 'status_aktif', $pilihan_status, $edit['status_aktif'] ?? '', ['wajib' => true]);
      ?>
    </div>

    <?php textarea_form('Alamat Lengkap', 'alamat', $edit['alamat'] ?? '', [
        'placeholder' => 'Alamat rumah',
    ]); ?>

    <?php if ($edit): ?>
      <?php input_form('Password Baru (Kosongkan jika tidak diubah)', 'password_baru', '', [
          'tipe' => 'password', 'baca' => true, 'placeholder' => 'Password baru',
          'autocomplete' => 'new-password',
      ]); ?>
      <button type="submit" name="edit_anggota" class="btn btn-warning">
        <?= bi('pencil', 14); ?> Simpan Perubahan Anggota
      </button>
    <?php else: ?>
      <?php input_form('Password Akun *', 'password', '', [
          'tipe' => 'password', 'wajib' => true, 'baca' => true,
          'placeholder' => 'Minimal 4 karakter', 'autocomplete' => 'new-password',
      ]); ?>
      <button type="submit" name="tambah_anggota" class="btn btn-primary">
        <?= bi('plus', 14); ?> Tambah Anggota Baru
      </button>
    <?php endif; ?>
  </form>
</div>
