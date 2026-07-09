<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3">
            <div>
                <h2 class="font-bold text-2xl text-slate-900 leading-tight">
                    Laporan Penerimaan Gudang
                </h2>
                <p class="text-sm text-slate-500 mt-1">
                    Monitor hasil penerimaan dan pemeriksaan barang oleh tim gudang dari seluruh Purchase Order.
                </p>
            </div>
            <div class="text-sm text-slate-600 bg-white px-4 py-2 rounded-xl border border-slate-200 shadow-sm">
                📅 {{ now()->format('d M Y') }}
            </div>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-7">

            {{-- ============================================================
                 HERO
                 ============================================================ --}}
            <div class="relative overflow-hidden rounded-3xl bg-gradient-to-r from-slate-950 via-blue-950 to-blue-800 p-7 md:p-10 shadow-xl text-white">
                <div class="absolute -top-20 -right-20 w-72 h-72 bg-cyan-400/20 rounded-full blur-3xl"></div>
                <div class="absolute -bottom-20 -left-20 w-72 h-72 bg-blue-400/20 rounded-full blur-3xl"></div>
                <div class="relative z-10 grid grid-cols-1 lg:grid-cols-3 gap-6 items-center">
                    <div class="lg:col-span-2">
                        <p class="inline-flex px-4 py-1.5 rounded-full bg-white/10 border border-white/10 text-sm text-blue-100 mb-4">
                            🏭 Goods Receipt Monitoring
                        </p>
                        <h3 class="text-2xl md:text-3xl font-black leading-tight">
                            Monitoring Penerimaan Material Kapal
                        </h3>
                        <p class="mt-3 text-blue-100 text-sm leading-relaxed max-w-2xl">
                            Pantau seluruh laporan penerimaan barang dari gudang, identifikasi masalah pengiriman vendor,
                            dan ambil tindakan cepat untuk menjaga kelancaran pengadaan material kapal.
                        </p>
                    </div>
                    <div class="grid grid-cols-2 gap-3">
                        <div class="bg-white/10 rounded-2xl p-4 text-center">
                            <p class="text-3xl font-black">{{ $stats['total'] }}</p>
                            <p class="text-xs text-blue-200 mt-1">Total Laporan</p>
                        </div>
                        <div class="bg-white/10 rounded-2xl p-4 text-center">
                            <p class="text-3xl font-black text-emerald-300">{{ $stats['diterima_sesuai'] }}</p>
                            <p class="text-xs text-blue-200 mt-1">Diterima Sesuai</p>
                        </div>
                        <div class="bg-white/10 rounded-2xl p-4 text-center">
                            <p class="text-3xl font-black text-red-300">{{ $stats['bermasalah'] }}</p>
                            <p class="text-xs text-blue-200 mt-1">Bermasalah</p>
                        </div>
                        <div class="bg-white/10 rounded-2xl p-4 text-center">
                            <p class="text-3xl font-black text-amber-300">{{ $stats['menunggu_tindak_lanjut'] }}</p>
                            <p class="text-xs text-blue-200 mt-1">Perlu Tindak Lanjut</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- ============================================================
                 FILTER & SEARCH
                 ============================================================ --}}
            <form method="GET" action="{{ route('supply-chain.goods-receipt-reports.index') }}"
                class="bg-white rounded-2xl border border-slate-200 shadow-sm p-5 flex flex-col sm:flex-row gap-3">
                <div class="flex-1">
                    <label class="block text-xs font-semibold text-slate-500 mb-1.5 uppercase tracking-wider">Cari PO / Vendor</label>
                    <div class="relative">
                        <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                        <input type="text" name="search" value="{{ request('search') }}"
                            placeholder="Cari nomor PO atau nama vendor..."
                            class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-slate-200 text-sm text-slate-700 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                    </div>
                </div>
                <div class="min-w-[200px]">
                    <label class="block text-xs font-semibold text-slate-500 mb-1.5 uppercase tracking-wider">Status Penerimaan</label>
                    <select name="status"
                        class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm text-slate-700 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition bg-white">
                        <option value="">Semua Status</option>
                        <option value="diterima_sesuai" {{ request('status') === 'diterima_sesuai' ? 'selected' : '' }}>Diterima Sesuai</option>
                        <option value="diterima_dengan_catatan" {{ request('status') === 'diterima_dengan_catatan' ? 'selected' : '' }}>Diterima Dengan Catatan</option>
                        <option value="menunggu_tindak_lanjut" {{ request('status') === 'menunggu_tindak_lanjut' ? 'selected' : '' }}>Menunggu Tindak Lanjut</option>
                        <option value="retur_barang" {{ request('status') === 'retur_barang' ? 'selected' : '' }}>Retur Barang</option>
                        <option value="penggantian_vendor" {{ request('status') === 'penggantian_vendor' ? 'selected' : '' }}>Penggantian Vendor</option>
                    </select>
                </div>
                <div class="flex items-end gap-2">
                    <button type="submit"
                        class="px-5 py-2.5 bg-blue-900 text-white rounded-xl text-sm font-semibold hover:bg-blue-950 transition shadow-sm">
                        Filter
                    </button>
                    @if (request('search') || request('status'))
                    <a href="{{ route('supply-chain.goods-receipt-reports.index') }}"
                        class="px-4 py-2.5 bg-slate-100 text-slate-700 rounded-xl text-sm font-semibold hover:bg-slate-200 transition border border-slate-200">
                        Reset
                    </a>
                    @endif
                </div>
            </form>

            @if (session('success'))
                <div class="p-4 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-2xl flex items-center gap-3">
                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    {{ session('success') }}
                </div>
            @endif

            {{-- ============================================================
                 TABEL LAPORAN
                 ============================================================ --}}
            <div class="bg-white rounded-3xl shadow-sm border border-slate-200 overflow-hidden">
                <div class="px-6 py-5 border-b border-slate-200 flex items-center justify-between">
                    <div>
                        <h3 class="text-lg font-bold text-slate-900">Daftar Laporan Penerimaan</h3>
                        <p class="text-sm text-slate-500 mt-0.5">{{ $receipts->total() }} laporan ditemukan</p>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-slate-50 border-b border-slate-200">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Nomor PO</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Vendor</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Material</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Tanggal Diterima</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Jml Diterima</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Kondisi</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-slate-100">
                            @forelse ($receipts as $receipt)
                                <tr class="hover:bg-slate-50/60 transition">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-black text-slate-900">{{ $receipt->purchaseOrder->kode_po }}</div>
                                        <div class="text-xs text-slate-500 mt-0.5">{{ $receipt->purchaseOrder->tender->kode_tender ?? '-' }}</div>
                                    </td>

                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-2">
                                            <div class="w-7 h-7 rounded-lg bg-blue-100 flex items-center justify-center shrink-0">
                                                <span class="text-xs font-bold text-blue-700">{{ substr($receipt->purchaseOrder->vendor->nama_vendor ?? 'V', 0, 1) }}</span>
                                            </div>
                                            <span class="text-sm font-semibold text-slate-800">{{ $receipt->purchaseOrder->vendor->nama_vendor ?? '-' }}</span>
                                        </div>
                                    </td>

                                    <td class="px-6 py-4 text-sm text-slate-600 max-w-[180px]">
                                        <div class="truncate">{{ $receipt->purchaseOrder->items->first()->nama_barang ?? '-' }}</div>
                                        @if ($receipt->purchaseOrder->items->count() > 1)
                                            <div class="text-xs text-slate-400 mt-0.5">+{{ $receipt->purchaseOrder->items->count() - 1 }} item lain</div>
                                        @endif
                                    </td>

                                    <td class="px-6 py-4 text-sm text-slate-700 whitespace-nowrap">
                                        {{ $receipt->tanggal_diterima?->format('d M Y') }}
                                    </td>

                                    <td class="px-6 py-4 text-sm font-bold text-slate-900 whitespace-nowrap">
                                        {{ $receipt->jumlah_diterima }} item(s)
                                        @if ($receipt->jumlah_rusak)
                                            <div class="text-xs text-red-500 font-semibold">{{ $receipt->jumlah_rusak }} rusak</div>
                                        @endif
                                    </td>

                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @php
                                            $kondisiClass = match($receipt->kondisi_barang) {
                                                'sesuai' => 'bg-emerald-100 text-emerald-700',
                                                'diterima_dengan_catatan' => 'bg-yellow-100 text-yellow-700',
                                                'kerusakan' => 'bg-red-100 text-red-700',
                                                'tidak_sesuai_spesifikasi' => 'bg-orange-100 text-orange-700',
                                                default => 'bg-slate-100 text-slate-700',
                                            };
                                        @endphp
                                        <span class="inline-flex px-2.5 py-1 rounded-full text-xs font-bold {{ $kondisiClass }}">
                                            {{ $receipt->kondisi_label }}
                                        </span>
                                    </td>

                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold {{ $receipt->status_badge_class }}">
                                            <span class="w-1.5 h-1.5 rounded-full bg-current"></span>
                                            {{ $receipt->status_label }}
                                        </span>
                                    </td>

                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <a href="{{ route('supply-chain.goods-receipt-reports.show', $receipt->id) }}"
                                            class="inline-flex items-center gap-1.5 px-4 py-2 bg-blue-900 text-white rounded-xl text-xs font-semibold hover:bg-blue-950 transition shadow-sm">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                            Detail
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="px-6 py-20 text-center">
                                        <div class="mx-auto w-16 h-16 rounded-2xl bg-slate-100 flex items-center justify-center mb-4">
                                            <svg class="w-8 h-8 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2M15 11l-3 3m0 0l-3-3m3 3V8"/></svg>
                                        </div>
                                        <h3 class="text-lg font-bold text-slate-900">Belum Ada Laporan Penerimaan</h3>
                                        <p class="text-sm text-slate-500 mt-2">Laporan akan muncul setelah tim gudang melakukan pemeriksaan barang.</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if ($receipts->hasPages())
                    <div class="px-6 py-4 border-t border-slate-200">
                        {{ $receipts->links() }}
                    </div>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>
