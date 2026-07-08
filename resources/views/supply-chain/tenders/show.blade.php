<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3">
            <div>
                <h2 class="font-bold text-2xl text-slate-900 leading-tight">
                    Detail Tender
                </h2>
                <p class="text-sm text-slate-500 mt-1">
                    Detail tender, vendor yang diundang, penawaran vendor, dan pemilihan vendor pemenang.
                </p>
            </div>

            <div class="flex flex-col sm:flex-row gap-3">
                <a href="{{ route('supply-chain.dashboard') }}"
                    class="inline-flex items-center justify-center px-5 py-3 bg-slate-100 text-slate-700 rounded-xl font-semibold border border-slate-200 hover:bg-slate-200 transition">
                    Kembali ke Dashboard
                </a>

                <a href="{{ route('supply-chain.tenders.index') }}"
                    class="inline-flex items-center justify-center px-5 py-3 bg-slate-900 text-white rounded-xl font-semibold hover:bg-slate-800 transition">
                    Daftar Tender
                </a>
            </div>
        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        @if (session('success'))
            <div class="mb-6 bg-green-50 border border-green-200 text-green-700 p-4 rounded-2xl">
                {{ session('success') }}
            </div>
        @endif

        {{-- Hero --}}
        <div
            class="bg-gradient-to-r from-slate-950 via-blue-950 to-blue-800 rounded-3xl p-8 md:p-10 shadow-xl text-white mb-8 overflow-hidden relative">
            <div class="absolute -top-24 -right-24 w-80 h-80 bg-cyan-400/20 rounded-full blur-3xl"></div>
            <div class="absolute -bottom-24 -left-24 w-80 h-80 bg-blue-400/20 rounded-full blur-3xl"></div>

            <div class="relative z-10 flex flex-col lg:flex-row lg:items-end lg:justify-between gap-6">
                <div>
                    <p
                        class="inline-flex px-4 py-2 rounded-full bg-white/10 border border-white/10 text-sm text-blue-100 mb-5">
                        {{ $tender->kode_tender }}
                    </p>

                    <h3 class="text-3xl md:text-4xl font-bold leading-tight">
                        {{ $tender->nama_tender }}
                    </h3>

                    <p class="mt-4 text-blue-100 max-w-3xl text-base leading-relaxed">
                        Supply Chain dapat melihat detail tender, vendor yang diundang,
                        penawaran yang masuk, dan memilih vendor pemenang.
                    </p>
                </div>

                <div>
                    @if ($tender->status == 'dikirim')
                        <span class="inline-flex px-4 py-2 rounded-full bg-blue-100 text-blue-800 text-sm font-bold">
                            Dikirim
                        </span>
                    @elseif ($tender->status == 'penawaran_masuk')
                        <span
                            class="inline-flex px-4 py-2 rounded-full bg-yellow-100 text-yellow-800 text-sm font-bold">
                            Penawaran Masuk
                        </span>
                    @elseif ($tender->status == 'negosiasi')
                        <span
                            class="inline-flex px-4 py-2 rounded-full bg-purple-100 text-purple-800 text-sm font-bold">
                            Negosiasi
                        </span>
                    @elseif ($tender->status == 'vendor_terpilih')
                        <span class="inline-flex px-4 py-2 rounded-full bg-green-100 text-green-800 text-sm font-bold">
                            Vendor Terpilih
                        </span>
                    @elseif ($tender->status == 'selesai')
                        <span
                            class="inline-flex px-4 py-2 rounded-full bg-emerald-100 text-emerald-800 text-sm font-bold">
                            Selesai
                        </span>
                    @elseif ($tender->status == 'dibatalkan')
                        <span class="inline-flex px-4 py-2 rounded-full bg-red-100 text-red-800 text-sm font-bold">
                            Dibatalkan
                        </span>
                    @else
                        <span class="inline-flex px-4 py-2 rounded-full bg-slate-100 text-slate-800 text-sm font-bold">
                            {{ str_replace('_', ' ', ucfirst($tender->status)) }}
                        </span>
                    @endif
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

            {{-- Kiri --}}
            <div class="lg:col-span-2 space-y-8">

                {{-- Informasi Tender --}}
                <div class="bg-white rounded-3xl shadow-sm border border-slate-200 overflow-hidden">
                    <div class="px-6 py-5 border-b border-slate-200">
                        <h3 class="text-lg font-bold text-slate-900">
                            Informasi Tender
                        </h3>
                        <p class="text-sm text-slate-500 mt-1">
                            Data utama tender yang dibuat oleh Supply Chain.
                        </p>
                    </div>

                    <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div class="rounded-2xl bg-slate-50 p-4">
                            <p class="text-xs text-slate-500 mb-1">Kode Tender</p>
                            <p class="font-bold text-slate-900">{{ $tender->kode_tender }}</p>
                        </div>

                        <div class="rounded-2xl bg-slate-50 p-4">
                            <p class="text-xs text-slate-500 mb-1">Nama Tender</p>
                            <p class="font-bold text-slate-900">{{ $tender->nama_tender }}</p>
                        </div>

                        <div class="rounded-2xl bg-slate-50 p-4">
                            <p class="text-xs text-slate-500 mb-1">Kode Pengajuan</p>
                            <p class="font-bold text-slate-900">
                                {{ $tender->materialRequest->kode_pengajuan ?? 'REQ-' . str_pad($tender->material_request_id, 4, '0', STR_PAD_LEFT) }}
                            </p>
                        </div>

                        <div class="rounded-2xl bg-slate-50 p-4">
                            <p class="text-xs text-slate-500 mb-1">Project</p>
                            <p class="font-bold text-slate-900">
                                {{ $tender->materialRequest->project->nama_project ?? '-' }}
                            </p>
                        </div>

                        <div class="rounded-2xl bg-slate-50 p-4">
                            <p class="text-xs text-slate-500 mb-1">Engineer</p>
                            <p class="font-bold text-slate-900">
                                {{ $tender->materialRequest->user->name ?? '-' }}
                            </p>
                        </div>

                        <div class="rounded-2xl bg-slate-50 p-4">
                            <p class="text-xs text-slate-500 mb-1">Deadline</p>
                            <p class="font-bold text-slate-900">
                                {{ \Carbon\Carbon::parse($tender->deadline)->format('d-m-Y') }}
                            </p>
                        </div>

                        <div class="rounded-2xl bg-slate-50 p-4">
                            <p class="text-xs text-slate-500 mb-1">Status Tender</p>
                            <p class="font-bold text-slate-900 capitalize">
                                {{ str_replace('_', ' ', $tender->status) }}
                            </p>
                        </div>

                        <div class="rounded-2xl bg-slate-50 p-4">
                            <p class="text-xs text-slate-500 mb-1">Jumlah Vendor Diundang</p>
                            <p class="font-bold text-slate-900">
                                {{ $tender->invitations->count() }} Vendor
                            </p>
                        </div>

                        <div class="rounded-2xl bg-slate-50 p-4 md:col-span-2">
                            <p class="text-xs text-slate-500 mb-1">Catatan Tender</p>
                            <p class="font-medium text-slate-900">
                                {{ $tender->catatan ?? '-' }}
                            </p>
                        </div>
                    </div>
                </div>

                {{-- Data Material --}}
                <div class="bg-white rounded-3xl shadow-sm border border-slate-200 overflow-hidden">
                    <div class="px-6 py-5 border-b border-slate-200">
                        <h3 class="text-lg font-bold text-slate-900">
                            Data Material
                        </h3>
                        <p class="text-sm text-slate-500 mt-1">
                            Material yang menjadi kebutuhan dalam tender ini.
                        </p>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead class="bg-slate-50 border-b border-slate-200">
                                <tr>
                                    <th
                                        class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">
                                        Nama Barang
                                    </th>
                                    <th
                                        class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">
                                        Spesifikasi
                                    </th>
                                    <th
                                        class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">
                                        Qty
                                    </th>
                                    <th
                                        class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">
                                        Satuan
                                    </th>
                                </tr>
                            </thead>

                            <tbody class="divide-y divide-slate-100">
                                @forelse ($tender->materialRequest->items as $item)
                                    <tr class="hover:bg-slate-50 transition">
                                        <td class="px-6 py-4 text-sm font-semibold text-slate-900">
                                            {{ $item->nama_barang }}
                                        </td>

                                        <td class="px-6 py-4 text-sm text-slate-700">
                                            {{ $item->spesifikasi ?? '-' }}
                                        </td>

                                        <td class="px-6 py-4 text-sm text-slate-700 whitespace-nowrap">
                                            {{ $item->qty }}
                                        </td>

                                        <td class="px-6 py-4 text-sm text-slate-700 whitespace-nowrap">
                                            {{ $item->satuan }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="px-6 py-12 text-center text-slate-500">
                                            Belum ada data material.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                {{-- Penawaran Vendor --}}
                <div class="bg-white rounded-3xl shadow-sm border border-slate-200 overflow-hidden">
                    <div class="px-6 py-5 border-b border-slate-200">
                        <h3 class="text-lg font-bold text-slate-900">
                            Penawaran Vendor
                        </h3>
                        <p class="text-sm text-slate-500 mt-1">
                            Daftar penawaran yang dikirim vendor pada tender ini.
                        </p>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead class="bg-slate-50 border-b border-slate-200">
                                <tr>
                                    <th
                                        class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">
                                        Vendor
                                    </th>
                                    <th
                                        class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">
                                        Harga
                                    </th>
                                    <th
                                        class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">
                                        Estimasi
                                    </th>
                                    <th
                                        class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">
                                        File
                                    </th>
                                    <th
                                        class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">
                                        Status
                                    </th>
                                    <th
                                        class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">
                                        Aksi
                                    </th>
                                </tr>
                            </thead>

                            <tbody class="divide-y divide-slate-100">
                                @forelse ($tender->quotations as $quotation)
                                    <tr class="hover:bg-slate-50 transition">
                                        <td class="px-6 py-4 text-sm">
                                            <div class="font-bold text-slate-900">
                                                {{ $quotation->vendor->nama_vendor ?? '-' }}
                                            </div>
                                            <div class="text-xs text-slate-500 mt-1">
                                                {{ $quotation->vendor->email ?? '-' }}
                                            </div>

                                            @if ($quotation->catatan)
                                                <div class="text-xs text-slate-500 mt-2">
                                                    Catatan: {{ $quotation->catatan }}
                                                </div>
                                            @endif
                                        </td>

                                        <td class="px-6 py-4 text-sm font-bold text-slate-900 whitespace-nowrap">
                                            Rp {{ number_format($quotation->harga_penawaran, 0, ',', '.') }}
                                        </td>

                                        <td class="px-6 py-4 text-sm text-slate-700 whitespace-nowrap">
                                            {{ $quotation->estimasi_pengiriman ?? '-' }} hari
                                        </td>

                                        <td class="px-6 py-4 text-sm whitespace-nowrap">
                                            @if ($quotation->file_penawaran)
                                                <a href="{{ asset('storage/' . $quotation->file_penawaran) }}"
                                                    target="_blank"
                                                    class="font-semibold text-blue-800 hover:text-blue-950">
                                                    Lihat File
                                                </a>
                                            @else
                                                <span class="text-slate-400">-</span>
                                            @endif
                                        </td>

                                        <td class="px-6 py-4 text-sm whitespace-nowrap">
                                            @if ($quotation->status == 'dikirim')
                                                <span
                                                    class="inline-flex px-3 py-1 rounded-full bg-blue-100 text-blue-700 text-xs font-bold">
                                                    Dikirim
                                                </span>
                                            @elseif ($quotation->status == 'direview')
                                                <span
                                                    class="inline-flex px-3 py-1 rounded-full bg-yellow-100 text-yellow-700 text-xs font-bold">
                                                    Direview
                                                </span>
                                            @elseif ($quotation->status == 'diterima')
                                                <span
                                                    class="inline-flex px-3 py-1 rounded-full bg-green-100 text-green-700 text-xs font-bold">
                                                    Diterima
                                                </span>
                                            @elseif ($quotation->status == 'ditolak')
                                                <span
                                                    class="inline-flex px-3 py-1 rounded-full bg-red-100 text-red-700 text-xs font-bold">
                                                    Ditolak
                                                </span>
                                            @else
                                                <span
                                                    class="inline-flex px-3 py-1 rounded-full bg-slate-100 text-slate-700 text-xs font-bold">
                                                    {{ $quotation->status }}
                                                </span>
                                            @endif
                                        </td>

                                        <td class="px-6 py-4 text-sm whitespace-nowrap">
                                            @if ($tender->status !== 'vendor_terpilih')
                                                <form
                                                    action="{{ route('supply-chain.tenders.quotations.choose', [$tender->id, $quotation->id]) }}"
                                                    method="POST"
                                                    onsubmit="return confirm('Yakin memilih vendor ini sebagai pemenang tender?')">
                                                    @csrf

                                                    <button type="submit"
                                                        class="inline-flex px-4 py-2 bg-green-600 text-white rounded-xl text-xs font-semibold hover:bg-green-700 transition">
                                                        Pilih Vendor
                                                    </button>
                                                </form>
                                            @else
                                                @if ($quotation->status == 'diterima')
                                                    <span
                                                        class="inline-flex px-3 py-1 rounded-full bg-green-100 text-green-700 text-xs font-bold">
                                                        Vendor Terpilih
                                                    </span>
                                                @else
                                                    <span class="text-xs text-slate-400">
                                                        Tidak Terpilih
                                                    </span>
                                                @endif
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="px-6 py-16 text-center">
                                            <div
                                                class="mx-auto w-16 h-16 rounded-2xl bg-slate-100 text-slate-400 flex items-center justify-center font-bold mb-4">
                                                PN
                                            </div>

                                            <h3 class="text-lg font-bold text-slate-900">
                                                Belum Ada Penawaran
                                            </h3>

                                            <p class="text-sm text-slate-500 mt-2">
                                                Penawaran vendor akan tampil setelah vendor mengirim penawaran dari
                                                portal vendor.
                                            </p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>

            {{-- Kanan --}}
            <div class="lg:col-span-1 space-y-8">

                <div class="bg-white rounded-3xl shadow-sm border border-slate-200 p-6">

                    <h3 class="text-lg font-bold text-slate-900 mb-2">
                        Chat Negosiasi
                    </h3>

                    <p class="text-sm text-slate-500 mb-5">
                        Diskusi harga & penawaran antara Supply Chain dan Vendor.
                    </p>

                    {{-- BUTTON CHAT --}}
                    <a href="{{ route('supply-chain.chat.negosiasi.index', $tender->id) }}"
                        class="w-full inline-flex items-center justify-center px-5 py-4 bg-amber-600 text-white rounded-2xl font-bold hover:bg-amber-700 transition">

                        💬 Buka Chat Negosiasi
                    </a>

                    <p class="text-xs text-slate-400 mt-3 text-center">
                        Klik untuk membuka ruang diskusi tender ini
                    </p>

                </div>

                {{-- Vendor Diundang --}}
                <div class="bg-white rounded-3xl shadow-sm border border-slate-200 overflow-hidden">
                    <div class="px-6 py-5 border-b border-slate-200">
                        <h3 class="text-lg font-bold text-slate-900">
                            Vendor Diundang
                        </h3>
                        <p class="text-sm text-slate-500 mt-1">
                            Vendor yang menerima undangan tender.
                        </p>
                    </div>

                    <div class="p-6 space-y-4">
                        @forelse ($tender->invitations as $invitation)
                            <div class="rounded-2xl bg-slate-50 p-4">
                                <h4 class="font-bold text-slate-900">
                                    {{ $invitation->vendor->nama_vendor ?? '-' }}
                                </h4>

                                <p class="text-xs text-slate-500 mt-1">
                                    {{ $invitation->vendor->email ?? '-' }}
                                </p>

                                <div class="mt-3">
                                    @if ($invitation->status == 'dikirim')
                                        <span
                                            class="inline-flex px-3 py-1 rounded-full bg-yellow-100 text-yellow-700 text-xs font-bold">
                                            Dikirim
                                        </span>
                                    @elseif ($invitation->status == 'dibaca')
                                        <span
                                            class="inline-flex px-3 py-1 rounded-full bg-blue-100 text-blue-700 text-xs font-bold">
                                            Dibaca
                                        </span>
                                    @elseif ($invitation->status == 'ditawar')
                                        <span
                                            class="inline-flex px-3 py-1 rounded-full bg-green-100 text-green-700 text-xs font-bold">
                                            Ditawar
                                        </span>
                                    @elseif ($invitation->status == 'terpilih')
                                        <span
                                            class="inline-flex px-3 py-1 rounded-full bg-emerald-100 text-emerald-700 text-xs font-bold">
                                            Terpilih
                                        </span>
                                    @elseif ($invitation->status == 'tidak_terpilih')
                                        <span
                                            class="inline-flex px-3 py-1 rounded-full bg-red-100 text-red-700 text-xs font-bold">
                                            Tidak Terpilih
                                        </span>
                                    @else
                                        <span
                                            class="inline-flex px-3 py-1 rounded-full bg-slate-100 text-slate-700 text-xs font-bold">
                                            {{ str_replace('_', ' ', $invitation->status) }}
                                        </span>
                                    @endif
                                </div>

                                <p class="text-xs text-slate-400 mt-3">
                                    Dikirim:
                                    {{ $invitation->sent_at ? \Carbon\Carbon::parse($invitation->sent_at)->format('d-m-Y H:i') : '-' }}
                                </p>
                            </div>
                        @empty
                            <p class="text-sm text-slate-500">
                                Belum ada vendor yang diundang.
                            </p>
                        @endforelse
                    </div>
                </div>

                {{-- Ringkasan --}}
                <div class="bg-white rounded-3xl shadow-sm border border-slate-200 p-6">
                    <h3 class="text-lg font-bold text-slate-900">
                        Ringkasan Tender
                    </h3>

                    <div class="mt-5 space-y-4">
                        <div>
                            <p class="text-xs text-slate-500">Total Vendor Diundang</p>
                            <p class="font-bold text-slate-900">{{ $tender->invitations->count() }}</p>
                        </div>

                        <div>
                            <p class="text-xs text-slate-500">Total Penawaran Masuk</p>
                            <p class="font-bold text-slate-900">{{ $tender->quotations->count() }}</p>
                        </div>

                        <div>
                            <p class="text-xs text-slate-500">Status</p>
                            <p class="font-bold text-slate-900 capitalize">
                                {{ str_replace('_', ' ', $tender->status) }}
                            </p>
                        </div>
                    </div>
                </div>

                {{-- Navigasi --}}
                <div class="bg-white rounded-3xl shadow-sm border border-slate-200 p-6">
                    <div class="space-y-3">

                        @if ($tender->status == 'vendor_terpilih')
                            @if ($tender->purchaseOrder)
                                <a href="{{ route('supply-chain.purchase-orders.show', $tender->purchaseOrder->id) }}"
                                    class="w-full inline-flex items-center justify-center px-5 py-3 bg-green-600 text-white rounded-xl font-semibold hover:bg-green-700 transition">
                                    Lihat Purchase Order
                                </a>
                            @else
                                <a href="{{ route('supply-chain.purchase-orders.create', $tender->id) }}"
                                    class="w-full inline-flex items-center justify-center px-5 py-3 bg-blue-900 text-white rounded-xl font-semibold hover:bg-blue-950 transition">
                                    Buat Purchase Order
                                </a>
                            @endif
                        @endif

                        <a href="{{ route('supply-chain.tenders.index') }}"
                            class="w-full inline-flex items-center justify-center px-5 py-3 bg-slate-100 text-slate-700 rounded-xl font-semibold hover:bg-slate-200 transition">
                            Kembali ke Daftar Tender
                        </a>

                        <a href="{{ route('supply-chain.dashboard') }}"
                            class="w-full inline-flex items-center justify-center px-5 py-3 bg-slate-900 text-white rounded-xl font-semibold hover:bg-slate-800 transition">
                            Kembali ke Dashboard
                        </a>
                    </div>
                </div>

            </div>

        </div>
    </div>
</x-app-layout>
