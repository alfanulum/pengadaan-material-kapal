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
            <div id="modal-penolakan" class="fixed inset-0 z-50 flex items-center justify-center bg-slate-900/50 backdrop-blur-sm p-4">
                <div class="bg-white rounded-2xl shadow-2xl max-w-lg w-full relative overflow-hidden">
                    <!-- Top border accent -->
                    <div class="absolute top-0 left-0 right-0 h-1.5 bg-rose-500"></div>
                    
                    <!-- Close X Button -->
                    <button onclick="document.getElementById('modal-penolakan').classList.add('hidden')" class="absolute top-5 right-5 text-slate-400 hover:text-slate-600 transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>

                    <div class="p-8">
                        <div class="flex items-start gap-4 mb-5">
                            <div class="w-12 h-12 rounded-full bg-rose-100 flex items-center justify-center shrink-0">
                                <svg class="w-6 h-6 text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                            </div>
                            <div>
                                <h3 class="text-xl font-bold text-slate-900">Registrasi Ditolak</h3>
                                <p class="text-sm text-slate-500 mt-1">Akun Vendor Anda belum disetujui.</p>
                            </div>
                        </div>

                        <p class="text-slate-600 text-sm leading-relaxed mb-6">
                            Mohon maaf, registrasi akun Vendor Anda belum dapat disetujui oleh tim Supply Chain karena alasan berikut:
                        </p>

                        <div class="p-4 bg-rose-50 border border-rose-100 rounded-xl mb-8">
                            <p class="text-xs font-bold text-rose-600 uppercase tracking-wider mb-2">Alasan Penolakan</p>
                            <p class="text-sm text-rose-800 font-medium">{{ $vendor->alasan_penolakan ?? '-' }}</p>
                        </div>

                        <div class="flex gap-3">
                            <form method="POST" action="{{ route('logout') }}" class="w-1/3">
                                @csrf
                                <button type="submit" class="w-full inline-flex items-center justify-center px-4 py-2.5 bg-white border border-slate-300 text-slate-700 rounded-lg text-sm font-semibold hover:bg-slate-50 transition-all shadow-sm">
                                    Keluar
                                </button>
                            </form>
                            <a href="{{ route('vendor.resubmit') }}" class="w-2/3 inline-flex items-center justify-center px-4 py-2.5 bg-indigo-600 text-white rounded-lg text-sm font-semibold hover:bg-indigo-500 transition-all shadow-sm">
                                Perbaiki Data Registrasi
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Pesan permanen di halaman --}}
            <div class="mb-8 rounded-xl border border-rose-200 bg-white shadow-sm overflow-hidden relative">
                <div class="absolute left-0 top-0 bottom-0 w-1.5 bg-rose-500"></div>
                <div class="p-6 sm:p-8 flex flex-col md:flex-row gap-6">
                    <div class="w-12 h-12 rounded-full bg-rose-100 flex items-center justify-center shrink-0">
                        <svg class="w-6 h-6 text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                    </div>
                    <div class="flex-1">
                        <h3 class="text-lg font-bold text-slate-900">Registrasi Ditolak</h3>
                        <p class="text-sm text-slate-600 mt-1 mb-4 leading-relaxed max-w-3xl">
                            Registrasi akun Vendor Anda belum dapat disetujui. Silakan perbaiki data registrasi Anda berdasarkan alasan penolakan di bawah ini.
                        </p>
                        <div class="p-4 bg-rose-50 rounded-lg border border-rose-100 mb-6 max-w-3xl">
                            <p class="text-xs font-bold text-rose-600 uppercase tracking-wider mb-2">Alasan Penolakan</p>
                            <p class="text-sm text-rose-800 font-medium">{{ $vendor->alasan_penolakan ?? '-' }}</p>
                        </div>
                        <div class="flex flex-wrap gap-3">
                            <a href="{{ route('vendor.resubmit') }}" class="inline-flex items-center px-5 py-2.5 bg-indigo-600 text-white rounded-lg text-sm font-semibold hover:bg-indigo-500 shadow-sm transition-all">
                                Perbaiki Data Registrasi
                            </a>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="inline-flex items-center px-5 py-2.5 bg-white border border-slate-300 text-slate-700 rounded-lg text-sm font-semibold hover:bg-slate-50 shadow-sm transition-all">
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

            {{-- Header dengan status menunggu --}}
            <div class="bg-white rounded-xl shadow-sm border border-amber-200 mb-8 overflow-hidden relative">
                <div class="absolute top-0 left-0 right-0 h-1.5 bg-amber-400"></div>
                <div class="p-8 md:p-10 flex flex-col lg:flex-row gap-8 items-start lg:items-center">
                    <div class="w-20 h-20 rounded-full bg-amber-50 border border-amber-100 flex items-center justify-center shrink-0">
                        <svg class="w-10 h-10 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <div class="flex-1">
                        <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-md bg-amber-50 border border-amber-100 text-amber-700 text-xs font-bold mb-4">
                            <span class="w-2 h-2 rounded-full bg-amber-500 animate-pulse"></span>
                            REGISTRASI SEDANG DIPERIKSA
                        </div>
                        <h3 class="text-2xl md:text-3xl font-extrabold text-slate-900 tracking-tight mb-2">
                            Akun Anda Menunggu Persetujuan
                        </h3>
                        <p class="text-slate-600 text-base leading-relaxed max-w-3xl">
                            Data registrasi Anda telah kami terima dan saat ini sedang dalam proses peninjauan oleh tim Supply Chain. Seluruh fitur Portal Vendor akan dapat Anda gunakan setelah registrasi disetujui.
                        </p>
                        @if ($vendor)
                            <div class="mt-5 flex items-center gap-2 text-sm font-medium text-slate-500">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                Tanggal registrasi: {{ $vendor->tanggal_daftar ? $vendor->tanggal_daftar->format('d M Y, H:i') : $vendor->created_at->format('d M Y, H:i') }}
                            </div>
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

            {{-- Hero Banner --}}
            <div class="bg-white rounded-2xl p-8 md:p-10 shadow-sm border border-slate-200 mb-8 flex flex-col lg:flex-row gap-8 items-center justify-between">
                <div class="max-w-3xl">
                    <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-lg bg-blue-50 border border-blue-100 text-blue-700 text-xs font-bold mb-5 shadow-sm">
                        <span class="w-1.5 h-1.5 rounded-full bg-blue-500"></span>
                        Portal Vendor
                    </div>
                    
                    <h3 class="text-3xl md:text-4xl font-extrabold leading-tight mb-4 tracking-tight text-slate-900">
                        Pantau Tender & <span class="text-transparent bg-clip-text bg-gradient-to-r from-slate-900 to-blue-900">Purchase Order</span>
                    </h3>

                    <p class="text-slate-600 text-sm md:text-base leading-relaxed mb-8 max-w-2xl">
                        Selamat datang, {{ Auth::user()->name }}. Vendor dapat membuka tender yang diterima, mengirim penawaran harga, melihat Purchase Order setelah terpilih, dan menyiapkan proses pengiriman material.
                    </p>

                    <div class="flex flex-wrap items-center gap-4">
                        <a href="{{ route('vendor.tenders.index') }}"
                            class="inline-flex items-center gap-2 px-6 py-3 bg-gradient-to-r from-slate-900 to-blue-900 hover:from-slate-800 hover:to-blue-800 text-white rounded-xl font-bold text-sm shadow-md shadow-blue-500/20 transition-all hover:-translate-y-0.5 active:translate-y-0">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                            </svg>
                            <span>Buka Tender Masuk</span>
                        </a>
                        <a href="{{ route('vendor.purchase-orders.index') }}"
                            class="inline-flex items-center gap-2 px-6 py-3 bg-white hover:bg-slate-50 text-slate-700 rounded-xl font-semibold text-sm border border-slate-200 shadow-sm transition-all hover:-translate-y-0.5 active:translate-y-0">
                            <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            <span>Lihat Purchase Order</span>
                        </a>
                    </div>
                </div>
            </div>

            {{-- Menu Utama Vendor --}}
            <div class="mb-5 flex items-center gap-3">
                <div class="w-10 h-10 rounded-lg bg-white border border-slate-200 flex items-center justify-center text-blue-600 shadow-sm">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                </div>
                <h3 class="text-xl font-bold text-slate-900 tracking-wide">
                    Menu Utama Vendor
                </h3>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-12">

                {{-- 1. Tender Masuk (Blue) --}}
                <a href="{{ route('vendor.tenders.index') }}"
                    class="group relative flex flex-col bg-white rounded-2xl border border-slate-200 hover:border-blue-300 transition-all duration-300 overflow-hidden h-full shadow-sm hover:shadow-md">
                    
                    <div class="absolute top-0 left-1/2 -translate-x-1/2 w-32 h-1 bg-blue-500 opacity-0 group-hover:opacity-100 transition-opacity duration-300 rounded-b-md"></div>

                    <div class="p-6 md:p-8 flex-grow">
                        <div class="flex items-start gap-5">
                            <div class="w-14 h-14 rounded-2xl bg-blue-50 border border-blue-100 text-blue-600 flex items-center justify-center shrink-0 group-hover:bg-blue-600 group-hover:text-white transition-all duration-300 group-hover:scale-110 group-hover:-rotate-3">
                                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-lg font-bold text-slate-900 group-hover:text-blue-600 transition-colors mb-2">
                                    Tender Masuk
                                </h3>
                                <p class="text-sm text-slate-500 leading-relaxed">
                                    Lihat daftar undangan tender, detail kebutuhan material, deadline, dan kirim penawaran vendor.
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="mt-auto px-8 py-4 bg-slate-50 border-t border-slate-100 flex items-center justify-between group-hover:bg-blue-50 transition-colors">
                        <span class="text-sm font-semibold text-slate-600 group-hover:text-blue-700 transition-colors">Buka Tender</span>
                        <svg class="w-5 h-5 text-slate-400 group-hover:text-blue-600 transition-all group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                        </svg>
                    </div>
                </a>

                {{-- 2. Purchase Order Masuk (Emerald) --}}
                <a href="{{ route('vendor.purchase-orders.index') }}"
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
                                    Purchase Order Masuk
                                </h3>
                                <p class="text-sm text-slate-500 leading-relaxed">
                                    Lihat PO yang dikirim Supply Chain setelah vendor dipilih sebagai pemenang tender.
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="mt-auto px-8 py-4 bg-slate-50 border-t border-slate-100 flex items-center justify-between group-hover:bg-emerald-50 transition-colors">
                        <span class="text-sm font-semibold text-slate-600 group-hover:text-emerald-700 transition-colors">Lihat PO</span>
                        <svg class="w-5 h-5 text-slate-400 group-hover:text-emerald-600 transition-all group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                        </svg>
                    </div>
                </a>

            </div>

            {{-- Alur Kerja Vendor --}}
            <div class="bg-white rounded-2xl shadow-sm border border-slate-200 mb-8 p-8">
                <div class="mb-6 flex items-center justify-between">
                    <div>
                        <h3 class="text-lg font-bold text-slate-900">Alur Kerja Vendor</h3>
                        <p class="text-sm text-slate-500 mt-1">Tahapan yang dilalui vendor dalam pengadaan material kapal.</p>
                    </div>
                </div>

                <div class="relative">
                    <div class="hidden md:block absolute top-1/2 left-0 w-full h-0.5 bg-slate-100 -translate-y-1/2 z-0"></div>
                    <div class="grid grid-cols-1 md:grid-cols-5 gap-6 relative z-10">
                        
                        <div class="bg-white group">
                            <div class="w-12 h-12 rounded-2xl bg-blue-50 text-blue-600 border border-blue-100 flex items-center justify-center font-bold mb-4 mx-auto md:mx-0 group-hover:scale-110 transition-transform duration-300 shadow-sm">
                                1
                            </div>
                            <h4 class="font-bold text-slate-900 text-center md:text-left mb-2">Terima Tender</h4>
                            <p class="text-sm text-slate-500 text-center md:text-left leading-relaxed">Tender dikirim oleh Supply Chain.</p>
                        </div>

                        <div class="bg-white group">
                            <div class="w-12 h-12 rounded-2xl bg-cyan-50 text-cyan-600 border border-cyan-100 flex items-center justify-center font-bold mb-4 mx-auto md:mx-0 group-hover:scale-110 transition-transform duration-300 shadow-sm">
                                2
                            </div>
                            <h4 class="font-bold text-slate-900 text-center md:text-left mb-2">Cek Material</h4>
                            <p class="text-sm text-slate-500 text-center md:text-left leading-relaxed">Lihat detail spesifikasi dan catatan.</p>
                        </div>

                        <div class="bg-white group">
                            <div class="w-12 h-12 rounded-2xl bg-emerald-50 text-emerald-600 border border-emerald-100 flex items-center justify-center font-bold mb-4 mx-auto md:mx-0 group-hover:scale-110 transition-transform duration-300 shadow-sm">
                                3
                            </div>
                            <h4 class="font-bold text-slate-900 text-center md:text-left mb-2">Penawaran</h4>
                            <p class="text-sm text-slate-500 text-center md:text-left leading-relaxed">Kirim harga dan estimasi pengiriman.</p>
                        </div>

                        <div class="bg-white group">
                            <div class="w-12 h-12 rounded-2xl bg-amber-50 text-amber-600 border border-amber-100 flex items-center justify-center font-bold mb-4 mx-auto md:mx-0 group-hover:scale-110 transition-transform duration-300 shadow-sm">
                                4
                            </div>
                            <h4 class="font-bold text-slate-900 text-center md:text-left mb-2">Terima PO</h4>
                            <p class="text-sm text-slate-500 text-center md:text-left leading-relaxed">Vendor terpilih menerima Purchase Order.</p>
                        </div>

                        <div class="bg-white group">
                            <div class="w-12 h-12 rounded-2xl bg-purple-50 text-purple-600 border border-purple-100 flex items-center justify-center font-bold mb-4 mx-auto md:mx-0 group-hover:scale-110 transition-transform duration-300 shadow-sm">
                                5
                            </div>
                            <h4 class="font-bold text-slate-900 text-center md:text-left mb-2">Pengiriman</h4>
                            <p class="text-sm text-slate-500 text-center md:text-left leading-relaxed">Kirim material sesuai deadline.</p>
                        </div>

                    </div>
                </div>
            </div>

        @endif

    </div>
</x-app-layout>
