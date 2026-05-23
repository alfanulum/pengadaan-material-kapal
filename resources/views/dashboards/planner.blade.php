<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3">
            <div>
                <h2 class="font-bold text-2xl text-slate-900 leading-tight">
                    Dashboard Planner
                </h2>
                <p class="text-sm text-slate-500 mt-1">
                    Verifikasi pengajuan material dari Engineer sebelum diteruskan ke Supply Chain.
                </p>
            </div>

            <div class="text-sm text-slate-600 bg-white px-4 py-2 rounded-xl border border-slate-200 shadow-sm">
                {{ now()->format('d M Y') }}
            </div>
        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        {{-- Hero Planner --}}
        <div
            class="bg-gradient-to-r from-slate-950 via-blue-950 to-blue-800 rounded-3xl p-8 md:p-10 shadow-xl text-white mb-8 overflow-hidden relative">
            <div class="absolute -top-24 -right-24 w-80 h-80 bg-cyan-400/20 rounded-full blur-3xl"></div>
            <div class="absolute -bottom-24 -left-24 w-80 h-80 bg-blue-400/20 rounded-full blur-3xl"></div>

            <div class="relative z-10 grid grid-cols-1 lg:grid-cols-2 gap-8 items-center">
                <div>
                    <p
                        class="inline-flex px-4 py-2 rounded-full bg-white/10 border border-white/10 text-sm text-blue-100 mb-5">
                        PT PAL Planner Dashboard
                    </p>

                    <h3 class="text-3xl md:text-5xl font-bold leading-tight">
                        Verifikasi Pengajuan Material Kapal
                    </h3>

                    <p class="mt-5 text-blue-100 max-w-3xl text-base md:text-lg leading-relaxed">
                        Planner bertugas memeriksa pengajuan material dari Engineer,
                        melengkapi dokumen pendukung seperti RAB dan perizinan,
                        lalu menentukan apakah pengajuan disetujui atau ditolak.
                    </p>

                    <div class="mt-8">
                        <a href="{{ route('planner.material-requests.index') }}"
                            class="inline-flex items-center justify-center px-8 py-5 bg-white text-blue-950 rounded-2xl font-bold text-lg shadow-lg hover:bg-slate-100 hover:-translate-y-1 transition">
                            Lihat Pengajuan Material
                        </a>
                    </div>
                </div>

                <div class="bg-white/10 border border-white/10 rounded-3xl p-6 md:p-8">
                    <h4 class="text-xl font-bold mb-4">
                        Alur Kerja Planner
                    </h4>

                    <div class="space-y-4">
                        <div class="flex gap-4">
                            <div
                                class="w-10 h-10 rounded-xl bg-white text-blue-950 flex items-center justify-center font-bold shrink-0">
                                1
                            </div>
                            <div>
                                <h5 class="font-semibold">Review Pengajuan</h5>
                                <p class="text-sm text-blue-100 mt-1">
                                    Memeriksa kebutuhan material yang diajukan oleh Engineer.
                                </p>
                            </div>
                        </div>

                        <div class="flex gap-4">
                            <div
                                class="w-10 h-10 rounded-xl bg-white text-blue-950 flex items-center justify-center font-bold shrink-0">
                                2
                            </div>
                            <div>
                                <h5 class="font-semibold">Lengkapi Dokumen</h5>
                                <p class="text-sm text-blue-100 mt-1">
                                    Mengisi total RAB, upload dokumen RAB, dan dokumen perizinan.
                                </p>
                            </div>
                        </div>

                        <div class="flex gap-4">
                            <div
                                class="w-10 h-10 rounded-xl bg-white text-blue-950 flex items-center justify-center font-bold shrink-0">
                                3
                            </div>
                            <div>
                                <h5 class="font-semibold">Approval</h5>
                                <p class="text-sm text-blue-100 mt-1">
                                    Menyetujui atau menolak pengajuan material berdasarkan hasil pemeriksaan.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Ringkasan --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-200">
                <div
                    class="w-12 h-12 rounded-xl bg-blue-100 text-blue-900 flex items-center justify-center font-bold mb-4">
                    01
                </div>

                <h3 class="text-lg font-bold text-slate-900">
                    Pengajuan Material
                </h3>

                <p class="text-sm text-slate-500 mt-2">
                    Melihat daftar pengajuan material yang dikirim oleh Engineer
                    untuk kebutuhan proyek kapal.
                </p>
            </div>

            <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-200">
                <div
                    class="w-12 h-12 rounded-xl bg-blue-100 text-blue-900 flex items-center justify-center font-bold mb-4">
                    02
                </div>

                <h3 class="text-lg font-bold text-slate-900">
                    Dokumen Planner
                </h3>

                <p class="text-sm text-slate-500 mt-2">
                    Planner dapat menambahkan total RAB, dokumen RAB,
                    dokumen perizinan, dan catatan hasil review.
                </p>
            </div>

            <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-200">
                <div
                    class="w-12 h-12 rounded-xl bg-blue-100 text-blue-900 flex items-center justify-center font-bold mb-4">
                    03
                </div>

                <h3 class="text-lg font-bold text-slate-900">
                    Keputusan Approval
                </h3>

                <p class="text-sm text-slate-500 mt-2">
                    Pengajuan yang disetujui akan diteruskan ke Supply Chain,
                    sedangkan pengajuan yang tidak sesuai dapat ditolak.
                </p>
            </div>
        </div>

        {{-- Shortcut --}}
        <div class="bg-white rounded-3xl shadow-sm border border-slate-200 p-6 md:p-8">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-5">
                <div>
                    <h3 class="text-xl font-bold text-slate-900">
                        Pengajuan Menunggu Verifikasi
                    </h3>

                    <p class="text-sm text-slate-500 mt-2 max-w-2xl">
                        Buka halaman pengajuan material untuk melihat detail,
                        melengkapi dokumen pendukung, dan melakukan verifikasi.
                    </p>
                </div>

                <a href="{{ route('planner.material-requests.index') }}"
                    class="inline-flex items-center justify-center px-6 py-3 bg-blue-900 text-white rounded-xl font-semibold shadow-lg hover:bg-blue-950 transition">
                    Buka Pengajuan
                </a>
            </div>
        </div>

    </div>
</x-app-layout>
