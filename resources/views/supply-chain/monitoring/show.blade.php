<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3">
            <div>
                <div class="flex items-center gap-2 text-sm text-slate-500 mb-1">
                    <a href="{{ route('supply-chain.dashboard') }}" class="hover:text-blue-700 transition">Dashboard</a>
                    <span>/</span>
                    <a href="{{ route('supply-chain.monitoring.index') }}" class="hover:text-blue-700 transition">Monitoring</a>
                    <span>/</span>
                    <span class="text-slate-900 font-semibold">Detail Timeline</span>
                </div>
                <h2 class="font-bold text-2xl text-slate-900 leading-tight">
                    Detail Monitoring Pengadaan
                </h2>
                <p class="text-sm text-slate-500 mt-1">
                    PO <span class="font-bold text-blue-700">{{ $po->kode_po }}</span> — {{ $po->vendor->nama_vendor ?? '-' }}
                </p>
            </div>
            
            <div class="flex gap-2">
                @if($po->status === 'selesai' || $po->status === 'diterima_gudang' || $po->goodsReceipt)
                    <form action="{{ route('supply-chain.monitoring.destroy', $po->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus riwayat monitoring pengadaan ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="inline-flex items-center gap-2 px-5 py-2.5 bg-red-50 text-red-700 rounded-xl font-semibold border border-red-200 hover:bg-red-100 transition text-sm">
                            Hapus Monitoring
                        </button>
                    </form>
                @endif
                <a href="{{ route('supply-chain.monitoring.index') }}"
                    class="inline-flex items-center gap-2 px-5 py-2.5 bg-slate-100 text-slate-700 rounded-xl font-semibold border border-slate-200 hover:bg-slate-200 transition text-sm">
                    ← Kembali
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

            @if(session('success'))
                <div class="p-4 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-xl text-sm">
                    ✅ {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div class="p-4 bg-red-50 border border-red-200 text-red-700 rounded-xl text-sm">
                    ❌ {{ session('error') }}
                </div>
            @endif

            @php
                $step1_active = true;
                $step1_date = $po->created_at->format('d M Y');

                $isShipped = in_array($po->status, ['dikirim', 'selesai', 'diterima_gudang']);
                $step2_active = $isShipped;
                $step2_date = $isShipped && $po->tanggal_pengiriman ? \Carbon\Carbon::parse($po->tanggal_pengiriman)->format('d M Y') : '-';

                $hasReceipt = $po->goodsReceipt !== null;
                $step3_active = $hasReceipt;
                $step3_date = $hasReceipt && $po->goodsReceipt->tanggal_diterima ? \Carbon\Carbon::parse($po->goodsReceipt->tanggal_diterima)->format('d M Y') : '-';
            @endphp

            {{-- Tracking Timeline Card --}}
            <div class="bg-white rounded-3xl shadow-sm border border-slate-200 overflow-hidden">
                <div class="px-6 py-5 border-b border-slate-200 flex justify-between items-center bg-slate-50">
                    <h3 class="text-lg font-bold text-slate-900">Tracking Timeline Procurement</h3>
                    <a href="{{ route('supply-chain.monitoring.edit', $po->id) }}" class="text-sm font-semibold text-blue-700 hover:text-blue-900 flex items-center gap-1 bg-blue-50 px-3 py-1 rounded-full border border-blue-100 transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                        Edit Monitoring
                    </a>
                </div>
                
                <div class="p-8 md:p-12 overflow-x-auto">
                    <div class="relative min-w-[700px] mx-auto pt-4 pb-8">
                        {{-- Garis Background --}}
                        <div class="absolute left-[10%] right-[10%] top-9 h-1 bg-slate-200 z-0 rounded-full"></div>
                        
                        {{-- Garis Progress --}}
                        <div class="absolute left-[10%] top-9 h-1 bg-emerald-500 transition-all duration-500 z-0 rounded-full"
                            style="width: {{ $step3_active ? '80%' : ($step2_active ? '40%' : '0%') }};"></div>

                        <div class="grid grid-cols-3 relative z-10 text-center">
                            
                            {{-- Step 1 --}}
                            <div class="relative group flex flex-col items-center">
                                <div class="w-10 h-10 rounded-full flex items-center justify-center border-[3px] shadow-sm transition-transform duration-300 bg-white {{ $step1_active ? 'border-emerald-500 text-emerald-500 group-hover:scale-110' : 'border-slate-300 text-slate-300' }} z-10">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                                </div>
                                <div class="mt-4 px-2">
                                    <h5 class="font-bold text-sm {{ $step1_active ? 'text-slate-900' : 'text-slate-500' }}">Pesanan Dibuat</h5>
                                    @if($step1_active)
                                        <p class="text-xs font-medium text-emerald-600 mt-1">{{ $step1_date }}</p>
                                        <p class="text-[11px] text-slate-500 mt-1 max-w-[150px] mx-auto">PO dibuat oleh Supply Chain</p>
                                    @endif
                                </div>
                            </div>

                            {{-- Step 2 --}}
                            <div class="relative group flex flex-col items-center">
                                <div class="w-10 h-10 rounded-full flex items-center justify-center border-[3px] shadow-sm transition-transform duration-300 bg-white {{ $step2_active ? 'border-emerald-500 text-emerald-500 group-hover:scale-110' : 'border-slate-300 text-slate-300' }} z-10">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                                </div>
                                <div class="mt-4 px-2">
                                    <h5 class="font-bold text-sm {{ $step2_active ? 'text-slate-900' : 'text-slate-500' }}">Barang Dikirim</h5>
                                    @if($step2_active)
                                        <p class="text-xs font-medium text-emerald-600 mt-1">{{ $step2_date }}</p>
                                        <p class="text-[11px] text-slate-500 mt-1 max-w-[150px] mx-auto">Vendor mengirim barang</p>
                                    @else
                                        <p class="text-[11px] text-slate-400 mt-1 max-w-[150px] mx-auto">Menunggu vendor mengirim barang</p>
                                    @endif
                                </div>
                            </div>

                            {{-- Step 3 --}}
                            <div class="relative group flex flex-col items-center">
                                <div class="w-10 h-10 rounded-full flex items-center justify-center border-[3px] shadow-sm transition-transform duration-300 bg-white {{ $step3_active ? 'border-emerald-500 text-emerald-500 group-hover:scale-110' : 'border-slate-300 text-slate-300' }} z-10">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                                </div>
                                <div class="mt-4 px-2">
                                    <h5 class="font-bold text-sm {{ $step3_active ? 'text-slate-900' : 'text-slate-500' }}">Barang Diterima Gudang</h5>
                                    @if($step3_active)
                                        <p class="text-xs font-medium text-emerald-600 mt-1">{{ $step3_date }}</p>
                                        <p class="text-[11px] font-semibold {{ in_array($po->goodsReceipt->kondisi_barang, ['kerusakan', 'tidak_sesuai_spesifikasi']) ? 'text-red-500' : 'text-slate-600' }} mt-1 max-w-[150px] mx-auto">
                                            {{ $po->goodsReceipt->kondisi_label }}
                                        </p>
                                    @else
                                        <p class="text-[11px] text-slate-400 mt-1 max-w-[150px] mx-auto">Menunggu laporan penerimaan gudang</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Detail PO --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6">
                    <h4 class="font-bold text-slate-900 mb-6 flex items-center gap-2">
                        <svg class="w-5 h-5 text-blue-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        Informasi Tender & PO
                    </h4>
                    <div class="space-y-4 text-sm">
                        <div class="flex flex-col border-b border-slate-100 pb-3">
                            <span class="text-xs text-slate-500 mb-1">Nomor Tender</span>
                            <span class="font-semibold text-slate-900">{{ $po->tender->kode_tender ?? '-' }}</span>
                        </div>
                        <div class="flex flex-col border-b border-slate-100 pb-3">
                            <span class="text-xs text-slate-500 mb-1">Nomor PO</span>
                            <span class="font-semibold text-slate-900">{{ $po->kode_po }}</span>
                        </div>
                        <div class="flex flex-col border-b border-slate-100 pb-3">
                            <span class="text-xs text-slate-500 mb-1">Vendor</span>
                            <span class="font-semibold text-slate-900">{{ $po->vendor->nama_vendor ?? '-' }}</span>
                        </div>
                        <div class="flex flex-col pb-1">
                            <span class="text-xs text-slate-500 mb-1">Project</span>
                            <span class="font-semibold text-slate-900">{{ $po->tender->materialRequest->project->nama_project ?? '-' }}</span>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6 flex flex-col">
                    <h4 class="font-bold text-slate-900 mb-6 flex items-center gap-2">
                        <svg class="w-5 h-5 text-blue-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                        Daftar Material
                    </h4>
                    <ul class="space-y-3 flex-grow overflow-y-auto pr-2 max-h-[300px]">
                        @foreach($po->items as $item)
                            <li class="flex items-center gap-4 p-4 border border-slate-100 rounded-xl hover:border-slate-200 transition">
                                <div class="w-10 h-10 rounded-lg bg-slate-50 flex items-center justify-center shrink-0 border border-slate-100">
                                    <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"/></svg>
                                </div>
                                <div>
                                    <p class="font-bold text-slate-900 text-sm">{{ $item->nama_barang }}</p>
                                    <p class="text-xs text-slate-500 mt-1"><span class="font-semibold text-slate-700">{{ $item->qty }} {{ $item->satuan }}</span> • {{ $item->spesifikasi ?? '-' }}</p>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
