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

                {{-- 1 Kelola Vendor --}}
                <a href="{{ route('supply-chain.vendors.index') }}"
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
                            <span
                                class="w-9 h-9 rounded-xl bg-blue-900 text-white flex items-center justify-center group-hover:bg-blue-950 transition">
                                →
                            </span>
                        </div>
                    </div>
                </a>

                {{-- 2 Permintaan dari Planner --}}
                <a href="{{ route('supply-chain.material-requests.index') }}"
                    class="group relative overflow-hidden bg-white rounded-3xl p-6 shadow-sm border border-slate-200 hover:shadow-xl hover:-translate-y-1 transition min-h-[260px] flex flex-col">
                    <div
                        class="absolute -top-10 -right-10 w-28 h-28 bg-cyan-100 rounded-full blur-2xl group-hover:bg-cyan-200 transition">
                    </div>

                    <div class="relative flex flex-col h-full">
                        <div class="flex items-center justify-between mb-6">
                            <div
                                class="w-14 h-14 rounded-2xl bg-cyan-100 text-cyan-900 flex items-center justify-center font-bold text-lg">
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
                            <span
                                class="w-9 h-9 rounded-xl bg-cyan-900 text-white flex items-center justify-center group-hover:bg-cyan-950 transition">
                                →
                            </span>
                        </div>
                    </div>
                </a>

                {{-- 3 Kelola Tender --}}
                <a href="{{ route('supply-chain.tenders.index') }}"
                    class="group relative overflow-hidden bg-white rounded-3xl p-6 shadow-sm border border-slate-200 hover:shadow-xl hover:-translate-y-1 transition min-h-[260px] flex flex-col">
                    <div
                        class="absolute -top-10 -right-10 w-28 h-28 bg-indigo-100 rounded-full blur-2xl group-hover:bg-indigo-200 transition">
                    </div>

                    <div class="relative flex flex-col h-full">
                        <div class="flex items-center justify-between mb-6">
                            <div
                                class="w-14 h-14 rounded-2xl bg-indigo-100 text-indigo-900 flex items-center justify-center font-bold text-lg">
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
                            <span class="text-sm font-bold text-indigo-900">Masuk ke Tender</span>
                            <span
                                class="w-9 h-9 rounded-xl bg-indigo-900 text-white flex items-center justify-center group-hover:bg-indigo-950 transition">
                                →
                            </span>
                        </div>
                    </div>
                </a>

                {{-- 4 Monitoring Purchase Order --}}
                <a href="{{ route('supply-chain.purchase-orders.index') }}"
                    class="group relative overflow-hidden bg-white rounded-3xl p-6 shadow-sm border border-slate-200 hover:shadow-xl hover:-translate-y-1 transition min-h-[260px] flex flex-col">
                    <div
                        class="absolute -top-10 -right-10 w-28 h-28 bg-emerald-100 rounded-full blur-2xl group-hover:bg-emerald-200 transition">
                    </div>

                    <div class="relative flex flex-col h-full">
                        <div class="flex items-center justify-between mb-6">
                            <div
                                class="w-14 h-14 rounded-2xl bg-emerald-100 text-emerald-900 flex items-center justify-center font-bold text-lg">
                                04
                            </div>

                            <span class="px-3 py-1 rounded-full bg-emerald-50 text-emerald-700 text-xs font-bold">
                                PO
                            </span>
                        </div>

                        <p class="text-sm text-slate-500">Purchase Order</p>
                        <h3 class="text-2xl font-bold text-slate-900 mt-1 group-hover:text-emerald-900">
                            Monitoring PO
                        </h3>

                        <p class="text-sm text-slate-500 mt-3 leading-relaxed">
                            Lihat daftar Purchase Order yang dibuat dari vendor terpilih dan penawaran yang disetujui.
                        </p>

                        <div class="mt-auto pt-6 flex items-center justify-between">
                            <span class="text-sm font-bold text-emerald-900">Lihat PO</span>
                            <span
                                class="w-9 h-9 rounded-xl bg-emerald-900 text-white flex items-center justify-center group-hover:bg-emerald-950 transition">
                                →
                            </span>
                        </div>
                    </div>
                </a>

                {{-- 5 Pengiriman Barang --}}
                <div
                    class="md:col-span-2 relative overflow-hidden rounded-3xl bg-gradient-to-r from-slate-950 via-blue-950 to-blue-800 p-7 md:p-8 shadow-xl text-white border border-blue-900">
                    <div class="absolute -top-16 -right-16 w-44 h-44 bg-cyan-300/20 rounded-full blur-3xl"></div>
                    <div class="absolute -bottom-16 -left-16 w-44 h-44 bg-blue-300/20 rounded-full blur-3xl"></div>

                    <div class="relative z-10 grid grid-cols-1 lg:grid-cols-3 gap-6 items-center">
                        <div class="lg:col-span-2">
                            <div class="flex items-center justify-between mb-6">
                                <div
                                    class="w-14 h-14 rounded-2xl bg-white/15 text-white flex items-center justify-center font-bold text-lg border border-white/10">
                                    05
                                </div>

                                <span
                                    class="px-3 py-1 rounded-full bg-white/15 text-white text-xs font-bold border border-white/10">
                                    Tahap Berikutnya
                                </span>
                            </div>

                            <p class="text-sm text-blue-100">Shipment</p>
                            <h3 class="text-3xl md:text-4xl font-bold mt-1">
                                Pengiriman Barang
                            </h3>

                            <p class="text-sm md:text-base text-blue-100 mt-4 leading-relaxed max-w-3xl">
                                Setelah PO dikirim ke vendor, tahap berikutnya adalah monitoring pengiriman material
                                sampai barang diterima dan divalidasi oleh gudang.
                            </p>
                        </div>

                        <div class="grid grid-cols-1 gap-4">
                            <div class="bg-white/10 rounded-2xl p-4 border border-white/10">
                                <p class="text-xs text-blue-100">Next Flow</p>
                                <p class="font-bold text-lg mt-1">PO → Pengiriman</p>
                            </div>

                            <div class="bg-white/10 rounded-2xl p-4 border border-white/10">
                                <p class="text-xs text-blue-100">Status</p>
                                <p class="font-bold text-lg mt-1">Belum Dibuat</p>
                            </div>
                        </div>
                    </div>

                    <div class="relative z-10 mt-6 flex items-center justify-between">
                        <span class="text-sm font-bold text-white">
                            Fitur ini dilanjutkan setelah Purchase Order selesai.
                        </span>

                        <span
                            class="px-4 py-2 rounded-xl bg-white/15 text-white text-sm font-bold border border-white/10">
                            Coming Next
                        </span>
                    </div>
                </div>

            </div>

        </div>
    </div>
</x-app-layout>
