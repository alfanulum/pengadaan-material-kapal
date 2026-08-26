<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <div class="flex items-center gap-2 text-sm text-slate-500 mb-1">
                    <a href="{{ route('supply-chain.goods-receipt-reports.index') }}" class="hover:text-blue-600 transition font-medium">Laporan Penerimaan</a>
                    <span>/</span>
                    <span class="text-slate-900 font-semibold">Detail PO #{{ $goodsReceiptReport->purchaseOrder->kode_po }}</span>
                </div>
                <h2 class="font-bold text-2xl text-slate-900 leading-tight">
                    Laporan Pemeriksaan Gudang
                </h2>
                <p class="text-sm text-slate-500 mt-1">
                    Dilaporkan pada {{ $goodsReceiptReport->created_at->format('d F Y, H:i') }}
                </p>
            </div>
            
            <div class="flex flex-wrap items-center gap-3">
                <a href="{{ route('supply-chain.goods-receipt-reports.pdf', $goodsReceiptReport->id) }}"
                    class="inline-flex items-center gap-2 px-4 py-2 bg-white border border-slate-200 text-slate-700 rounded-xl font-semibold text-sm hover:bg-slate-50 hover:text-red-600 transition shadow-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    Unduh PDF
                </a>
                <a href="{{ route('supply-chain.goods-receipt-reports.index') }}"
                    class="inline-flex items-center justify-center px-4 py-2 bg-slate-100 text-slate-700 rounded-xl font-semibold text-sm hover:bg-slate-200 transition">
                    Kembali
                </a>
            </div>
        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

        {{-- Flash Messages --}}
        @if (session('success'))
            <div class="mb-6 p-4 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-2xl flex items-center gap-3 shadow-sm">
                <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                {{ session('success') }}
            </div>
        @endif

        @php
            $r = $goodsReceiptReport;
            $isGood = $r->status_penerimaan === 'diterima_sesuai';
            $isCaution = $r->status_penerimaan === 'diterima_dengan_catatan';
            $isProblem = in_array($r->status_penerimaan, ['menunggu_tindak_lanjut', 'retur_barang', 'penggantian_vendor']);
            $isUrgent = in_array($r->kondisi_barang, ['kerusakan', 'tidak_sesuai_spesifikasi']);
        @endphp

        @if ($isUrgent)
            <div class="mb-8 p-6 bg-red-50 border-l-4 border-red-500 rounded-r-2xl shadow-sm">
                <div class="flex items-start gap-4">
                    <div class="w-12 h-12 rounded-full bg-red-100 flex items-center justify-center shrink-0">
                        <svg class="w-6 h-6 text-red-600 animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-red-900">Perhatian — Barang Bermasalah!</h3>
                        <p class="text-red-700 mt-1 leading-relaxed">
                            Gudang melaporkan kondisi material <strong>{{ $r->kondisi_label }}</strong>. 
                            Mohon segera tindak lanjuti laporan ini dengan menghubungi Vendor atau memproses retur barang jika diperlukan.
                        </p>
                    </div>
                </div>
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            {{-- KOLOM KIRI: Informasi PO, Item & Foto --}}
            <div class="lg:col-span-2 space-y-8">

                {{-- Informasi PO --}}
                <div class="bg-white rounded-3xl shadow-sm border border-slate-200 overflow-hidden">
                    <div class="px-8 py-6 border-b border-slate-100 bg-slate-50/50">
                        <h3 class="text-lg font-bold text-slate-900 flex items-center gap-2">
                            <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            Informasi Purchase Order
                        </h3>
                    </div>
                    
                    <div class="p-8 grid grid-cols-1 md:grid-cols-2 gap-x-12 gap-y-8">
                        <div>
                            <p class="text-sm font-medium text-slate-500 mb-1">Nomor PO</p>
                            <p class="text-xl font-bold text-slate-900">{{ $r->purchaseOrder->kode_po }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-slate-500 mb-1">Total Nilai PO</p>
                            <p class="text-xl font-bold text-slate-900">Rp {{ number_format($r->purchaseOrder->total_harga, 0, ',', '.') }}</p>
                        </div>

                        <div class="col-span-1 md:col-span-2 h-px bg-slate-100"></div>

                        <div>
                            <p class="text-sm font-medium text-slate-500 mb-1">Vendor Terkait</p>
                            <p class="font-semibold text-slate-900">{{ $r->purchaseOrder->vendor->nama_vendor ?? '-' }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-slate-500 mb-1">Deadline Pengiriman Gudang</p>
                            <p class="font-semibold text-slate-900">{{ $r->purchaseOrder->deadline_pengiriman ? \Carbon\Carbon::parse($r->purchaseOrder->deadline_pengiriman)->format('d F Y') : '-' }}</p>
                        </div>

                        <div>
                            <p class="text-sm font-medium text-slate-500 mb-1">Kode Tender</p>
                            <p class="font-semibold text-slate-700">{{ $r->purchaseOrder->tender->kode_tender ?? '-' }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-slate-500 mb-1">Nama Tender</p>
                            <p class="font-semibold text-slate-700">{{ $r->purchaseOrder->tender->nama_tender ?? '-' }}</p>
                        </div>
                    </div>
                </div>

                {{-- Detail Material --}}
                <div class="bg-white rounded-3xl shadow-sm border border-slate-200 overflow-hidden">
                    <div class="px-8 py-6 border-b border-slate-100 bg-slate-50/50">
                        <div class="flex items-center justify-between">
                            <h3 class="text-lg font-bold text-slate-900 flex items-center gap-2">
                                <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                                Detail Material Dipesan
                            </h3>
                            <span class="px-3 py-1 bg-white border border-slate-200 text-slate-600 rounded-lg text-sm font-bold shadow-sm">
                                {{ $r->purchaseOrder->items->count() }} Item
                            </span>
                        </div>
                    </div>

                    <div class="overflow-x-auto p-4">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr>
                                    <th class="px-4 py-3 text-xs font-bold text-slate-400 uppercase tracking-wider border-b border-slate-200">Nama Barang</th>
                                    <th class="px-4 py-3 text-xs font-bold text-slate-400 uppercase tracking-wider border-b border-slate-200">Spesifikasi</th>
                                    <th class="px-4 py-3 text-right text-xs font-bold text-slate-400 uppercase tracking-wider border-b border-slate-200">Qty Pesanan</th>
                                    <th class="px-4 py-3 text-right text-xs font-bold text-slate-400 uppercase tracking-wider border-b border-slate-200">Harga Satuan</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100">
                                @foreach ($r->purchaseOrder->items as $item)
                                <tr>
                                    <td class="px-4 py-4">
                                        <p class="font-bold text-slate-900">{{ $item->nama_barang }}</p>
                                    </td>
                                    <td class="px-4 py-4">
                                        <p class="text-sm text-slate-600 line-clamp-2" title="{{ $item->spesifikasi }}">{{ $item->spesifikasi ?? '-' }}</p>
                                    </td>
                                    <td class="px-4 py-4 text-right">
                                        <span class="inline-flex px-3 py-1 rounded-lg bg-blue-50 text-blue-700 font-bold text-sm border border-blue-100">
                                            {{ $item->qty }} {{ $item->satuan }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-4 text-right text-sm font-medium text-slate-700">
                                        Rp {{ number_format($item->harga_satuan, 0, ',', '.') }}
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                {{-- Foto Bukti --}}
                <div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden">
                    <div class="px-8 py-6 border-b border-slate-100 bg-slate-50/50">
                        <h3 class="text-lg font-bold text-slate-900 flex items-center gap-2">
                            <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            Foto Bukti Penerimaan & Pengecekan
                        </h3>
                    </div>
                    <div class="p-8">
                        @if ($r->photos->count() > 0)
                            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-6">
                                @foreach ($r->photos as $photo)
                                <div class="group relative">
                                    <div class="aspect-square rounded-2xl overflow-hidden bg-slate-100 border border-slate-200 cursor-pointer shadow-sm group-hover:shadow-md transition-all"
                                        onclick="openLightbox('{{ Storage::url($photo->file_path) }}', '{{ $photo->keterangan ?? '' }}')">
                                        <img src="{{ Storage::url($photo->file_path) }}"
                                            alt="Dokumentasi Gudang"
                                            class="w-full h-full object-cover group-hover:scale-110 transition duration-500">
                                        <div class="absolute inset-0 bg-black/0 group-hover:bg-black/10 transition-colors"></div>
                                    </div>
                                    @if ($photo->keterangan)
                                        <p class="text-xs text-slate-600 mt-2 text-center font-medium px-2 truncate" title="{{ $photo->keterangan }}">{{ $photo->keterangan }}</p>
                                    @endif
                                </div>
                                @endforeach
                            </div>
                        @else
                            <div class="py-12 text-center">
                                <div class="w-16 h-16 mx-auto bg-slate-100 rounded-full flex items-center justify-center mb-4">
                                    <svg class="w-8 h-8 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                </div>
                                <p class="text-slate-500 font-medium">Gudang tidak melampirkan foto dokumentasi.</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            {{-- KOLOM KANAN: Hasil Gudang & Tindakan --}}
            <div class="lg:col-span-1 space-y-6">

                {{-- Status Card --}}
                <div class="bg-white rounded-3xl shadow-sm border border-slate-200 overflow-hidden">
                    <div class="p-6">
                        <p class="text-sm font-bold text-slate-500 uppercase tracking-wider mb-4">Hasil Pemeriksaan Gudang</p>
                        
                        <div class="p-5 rounded-2xl border {{ $isGood ? 'bg-emerald-50 border-emerald-200' : ($isCaution ? 'bg-amber-50 border-amber-200' : 'bg-red-50 border-red-200') }} mb-6">
                            <p class="text-xs font-semibold {{ $isGood ? 'text-emerald-700' : ($isCaution ? 'text-amber-700' : 'text-red-700') }} uppercase tracking-wider mb-1">Status</p>
                            <h4 class="text-xl font-bold {{ $isGood ? 'text-emerald-900' : ($isCaution ? 'text-amber-900' : 'text-red-900') }}">{{ $r->status_label }}</h4>
                            <p class="text-sm font-medium mt-1 {{ $isGood ? 'text-emerald-700' : ($isCaution ? 'text-amber-700' : 'text-red-700') }}">
                                Kondisi: {{ $r->kondisi_label }}
                            </p>
                        </div>

                        <div class="space-y-4">
                            <div>
                                <p class="text-xs font-medium text-slate-500 mb-1">Jumlah Diterima</p>
                                <p class="text-base font-bold text-slate-900">{{ $r->jumlah_diterima }} item(s)</p>
                            </div>
                            @if($r->jumlah_rusak > 0)
                            <div>
                                <p class="text-xs font-medium text-slate-500 mb-1">Jumlah Rusak / Ditolak</p>
                                <p class="text-base font-bold text-red-600">{{ $r->jumlah_rusak }} item(s)</p>
                            </div>
                            @endif
                            <div class="pt-4 border-t border-slate-100">
                                <p class="text-xs font-medium text-slate-500 mb-1">Diperiksa Oleh</p>
                                <div class="flex items-center gap-2 mt-1">
                                    <div class="w-6 h-6 rounded-full bg-blue-100 flex items-center justify-center">
                                        <svg class="w-3 h-3 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                                    </div>
                                    <p class="text-sm font-bold text-slate-900">{{ $r->creator->name ?? 'Staf Gudang' }}</p>
                                </div>
                                <p class="text-xs text-slate-500 mt-1 ml-8">{{ $r->tanggal_diterima?->format('d F Y') }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Catatan Gudang --}}
                <div class="bg-white rounded-3xl shadow-sm border border-slate-200 p-6 space-y-4">
                    <h3 class="text-sm font-bold text-slate-900 uppercase tracking-wider mb-2">Catatan dari Gudang</h3>

                    @if ($r->catatan_gudang)
                        <div class="p-4 bg-slate-50 rounded-2xl border border-slate-100">
                            <p class="text-xs font-bold text-slate-500 mb-1">Keterangan Tambahan</p>
                            <p class="text-sm text-slate-800 leading-relaxed">{{ $r->catatan_gudang }}</p>
                        </div>
                    @endif

                    @if ($r->detail_permasalahan)
                        <div class="p-4 bg-red-50 border border-red-200 rounded-2xl">
                            <p class="text-xs font-bold text-red-700 mb-1">Detail Permasalahan</p>
                            <p class="text-sm text-red-900 leading-relaxed">{{ $r->detail_permasalahan }}</p>
                        </div>
                    @endif

                    @if (!$r->catatan_gudang && !$r->detail_permasalahan)
                        <div class="py-6 text-center text-slate-400">
                            <svg class="w-8 h-8 mx-auto mb-2 opacity-30" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                            <p class="text-sm">Tidak ada catatan.</p>
                        </div>
                    @endif
                </div>

                {{-- Tindak Lanjut Supply Chain --}}
                <div class="bg-white rounded-3xl shadow-sm border border-slate-200 p-6">
                    <h3 class="text-base font-bold text-slate-900 mb-1">Aksi & Tindak Lanjut</h3>
                    <p class="text-xs text-slate-500 mb-5 leading-relaxed">Keputusan akhir dan resolusi laporan oleh tim Supply Chain.</p>

                    <div class="space-y-3">
                        @if ($r->status_penerimaan !== 'diterima_sesuai')
                            <form action="{{ route('supply-chain.goods-receipt-reports.confirm', $r->id) }}" method="POST" onsubmit="return confirm('Apakah semua permasalahan pada penerimaan ini telah diselesaikan?')">
                                @csrf
                                <button type="submit" class="w-full flex items-center justify-center gap-2 px-4 py-3 bg-emerald-600 text-white rounded-xl font-bold text-sm hover:bg-emerald-700 shadow-md shadow-emerald-600/20 transition">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                    Konfirmasi Resolusi Selesai
                                </button>
                            </form>
                        @endif

                        @if ($r->purchaseOrder->vendor?->email)
                            <a href="mailto:{{ $r->purchaseOrder->vendor->email }}?subject=Info Pengiriman PO {{ $r->purchaseOrder->kode_po }}&body=Yth. {{ $r->purchaseOrder->vendor->nama_vendor }},%0A%0ATerkait pengiriman PO {{ $r->purchaseOrder->kode_po }}...%0A%0A"
                                class="w-full flex items-center justify-center gap-2 px-4 py-3 bg-blue-50 text-blue-700 border border-blue-200 rounded-xl font-bold text-sm hover:bg-blue-100 transition">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                                Email Vendor
                            </a>
                        @endif

                        @if (in_array($r->kondisi_barang, ['kerusakan', 'tidak_sesuai_spesifikasi']) && $r->status_penerimaan !== 'retur_barang')
                            <form action="{{ route('supply-chain.goods-receipt-reports.return', $r->id) }}" method="POST" onsubmit="return confirm('Kirim notifikasi retur barang ke gudang dan vendor?')">
                                @csrf
                                <button type="submit" class="w-full flex items-center justify-center gap-2 px-4 py-3 bg-orange-50 text-orange-700 border border-orange-200 rounded-xl font-bold text-sm hover:bg-orange-100 transition">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 15v-1a4 4 0 00-4-4H8m0 0l3 3m-3-3l3-3m9 14V5a2 2 0 00-2-2H6a2 2 0 00-2 2v16l4-2 4 2 4-2 4 2z"/></svg>
                                    Proses Retur Barang
                                </button>
                            </form>
                        @endif

                        @if ($r->status_penerimaan === 'retur_barang')
                            <div class="w-full text-center px-4 py-3 bg-orange-100 text-orange-800 rounded-xl font-bold text-sm border border-orange-200">
                                Proses Retur Sedang Berjalan
                            </div>
                        @endif

                        @if ($r->status_penerimaan === 'diterima_sesuai')
                            <div class="w-full text-center px-4 py-3 bg-emerald-100 text-emerald-800 rounded-xl font-bold text-sm border border-emerald-200 flex items-center justify-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                Penerimaan Telah Dikonfirmasi
                            </div>
                        @endif
                    </div>
                </div>

            </div>
        </div>
    </div>

    {{-- Lightbox Modal --}}
    <div id="lightbox" onclick="closeLightbox()" class="fixed inset-0 z-50 hidden bg-slate-900/90 backdrop-blur-sm items-center justify-center p-4">
        <div class="max-w-5xl w-full relative" onclick="event.stopPropagation()">
            <img id="lightbox-img" src="" alt="" class="w-full max-h-[85vh] object-contain rounded-2xl shadow-2xl">
            <p id="lightbox-caption" class="text-white text-center mt-4 text-sm font-medium"></p>
            <button onclick="closeLightbox()" class="absolute -top-4 -right-4 w-10 h-10 bg-white/10 hover:bg-white/20 text-white border border-white/20 rounded-full flex items-center justify-center transition">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>
    </div>

    <script>
        function openLightbox(src, caption) {
            document.getElementById('lightbox-img').src = src;
            document.getElementById('lightbox-caption').textContent = caption;
            const lb = document.getElementById('lightbox');
            lb.classList.remove('hidden');
            lb.classList.add('flex');
            document.body.style.overflow = 'hidden';
        }
        function closeLightbox() {
            const lb = document.getElementById('lightbox');
            lb.classList.add('hidden');
            lb.classList.remove('flex');
            document.body.style.overflow = '';
        }
        document.addEventListener('keydown', e => { if (e.key === 'Escape') closeLightbox(); });
    </script>
</x-app-layout>
