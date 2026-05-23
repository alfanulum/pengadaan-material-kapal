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

        {{-- Informasi Status --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

            {{-- Status Tender --}}
            <div class="lg:col-span-2 bg-white rounded-3xl shadow-sm border border-slate-200 overflow-hidden">
                <div class="px-6 py-5 border-b border-slate-200">
                    <h3 class="text-lg font-bold text-slate-900">
                        Keterangan Status Tender & PO
                    </h3>
                    <p class="text-sm text-slate-500 mt-1">
                        Status yang akan muncul pada proses vendor.
                    </p>
                </div>

                <div class="p-6 grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div class="rounded-2xl bg-yellow-50 border border-yellow-100 p-4">
                        <span
                            class="inline-flex px-3 py-1 rounded-full bg-yellow-100 text-yellow-700 text-xs font-bold">
                            Dikirim
                        </span>
                        <p class="text-sm text-slate-600 mt-3">
                            Tender sudah dikirim oleh Supply Chain, tetapi belum dibuka vendor.
                        </p>
                    </div>

                    <div class="rounded-2xl bg-blue-50 border border-blue-100 p-4">
                        <span class="inline-flex px-3 py-1 rounded-full bg-blue-100 text-blue-700 text-xs font-bold">
                            Dibaca
                        </span>
                        <p class="text-sm text-slate-600 mt-3">
                            Vendor sudah membuka detail tender dan melihat kebutuhan material.
                        </p>
                    </div>

                    <div class="rounded-2xl bg-green-50 border border-green-100 p-4">
                        <span class="inline-flex px-3 py-1 rounded-full bg-green-100 text-green-700 text-xs font-bold">
                            Ditawar
                        </span>
                        <p class="text-sm text-slate-600 mt-3">
                            Vendor sudah mengirim penawaran kepada Supply Chain.
                        </p>
                    </div>

                    <div class="rounded-2xl bg-emerald-50 border border-emerald-100 p-4">
                        <span
                            class="inline-flex px-3 py-1 rounded-full bg-emerald-100 text-emerald-700 text-xs font-bold">
                            Terpilih
                        </span>
                        <p class="text-sm text-slate-600 mt-3">
                            Penawaran vendor dipilih sebagai pemenang tender.
                        </p>
                    </div>

                    <div class="rounded-2xl bg-red-50 border border-red-100 p-4">
                        <span class="inline-flex px-3 py-1 rounded-full bg-red-100 text-red-700 text-xs font-bold">
                            Tidak Terpilih
                        </span>
                        <p class="text-sm text-slate-600 mt-3">
                            Vendor sudah mengirim penawaran, tetapi belum dipilih sebagai pemenang tender.
                        </p>
                    </div>

                    <div class="rounded-2xl bg-purple-50 border border-purple-100 p-4">
                        <span
                            class="inline-flex px-3 py-1 rounded-full bg-purple-100 text-purple-700 text-xs font-bold">
                            PO Diterima
                        </span>
                        <p class="text-sm text-slate-600 mt-3">
                            Purchase Order sudah diterbitkan Supply Chain dan dapat diproses vendor.
                        </p>
                    </div>
                </div>
            </div>

            {{-- Quick Action --}}
            <div class="bg-gradient-to-r from-slate-950 via-blue-950 to-blue-800 rounded-3xl shadow-xl text-white p-6">
                <p class="inline-flex px-4 py-2 rounded-full bg-white/10 border border-white/10 text-sm text-blue-100">
                    Quick Access
                </p>

                <h3 class="text-2xl font-bold mt-5">
                    Akses Cepat Vendor
                </h3>

                <p class="text-sm text-blue-100 mt-3 leading-relaxed">
                    Buka tender untuk mengirim penawaran, atau buka PO untuk melihat instruksi pengadaan dari Supply
                    Chain.
                </p>

                <div class="mt-6 space-y-3">
                    <a href="{{ route('vendor.tenders.index') }}"
                        class="w-full inline-flex items-center justify-center px-5 py-4 bg-white text-blue-950 rounded-2xl font-bold hover:bg-slate-100 transition">
                        Buka Tender
                    </a>

                    <a href="{{ route('vendor.purchase-orders.index') }}"
                        class="w-full inline-flex items-center justify-center px-5 py-4 bg-white/10 text-white border border-white/20 rounded-2xl font-bold hover:bg-white/20 transition">
                        Buka Purchase Order
                    </a>
                </div>
            </div>

        </div>

    </div>
</x-app-layout>
