<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3">
            <div>
                <div class="flex items-center gap-2 text-sm text-slate-500 mb-1">
                    <a href="{{ route('gudang.dashboard') }}" class="hover:text-blue-700 transition">Dashboard</a>
                    <span>/</span>
                    <span class="text-slate-900 font-semibold">Daftar Barang Diterima</span>
                </div>
                <h2 class="font-bold text-2xl text-slate-900 leading-tight">
                    Daftar Barang yang Akan Diterima
                </h2>
                <p class="text-sm text-slate-500 mt-1">
                    Purchase Order yang sudah dikirim vendor dan menunggu penerimaan gudang.
                </p>
            </div>
            <a href="{{ route('gudang.dashboard') }}"
                class="inline-flex items-center gap-2 px-5 py-2.5 bg-slate-100 text-slate-700 rounded-xl font-semibold border border-slate-200 hover:bg-slate-200 transition text-sm">
                ← Dashboard
            </a>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

            @if (session('success'))
                <div class="p-4 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-2xl flex items-center gap-3">
                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    {{ session('success') }}
                </div>
            @endif

            {{-- Barang menunggu penerimaan (status dikirim) --}}
            @php
                $menunggu = $purchaseOrders->filter(fn($po) => $po->status === 'dikirim' && !$po->goodsReceipt);
                $sudahDiterima = $purchaseOrders->filter(fn($po) => $po->goodsReceipt !== null || in_array($po->status, ['selesai','retur','penggantian_vendor','menunggu_tindak_lanjut']));
            @endphp

            {{-- Section: Menunggu Penerimaan --}}
            <div class="bg-white rounded-3xl shadow-sm border border-slate-200 overflow-hidden">
                <div class="px-6 py-5 border-b border-slate-200 bg-orange-50">
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 rounded-xl bg-orange-100 flex items-center justify-center">
                            <svg class="w-5 h-5 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8a1 1 0 011-1h2.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1m-6-1a1 1 0 001 1h1M5 17a2 2 0 104 0m-4 0a2 2 0 114 0m6 0a2 2 0 104 0m-4 0a2 2 0 114 0"/></svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-bold text-slate-900">Barang Dikirim Vendor</h3>
                            <p class="text-sm text-orange-700 mt-0.5">{{ $purchaseOrders->where('status', 'dikirim')->count() }} PO menunggu penerimaan gudang</p>
                        </div>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-slate-50 border-b border-slate-200">
                            <tr>
                                <th class="px-5 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">No. PO</th>
                                <th class="px-5 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Nama Tender</th>
                                <th class="px-5 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Vendor</th>
                                <th class="px-5 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Material</th>
                                <th class="px-5 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Jumlah</th>
                                <th class="px-5 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Tanggal Dikirim</th>
                                <th class="px-5 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Status</th>
                                <th class="px-5 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-slate-100">
                            @forelse ($purchaseOrders->where('status', 'dikirim') as $po)
                                <tr class="hover:bg-orange-50/50 transition group">
                                    <td class="px-5 py-4 whitespace-nowrap">
                                        <span class="text-sm font-black text-slate-900">{{ $po->kode_po }}</span>
                                    </td>

                                    <td class="px-5 py-4">
                                        <div class="text-sm font-semibold text-slate-900">{{ $po->tender->nama_tender ?? '-' }}</div>
                                        <div class="text-xs text-slate-500 mt-0.5">{{ $po->tender->kode_tender ?? '' }}</div>
                                    </td>

                                    <td class="px-5 py-4">
                                        <div class="flex items-center gap-2">
                                            <div class="w-7 h-7 rounded-lg bg-blue-100 flex items-center justify-center shrink-0">
                                                <span class="text-xs font-bold text-blue-700">{{ substr($po->vendor->nama_vendor ?? 'V', 0, 1) }}</span>
                                            </div>
                                            <span class="text-sm font-semibold text-slate-800">{{ $po->vendor->nama_vendor ?? '-' }}</span>
                                        </div>
                                    </td>

                                    <td class="px-5 py-4">
                                        <div class="text-sm font-medium text-slate-900">{{ $po->items->first()->nama_barang ?? '-' }}</div>
                                        @if($po->items->count() > 1)
                                            <div class="text-xs text-slate-500 mt-0.5">+{{ $po->items->count() - 1 }} item lainnya</div>
                                        @endif
                                    </td>

                                    <td class="px-5 py-4 whitespace-nowrap text-sm text-slate-700">
                                        {{ $po->items->sum('qty') }} item
                                    </td>

                                    <td class="px-5 py-4 whitespace-nowrap">
                                        @if ($po->tanggal_pengiriman)
                                            <span class="text-sm font-medium text-orange-700">
                                                {{ \Carbon\Carbon::parse($po->tanggal_pengiriman)->format('d M Y') }}
                                            </span>
                                            <div class="text-xs text-slate-500 mt-0.5">
                                                {{ \Carbon\Carbon::parse($po->tanggal_pengiriman)->format('H:i') }} WIB
                                            </div>
                                        @else
                                            <span class="text-slate-400 text-sm">-</span>
                                        @endif
                                    </td>

                                    <td class="px-5 py-4 whitespace-nowrap">
                                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-orange-100 text-orange-700">
                                            <span class="w-1.5 h-1.5 rounded-full bg-current animate-pulse"></span>
                                            Barang Dikirim
                                        </span>
                                    </td>

                                    <td class="px-5 py-4 whitespace-nowrap">
                                        <div class="flex items-center gap-2">
                                            <a href="{{ route('gudang.goods-receipts.show', $po->id) }}"
                                                class="inline-flex items-center gap-1.5 px-3 py-2 bg-slate-100 text-slate-700 rounded-xl text-xs font-semibold hover:bg-slate-200 transition">
                                                Detail
                                            </a>
                                            <a href="{{ route('gudang.goods-receipts.show', $po->id) }}"
                                                class="inline-flex items-center gap-1.5 px-3 py-2 bg-blue-900 text-white rounded-xl text-xs font-semibold hover:bg-blue-950 transition shadow-sm">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                                Terima Barang
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="px-6 py-16 text-center">
                                        <div class="mx-auto w-16 h-16 rounded-2xl bg-orange-50 flex items-center justify-center mb-4">
                                            <svg class="w-8 h-8 text-orange-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                                        </div>
                                        <h3 class="text-lg font-bold text-slate-900">Belum Ada Barang Dikirim</h3>
                                        <p class="text-sm text-slate-500 mt-2">Barang akan muncul di sini setelah vendor menekan tombol "Kirim Barang ke Gudang".</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- Section: Semua PO (termasuk yang sudah diterima) --}}
            <div class="bg-white rounded-3xl shadow-sm border border-slate-200 overflow-hidden">
                <div class="px-6 py-5 border-b border-slate-200">
                    <h3 class="text-lg font-bold text-slate-900">Riwayat Purchase Order</h3>
                    <p class="text-sm text-slate-500 mt-0.5">{{ $purchaseOrders->total() }} Purchase Order ditemukan</p>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-slate-50 border-b border-slate-200">
                            <tr>
                                <th class="px-5 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">No. PO</th>
                                <th class="px-5 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Vendor</th>
                                <th class="px-5 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Tender / Material</th>
                                <th class="px-5 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Jml Pesanan</th>
                                <th class="px-5 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Tgl Dikirim</th>
                                <th class="px-5 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Status</th>
                                <th class="px-5 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-slate-100">
                            @forelse ($purchaseOrders as $po)
                                <tr class="hover:bg-slate-50/70 transition">
                                    <td class="px-5 py-4 whitespace-nowrap">
                                        <span class="text-sm font-black text-slate-900">{{ $po->kode_po }}</span>
                                    </td>

                                    <td class="px-5 py-4">
                                        <div class="flex items-center gap-2">
                                            <div class="w-7 h-7 rounded-lg bg-blue-100 flex items-center justify-center shrink-0">
                                                <span class="text-xs font-bold text-blue-700">{{ substr($po->vendor->nama_vendor ?? 'V', 0, 1) }}</span>
                                            </div>
                                            <span class="text-sm font-semibold text-slate-800">{{ $po->vendor->nama_vendor ?? '-' }}</span>
                                        </div>
                                    </td>

                                    <td class="px-5 py-4">
                                        <div class="text-sm font-semibold text-slate-900">{{ $po->tender->nama_tender ?? '-' }}</div>
                                        <div class="text-xs text-slate-500 mt-0.5">
                                            {{ $po->items->first()->nama_barang ?? '-' }}
                                        </div>
                                    </td>

                                    <td class="px-5 py-4 whitespace-nowrap text-sm text-slate-700">
                                        {{ $po->items->sum('qty') }} item(s)
                                    </td>

                                    <td class="px-5 py-4 whitespace-nowrap">
                                        @if ($po->tanggal_pengiriman)
                                            <span class="text-sm text-slate-700">
                                                {{ \Carbon\Carbon::parse($po->tanggal_pengiriman)->format('d M Y') }}
                                            </span>
                                        @else
                                            <span class="text-slate-400 text-sm">-</span>
                                        @endif
                                    </td>

                                    <td class="px-5 py-4 whitespace-nowrap">
                                        @if ($po->goodsReceipt)
                                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold {{ $po->goodsReceipt->status_badge_class }}">
                                                <span class="w-1.5 h-1.5 rounded-full bg-current"></span>
                                                {{ $po->goodsReceipt->status_label }}
                                            </span>
                                        @elseif ($po->status === 'dikirim')
                                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-orange-100 text-orange-700">
                                                <span class="w-1.5 h-1.5 rounded-full bg-current animate-pulse"></span>
                                                Barang Dikirim
                                            </span>
                                        @else
                                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-slate-100 text-slate-700">
                                                {{ str_replace('_', ' ', ucfirst($po->status)) }}
                                            </span>
                                        @endif
                                    </td>

                                    <td class="px-5 py-4 whitespace-nowrap">
                                        @if ($po->goodsReceipt)
                                            <a href="{{ route('gudang.goods-receipts.report', $po->goodsReceipt->id) }}"
                                                class="inline-flex items-center gap-1.5 px-4 py-2 bg-slate-100 text-slate-700 rounded-xl text-xs font-semibold hover:bg-slate-200 transition">
                                                Lihat Laporan
                                            </a>
                                        @elseif($po->status === 'dikirim')
                                            <a href="{{ route('gudang.goods-receipts.show', $po->id) }}"
                                                class="inline-flex items-center gap-1.5 px-4 py-2 bg-blue-900 text-white rounded-xl text-xs font-semibold hover:bg-blue-950 transition shadow-sm">
                                                Periksa Barang
                                            </a>
                                        @else
                                            <span class="text-xs text-slate-400">-</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="px-6 py-20 text-center">
                                        <div class="mx-auto w-16 h-16 rounded-2xl bg-slate-100 flex items-center justify-center mb-4">
                                            <svg class="w-8 h-8 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                                        </div>
                                        <h3 class="text-lg font-bold text-slate-900">Belum Ada Purchase Order</h3>
                                        <p class="text-sm text-slate-500 mt-2">PO akan muncul setelah vendor mengirimkan barang.</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if ($purchaseOrders->hasPages())
                    <div class="px-6 py-4 border-t border-slate-200">
                        {{ $purchaseOrders->links() }}
                    </div>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>
