<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3">
            <div>
                <div class="flex items-center gap-2 text-sm text-slate-500 mb-1">
                    <a href="{{ route('gudang.dashboard') }}" class="hover:text-blue-700 transition">Dashboard</a>
                    <span>/</span>
                    <span class="text-slate-900 font-semibold">Laporan Penerimaan</span>
                </div>
                <h2 class="font-bold text-2xl text-slate-900 leading-tight">
                    Laporan Penerimaan Barang
                </h2>
                <p class="text-sm text-slate-500 mt-1">
                    PO <span class="font-bold text-blue-700">{{ $receipt->purchaseOrder->kode_po }}</span> —
                    Dibuat {{ $receipt->created_at->format('d M Y H:i') }}
                </p>
            </div>
            <div class="flex gap-3">
                <a href="{{ route('gudang.goods-receipts.show', $receipt->purchaseOrder->id) }}"
                    class="inline-flex items-center gap-2 px-5 py-2.5 bg-white border border-slate-200 text-slate-700 rounded-xl font-semibold hover:bg-slate-50 transition text-sm shadow-sm">
                    ✏️ Edit Laporan
                </a>
                <a href="{{ route('gudang.dashboard') }}"
                    class="inline-flex items-center gap-2 px-5 py-2.5 bg-slate-100 text-slate-700 rounded-xl font-semibold border border-slate-200 hover:bg-slate-200 transition text-sm">
                    ← Kembali
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

            @if (session('success'))
                <div class="p-4 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-2xl flex items-center gap-3">
                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    {{ session('success') }}
                </div>
            @endif

            {{-- ============================================================
                 STATUS BANNER
                 ============================================================ --}}
            @php
                $isGood = $receipt->status_penerimaan === 'diterima_sesuai';
                $isCaution = $receipt->status_penerimaan === 'diterima_dengan_catatan';
                $isProblem = in_array($receipt->status_penerimaan, ['menunggu_tindak_lanjut', 'retur_barang', 'penggantian_vendor']);
            @endphp

            <div class="rounded-3xl p-6 md:p-8 text-white shadow-xl relative overflow-hidden
                {{ $isGood ? 'bg-gradient-to-r from-emerald-700 to-emerald-500' : ($isCaution ? 'bg-gradient-to-r from-amber-700 to-amber-500' : 'bg-gradient-to-r from-red-800 to-red-600') }}">
                <div class="absolute -top-10 -right-10 w-40 h-40 bg-white/10 rounded-full blur-2xl"></div>
                <div class="relative z-10 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                    <div class="flex items-center gap-4">
                        <div class="w-16 h-16 rounded-2xl bg-white/20 flex items-center justify-center text-3xl">
                            {{ $isGood ? '✅' : ($isCaution ? '📝' : '⚠️') }}
                        </div>
                        <div>
                            <p class="text-sm font-semibold opacity-80">Status Penerimaan</p>
                            <p class="text-2xl font-black mt-0.5">{{ $receipt->status_label }}</p>
                        </div>
                    </div>
                    <div class="text-right">
                        <p class="text-sm opacity-80">Diperiksa oleh</p>
                        <p class="text-lg font-bold mt-0.5">{{ $receipt->creator->name ?? 'Petugas Gudang' }}</p>
                        <p class="text-sm opacity-70 mt-0.5">{{ $receipt->tanggal_diterima?->format('d M Y') }}</p>
                    </div>
                </div>
            </div>

            {{-- ============================================================
                 INFO PO + RINGKASAN PENERIMAAN
                 ============================================================ --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                {{-- Informasi PO --}}
                <div class="bg-white rounded-3xl border border-slate-200 shadow-sm p-6">
                    <h3 class="text-base font-bold text-slate-900 mb-4 flex items-center gap-2">
                        <span class="w-7 h-7 rounded-lg bg-blue-100 text-blue-700 flex items-center justify-center text-xs font-bold">PO</span>
                        Informasi Purchase Order
                    </h3>
                    <dl class="space-y-3">
                        <div class="flex justify-between">
                            <dt class="text-sm text-slate-500">Nomor PO</dt>
                            <dd class="text-sm font-bold text-slate-900">{{ $receipt->purchaseOrder->kode_po }}</dd>
                        </div>
                        <div class="flex justify-between">
                            <dt class="text-sm text-slate-500">Kode Tender</dt>
                            <dd class="text-sm font-semibold text-slate-700">{{ $receipt->purchaseOrder->tender->kode_tender ?? '-' }}</dd>
                        </div>
                        <div class="flex justify-between">
                            <dt class="text-sm text-slate-500">Vendor</dt>
                            <dd class="text-sm font-semibold text-slate-700">{{ $receipt->purchaseOrder->vendor->nama_vendor ?? '-' }}</dd>
                        </div>
                        <div class="flex justify-between">
                            <dt class="text-sm text-slate-500">Total Nilai PO</dt>
                            <dd class="text-sm font-bold text-blue-700">Rp {{ number_format($receipt->purchaseOrder->total_harga, 0, ',', '.') }}</dd>
                        </div>
                    </dl>
                </div>

                {{-- Ringkasan Penerimaan --}}
                <div class="bg-white rounded-3xl border border-slate-200 shadow-sm p-6">
                    <h3 class="text-base font-bold text-slate-900 mb-4 flex items-center gap-2">
                        <span class="w-7 h-7 rounded-lg bg-emerald-100 text-emerald-700 flex items-center justify-center text-xs">📋</span>
                        Ringkasan Penerimaan
                    </h3>
                    <dl class="space-y-3">
                        <div class="flex justify-between">
                            <dt class="text-sm text-slate-500">Tanggal Diterima</dt>
                            <dd class="text-sm font-semibold text-slate-700">{{ $receipt->tanggal_diterima?->format('d M Y') }}</dd>
                        </div>
                        <div class="flex justify-between">
                            <dt class="text-sm text-slate-500">Jumlah Diterima</dt>
                            <dd class="text-sm font-bold text-slate-900">{{ $receipt->jumlah_diterima }} item(s)</dd>
                        </div>
                        <div class="flex justify-between">
                            <dt class="text-sm text-slate-500">Kondisi Barang</dt>
                            <dd class="text-sm font-semibold {{ in_array($receipt->kondisi_barang, ['kerusakan', 'tidak_sesuai_spesifikasi']) ? 'text-red-600' : 'text-emerald-600' }}">
                                {{ $receipt->kondisi_label }}
                            </dd>
                        </div>
                        @if ($receipt->jumlah_rusak)
                        <div class="flex justify-between">
                            <dt class="text-sm text-slate-500">Jumlah Rusak</dt>
                            <dd class="text-sm font-bold text-red-600">{{ $receipt->jumlah_rusak }} item(s)</dd>
                        </div>
                        @endif
                    </dl>
                </div>
            </div>

            {{-- ============================================================
                 CATATAN + TINDAKAN
                 ============================================================ --}}
            <div class="bg-white rounded-3xl border border-slate-200 shadow-sm p-6">
                <h3 class="text-base font-bold text-slate-900 mb-5">📝 Catatan & Tindakan</h3>
                <div class="space-y-4">
                    @if ($receipt->catatan_gudang)
                    <div class="p-4 bg-slate-50 rounded-2xl">
                        <p class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Catatan Gudang</p>
                        <p class="text-sm text-slate-700 leading-relaxed">{{ $receipt->catatan_gudang }}</p>
                    </div>
                    @endif

                    @if ($receipt->detail_permasalahan)
                    <div class="p-4 bg-red-50 border border-red-200 rounded-2xl">
                        <p class="text-xs font-bold text-red-600 uppercase tracking-wider mb-2">⚠️ Detail Permasalahan</p>
                        <p class="text-sm text-red-800 leading-relaxed">{{ $receipt->detail_permasalahan }}</p>
                    </div>
                    @endif

                    @if ($receipt->tindakan_selanjutnya)
                    <div class="p-4 bg-blue-50 border border-blue-200 rounded-2xl flex items-start gap-3">
                        <svg class="w-5 h-5 text-blue-600 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                        <div>
                            <p class="text-xs font-bold text-blue-600 uppercase tracking-wider mb-1">Tindakan Selanjutnya</p>
                            <p class="text-sm font-semibold text-blue-900">{{ $receipt->tindakan_label }}</p>
                        </div>
                    </div>
                    @endif

                    @if (!$receipt->catatan_gudang && !$receipt->detail_permasalahan && !$receipt->tindakan_selanjutnya)
                        <p class="text-sm text-slate-400 text-center py-4">Tidak ada catatan tambahan</p>
                    @endif
                </div>
            </div>

            {{-- ============================================================
                 FOTO DOKUMENTASI
                 ============================================================ --}}
            @if ($receipt->photos->count() > 0)
            <div class="bg-white rounded-3xl border border-slate-200 shadow-sm p-6">
                <h3 class="text-base font-bold text-slate-900 mb-5">
                    📷 Foto Dokumentasi
                    <span class="text-sm font-normal text-slate-500 ml-2">({{ $receipt->photos->count() }} foto)</span>
                </h3>
                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                    @foreach ($receipt->photos as $photo)
                    <div class="group relative">
                        <div class="aspect-square rounded-2xl overflow-hidden bg-slate-100 border border-slate-200">
                            <img src="{{ Storage::url($photo->file_path) }}"
                                alt="{{ $photo->keterangan ?? 'Foto dokumentasi' }}"
                                class="w-full h-full object-cover group-hover:scale-105 transition duration-300 cursor-pointer"
                                onclick="openLightbox('{{ Storage::url($photo->file_path) }}', '{{ $photo->keterangan ?? '' }}')">
                        </div>
                        @if ($photo->keterangan)
                        <p class="text-xs text-slate-600 mt-1.5 text-center font-medium">{{ $photo->keterangan }}</p>
                        @endif
                    </div>
                    @endforeach
                </div>
            </div>
            @endif

            {{-- ============================================================
                 DETAIL MATERIAL
                 ============================================================ --}}
            <div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden">
                <div class="px-6 py-4 border-b border-slate-200">
                    <h3 class="text-base font-bold text-slate-900">📦 Material yang Diperiksa</h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-slate-50 border-b border-slate-100">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Nama Barang</th>
                                <th class="px-6 py-3 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Spesifikasi</th>
                                <th class="px-6 py-3 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Qty Pesanan</th>
                                <th class="px-6 py-3 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Satuan</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @foreach ($receipt->purchaseOrder->items as $item)
                            <tr>
                                <td class="px-6 py-4 text-sm font-semibold text-slate-900">{{ $item->nama_barang }}</td>
                                <td class="px-6 py-4 text-sm text-slate-600">{{ $item->spesifikasi ?? '-' }}</td>
                                <td class="px-6 py-4 text-sm font-bold text-blue-700">{{ $item->qty }}</td>
                                <td class="px-6 py-4 text-sm text-slate-600">{{ $item->satuan ?? '-' }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>

    {{-- Lightbox Modal --}}
    <div id="lightbox" onclick="closeLightbox()" class="fixed inset-0 z-50 hidden bg-black/80 backdrop-blur-sm flex items-center justify-center p-4">
        <div class="max-w-4xl w-full" onclick="event.stopPropagation()">
            <img id="lightbox-img" src="" alt="" class="w-full max-h-[80vh] object-contain rounded-2xl shadow-2xl">
            <p id="lightbox-caption" class="text-white text-center mt-3 text-sm font-medium opacity-80"></p>
            <button onclick="closeLightbox()" class="absolute top-4 right-4 text-white bg-white/20 rounded-full p-2 hover:bg-white/30 transition">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>
    </div>

    <script>
        function openLightbox(src, caption) {
            document.getElementById('lightbox-img').src = src;
            document.getElementById('lightbox-caption').textContent = caption;
            document.getElementById('lightbox').classList.remove('hidden');
            document.getElementById('lightbox').classList.add('flex');
        }
        function closeLightbox() {
            document.getElementById('lightbox').classList.add('hidden');
            document.getElementById('lightbox').classList.remove('flex');
        }
    </script>
</x-app-layout>
