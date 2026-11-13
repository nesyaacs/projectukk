<?php
// Form tambah / edit buku (admin)
$pilihan_kategori = ['' => '-- Pilih Kategori --'];
foreach ($kategori as $kat) {
    $pilihan_kategori[$kat['id_kategori']] = $kat['nama_kategori'];
}
?>
<div class="card">
  <div class="card-header">
    <div class="card-title">
      <?= $edit ? bi('pencil', 16) . ' Edit Data Buku' : bi('plus', 16) . ' Tambah Koleksi Buku Baru'; ?>
    </div>
    <?php if ($edit): ?>
      <a href="buku.php" class="btn btn-outline btn-sm">Batal Edit</a>
    <?php endif; ?>
  </div>

  <form action="buku.php" method="POST" enctype="multipart/form-data">
    <?php if ($edit): ?>
      <input type="hidden" name="id_buku" value="<?= $edit['id_buku']; ?>">
    <?php endif; ?>

    <div class="form-row">
      <?php
      input_form('Kode Buku *', 'kode_buku', $edit['kode_buku'] ?? '', [
          'wajib' => true, 'placeholder' => 'Contoh: BK-RPL-007',
      ]);
      input_form('Judul Buku *', 'judul', $edit['judul'] ?? '', [
          'wajib' => true, 'placeholder' => 'Judul buku',
      ]);
      ?>
    </div>

    <div class="form-row">
      <?php
      select_form('Kategori Buku *', 'id_kategori', $pilihan_kategori, $edit['id_kategori'] ?? 0, ['wajib' => true]);
      input_form('Pengarang / Penulis *', 'pengarang', $edit['pengarang'] ?? '', [
          'wajib' => true, 'placeholder' => 'Nama penulis',
      ]);
      ?>
    </div>

    <div class="form-row">
      <?php
      input_form('Penerbit *', 'penerbit', $edit['penerbit'] ?? '', [
          'wajib' => true, 'placeholder' => 'Penerbit',
      ]);
      input_form('Tahun Terbit *', 'tahun_terbit', $edit['tahun_terbit'] ?? date('Y'), [
          'tipe' => 'number', 'wajib' => true, 'min' => 1990, 'max' => 2099,
      ]);
      ?>
    </div>

    <div class="form-row">
      <?php
      input_form('Nomor ISBN', 'isbn', $edit['isbn'] ?? '', ['placeholder' => '978-...']);
      input_form('Lokasi Rak *', 'lokasi_rak', $edit['lokasi_rak'] ?? 'Rak A1', [
          'wajib' => true, 'placeholder' => 'Contoh: Rak A1',
      ]);
      ?>
    </div>

    <div class="form-row">
      <?php
      input_form('Jumlah Total Stok *', 'jumlah_buku', $edit['jumlah_buku'] ?? 5, [
          'tipe' => 'number', 'wajib' => true, 'min' => 1,
      ]);
      if ($edit) {
          input_form('Sisa Stok Tersedia *', 'sisa_buku', $edit['sisa_buku'] ?? 5, [
              'tipe' => 'number', 'wajib' => true, 'min' => 0,
          ]);
      }
      ?>
    </div>

    <?php textarea_form('Sinopsis / Deskripsi Singkat', 'deskripsi', $edit['deskripsi'] ?? '', [
        'placeholder' => 'Ringkasan isi buku...',
    ]); ?>

    <?php input_form('Foto / Gambar Cover Buku', 'gambar', '', [
        'tipe' => 'file', 'extra' => 'accept="image/png, image/jpeg, image/jpg, image/webp, image/svg+xml"',
        'bantuan' => 'Format: JPG, JPEG, PNG, WEBP, SVG (Maksimal 2 MB). Opsional — biarkan kosong jika tidak ingin mengubah cover.',
    ]); ?>

    <?php if ($edit): ?>
      <input type="hidden" name="gambar_lama" value="<?= e($edit['gambar'] ?? 'default-book.svg'); ?>">
      <?php if (!empty($edit['gambar'])): ?>
        <div style="margin-top: 10px; display: flex; align-items: center; gap: 12px; background: var(--primary-subtle); padding: 8px 14px; border-radius: 6px; border: 1px solid var(--primary-border);">
          <img src="assets/uploads/<?= e($edit['gambar']); ?>" alt="Cover Saat Ini" style="width: 44px; height: 58px; object-fit: cover; border-radius: 4px; border: 1px solid var(--primary-border);" onerror="this.src='assets/uploads/default-book.svg';">
          <div>
            <div style="font-size: 0.82rem; font-weight: 600; color: var(--primary-dark);">Cover Aktif Saat Ini: <code><?= e($edit['gambar']); ?></code></div>
            <div style="font-size: 0.74rem; color: var(--text-muted);">Pilih file baru di atas jika ingin mengganti gambar cover ini.</div>
          </div>
        </div>
      <?php endif; ?>
    <?php endif; ?>

    <div id="coverPreviewContainer" style="display: none; margin-top: 10px; align-items: center; gap: 12px; background: #ffffff; padding: 8px 14px; border-radius: 6px; border: 1px dashed var(--primary);">
      <img id="coverPreviewImg" src="" alt="Pratinjau Cover" style="width: 44px; height: 58px; object-fit: cover; border-radius: 4px; border: 1px solid var(--border);">
      <div>
        <div style="font-size: 0.82rem; font-weight: 600; color: var(--primary);">Pratinjau Cover Baru yang Dipilih</div>
        <div id="coverPreviewName" style="font-size: 0.74rem; color: var(--text-muted);"></div>
      </div>
    </div>

    <div style="margin-top: 10px;">
      <?php if ($edit): ?>
        <button type="submit" name="edit_buku" class="btn btn-warning">
          <?= bi('pencil', 14); ?> Simpan Perubahan Buku
        </button>
      <?php else: ?>
        <button type="submit" name="tambah_buku" class="btn btn-primary">
          <?= bi('plus', 14); ?> Tambahkan Buku Baru
        </button>
      <?php endif; ?>
    </div>
  </form>
</div>
