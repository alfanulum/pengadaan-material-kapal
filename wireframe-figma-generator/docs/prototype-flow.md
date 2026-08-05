# Alur Prototype – Sistem Pengadaan Material Kapal (PT PAL)

> Dokumen ini menjelaskan alur navigasi per role pengguna berdasarkan source code nyata.

---

## Alur 1 – Engineer

```
[Login]
  │ Masuk (email + password)
  ▼
[Dashboard Engineer]
  ├── Buat Pengajuan → [Form Buat Pengajuan Material]
  │     │ Simpan
  │     ▼
  │   [Daftar Pengajuan Material]
  │     ├── Detail → [Detail Pengajuan Material]
  │     │     ├── Edit (jika diajukan) → [Edit Pengajuan]
  │     │     └── Hapus → [Daftar Pengajuan]
  │     └── Edit (jika diajukan) → [Edit Pengajuan]
  │
  ├── Klarifikasi Spesifikasi → [Daftar Klarifikasi Teknis]
  │     │ Buka Chat
  │     ▼
  │   [Chat Klarifikasi Teknis (dengan Vendor)]
  │
  ├── Daftar Pengajuan → [Daftar Pengajuan Material]
  │
  └── Monitoring Kebutuhan Material → [Monitoring Kebutuhan Material]
        │ Lihat Detail
        ▼
      [Detail Monitoring Kebutuhan]
```

---

## Alur 2 – Planner

```
[Login]
  │ Masuk
  ▼
[Dashboard Planner]
  │ Lihat Pengajuan Material / Buka Pengajuan
  ▼
[Daftar Verifikasi Pengajuan]
  │ Detail / Verifikasi
  ▼
[Detail & Verifikasi Pengajuan]
  ├── Upload Dokumen (RAB, Perizinan)
  ├── Input Total RAB + Catatan
  ├── Tombol Setujui → status = disetujui → [Daftar Verifikasi]
  └── Tombol Tolak   → status = ditolak  → [Daftar Verifikasi]
```

---

## Alur 3 – Supply Chain

```
[Login]
  │ Masuk
  ▼
[Dashboard Supply Chain]
  │
  ├── Kelola Vendor
  │     ├── Daftar Vendor
  │     │     ├── Tambah Vendor → [Form Tambah Vendor] → Simpan → [Daftar Vendor]
  │     │     ├── Detail → [Detail Vendor]
  │     │     └── Edit → [Edit Vendor] → Update → [Daftar Vendor]
  │     └── Hapus → [Daftar Vendor]
  │
  ├── Permintaan dari Planner
  │     ├── [Daftar Permintaan Material SC]
  │     │     │ Detail
  │     │     ▼
  │     │   [Detail Permintaan Material SC]
  │     │     │ Buat Tender
  │     │     ▼
  │     │   [Form Buat Tender]
  │     │     │ Simpan
  │     │     ▼
  │     │   [Daftar Tender]
  │
  ├── Kelola Tender
  │     ├── [Daftar Tender]
  │     │     │ Detail
  │     │     ▼
  │     │   [Detail Tender]
  │     │     ├── Pilih Vendor → Vendor terpilih
  │     │     ├── Buat PO → [Form Buat Purchase Order] → Simpan → [Daftar PO]
  │     │     └── Buka Negosiasi → [Daftar Negosiasi Vendor]
  │     │           │ Masuk Chat
  │     │           ▼
  │     │         [Chat Negosiasi]
  │
  ├── Laporan Penerimaan (goods-receipts)
  │     ├── [Daftar Laporan Penerimaan SC]
  │     │     │ Detail
  │     │     ▼
  │     │   [Detail Laporan Penerimaan SC]
  │
  ├── Laporan Penerimaan Gudang (goods-receipt-reports)
  │     ├── [Daftar Laporan Gudang SC]
  │     │     │ Detail
  │     │     ▼
  │     │   [Detail Laporan Gudang SC]
  │     │     ├── Konfirmasi → status dikonfirmasi → [Daftar Laporan]
  │     │     └── Retur → status diretur → [Daftar Laporan]
  │
  └── Monitoring Pengadaan
        ├── [Daftar Monitoring SC]
        │     │ Detail
        │     ▼
        │   [Detail Monitoring SC]
        │     │ Edit Status
        │     ▼
        │   [Edit Monitoring SC] → Update → [Detail Monitoring]
```

---

## Alur 4 – Vendor

```
[Login]
  │ Masuk
  ▼
[Dashboard Vendor]
  │
  ├── Buka Tender Masuk
  │     ▼
  │   [Daftar Tender Vendor]
  │     │ Detail Tender
  │     ▼
  │   [Detail Tender & Form Penawaran Vendor]
  │     ├── Kirim Penawaran (form harga, estimasi, file)
  │     ├── Buka Klarifikasi → [Chat Klarifikasi Teknis Vendor]
  │     │     │ Kirim pesan ke Engineer
  │     └── Buka Negosiasi → [Chat Negosiasi Vendor]
  │           │ Kirim pesan ke Supply Chain
  │
  └── Lihat Purchase Order
        ▼
      [Daftar Purchase Order Vendor]
        │ Detail PO
        ▼
      [Detail Purchase Order Vendor]
        │ Konfirmasi Pengiriman (isi tanggal kirim, ekspedisi, no resi)
        ▼
      [Daftar PO Vendor] (status berubah)
```

---

## Alur 5 – Gudang

```
[Login]
  │ Masuk
  ▼
[Dashboard Gudang]
  ├── 4 stat cards (Menunggu, Diterima, Bermasalah, Tindak Lanjut)
  ├── Tabel PO menunggu
  │     ├── Periksa Barang → [Pemeriksaan Penerimaan Barang]
  │     │     │ Simpan Laporan Penerimaan
  │     │     ▼
  │     │   [Laporan Penerimaan Barang Gudang]
  │     └── Lihat Laporan → [Laporan Penerimaan Barang Gudang]
  │
  └── Semua PO → [Daftar Penerimaan Barang Gudang]
        │ Periksa Barang
        ▼
      [Pemeriksaan Penerimaan Barang]
        │ Simpan
        ▼
      [Laporan Penerimaan Barang Gudang]
```

---

## Alur Login & Redirect Role

```
POST /login
  │
  ├── role = engineer      → redirect /engineer/dashboard
  ├── role = planner       → redirect /planner/dashboard
  ├── role = supply_chain  → redirect /supply-chain/dashboard
  ├── role = vendor        → redirect /vendor/dashboard
  ├── role = gudang        → redirect /gudang/dashboard
  └── role = admin         → redirect /admin/dashboard
```

---

## Halaman yang Masuk ke Prototype

| Role | Halaman |
|---|---|
| Semua | Login |
| Engineer | Dashboard, Daftar Pengajuan, Buat Pengajuan, Detail Pengajuan, Daftar Klarifikasi, Chat Klarifikasi, Monitoring Index, Detail Monitoring |
| Planner | Dashboard, Daftar Verifikasi, Detail Verifikasi |
| Supply Chain | Dashboard, Daftar Vendor, Tambah Vendor, Daftar MR SC, Detail MR SC, Buat Tender, Daftar Tender, Detail Tender, Chat Negosiasi, Buat PO, Daftar PO SC, Daftar Laporan Gudang SC, Detail Laporan Gudang SC, Monitoring SC |
| Vendor | Dashboard, Daftar Tender Vendor, Detail Tender + Penawaran, Chat Klarifikasi, Chat Negosiasi, Daftar PO Vendor, Detail PO Vendor |
| Gudang | Dashboard, Daftar Penerimaan, Pemeriksaan Barang, Laporan Penerimaan |
