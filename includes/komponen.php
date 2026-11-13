<?php
// Komponen tampilan yang dipakai berulang di banyak halaman

// Hero / judul halaman
function hero($ikon, $judul, $teks = '', $aksi = '', $kelas = 'page-hero hero-compact') {
    echo '<div class="' . $kelas . '">';
    echo '<h2>' . bi($ikon, 24) . ' ' . $judul . '</h2>';
    if ($teks !== '') {
        echo '<p>' . $teks . '</p>';
    }
    if ($aksi !== '') {
        echo '<div style="margin-top: 15px; display: flex; gap: 10px; flex-wrap: wrap;">' . $aksi . '</div>';
    }
    echo '</div>';
}

// Grid kartu statistik: [[ikon, angka, label], ...]
function kartu_statistik($stat) {
    echo '<div class="stats-grid">';
    foreach ($stat as [$ikon, $jumlah, $label]) {
        echo '<div class="stat-card">';
        echo '<div class="stat-icon">' . bi($ikon, 24) . '</div>';
        echo '<div class="stat-info"><h3>' . $jumlah . '</h3><p>' . $label . '</p></div>';
        echo '</div>';
    }
    echo '</div>';
}

// Baris kosong pada tabel
function baris_kosong($colspan, $pesan, $kelas = 'td-kosong') {
    echo '<tr><td colspan="' . $colspan . '" class="' . $kelas . '">' . $pesan . '</td></tr>';
}

// Badge status (teks sekaligus nama kelas badge)
function badge($teks) {
    echo '<span class="badge badge-' . $teks . '">' . e($teks) . '</span>';
}

// Input teks / angka / tanggal / password / file
function input_form($label, $nama, $nilai = '', $opsi = []) {
    $tipe = $opsi['tipe'] ?? 'text';
    $id   = $opsi['id'] ?? $nama;
    $attr = ' class="form-control"';

    if (!empty($opsi['wajib']))       $attr .= ' required';
    if (!empty($opsi['baca']))        $attr .= ' readonly data-unlock';
    if (isset($opsi['autocomplete'])) $attr .= ' autocomplete="' . $opsi['autocomplete'] . '"';
    if (isset($opsi['placeholder']))  $attr .= ' placeholder="' . $opsi['placeholder'] . '"';
    if (isset($opsi['min']))          $attr .= ' min="' . $opsi['min'] . '"';
    if (isset($opsi['max']))          $attr .= ' max="' . $opsi['max'] . '"';
    if (!empty($opsi['extra']))       $attr .= ' ' . $opsi['extra'];

    echo '<div class="form-group">';
    echo '<label class="form-label" for="' . $id . '">' . $label . '</label>';
    echo '<input type="' . $tipe . '" name="' . $nama . '" id="' . $id . '"' . $attr;
    echo $tipe === 'file' ? '>' : ' value="' . e($nilai) . '">';
    if (!empty($opsi['bantuan'])) {
        echo '<small class="text-muted">' . $opsi['bantuan'] . '</small>';
    }
    echo '</div>';
}

// Textarea
function textarea_form($label, $nama, $nilai = '', $opsi = []) {
    $id = $opsi['id'] ?? $nama;
    echo '<div class="form-group">';
    echo '<label class="form-label" for="' . $id . '">' . $label . '</label>';
    echo '<textarea name="' . $nama . '" id="' . $id . '" rows="' . ($opsi['baris'] ?? 2) . '" class="form-control"';
    if (isset($opsi['placeholder'])) echo ' placeholder="' . $opsi['placeholder'] . '"';
    echo '>' . e($nilai) . '</textarea>';
    echo '</div>';
}

// Select (pilihan berupa array nilai => teks)
function select_form($label, $nama, $pilihan, $terpilih = '', $opsi = []) {
    $id = $opsi['id'] ?? $nama;
    echo '<div class="form-group">';
    echo '<label class="form-label" for="' . $id . '">' . $label . '</label>';
    echo '<select name="' . $nama . '" id="' . $id . '" class="form-control"';
    echo !empty($opsi['wajib']) ? ' required>' : '>';
    foreach ($pilihan as $nilai => $teks) {
        $selected = (string)$nilai === (string)$terpilih ? ' selected' : '';
        echo '<option value="' . e($nilai) . '"' . $selected . '>' . e($teks) . '</option>';
    }
    echo '</select></div>';
}
