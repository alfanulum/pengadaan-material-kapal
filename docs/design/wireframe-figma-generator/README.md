# Wireframe Generator – Sistem Pengadaan Material Kapal PT PAL

Folder ini berisi **low-fidelity wireframe** lengkap untuk Sistem Informasi Pengadaan Material Kapal PT PAL Indonesia, dibuat berdasarkan analisis source code aplikasi Laravel secara nyata.

> **PENTING:** Folder ini tidak mengubah, menghapus, atau memodifikasi source code aplikasi utama.

---

## Struktur Folder

```
wireframe-figma-generator/
├── docs/
│   ├── page-inventory.md        # Inventaris 49 halaman sistem
│   └── prototype-flow.md        # Alur navigasi per role
├── figma-plugin/
│   ├── manifest.json            # Figma plugin manifest
│   ├── code.js                  # Plugin logic (draw wireframe di canvas Figma)
│   └── ui.html                  # Plugin UI (select halaman, generate)
├── preview/
│   └── index.html               # Preview wireframe di browser (standalone)
├── wireframe-spec.json          # Spesifikasi lengkap 43 halaman
└── README.md                    # Dokumentasi ini
```

---

## Cara Penggunaan

### 1. Preview di Browser (Tercepat)

Buka file `preview/index.html` langsung di browser:
- Sidebar kiri: navigasi per halaman, filter role, pencarian
- Panel kanan: wireframe 1440×900px dengan zoom control
- Menampilkan semua 43 halaman dari 5 role

### 2. Generate ke Figma via Plugin

1. Buka Figma Desktop App
2. Menu: **Plugins** → **Development** → **Import plugin from manifest...**
3. Pilih file `figma-plugin/manifest.json`
4. Jalankan plugin dari menu Plugins
5. Pilih halaman yang ingin di-generate (bisa filter per role)
6. Klik **▶ Generate Wireframe yang Dipilih**
7. Plugin akan membuat Frame untuk setiap halaman di canvas Figma

---

## Statistik

| Metrik | Nilai |
|--------|-------|
| Total Halaman | 43 |
| Role | 5 (Engineer, Planner, Supply Chain, Vendor, Gudang) |
| Resolusi | 1440 × 900 px |
| Palet Warna | Hitam, Putih, Abu-abu (Low-Fidelity) |
| Format Spec | JSON |

---

## Role & Halaman

| Role | Jumlah Halaman |
|------|----------------|
| Engineer | 8 |
| Planner | 3 |
| Supply Chain | 14 |
| Vendor | 7 |
| Gudang | 4 |
| All / Public | 4 |
| **Total** | **43** |

---

## Referensi Teknis

- **Framework**: Laravel MVC
- **Auth**: Middleware berbasis `role` field
- **Layout UI**: `resources/views/layouts/app.blade.php`
- **Navigasi**: `resources/views/layouts/navigation.blade.php` (horizontal top navbar)
- **CSS**: Tailwind CSS (aplikasi) → Pure CSS (wireframe/preview)
- **Analisis Source**: Route `web.php`, Controller, Views, Navigation Blade

---

## Catatan

- Semua wireframe menggunakan **hanya hitam, putih, dan abu-abu** sesuai standar low-fidelity
- Tidak ada warna dari aplikasi asli yang digunakan
- Konten halaman (judul, kolom, label form, tombol) diambil **langsung dari source code**
- Tidak ada halaman, tombol, atau form yang dikarang
