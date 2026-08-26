<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3">
            <div>
                <h2 class="font-bold text-2xl text-slate-900 leading-tight">
                    Dashboard Engineer
                </h2>
                <p class="text-sm text-slate-500 mt-1">
                    Pengajuan kebutuhan material kapal, monitoring status permintaan, dan klarifikasi spesifikasi.
                </p>
            </div>

            <div class="inline-flex items-center gap-2 text-sm text-blue-700 bg-blue-50 px-4 py-2.5 rounded-xl border border-blue-100 shadow-sm font-medium">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                </svg>
                <span>{{ now()->translatedFormat('d F Y') }}</span>
            </div>
        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 py-6">

        {{-- Hero Banner --}}
        <div class="bg-white rounded-2xl p-8 md:p-10 shadow-sm border border-slate-200 mb-8 flex flex-col lg:flex-row gap-8 items-center justify-between">
            <div class="max-w-3xl">
                <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-lg bg-blue-50 border border-blue-100 text-blue-700 text-xs font-bold mb-5 shadow-sm">
                    <span class="w-1.5 h-1.5 rounded-full bg-blue-500"></span>
                    Sistem Manajemen Pengadaan
                </div>
                
                <h3 class="text-3xl md:text-4xl font-extrabold leading-tight mb-4 tracking-tight text-slate-900">
                    Ajukan Material & <span class="text-transparent bg-clip-text bg-gradient-to-r from-slate-900 to-blue-900">Kelola Pengajuan</span>
                </h3>

                <p class="text-slate-600 text-sm md:text-base leading-relaxed mb-8 max-w-2xl">
                    Buat permintaan kebutuhan material kapal secara langsung, pantau status persetujuan, dan tanggapi klarifikasi teknis dari vendor.
                </p>

                <div class="flex flex-wrap items-center gap-4">
                    <a href="{{ route('material-requests.create') }}"
                        class="inline-flex items-center gap-2 px-6 py-3 bg-gradient-to-r from-slate-900 to-blue-900 hover:from-slate-800 hover:to-blue-800 text-white rounded-xl font-bold text-sm shadow-md shadow-blue-500/20 transition-all hover:-translate-y-0.5 active:translate-y-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path>
                        </svg>
                        <span>Buat Pengajuan Baru</span>
                    </a>
                    <a href="{{ route('material-requests.index') }}"
                        class="inline-flex items-center gap-2 px-6 py-3 bg-white hover:bg-slate-50 text-slate-700 rounded-xl font-semibold text-sm border border-slate-200 shadow-sm transition-all hover:-translate-y-0.5 active:translate-y-0">
                        <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                        </svg>
                        <span>Riwayat Pengajuan</span>
                    </a>
                </div>
            </div>
            

        </div>

        {{-- Menu Utama Engineer --}}
        <div class="mb-5 flex items-center gap-3">
            <div class="w-10 h-10 rounded-lg bg-white border border-slate-200 flex items-center justify-center text-blue-600 shadow-sm">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
            </div>
            <h3 class="text-xl font-bold text-slate-900 tracking-wide">
                Menu Utama Engineer
            </h3>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-12">

            {{-- 1. Permintaan Material (Blue) --}}
            <a href="{{ route('material-requests.create') }}"
                class="group relative flex flex-col bg-white rounded-2xl border border-slate-200 hover:border-blue-300 transition-all duration-300 overflow-hidden h-full shadow-sm hover:shadow-md">
                
                <div class="absolute top-0 left-1/2 -translate-x-1/2 w-32 h-1 bg-blue-500 opacity-0 group-hover:opacity-100 transition-opacity duration-300 rounded-b-md"></div>

                <div class="p-6 md:p-8 flex-grow">
                    <div class="flex items-start gap-5">
                        <div class="w-14 h-14 rounded-2xl bg-blue-50 border border-blue-100 text-blue-600 flex items-center justify-center shrink-0 group-hover:bg-blue-600 group-hover:text-white transition-all duration-300 group-hover:scale-110 group-hover:-rotate-3">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4v16m8-8H4"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-bold text-slate-900 group-hover:text-blue-600 transition-colors mb-2">
                                Buat Permintaan Material
                            </h3>
                            <p class="text-sm text-slate-500 leading-relaxed">
                                Formulir pengajuan kebutuhan material kapal baru berdasarkan spesifikasi proyek.
                            </p>
                        </div>
                    </div>
                </div>

                <div class="mt-auto px-8 py-4 bg-slate-50 border-t border-slate-100 flex items-center justify-between group-hover:bg-blue-50 transition-colors">
                    <span class="text-sm font-semibold text-slate-600 group-hover:text-blue-700 transition-colors">Akses Form Pengajuan</span>
                    <svg class="w-5 h-5 text-slate-400 group-hover:text-blue-600 transition-all group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                    </svg>
                </div>
            </a>

            {{-- 2. Daftar Pengajuan (Emerald) --}}
            <a href="{{ route('material-requests.index') }}"
                class="group relative flex flex-col bg-white rounded-2xl border border-slate-200 hover:border-emerald-300 transition-all duration-300 overflow-hidden h-full shadow-sm hover:shadow-md">
                
                <div class="absolute top-0 left-1/2 -translate-x-1/2 w-32 h-1 bg-emerald-500 opacity-0 group-hover:opacity-100 transition-opacity duration-300 rounded-b-md"></div>

                <div class="p-6 md:p-8 flex-grow">
                    <div class="flex items-start gap-5">
                        <div class="w-14 h-14 rounded-2xl bg-emerald-50 border border-emerald-100 text-emerald-600 flex items-center justify-center shrink-0 group-hover:bg-emerald-600 group-hover:text-white transition-all duration-300 group-hover:scale-110 group-hover:-rotate-3">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-bold text-slate-900 group-hover:text-emerald-600 transition-colors mb-2">
                                Riwayat Pengajuan
                            </h3>
                            <p class="text-sm text-slate-500 leading-relaxed">
                                Lihat status verifikasi planner dan daftar seluruh pengajuan material sebelumnya.
                            </p>
                        </div>
                    </div>
                </div>

                <div class="mt-auto px-8 py-4 bg-slate-50 border-t border-slate-100 flex items-center justify-between group-hover:bg-emerald-50 transition-colors">
                    <span class="text-sm font-semibold text-slate-600 group-hover:text-emerald-700 transition-colors">Lihat Daftar</span>
                    <svg class="w-5 h-5 text-slate-400 group-hover:text-emerald-600 transition-all group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                    </svg>
                </div>
            </a>

            {{-- 3. Klarifikasi Spesifikasi (Orange) --}}
            <a href="{{ route('engineer.clarifications.index') }}"
                class="group relative flex flex-col bg-white rounded-2xl border border-slate-200 hover:border-amber-300 transition-all duration-300 overflow-hidden h-full shadow-sm hover:shadow-md">
                
                <div class="absolute top-0 left-1/2 -translate-x-1/2 w-32 h-1 bg-amber-500 opacity-0 group-hover:opacity-100 transition-opacity duration-300 rounded-b-md"></div>

                <div class="p-6 md:p-8 flex-grow">
                    <div class="flex items-start gap-5">
                        <div class="w-14 h-14 rounded-2xl bg-amber-50 border border-amber-100 text-amber-600 flex items-center justify-center shrink-0 group-hover:bg-amber-500 group-hover:text-white transition-all duration-300 group-hover:scale-110 group-hover:-rotate-3">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-bold text-slate-900 group-hover:text-amber-600 transition-colors mb-2">
                                Klarifikasi Teknis
                            </h3>
                            <p class="text-sm text-slate-500 leading-relaxed">
                                Diskusi teknis dan tanya jawab langsung dengan vendor mengenai material yang ditenderkan.
                            </p>
                        </div>
                    </div>
                </div>

                <div class="mt-auto px-8 py-4 bg-slate-50 border-t border-slate-100 flex items-center justify-between group-hover:bg-amber-50 transition-colors">
                    <span class="text-sm font-semibold text-slate-600 group-hover:text-amber-700 transition-colors">Buka Ruang Obrolan</span>
                    <svg class="w-5 h-5 text-slate-400 group-hover:text-amber-600 transition-all group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                    </svg>
                </div>
            </a>

            {{-- 4. Monitoring Kebutuhan Material (Purple) --}}
            <a href="{{ route('engineer.monitoring.index') }}"
                class="group relative flex flex-col bg-white rounded-2xl border border-slate-200 hover:border-purple-300 transition-all duration-300 overflow-hidden h-full shadow-sm hover:shadow-md">
                
                <div class="absolute top-0 left-1/2 -translate-x-1/2 w-32 h-1 bg-purple-500 opacity-0 group-hover:opacity-100 transition-opacity duration-300 rounded-b-md"></div>

                <div class="p-6 md:p-8 flex-grow">
                    <div class="flex items-start gap-5">
                        <div class="w-14 h-14 rounded-2xl bg-purple-50 border border-purple-100 text-purple-600 flex items-center justify-center shrink-0 group-hover:bg-purple-600 group-hover:text-white transition-all duration-300 group-hover:scale-110 group-hover:-rotate-3">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-bold text-slate-900 group-hover:text-purple-600 transition-colors mb-2">
                                Monitoring Pengadaan
                            </h3>
                            <p class="text-sm text-slate-500 leading-relaxed">
                                Lacak proses pengadaan dari Tender, PO, hingga penerimaan di Gudang.
                            </p>
                        </div>
                    </div>
                </div>

                <div class="mt-auto px-8 py-4 bg-slate-50 border-t border-slate-100 flex items-center justify-between group-hover:bg-purple-50 transition-colors">
                    <span class="text-sm font-semibold text-slate-600 group-hover:text-purple-700 transition-colors">Pantau Progres</span>
                    <svg class="w-5 h-5 text-slate-400 group-hover:text-purple-600 transition-all group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                    </svg>
                </div>
            </a>

        </div>

    </div>
</x-app-layout>
