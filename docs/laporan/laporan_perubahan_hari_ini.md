# Laporan Lengkap Seluruh Perubahan Fitur SC & Vendor (Hari Ini)

Dokumen ini merangkum *keseluruhan* perubahan file, database, controller, dan antarmuka pengguna (UI) yang telah dilakukan pada sistem pengadaan material kapal pada hari ini, baik pada sesi awal (fitur pengunduran diri vendor & tender ulang) maupun pada sesi lanjutan (optimasi UI dan pengisian harga satuan per item).

---

## BAGIAN I: FITUR PENGUNDURAN DIRI VENDOR & TENDER ULANG

Pada bagian ini, sistem ditambahkan kemampuannya untuk menangani kasus vendor yang mengundurkan diri setelah menerima Purchase Order (PO), serta kemampuan bagi Supply Chain (SC) untuk mencatat pembuat dokumen dan merilis tender ulang.

### 1. Database Migrations
*   **`..._add_pengunduran_diri_and_dibuat_oleh_to_purchase_orders_table.php`**
    *   Menambahkan kolom `dibuat_oleh` (ID SC pembuat PO), `tanggal_pengunduran_diri`, `alasan_pengunduran_diri`, serta menambah enum status PO `'vendor_mundur'`.
*   **`..._add_dibuat_oleh_and_tender_induk_to_tenders_table.php`**
    *   Menambahkan kolom `dibuat_oleh` dan `tender_induk_id` (untuk *tracking* tender mana yang merupakan hasil tender ulang).

### 2. Controllers & Models
*   **`app/Models/PurchaseOrder.php` & `Tender.php` & `User.php`**
    *   Menambahkan relasi-relasi (seperti `pembuatPo()`, `tenderInduk()`, `tenderPengganti()`) serta menambahkan helper logic pengecekan status mundur.
*   **`app/Http/Controllers/Vendor/PurchaseOrderController.php`**
    *   **Fitur Pengunduran Diri:** Menambahkan *method* `mundur` untuk memproses alasan pengunduran diri vendor dan mengubah status PO.
    *   **Fitur Dokumen PDF:** Menambahkan *method* `unduhDokumenPo` bagi vendor.
*   **`app/Http/Controllers/SupplyChain/PurchaseOrderController.php`**
    *   **Fitur Tender Ulang:** Menambahkan *method* `buatTenderUlang` yang mengunci tender lama, dan meneruskan `tender_induk_id` ke sesi pembuatan tender baru.
*   **`app/Http/Controllers/SupplyChain/TenderController.php`**
    *   Mencatat `dibuat_oleh` ke *database* dan menarik `tender_induk_id` saat form pembuatan tender disimpan.
*   **`app/Http/Controllers/SupplyChain/PurchaseOrderPdfController.php`**
    *   Pembuatan controller khusus menggunakan *library DomPDF* untuk menghasilkan (generate) dokumen cetak PO (PDF).

### 3. Perubahan Antarmuka (UI) - Bagian I
*   **Vendor PO Detail:** 
    *   Menambahkan pop-up modal "Pengunduran Diri" yang berisi formulir wajib (alasan minimum 10 karakter).
    *   Menambahkan peringatan banner warna merah jika vendor sudah berstatus mundur.
    *   Menambahkan tombol "Unduh Dokumen PO".
*   **Supply Chain PO Detail:**
    *   Menambahkan *badge* status "⚠ Vendor Mundur".
    *   Menampilkan pop-up peringatan berwarna merah jika vendor mengundurkan diri beserta alasannya.
    *   Menambahkan pop-up modal "Buat Tender Ulang" yang akan diarahkan langsung ke halaman pembuatan tender baru dengan indikator visual (banner peringatan tender ulang).
    *   Menambahkan tombol "Unduh Dokumen PO".


---

## BAGIAN II: OPTIMASI HARGA SATUAN (PER ITEM) & DASHBOARD UI

Pada bagian ini, dilakukan pembaruan struktur pengisian penawaran harga vendor yang sebelumnya *lumpsum* (digabung) menjadi per-item, serta penyesuaian estetika tampilan Dashboard SC.

### 1. Perubahan Basis Data & Model Harga Satuan
*   **`database/migrations/..._create_penawaran_vendor_items_table.php`**
    *   Tabel baru `penawaran_vendor_items` untuk menyimpan harga per item secara terpisah.
*   **`app/Models/VendorQuotationItem.php`**
    *   Model representasi tabel baru untuk relasi barang, kuantitas, subtotal, dan `VendorQuotation`.

### 2. Logika Backend (Controllers) - Bagian II
*   **`app/Http/Controllers/Vendor/TenderController.php`**
    *   Menerima form array *items* harga, menghitung subtotal masing-masing, menyimpan detail ke dalam `penawaran_vendor_items`, dan mengotomatiskan jumlah *Total Harga Penawaran*.
*   **`app/Http/Controllers/SupplyChain/PurchaseOrderController.php`**
    *   Logika pembuatan PO (PurchaseOrderItem) tidak lagi merata-ratakan harga keseluruhan. Sistem secara spesifik menarik "Harga Satuan Asli" milik vendor, dan menerapkan perhitungan matematis "Discount Factor" jika terdapat harga negosiasi sehingga penurunan harganya menjadi akurat/pro-rata untuk semua barang.

### 3. Perubahan Antarmuka (UI) - Bagian II
*   **Detail Penawaran Vendor (`resources/views/vendor/tenders/show.blade.php`)**
    *   Kolom isian harga dirombak secara total menjadi deretan pengisian harga **per item** barang yang diajukan.
    *   Terdapat kalkulator *JavaScript* interaktif yang memunculkan nominal format Rupiah (Subtotal dan Total Penawaran) langsung secara statis saat angka diketik oleh vendor.
*   **Dashboard & Navigasi Supply Chain**
    *   Menambahkan dokumen referensi anggaran "Total RAB", serta dokumen unduhan RAB & Perizinan di halaman Detail Permintaan Material SC.
    *   Menghilangkan icon di bar navigasi untuk menu "Monitoring" dan "Daftar Purchase Order" agar lebih minimalis.
    *   Merombak baris bawah `supply.blade.php` (Dashboard SC): Mengubah *card* "Monitoring" menjadi setengah lebar dan menempatkan satu *card* baru **"Daftar Purchase Order"** tepat di sebelahnya (menggunakan tema warna *emerald*) untuk penyelarasan *user experience* (UX).

---

**Status Keseluruhan:** Seluruh penambahan dari dua sesi perbaikan (Pengunduran Diri/Tender Ulang, Manajemen PDF, Harga Per Item, dan Perbaikan Dashboard) sudah selesai divalidasi dan berjalan sepenuhnya pada sistem hari ini.
