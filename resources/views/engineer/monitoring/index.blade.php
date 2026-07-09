<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3">
            <div>
                <div class="flex items-center gap-2 text-sm text-slate-500 mb-1">
                    <a href="{{ route('engineer.dashboard') }}" class="hover:text-blue-700 transition">Dashboard</a>
                    <span>/</span>
                    <span class="text-slate-900 font-semibold">Monitoring Kebutuhan</span>
                </div>
                <h2 class="font-bold text-2xl text-slate-900 leading-tight">
                    Monitoring Kebutuhan Material
                </h2>
                <p class="text-sm text-slate-500 mt-1">
                    Pantau status pengadaan material yang sudah diproses oleh Supply Chain.
                </p>
            </div>
            <a href="{{ route('engineer.dashboard') }}"
                class="inline-flex items-center gap-2 px-5 py-2.5 bg-slate-100 text-slate-700 rounded-xl font-semibold border border-slate-200 hover:bg-slate-200 transition text-sm">
                ← Kembali
            </a>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @forelse($purchaseOrders as $po)
                    <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6 flex flex-col hover:shadow-md transition">
                        <div class="flex items-start justify-between mb-4">
                            <span class="text-sm font-bold text-slate-700">
                                Tender #{{ $po->tender->kode_tender ?? '-' }}
                            </span>
                            @php
                                $statusLabel = 'Pesanan Dibuat';
                                $statusClass = 'text-slate-600 bg-slate-100 border-slate-200';
                                
                                if($po->goodsReceipt) {
                                    $statusLabel = 'Barang Diterima Gudang';
                                    $statusClass = 'text-emerald-700 bg-emerald-50 border-emerald-200';
                                } elseif($po->status === 'dikirim' || $po->status === 'selesai' || $po->tanggal_pengiriman) {
                                    $statusLabel = 'Barang Dikirim';
                                    $statusClass = 'text-blue-700 bg-blue-50 border-blue-200';
                                }
                            @endphp
                            <span class="px-2.5 py-1 rounded-full text-[10px] uppercase tracking-wider font-bold border {{ $statusClass }}">
                                {{ $statusLabel }}
                            </span>
                        </div>

                        <h4 class="font-bold text-slate-900 text-lg line-clamp-2 mb-4">
                            {{ $po->items->first()->nama_barang ?? 'Material' }} 
                            @if($po->items->count() > 1) 
                                dkk ({{ $po->items->count() }} item)
                            @endif
                        </h4>
                        
                        <div class="space-y-3 text-sm text-slate-600 flex-grow">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-lg bg-slate-50 flex items-center justify-center shrink-0">
                                    <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                                </div>
                                <div>
                                    <p class="text-xs text-slate-400">Vendor</p>
                                    <p class="font-semibold text-slate-700">{{ $po->vendor->nama_vendor ?? '-' }}</p>
                                </div>
                            </div>
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-lg bg-slate-50 flex items-center justify-center shrink-0">
                                    <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                </div>
                                <div>
                                    <p class="text-xs text-slate-400">PO Dibuat</p>
                                    <p class="font-semibold text-slate-700">{{ $po->created_at->format('d M Y') }}</p>
                                </div>
                            </div>
                        </div>

                        <div class="mt-6 pt-4 border-t border-slate-100 flex justify-end">
                            <a href="{{ route('engineer.monitoring.show', $po->id) }}"
                                class="inline-flex items-center justify-center gap-2 px-5 h-[42px] bg-slate-900 text-white rounded-lg text-sm font-semibold hover:bg-blue-700 transition w-full md:w-auto">
                                Detail Monitoring 
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="md:col-span-2 lg:col-span-3 py-16 text-center bg-white rounded-3xl border border-slate-200">
                        <div class="mx-auto w-16 h-16 rounded-2xl bg-slate-100 flex items-center justify-center mb-4">
                            <svg class="w-8 h-8 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                        </div>
                        <h3 class="text-lg font-bold text-slate-900">Belum Ada Pengadaan</h3>
                        <p class="text-slate-500 mt-2">Daftar monitoring akan muncul setelah ada PO yang diterbitkan oleh Supply Chain.</p>
                    </div>
                @endforelse
            </div>

            @if($purchaseOrders->hasPages())
                <div class="mt-6">
                    {{ $purchaseOrders->links() }}
                </div>
            @endif

        </div>
    </div>
</x-app-layout>
