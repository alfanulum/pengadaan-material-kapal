<x-app-layout>

    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <div class="flex items-center gap-3">
                    <h2 class="font-bold text-2xl text-slate-900 leading-tight">
                        Purchase Order <span class="text-blue-600">#{{ $purchaseOrder->kode_po }}</span>
                    </h2>
                    @php
                        $statusPO    = $purchaseOrder->status;
                        $hasShipment = $purchaseOrder->shipment !== null;
                        $hasReceipt  = $purchaseOrder->goodsReceipt !== null;
                        $isMundur    = $purchaseOrder->isVendorMundur();

                        if ($isMundur) {
                            $badgeLabel = 'Vendor Telah Mundur';
                            $badgeClass = 'bg-red-100 text-red-700 border-red-200';
                            $statusColor = 'red';
                        } elseif ($hasReceipt || in_array($statusPO, ['selesai', 'diterima_gudang'])) {
                            $badgeLabel = 'Barang Diterima Gudang';
                            $badgeClass = 'bg-emerald-100 text-emerald-700 border-emerald-200';
                            $statusColor = 'emerald';
                        } elseif ($hasShipment || $statusPO === 'dikirim') {
                            $badgeLabel = 'Barang Dikirim';
                            $badgeClass = 'bg-orange-100 text-orange-700 border-orange-200';
                            $statusColor = 'orange';
                        } else {
                            $badgeLabel = 'PO Diterbitkan';
                            $badgeClass = 'bg-blue-100 text-blue-700 border-blue-200';
                            $statusColor = 'blue';
                        }
                        $canShip     = ($statusPO === 'dikirim_ke_vendor') && !$hasShipment && !$isMundur;
                        $canWithdraw = $purchaseOrder->canVendorWithdraw();
                    @endphp
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold border {{ $badgeClass }}">
                        <span class="w-1.5 h-1.5 rounded-full bg-current"></span>
                        {{ $badgeLabel }}
                    </span>
                </div>
                <p class="text-sm text-slate-500 mt-1">
                    Diterbitkan pada {{ \Carbon\Carbon::parse($purchaseOrder->tanggal_po)->format('d F Y') }}
                </p>
            </div>

            <div class="flex flex-wrap items-center gap-3">
                <a href="{{ route('vendor.purchase-orders.pdf', $purchaseOrder->id) }}" target="_blank"
                    class="inline-flex items-center gap-2 px-4 py-2 bg-white border border-slate-200 text-slate-700 rounded-xl font-semibold text-sm hover:bg-slate-50 hover:text-blue-600 transition shadow-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" /></svg>
                    Unduh PDF
                </a>
                <a href="{{ route('vendor.purchase-orders.index') }}"
                    class="inline-flex items-center justify-center px-4 py-2 bg-slate-100 text-slate-700 rounded-xl font-semibold text-sm hover:bg-slate-200 transition">
                    Kembali
                </a>
            </div>
        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

        {{-- Flash Messages --}}
        @if(session('success'))
            <div class="mb-6 p-4 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-2xl flex items-center gap-3 shadow-sm">
                <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="mb-6 p-4 bg-red-50 border border-red-200 text-red-700 rounded-2xl flex items-center gap-3 shadow-sm">
                <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                {{ session('error') }}
            </div>
        @endif

        @if ($isMundur)
            <div class="mb-8 p-6 bg-red-50 border-l-4 border-red-500 rounded-r-2xl shadow-sm">
                <div class="flex items-start gap-4">
                    <div class="w-12 h-12 rounded-full bg-red-100 flex items-center justify-center shrink-0">
                        <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" /></svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-red-900">Anda Telah Mengundurkan Diri</h3>
                        <p class="text-red-700 mt-1 leading-relaxed">
                            Pengunduran diri Anda direkam pada <strong class="font-bold">{{ $purchaseOrder->tanggal_pengunduran_diri ? $purchaseOrder->tanggal_pengunduran_diri->format('d M Y, H:i') : '-' }}</strong>.
                            Proses pengiriman PO ini dibatalkan secara sistem dan Supply Chain telah diberitahu.
                        </p>
                    </div>
                </div>
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            {{-- KOLOM KIRI: Informasi Utama & Items --}}
            <div class="lg:col-span-2 space-y-8">

                {{-- Card Info PO --}}
                <div class="bg-white rounded-3xl shadow-sm border border-slate-200 overflow-hidden">
                    <div class="px-8 py-6 border-b border-slate-100 bg-slate-50/50">
                        <h3 class="text-lg font-bold text-slate-900 flex items-center gap-2">
                            <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            Informasi Purchase Order
                        </h3>
                    </div>
                    
                    <div class="p-8 grid grid-cols-1 md:grid-cols-2 gap-x-12 gap-y-8">
                        <div>
                            <p class="text-sm font-medium text-slate-500 mb-1">Total Nilai PO</p>
                            <p class="text-3xl font-bold text-slate-900">Rp {{ number_format($purchaseOrder->total_harga, 0, ',', '.') }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-slate-500 mb-1">Batas Waktu Pengiriman</p>
                            <div class="flex items-center gap-2">
                                <svg class="w-5 h-5 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                <p class="text-lg font-bold text-slate-900">
                                    {{ $purchaseOrder->deadline_pengiriman ? \Carbon\Carbon::parse($purchaseOrder->deadline_pengiriman)->format('d F Y') : '-' }}
                                </p>
                            </div>
                        </div>

                        <div class="col-span-1 md:col-span-2 h-px bg-slate-100"></div>

                        <div>
                            <p class="text-sm font-medium text-slate-500 mb-1">Kode Tender Terkait</p>
                            <p class="font-semibold text-slate-900">{{ $purchaseOrder->tender->kode_tender ?? '-' }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-slate-500 mb-1">Proyek / Kebutuhan</p>
                            <p class="font-semibold text-slate-900">{{ $purchaseOrder->tender->materialRequest->project->nama_project ?? '-' }}</p>
                        </div>

                        <div class="col-span-1 md:col-span-2 bg-slate-50 rounded-2xl p-5 border border-slate-100">
                            <p class="text-sm font-medium text-slate-500 mb-2">Catatan Supply Chain</p>
                            <p class="text-slate-800 leading-relaxed">
                                {{ $purchaseOrder->catatan ?: 'Tidak ada catatan.' }}
                            </p>
                        </div>
                    </div>
                </div>

                {{-- Card Items --}}
                <div class="bg-white rounded-3xl shadow-sm border border-slate-200 overflow-hidden">
                    <div class="px-8 py-6 border-b border-slate-100 bg-slate-50/50">
                        <div class="flex items-center justify-between">
                            <h3 class="text-lg font-bold text-slate-900 flex items-center gap-2">
                                <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                                Daftar Material yang Dipesan
                            </h3>
                            <span class="px-3 py-1 bg-slate-100 text-slate-600 rounded-lg text-sm font-bold">
                                {{ $purchaseOrder->items->count() }} Item
                            </span>
                        </div>
                    </div>

                    <div class="overflow-x-auto p-4">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr>
                                    <th class="px-4 py-3 text-xs font-bold text-slate-400 uppercase tracking-wider border-b border-slate-200">Material</th>
                                    <th class="px-4 py-3 text-xs font-bold text-slate-400 uppercase tracking-wider border-b border-slate-200">Spesifikasi</th>
                                    <th class="px-4 py-3 text-right text-xs font-bold text-slate-400 uppercase tracking-wider border-b border-slate-200">Kuantitas</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100">
                                @forelse ($purchaseOrder->items as $item)
                                    <tr class="hover:bg-slate-50/50 transition">
                                        <td class="px-4 py-4">
                                            <p class="font-bold text-slate-900">{{ $item->nama_barang }}</p>
                                        </td>
                                        <td class="px-4 py-4">
                                            <p class="text-sm text-slate-600 line-clamp-2" title="{{ $item->spesifikasi }}">{{ $item->spesifikasi ?? '-' }}</p>
                                        </td>
                                        <td class="px-4 py-4 text-right">
                                            <span class="inline-flex px-3 py-1 rounded-lg bg-blue-50 text-blue-700 font-bold text-sm">
                                                {{ $item->qty }} {{ $item->satuan }}
                                            </span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="px-4 py-12 text-center">
                                            <div class="flex flex-col items-center justify-center text-slate-400">
                                                <svg class="w-12 h-12 mb-3 opacity-20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/></svg>
                                                <p>Tidak ada item dalam PO ini.</p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>

            {{-- KOLOM KANAN: Tindak Lanjut & Timeline --}}
            <div class="lg:col-span-1 space-y-6">

                {{-- Box Aksi Utama --}}
                <div class="bg-white rounded-3xl shadow-sm border border-slate-200 overflow-hidden">
                    <div class="p-6">
                        <h3 class="text-base font-bold text-slate-900 mb-4">Tindak Lanjut</h3>
                        
                        @if($canShip)
                            <div class="bg-blue-50 border border-blue-100 rounded-2xl p-5 mb-5 text-center">
                                <div class="w-12 h-12 mx-auto bg-blue-100 text-blue-600 rounded-full flex items-center justify-center mb-3">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"/></svg>
                                </div>
                                <h4 class="font-bold text-blue-900 mb-1">Siap Dikirim?</h4>
                                <p class="text-xs text-blue-700 leading-relaxed mb-4">Jika semua material sudah siap, segera lakukan pengiriman ke gudang pemesan.</p>
                                
                                <form action="{{ route('vendor.purchase-orders.ship', $purchaseOrder->id) }}" method="POST" id="form-kirim-barang" onsubmit="return confirmShip(event)">
                                    @csrf
                                    <button type="submit" id="btn-kirim-barang" class="w-full px-4 py-3 bg-blue-600 text-white rounded-xl font-bold text-sm hover:bg-blue-700 active:scale-95 transition-all shadow-md shadow-blue-600/20">
                                        Kirim Barang Sekarang
                                    </button>
                                </form>
                            </div>

                        @elseif($isMundur)
                            <div class="bg-red-50 border border-red-100 rounded-2xl p-5 mb-5 text-center">
                                <div class="w-12 h-12 mx-auto bg-red-100 text-red-600 rounded-full flex items-center justify-center mb-3">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                                </div>
                                <h4 class="font-bold text-red-900 mb-1">Dibatalkan</h4>
                                <p class="text-xs text-red-700 leading-relaxed">Anda tidak dapat menindaklanjuti PO ini karena telah mengundurkan diri.</p>
                            </div>

                        @elseif(($hasShipment || $statusPO === 'dikirim') && !$hasReceipt && !in_array($statusPO, ['selesai','diterima_gudang']))
                            <div class="bg-orange-50 border border-orange-100 rounded-2xl p-5 mb-5 text-center">
                                <div class="w-12 h-12 mx-auto bg-orange-100 text-orange-600 rounded-full flex items-center justify-center mb-3">
                                    <svg class="w-6 h-6 animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8a1 1 0 011-1h2.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1m-6-1a1 1 0 001 1h1M5 17a2 2 0 104 0m-4 0a2 2 0 114 0m6 0a2 2 0 104 0m-4 0a2 2 0 114 0"/></svg>
                                </div>
                                <h4 class="font-bold text-orange-900 mb-1">Dalam Pengiriman</h4>
                                <p class="text-xs text-orange-700 leading-relaxed">Menunggu pihak gudang melakukan penerimaan dan pengecekan barang.</p>
                            </div>

                        @elseif($hasReceipt || in_array($statusPO, ['selesai','diterima_gudang']))
                            <div class="bg-emerald-50 border border-emerald-100 rounded-2xl p-5 mb-5 text-center">
                                <div class="w-12 h-12 mx-auto bg-emerald-100 text-emerald-600 rounded-full flex items-center justify-center mb-3">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                </div>
                                <h4 class="font-bold text-emerald-900 mb-1">Selesai</h4>
                                <p class="text-xs text-emerald-700 leading-relaxed">Barang telah diterima oleh gudang. Proses pengadaan ini telah ditutup.</p>
                            </div>
                        @endif

                        @if($canWithdraw)
                            <div class="mt-4 pt-4 border-t border-slate-100">
                                <button type="button" onclick="document.getElementById('modal-mundur').classList.remove('hidden')" class="w-full text-center text-xs font-bold text-red-600 hover:text-red-700 transition">
                                    Mengundurkan Diri dari PO ini
                                </button>
                            </div>
                        @endif
                    </div>
                </div>

                {{-- Status Timeline (Vertical Stepper) --}}
                <div class="bg-white rounded-3xl shadow-sm border border-slate-200 overflow-hidden p-6">
                    <h3 class="text-base font-bold text-slate-900 mb-6">Progress Status</h3>
                    
                    <div class="relative space-y-6">
                        {{-- Step 1: Diterbitkan --}}
                        <div class="flex gap-4">
                            <div class="flex flex-col items-center">
                                <div class="w-8 h-8 rounded-full bg-emerald-500 text-white flex items-center justify-center shadow shadow-emerald-500/30 z-10">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                                </div>
                                <div class="w-px h-full bg-slate-200 mt-2"></div>
                            </div>
                            <div class="pb-6">
                                <p class="font-bold text-slate-900 text-sm">PO Diterbitkan</p>
                                <p class="text-xs text-slate-500 mt-1">{{ \Carbon\Carbon::parse($purchaseOrder->tanggal_po)->format('d F Y, H:i') }}</p>
                            </div>
                        </div>

                        {{-- Step 2: Dikirim / Mundur --}}
                        <div class="flex gap-4">
                            <div class="flex flex-col items-center">
                                @if($isMundur)
                                    <div class="w-8 h-8 rounded-full bg-red-500 text-white flex items-center justify-center shadow shadow-red-500/30 z-10">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M6 18L18 6M6 6l12 12"/></svg>
                                    </div>
                                @elseif($hasShipment || in_array($statusPO, ['dikirim','selesai','diterima_gudang']))
                                    <div class="w-8 h-8 rounded-full bg-emerald-500 text-white flex items-center justify-center shadow shadow-emerald-500/30 z-10">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                                    </div>
                                    <div class="w-px h-full bg-slate-200 mt-2"></div>
                                @else
                                    <div class="w-8 h-8 rounded-full bg-slate-100 border-2 border-slate-300 flex items-center justify-center z-10"></div>
                                    <div class="w-px h-full bg-slate-200 mt-2 border-l-2 border-dashed border-slate-300"></div>
                                @endif
                            </div>
                            <div class="pb-6">
                                @if($isMundur)
                                    <p class="font-bold text-red-600 text-sm">Vendor Mundur</p>
                                    <p class="text-xs text-red-500 mt-1">{{ $purchaseOrder->tanggal_pengunduran_diri ? $purchaseOrder->tanggal_pengunduran_diri->format('d F Y, H:i') : '-' }}</p>
                                @else
                                    <p class="font-bold {{ ($hasShipment || in_array($statusPO, ['dikirim','selesai','diterima_gudang'])) ? 'text-slate-900' : 'text-slate-400' }} text-sm">Barang Dikirim</p>
                                    @if($purchaseOrder->tanggal_pengiriman && ($hasShipment || in_array($statusPO, ['dikirim','selesai','diterima_gudang'])))
                                        <p class="text-xs text-slate-500 mt-1">{{ \Carbon\Carbon::parse($purchaseOrder->tanggal_pengiriman)->format('d F Y, H:i') }}</p>
                                    @else
                                        <p class="text-xs text-slate-400 mt-1">Belum dilakukan</p>
                                    @endif
                                @endif
                            </div>
                        </div>

                        {{-- Step 3: Diterima Gudang (Sembunyikan jika mundur) --}}
                        @if(!$isMundur)
                        <div class="flex gap-4">
                            <div class="flex flex-col items-center">
                                @if($hasReceipt || in_array($statusPO, ['selesai','diterima_gudang']))
                                    <div class="w-8 h-8 rounded-full bg-emerald-500 text-white flex items-center justify-center shadow shadow-emerald-500/30 z-10">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                                    </div>
                                @else
                                    <div class="w-8 h-8 rounded-full bg-slate-100 border-2 border-slate-300 flex items-center justify-center z-10"></div>
                                @endif
                            </div>
                            <div>
                                <p class="font-bold {{ ($hasReceipt || in_array($statusPO, ['selesai','diterima_gudang'])) ? 'text-slate-900' : 'text-slate-400' }} text-sm">Diterima Gudang</p>
                                @if($purchaseOrder->goodsReceipt?->tanggal_diterima)
                                    <p class="text-xs text-slate-500 mt-1">{{ \Carbon\Carbon::parse($purchaseOrder->goodsReceipt->tanggal_diterima)->format('d F Y, H:i') }}</p>
                                @else
                                    <p class="text-xs text-slate-400 mt-1">Belum dilakukan</p>
                                @endif
                            </div>
                        </div>
                        @endif
                    </div>
                </div>

            </div>
        </div>
    </div>

    {{-- MODAL KONFIRMASI PENGUNDURAN DIRI --}}
    <div id="modal-mundur" class="hidden fixed inset-0 z-50 flex items-center justify-center p-4">
        <div class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm"
            onclick="document.getElementById('modal-mundur').classList.add('hidden')"></div>

        <div class="relative bg-white rounded-3xl shadow-2xl w-full max-w-md p-8 z-10 transform scale-100 transition-transform">
            <div class="flex items-center gap-4 mb-6">
                <div class="w-12 h-12 rounded-2xl bg-red-100 flex items-center justify-center shrink-0">
                    <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                    </svg>
                </div>
                <div>
                    <h3 class="text-xl font-bold text-slate-900">Konfirmasi Mundur</h3>
                    <p class="text-sm text-slate-500 mt-0.5">Tindakan ini permanen.</p>
                </div>
            </div>

            <div class="mb-5 p-4 bg-red-50 border border-red-200 rounded-xl">
                <p class="text-sm text-red-900 leading-relaxed">
                    Dengan mengundurkan diri, Supply Chain akan mendapat notifikasi dan PO <strong class="font-bold">{{ $purchaseOrder->kode_po }}</strong> dibatalkan untuk Anda.
                </p>
            </div>

            <form action="{{ route('vendor.purchase-orders.mundur', $purchaseOrder->id) }}" method="POST" id="form-mundur">
                @csrf
                <div class="mb-6">
                    <label for="alasan_pengunduran_diri" class="block text-sm font-semibold text-slate-700 mb-2">
                        Alasan Pengunduran Diri <span class="text-red-600">*</span>
                    </label>
                    <textarea id="alasan_pengunduran_diri" name="alasan_pengunduran_diri" rows="4" required minlength="10" maxlength="2000"
                        placeholder="Contoh: Stok material saat ini kosong..."
                        class="w-full rounded-xl border-slate-300 focus:border-red-500 focus:ring-red-500 text-sm resize-none"></textarea>
                    <p class="text-xs text-slate-400 mt-2">Minimal 10 karakter.</p>
                </div>

                <div class="flex gap-3">
                    <button type="button" onclick="document.getElementById('modal-mundur').classList.add('hidden')"
                        class="flex-1 px-4 py-3 bg-slate-100 text-slate-700 rounded-xl font-bold text-sm hover:bg-slate-200 transition">
                        Batal
                    </button>
                    <button type="submit" id="btn-konfirmasi-mundur" onclick="return konfirmasiMundur()"
                        class="flex-1 px-4 py-3 bg-red-600 text-white rounded-xl font-bold text-sm hover:bg-red-700 shadow-md shadow-red-600/20 transition">
                        Konfirmasi Mundur
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function confirmShip(e) {
            e.preventDefault();
            if (!confirm('Anda yakin material sudah siap dan akan dikirim ke gudang?\n\nNotifikasi akan dikirimkan ke pihak Gudang.')) {
                return false;
            }
            const btn = document.getElementById('btn-kirim-barang');
            btn.disabled = true;
            btn.innerHTML = `
                <svg class="w-4 h-4 animate-spin inline-block mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                Memproses...
            `;
            document.getElementById('form-kirim-barang').submit();
        }

        function konfirmasiMundur() {
            const alasan = document.getElementById('alasan_pengunduran_diri').value.trim();
            if (alasan.length < 10) {
                alert('Alasan pengunduran diri minimal 10 karakter.');
                return false;
            }
            const btn = document.getElementById('btn-konfirmasi-mundur');
            btn.disabled = true;
            btn.innerHTML = `
                <svg class="w-4 h-4 animate-spin inline-block mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                Memproses...
            `;
            document.getElementById('form-mundur').submit();
            return false;
        }
    </script>
</x-app-layout>
