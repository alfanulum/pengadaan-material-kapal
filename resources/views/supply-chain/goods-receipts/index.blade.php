<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3">
            <div>
                <div class="flex items-center gap-2 text-sm text-slate-500 mb-1">
                    <a href="{{ route('supply-chain.dashboard') }}" class="hover:text-blue-700 transition">Dashboard</a>
                    <span>/</span>
                    <span class="text-slate-900 font-semibold">Laporan Penerimaan Barang</span>
                </div>
                <h2 class="font-bold text-2xl text-slate-900 leading-tight">
                    Laporan Penerimaan Barang
                </h2>
                <p class="text-sm text-slate-500 mt-1">
                    Pantau seluruh laporan penerimaan material yang dikirimkan dari gudang.
                </p>
            </div>
            <a href="{{ route('supply-chain.dashboard') }}"
                class="inline-flex items-center gap-2 px-5 py-2.5 bg-slate-100 text-slate-700 rounded-xl font-semibold border border-slate-200 hover:bg-slate-200 transition text-sm">
                ← Kembali
            </a>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

            {{-- Hero Stats --}}
            <div class="bg-gradient-to-r from-slate-950 via-blue-950 to-blue-800 rounded-3xl p-6 md:p-8 text-white shadow-xl relative overflow-hidden">
                <div class="absolute -top-12 -right-12 w-48 h-48 bg-cyan-400/20 rounded-full blur-3xl"></div>
                <div class="absolute -bottom-12 -left-12 w-48 h-48 bg-blue-400/20 rounded-full blur-3xl"></div>
                <div class="relative z-10">
                    <p class="text-sm text-blue-200 mb-1">Supply Chain · Monitoring</p>
                    <h3 class="text-2xl md:text-3xl font-bold mb-6">Laporan Penerimaan Barang dari Gudang</h3>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                        <div class="bg-white/10 rounded-2xl p-4 border border-white/10">
                            <p class="text-xs text-blue-200">Total Laporan</p>
                            <p class="text-2xl font-bold mt-1">{{ $stats['total'] }}</p>
                        </div>
                        <div class="bg-white/10 rounded-2xl p-4 border border-white/10">
                            <p class="text-xs text-blue-200">Diterima Sesuai</p>
                            <p class="text-2xl font-bold mt-1 text-emerald-300">{{ $stats['diterima_sesuai'] }}</p>
                        </div>
                        <div class="bg-white/10 rounded-2xl p-4 border border-white/10">
                            <p class="text-xs text-blue-200">Barang Bermasalah</p>
                            <p class="text-2xl font-bold mt-1 text-red-300">{{ $stats['bermasalah'] }}</p>
                        </div>
                        <div class="bg-white/10 rounded-2xl p-4 border border-white/10">
                            <p class="text-xs text-blue-200">Menunggu Tindak Lanjut</p>
                            <p class="text-2xl font-bold mt-1 text-amber-300">{{ $stats['tindak_lanjut'] }}</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Tabel Laporan --}}
            <div class="bg-white rounded-3xl shadow-sm border border-slate-200 overflow-hidden">
                <div class="px-6 py-5 border-b border-slate-200 flex items-center justify-between">
                    <div>
                        <h3 class="text-lg font-bold text-slate-900">Daftar Laporan Penerimaan</h3>
                        <p class="text-sm text-slate-500 mt-0.5">Laporan yang dibuat oleh staf gudang setelah barang diterima dari vendor.</p>
                    </div>
                    <span class="px-3 py-1 rounded-full bg-blue-50 text-blue-700 text-xs font-bold border border-blue-100">
                        {{ $goodsReceipts->total() }} Laporan
                    </span>
                </div>

                @if(session('success'))
                    <div class="mx-6 mt-4 p-4 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-xl text-sm">
                        ✅ {{ session('success') }}
                    </div>
                @endif

                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-slate-50 border-b border-slate-200">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">No. PO / Vendor</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Material / Project</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Tgl Diterima</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Kondisi Barang</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @forelse($goodsReceipts as $receipt)
                                <tr class="hover:bg-slate-50/70 transition">
                                    <td class="px-6 py-4">
                                        <p class="text-sm font-black text-slate-900">{{ $receipt->purchaseOrder->kode_po }}</p>
                                        <p class="text-xs text-slate-500 mt-0.5">{{ $receipt->purchaseOrder->vendor->nama_vendor ?? '-' }}</p>
                                    </td>
                                    <td class="px-6 py-4">
                                        <p class="text-sm font-semibold text-slate-800">{{ $receipt->purchaseOrder->items->first()->nama_barang ?? '-' }}</p>
                                        <p class="text-xs text-slate-500 mt-0.5">{{ $receipt->purchaseOrder->tender->materialRequest->project->nama_project ?? '-' }}</p>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <p class="text-sm text-slate-700">{{ \Carbon\Carbon::parse($receipt->tanggal_diterima)->format('d M Y') }}</p>
                                        <p class="text-xs text-slate-500">Jml: {{ $receipt->jumlah_diterima }} item</p>
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
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold {{ $kondisiClass }}">
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
                                        <a href="{{ route('supply-chain.goods-receipts.show', $receipt->id) }}"
                                            class="inline-flex items-center gap-1.5 px-4 py-2 bg-blue-900 text-white rounded-xl text-xs font-semibold hover:bg-blue-950 transition shadow-sm">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                            Lihat Detail
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-20 text-center">
                                        <div class="mx-auto w-16 h-16 rounded-2xl bg-slate-100 flex items-center justify-center mb-4">
                                            <svg class="w-8 h-8 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                        </div>
                                        <h3 class="text-lg font-bold text-slate-900">Belum Ada Laporan</h3>
                                        <p class="text-sm text-slate-500 mt-2">Laporan penerimaan akan muncul di sini setelah gudang membuat laporan pemeriksaan barang.</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if($goodsReceipts->hasPages())
                    <div class="px-6 py-4 border-t border-slate-200">
                        {{ $goodsReceipts->links() }}
                    </div>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>
