<?php
// Upload cover buku: nama file baru, nama lama, false (gagal), atau null (format salah)
function upload_cover($field, $old = 'default-book.svg') {
    if (!isset($_FILES[$field]) || $_FILES[$field]['error'] === UPLOAD_ERR_NO_FILE) {
        return $old;
    }
    if ($_FILES[$field]['error'] !== UPLOAD_ERR_OK) {
        return false;
    }

    $file = $_FILES[$field];
    $ext  = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));

    if (!in_array($ext, ['jpg', 'jpeg', 'png', 'webp', 'svg'])) {
        return null;
    }
    if ($file['size'] > 2097152) {
        return false;
    }

    $nama_baru = 'cover_' . date('Ymd_His') . '_' . substr(md5(uniqid()), 0, 6) . '.' . $ext;
    $folder    = __DIR__ . '/../assets/uploads/';

    if (!move_uploaded_file($file['tmp_name'], $folder . $nama_baru)) {
        return $old;
    }

    hapus_cover($old);
    return $nama_baru;
}

// Hapus cover buatan admin (file bawaan tidak disentuh)
function hapus_cover($nama) {
    if ($nama && strpos($nama, 'cover_') === 0) {
        $file = __DIR__ . '/../assets/uploads/' . $nama;
        if (file_exists($file)) {
            @unlink($file);
        }
    }
}
