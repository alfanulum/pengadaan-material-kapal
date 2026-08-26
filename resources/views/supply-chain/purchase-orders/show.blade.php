<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <h2 class="font-bold text-2xl text-slate-900 leading-tight mb-1">
                    Detail Purchase Order
                </h2>
                <p class="text-sm text-slate-500">
                    PO: <span class="font-semibold text-slate-700">{{ $purchaseOrder->kode_po }}</span>
                </p>
            </div>

            <div class="flex flex-row items-center flex-wrap md:flex-nowrap gap-3">
                <div class="bg-white border border-slate-200 shadow-sm rounded-xl py-2 px-4 flex flex-col text-right justify-center h-[52px]">
                    <span class="text-[10px] font-bold text-slate-500 uppercase tracking-wider mb-0.5">Total PO</span>
                    <span class="text-lg font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-slate-900 to-blue-900 leading-none">
                        Rp {{ number_format($purchaseOrder->total_harga, 0, ',', '.') }}
                    </span>
                </div>

                <a href="{{ route('supply-chain.purchase-orders.index') }}" class="inline-flex items-center justify-center gap-2 px-4 py-2 bg-white border border-slate-300 text-slate-700 rounded-xl text-sm font-semibold hover:bg-slate-50 transition shadow-sm h-[52px]">
                    <svg class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" />
                    </svg>
                    Kembali
                </a>

                <a href="{{ route('supply-chain.purchase-orders.pdf', $purchaseOrder->id) }}"
                    target="_blank"
                    class="inline-flex items-center justify-center gap-2 px-5 py-2 bg-gradient-to-r from-emerald-600 to-green-600 text-white rounded-xl text-sm font-bold shadow-sm transition hover:from-emerald-700 hover:to-green-700 h-[52px]">
                    <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                            d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3" />
                    </svg>
                    Unduh Dokumen PO
                </a>
            </div>
        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-12">

        @if (session('success'))
            <div class="mb-6 p-4 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-xl font-medium text-sm">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="mb-6 p-4 bg-rose-50 border border-rose-200 text-rose-700 rounded-xl font-medium text-sm">
                {{ session('error') }}
            </div>
        @endif

        @if (session('info'))
            <div class="mb-6 p-4 bg-blue-50 border border-blue-200 text-blue-700 rounded-xl font-medium text-sm">
                {{ session('info') }}
            </div>
        @endif

        {{-- BANNER VENDOR MUNDUR --}}
        @if ($purchaseOrder->isVendorMundur())
            <div class="mb-8 rounded-xl border border-rose-200 bg-white shadow-sm overflow-hidden relative">
                <div class="absolute left-0 top-0 bottom-0 w-1.5 bg-rose-500"></div>
                <div class="p-6 flex flex-col md:flex-row gap-5">
                    <div class="w-12 h-12 rounded-full bg-rose-100 flex items-center justify-center shrink-0">
                        <svg class="w-6 h-6 text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                    </div>
                    <div class="flex-1">
                        <h3 class="text-lg font-bold text-slate-900">Vendor Mengundurkan Diri</h3>
                        <p class="text-sm text-slate-600 mt-1 mb-4 leading-relaxed max-w-3xl">
                            <span class="font-bold">{{ $purchaseOrder->vendor->nama_vendor ?? '-' }}</span>
                            telah mengundurkan diri dari Purchase Order ini pada
                            {{ $purchaseOrder->tanggal_pengunduran_diri ? $purchaseOrder->tanggal_pengunduran_diri->format('d M Y, H:i') : '-' }}.
                        </p>
                        <div class="p-4 bg-rose-50 rounded-lg border border-rose-100 mb-4 max-w-3xl">
                            <p class="text-[11px] font-bold text-rose-600 uppercase tracking-wider mb-1.5">Alasan Pengunduran Diri</p>
                            <p class="text-sm text-rose-900 font-medium">{{ $purchaseOrder->alasan_pengunduran_diri ?? '-' }}</p>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <div class="lg:col-span-2 space-y-8">
                {{-- Card Info PO --}}
                <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
                    <div class="px-6 py-4 border-b border-slate-200 bg-slate-50 flex items-center justify-between">
                        <h3 class="text-sm font-bold text-slate-900 uppercase tracking-wide">
                            Informasi Purchase Order
                        </h3>
                        @if ($purchaseOrder->status == 'vendor_mundur')
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-rose-100 text-rose-700">
                                <span class="w-1.5 h-1.5 rounded-full bg-rose-500"></span>
                                Vendor Mundur
                            </span>
                        @else
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-indigo-50 text-indigo-700 border border-indigo-100">
                                <span class="w-1.5 h-1.5 rounded-full bg-indigo-500"></span>
                                {{ ucwords(str_replace('_', ' ', $purchaseOrder->status)) }}
                            </span>
                        @endif
                    </div>
                    
                    <div class="p-6">
                        <dl class="grid grid-cols-1 sm:grid-cols-2 gap-x-6 gap-y-6">
                            <div>
                                <dt class="text-xs font-medium text-slate-500 mb-1">Kode PO</dt>
                                <dd class="text-sm font-bold text-slate-900">{{ $purchaseOrder->kode_po }}</dd>
                            </div>
                            <div>
                                <dt class="text-xs font-medium text-slate-500 mb-1">Kode Tender</dt>
                                <dd class="text-sm font-bold text-slate-900">{{ $purchaseOrder->tender->kode_tender ?? '-' }}</dd>
                            </div>
                            <div class="sm:col-span-2 pt-4 border-t border-slate-100">
                                <dt class="text-xs font-medium text-slate-500 mb-1">Project Terkait</dt>
                                <dd class="text-sm font-semibold text-slate-900">
                                    {{ $purchaseOrder->tender->materialRequest->project->nama_project ?? '-' }}
                                </dd>
                            </div>
                            <div class="pt-4 border-t border-slate-100">
                                <dt class="text-xs font-medium text-slate-500 mb-1">Tanggal PO</dt>
                                <dd class="text-sm font-semibold text-slate-900">
                                    {{ \Carbon\Carbon::parse($purchaseOrder->tanggal_po)->format('d M Y') }}
                                </dd>
                            </div>
                            <div class="pt-4 border-t border-slate-100">
                                <dt class="text-xs font-medium text-slate-500 mb-1">Batas Waktu Pengiriman (Deadline)</dt>
                                <dd class="text-sm font-semibold text-rose-600">
                                    {{ $purchaseOrder->deadline_pengiriman ? \Carbon\Carbon::parse($purchaseOrder->deadline_pengiriman)->format('d M Y') : '-' }}
                                </dd>
                            </div>
                            @if($purchaseOrder->catatan)
                            <div class="sm:col-span-2 pt-4 border-t border-slate-100">
                                <dt class="text-xs font-medium text-slate-500 mb-1.5">Catatan Khusus</dt>
                                <dd class="text-sm font-medium text-slate-700 bg-slate-50 p-4 rounded-lg border border-slate-100">
                                    {{ $purchaseOrder->catatan }}
                                </dd>
                            </div>
                            @endif
                        </dl>
                    </div>
                </div>

                {{-- Tabel Item PO --}}
                <div>
                    <h3 class="text-base font-bold text-slate-900 mb-4">
                        Daftar Material
                    </h3>
                    
                    <div class="border border-slate-200 rounded-xl overflow-hidden shadow-sm">
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-slate-200">
                                <thead class="bg-slate-50">
                                    <tr>
                                        <th scope="col" class="px-5 py-3.5 text-left text-xs font-semibold text-slate-600 uppercase tracking-wider">Item Barang</th>
                                        <th scope="col" class="px-5 py-3.5 text-left text-xs font-semibold text-slate-600 uppercase tracking-wider">Spesifikasi</th>
                                        <th scope="col" class="px-5 py-3.5 text-center text-xs font-semibold text-slate-600 uppercase tracking-wider">Qty</th>
                                        <th scope="col" class="px-5 py-3.5 text-right text-xs font-semibold text-slate-600 uppercase tracking-wider">Harga Satuan</th>
                                        <th scope="col" class="px-5 py-3.5 text-right text-xs font-semibold text-slate-600 uppercase tracking-wider">Subtotal</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-slate-200">
                                    @forelse ($purchaseOrder->items as $item)
                                        <tr class="hover:bg-slate-50 transition-colors">
                                            <td class="px-5 py-4 text-sm font-bold text-slate-900">
                                                {{ $item->nama_barang }}
                                            </td>
                                            <td class="px-5 py-4 text-sm text-slate-600">
                                                {{ $item->spesifikasi ?? '-' }}
                                            </td>
                                            <td class="px-5 py-4 text-sm font-semibold text-slate-700 text-center whitespace-nowrap">
                                                {{ $item->qty }} <span class="text-slate-500 font-normal ml-0.5">{{ $item->satuan }}</span>
                                            </td>
                                            <td class="px-5 py-4 text-sm font-medium text-slate-700 text-right whitespace-nowrap">
                                                Rp {{ number_format($item->harga_satuan, 0, ',', '.') }}
                                            </td>
                                            <td class="px-5 py-4 text-sm font-bold text-slate-900 text-right whitespace-nowrap">
                                                Rp {{ number_format($item->subtotal ?? ($item->harga_satuan * $item->qty), 0, ',', '.') }}
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="px-5 py-12 text-center">
                                                <div class="inline-flex items-center justify-center w-12 h-12 rounded-full bg-slate-100 text-slate-400 mb-3">
                                                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" /></svg>
                                                </div>
                                                <p class="text-sm font-medium text-slate-500">Belum ada item PO yang terdaftar.</p>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                                <tfoot class="bg-slate-50 border-t border-slate-200">
                                    <tr>
                                        <td colspan="4" class="px-5 py-4 text-sm font-bold text-slate-700 text-right uppercase tracking-wider">
                                            Total Keseluruhan
                                        </td>
                                        <td class="px-5 py-4 text-base font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-slate-900 to-blue-900 text-right whitespace-nowrap">
                                            Rp {{ number_format($purchaseOrder->total_harga, 0, ',', '.') }}
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Bagian Kanan --}}
            <div class="lg:col-span-1 space-y-6">
                {{-- Card Vendor --}}
                <div class="bg-white rounded-xl shadow-sm border border-emerald-200 overflow-hidden relative">
                    <div class="absolute top-0 left-0 right-0 h-1 bg-emerald-500"></div>
                    <div class="px-6 py-4 border-b border-slate-100 bg-emerald-50/50 flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-full bg-emerald-100 flex items-center justify-center shrink-0">
                                <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                            </div>
                            <h3 class="text-sm font-bold text-emerald-900 uppercase tracking-wide">
                                Vendor Penerima
                            </h3>
                        </div>
                    </div>
                    <div class="px-6 py-5">
                        <dl class="space-y-4">
                            <div>
                                <dt class="text-[10px] font-bold text-slate-500 uppercase tracking-wider">Nama Perusahaan</dt>
                                <dd class="mt-1 text-base font-bold text-slate-900">{{ $purchaseOrder->vendor->nama_vendor ?? '-' }}</dd>
                            </div>
                            <div class="pt-4 border-t border-slate-100">
                                <dt class="text-[10px] font-bold text-slate-500 uppercase tracking-wider">Email Resmi</dt>
                                <dd class="mt-1 text-sm font-medium text-slate-700">{{ $purchaseOrder->vendor->email ?? '-' }}</dd>
                            </div>
                            <div class="pt-4 border-t border-slate-100">
                                <dt class="text-[10px] font-bold text-slate-500 uppercase tracking-wider">PIC / Penanggung Jawab</dt>
                                <dd class="mt-1 text-sm font-medium text-slate-700">{{ $purchaseOrder->vendor->pic ?? '-' }}</dd>
                            </div>
                        </dl>
                    </div>
                </div>

                {{-- Action Menu --}}
                <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
                    <div class="px-6 py-4 border-b border-slate-200 bg-slate-50">
                        <h3 class="text-sm font-bold text-slate-900 uppercase tracking-wide">
                            Tindakan
                        </h3>
                    </div>
                    <div class="p-4 space-y-3">
                        <a href="{{ route('supply-chain.tenders.show', $purchaseOrder->tender_id) }}"
                            class="w-full inline-flex items-center justify-center gap-2 px-4 py-2.5 bg-slate-50 border border-slate-200 text-slate-700 rounded-lg text-sm font-bold hover:bg-slate-100 transition shadow-sm">
                            <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                            </svg>
                            Lihat Detail Tender
                        </a>

                        {{-- TOMBOL BUAT TENDER ULANG --}}
                        @if ($purchaseOrder->isVendorMundur())
                            @php
                                $tenderPengganti = $purchaseOrder->tender->tenderPengganti ?? null;
                            @endphp

                            @if ($tenderPengganti)
                                <a href="{{ route('supply-chain.tenders.show', $tenderPengganti->id) }}"
                                    class="w-full inline-flex items-center justify-center gap-2 px-4 py-2.5 bg-emerald-600 text-white rounded-lg text-sm font-bold shadow-sm hover:bg-emerald-700 transition">
                                    Lihat Tender Baru
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                                </a>
                            @else
                                <button type="button" id="btn-tender-ulang"
                                    onclick="document.getElementById('modal-tender-ulang').classList.remove('hidden')"
                                    class="w-full inline-flex items-center justify-center gap-2 px-4 py-2.5 bg-rose-600 text-white rounded-lg text-sm font-bold hover:bg-rose-700 transition shadow-sm">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                    </svg>
                                    Buat Tender Ulang
                                </button>
                            @endif
                        @endif
                    </div>
                </div>

                {{-- Informasi Tender Induk (jika ini tender ulang) --}}
                @if ($purchaseOrder->tender && $purchaseOrder->tender->tenderInduk)
                    <div class="bg-amber-50 rounded-xl shadow-sm border border-amber-200 overflow-hidden relative">
                        <div class="absolute left-0 top-0 bottom-0 w-1 bg-amber-400"></div>
                        <div class="p-5">
                            <h3 class="text-[11px] font-bold text-amber-800 uppercase tracking-wider mb-2">Info Tender Ulang</h3>
                            <p class="text-xs text-amber-900 leading-relaxed">
                                PO ini berasal dari tender ulang. Tender sebelumnya: <br>
                                <strong class="font-bold text-amber-950">{{ $purchaseOrder->tender->tenderInduk->kode_tender }}</strong>
                            </p>
                            <a href="{{ route('supply-chain.tenders.show', $purchaseOrder->tender->tenderInduk->id) }}"
                                class="inline-flex items-center mt-3 text-xs font-bold text-amber-700 hover:text-amber-900 group">
                                Buka Tender Sebelumnya 
                                <svg class="w-3.5 h-3.5 ml-1 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                            </a>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    {{-- MODAL KONFIRMASI BUAT TENDER ULANG --}}
    @if ($purchaseOrder->isVendorMundur())
    <div id="modal-tender-ulang" class="hidden fixed inset-0 z-50 flex items-center justify-center p-4">
        <div class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm transition-opacity"
            onclick="document.getElementById('modal-tender-ulang').classList.add('hidden')"></div>

        <div class="relative bg-white rounded-2xl shadow-2xl w-full max-w-md overflow-hidden z-10">
            <div class="absolute top-0 left-0 right-0 h-1.5 bg-rose-600"></div>
            <div class="p-6 md:p-8">
                <div class="flex items-center gap-4 mb-5">
                    <div class="w-12 h-12 rounded-full bg-rose-100 flex items-center justify-center shrink-0">
                        <svg class="w-6 h-6 text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-xl font-bold text-slate-900">Buat Tender Ulang</h3>
                        <p class="text-sm text-slate-500 mt-0.5">Tindakan tidak dapat dibatalkan</p>
                    </div>
                </div>

                <div class="mb-5 p-4 bg-amber-50 border border-amber-200 rounded-xl">
                    <p class="text-sm text-amber-900 leading-relaxed">
                        Vendor terpilih sebelumnya (<strong class="font-bold">{{ $purchaseOrder->vendor->nama_vendor ?? '-' }}</strong>) telah mengundurkan diri.
                        Sistem akan membuka form pembuatan Tender baru untuk material yang sama.
                    </p>
                </div>

                <p class="text-xs text-slate-500 mb-6 flex gap-2">
                    <svg class="w-4 h-4 text-slate-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <span>Tender dan PO lama tetap tersimpan di histori.</span>
                </p>

                <div class="flex gap-3">
                    <button type="button"
                        onclick="document.getElementById('modal-tender-ulang').classList.add('hidden')"
                        class="flex-1 px-4 py-2.5 bg-white border border-slate-300 text-slate-700 rounded-lg text-sm font-bold hover:bg-slate-50 transition shadow-sm">
                        Batal
                    </button>

                    <form action="{{ route('supply-chain.purchase-orders.buat-tender-ulang', $purchaseOrder->id) }}"
                        method="POST" class="flex-1">
                        @csrf
                        <button type="submit"
                            class="w-full px-4 py-2.5 bg-rose-600 text-white rounded-lg text-sm font-bold hover:bg-rose-700 transition shadow-sm">
                            Buat Tender
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @endif
</x-app-layout>
