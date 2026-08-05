# Inventaris Halaman – Sistem Pengadaan Material Kapal (PT PAL)

> Dokumen ini dibuat berdasarkan analisis source code nyata dari proyek Laravel.

## Teknologi UI
- Framework CSS: Tailwind CSS (via Vite)
- Font: Figtree (Bunny Fonts)
- JS: Alpine.js (dropdown, mobile nav)
- Layout utama: resources/views/layouts/app.blade.php
- Navigasi: resources/views/layouts/navigation.blade.php
- Layout tamu: resources/views/layouts/guest.blade.php
- Navigasi: HORIZONTAL top navbar (bukan sidebar) - menu berbeda per role

## Role Pengguna
| Role | Redirect Login |
|---|---|
| engineer | /engineer/dashboard |
| planner | /planner/dashboard |
| supply_chain | /supply-chain/dashboard |
| vendor | /vendor/dashboard |
| gudang | /gudang/dashboard |
| admin | /admin/dashboard |

## Inventaris Halaman

| No | Nama Halaman | Role | Route | File View | Controller | Komponen Utama | Tombol/Aksi | Halaman Tujuan | Prototype |
|---|---|---|---|---|---|---|---|---|---|
| 1 | Login | Semua | /login | auth/login.blade.php | AuthenticatedSessionController | Layout 2 kolom: panel kiri biru (branding PT PAL), panel kanan form login; Input email, password (toggle lihat), checkbox ingat saya, link lupa password | Tombol Masuk, Link Daftar, Link Lupa Password, Link Kembali ke Halaman Utama | Dashboard sesuai role | Ya |
| 2 | Register | Semua | /register | auth/register.blade.php | RegisteredUserController | Form: nama, email, password, konfirmasi password | Tombol Daftar | Login | Ya |
| 3 | Halaman Utama (Welcome) | Publik | / | welcome.blade.php | Route closure | Landing page, header dengan logo PT PAL | Tombol Login, Tombol Register | Login, Register | Ya |
| 4 | Dashboard Engineer | Engineer | /engineer/dashboard | dashboards/engineer.blade.php | Engineer\DashboardController | Navbar top (Dashboard, Pengajuan Material), header tanggal, hero banner biru, 4 step alur kerja, 4 menu kartu (01 Permintaan Material, 02 Klarifikasi Spesifikasi, 03 Daftar Pengajuan, 04 Monitoring Kebutuhan Material) | Buat Pengajuan (hero), Buka Klarifikasi, Lihat Daftar, Pantau Proses | Buat Pengajuan, Klarifikasi Index, Material Requests Index, Monitoring Index | Ya |
| 5 | Daftar Pengajuan Material | Engineer | /material-requests | material-requests/index.blade.php | MaterialRequestController | Header, hero banner biru, tabel (Kode, Project, Barang, Qty, Tanggal Dibutuhkan, Status badge, Aksi) | Detail, Edit (jika diajukan), Hapus (jika diajukan), Kembali ke Dashboard | Show, Edit | Ya |
| 6 | Buat Pengajuan Material | Engineer | /material-requests/create | material-requests/create.blade.php | MaterialRequestController | Hero banner, layout 2 kolom: panel kiri (catatan pengajuan step), panel kanan form (select Project, input Nama Barang, Spesifikasi, Qty, Satuan, Tanggal Dibutuhkan, Catatan, tombol + tambah item) | Simpan Pengajuan, Tambah Item, Kembali ke Dashboard | Daftar Pengajuan | Ya |
| 7 | Detail Pengajuan Material | Engineer | /material-requests/{id} | material-requests/show.blade.php | MaterialRequestController | Info proyek, tabel item barang, status badge, dokumen planner (jika ada) | Edit (jika diajukan), Hapus, Kembali | Edit, Daftar | Ya |
| 8 | Edit Pengajuan Material | Engineer | /material-requests/{id}/edit | material-requests/edit.blade.php | MaterialRequestController | Form edit pengajuan (sama dengan create) | Update, Kembali | Daftar Pengajuan | Tidak |
| 9 | Daftar Klarifikasi Teknis | Engineer | /engineer/clarifications | engineer/clarifications/index.blade.php | Engineer\TenderClarificationController | Tabel: Tender, Vendor, Pesan Terakhir, Aksi | Buka Chat, Kembali ke Dashboard | Chat Klarifikasi | Ya |
| 10 | Chat Klarifikasi Teknis | Engineer | /engineer/clarifications/{tender}/{vendor} | engineer/clarifications/show.blade.php | Engineer\TenderClarificationController | Chat UI: header (nama vendor, tender), panel riwayat pesan, form kirim pesan | Kirim, Kembali | - | Ya |
| 11 | Monitoring Kebutuhan Material | Engineer | /engineer/monitoring | engineer/monitoring/index.blade.php | Engineer\MonitoringController | Tabel monitoring: Kode MR, Project, Status, Aksi | Lihat Detail, Kembali | Detail Monitoring Engineer | Ya |
| 12 | Detail Monitoring Kebutuhan | Engineer | /engineer/monitoring/{id} | engineer/monitoring/show.blade.php | Engineer\MonitoringController | Timeline tahapan pengadaan, status tiap step, info material | Kembali | Monitoring Index | Ya |
| 13 | Dashboard Planner | Planner | /planner/dashboard | dashboards/planner.blade.php | Route closure | Navbar top (Dashboard, Verifikasi Pengajuan), hero banner biru, 3 info card (Pengajuan Material, Dokumen Planner, Keputusan Approval), panel shortcut buka pengajuan | Lihat Pengajuan Material (hero), Buka Pengajuan (shortcut) | Daftar Verifikasi Planner | Ya |
| 14 | Daftar Verifikasi Pengajuan | Planner | /planner/material-requests | planner/material-requests/index.blade.php | PlannerMaterialRequestController | Tabel: Kode, Project, Barang, Qty, Status, Aksi | Detail/Verifikasi, Kembali | Detail Verifikasi | Ya |
| 15 | Detail & Verifikasi Pengajuan | Planner | /planner/material-requests/{id} | planner/material-requests/show.blade.php | PlannerMaterialRequestController | Detail pengajuan (info project + item), form dokumen planner (input total RAB, upload file RAB, upload perizinan, catatan), tombol approve/reject | Setujui, Tolak, Upload Dokumen, Kembali | Daftar Verifikasi | Ya |
| 16 | Dashboard Supply Chain | Supply Chain | /supply-chain/dashboard | dashboards/supply.blade.php | SupplyChain\DashboardController | Navbar top (Dashboard, Vendor, Permintaan, Tender, Laporan Penerimaan), hero banner biru, 5 kartu menu (01 Kelola Vendor, 02 Dari Planner, 03 Kelola Tender, 04 Laporan Penerimaan, 05 Monitoring Pengadaan) | Permintaan Planner (hero), Kelola Tender (hero), Buka Vendor, Lihat Pengajuan, Masuk ke Tender, Lihat Laporan, Lihat Monitoring | Masing-masing menu | Ya |
| 17 | Kelola Vendor | Supply Chain | /supply-chain/vendors | supply-chain/vendors/index.blade.php | SupplyChain\VendorController | Tabel: Nama Vendor, Email, Telepon, Spesialisasi, Status (Aktif/Nonaktif), Aksi | Tambah Vendor, Detail, Edit, Hapus, Kembali | Create, Show, Edit | Ya |
| 18 | Tambah Vendor | Supply Chain | /supply-chain/vendors/create | supply-chain/vendors/create.blade.php | SupplyChain\VendorController | Form: Nama Vendor, Email, No. Telepon, Alamat, Spesialisasi | Simpan, Kembali | Daftar Vendor | Ya |
| 19 | Detail Vendor | Supply Chain | /supply-chain/vendors/{vendor} | supply-chain/vendors/show.blade.php | SupplyChain\VendorController | Info vendor lengkap | Edit, Kembali | Edit Vendor | Tidak |
| 20 | Edit Vendor | Supply Chain | /supply-chain/vendors/{vendor}/edit | supply-chain/vendors/edit.blade.php | SupplyChain\VendorController | Form edit vendor | Update, Kembali | Daftar Vendor | Tidak |
| 21 | Daftar Permintaan Material (SC) | Supply Chain | /supply-chain/material-requests | supply-chain/material-requests/index.blade.php | SupplyChain\MaterialRequestController | Tabel: Kode, Project, Status, Engineer, Tanggal, Aksi; filter status | Detail, Buat Tender, Kembali | Detail MR SC, Buat Tender | Ya |
| 22 | Detail Permintaan Material (SC) | Supply Chain | /supply-chain/material-requests/{id} | supply-chain/material-requests/show.blade.php | SupplyChain\MaterialRequestController | Detail pengajuan, dokumen planner (RAB, perizinan), info status | Buat Tender, Kembali | Buat Tender | Ya |
| 23 | Daftar Tender | Supply Chain | /supply-chain/tenders | supply-chain/tenders/index.blade.php | SupplyChain\TenderController | Hero (total tender), tabel: Nama Tender, No MR, Deadline, Status, Vendor Diundang, Aksi; pagination | Detail, Buat dari Pengajuan, Kembali | Detail Tender, SC Material Requests | Ya |
| 24 | Buat Tender | Supply Chain | /supply-chain/material-requests/{id}/tenders/create | supply-chain/tenders/create.blade.php | SupplyChain\TenderController | Form: Nama Tender, Deadline Penawaran, Catatan, Checkbox pilih vendor dari daftar | Simpan Tender, Kembali | Daftar Tender | Ya |
| 25 | Detail Tender | Supply Chain | /supply-chain/tenders/{tender} | supply-chain/tenders/show.blade.php | SupplyChain\TenderController | Info tender, daftar vendor diundang + status (Dikirim/Dibaca/Ditawar), tabel penawaran masuk (harga, estimasi, file), tombol pilih vendor, link negosiasi | Pilih Vendor, Buka Negosiasi, Buat PO, Kembali | Buat PO | Ya |
| 26 | Negosiasi – Daftar Vendor | Supply Chain | /supply-chain/tenders/{tender}/negotiation | supply-chain/chatnegosiasi/index.blade.php | SupplyChain\ChatNegosiasiController | Daftar vendor yang terlibat negosiasi di tender ini | Masuk Chat, Kembali | Chat Negosiasi | Ya |
| 27 | Negosiasi – Chat Detail | Supply Chain | /supply-chain/tenders/{tender}/negotiation/{vendor} | supply-chain/chatnegosiasi/show.blade.php | SupplyChain\ChatNegosiasiController | Chat UI negosiasi: header, riwayat pesan, form kirim pesan | Kirim, Kembali | - | Ya |
| 28 | Daftar Purchase Order (SC) | Supply Chain | /supply-chain/purchase-orders | supply-chain/purchase-orders/index.blade.php | SupplyChain\PurchaseOrderController | Tabel: No PO, Tender, Vendor, Deadline, Status, Aksi | Detail, Kembali | Detail PO SC | Ya |
| 29 | Buat Purchase Order | Supply Chain | /supply-chain/tenders/{tender}/purchase-orders/create | supply-chain/purchase-orders/create.blade.php | SupplyChain\PurchaseOrderController | Form PO: Info vendor terpilih, tabel item (nama, qty, harga satuan), Deadline Pengiriman, Catatan | Simpan PO, Kembali | Daftar PO SC | Ya |
| 30 | Detail Purchase Order (SC) | Supply Chain | /supply-chain/purchase-orders/{purchaseOrder} | supply-chain/purchase-orders/show.blade.php | SupplyChain\PurchaseOrderController | Detail PO lengkap: No PO, Vendor, Item, Status, Deadline Pengiriman | Kembali | Daftar PO SC | Tidak |
| 31 | Daftar Laporan Penerimaan (SC) | Supply Chain | /supply-chain/goods-receipts | supply-chain/goods-receipts/index.blade.php | SupplyChain\GoodsReceiptController | Tabel laporan penerimaan dari gudang | Detail, Kembali | Detail Laporan SC | Ya |
| 32 | Detail Laporan Penerimaan (SC) | Supply Chain | /supply-chain/goods-receipts/{goodsReceipt} | supply-chain/goods-receipts/show.blade.php | SupplyChain\GoodsReceiptController | Detail laporan penerimaan: kondisi barang, foto, catatan | Kembali | Daftar Laporan SC | Tidak |
| 33 | Laporan Penerimaan Gudang – Daftar (SC) | Supply Chain | /supply-chain/goods-receipt-reports | supply-chain/goods-receipt-reports/index.blade.php | SupplyChain\GoodsReceiptReportController | Tabel laporan dengan status (Menunggu, Dikonfirmasi, Diretur) | Detail, Kembali | Detail Report | Ya |
| 34 | Laporan Penerimaan Gudang – Detail (SC) | Supply Chain | /supply-chain/goods-receipt-reports/{id} | supply-chain/goods-receipt-reports/show.blade.php | SupplyChain\GoodsReceiptReportController | Detail laporan: item, foto, catatan gudang | Konfirmasi, Retur, Kembali | Daftar Report SC | Ya |
| 35 | Monitoring Pengadaan (SC) | Supply Chain | /supply-chain/monitoring | supply-chain/monitoring/index.blade.php | SupplyChain\MonitoringController | Tabel monitoring semua PO: No PO, Vendor, Status Pengiriman, Aksi | Detail, Kembali | Detail Monitoring SC | Ya |
| 36 | Detail Monitoring Pengadaan (SC) | Supply Chain | /supply-chain/monitoring/{id} | supply-chain/monitoring/show.blade.php | SupplyChain\MonitoringController | Timeline status pengadaan, info PO | Edit Status, Kembali | Edit Monitoring SC | Ya |
| 37 | Edit Monitoring Pengadaan (SC) | Supply Chain | /supply-chain/monitoring/{id}/edit | supply-chain/monitoring/edit.blade.php | SupplyChain\MonitoringController | Form edit status monitoring | Update, Kembali | Detail Monitoring SC | Tidak |
| 38 | Dashboard Vendor | Vendor | /vendor/dashboard | dashboards/vendor.blade.php | Route closure | Navbar top (Dashboard), hero biru (Tender/PO/Pengiriman), 2 kartu menu (Tender Masuk, Purchase Order Masuk), alur vendor 5 tahap, info keterangan status (Dikirim, Dibaca, Ditawar, Terpilih, Tidak Terpilih, PO Diterima), panel Quick Access | Buka Tender Masuk (hero), Lihat Purchase Order (hero), Buka Tender (quick), Buka Purchase Order (quick) | Daftar Tender Vendor, Daftar PO Vendor | Ya |
| 39 | Daftar Tender (Vendor) | Vendor | /vendor/tenders | vendor/tenders/index.blade.php | Vendor\TenderController | Tabel tender yang diterima: Nama Tender, Material, Deadline, Status | Detail Tender, Kembali | Detail Tender Vendor | Ya |
| 40 | Detail Tender & Kirim Penawaran (Vendor) | Vendor | /vendor/tenders/{id} | vendor/tenders/show.blade.php | Vendor\TenderController | Detail tender: info kebutuhan material, spesifikasi; Form penawaran (harga, estimasi pengiriman, catatan, upload file); Link klarifikasi; Link negosiasi | Kirim Penawaran, Buka Klarifikasi, Buka Negosiasi, Kembali | Chat Klarifikasi, Chat Negosiasi | Ya |
| 41 | Chat Klarifikasi (Vendor) | Vendor | /vendor/tenders/{invitation}/chat | vendor/tenders/chat-clarification.blade.php | Vendor\TenderClarificationController | Chat UI: header tender, riwayat pesan dengan Engineer, form kirim pesan | Kirim, Kembali | - | Ya |
| 42 | Chat Negosiasi (Vendor) | Vendor | /vendor/tenders/{invitation}/chat-negotiation | vendor/tenders/chat-negotiation.blade.php | Vendor\TenderClarificationController | Chat UI: header tender, riwayat pesan negosiasi dengan SC, form kirim | Kirim, Kembali | - | Ya |
| 43 | Daftar Purchase Order (Vendor) | Vendor | /vendor/purchase-orders | vendor/purchase-orders/index.blade.php | Vendor\PurchaseOrderController | Tabel PO masuk: No PO, Tender, Deadline Pengiriman, Status | Detail PO, Kembali | Detail PO Vendor | Ya |
| 44 | Detail Purchase Order (Vendor) | Vendor | /vendor/purchase-orders/{purchaseOrder} | vendor/purchase-orders/show.blade.php | Vendor\PurchaseOrderController | Detail PO: info SC, item barang, deadline; Form konfirmasi pengiriman (tanggal kirim, ekspedisi, no resi) | Konfirmasi Pengiriman, Kembali | Daftar PO Vendor | Ya |
| 45 | Dashboard Gudang | Gudang | /gudang/dashboard | dashboards/gudang.blade.php | Gudang\DashboardController | Navbar top (Dashboard, Penerimaan Barang), header dengan tombol Semua PO, hero banner biru (4 stat card: Menunggu, Diterima, Bermasalah, Tindak Lanjut), 4 stat card di bawah, tabel PO menunggu penerimaan (No PO, Vendor, Tender/Material, Jml Pesanan, Deadline Kirim, Status, Aksi) | Periksa Barang Masuk (hero), Semua PO (header), Lihat Laporan, Periksa Barang (tabel) | Daftar Penerimaan Gudang, Detail Pemeriksaan | Ya |
| 46 | Daftar Penerimaan Barang (Gudang) | Gudang | /gudang/goods-receipts | gudang/goods-receipts/index.blade.php | Gudang\GoodsReceiptController | Tabel PO: No PO, Vendor, Tender, Jml Item, Deadline, Status, Aksi | Periksa Barang, Lihat Laporan, Kembali | Pemeriksaan, Laporan | Ya |
| 47 | Pemeriksaan Penerimaan Barang | Gudang | /gudang/goods-receipts/{purchaseOrder} | gudang/goods-receipts/show.blade.php | Gudang\GoodsReceiptController | Detail PO, form penerimaan per item (kondisi, qty diterima, catatan), upload foto, status keseluruhan | Simpan Laporan Penerimaan, Kembali | Laporan Penerimaan Gudang | Ya |
| 48 | Laporan Penerimaan Barang (Gudang) | Gudang | /gudang/goods-receipts/report/{receipt} | gudang/goods-receipts/report.blade.php | Gudang\GoodsReceiptController | Laporan resmi: detail item diterima, foto barang, catatan gudang, status akhir | Kembali | Daftar Penerimaan | Ya |
| 49 | Profil Pengguna | Semua | /profile | profile/edit.blade.php | ProfileController | Form update nama, email; opsi hapus akun | Simpan, Hapus Akun | Dashboard | Tidak |

## Status Badge yang Ditemukan
- Material Request: diajukan (kuning), disetujui (hijau), ditolak (merah)
- Tender/Invitation: dikirim (kuning), dibaca (biru), ditawar (hijau), terpilih (emerald), tidak_terpilih (merah)
- Purchase Order: menunggu (abu), dikirim (ungu), selesai (hijau)
- Goods Receipt: baik, kurang, cacat, return
