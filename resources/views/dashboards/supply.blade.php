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
            <div class="bg-white rounded-2xl p-8 md:p-10 shadow-sm border border-slate-200 mb-8 flex flex-col lg:flex-row gap-8 items-center justify-between">
                <div class="max-w-3xl">
                    <h3 class="text-3xl md:text-4xl font-extrabold mb-4 tracking-tight text-slate-900">
                        Kelola Pengadaan Material, <span class="text-transparent bg-clip-text bg-gradient-to-r from-slate-900 to-blue-900">{{ Auth::user()->name }}</span>
                    </h3>

                    <p class="text-slate-600 text-sm md:text-base leading-relaxed mb-8 max-w-2xl">
                        Dashboard ini digunakan Supply Chain untuk memproses pengajuan material
                        yang sudah disetujui Planner, mengelola vendor, membuat tender,
                        memantau penawaran, dan menentukan vendor pemenang.
                    </p>

                    <div class="flex flex-col sm:flex-row gap-4">
                        <a href="{{ route('supply-chain.material-requests.index') }}"
                            class="inline-flex items-center justify-center px-7 py-4 bg-gradient-to-r from-slate-900 to-blue-900 text-white rounded-xl font-bold shadow-md hover:from-slate-800 hover:to-blue-800 transition-all hover:-translate-y-0.5">
                            Permintaan Planner
                        </a>

                        <a href="{{ route('supply-chain.tenders.index') }}"
                            class="inline-flex items-center justify-center px-7 py-4 bg-white text-slate-700 border border-slate-300 rounded-xl font-bold shadow-sm hover:bg-slate-50 transition-all hover:-translate-y-0.5">
                            Kelola Tender
                        </a>
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
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-12">

                {{-- 01 Kelola Vendor (Blue) --}}
                <a href="{{ route('supply-chain.vendors.index') }}"
                    class="group relative flex flex-col bg-white rounded-2xl border border-slate-200 hover:border-blue-300 transition-all duration-300 overflow-hidden h-full shadow-sm hover:shadow-md">
                    
                    <div class="absolute top-0 left-1/2 -translate-x-1/2 w-32 h-1 bg-blue-500 opacity-0 group-hover:opacity-100 transition-opacity duration-300 rounded-b-md"></div>

                    <div class="p-6 md:p-8 flex-grow">
                        <div class="flex items-start gap-5">
                            <div class="w-14 h-14 rounded-2xl bg-blue-50 border border-blue-100 text-blue-600 flex items-center justify-center shrink-0 group-hover:bg-blue-600 group-hover:text-white transition-all duration-300 group-hover:scale-110 group-hover:-rotate-3">
                                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-lg font-bold text-slate-900 group-hover:text-blue-600 transition-colors mb-2">
                                    Kelola Vendor
                                </h3>
                                <p class="text-sm text-slate-500 leading-relaxed">
                                    Tambah, edit, lihat detail, dan atur status vendor penyedia material kapal.
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="mt-auto px-8 py-4 bg-slate-50 border-t border-slate-100 flex items-center justify-between group-hover:bg-blue-50 transition-colors">
                        <span class="text-sm font-semibold text-slate-600 group-hover:text-blue-700 transition-colors">Buka Vendor</span>
                        <svg class="w-5 h-5 text-slate-400 group-hover:text-blue-600 transition-all group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                        </svg>
                    </div>
                </a>

                {{-- 02 Permintaan dari Planner (Cyan) --}}
                <a href="{{ route('supply-chain.material-requests.index') }}"
                    class="group relative flex flex-col bg-white rounded-2xl border border-slate-200 hover:border-cyan-300 transition-all duration-300 overflow-hidden h-full shadow-sm hover:shadow-md">
                    
                    <div class="absolute top-0 left-1/2 -translate-x-1/2 w-32 h-1 bg-cyan-500 opacity-0 group-hover:opacity-100 transition-opacity duration-300 rounded-b-md"></div>

                    <div class="p-6 md:p-8 flex-grow">
                        <div class="flex items-start gap-5">
                            <div class="w-14 h-14 rounded-2xl bg-cyan-50 border border-cyan-100 text-cyan-600 flex items-center justify-center shrink-0 group-hover:bg-cyan-600 group-hover:text-white transition-all duration-300 group-hover:scale-110 group-hover:-rotate-3">
                                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-lg font-bold text-slate-900 group-hover:text-cyan-600 transition-colors mb-2">
                                    Permintaan dari Planner
                                </h3>
                                <p class="text-sm text-slate-500 leading-relaxed">
                                    Lihat pengajuan material yang sudah disetujui Planner dan siap diproses ke tahap tender.
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="mt-auto px-8 py-4 bg-slate-50 border-t border-slate-100 flex items-center justify-between group-hover:bg-cyan-50 transition-colors">
                        <span class="text-sm font-semibold text-slate-600 group-hover:text-cyan-700 transition-colors">Lihat Pengajuan</span>
                        <svg class="w-5 h-5 text-slate-400 group-hover:text-cyan-600 transition-all group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                        </svg>
                    </div>
                </a>

                {{-- 03 Kelola Tender (Indigo) --}}
                <a href="{{ route('supply-chain.tenders.index') }}"
                    class="group relative flex flex-col bg-white rounded-2xl border border-slate-200 hover:border-indigo-300 transition-all duration-300 overflow-hidden h-full shadow-sm hover:shadow-md">
                    
                    <div class="absolute top-0 left-1/2 -translate-x-1/2 w-32 h-1 bg-indigo-500 opacity-0 group-hover:opacity-100 transition-opacity duration-300 rounded-b-md"></div>

                    <div class="p-6 md:p-8 flex-grow">
                        <div class="flex items-start gap-5">
                            <div class="w-14 h-14 rounded-2xl bg-indigo-50 border border-indigo-100 text-indigo-600 flex items-center justify-center shrink-0 group-hover:bg-indigo-600 group-hover:text-white transition-all duration-300 group-hover:scale-110 group-hover:-rotate-3">
                                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-lg font-bold text-slate-900 group-hover:text-indigo-600 transition-colors mb-2">
                                    Kelola Tender
                                </h3>
                                <p class="text-sm text-slate-500 leading-relaxed">
                                    Buat tender, undang vendor, lihat penawaran, dan pilih vendor pemenang.
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="mt-auto px-8 py-4 bg-slate-50 border-t border-slate-100 flex items-center justify-between group-hover:bg-indigo-50 transition-colors">
                        <span class="text-sm font-semibold text-slate-600 group-hover:text-indigo-700 transition-colors">Masuk ke Tender</span>
                        <svg class="w-5 h-5 text-slate-400 group-hover:text-indigo-600 transition-all group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                        </svg>
                    </div>
                </a>

                {{-- 04 Laporan Penerimaan (Amber) --}}
                <a href="{{ route('supply-chain.goods-receipt-reports.index') }}"
                    class="group relative flex flex-col bg-white rounded-2xl border border-slate-200 hover:border-amber-300 transition-all duration-300 overflow-hidden h-full shadow-sm hover:shadow-md">
                    
                    <div class="absolute top-0 left-1/2 -translate-x-1/2 w-32 h-1 bg-amber-500 opacity-0 group-hover:opacity-100 transition-opacity duration-300 rounded-b-md"></div>

                    <div class="p-6 md:p-8 flex-grow">
                        <div class="flex items-start gap-5">
                            <div class="w-14 h-14 rounded-2xl bg-amber-50 border border-amber-100 text-amber-600 flex items-center justify-center shrink-0 group-hover:bg-amber-600 group-hover:text-white transition-all duration-300 group-hover:scale-110 group-hover:-rotate-3">
                                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-lg font-bold text-slate-900 group-hover:text-amber-600 transition-colors mb-2">
                                    Laporan Penerimaan
                                </h3>
                                <p class="text-sm text-slate-500 leading-relaxed">
                                    Lihat seluruh laporan penerimaan barang yang dibuat gudang setelah material tiba.
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="mt-auto px-8 py-4 bg-slate-50 border-t border-slate-100 flex items-center justify-between group-hover:bg-amber-50 transition-colors">
                        <span class="text-sm font-semibold text-slate-600 group-hover:text-amber-700 transition-colors">Lihat Laporan</span>
                        <svg class="w-5 h-5 text-slate-400 group-hover:text-amber-600 transition-all group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                        </svg>
                    </div>
                </a>

                {{-- 05 Monitoring Pengadaan Material (Pink) --}}
                <a href="{{ route('supply-chain.monitoring.index') }}"
                    class="group relative flex flex-col bg-white rounded-2xl border border-slate-200 hover:border-pink-300 transition-all duration-300 overflow-hidden h-full shadow-sm hover:shadow-md">
                    
                    <div class="absolute top-0 left-1/2 -translate-x-1/2 w-32 h-1 bg-pink-500 opacity-0 group-hover:opacity-100 transition-opacity duration-300 rounded-b-md"></div>

                    <div class="p-6 md:p-8 flex-grow">
                        <div class="flex items-start gap-5">
                            <div class="w-14 h-14 rounded-2xl bg-pink-50 border border-pink-100 text-pink-600 flex items-center justify-center shrink-0 group-hover:bg-pink-600 group-hover:text-white transition-all duration-300 group-hover:scale-110 group-hover:-rotate-3">
                                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-lg font-bold text-slate-900 group-hover:text-pink-600 transition-colors mb-2">
                                    Monitoring Pengadaan
                                </h3>
                                <p class="text-sm text-slate-500 leading-relaxed">
                                    Pantau proses pengadaan material mulai dari tender dibuat hingga barang diterima oleh gudang.
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="mt-auto px-8 py-4 bg-slate-50 border-t border-slate-100 flex items-center justify-between group-hover:bg-pink-50 transition-colors">
                        <span class="text-sm font-semibold text-slate-600 group-hover:text-pink-700 transition-colors">Lihat Monitoring</span>
                        <svg class="w-5 h-5 text-slate-400 group-hover:text-pink-600 transition-all group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                        </svg>
                    </div>
                </a>

                {{-- 06 Daftar Purchase Order (Emerald) --}}
                <a href="{{ route('supply-chain.purchase-orders.index') }}"
                    class="group relative flex flex-col bg-white rounded-2xl border border-slate-200 hover:border-emerald-300 transition-all duration-300 overflow-hidden h-full shadow-sm hover:shadow-md">
                    
                    <div class="absolute top-0 left-1/2 -translate-x-1/2 w-32 h-1 bg-emerald-500 opacity-0 group-hover:opacity-100 transition-opacity duration-300 rounded-b-md"></div>

                    <div class="p-6 md:p-8 flex-grow">
                        <div class="flex items-start gap-5">
                            <div class="w-14 h-14 rounded-2xl bg-emerald-50 border border-emerald-100 text-emerald-600 flex items-center justify-center shrink-0 group-hover:bg-emerald-600 group-hover:text-white transition-all duration-300 group-hover:scale-110 group-hover:-rotate-3">
                                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-lg font-bold text-slate-900 group-hover:text-emerald-600 transition-colors mb-2">
                                    Daftar Purchase Order
                                </h3>
                                <p class="text-sm text-slate-500 leading-relaxed">
                                    Menampilkan daftar purchase order yang telah dibuat, detail PO, dan status pengadaan.
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="mt-auto px-8 py-4 bg-slate-50 border-t border-slate-100 flex items-center justify-between group-hover:bg-emerald-50 transition-colors">
                        <span class="text-sm font-semibold text-slate-600 group-hover:text-emerald-700 transition-colors">Lihat Daftar PO</span>
                        <svg class="w-5 h-5 text-slate-400 group-hover:text-emerald-600 transition-all group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                        </svg>
                    </div>
                </a>

            </div>
        </div>
    </div>
</x-app-layout>

