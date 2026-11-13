/**
 * ============================================================
 * JAVASCRIPT PERPUSTAKAAN DIGITAL (TEMA: SOLID LIGHT BLUE)
 * FILE: assets/js/script.js
 * FUNGSI: Interaktivitas Client-Side, Filter Pencarian Live, 
 *         Validasi Tanggal Pinjam/Kembali, Modal & Konfirmasi
 * ============================================================
 */

document.addEventListener("DOMContentLoaded", function () {
  // 1. Toggle Menu Navigasi di Mobile
  const toggleBtn = document.getElementById("navToggle");
  const navMenu = document.getElementById("navMenu");
  if (toggleBtn && navMenu) {
    toggleBtn.addEventListener("click", function () {
      navMenu.classList.toggle("open");
    });
  }

  // 2. Auto-close Alert setelah 4 detik
  const alerts = document.querySelectorAll(".alert");
  alerts.forEach(function (alert) {
    setTimeout(function () {
      alert.style.transition = "opacity 0.5s ease";
      alert.style.opacity = "0";
      setTimeout(() => alert.remove(), 500);
    }, 4000);
  });

  // 3. Live Search Tabel (Pencarian Instan pada Tabel)
  const searchInput = document.getElementById("tableSearch");
  if (searchInput) {
    searchInput.addEventListener("keyup", function () {
      const keyword = searchInput.value.toLowerCase();
      const tableRows = document.querySelectorAll(".live-table tbody tr");

      tableRows.forEach(function (row) {
        const text = row.textContent.toLowerCase();
        if (text.includes(keyword)) {
          row.style.display = "";
        } else {
          row.style.display = "none";
        }
      });
    });
  }

  // 4. Live Search Katalog Buku (Tampilan Card Grid)
  const bookSearchInput = document.getElementById("bookCatalogSearch");
  if (bookSearchInput) {
    bookSearchInput.addEventListener("keyup", function () {
      const keyword = bookSearchInput.value.toLowerCase();
      const bookCards = document.querySelectorAll(".book-grid .book-card");

      bookCards.forEach(function (card) {
        const text = card.textContent.toLowerCase();
        if (text.includes(keyword)) {
          card.style.display = "flex";
        } else {
          card.style.display = "none";
        }
      });
    });
  }

  // 5. Otomatis Hitung Tanggal Jatuh Tempo (7 Hari dari Tanggal Pinjam)
  const tglPinjamInput = document.getElementById("tgl_pinjam");
  const tglJatuhTempoInput = document.getElementById("tgl_jatuh_tempo");
  if (tglPinjamInput && tglJatuhTempoInput) {
    tglPinjamInput.addEventListener("change", function () {
      if (tglPinjamInput.value) {
        const pinjamDate = new Date(tglPinjamInput.value);
        // Tambahkan 7 hari
        pinjamDate.setDate(pinjamDate.getDate() + 7);

        const yyyy = pinjamDate.getFullYear();
        const mm = String(pinjamDate.getMonth() + 1).padStart(2, "0");
        const dd = String(pinjamDate.getDate()).padStart(2, "0");

        tglJatuhTempoInput.value = `${yyyy}-${mm}-${dd}`;
      }
    });
  }

  // 6. Pratinjau Gambar Cover Buku Instan (Client-Side File Reader)
  const fileInput = document.getElementById("gambar");
  const previewBox = document.getElementById("coverPreviewContainer");
  const previewImg = document.getElementById("coverPreviewImg");
  const previewName = document.getElementById("coverPreviewName");

  if (fileInput && previewBox && previewImg) {
    fileInput.addEventListener("change", function () {
      const file = fileInput.files[0];
      if (file) {
        // Cek ukuran max 2MB
        if (file.size > 2 * 1024 * 1024) {
          alert("Peringatan: Ukuran file melebihi 2 MB! Harap pilih gambar yang lebih kecil.");
          fileInput.value = "";
          previewBox.style.display = "none";
          return;
        }

        const reader = new FileReader();
        reader.onload = function (e) {
          previewImg.src = e.target.result;
          if (previewName) {
            previewName.textContent = `${file.name} (${(file.size / 1024).toFixed(1)} KB)`;
          }
          previewBox.style.display = "flex";
        };
        reader.readAsDataURL(file);
      } else {
        previewBox.style.display = "none";
      }
    });
  }

  // 7. Cegah Browser Meng-Autofill Username & Password pada Form Tambah Anggota / Pendaftaran
  const formAnggotaBaru = document.querySelector('form[action="anggota.php"], form[action="daftar.php"]');
  if (formAnggotaBaru && !formAnggotaBaru.querySelector('input[name="id_user"]')) {
    const usnInput = formAnggotaBaru.querySelector('input[name="username"]');
    const pwdInput = formAnggotaBaru.querySelector('input[name="password"]');

    if (usnInput && pwdInput) {
      // Tandai jika pengguna mengetik secara manual
      usnInput.addEventListener("input", () => usnInput.setAttribute("data-manual", "true"));
      pwdInput.addEventListener("input", () => pwdInput.setAttribute("data-manual", "true"));

      // Kosongkan otomatisasi pengisian password oleh browser
      [50, 150, 300, 500].forEach(function (ms) {
        setTimeout(function () {
          if (!usnInput.hasAttribute("data-manual")) usnInput.value = "";
          if (!pwdInput.hasAttribute("data-manual")) pwdInput.value = "";
        }, ms);
      });
    }
  }

  // 8. Konfirmasi sebelum menjalankan aksi (pengganti onclick="return confirm(...)")
  document.addEventListener("click", function (event) {
    const el = event.target.closest("[data-confirm]");
    if (el && !confirm(el.dataset.confirm)) {
      event.preventDefault();
    }
  });

  // 9. Tombol cetak (pengganti onclick="window.print();")
  document.addEventListener("click", function (event) {
    const el = event.target.closest("[data-print]");
    if (el) {
      event.preventDefault();
      window.print();
    }
  });

  // 10. Lepas readonly saat input difokuskan (pengganti onfocus="this.removeAttribute('readonly')")
  document.addEventListener("focusin", function (event) {
    if (event.target.hasAttribute("data-unlock")) {
      event.target.removeAttribute("readonly");
    }
  });

  // 11. Tutup notifikasi alert (pengganti onclick="this.parentElement.remove();")
  document.addEventListener("click", function (event) {
    const tombol = event.target.closest(".alert-close");
    if (tombol) {
      tombol.parentElement.remove();
    }
  });
});

/**
 * Konfirmasi Hapus Data dengan Dialog Ramah
 * @param {string} url - Link tujuan hapus data
 * @param {string} namaData - Nama item yang akan dihapus
 */
function konfirmasiHapus(url, namaData) {
  const konfirmasi = confirm(
    `Konfirmasi Hapus\nApakah Anda yakin ingin menghapus data: "${namaData}"?\nData yang dihapus tidak dapat dikembalikan.`
  );
  if (konfirmasi) {
    window.location.href = url;
  }
}

/**
 * Modal Helper: Buka Modal
 */
function bukaModal(modalId) {
  const modal = document.getElementById(modalId);
  if (modal) {
    modal.classList.add("show");
  }
}

/**
 * Modal Helper: Tutup Modal
 */
function tutupModal(modalId) {
  const modal = document.getElementById(modalId);
  if (modal) {
    modal.classList.remove("show");
  }
}

