<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3">
            <div>
                <h2 class="font-bold text-2xl text-slate-900 leading-tight">
                    Dashboard Engineer
                </h2>
                <p class="text-sm text-slate-500 mt-1">
                    Pengajuan kebutuhan material kapal dan monitoring status permintaan.
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

            <div class="relative z-10 max-w-4xl">
                <p
                    class="inline-flex px-4 py-2 rounded-full bg-white/10 border border-white/10 text-sm text-blue-100 mb-5">
                    PT PAL Material Request System
                </p>

                <h3 class="text-3xl md:text-5xl font-bold leading-tight">
                    Ajukan Kebutuhan Material Kapal
                </h3>

                <p class="mt-5 text-blue-100 max-w-3xl text-base md:text-lg leading-relaxed">
                    Dashboard ini digunakan oleh Engineer untuk membuat permintaan material,
                    menambahkan item kebutuhan, serta memantau status pengajuan sampai masuk
                    ke proses verifikasi planner dan procurement supply chain.
                </p>

                <div class="mt-8 grid grid-cols-1 sm:grid-cols-2 gap-4 max-w-3xl">
                    <a href="{{ route('material-requests.create') }}"
                        class="flex items-center justify-center px-8 py-5 bg-white text-blue-950 rounded-2xl font-bold text-lg shadow-lg hover:bg-slate-100 hover:-translate-y-1 transition">
                        Buat Pengajuan Material
                    </a>

                    <a href="{{ route('material-requests.index') }}"
                        class="flex items-center justify-center px-8 py-5 bg-white/10 text-white border border-white/20 rounded-2xl font-bold text-lg shadow-lg hover:bg-white/20 hover:-translate-y-1 transition">
                        Lihat Permintaan
                    </a>
                </div>
            </div>
        </div>

        {{-- Summary Cards --}}
        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6 mb-8">
            <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-200">
                <p class="text-sm text-slate-500">Total Pengajuan</p>
                <h3 class="text-3xl font-bold text-slate-900 mt-2">Material</h3>
                <p class="text-xs text-slate-400 mt-2">
                    Permintaan material yang dibuat oleh engineer
                </p>
            </div>

            <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-200">
                <p class="text-sm text-slate-500">Status Pengajuan</p>
                <h3 class="text-3xl font-bold text-slate-900 mt-2">Menunggu</h3>
                <p class="text-xs text-slate-400 mt-2">
                    Pengajuan menunggu verifikasi planner
                </p>
            </div>

            <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-200">
                <p class="text-sm text-slate-500">Disetujui Planner</p>
                <h3 class="text-3xl font-bold text-slate-900 mt-2">Proses</h3>
                <p class="text-xs text-slate-400 mt-2">
                    Pengajuan siap diteruskan ke supply chain
                </p>
            </div>

            <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-200">
                <p class="text-sm text-slate-500">Monitoring</p>
                <h3 class="text-3xl font-bold text-slate-900 mt-2">Track</h3>
                <p class="text-xs text-slate-400 mt-2">
                    Pantau perkembangan proses pengadaan
                </p>
            </div>
        </div>

        {{-- Menu Engineer --}}
        <div class="mb-6">
            <h3 class="text-xl font-bold text-slate-900">
                Menu Engineer
            </h3>
            <p class="text-sm text-slate-500 mt-1">
                Pilih fitur yang ingin digunakan untuk mengelola permintaan material.
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">

            <a href="{{ route('material-requests.create') }}"
                class="group bg-white rounded-2xl p-6 shadow-sm border border-slate-200 hover:shadow-lg hover:-translate-y-1 transition">
                <div
                    class="w-12 h-12 rounded-xl bg-blue-100 text-blue-900 flex items-center justify-center font-bold mb-4">
                    01
                </div>

                <h3 class="text-lg font-bold text-slate-900 group-hover:text-blue-900">
                    Buat Permintaan Material
                </h3>

                <p class="text-sm text-slate-500 mt-2">
                    Membuat pengajuan kebutuhan material kapal berdasarkan proyek,
                    spesifikasi, jumlah, dan kebutuhan pekerjaan.
                </p>
            </a>

            <a href="{{ route('material-requests.index') }}"
                class="group bg-white rounded-2xl p-6 shadow-sm border border-slate-200 hover:shadow-lg hover:-translate-y-1 transition">
                <div
                    class="w-12 h-12 rounded-xl bg-blue-100 text-blue-900 flex items-center justify-center font-bold mb-4">
                    02
                </div>

                <h3 class="text-lg font-bold text-slate-900 group-hover:text-blue-900">
                    Daftar Permintaan Material
                </h3>

                <p class="text-sm text-slate-500 mt-2">
                    Melihat seluruh pengajuan material yang sudah dibuat beserta
                    detail item dan status permintaannya.
                </p>
            </a>

            <a href="{{ route('material-requests.index') }}"
                class="group bg-white rounded-2xl p-6 shadow-sm border border-slate-200 hover:shadow-lg hover:-translate-y-1 transition">
                <div
                    class="w-12 h-12 rounded-xl bg-blue-100 text-blue-900 flex items-center justify-center font-bold mb-4">
                    03
                </div>

                <h3 class="text-lg font-bold text-slate-900 group-hover:text-blue-900">
                    Status Pengajuan
                </h3>

                <p class="text-sm text-slate-500 mt-2">
                    Memantau status permintaan material, seperti menunggu,
                    disetujui planner, ditolak, atau sedang diproses supply chain.
                </p>
            </a>

            <a href="{{ route('material-requests.index') }}"
                class="group bg-white rounded-2xl p-6 shadow-sm border border-slate-200 hover:shadow-lg hover:-translate-y-1 transition">
                <div
                    class="w-12 h-12 rounded-xl bg-slate-100 text-slate-700 flex items-center justify-center font-bold mb-4">
                    04
                </div>

                <h3 class="text-lg font-bold text-slate-900 group-hover:text-blue-900">
                    Riwayat Permintaan
                </h3>

                <p class="text-sm text-slate-500 mt-2">
                    Melihat riwayat pengajuan material yang pernah dibuat
                    untuk kebutuhan dokumentasi dan monitoring.
                </p>
            </a>

            <a href="{{ route('material-requests.index') }}"
                class="group bg-white rounded-2xl p-6 shadow-sm border border-slate-200 hover:shadow-lg hover:-translate-y-1 transition">
                <div
                    class="w-12 h-12 rounded-xl bg-slate-100 text-slate-700 flex items-center justify-center font-bold mb-4">
                    05
                </div>

                <h3 class="text-lg font-bold text-slate-900 group-hover:text-blue-900">
                    Monitoring Procurement
                </h3>

                <p class="text-sm text-slate-500 mt-2">
                    Mengikuti perkembangan permintaan material setelah masuk
                    ke proses verifikasi dan pengadaan.
                </p>
            </a>

            <a href="{{ route('material-requests.index') }}"
                class="group bg-white rounded-2xl p-6 shadow-sm border border-slate-200 hover:shadow-lg hover:-translate-y-1 transition">
                <div
                    class="w-12 h-12 rounded-xl bg-slate-100 text-slate-700 flex items-center justify-center font-bold mb-4">
                    06
                </div>

                <h3 class="text-lg font-bold text-slate-900 group-hover:text-blue-900">
                    Laporan Kebutuhan Material
                </h3>

                <p class="text-sm text-slate-500 mt-2">
                    Melihat ringkasan kebutuhan material yang diajukan berdasarkan
                    proyek, tanggal, atau status pengajuan.
                </p>
            </a>

        </div>
    </div>
</x-app-layout>
