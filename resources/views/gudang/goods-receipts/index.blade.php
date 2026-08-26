<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <div class="flex items-center gap-2 text-sm text-slate-500 mb-1">
                    <a href="{{ route('gudang.dashboard') }}" class="hover:text-blue-700 transition">Dashboard</a>
                    <span>/</span>
                    <span class="text-slate-900 font-semibold">Daftar Penerimaan Barang</span>
                </div>
                <h2 class="font-bold text-2xl text-slate-900 leading-tight">
                    Penerimaan Barang (Goods Receipt)
                </h2>
                <p class="text-sm text-slate-500 mt-1">
                    Purchase Order yang sudah dikirim vendor dan menunggu/sudah melalui proses penerimaan gudang.
                </p>
            </div>
            <a href="{{ route('gudang.dashboard') }}"
                class="inline-flex items-center gap-2 px-5 py-2.5 bg-slate-100 text-slate-700 rounded-xl font-semibold border border-slate-200 hover:bg-slate-200 transition text-sm">
                ← Dashboard
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">

            {{-- Flash Messages --}}
            @if (session('success'))
                <div class="p-4 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-2xl flex items-center gap-3 shadow-sm">
                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    {{ session('success') }}
                </div>
            @endif

            {{-- Filter & Search --}}
            <div class="bg-white rounded-3xl shadow-sm border border-slate-200 p-6 flex flex-col md:flex-row gap-4 items-center justify-between">
                <div>
                    <h3 class="text-lg font-bold text-slate-900">Riwayat & Daftar PO</h3>
                    <p class="text-sm text-slate-500">{{ $purchaseOrders->total() }} data ditemukan</p>
                </div>
                
                <form action="{{ route('gudang.goods-receipts.index') }}" method="GET" class="w-full md:w-96 relative">
                    <div class="relative flex items-center">
                        <svg class="w-5 h-5 absolute left-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                        <input type="text" name="search" value="{{ request('search') }}" 
                            placeholder="Cari No. PO atau nama vendor..." 
                            class="w-full pl-12 pr-24 py-3 bg-slate-50 border border-slate-200 text-slate-900 rounded-2xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition outline-none text-sm font-medium">
                        <button type="submit" class="absolute right-2 top-1/2 -translate-y-1/2 px-4 py-1.5 bg-blue-600 text-white rounded-xl text-xs font-bold hover:bg-blue-700 transition shadow-sm">
                            Cari
                        </button>
                    </div>
                </form>
            </div>

            {{-- Tabel Data --}}
            <div class="bg-white rounded-3xl shadow-sm border border-slate-200 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-slate-50/50 border-b border-slate-100">
                                <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">No. PO</th>
                                <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Vendor</th>
                                <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Tender / Material</th>
                                <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider text-center">Qty</th>
                                <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Tgl Dikirim</th>
                                <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider text-right">Aksi</th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-slate-100">
                            @forelse ($purchaseOrders as $po)
                                <tr class="hover:bg-slate-50/50 transition group">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="text-sm font-bold text-slate-900">{{ $po->kode_po }}</span>
                                    </td>

                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center gap-3">
                                            <div class="w-8 h-8 rounded-full bg-blue-50 flex items-center justify-center shrink-0 border border-blue-100">
                                                <span class="text-xs font-bold text-blue-700">{{ substr($po->vendor->nama_vendor ?? 'V', 0, 1) }}</span>
                                            </div>
                                            <span class="text-sm font-semibold text-slate-800">{{ $po->vendor->nama_vendor ?? '-' }}</span>
                                        </div>
                                    </td>

                                    <td class="px-6 py-4">
                                        <div class="text-sm font-semibold text-slate-900 truncate max-w-[200px]" title="{{ $po->tender->nama_tender ?? '-' }}">{{ $po->tender->nama_tender ?? '-' }}</div>
                                        <div class="text-xs text-slate-500 mt-0.5 truncate max-w-[200px]">
                                            {{ $po->items->first()->nama_barang ?? 'Material tidak tersedia' }}
                                        </div>
                                    </td>

                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-center font-bold text-slate-700">
                                        {{ $po->items->sum('qty') }}
                                    </td>

                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if ($po->tanggal_pengiriman)
                                            <span class="text-sm text-slate-700 font-medium">
                                                {{ \Carbon\Carbon::parse($po->tanggal_pengiriman)->format('d M Y') }}
                                            </span>
                                        @else
                                            <span class="text-slate-400 text-sm">-</span>
                                        @endif
                                    </td>

                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if ($po->goodsReceipt)
                                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold border 
                                                {{ str_contains($po->goodsReceipt->status_badge_class, 'emerald') ? 'bg-emerald-50 text-emerald-700 border-emerald-200' : 'bg-amber-50 text-amber-700 border-amber-200' }}">
                                                <span class="w-1.5 h-1.5 rounded-full bg-current"></span>
                                                {{ $po->goodsReceipt->status_label }}
                                            </span>
                                        @elseif ($po->status === 'dikirim')
                                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-orange-50 text-orange-700 border border-orange-200">
                                                <span class="w-1.5 h-1.5 rounded-full bg-current animate-pulse"></span>
                                                Menunggu Pemeriksaan
                                            </span>
                                        @elseif ($po->status === 'selesai')
                                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                                <span class="w-1.5 h-1.5 rounded-full bg-current"></span>
                                                Selesai
                                            </span>
                                        @else
                                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-slate-50 text-slate-700 border border-slate-200">
                                                {{ str_replace('_', ' ', ucfirst($po->status)) }}
                                            </span>
                                        @endif
                                    </td>

                                    <td class="px-6 py-4 whitespace-nowrap text-right">
                                        @if ($po->goodsReceipt)
                                            <a href="{{ route('gudang.goods-receipts.report', $po->goodsReceipt->id) }}"
                                                class="inline-flex items-center justify-center gap-2 px-4 py-2 bg-white border border-slate-200 text-slate-700 rounded-xl text-xs font-bold hover:bg-slate-50 transition shadow-sm">
                                                <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                                Lihat Laporan
                                            </a>
                                        @else
                                            <a href="{{ route('gudang.goods-receipts.show', $po->id) }}"
                                                class="inline-flex items-center justify-center gap-2 px-4 py-2 bg-blue-600 text-white rounded-xl text-xs font-bold hover:bg-blue-700 transition shadow-sm shadow-blue-600/20">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2M15 11l-3 3m0 0l-3-3m3 3V8"/></svg>
                                                Periksa Barang
                                            </a>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="px-6 py-20 text-center">
                                        <div class="mx-auto w-16 h-16 rounded-full bg-slate-50 border border-slate-100 flex items-center justify-center mb-4">
                                            <svg class="w-8 h-8 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                                        </div>
                                        <h3 class="text-lg font-bold text-slate-900">Belum Ada Data</h3>
                                        <p class="text-sm text-slate-500 mt-2">Tidak ditemukan Purchase Order yang sesuai.</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if ($purchaseOrders->hasPages())
                    <div class="px-6 py-4 border-t border-slate-100 bg-slate-50/50">
                        {{ $purchaseOrders->links() }}
                    </div>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>
