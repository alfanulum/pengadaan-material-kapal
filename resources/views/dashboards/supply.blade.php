<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3">
            <div>
                <h2 class="font-bold text-2xl text-slate-900 leading-tight">
                    Dashboard Supply Chain
                </h2>
                <p class="text-sm text-slate-500 mt-1">
                    Kelola vendor, permintaan planner, tender, penawaran vendor, dan pemilihan vendor pemenang.
                </p>
            </div>

            <div class="text-sm text-slate-600 bg-white px-4 py-2 rounded-xl border border-slate-200 shadow-sm">
                {{ now()->format('d M Y') }}
            </div>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            {{-- Hero --}}
            <div
                class="relative overflow-hidden rounded-3xl bg-gradient-to-r from-slate-950 via-blue-950 to-blue-800 p-8 md:p-10 shadow-xl text-white mb-8">
                <div class="absolute -top-24 -right-24 w-80 h-80 bg-cyan-400/20 rounded-full blur-3xl"></div>
                <div class="absolute -bottom-24 -left-24 w-80 h-80 bg-blue-400/20 rounded-full blur-3xl"></div>

                <div class="relative z-10 grid grid-cols-1 lg:grid-cols-2 gap-8 items-center">
                    <div>
                        <p
                            class="inline-flex px-4 py-2 rounded-full bg-white/10 border border-white/10 text-sm text-blue-100 mb-5">
                            PT PAL Supply Chain Procurement
                        </p>

                        <h3 class="text-3xl md:text-5xl font-bold leading-tight">
                            Kelola Pengadaan Material Kapal
                        </h3>

                        <p class="mt-5 text-blue-100 max-w-3xl text-base md:text-lg leading-relaxed">
                            Dashboard ini digunakan Supply Chain untuk memproses pengajuan material
                            yang sudah disetujui Planner, mengelola vendor, membuat tender,
                            memantau penawaran, dan menentukan vendor pemenang.
                        </p>

                        <div class="mt-8 flex flex-col sm:flex-row gap-4">
                            <a href="{{ route('supply-chain.material-requests.index') }}"
                                class="inline-flex items-center justify-center px-7 py-4 bg-white text-blue-950 rounded-2xl font-bold shadow-lg hover:bg-slate-100 hover:-translate-y-1 transition">
                                Permintaan Planner
                            </a>

                            <a href="{{ route('supply-chain.tenders.index') }}"
                                class="inline-flex items-center justify-center px-7 py-4 bg-white/10 text-white border border-white/20 rounded-2xl font-bold shadow-lg hover:bg-white/20 hover:-translate-y-1 transition">
                                Kelola Tender
                            </a>
                        </div>
                    </div>

                    <div class="bg-white/10 border border-white/10 rounded-3xl p-6 md:p-8">
                        <h4 class="text-xl font-bold mb-5">
                            Alur Procurement
                        </h4>

                        <div class="space-y-4">
                            <div class="flex gap-4">
                                <div
                                    class="w-10 h-10 rounded-xl bg-white text-blue-950 flex items-center justify-center font-bold shrink-0">
                                    1
                                </div>
                                <div>
                                    <h5 class="font-semibold">Vendor & Permintaan</h5>
                                    <p class="text-sm text-blue-100 mt-1">
                                        Kelola vendor dan terima pengajuan material dari Planner.
                                    </p>
                                </div>
                            </div>

                            <div class="flex gap-4">
                                <div
                                    class="w-10 h-10 rounded-xl bg-white text-blue-950 flex items-center justify-center font-bold shrink-0">
                                    2
                                </div>
                                <div>
                                    <h5 class="font-semibold">Tender & Penawaran</h5>
                                    <p class="text-sm text-blue-100 mt-1">
                                        Buat tender, undang vendor, dan pantau penawaran masuk.
                                    </p>
                                </div>
                            </div>

                            <div class="flex gap-4">
                                <div
                                    class="w-10 h-10 rounded-xl bg-white text-blue-950 flex items-center justify-center font-bold shrink-0">
                                    3
                                </div>
                                <div>
                                    <h5 class="font-semibold">Vendor Pemenang</h5>
                                    <p class="text-sm text-blue-100 mt-1">
                                        Pilih vendor terbaik berdasarkan penawaran yang masuk.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            {{-- Judul Menu --}}
            <div class="mb-6">
                <h3 class="text-xl font-bold text-slate-900">
                    Menu Supply Chain
                </h3>
                <p class="text-sm text-slate-500 mt-1">
                    Pilih proses utama untuk mengelola procurement material kapal.
                </p>
            </div>

            {{-- Grid Menu --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                {{-- 01 Kelola Vendor --}}
                <a href="{{ route('supply-chain.vendors.index') }}"
                    class="group relative overflow-hidden bg-white rounded-3xl p-6 shadow-sm border border-slate-200 hover:shadow-xl hover:-translate-y-1 transition min-h-[260px] flex flex-col">
                    <div class="absolute -top-10 -right-10 w-28 h-28 bg-blue-100 rounded-full blur-2xl group-hover:bg-blue-200 transition"></div>
                    <div class="relative flex flex-col h-full">
                        <div class="flex items-center justify-between mb-6">
                            <div class="w-14 h-14 rounded-2xl bg-blue-100 text-blue-900 flex items-center justify-center font-bold text-lg">
                                01
                            </div>
                            <span class="px-3 py-1 rounded-full bg-green-50 text-green-700 text-xs font-bold">
                                Aktif
                            </span>
                        </div>
                        <p class="text-sm text-slate-500">Vendor</p>
                        <h3 class="text-2xl font-bold text-slate-900 mt-1 group-hover:text-blue-900">
                            Kelola Vendor
                        </h3>
                        <p class="text-sm text-slate-500 mt-3 leading-relaxed">
                            Tambah, edit, lihat detail, dan atur status vendor penyedia material kapal.
                        </p>
                        <div class="mt-auto pt-6 flex items-center justify-between">
                            <span class="text-sm font-bold text-blue-900">Buka Vendor</span>
                            <span class="w-9 h-9 rounded-xl bg-blue-900 text-white flex items-center justify-center group-hover:bg-blue-950 transition">
                                →
                            </span>
                        </div>
                    </div>
                </a>

                {{-- 02 Permintaan dari Planner --}}
                <a href="{{ route('supply-chain.material-requests.index') }}"
                    class="group relative overflow-hidden bg-white rounded-3xl p-6 shadow-sm border border-slate-200 hover:shadow-xl hover:-translate-y-1 transition min-h-[260px] flex flex-col">
                    <div class="absolute -top-10 -right-10 w-28 h-28 bg-cyan-100 rounded-full blur-2xl group-hover:bg-cyan-200 transition"></div>
                    <div class="relative flex flex-col h-full">
                        <div class="flex items-center justify-between mb-6">
                            <div class="w-14 h-14 rounded-2xl bg-cyan-100 text-cyan-900 flex items-center justify-center font-bold text-lg">
                                02
                            </div>
                            <span class="px-3 py-1 rounded-full bg-blue-50 text-blue-700 text-xs font-bold">
                                Masuk
                            </span>
                        </div>
                        <p class="text-sm text-slate-500">Permintaan</p>
                        <h3 class="text-2xl font-bold text-slate-900 mt-1 group-hover:text-cyan-900">
                            Dari Planner
                        </h3>
                        <p class="text-sm text-slate-500 mt-3 leading-relaxed">
                            Lihat pengajuan material yang sudah disetujui Planner dan siap diproses ke tahap tender.
                        </p>
                        <div class="mt-auto pt-6 flex items-center justify-between">
                            <span class="text-sm font-bold text-cyan-900">Lihat Pengajuan</span>
                            <span class="w-9 h-9 rounded-xl bg-cyan-900 text-white flex items-center justify-center group-hover:bg-cyan-950 transition">
                                →
                            </span>
                        </div>
                    </div>
                </a>

                {{-- 03 Kelola Tender --}}
                <a href="{{ route('supply-chain.tenders.index') }}"
                    class="group relative overflow-hidden bg-white rounded-3xl p-6 shadow-sm border border-slate-200 hover:shadow-xl hover:-translate-y-1 transition min-h-[260px] flex flex-col">
                    <div class="absolute -top-10 -right-10 w-28 h-28 bg-indigo-100 rounded-full blur-2xl group-hover:bg-indigo-200 transition"></div>
                    <div class="relative flex flex-col h-full">
                        <div class="flex items-center justify-between mb-6">
                            <div class="w-14 h-14 rounded-2xl bg-indigo-100 text-indigo-900 flex items-center justify-center font-bold text-lg">
                                03
                            </div>
                            <span class="px-3 py-1 rounded-full bg-purple-50 text-purple-700 text-xs font-bold">
                                Tender
                            </span>
                        </div>
                        <p class="text-sm text-slate-500">Tender</p>
                        <h3 class="text-2xl font-bold text-slate-900 mt-1 group-hover:text-indigo-900">
                            Kelola Tender
                        </h3>
                        <p class="text-sm text-slate-500 mt-3 leading-relaxed">
                            Buat tender, undang vendor, lihat penawaran, dan pilih vendor pemenang.
                        </p>
                        <div class="mt-auto pt-6 flex items-center justify-between">
                            <span class="text-sm font-bold text-indigo-900">Masuk ke Tender &rarr;</span>
                            <span class="w-9 h-9 rounded-xl bg-indigo-900 text-white flex items-center justify-center group-hover:bg-indigo-950 transition">
                                →
                            </span>
                        </div>
                    </div>
                </a>

                {{-- 04 Laporan Penerimaan --}}
                <a href="{{ route('supply-chain.goods-receipts.index') }}"
                    class="group relative overflow-hidden bg-white rounded-3xl p-6 shadow-sm border border-slate-200 hover:shadow-xl hover:-translate-y-1 transition min-h-[260px] flex flex-col">
                    <div class="absolute -top-10 -right-10 w-28 h-28 bg-amber-100 rounded-full blur-2xl group-hover:bg-amber-200 transition"></div>
                    <div class="relative flex flex-col h-full">
                        <div class="flex items-center justify-between mb-6">
                            <div class="w-14 h-14 rounded-2xl bg-amber-100 text-amber-900 flex items-center justify-center font-bold text-lg">
                                04
                            </div>
                            <span class="px-3 py-1 rounded-full bg-amber-50 text-amber-700 text-xs font-bold">
                                Gudang
                            </span>
                        </div>
                        <p class="text-sm text-slate-500">Penerimaan</p>
                        <h3 class="text-2xl font-bold text-slate-900 mt-1 group-hover:text-amber-900">
                            Laporan Penerimaan
                        </h3>
                        <p class="text-sm text-slate-500 mt-3 leading-relaxed">
                            Lihat seluruh laporan penerimaan barang yang dibuat gudang setelah material tiba dan diperiksa.
                        </p>
                        <div class="mt-auto pt-6 flex items-center justify-between">
                            <span class="text-sm font-bold text-amber-900">Lihat Laporan &rarr;</span>
                            <span class="w-9 h-9 rounded-xl bg-amber-800 text-white flex items-center justify-center group-hover:bg-amber-900 transition">
                                →
                            </span>
                        </div>
                    </div>
                </a>

                {{-- 05 Monitoring Pengadaan Material --}}
                <a href="{{ route('supply-chain.monitoring.index') }}"
                    class="md:col-span-2 group relative overflow-hidden bg-white rounded-3xl p-6 shadow-sm border border-slate-200 hover:shadow-xl hover:-translate-y-1 transition min-h-[260px] flex flex-col">
                    <div class="absolute -top-10 -right-10 w-40 h-40 bg-pink-100 rounded-full blur-2xl group-hover:bg-pink-200 transition"></div>
                    <div class="relative flex flex-col h-full">
                        <div class="flex items-center justify-between mb-6">
                            <div class="w-14 h-14 rounded-2xl bg-pink-100 text-pink-900 flex items-center justify-center font-bold text-lg">
                                05
                            </div>
                            <span class="px-3 py-1 rounded-full bg-pink-50 text-pink-700 text-xs font-bold">
                                Tracking
                            </span>
                        </div>
                        <p class="text-sm text-slate-500">Monitoring</p>
                        <h3 class="text-2xl font-bold text-slate-900 mt-1 group-hover:text-pink-900">
                            Monitoring Pengadaan Material
                        </h3>
                        <p class="text-sm text-slate-500 mt-3 leading-relaxed max-w-xl">
                            Pantau proses pengadaan material mulai dari tender dibuat, barang dikirim vendor, hingga barang diterima oleh gudang.
                        </p>
                        <div class="mt-auto pt-6 flex items-center justify-between max-w-[200px]">
                            <span class="text-sm font-bold text-pink-900">Lihat Monitoring &rarr;</span>
                            <span class="w-9 h-9 rounded-xl bg-pink-700 text-white flex items-center justify-center group-hover:bg-pink-800 transition">
                                →
                            </span>
                        </div>
                    </div>
                </a>

            </div>
        </div>
    </div>
</x-app-layout>
