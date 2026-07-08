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

                    <div class="mt-8 grid grid-cols-1 sm:grid-cols-3 gap-4 max-w-5xl">
                        <a href="{{ route('material-requests.create') }}"
                            class="flex items-center justify-center px-6 py-5 bg-white text-blue-950 rounded-2xl font-bold text-base shadow-lg hover:bg-slate-100 hover:-translate-y-1 transition">
                            Buat Pengajuan
                        </a>

                        <a href="{{ route('material-requests.index') }}"
                            class="flex items-center justify-center px-6 py-5 bg-white/10 text-white border border-white/20 rounded-2xl font-bold text-base shadow-lg hover:bg-white/20 hover:-translate-y-1 transition">
                            Lihat Permintaan
                        </a>

                        <a href="{{ route('engineer.clarifications.index') }}"
                            class="flex items-center justify-center px-6 py-5 bg-cyan-400/20 text-white border border-cyan-200/30 rounded-2xl font-bold text-base shadow-lg hover:bg-cyan-400/30 hover:-translate-y-1 transition">
                            Klarifikasi
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

        {{-- Summary Cards --}}
        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6 mb-8">
            <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-200">
                <p class="text-sm text-slate-500">Total Pengajuan</p>
                <h3 class="text-3xl font-bold text-slate-900 mt-2">Material</h3>
                <p class="text-xs text-slate-400 mt-2">
                    Permintaan material yang dibuat oleh Engineer.
                </p>
            </div>

            <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-200">
                <p class="text-sm text-slate-500">Status Pengajuan</p>
                <h3 class="text-3xl font-bold text-slate-900 mt-2">Menunggu</h3>
                <p class="text-xs text-slate-400 mt-2">
                    Pengajuan menunggu proses verifikasi Planner.
                </p>
            </div>

            <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-200">
                <p class="text-sm text-slate-500">Disetujui Planner</p>
                <h3 class="text-3xl font-bold text-slate-900 mt-2">Proses</h3>
                <p class="text-xs text-slate-400 mt-2">
                    Pengajuan siap diteruskan ke Supply Chain.
                </p>
            </div>

            <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-200">
                <p class="text-sm text-slate-500">Klarifikasi Vendor</p>
                <h3 class="text-3xl font-bold text-slate-900 mt-2">Teknis</h3>
                <p class="text-xs text-slate-400 mt-2">
                    Pertanyaan spesifikasi dari vendor dapat dijawab oleh Engineer.
                </p>
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

        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">

            {{-- 01 Buat Permintaan Material --}}
            <a href="{{ route('material-requests.create') }}"
                class="group relative overflow-hidden bg-white rounded-3xl p-6 shadow-sm border border-slate-200 hover:shadow-xl hover:-translate-y-1 transition min-h-[250px] flex flex-col">
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
                            Form
                        </span>
                    </div>

                    <p class="text-sm text-slate-500">Pengajuan</p>
                    <h3 class="text-2xl font-bold text-slate-900 mt-1 group-hover:text-blue-900">
                        Buat Permintaan Material
                    </h3>

                    <p class="text-sm text-slate-500 mt-3 leading-relaxed">
                        Membuat pengajuan kebutuhan material kapal berdasarkan proyek, spesifikasi, jumlah, dan tanggal
                        kebutuhan.
                    </p>

                    <div class="mt-auto pt-6 flex items-center justify-between">
                        <span class="text-sm font-bold text-blue-900">Buat Pengajuan</span>
                        <span
                            class="w-9 h-9 rounded-xl bg-blue-900 text-white flex items-center justify-center group-hover:bg-blue-950 transition">
                            →
                        </span>
                    </div>
                </div>
            </a>

            {{-- 02 Daftar Permintaan Material --}}
            <a href="{{ route('material-requests.index') }}"
                class="group relative overflow-hidden bg-white rounded-3xl p-6 shadow-sm border border-slate-200 hover:shadow-xl hover:-translate-y-1 transition min-h-[250px] flex flex-col">
                <div
                    class="absolute -top-10 -right-10 w-28 h-28 bg-indigo-100 rounded-full blur-2xl group-hover:bg-indigo-200 transition">
                </div>

                <div class="relative flex flex-col h-full">
                    <div class="flex items-center justify-between mb-6">
                        <div
                            class="w-14 h-14 rounded-2xl bg-indigo-100 text-indigo-900 flex items-center justify-center font-bold text-lg">
                            02
                        </div>

                        <span class="px-3 py-1 rounded-full bg-indigo-50 text-indigo-700 text-xs font-bold">
                            Data
                        </span>
                    </div>

                    <p class="text-sm text-slate-500">Permintaan</p>
                    <h3 class="text-2xl font-bold text-slate-900 mt-1 group-hover:text-indigo-900">
                        Daftar Permintaan Material
                    </h3>

                    <p class="text-sm text-slate-500 mt-3 leading-relaxed">
                        Melihat seluruh pengajuan material yang sudah dibuat beserta detail item dan status
                        permintaannya.
                    </p>

                    <div class="mt-auto pt-6 flex items-center justify-between">
                        <span class="text-sm font-bold text-indigo-900">Lihat Daftar</span>
                        <span
                            class="w-9 h-9 rounded-xl bg-indigo-900 text-white flex items-center justify-center group-hover:bg-indigo-950 transition">
                            →
                        </span>
                    </div>
                </div>
            </a>

            {{-- 03 Klarifikasi Spesifikasi --}}
            <a href="{{ route('engineer.clarifications.index') }}"
                class="group relative overflow-hidden bg-white rounded-3xl p-6 shadow-sm border border-slate-200 hover:shadow-xl hover:-translate-y-1 transition min-h-[250px] flex flex-col">
                <div
                    class="absolute -top-10 -right-10 w-28 h-28 bg-cyan-100 rounded-full blur-2xl group-hover:bg-cyan-200 transition">
                </div>

                <div class="relative flex flex-col h-full">
                    <div class="flex items-center justify-between mb-6">
                        <div
                            class="w-14 h-14 rounded-2xl bg-cyan-100 text-cyan-900 flex items-center justify-center font-bold text-lg">
                            03
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
                        Menjawab pertanyaan vendor terkait spesifikasi material agar vendor memahami kebutuhan sebelum
                        mengirim penawaran.
                    </p>

                    <div class="mt-auto pt-6 flex items-center justify-between">
                        <span class="text-sm font-bold text-cyan-900">Buka Klarifikasi</span>
                        <span
                            class="w-9 h-9 rounded-xl bg-cyan-900 text-white flex items-center justify-center group-hover:bg-cyan-950 transition">
                            →
                        </span>
                    </div>
                </div>
            </a>

            {{-- 04 Riwayat Permintaan --}}
            <a href="{{ route('material-requests.index') }}"
                class="group relative overflow-hidden bg-white rounded-3xl p-6 shadow-sm border border-slate-200 hover:shadow-xl hover:-translate-y-1 transition min-h-[250px] flex flex-col">
                <div
                    class="absolute -top-10 -right-10 w-28 h-28 bg-slate-100 rounded-full blur-2xl group-hover:bg-slate-200 transition">
                </div>

                <div class="relative flex flex-col h-full">
                    <div class="flex items-center justify-between mb-6">
                        <div
                            class="w-14 h-14 rounded-2xl bg-slate-100 text-slate-700 flex items-center justify-center font-bold text-lg">
                            04
                        </div>

                        <span class="px-3 py-1 rounded-full bg-slate-100 text-slate-700 text-xs font-bold">
                            Riwayat
                        </span>
                    </div>

                    <p class="text-sm text-slate-500">Dokumentasi</p>
                    <h3 class="text-2xl font-bold text-slate-900 mt-1 group-hover:text-blue-900">
                        Riwayat Permintaan
                    </h3>

                    <p class="text-sm text-slate-500 mt-3 leading-relaxed">
                        Melihat riwayat pengajuan material yang pernah dibuat untuk kebutuhan dokumentasi dan
                        monitoring.
                    </p>

                    <div class="mt-auto pt-6 flex items-center justify-between">
                        <span class="text-sm font-bold text-slate-700">Lihat Riwayat</span>
                        <span
                            class="w-9 h-9 rounded-xl bg-slate-800 text-white flex items-center justify-center group-hover:bg-slate-900 transition">
                            →
                        </span>
                    </div>
                </div>
            </a>

            {{-- 05 Monitoring Procurement --}}
            <a href="{{ route('material-requests.index') }}"
                class="group relative overflow-hidden bg-white rounded-3xl p-6 shadow-sm border border-slate-200 hover:shadow-xl hover:-translate-y-1 transition min-h-[250px] flex flex-col">
                <div
                    class="absolute -top-10 -right-10 w-28 h-28 bg-emerald-100 rounded-full blur-2xl group-hover:bg-emerald-200 transition">
                </div>

                <div class="relative flex flex-col h-full">
                    <div class="flex items-center justify-between mb-6">
                        <div
                            class="w-14 h-14 rounded-2xl bg-emerald-100 text-emerald-900 flex items-center justify-center font-bold text-lg">
                            05
                        </div>

                        <span class="px-3 py-1 rounded-full bg-emerald-50 text-emerald-700 text-xs font-bold">
                            Track
                        </span>
                    </div>

                    <p class="text-sm text-slate-500">Monitoring</p>
                    <h3 class="text-2xl font-bold text-slate-900 mt-1 group-hover:text-emerald-900">
                        Monitoring Procurement
                    </h3>

                    <p class="text-sm text-slate-500 mt-3 leading-relaxed">
                        Mengikuti perkembangan permintaan material setelah masuk ke proses verifikasi dan pengadaan.
                    </p>

                    <div class="mt-auto pt-6 flex items-center justify-between">
                        <span class="text-sm font-bold text-emerald-900">Pantau Proses</span>
                        <span
                            class="w-9 h-9 rounded-xl bg-emerald-900 text-white flex items-center justify-center group-hover:bg-emerald-950 transition">
                            →
                        </span>
                    </div>
                </div>
            </a>

            {{-- 06 Laporan Kebutuhan Material --}}
            <a href="{{ route('material-requests.index') }}"
                class="group relative overflow-hidden bg-white rounded-3xl p-6 shadow-sm border border-slate-200 hover:shadow-xl hover:-translate-y-1 transition min-h-[250px] flex flex-col">
                <div
                    class="absolute -top-10 -right-10 w-28 h-28 bg-purple-100 rounded-full blur-2xl group-hover:bg-purple-200 transition">
                </div>

                <div class="relative flex flex-col h-full">
                    <div class="flex items-center justify-between mb-6">
                        <div
                            class="w-14 h-14 rounded-2xl bg-purple-100 text-purple-900 flex items-center justify-center font-bold text-lg">
                            06
                        </div>

                        <span class="px-3 py-1 rounded-full bg-purple-50 text-purple-700 text-xs font-bold">
                            Report
                        </span>
                    </div>

                    <p class="text-sm text-slate-500">Laporan</p>
                    <h3 class="text-2xl font-bold text-slate-900 mt-1 group-hover:text-purple-900">
                        Laporan Kebutuhan Material
                    </h3>

                    <p class="text-sm text-slate-500 mt-3 leading-relaxed">
                        Melihat ringkasan kebutuhan material yang diajukan berdasarkan proyek, tanggal, atau status
                        pengajuan.
                    </p>

                    <div class="mt-auto pt-6 flex items-center justify-between">
                        <span class="text-sm font-bold text-purple-900">Lihat Laporan</span>
                        <span
                            class="w-9 h-9 rounded-xl bg-purple-900 text-white flex items-center justify-center group-hover:bg-purple-950 transition">
                            →
                        </span>
                    </div>
                </div>
            </a>

        </div>
    </div>
</x-app-layout>
