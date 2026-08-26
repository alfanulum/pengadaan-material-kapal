# Prototype Flow – PT PAL Wireframe

> **Terakhir diperbarui:** 2026-08-11
> Dokumen ini menggambarkan alur navigasi antar halaman per role.
> Prototype dibuat **dalam grup role masing-masing** (tidak ada link silang antar role).

---

## ⚙️ Aturan Prototype Figma

- **Satu role = satu grup frame** (Engineer, Planner, Supply Chain, Vendor, Gudang)
- Tidak ada interaksi silang antar role
- Setiap role dimulai dari **Login (duplikat)** → Dashboard → halaman operasional
- Tombol "Kembali" selalu mengarah ke halaman sebelumnya dalam role yang sama

---

## 🔐 Alur Login (Shared – berlaku di semua role)

```
Login ──(Masuk)──────────────────── Dashboard [role]
     ──(Daftar sebagai Vendor)───── vendor-register-page
     ──(Lupa password?)──────────── [tidak ada frame di luar scope]
     ──(Kembali ke halaman utama)── welcome
```

**Catatan:** Tidak ada link "Daftar sekarang" / register user umum.

---

## 👷 ENGINEER FLOW

```
login-engineer
    │
    └──(Masuk)──► dashboard-engineer
                     │
                     ├──(Buat Pengajuan / Menu 01)──► material-requests-create
                     │                                    │
                     │                                    └──(Simpan)──► material-requests-index
                     │                                                        │
                     │                                                        ├──(Detail)──► material-requests-show
                     │                                                        │                 │
                     │                                                        │                 └──(Edit)──► material-requests-edit
                     │                                                        │
                     │                                                        └──(Buat Pengajuan Baru)──► material-requests-create
                     │
                     ├──(Klarifikasi Teknis / Menu 02)──► engineer-clarifications-index
                     │                                        │
                     │                                        └──(Buka Chat)──► engineer-clarification-show
                     │
                     └──(Monitoring / Menu 04)──► engineer-monitoring-index
                                                      │
                                                      └──(Lihat Detail)──► engineer-monitoring-show
```

---

## 📋 PLANNER FLOW

```
login-planner
    │
    └──(Masuk)──► dashboard-planner
                     │
                     └──(Buka Pengajuan / Verifikasi Pengajuan)──► planner-material-requests-index
                                                                        │
                                                                        └──(Verifikasi)──► planner-material-requests-show
                                                                                              │
                                                                                              ├──(Setujui)──► planner-material-requests-index
                                                                                              └──(Tolak)────► planner-material-requests-index
```

---

## 🏭 SUPPLY CHAIN FLOW

```
login-supply-chain
    │
    └──(Masuk)──► dashboard-supply-chain
                     │
                     ├──[Vendor]──────────────────────────────────────────────────────────────────────────────────────────────────┐
                     │  sc-vendors-index                                                                                          │
                     │      ├──(Tambah Vendor)──► sc-vendors-create ──(Simpan)──► sc-vendors-index                               │
                     │      ├──(Detail)──────────► sc-vendors-show ──(Setujui/Tolak)──► sc-vendors-index                        │
                     │      │                           └──(Edit)──► sc-vendors-edit ──(Update)──► sc-vendors-show              │
                     │      └──(Edit)────────────► sc-vendors-edit                                                               │
                     │                                                                                                            │
                     ├──[Permintaan]──────────────────────────────────────────────────────────────────────────────────────────────┤
                     │  sc-material-requests-index                                                                                │
                     │      ├──(Detail)──► sc-material-requests-show                                                             │
                     │      │                  └──(Buat Tender)──► sc-tenders-create                                            │
                     │      └──(Buat Tender)──► sc-tenders-create                                                               │
                     │                                                                                                            │
                     ├──[Tender]──────────────────────────────────────────────────────────────────────────────────────────────────┤
                     │  sc-tenders-index                                                                                         │
                     │      ├──(+ Buat dari Pengajuan)──► sc-material-requests-index                                            │
                     │      └──(Detail)──► sc-tenders-show                                                                      │
                     │                        ├──(Buka Negosiasi)──► sc-chat-negosiasi-index                                   │
                     │                        │                           └──(Masuk Chat)──► sc-chat-negosiasi-show             │
                     │                        └──(Buat PO setelah pilih vendor)──► sc-purchase-orders-create                   │
                     │                                                                  └──(Simpan)──► sc-purchase-orders-index │
                     │                                                                                                           │
                     ├──[Purchase Order]──────────────────────────────────────────────────────────────────────────────────────────┤
                     │  sc-purchase-orders-index                                                                                  │
                     │      └──(Detail)──► sc-purchase-orders-show                                                               │
                     │                        └──(Buat Tender Ulang)──► sc-tenders-create   [jika Vendor Mundur]                │
                     │                                                                                                            │
                     ├──[Laporan Penerimaan]──────────────────────────────────────────────────────────────────────────────────────┤
                     │  sc-goods-receipts-index                                                                                   │
                     │      └──(Detail)──► sc-goods-receipts-show                                                                │
                     │  sc-goods-receipt-reports-index                                                                            │
                     │      └──(Detail)──► sc-goods-receipt-reports-show                                                         │
                     │                        ├──(Konfirmasi)──► sc-goods-receipt-reports-index                                  │
                     │                        └──(Retur)────────► sc-goods-receipt-reports-index                                 │
                     │                                                                                                            │
                     └──[Monitoring]──────────────────────────────────────────────────────────────────────────────────────────────┘
                        sc-monitoring-index
                            └──(Detail)──► sc-monitoring-show
                                              └──(Edit Status)──► sc-monitoring-edit ──(Update)──► sc-monitoring-index
```

---

## 🏢 VENDOR FLOW

```
welcome
    ├──(Login ke Sistem)──────────────► login-vendor
    │                                       │
    │                                       └──(Masuk)──► dashboard-vendor-[status]
    │
    └──(Daftar sebagai Vendor)──────────► vendor-register-page
                                              │
                                              └──(Kirim Registrasi)──► dashboard-vendor-waiting
                                                                            [Menunggu verifikasi SC]

─────────────────────────────────────────────────────────────────────────────────────────────────────
  KONDISI DASHBOARD VENDOR
─────────────────────────────────────────────────────────────────────────────────────────────────────

  dashboard-vendor-waiting
      [Tidak ada navigasi — hanya tampil info menunggu]

  dashboard-vendor-rejected
      └──(Perbaiki Data Registrasi)──► vendor-resubmit
                                           └──(Kirim Ulang)──► dashboard-vendor-waiting

  dashboard-vendor-approved
      ├──(Buka Tender Masuk)──► vendor-tenders-index
      │                              └──(Detail)──► vendor-tenders-show
      │                                                ├──(Kirim Penawaran)──► vendor-tenders-index
      │                                                ├──(Klarifikasi Spesifikasi)──► vendor-chat-clarification
      │                                                └──(Negosiasi)──► vendor-chat-negotiation
      │
      └──(Lihat Purchase Order)──► vendor-purchase-orders-index
                                        └──(Detail)──► vendor-purchase-orders-show
                                                           ├──(Konfirmasi Pengiriman)──► vendor-purchase-orders-index
                                                           └──(Mundur dari PO)─────────► vendor-purchase-orders-index
```

---

## 🏗️ GUDANG FLOW

```
login-gudang
    │
    └──(Masuk)──► dashboard-gudang
                     │
                     ├──(Semua PO / Periksa Barang)──► gudang-goods-receipts-index
                     │                                       │
                     │                                       ├──(Terima Barang)──► gudang-goods-receipts-show
                     │                                       │                         └──(Simpan Laporan)──► gudang-goods-receipts-report
                     │                                       │                                                     └──(Kembali ke Daftar)──► gudang-goods-receipts-index
                     │                                       │
                     │                                       └──(Lihat Laporan)──► gudang-goods-receipts-report
                     │
                     └──(Dashboard link laporan)──► gudang-goods-receipts-report
```

---

## 📌 Ringkasan Interaksi Kritis

| Interaksi | Dari | Ke | Kondisi |
|-----------|------|----|---------|
| Vendor Mundur dari PO | `vendor-purchase-orders-show` | `vendor-purchase-orders-index` | Jika status belum dikirim |
| SC Tender Ulang | `sc-purchase-orders-show` | `sc-tenders-create` | Jika status = Vendor Mundur |
| Verifikasi Vendor SC | `sc-vendors-show` | `sc-vendors-index` | Setujui / Tolak |
| Perbaiki Data Vendor | `dashboard-vendor-rejected` | `vendor-resubmit` | Status = Ditolak |
| Kirim Ulang Registrasi | `vendor-resubmit` | `dashboard-vendor-waiting` | — |
| Registrasi Vendor Baru | `vendor-register-page` | `dashboard-vendor-waiting` | — |
| Klarifikasi Vendor→Engineer | `vendor-tenders-show` | `vendor-chat-clarification` | Dari halaman tender |
| Negosiasi Vendor→SC | `vendor-tenders-show` | `vendor-chat-negotiation` | Dari halaman tender |
