<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3">
            <div>
                <div class="flex items-center gap-2 text-sm text-slate-500 mb-1">
                    <a href="{{ route('gudang.dashboard') }}" class="hover:text-blue-700 transition">Dashboard</a>
                    <span>/</span>
                    <a href="{{ route('gudang.dashboard') }}" class="hover:text-blue-700 transition">Laporan Penerimaan</a>
                </div>
                <h2 class="font-bold text-2xl text-slate-900 leading-tight">
                    Laporan Penerimaan Barang
                </h2>
                <p class="text-sm text-slate-500 mt-1">
                    PO <span class="font-bold text-slate-900">{{ $receipt->purchaseOrder->kode_po }}</span> &mdash; Dibuat {{ $receipt->created_at->format('d M Y H:i') }}
                </p>
            </div>
            <div class="flex gap-2">
                <a href="{{ route('gudang.goods-receipts.show', $receipt->purchaseOrder->id) }}"
                    class="inline-flex items-center gap-2 px-4 py-2 bg-white text-blue-700 rounded-xl font-bold border border-blue-200 hover:bg-blue-50 transition shadow-sm text-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                    Edit Laporan
                </a>
                <a href="{{ route('gudang.dashboard') }}"
                    class="inline-flex items-center gap-2 px-5 py-2 bg-white text-slate-700 rounded-xl font-bold border border-slate-200 hover:bg-slate-50 transition shadow-sm text-sm">
                    Kembali
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">

            {{-- Flash Message --}}
            @if (session('success'))
            <div class="p-4 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-2xl flex items-center gap-3 shadow-sm">
                <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                <p class="font-medium">{{ session('success') }}</p>
            </div>
            @endif

            {{-- Status Banner --}}
            <div class="{{ $receipt->status_badge_class }} rounded-3xl p-6 md:p-8 flex flex-col md:flex-row items-center justify-between gap-6 relative overflow-hidden">
                <div class="flex items-center gap-5 relative z-10 w-full md:w-auto">
                    <div class="w-16 h-16 rounded-2xl bg-white/20 flex items-center justify-center shrink-0 border border-white/20">
                        @if (str_contains($receipt->status_badge_class, 'emerald'))
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        @elseif (str_contains($receipt->status_badge_class, 'amber'))
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                        @else
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        @endif
                    </div>
                    <div>
                        <p class="text-sm font-medium opacity-90 mb-0.5">Status Penerimaan</p>
                        <h3 class="text-2xl font-black tracking-tight">{{ $receipt->status_label }}</h3>
                    </div>
                </div>
                <div class="text-left md:text-right w-full md:w-auto relative z-10">
                    <p class="text-sm font-medium opacity-90 mb-0.5">Diperiksa oleh</p>
                    <p class="font-bold text-lg">{{ $receipt->creator->name ?? 'Gudang' }}</p>
                    <p class="text-xs opacity-80 mt-1">{{ \Carbon\Carbon::parse($receipt->tanggal_diterima)->format('d M Y') }}</p>
                </div>
            </div>

            {{-- Ringkasan Split --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                {{-- Info PO --}}
                <div class="bg-white rounded-3xl p-6 border border-slate-200 shadow-sm">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="w-8 h-8 rounded-full bg-blue-50 flex items-center justify-center text-blue-600">
                            <span class="text-xs font-black">PO</span>
                        </div>
                        <h4 class="font-bold text-slate-900">Informasi Purchase Order</h4>
                    </div>
                    <dl class="space-y-4 text-sm">
                        <div class="flex justify-between items-center pb-3 border-b border-slate-100">
                            <dt class="text-slate-500 font-medium">Nomor PO</dt>
                            <dd class="font-bold text-slate-900">{{ $receipt->purchaseOrder->kode_po }}</dd>
                        </div>
                        <div class="flex justify-between items-center pb-3 border-b border-slate-100">
                            <dt class="text-slate-500 font-medium">Kode Tender</dt>
                            <dd class="font-bold text-slate-900">{{ $receipt->purchaseOrder->tender->kode_tender ?? '-' }}</dd>
                        </div>
                        <div class="flex justify-between items-center pb-3 border-b border-slate-100">
                            <dt class="text-slate-500 font-medium">Vendor</dt>
                            <dd class="font-bold text-slate-900">{{ $receipt->purchaseOrder->vendor->nama_vendor ?? '-' }}</dd>
                        </div>
                        <div class="flex justify-between items-center">
                            <dt class="text-slate-500 font-medium">Total Nilai PO</dt>
                            <dd class="font-black text-blue-600">Rp {{ number_format($receipt->purchaseOrder->total_harga, 0, ',', '.') }}</dd>
                        </div>
                    </dl>
                </div>

                {{-- Info Penerimaan --}}
                <div class="bg-white rounded-3xl p-6 border border-slate-200 shadow-sm">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="w-8 h-8 rounded-full bg-emerald-50 flex items-center justify-center text-emerald-600">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                        </div>
                        <h4 class="font-bold text-slate-900">Ringkasan Penerimaan</h4>
                    </div>
                    <dl class="space-y-4 text-sm">
                        <div class="flex justify-between items-center pb-3 border-b border-slate-100">
                            <dt class="text-slate-500 font-medium">Tanggal Diterima</dt>
                            <dd class="font-bold text-slate-900">{{ \Carbon\Carbon::parse($receipt->tanggal_diterima)->format('d M Y') }}</dd>
                        </div>
                        <div class="flex justify-between items-center pb-3 border-b border-slate-100">
                            <dt class="text-slate-500 font-medium">Jumlah Diterima</dt>
                            <dd class="font-bold text-slate-900">{{ $receipt->jumlah_diterima }} item(s)</dd>
                        </div>
                        <div class="flex justify-between items-center pb-3 border-b border-slate-100">
                            <dt class="text-slate-500 font-medium">Kondisi Barang</dt>
                            <dd class="font-bold {{ in_array($receipt->kondisi_barang, ['kerusakan', 'tidak_sesuai_spesifikasi']) ? 'text-red-600' : 'text-emerald-600' }}">
                                {{ ucwords(str_replace('_', ' ', $receipt->kondisi_barang)) }}
                            </dd>
                        </div>
                        @if ($receipt->jumlah_rusak > 0)
                        <div class="flex justify-between items-center text-red-600">
                            <dt class="font-medium">Jumlah Rusak</dt>
                            <dd class="font-black">{{ $receipt->jumlah_rusak }} item(s)</dd>
                        </div>
                        @endif
                    </dl>
                </div>
            </div>

            {{-- Catatan & Tindakan --}}
            <div class="bg-white rounded-3xl border border-slate-200 shadow-sm p-6">
                <h3 class="text-base font-bold text-slate-900 mb-5">Catatan Pemeriksaan</h3>
                <div class="space-y-4">
                    @if ($receipt->catatan_gudang)
                    <div class="p-4 bg-slate-50 rounded-2xl border border-slate-100">
                        <p class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Catatan Gudang</p>
                        <p class="text-sm text-slate-700 leading-relaxed">{{ $receipt->catatan_gudang }}</p>
                    </div>
                    @endif

                    @if ($receipt->detail_permasalahan)
                    <div class="p-4 bg-red-50 border border-red-200 rounded-2xl">
                        <p class="text-xs font-bold text-red-600 uppercase tracking-wider mb-2">Detail Permasalahan</p>
                        <p class="text-sm text-red-800 leading-relaxed font-medium">{{ $receipt->detail_permasalahan }}</p>
                    </div>
                    @endif

                    @if (!$receipt->catatan_gudang && !$receipt->detail_permasalahan)
                        <p class="text-sm text-slate-400 text-center py-6 font-medium">Tidak ada catatan tambahan</p>
                    @endif
                </div>
            </div>

            {{-- Foto Bukti --}}
            <div class="bg-white rounded-3xl border border-slate-200 shadow-sm p-6">
                <h3 class="text-base font-bold text-slate-900 mb-5">
                    Foto Bukti Penerimaan Barang
                    @if ($receipt->photos->count() > 0)
                        <span class="text-sm font-normal text-slate-500 ml-2">({{ $receipt->photos->count() }} foto)</span>
                    @endif
                </h3>
                
                @if ($receipt->photos->count() > 0)
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
                        <p class="text-xs text-slate-600 mt-2 text-center font-medium">{{ $photo->keterangan }}</p>
                        @endif
                    </div>
                    @endforeach
                </div>
                @else
                <div class="p-8 text-center bg-slate-50 rounded-2xl border border-slate-100">
                    <p class="text-sm font-medium text-slate-500">Belum ada foto bukti penerimaan.</p>
                </div>
                @endif
            </div>

            {{-- Detail Material --}}
            <div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden">
                <div class="px-6 py-5 border-b border-slate-100">
                    <h3 class="text-base font-bold text-slate-900">Material yang Diperiksa</h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-slate-50/50 border-b border-slate-100">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Nama Barang</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Spesifikasi</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Qty Pesanan</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Satuan</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @foreach ($receipt->purchaseOrder->items as $item)
                            <tr class="hover:bg-slate-50/50 transition">
                                <td class="px-6 py-4 text-sm font-bold text-slate-900">{{ $item->nama_barang }}</td>
                                <td class="px-6 py-4 text-sm text-slate-600">{{ $item->spesifikasi ?? '-' }}</td>
                                <td class="px-6 py-4 text-sm font-black text-blue-700">{{ $item->qty }}</td>
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
