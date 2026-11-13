<?php
// Kartu laporan siap cetak
?>
<div class="card">
  <div class="print-header" style="text-align: center; border-bottom: 2px solid var(--primary); padding-bottom: 12px; margin-bottom: 16px;">
    <h2 style="font-size: 1.35rem; text-transform: uppercase; margin-bottom: 4px;">
      LAPORAN SIRKULASI PEMINJAMAN BUKU PERPUSTAKAAN DIGITAL
    </h2>
    <p style="font-size: 0.9rem; color: var(--text-muted); margin: 0;">
      SMK Negeri 3 Kendal • Program Keahlian Rekayasa Perangkat Lunak (RPL)
    </p>
    <p style="font-size: 0.82rem; color: var(--text-muted); margin: 3px 0 0 0;">
      Periode: <strong><?= tgl($awal); ?></strong> s/d <strong><?= tgl($akhir); ?></strong>
      <?= $status ? ' | Status: <strong>' . ucfirst($status) . '</strong>' : ''; ?>
    </p>
  </div>

  <div class="stats-grid no-print" style="margin-bottom: 20px;">
    <div class="stat-card" style="padding: 12px 16px;">
      <div class="stat-info"><h3><?= $total_trx; ?></h3><p>Total Transaksi</p></div>
    </div>
    <div class="stat-card" style="padding: 12px 16px;">
      <div class="stat-info"><h3><?= $jumlah['dipinjam']; ?></h3><p>Masih Dipinjam</p></div>
    </div>
    <div class="stat-card" style="padding: 12px 16px;">
      <div class="stat-info"><h3><?= $jumlah['dikembalikan']; ?></h3><p>Telah Dikembalikan</p></div>
    </div>
    <div class="stat-card" style="padding: 12px 16px;">
      <div class="stat-info"><h3><?= rp($total_denda); ?></h3><p>Total Denda Masuk</p></div>
    </div>
  </div>

  <div class="print-summary" style="display: none;">
    <table>
      <tr>
        <td><strong>Total Transaksi:</strong> <?= $total_trx; ?> Data</td>
        <td><strong>Sedang Dipinjam:</strong> <?= $jumlah['dipinjam']; ?></td>
        <td><strong>Telah Kembali:</strong> <?= $jumlah['dikembalikan']; ?></td>
        <td><strong>Menunggu:</strong> <?= $jumlah['menunggu']; ?></td>
        <td><strong>Ditolak:</strong> <?= $jumlah['ditolak']; ?></td>
        <td><strong>Total Denda:</strong> <?= rp($total_denda); ?></td>
      </tr>
    </table>
  </div>

  <div class="table-responsive">
    <table>
      <thead>
        <tr>
          <th style="width: 4%;">No</th>
          <th style="width: 13%;">Kode Transaksi</th>
          <th style="width: 16%;">Nama Siswa (NIS)</th>
          <th style="width: 8%;">Kelas</th>
          <th style="width: 23%;">Judul Buku</th>
          <th style="width: 9%;">Tgl Pinjam</th>
          <th style="width: 9%;">Jatuh Tempo</th>
          <th style="width: 9%;">Tgl Kembali</th>
          <th style="width: 9%;">Denda</th>
          <th style="width: 9%;">Status</th>
        </tr>
      </thead>
      <tbody>
        <?php if (!$data): ?>
          <?php baris_kosong(10, 'Tidak ada data transaksi pada rentang periode ini.'); ?>
        <?php else: $no = 1; foreach ($data as $trx): ?>
          <tr>
            <td style="text-align: center;"><?= $no++; ?></td>
            <td><code><?= e($trx['kode_transaksi']); ?></code></td>
            <td>
              <strong><?= e($trx['nama_lengkap']); ?></strong><br>
              <small class="text-muted"><?= e($trx['nis_nip']); ?></small>
            </td>
            <td style="text-align: center;"><?= e($trx['kelas'] ?? '-'); ?></td>
            <td><?= e($trx['judul']); ?></td>
            <td style="text-align: center;"><?= tgl($trx['tgl_pinjam']); ?></td>
            <td style="text-align: center;"><?= tgl($trx['tgl_jatuh_tempo']); ?></td>
            <td style="text-align: center;"><?= tgl($trx['tgl_kembali']); ?></td>
            <td style="text-align: right;"><?= $trx['denda'] > 0 ? rp($trx['denda']) : 'Rp 0'; ?></td>
            <td style="text-align: center;"><?php badge($trx['status']); ?></td>
          </tr>
        <?php endforeach; endif; ?>
      </tbody>
    </table>
  </div>

  <div class="signature-box" style="margin-top: 35px; display: flex; justify-content: flex-end; text-align: center;">
    <div style="width: 220px;">
      <p style="font-size: 0.85rem; margin-bottom: 55px;">
        Kota Sekolah, <?= date('d F Y'); ?><br>
        Kepala Perpustakaan / Petugas,
      </p>
      <p style="font-weight: bold; text-decoration: underline; margin-bottom: 2px;">
        <?= e($_SESSION['nama_lengkap']); ?>
      </p>
      <p style="font-size: 0.8rem; color: var(--text-muted); margin: 0;">
        NIP. <?= e($_SESSION['nis_nip']); ?>
      </p>
    </div>
  </div>
</div>
