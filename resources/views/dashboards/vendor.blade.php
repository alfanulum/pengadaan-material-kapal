<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3">
            <div>
                <h2 class="font-bold text-2xl text-slate-900 leading-tight">
                    Dashboard Vendor
                </h2>
                <p class="text-sm text-slate-500 mt-1">
                    Portal vendor untuk memantau tender masuk, mengirim penawaran, melihat Purchase Order, dan memproses
                    pengiriman.
                </p>
            </div>

            <div class="text-sm text-slate-600 bg-white px-4 py-2 rounded-xl border border-slate-200 shadow-sm">
                {{ now()->format('d M Y') }}
            </div>
        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        @php
            // $vendor bisa null jika data belum ada (tapi seharusnya tidak terjadi setelah registrasi)
            $statusRegistrasi = $vendor->status_registrasi ?? 'menunggu';
        @endphp

        {{-- =========================================================
             KONDISI: VENDOR DITOLAK — Pop-up modal + pesan permanen
             ========================================================= --}}
        @if ($vendor && $statusRegistrasi === 'ditolak')

            {{-- Modal Pop-up Penolakan (muncul sekali saat pertama kali halaman dibuka) --}}
            <div id="modal-penolakan"
                class="fixed inset-0 z-50 flex items-center justify-center bg-black/60 backdrop-blur-sm p-4">
                <div class="bg-white rounded-3xl shadow-2xl max-w-lg w-full p-8">
                    <div class="flex items-center gap-3 mb-5">
                        <div class="w-12 h-12 rounded-2xl bg-red-100 flex items-center justify-center text-2xl">❌</div>
                        <div>
                            <h3 class="text-xl font-bold text-slate-900">REGISTRASI DITOLAK</h3>
                            <p class="text-sm text-red-600 font-semibold">Akun Vendor belum dapat disetujui</p>
                        </div>
                    </div>

                    <p class="text-slate-700 text-sm leading-relaxed">
                        Registrasi akun Vendor Anda belum dapat disetujui oleh Supply Chain.
                    </p>

                    <div class="mt-4 p-4 bg-red-50 border border-red-200 rounded-2xl">
                        <p class="text-xs font-bold text-red-600 uppercase tracking-wider mb-1">Alasan Penolakan</p>
                        <p class="text-sm text-red-800 leading-relaxed">{{ $vendor->alasan_penolakan ?? '-' }}</p>
                    </div>

                    <div class="mt-6 flex flex-col gap-3">
                        <a href="{{ route('vendor.resubmit') }}"
                            class="w-full inline-flex items-center justify-center px-5 py-3 bg-blue-900 text-white rounded-xl font-semibold hover:bg-blue-950 transition">
                            Perbaiki Data Registrasi
                        </a>
                        <button onclick="document.getElementById('modal-penolakan').classList.add('hidden')"
                            class="w-full inline-flex items-center justify-center px-5 py-3 bg-slate-100 text-slate-700 rounded-xl font-semibold hover:bg-slate-200 transition">
                            Tutup
                        </button>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit"
                                class="w-full inline-flex items-center justify-center px-5 py-3 bg-red-600 text-white rounded-xl font-semibold hover:bg-red-700 transition">
                                Keluar
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            {{-- Pesan permanen di halaman --}}
            <div class="mb-6 rounded-3xl border-2 border-red-300 bg-red-50 p-6">
                <div class="flex items-start gap-4">
                    <div class="w-12 h-12 rounded-2xl bg-red-100 flex items-center justify-center text-2xl shrink-0">❌</div>
                    <div class="flex-1">
                        <h3 class="text-lg font-bold text-red-900">REGISTRASI DITOLAK</h3>
                        <p class="text-sm text-red-700 mt-1">
                            Registrasi akun Vendor Anda belum dapat disetujui oleh Supply Chain.
                        </p>
                        <div class="mt-3 p-3 bg-white border border-red-200 rounded-xl">
                            <p class="text-xs font-bold text-red-600 uppercase tracking-wider mb-1">Alasan Penolakan</p>
                            <p class="text-sm text-red-800">{{ $vendor->alasan_penolakan ?? '-' }}</p>
                        </div>
                        <div class="mt-4 flex flex-wrap gap-3">
                            <a href="{{ route('vendor.resubmit') }}"
                                class="inline-flex items-center px-5 py-2.5 bg-blue-900 text-white rounded-xl text-sm font-semibold hover:bg-blue-950 transition">
                                Perbaiki Data Registrasi
                            </a>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit"
                                    class="inline-flex items-center px-5 py-2.5 bg-red-600 text-white rounded-xl text-sm font-semibold hover:bg-red-700 transition">
                                    Keluar
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        {{-- =========================================================
             KONDISI: VENDOR MENUNGGU VERIFIKASI
             ========================================================= --}}
        @elseif (!$vendor || $statusRegistrasi === 'menunggu')

            {{-- Hero dengan status menunggu --}}
            <div class="bg-gradient-to-r from-amber-600 via-amber-500 to-yellow-400 rounded-3xl p-8 md:p-10 shadow-xl text-white mb-8 overflow-hidden relative">
                <div class="absolute -top-24 -right-24 w-80 h-80 bg-white/10 rounded-full blur-3xl"></div>
                <div class="absolute -bottom-24 -left-24 w-80 h-80 bg-white/10 rounded-full blur-3xl"></div>

                <div class="relative z-10 flex flex-col lg:flex-row lg:items-center gap-8">
                    <div class="w-24 h-24 rounded-3xl bg-white/20 flex items-center justify-center text-5xl shrink-0">
                        ⏳
                    </div>
                    <div>
                        <p class="text-lg font-bold uppercase tracking-widest text-white/90 mb-2">
                            REGISTRASI SEDANG DIPERIKSA
                        </p>
                        <h3 class="text-3xl md:text-4xl font-black leading-tight">
                            Akun Anda Menunggu Persetujuan
                        </h3>
                        <p class="mt-4 text-white/90 leading-relaxed max-w-2xl">
                            Data registrasi Anda telah diterima. Akun Anda sedang menunggu persetujuan dari Supply Chain.
                            Seluruh fitur Vendor dapat digunakan setelah registrasi disetujui.
                        </p>
                        @if ($vendor)
                            <p class="mt-3 text-sm text-white/75">
                                Tanggal registrasi:
                                {{ $vendor->tanggal_daftar ? $vendor->tanggal_daftar->format('d M Y H:i') : $vendor->created_at->format('d M Y H:i') }}
                            </p>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Info perusahaan yang terdaftar --}}
            @if ($vendor)
            <div class="bg-white rounded-3xl shadow-sm border border-slate-200 p-6 mb-6">
                <h3 class="text-lg font-bold text-slate-900 mb-4">📋 Data Registrasi Anda</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="rounded-2xl bg-slate-50 p-4">
                        <p class="text-xs text-slate-500 mb-1">Nama Perusahaan</p>
                        <p class="font-bold text-slate-900">{{ $vendor->nama_vendor }}</p>
                    </div>
                    <div class="rounded-2xl bg-slate-50 p-4">
                        <p class="text-xs text-slate-500 mb-1">PIC</p>
                        <p class="font-bold text-slate-900">{{ $vendor->pic ?? '-' }}</p>
                    </div>
                    <div class="rounded-2xl bg-slate-50 p-4">
                        <p class="text-xs text-slate-500 mb-1">Email</p>
                        <p class="font-bold text-slate-900">{{ $vendor->email ?? '-' }}</p>
                    </div>
                    <div class="rounded-2xl bg-slate-50 p-4">
                        <p class="text-xs text-slate-500 mb-1">Telepon</p>
                        <p class="font-bold text-slate-900">{{ $vendor->telepon ?? '-' }}</p>
                    </div>
                    <div class="rounded-2xl bg-slate-50 p-4 md:col-span-2">
                        <p class="text-xs text-slate-500 mb-1">Alamat</p>
                        <p class="font-medium text-slate-900">{{ $vendor->alamat ?? '-' }}</p>
                    </div>
                </div>
            </div>
            @endif

            {{-- Apa yang terjadi selanjutnya --}}
            <div class="bg-white rounded-3xl shadow-sm border border-slate-200 p-6">
                <h3 class="text-lg font-bold text-slate-900 mb-4">🔔 Apa yang terjadi selanjutnya?</h3>
                <div class="space-y-4">
                    <div class="flex items-start gap-4">
                        <div class="w-10 h-10 rounded-xl bg-amber-100 text-amber-700 flex items-center justify-center font-bold text-sm shrink-0">1</div>
                        <div>
                            <p class="font-semibold text-slate-900">Tim Supply Chain memeriksa data Anda</p>
                            <p class="text-sm text-slate-500 mt-0.5">Supply Chain akan meninjau data perusahaan dan kelengkapan informasi Anda.</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-4">
                        <div class="w-10 h-10 rounded-xl bg-blue-100 text-blue-700 flex items-center justify-center font-bold text-sm shrink-0">2</div>
                        <div>
                            <p class="font-semibold text-slate-900">Keputusan verifikasi</p>
                            <p class="text-sm text-slate-500 mt-0.5">Akun Anda akan disetujui atau ditolak beserta alasannya. Jika ditolak, Anda dapat memperbaiki data.</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-4">
                        <div class="w-10 h-10 rounded-xl bg-green-100 text-green-700 flex items-center justify-center font-bold text-sm shrink-0">3</div>
                        <div>
                            <p class="font-semibold text-slate-900">Akses penuh tersedia</p>
                            <p class="text-sm text-slate-500 mt-0.5">Setelah disetujui, Anda dapat mengikuti tender, mengirim penawaran, dan mengelola Purchase Order.</p>
                        </div>
                    </div>
                </div>
            </div>

        {{-- =========================================================
             KONDISI: VENDOR DISETUJUI — Dashboard normal
             ========================================================= --}}
        @else

            @if (session('success'))
                <div class="mb-6 p-4 bg-green-50 border border-green-200 text-green-700 rounded-2xl">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="mb-6 p-4 bg-red-50 border border-red-200 text-red-700 rounded-2xl">
                    {{ session('error') }}
                </div>
            @endif

            {{-- Hero --}}
            <div
                class="bg-gradient-to-r from-slate-950 via-blue-950 to-blue-800 rounded-3xl p-8 md:p-10 shadow-xl text-white mb-8 overflow-hidden relative">
                <div class="absolute -top-24 -right-24 w-80 h-80 bg-cyan-400/20 rounded-full blur-3xl"></div>
                <div class="absolute -bottom-24 -left-24 w-80 h-80 bg-blue-400/20 rounded-full blur-3xl"></div>

                <div class="relative z-10 grid grid-cols-1 lg:grid-cols-3 gap-8 items-center">
                    <div class="lg:col-span-2">
                        <p
                            class="inline-flex px-4 py-2 rounded-full bg-white/10 border border-white/10 text-sm text-blue-100 mb-5">
                            PT PAL Vendor Portal
                        </p>

                        <h3 class="text-3xl md:text-5xl font-bold leading-tight">
                            Pantau Tender, Purchase Order, dan Pengiriman Material
                        </h3>

                        <p class="mt-5 text-blue-100 max-w-3xl text-base md:text-lg leading-relaxed">
                            Vendor dapat membuka tender yang diterima, mengirim penawaran harga,
                            melihat Purchase Order setelah terpilih, dan menyiapkan proses pengiriman material.
                        </p>

                        <div class="mt-8 flex flex-col sm:flex-row gap-4">
                            <a href="{{ route('vendor.tenders.index') }}"
                                class="inline-flex items-center justify-center px-7 py-4 bg-white text-blue-950 rounded-2xl font-bold shadow-lg hover:bg-slate-100 hover:-translate-y-1 transition">
                                Buka Tender Masuk
                            </a>

                            <a href="{{ route('vendor.purchase-orders.index') }}"
                                class="inline-flex items-center justify-center px-7 py-4 bg-white/10 text-white border border-white/20 rounded-2xl font-bold shadow-lg hover:bg-white/20 hover:-translate-y-1 transition">
                                Lihat Purchase Order
                            </a>
                        </div>
                    </div>

                    <div class="bg-white/10 border border-white/10 rounded-3xl p-6 md:p-8">
                        <p class="text-sm text-blue-100">
                            Fokus Vendor
                        </p>

                        <h4 class="text-2xl font-bold mt-2">
                            Tender → PO → Pengiriman
                        </h4>

                        <p class="text-sm text-blue-100 mt-4 leading-relaxed">
                            Semua aktivitas vendor dimulai dari tender masuk. Setelah vendor terpilih,
                            Supply Chain akan menerbitkan Purchase Order sebagai dasar proses pengadaan.
                        </p>

                        <div class="mt-6 grid grid-cols-2 gap-3">
                            <div class="bg-white/10 border border-white/10 rounded-2xl p-4">
                                <p class="text-xs text-blue-100">Aksi Utama</p>
                                <p class="font-bold mt-1">Kirim Penawaran</p>
                            </div>

                            <div class="bg-white/10 border border-white/10 rounded-2xl p-4">
                                <p class="text-xs text-blue-100">Setelah Terpilih</p>
                                <p class="font-bold mt-1">Terima PO</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Akses Utama --}}
            <div class="mb-6">
                <h3 class="text-xl font-bold text-slate-900">
                    Akses Vendor
                </h3>
                <p class="text-sm text-slate-500 mt-1">
                    Gunakan menu utama berikut untuk menjalankan proses vendor.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">

                {{-- Tender Masuk --}}
                <a href="{{ route('vendor.tenders.index') }}"
                    class="group relative overflow-hidden bg-white rounded-3xl p-6 shadow-sm border border-slate-200 hover:shadow-xl hover:-translate-y-1 transition min-h-[260px] flex flex-col">
                    <div
                        class="absolute -top-10 -right-10 w-28 h-28 bg-blue-100 rounded-full blur-2xl group-hover:bg-blue-200 transition">
                    </div>

                    <div class="relative flex flex-col h-full">
                        <div class="flex items-center justify-between mb-6">
                            <div
                                class="w-14 h-14 rounded-2xl bg-blue-100 text-blue-900 flex items-center justify-center font-bold text-lg">
                                01
                            </div>

                            <span class="px-3 py-1 rounded-full bg-blue-50 text-blue-700 text-xs font-bold">
                                Tender
                            </span>
                        </div>

                        <p class="text-sm text-slate-500">Undangan Vendor</p>
                        <h3 class="text-2xl font-bold text-slate-900 mt-1 group-hover:text-blue-900">
                            Tender Masuk
                        </h3>

                        <p class="text-sm text-slate-500 mt-3 leading-relaxed">
                            Lihat daftar undangan tender, detail kebutuhan material, deadline, dan kirim penawaran vendor.
                        </p>

                        <div class="mt-auto pt-6 flex items-center justify-between">
                            <span class="text-sm font-bold text-blue-900">
                                Buka Tender
                            </span>

                            <span
                                class="w-9 h-9 rounded-xl bg-blue-900 text-white flex items-center justify-center group-hover:bg-blue-950 transition">
                                →
                            </span>
                        </div>
                    </div>
                </a>

                {{-- Purchase Order --}}
                <a href="{{ route('vendor.purchase-orders.index') }}"
                    class="group relative overflow-hidden bg-white rounded-3xl p-6 shadow-sm border border-slate-200 hover:shadow-xl hover:-translate-y-1 transition min-h-[260px] flex flex-col">
                    <div
                        class="absolute -top-10 -right-10 w-28 h-28 bg-emerald-100 rounded-full blur-2xl group-hover:bg-emerald-200 transition">
                    </div>

                    <div class="relative flex flex-col h-full">
                        <div class="flex items-center justify-between mb-6">
                            <div
                                class="w-14 h-14 rounded-2xl bg-emerald-100 text-emerald-900 flex items-center justify-center font-bold text-lg">
                                02
                            </div>

                            <span class="px-3 py-1 rounded-full bg-emerald-50 text-emerald-700 text-xs font-bold">
                                PO
                            </span>
                        </div>

                        <p class="text-sm text-slate-500">Purchase Order</p>
                        <h3 class="text-2xl font-bold text-slate-900 mt-1 group-hover:text-emerald-900">
                            Purchase Order Masuk
                        </h3>

                        <p class="text-sm text-slate-500 mt-3 leading-relaxed">
                            Lihat PO yang dikirim Supply Chain setelah vendor dipilih sebagai pemenang tender.
                        </p>

                        <div class="mt-auto pt-6 flex items-center justify-between">
                            <span class="text-sm font-bold text-emerald-900">
                                Lihat PO
                            </span>

                            <span
                                class="w-9 h-9 rounded-xl bg-emerald-900 text-white flex items-center justify-center group-hover:bg-emerald-950 transition">
                                →
                            </span>
                        </div>
                    </div>
                </a>

            </div>

            {{-- Alur Vendor --}}
            <div class="bg-white rounded-3xl shadow-sm border border-slate-200 overflow-hidden mb-8">
                <div class="px-6 py-5 border-b border-slate-200">
                    <h3 class="text-lg font-bold text-slate-900">
                        Alur Kerja Vendor
                    </h3>
                    <p class="text-sm text-slate-500 mt-1">
                        Tahapan vendor dalam mengikuti proses procurement material kapal.
                    </p>
                </div>

                <div class="p-6 grid grid-cols-1 md:grid-cols-5 gap-5">
                    <div class="relative rounded-3xl bg-slate-50 border border-slate-200 p-5">
                        <div
                            class="w-12 h-12 rounded-2xl bg-blue-100 text-blue-900 flex items-center justify-center font-bold mb-5">
                            01
                        </div>

                        <h4 class="font-bold text-slate-900 text-lg">
                            Terima Tender
                        </h4>

                        <p class="text-sm text-slate-500 mt-2 leading-relaxed">
                            Tender dikirim oleh Supply Chain dan tampil pada halaman tender masuk.
                        </p>
                    </div>

                    <div class="relative rounded-3xl bg-slate-50 border border-slate-200 p-5">
                        <div
                            class="w-12 h-12 rounded-2xl bg-cyan-100 text-cyan-900 flex items-center justify-center font-bold mb-5">
                            02
                        </div>

                        <h4 class="font-bold text-slate-900 text-lg">
                            Cek Material
                        </h4>

                        <p class="text-sm text-slate-500 mt-2 leading-relaxed">
                            Vendor melihat detail material, spesifikasi, quantity, deadline, dan catatan tender.
                        </p>
                    </div>

                    <div class="relative rounded-3xl bg-slate-50 border border-slate-200 p-5">
                        <div
                            class="w-12 h-12 rounded-2xl bg-emerald-100 text-emerald-900 flex items-center justify-center font-bold mb-5">
                            03
                        </div>

                        <h4 class="font-bold text-slate-900 text-lg">
                            Kirim Penawaran
                        </h4>

                        <p class="text-sm text-slate-500 mt-2 leading-relaxed">
                            Vendor mengisi harga, estimasi pengiriman, catatan, dan mengunggah file penawaran.
                        </p>
                    </div>

                    <div class="relative rounded-3xl bg-slate-50 border border-slate-200 p-5">
                        <div
                            class="w-12 h-12 rounded-2xl bg-green-100 text-green-900 flex items-center justify-center font-bold mb-5">
                            04
                        </div>

                        <h4 class="font-bold text-slate-900 text-lg">
                            Terima PO
                        </h4>

                        <p class="text-sm text-slate-500 mt-2 leading-relaxed">
                            Jika vendor terpilih, Supply Chain menerbitkan Purchase Order kepada vendor.
                        </p>
                    </div>

                    <div class="relative rounded-3xl bg-slate-50 border border-slate-200 p-5">
                        <div
                            class="w-12 h-12 rounded-2xl bg-purple-100 text-purple-900 flex items-center justify-center font-bold mb-5">
                            05
                        </div>

                        <h4 class="font-bold text-slate-900 text-lg">
                            Pengiriman
                        </h4>

                        <p class="text-sm text-slate-500 mt-2 leading-relaxed">
                            Vendor menyiapkan dan mengirim material sesuai Purchase Order dan deadline pengiriman.
                        </p>
                    </div>
                </div>
            </div>

        @endif

    </div>
</x-app-layout>
