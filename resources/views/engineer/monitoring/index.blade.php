<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3">
            <div>
                <div class="flex items-center gap-2 text-sm text-slate-500 mb-1">
                    <a href="{{ route('engineer.dashboard') }}" class="hover:text-blue-700 transition">Dashboard</a>
                    <span>/</span>
                    <span class="text-slate-900 font-semibold">Monitoring</span>
                </div>
                <h2 class="font-bold text-2xl text-slate-900 leading-tight">
                    Monitoring Kebutuhan Material
                </h2>
                <p class="text-sm text-slate-500 mt-1">
                    Pantau tahapan pengadaan material yang telah diproses menjadi Purchase Order oleh Supply Chain.
                </p>
            </div>
            <a href="{{ route('engineer.dashboard') }}"
                class="inline-flex items-center gap-2 px-5 py-2.5 bg-white border border-slate-200 hover:bg-slate-50 text-slate-700 rounded-xl text-sm font-semibold shadow-sm transition hover:-translate-y-0.5">
                <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                <span>Dashboard</span>
            </a>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

            {{-- SEARCH BAR --}}
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-4">
                <div class="flex flex-col sm:flex-row gap-3">
                    <div class="relative flex-1">
                        <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                        <input type="text" id="monitoringSearch" placeholder="Cari vendor, tender, atau material..."
                            class="w-full pl-9 pr-4 py-3 rounded-xl border border-slate-200 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                    </div>
                    <button type="button" class="inline-flex items-center justify-center gap-2 px-6 py-3 bg-gradient-to-r from-slate-900 to-blue-900 hover:from-slate-800 hover:to-blue-800 text-white rounded-xl text-sm font-bold shadow-sm shadow-blue-900/20 transition hover:-translate-y-0.5 whitespace-nowrap">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                        <span>Cari Data</span>
                    </button>
                </div>
                <p id="monitoringNoResult" class="hidden text-sm text-slate-500 mt-3 text-center py-2">Tidak ada data yang cocok dengan pencarian.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6" id="monitoringGrid">
                @forelse($purchaseOrders as $po)
                    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6 flex flex-col justify-between hover:border-blue-300 hover:shadow-md transition duration-200">
                        <div>
                            <div class="flex items-start justify-between gap-3 mb-4">
                                <span class="text-xs font-bold text-blue-900 bg-blue-50 px-3 py-1 rounded-lg border border-blue-100">
                                    Tender #{{ $po->tender->kode_tender ?? '-' }}
                                </span>
                                @php
                                    $statusLabel = 'Pesanan Dibuat';
                                    $statusClass = 'text-slate-700 bg-slate-100 border-slate-200';
                                    
                                    if($po->goodsReceipt) {
                                        $statusLabel = 'Barang Diterima Gudang';
                                        $statusClass = 'text-emerald-700 bg-emerald-50 border-emerald-200';
                                    } elseif($po->status === 'dikirim' || $po->status === 'selesai' || $po->tanggal_pengiriman) {
                                        $statusLabel = 'Barang Sedang Dikirim';
                                        $statusClass = 'text-blue-700 bg-blue-50 border-blue-200';
                                    }
                                @endphp
                                <span class="px-3 py-1 rounded-full text-[11px] font-bold border {{ $statusClass }}">
                                    {{ $statusLabel }}
                                </span>
                            </div>

                            <h4 class="font-bold text-slate-900 text-base line-clamp-2 mb-4">
                                {{ $po->items->first()->nama_barang ?? 'Material' }} 
                                @if($po->items->count() > 1) 
                                    <span class="text-xs font-normal text-slate-500">dan {{ $po->items->count() - 1 }} item lainnya</span>
                                @endif
                            </h4>
                            
                            <div class="space-y-3 text-xs text-slate-600 mb-6">
                                <div class="flex items-center gap-3 bg-slate-50 p-3 rounded-xl border border-slate-100">
                                    <div class="w-7 h-7 rounded-lg bg-white flex items-center justify-center shrink-0 border border-slate-200 shadow-2xs">
                                        <svg class="w-3.5 h-3.5 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                                    </div>
                                    <div>
                                        <p class="text-[10px] uppercase font-bold text-slate-400">Vendor Pemenang</p>
                                        <p class="font-bold text-slate-800">{{ $po->vendor->nama_vendor ?? '-' }}</p>
                                    </div>
                                </div>
                                <div class="flex items-center gap-3 bg-slate-50 p-3 rounded-xl border border-slate-100">
                                    <div class="w-7 h-7 rounded-lg bg-white flex items-center justify-center shrink-0 border border-slate-200 shadow-2xs">
                                        <svg class="w-3.5 h-3.5 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                    </div>
                                    <div>
                                        <p class="text-[10px] uppercase font-bold text-slate-400">Tanggal Penerbitan PO</p>
                                        <p class="font-bold text-slate-800">{{ $po->created_at->translatedFormat('d F Y') }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="pt-4 border-t border-slate-100 flex justify-end">
                            <a href="{{ route('engineer.monitoring.show', $po->id) }}"
                                class="inline-flex items-center justify-center gap-2 px-5 py-2.5 bg-blue-900 hover:bg-blue-950 text-white rounded-xl text-xs font-bold shadow-sm transition hover:shadow w-full sm:w-auto">
                                <span>Lihat Progres Pengadaan</span>
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="md:col-span-2 py-16 text-center bg-white rounded-2xl border border-slate-200">
                        <div class="mx-auto w-16 h-16 rounded-2xl bg-slate-100 flex items-center justify-center mb-4">
                            <svg class="w-8 h-8 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                        </div>
                        <h3 class="text-base font-bold text-slate-900">Belum Ada Data Pengadaan Aktif</h3>
                        <p class="text-xs text-slate-500 mt-1 max-w-sm mx-auto">Daftar monitoring pengadaan material akan muncul secara otomatis setelah Purchase Order (PO) diterbitkan oleh tim Supply Chain.</p>
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
    
    <script>
    (function() {
        const searchInput = document.getElementById('monitoringSearch');
        const grid = document.getElementById('monitoringGrid');
        const noResult = document.getElementById('monitoringNoResult');

        if(searchInput && grid) {
            searchInput.addEventListener('input', function() {
                const keyword = this.value.toLowerCase().trim();
                const cards = grid.querySelectorAll(':scope > div');
                let visibleCount = 0;

                cards.forEach(function(card) {
                    const text = card.textContent.toLowerCase();
                    if (!keyword || text.includes(keyword)) {
                        card.style.display = '';
                        visibleCount++;
                    } else {
                        card.style.display = 'none';
                    }
                });

                if(noResult) {
                    noResult.classList.toggle('hidden', visibleCount > 0 || cards.length === 0);
                }
            });
        }
    })();
    </script>
</x-app-layout>
