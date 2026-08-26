# Laporan Detail Perubahan Fitur Supply Chain & Purchase Order (Agustus 2026)

Laporan ini berisi rincian seluruh file baru yang ditambahkan dan file lama yang dimodifikasi untuk memenuhi fitur:
1. Pengunduran Diri Vendor dari Purchase Order (PO).
2. Pembuatan Tender Ulang dari PO yang vendor-nya mengundurkan diri.
3. Pencatatan rekam jejak pembuat ("Dibuat Oleh") pada Tender dan PO.
4. Pembuatan dokumen PDF untuk Purchase Order.

---

## 🆕 FILE BARU (NEW FILES)

File-file berikut adalah file yang **baru dibuat** pada pembaruan ini:

### 1. Database Migrations
*   **`database/migrations/2026_08_10_010000_add_pengunduran_diri_and_dibuat_oleh_to_purchase_orders_table.php`**
    *   **Fungsi:** Menambahkan kolom `dibuat_oleh` (foreign key ke users), `tanggal_pengunduran_diri` (timestamp), `alasan_pengunduran_diri` (text), dan menambahkan status `'vendor_mundur'` pada enum status PO.
*   **`database/migrations/2026_08_10_010001_add_dibuat_oleh_and_tender_induk_to_tenders_table.php`**
    *   **Fungsi:** Menambahkan kolom `dibuat_oleh` (foreign key ke users) dan `tender_induk_id` (foreign key referensi ke table tenders itu sendiri untuk tracking tender ulang).

### 2. Controllers
*   **`app/Http/Controllers/SupplyChain/PurchaseOrderPdfController.php`**
    *   **Fungsi:** Controller khusus untuk menangani proses *generate* dan *download* file PDF Purchase Order menggunakan library `Barryvdh\DomPDF\Facade\Pdf`.

### 3. Views (Blade Templates)
*   **`resources/views/supply-chain/purchase-orders/pdf.blade.php`**
    *   **Fungsi:** Template HTML dan CSS untuk mencetak data PO ke dalam bentuk dokumen PDF. Termasuk di dalamnya kop surat perusahaan, tabel item material, total harga dengan fungsi *terbilang* dinamis, serta kolom tanda tangan.

---

## 🔄 FILE YANG DIMODIFIKASI (MODIFIED FILES)

File-file lama berikut ini **telah diubah atau ditambahkan kodenya** untuk mendukung fitur baru:

### 1. Models
*   **`app/Models/PurchaseOrder.php`**
    *   Menambahkan kolom baru ke `$fillable`.
    *   Menambahkan relasi `pembuatPo()` (ke model User).
    *   Menambahkan relasi `tenderInduk()` dan `tenderPengganti()` (melalui model Tender).
    *   Menambahkan fungsi logika (helper) `canVendorWithdraw()` dan `isVendorMundur()`.
*   **`app/Models/Tender.php`**
    *   Menambahkan kolom baru ke `$fillable`.
    *   Menambahkan relasi `pembuatTender()` (ke model User).
    *   Menambahkan relasi `tenderInduk()` dan `tenderPengganti()`.
*   **`app/Models/User.php`**
    *   Menambahkan relasi `tendersDibuat()` (HasMany ke Tender).
    *   Menambahkan relasi `purchaseOrdersDibuat()` (HasMany ke PurchaseOrder).

### 2. Routes
*   **`routes/web.php`**
    *   Tambah route `POST` untuk SC Buat Tender Ulang.
    *   Tambah route `GET` untuk SC download PDF PO.
    *   Tambah route `POST` untuk Vendor Mengundurkan Diri.
    *   Tambah route `GET` untuk Vendor download PDF PO.

### 3. Controllers
*   **`app/Http/Controllers/SupplyChain/TenderController.php`**
    *   Method `store()`: Menyimpan ID user (SC) ke kolom `dibuat_oleh` dan menyimpan `tender_induk_id` dari session. Session kemudian dihapus setelah berhasil simpan.
    *   Method `index()` dan `show()`: Melakukan *Eager Loading* (`with('pembuatTender')`) agar tampilan daftar tender lebih optimal.
*   **`app/Http/Controllers/SupplyChain/PurchaseOrderController.php`**
    *   Method `store()`: Menyimpan ID user (SC) ke kolom `dibuat_oleh`.
    *   Method `index()` dan `show()`: Melakukan *Eager Loading* (`with('pembuatPo')`).
    *   **Method Baru (`buatTenderUlang`)**: Menangani validasi dan *redirect* dengan session ID tender lama ke halaman pembuatan tender baru.
*   **`app/Http/Controllers/Vendor/PurchaseOrderController.php`**
    *   **Method Baru (`mundur`)**: Memproses aksi pengunduran diri vendor, menyimpan tanggal & alasan, merubah status, dan mengirimkan notifikasi Firebase ke divisi Supply Chain & Gudang.
    *   **Method Baru (`unduhDokumenPo`)**: Mengatur proses download PDF untuk role Vendor (memvalidasi agar vendor hanya bisa download PO miliknya).
    *   Method `ship()`: Ditambahkan pengecekan agar jika status vendor sudah mundur, proses pengiriman barang tidak bisa dilakukan.

### 4. Views (Blade Templates)
#### Supply Chain (SC)
*   **`resources/views/supply-chain/tenders/index.blade.php`**
    *   Menambah kolom tabel **"Dibuat Oleh"**.
*   **`resources/views/supply-chain/tenders/show.blade.php`**
    *   Menambah field informasi **"Dibuat Oleh"**.
    *   Menambah banner notifikasi **"Tender Ulang"** (jika tender tersebut adalah hasil dari tender ulang) dan **"Tender Pengganti"** (jika sudah ada tender baru dari tender tersebut).
*   **`resources/views/supply-chain/tenders/create.blade.php`**
    *   Menambah input *hidden* `tender_induk_id` yang ditarik dari *session*.
    *   Menambah alert banner kuning yang memberitahu SC bahwa ia sedang membuat "Tender Ulang".
*   **`resources/views/supply-chain/purchase-orders/index.blade.php`**
    *   Menambah kolom tabel **"Dibuat Oleh"**.
    *   Menambah status badge merah peringatan **"⚠ Vendor Mundur"**.
*   **`resources/views/supply-chain/purchase-orders/show.blade.php`**
    *   Menambah field **"Dibuat Oleh"**.
    *   Menambah banner merah notifikasi detail alasan vendor mengundurkan diri.
    *   Menambahkan tombol **"Buat Tender Ulang"** beserta modal konfirmasinya.
    *   Menambahkan tombol **"Unduh Dokumen PO"**.

#### Vendor
*   **`resources/views/vendor/purchase-orders/show.blade.php`**
    *   Menambahkan tombol **"Mengundurkan Diri"** yang hanya aktif jika status masih dikirim ke vendor.
    *   Menambahkan modal konfirmasi dengan *textarea* wajib untuk mengisi alasan pengunduran diri (minimal 10 karakter).
    *   Menambahkan banner merah jika vendor telah mengundurkan diri.
    *   Menambahkan tombol **"Unduh Dokumen PO"**.

---
*Laporan ini dihasilkan secara otomatis dari hasil implementasi sistem pada Agustus 2026.*
