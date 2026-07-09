<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3">
            <div>
                <h2 class="font-bold text-2xl text-slate-900 leading-tight">
                    Dashboard Engineer
                </h2>
                <p class="text-sm text-slate-500 mt-1">
                    Pengajuan kebutuhan material kapal, monitoring status permintaan, dan klarifikasi spesifikasi
                    vendor.
                </p>
            </div>

            <div class="text-sm text-slate-600 bg-white px-4 py-2 rounded-xl border border-slate-200 shadow-sm">
                {{ now()->format('d M Y') }}
            </div>
        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        {{-- Hero --}}
        <div
            class="bg-gradient-to-r from-slate-950 via-blue-950 to-blue-800 rounded-3xl p-8 md:p-10 shadow-xl text-white mb-8 overflow-hidden relative">
            <div class="absolute -top-24 -right-24 w-80 h-80 bg-cyan-400/20 rounded-full blur-3xl"></div>
            <div class="absolute -bottom-24 -left-24 w-80 h-80 bg-blue-400/20 rounded-full blur-3xl"></div>

            <div class="relative z-10 grid grid-cols-1 lg:grid-cols-3 gap-8 items-center">
                <div class="lg:col-span-2">
                    <p
                        class="inline-flex px-4 py-2 rounded-full bg-white/10 border border-white/10 text-sm text-blue-100 mb-5">
                        PT PAL Material Request System
                    </p>

                    <h3 class="text-3xl md:text-5xl font-bold leading-tight">
                        Ajukan Material dan Jawab Klarifikasi Teknis
                    </h3>

                    <p class="mt-5 text-blue-100 max-w-3xl text-base md:text-lg leading-relaxed">
                        Engineer dapat membuat permintaan material, menambahkan detail kebutuhan,
                        memantau status pengajuan, serta menjawab pertanyaan vendor terkait spesifikasi material.
                    </p>

                    <div class="mt-8 flex flex-wrap gap-4">
                        <a href="{{ route('material-requests.create') }}"
                            class="inline-flex items-center justify-center px-8 py-4 bg-white text-blue-950 rounded-2xl font-bold text-base shadow-lg hover:bg-slate-100 hover:-translate-y-1 transition">
                            Buat Pengajuan
                        </a>
                    </div>
                </div>

                <div class="bg-white/10 border border-white/10 rounded-3xl p-6 md:p-8">
                    <p class="text-sm text-blue-100">
                        Fokus Engineer
                    </p>

                    <h4 class="text-2xl font-bold mt-2">
                        Pengajuan → Verifikasi → Klarifikasi
                    </h4>

                    <p class="text-sm text-blue-100 mt-4 leading-relaxed">
                        Engineer berperan membuat kebutuhan material dan membantu vendor memahami spesifikasi teknis
                        sebelum vendor mengirimkan penawaran.
                    </p>

                    <div class="mt-6 grid grid-cols-2 gap-3">
                        <div class="bg-white/10 border border-white/10 rounded-2xl p-4">
                            <p class="text-xs text-blue-100">Aksi Utama</p>
                            <p class="font-bold mt-1">Ajukan Material</p>
                        </div>

                        <div class="bg-white/10 border border-white/10 rounded-2xl p-4">
                            <p class="text-xs text-blue-100">Teknis</p>
                            <p class="font-bold mt-1">Jawab Vendor</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Alur Kerja Engineer --}}
        <div class="bg-white rounded-3xl shadow-sm border border-slate-200 p-6 md:p-8 mb-8">
            <div class="mb-6">
                <h3 class="text-xl font-bold text-slate-900 flex items-center gap-2">
                    <span class="w-2.5 h-6 bg-blue-900 rounded-full inline-block"></span>
                    Alur Kerja Engineer
                </h3>
                <p class="text-sm text-slate-500 mt-1">
                    Ikuti tahapan berikut untuk membuat permintaan material, memantau status, dan menjawab klarifikasi teknis dari vendor.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                {{-- Step 1 --}}
                <div class="relative bg-slate-50 rounded-2xl p-5 border border-slate-100 hover:border-blue-200 transition group">
                    <div class="flex items-center justify-between mb-4">
                        <span class="text-xs font-bold text-blue-900 bg-blue-50 px-2.5 py-1 rounded-lg">Step 01</span>
                        <div class="w-8 h-8 rounded-full bg-blue-900/10 text-blue-900 flex items-center justify-center font-bold text-sm">1</div>
                    </div>
                    <h4 class="font-bold text-slate-900 group-hover:text-blue-950 transition">Buat Pengajuan Material</h4>
                    <p class="text-xs text-slate-500 mt-2 leading-relaxed">
                        Engineer membuat permintaan material berdasarkan kebutuhan proyek, spesifikasi barang, jumlah, dan tanggal kebutuhan.
                    </p>
                </div>

                {{-- Step 2 --}}
                <div class="relative bg-slate-50 rounded-2xl p-5 border border-slate-100 hover:border-blue-200 transition group">
                    <div class="flex items-center justify-between mb-4">
                        <span class="text-xs font-bold text-blue-900 bg-blue-50 px-2.5 py-1 rounded-lg">Step 02</span>
                        <div class="w-8 h-8 rounded-full bg-blue-900/10 text-blue-900 flex items-center justify-center font-bold text-sm">2</div>
                    </div>
                    <h4 class="font-bold text-slate-900 group-hover:text-blue-950 transition">Tunggu Verifikasi Planner</h4>
                    <p class="text-xs text-slate-500 mt-2 leading-relaxed">
                        Pengajuan yang sudah dibuat akan diperiksa oleh Planner. Jika data belum sesuai, pengajuan dapat dikembalikan untuk diperbaiki.
                    </p>
                </div>

                {{-- Step 3 --}}
                <div class="relative bg-slate-50 rounded-2xl p-5 border border-slate-100 hover:border-blue-200 transition group">
                    <div class="flex items-center justify-between mb-4">
                        <span class="text-xs font-bold text-blue-900 bg-blue-50 px-2.5 py-1 rounded-lg">Step 03</span>
                        <div class="w-8 h-8 rounded-full bg-blue-900/10 text-blue-900 flex items-center justify-center font-bold text-sm">3</div>
                    </div>
                    <h4 class="font-bold text-slate-900 group-hover:text-blue-950 transition">Pantau Monitoring Kebutuhan</h4>
                    <p class="text-xs text-slate-500 mt-2 leading-relaxed">
                        Setelah pengajuan diproses ke Supply Chain, Engineer dapat memantau perkembangan pengadaan material sampai barang diterima Gudang.
                    </p>
                </div>

                {{-- Step 4 --}}
                <div class="relative bg-slate-50 rounded-2xl p-5 border border-slate-100 hover:border-blue-200 transition group">
                    <div class="flex items-center justify-between mb-4">
                        <span class="text-xs font-bold text-blue-900 bg-blue-50 px-2.5 py-1 rounded-lg">Step 04</span>
                        <div class="w-8 h-8 rounded-full bg-blue-900/10 text-blue-900 flex items-center justify-center font-bold text-sm">4</div>
                    </div>
                    <h4 class="font-bold text-slate-900 group-hover:text-blue-950 transition">Jawab Klarifikasi Vendor</h4>
                    <p class="text-xs text-slate-500 mt-2 leading-relaxed">
                        Jika vendor memiliki pertanyaan terkait spesifikasi material, Engineer dapat menjawab melalui fitur klarifikasi teknis.
                    </p>
                </div>
            </div>
        </div>

        {{-- Menu Engineer --}}
        <div class="mb-6">
            <h3 class="text-xl font-bold text-slate-900">
                Menu Engineer
            </h3>
            <p class="text-sm text-slate-500 mt-1">
                Pilih fitur yang ingin digunakan untuk mengelola permintaan material dan klarifikasi teknis.
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">

            {{-- 01 Permintaan Material --}}
            <a href="{{ route('material-requests.create') }}"
                class="group relative overflow-hidden bg-white rounded-3xl p-6 shadow-sm border border-slate-200 hover:shadow-xl hover:-translate-y-1 transition min-h-[250px] flex flex-col">
                <div class="absolute -top-10 -right-10 w-28 h-28 bg-blue-100 rounded-full blur-2xl group-hover:bg-blue-200 transition"></div>
                <div class="relative flex flex-col h-full">
                    <div class="flex items-center justify-between mb-6">
                        <div class="w-14 h-14 rounded-2xl bg-blue-100 text-blue-900 flex items-center justify-center font-bold text-lg">
                            01
                        </div>
                        <span class="px-3 py-1 rounded-full bg-blue-50 text-blue-700 text-xs font-bold">
                            Form
                        </span>
                    </div>
                    <p class="text-sm text-slate-500">Pengajuan</p>
                    <h3 class="text-2xl font-bold text-slate-900 mt-1 group-hover:text-blue-900">
                        Permintaan Material
                    </h3>
                    <p class="text-sm text-slate-500 mt-3 leading-relaxed">
                        Membuat pengajuan kebutuhan material kapal berdasarkan proyek, spesifikasi, jumlah, dan tanggal kebutuhan.
                    </p>
                    <div class="mt-auto pt-6 flex items-center justify-between">
                        <span class="text-sm font-bold text-blue-900">Buat Pengajuan</span>
                        <span class="w-9 h-9 rounded-xl bg-blue-900 text-white flex items-center justify-center group-hover:bg-blue-950 transition">
                            →
                        </span>
                    </div>
                </div>
            </a>

            {{-- 02 Klarifikasi Spesifikasi --}}
            <a href="{{ route('engineer.clarifications.index') }}"
                class="group relative overflow-hidden bg-white rounded-3xl p-6 shadow-sm border border-slate-200 hover:shadow-xl hover:-translate-y-1 transition min-h-[250px] flex flex-col">
                <div class="absolute -top-10 -right-10 w-28 h-28 bg-cyan-100 rounded-full blur-2xl group-hover:bg-cyan-200 transition"></div>
                <div class="relative flex flex-col h-full">
                    <div class="flex items-center justify-between mb-6">
                        <div class="w-14 h-14 rounded-2xl bg-cyan-100 text-cyan-900 flex items-center justify-center font-bold text-lg">
                            02
                        </div>
                        <span class="px-3 py-1 rounded-full bg-cyan-50 text-cyan-700 text-xs font-bold">
                            Chat
                        </span>
                    </div>
                    <p class="text-sm text-slate-500">Spesifikasi</p>
                    <h3 class="text-2xl font-bold text-slate-900 mt-1 group-hover:text-cyan-900">
                        Klarifikasi Spesifikasi
                    </h3>
                    <p class="text-sm text-slate-500 mt-3 leading-relaxed">
                        Menjawab pertanyaan vendor terkait spesifikasi material agar vendor memahami kebutuhan sebelum mengirim penawaran.
                    </p>
                    <div class="mt-auto pt-6 flex items-center justify-between">
                        <span class="text-sm font-bold text-cyan-900">Buka Klarifikasi</span>
                        <span class="w-9 h-9 rounded-xl bg-cyan-900 text-white flex items-center justify-center group-hover:bg-cyan-950 transition">
                            →
                        </span>
                    </div>
                </div>
            </a>

            {{-- 03 Spesifikasi Material (Daftar Permintaan) --}}
            <a href="{{ route('material-requests.index') }}"
                class="group relative overflow-hidden bg-white rounded-3xl p-6 shadow-sm border border-slate-200 hover:shadow-xl hover:-translate-y-1 transition min-h-[250px] flex flex-col">
                <div class="absolute -top-10 -right-10 w-28 h-28 bg-indigo-100 rounded-full blur-2xl group-hover:bg-indigo-200 transition"></div>
                <div class="relative flex flex-col h-full">
                    <div class="flex items-center justify-between mb-6">
                        <div class="w-14 h-14 rounded-2xl bg-indigo-100 text-indigo-900 flex items-center justify-center font-bold text-lg">
                            03
                        </div>
                        <span class="px-3 py-1 rounded-full bg-indigo-50 text-indigo-700 text-xs font-bold">
                            Data
                        </span>
                    </div>
                    <p class="text-sm text-slate-500">Permintaan</p>
                    <h3 class="text-2xl font-bold text-slate-900 mt-1 group-hover:text-indigo-900">
                        Daftar Pengajuan
                    </h3>
                    <p class="text-sm text-slate-500 mt-3 leading-relaxed">
                        Melihat seluruh pengajuan material yang sudah dibuat beserta detail item dan status permintaannya.
                    </p>
                    <div class="mt-auto pt-6 flex items-center justify-between">
                        <span class="text-sm font-bold text-indigo-900">Lihat Daftar</span>
                        <span class="w-9 h-9 rounded-xl bg-indigo-900 text-white flex items-center justify-center group-hover:bg-indigo-950 transition">
                            →
                        </span>
                    </div>
                </div>
            </a>

            {{-- 04 Monitoring Kebutuhan Material --}}
            <a href="{{ route('engineer.monitoring.index') }}"
                class="group relative overflow-hidden bg-white rounded-3xl p-6 shadow-sm border border-slate-200 hover:shadow-xl hover:-translate-y-1 transition min-h-[250px] flex flex-col">
                <div class="absolute -top-10 -right-10 w-28 h-28 bg-emerald-100 rounded-full blur-2xl group-hover:bg-emerald-200 transition"></div>
                <div class="relative flex flex-col h-full">
                    <div class="flex items-center justify-between mb-6">
                        <div class="w-14 h-14 rounded-2xl bg-emerald-100 text-emerald-900 flex items-center justify-center font-bold text-lg">
                            04
                        </div>
                        <span class="px-3 py-1 rounded-full bg-emerald-50 text-emerald-700 text-xs font-bold">
                            Track
                        </span>
                    </div>
                    <p class="text-sm text-slate-500">Monitoring</p>
                    <h3 class="text-2xl font-bold text-slate-900 mt-1 group-hover:text-emerald-900">
                        Monitoring Kebutuhan Material
                    </h3>
                    <p class="text-sm text-slate-500 mt-3 leading-relaxed">
                        Pantau perkembangan kebutuhan material mulai dari pengajuan kebutuhan hingga proses pengadaan selesai.
                    </p>
                    <div class="mt-auto pt-6 flex items-center justify-between">
                        <span class="text-sm font-bold text-emerald-900">Pantau Proses &rarr;</span>
                        <span class="w-9 h-9 rounded-xl bg-emerald-900 text-white flex items-center justify-center group-hover:bg-emerald-950 transition">
                            →
                        </span>
                    </div>
                </div>
            </a>

        </div>
    </div>
</x-app-layout>
