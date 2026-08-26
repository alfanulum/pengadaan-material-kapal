# Inventaris Halaman Wireframe – PT PAL Pengadaan Material Kapal

> **Terakhir diperbarui:** 2026-08-11
> **Total halaman:** 55
> **Sumber:** Analisis source code Laravel (`routes/web.php` + `resources/views/`)
> **Layout Figma:** 4 kolom per role, section label per grup role

---

## ⚠️ Catatan Penting

- ❌ **Registrasi user umum (`/register`) DIHAPUS** — fitur sudah dihilangkan dari aplikasi (tombol "Daftar sekarang" di login sudah dihapus dari `auth/login.blade.php`)
- ✅ **Registrasi Vendor Mandiri (`/vendor/register`) ADA** — vendor mendaftar sendiri, diverifikasi SC
- Setiap role memiliki **duplikasi halaman Login** untuk keperluan prototype flow di Figma
- Dashboard Vendor terdapat **3 varian frame** sesuai kondisi status registrasi

---

## 📐 Struktur Layout di Figma

```
Canvas Figma:
┌─────────────────────────────────────────────────────────────────┐
│ — ENGINEER — (10 halaman)                                       │
│ [Login] [Dashboard] [MR Index] [MR Create]                      │
│ [MR Show] [MR Edit] [Clarif Index] [Clarif Show]                │
│ [Mon Index] [Mon Show]                                          │
│                                                                 │
│ — PLANNER — (4 halaman)                                         │
│ [Login] [Dashboard] [MR Index] [MR Show]                        │
│                                                                 │
│ — SUPPLY CHAIN — (23 halaman)                                   │
│ [Login] [Dashboard] [Vendor Index] [Vendor Create]              │
│ [Vendor Show] [Vendor Edit] [MR Index] [MR Show]                │
│ [Tender Index] [Tender Create] [Tender Show] [Neg Index]        │
│ [Neg Show] [PO Index] [PO Create] [PO Show]                     │
│ [GR Index] [GR Show] [GRR Index] [GRR Show]                     │
│ [Mon Index] [Mon Show] [Mon Edit]                               │
│                                                                 │
│ — VENDOR — (13 halaman)                                         │
│ [Welcome] [Daftar Vendor] [Login] [Dashboard-Waiting]           │
│ [Dashboard-Rejected] [Resubmit] [Dashboard-Approved] [Ten Index]│
│ [Ten Show] [Chat Clarif] [Chat Neg] [PO Index] [PO Show]       │
│                                                                 │
│ — GUDANG — (5 halaman)                                          │
│ [Login] [Dashboard] [GR Index] [GR Show] [GR Report]           │
└─────────────────────────────────────────────────────────────────┘
```

---

## 👷 ENGINEER (10 halaman)

| # | ID | Nama | Route | View |
|---|-----|------|-------|------|
| 1 | `login-engineer` | Login | `/login` | `auth/login.blade.php` |
| 2 | `dashboard-engineer` | Dashboard Engineer | `/engineer/dashboard` | `dashboards/engineer.blade.php` |
| 3 | `material-requests-index` | Daftar Pengajuan Material | `/material-requests` | `material-requests/index.blade.php` |
| 4 | `material-requests-create` | Buat Pengajuan Material | `/material-requests/create` | `material-requests/create.blade.php` |
| 5 | `material-requests-show` | Detail Pengajuan Material | `/material-requests/{id}` | `material-requests/show.blade.php` |
| 6 | `material-requests-edit` | Edit Pengajuan Material | `/material-requests/{id}/edit` | `material-requests/edit.blade.php` |
| 7 | `engineer-clarifications-index` | Daftar Klarifikasi Teknis | `/engineer/clarifications` | `engineer/clarifications/index.blade.php` |
| 8 | `engineer-clarification-show` | Chat Klarifikasi Teknis | `/engineer/clarifications/{tender}/{vendor}` | `engineer/clarifications/show.blade.php` |
| 9 | `engineer-monitoring-index` | Monitoring Kebutuhan Material | `/engineer/monitoring` | `engineer/monitoring/index.blade.php` |
| 10 | `engineer-monitoring-show` | Detail Monitoring Kebutuhan | `/engineer/monitoring/{id}` | `engineer/monitoring/show.blade.php` |

**Navbar Engineer:** Dashboard · Pengajuan Material · Klarifikasi Teknis · Monitoring

**Fitur kunci:**
- Buat, edit, hapus pengajuan material
- Chat klarifikasi spesifikasi teknis dengan vendor (lewat tender)
- Monitoring status pengadaan dari pengajuan hingga barang diterima
- Timeline visual progress pengadaan

---

## 📋 PLANNER (4 halaman)

| # | ID | Nama | Route | View |
|---|-----|------|-------|------|
| 1 | `login-planner` | Login | `/login` | `auth/login.blade.php` |
| 2 | `dashboard-planner` | Dashboard Planner | `/planner/dashboard` | `dashboards/planner.blade.php` |
| 3 | `planner-material-requests-index` | Daftar Verifikasi Pengajuan | `/planner/material-requests` | `planner/material-requests/index.blade.php` |
| 4 | `planner-material-requests-show` | Detail & Verifikasi Pengajuan | `/planner/material-requests/{id}` | `planner/material-requests/show.blade.php` |

**Navbar Planner:** Dashboard · Verifikasi Pengajuan

**Fitur kunci:**
- Melihat daftar pengajuan material dari Engineer
- Upload dokumen RAB dan perizinan
- Setujui / Tolak pengajuan dengan catatan
- Input Total RAB

---

## 🏭 SUPPLY CHAIN (23 halaman)

| # | ID | Nama | Route | View |
|---|-----|------|-------|------|
| 1 | `login-supply-chain` | Login | `/login` | `auth/login.blade.php` |
| 2 | `dashboard-supply-chain` | Dashboard Supply Chain | `/supply-chain/dashboard` | `dashboards/supply.blade.php` |
| 3 | `sc-vendors-index` | Kelola Vendor | `/supply-chain/vendors` | `supply-chain/vendors/index.blade.php` |
| 4 | `sc-vendors-create` | Tambah Vendor | `/supply-chain/vendors/create` | `supply-chain/vendors/create.blade.php` |
| 5 | `sc-vendors-show` | Detail Vendor & Verifikasi | `/supply-chain/vendors/{vendor}` | `supply-chain/vendors/show.blade.php` |
| 6 | `sc-vendors-edit` | Edit Vendor | `/supply-chain/vendors/{vendor}/edit` | `supply-chain/vendors/edit.blade.php` |
| 7 | `sc-material-requests-index` | Permintaan Material dari Planner | `/supply-chain/material-requests` | `supply-chain/material-requests/index.blade.php` |
| 8 | `sc-material-requests-show` | Detail Permintaan Material | `/supply-chain/material-requests/{id}` | `supply-chain/material-requests/show.blade.php` |
| 9 | `sc-tenders-index` | Daftar Tender | `/supply-chain/tenders` | `supply-chain/tenders/index.blade.php` |
| 10 | `sc-tenders-create` | Buat Tender | `/supply-chain/material-requests/{mr}/tenders/create` | `supply-chain/tenders/create.blade.php` |
| 11 | `sc-tenders-show` | Detail Tender | `/supply-chain/tenders/{tender}` | `supply-chain/tenders/show.blade.php` |
| 12 | `sc-chat-negosiasi-index` | Negosiasi – Daftar Vendor | `/supply-chain/tenders/{tender}/negotiation` | `supply-chain/chatnegosiasi/index.blade.php` |
| 13 | `sc-chat-negosiasi-show` | Chat Negosiasi | `/supply-chain/tenders/{tender}/negotiation/{vendor}` | `supply-chain/chatnegosiasi/show.blade.php` |
| 14 | `sc-purchase-orders-index` | Daftar Purchase Order | `/supply-chain/purchase-orders` | `supply-chain/purchase-orders/index.blade.php` |
| 15 | `sc-purchase-orders-create` | Buat Purchase Order | `/supply-chain/tenders/{tender}/purchase-orders/create` | `supply-chain/purchase-orders/create.blade.php` |
| 16 | `sc-purchase-orders-show` | Detail Purchase Order | `/supply-chain/purchase-orders/{purchaseOrder}` | `supply-chain/purchase-orders/show.blade.php` |
| 17 | `sc-goods-receipts-index` | Barang Masuk dari Gudang | `/supply-chain/goods-receipts` | `supply-chain/goods-receipts/index.blade.php` |
| 18 | `sc-goods-receipts-show` | Detail Penerimaan Barang | `/supply-chain/goods-receipts/{goodsReceipt}` | `supply-chain/goods-receipts/show.blade.php` |
| 19 | `sc-goods-receipt-reports-index` | Laporan Penerimaan Gudang | `/supply-chain/goods-receipt-reports` | `supply-chain/goods-receipt-reports/index.blade.php` |
| 20 | `sc-goods-receipt-reports-show` | Detail Laporan Penerimaan | `/supply-chain/goods-receipt-reports/{report}` | `supply-chain/goods-receipt-reports/show.blade.php` |
| 21 | `sc-monitoring-index` | Monitoring Pengadaan | `/supply-chain/monitoring` | `supply-chain/monitoring/index.blade.php` |
| 22 | `sc-monitoring-show` | Detail Monitoring | `/supply-chain/monitoring/{id}` | `supply-chain/monitoring/show.blade.php` |
| 23 | `sc-monitoring-edit` | Edit Monitoring | `/supply-chain/monitoring/{id}/edit` | `supply-chain/monitoring/edit.blade.php` |

**Navbar SC:** Dashboard · Vendor · Permintaan · Tender · Purchase Order · Laporan Penerimaan · Monitoring

**Fitur kunci:**
- Verifikasi registrasi vendor (setujui/tolak + alasan) di `sc-vendors-show`
- Chat negosiasi harga dengan vendor
- Pilih vendor pemenang tender → otomatis buat PO
- Tombol "Buat Tender Ulang" di `sc-purchase-orders-show` (jika vendor mundur dari PO)
- Konfirmasi atau Retur laporan penerimaan gudang
- Edit status monitoring pengadaan

---

## 🏢 VENDOR (13 halaman)

| # | ID | Nama | Route | View |
|---|-----|------|-------|------|
| 1 | `welcome` | Halaman Utama | `/` | `welcome.blade.php` |
| 2 | `vendor-register-page` | Daftar sebagai Vendor | `/vendor/register` | `auth/vendor-register.blade.php` |
| 3 | `login-vendor` | Login | `/login` | `auth/login.blade.php` |
| 4 | `dashboard-vendor-waiting` | Dashboard Vendor (Menunggu) | `/vendor/dashboard` | `dashboards/vendor.blade.php` |
| 5 | `dashboard-vendor-rejected` | Dashboard Vendor (Ditolak) | `/vendor/dashboard` | `dashboards/vendor.blade.php` |
| 6 | `vendor-resubmit` | Perbaiki Data Registrasi | `/vendor/resubmit` | `vendor/resubmit.blade.php` |
| 7 | `dashboard-vendor-approved` | Dashboard Vendor (Disetujui) | `/vendor/dashboard` | `dashboards/vendor.blade.php` |
| 8 | `vendor-tenders-index` | Daftar Tender | `/vendor/tenders` | `vendor/tenders/index.blade.php` |
| 9 | `vendor-tenders-show` | Detail Tender & Form Penawaran | `/vendor/tenders/{id}` | `vendor/tenders/show.blade.php` |
| 10 | `vendor-chat-clarification` | Chat Klarifikasi Spesifikasi | `/vendor/tenders/{inv}/chat` | `vendor/tenders/chat-clarification.blade.php` |
| 11 | `vendor-chat-negotiation` | Chat Negosiasi Harga | `/vendor/tenders/{inv}/chat-negotiation` | `vendor/tenders/chat-negotiation.blade.php` |
| 12 | `vendor-purchase-orders-index` | Daftar Purchase Order | `/vendor/purchase-orders` | `vendor/purchase-orders/index.blade.php` |
| 13 | `vendor-purchase-orders-show` | Detail Purchase Order | `/vendor/purchase-orders/{purchaseOrder}` | `vendor/purchase-orders/show.blade.php` |

**Navbar Vendor (disetujui):** Dashboard · Tender · Purchase Order

**Varian Dashboard:**
| Status | Frame ID | Deskripsi |
|--------|----------|-----------|
| Menunggu | `dashboard-vendor-waiting` | Akun menunggu verifikasi SC, tombol tidak tersedia |
| Ditolak | `dashboard-vendor-rejected` | Tampilkan alasan penolakan + tombol Perbaiki Data |
| Disetujui | `dashboard-vendor-approved` | Akses penuh: Tender, PO, Chat |

**Fitur kunci:**
- Registrasi mandiri sebagai vendor
- 3 varian dashboard sesuai status registrasi
- Perbaiki & kirim ulang data registrasi
- Chat klarifikasi teknis dengan Engineer
- Chat negosiasi harga dengan Supply Chain
- Kirim penawaran (harga, estimasi, file PDF)
- Tombol "Konfirmasi Pengiriman" di detail PO
- Tombol "Mundur dari PO" (jika belum dikirim)

---

## 🏗️ GUDANG (5 halaman)

| # | ID | Nama | Route | View |
|---|-----|------|-------|------|
| 1 | `login-gudang` | Login | `/login` | `auth/login.blade.php` |
| 2 | `dashboard-gudang` | Dashboard Gudang | `/gudang/dashboard` | `dashboards/gudang.blade.php` |
| 3 | `gudang-goods-receipts-index` | Daftar Penerimaan Barang | `/gudang/goods-receipts` | `gudang/goods-receipts/index.blade.php` |
| 4 | `gudang-goods-receipts-show` | Form Terima Barang | `/gudang/goods-receipts/{purchaseOrder}` | `gudang/goods-receipts/show.blade.php` |
| 5 | `gudang-goods-receipts-report` | Laporan Penerimaan | `/gudang/goods-receipts/report/{receipt}` | `gudang/goods-receipts/report.blade.php` |

**Navbar Gudang:** Dashboard · Penerimaan Barang

**Fitur kunci:**
- Stat cards ringkasan (menunggu, diterima, bermasalah, tindak lanjut)
- Form penerimaan: input qty diterima, kondisi, catatan, upload foto
- Image gallery placeholder (3 slot foto)
- Laporan penerimaan lengkap (dikirim ke SC untuk dikonfirmasi/retur)

---

## 📊 Ringkasan Statistik

| Role | Jumlah Halaman | Baris (4 col) |
|------|---------------|---------------|
| Engineer | 10 | 3 baris (4+4+2) |
| Planner | 4 | 1 baris (4) |
| Supply Chain | 23 | 6 baris (4+4+4+4+4+3) |
| Vendor | 13 | 4 baris (4+4+4+1) |
| Gudang | 5 | 2 baris (4+1) |
| **Total** | **55** | **16 baris** |
