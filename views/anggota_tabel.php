<?php
// Tabel data anggota & petugas
?>
<div class="card">
  <div class="card-header">
    <div class="card-title"><?= bi('people', 18); ?> Data Seluruh Anggota & Petugas</div>
    <span class="text-muted-sm">Total: <?= count($daftar); ?> Akun</span>
  </div>

  <div class="filter-bar">
    <div class="search-input-wrapper">
      <input type="text" id="tableSearch" class="form-control"
             placeholder="Ketik kata kunci untuk mencari nama, NIS, kelas, jurusan, username...">
    </div>
  </div>

  <div class="table-responsive">
    <table class="live-table">
      <thead>
        <tr>
          <th>No</th>
          <th>NIS / NIP</th>
          <th>Nama Lengkap</th>
          <th>Kelas & Jurusan</th>
          <th>Username</th>
          <th>Telepon</th>
          <th>Role</th>
          <th>Status</th>
          <th style="text-align: center;">Aksi</th>
        </tr>
      </thead>
      <tbody>
        <?php if (!$daftar): ?>
          <?php baris_kosong(9, 'Belum ada data anggota tersimpan.'); ?>
        <?php else: $no = 1; foreach ($daftar as $u): ?>
          <tr>
            <td><?= $no++; ?></td>
            <td><code><?= e($u['nis_nip']); ?></code></td>
            <td><strong><?= e($u['nama_lengkap']); ?></strong></td>
            <td>
              <?= e($u['kelas'] ?? '-'); ?><br>
              <small class="text-muted"><?= e($u['jurusan'] ?? '-'); ?></small>
            </td>
            <td><?= e($u['username']); ?></td>
            <td><?= e($u['telepon'] ?? '-'); ?></td>
            <td><span class="badge badge-<?= $u['level']; ?>"><?= $u['level'] === 'admin' ? 'Admin' : 'Siswa'; ?></span></td>
            <td>
              <span class="badge <?= $u['status_aktif'] === 'aktif' ? 'badge-dikembalikan' : 'badge-ditolak'; ?>">
                <?= $u['status_aktif']; ?>
              </span>
            </td>
            <td class="td-aksi">
              <a href="anggota.php?aksi=edit&id=<?= $u['id_user']; ?>" class="btn btn-warning btn-sm">
                <?= bi('pencil', 12); ?> Edit
              </a>
              <?php if ($u['id_user'] != $_SESSION['id_user']): ?>
                <a href="anggota.php?aksi=hapus&id=<?= $u['id_user']; ?>" class="btn btn-danger btn-sm"
                   data-confirm="Hapus anggota ini?">
                  <?= bi('trash', 12); ?> Hapus
                </a>
              <?php else: ?>
                <span style="font-size: 0.75rem; color: var(--text-muted);">(Akun Anda)</span>
              <?php endif; ?>
            </td>
          </tr>
        <?php endforeach; endif; ?>
      </tbody>
    </table>
  </div>
</div>
