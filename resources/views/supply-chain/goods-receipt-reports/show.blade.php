<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3">
            <div>
                <div class="flex items-center gap-2 text-sm text-slate-500 mb-1">
                    <a href="{{ route('supply-chain.goods-receipt-reports.index') }}" class="hover:text-blue-700 transition">Laporan Penerimaan</a>
                    <span>/</span>
                    <span class="text-slate-900 font-semibold">Detail</span>
                </div>
                <h2 class="font-bold text-2xl text-slate-900 leading-tight">
                    Detail Laporan Penerimaan
                </h2>
                <p class="text-sm text-slate-500 mt-1">
                    PO <span class="font-bold text-blue-700">{{ $goodsReceiptReport->purchaseOrder->kode_po }}</span> —
                    Laporan dikirim {{ $goodsReceiptReport->created_at->format('d M Y H:i') }}
                </p>
            </div>
            <a href="{{ route('supply-chain.goods-receipt-reports.index') }}"
                class="inline-flex items-center gap-2 px-5 py-2.5 bg-slate-100 text-slate-700 rounded-xl font-semibold border border-slate-200 hover:bg-slate-200 transition text-sm">
                ← Kembali ke Daftar
            </a>
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
                 STATUS BANNER + NOTIFIKASI ALERT
                 ============================================================ --}}
            @php
                $r = $goodsReceiptReport;
                $isGood = $r->status_penerimaan === 'diterima_sesuai';
                $isCaution = $r->status_penerimaan === 'diterima_dengan_catatan';
                $isProblem = in_array($r->status_penerimaan, ['menunggu_tindak_lanjut', 'retur_barang', 'penggantian_vendor']);
                $isUrgent = in_array($r->kondisi_barang, ['kerusakan', 'tidak_sesuai_spesifikasi']);
            @endphp

            @if ($isUrgent)
            <div class="flex items-start gap-4 p-5 bg-red-50 border-2 border-red-300 rounded-2xl">
                <div class="w-10 h-10 rounded-xl bg-red-500 flex items-center justify-center shrink-0 text-white text-lg">⚠️</div>
                <div>
                    <p class="font-bold text-red-900">Perhatian — Barang Bermasalah Memerlukan Tindakan Segera!</p>
                    <p class="text-sm text-red-700 mt-1">
                        Gudang melaporkan bahwa barang pada PO <strong>{{ $r->purchaseOrder->kode_po }}</strong> mengalami masalah:
                        <strong>{{ $r->kondisi_label }}</strong>. Segera hubungi vendor atau proses tindak lanjut yang diperlukan.
                    </p>
                </div>
            </div>
            @endif

            {{-- Status Banner --}}
            <div class="rounded-3xl p-6 md:p-8 text-white shadow-xl relative overflow-hidden
                {{ $isGood ? 'bg-gradient-to-r from-emerald-700 to-emerald-500' : ($isCaution ? 'bg-gradient-to-r from-amber-600 to-amber-500' : 'bg-gradient-to-r from-red-800 to-red-600') }}">
                <div class="absolute -top-10 -right-10 w-40 h-40 bg-white/10 rounded-full blur-2xl"></div>
                <div class="relative z-10 grid grid-cols-1 md:grid-cols-3 gap-6 items-center">
                    <div class="md:col-span-2 flex items-center gap-4">
                        <div class="w-16 h-16 rounded-2xl bg-white/20 flex items-center justify-center text-3xl">
                            {{ $isGood ? '✅' : ($isCaution ? '📝' : '⚠️') }}
                        </div>
                        <div>
                            <p class="text-sm font-semibold opacity-80">Status Penerimaan</p>
                            <p class="text-2xl font-black mt-0.5">{{ $r->status_label }}</p>
                            <p class="text-sm opacity-70 mt-1">{{ $r->kondisi_label }}</p>
                        </div>
                    </div>
                    <div class="text-left md:text-right">
                        <p class="text-sm opacity-80">Diperiksa oleh</p>
                        <p class="text-lg font-bold mt-0.5">{{ $r->creator->name ?? 'Petugas Gudang' }}</p>
                        <p class="text-sm opacity-70 mt-0.5">{{ $r->tanggal_diterima?->format('d M Y') }}</p>
                    </div>
                </div>
            </div>

            {{-- ============================================================
                 INFO PO + RINGKASAN SIDE-BY-SIDE
                 ============================================================ --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div class="bg-white rounded-3xl border border-slate-200 shadow-sm p-6">
                    <h3 class="text-base font-bold text-slate-900 mb-4">📄 Informasi Purchase Order</h3>
                    <dl class="space-y-3 text-sm">
                        <div class="flex justify-between border-b border-slate-100 pb-2">
                            <dt class="text-slate-500">Nomor PO</dt>
                            <dd class="font-bold text-slate-900">{{ $r->purchaseOrder->kode_po }}</dd>
                        </div>
                        <div class="flex justify-between border-b border-slate-100 pb-2">
                            <dt class="text-slate-500">Kode Tender</dt>
                            <dd class="font-semibold text-slate-700">{{ $r->purchaseOrder->tender->kode_tender ?? '-' }}</dd>
                        </div>
                        <div class="flex justify-between border-b border-slate-100 pb-2">
                            <dt class="text-slate-500">Nama Tender</dt>
                            <dd class="font-semibold text-slate-700 text-right max-w-[200px]">{{ $r->purchaseOrder->tender->nama_tender ?? '-' }}</dd>
                        </div>
                        <div class="flex justify-between border-b border-slate-100 pb-2">
                            <dt class="text-slate-500">Vendor</dt>
                            <dd class="font-semibold text-slate-700">{{ $r->purchaseOrder->vendor->nama_vendor ?? '-' }}</dd>
                        </div>
                        <div class="flex justify-between border-b border-slate-100 pb-2">
                            <dt class="text-slate-500">Total Nilai PO</dt>
                            <dd class="font-bold text-blue-700">Rp {{ number_format($r->purchaseOrder->total_harga, 0, ',', '.') }}</dd>
                        </div>
                        <div class="flex justify-between">
                            <dt class="text-slate-500">Deadline Pengiriman</dt>
                            <dd class="font-semibold text-slate-700">{{ $r->purchaseOrder->deadline_pengiriman ? \Carbon\Carbon::parse($r->purchaseOrder->deadline_pengiriman)->format('d M Y') : '-' }}</dd>
                        </div>
                    </dl>
                </div>

                <div class="bg-white rounded-3xl border border-slate-200 shadow-sm p-6">
                    <h3 class="text-base font-bold text-slate-900 mb-4">📦 Hasil Pemeriksaan Gudang</h3>
                    <dl class="space-y-3 text-sm">
                        <div class="flex justify-between border-b border-slate-100 pb-2">
                            <dt class="text-slate-500">Tanggal Diterima</dt>
                            <dd class="font-semibold text-slate-700">{{ $r->tanggal_diterima?->format('d M Y') }}</dd>
                        </div>
                        <div class="flex justify-between border-b border-slate-100 pb-2">
                            <dt class="text-slate-500">Jumlah Diterima</dt>
                            <dd class="font-bold text-slate-900">{{ $r->jumlah_diterima }} item(s)</dd>
                        </div>
                        @if ($r->jumlah_rusak)
                        <div class="flex justify-between border-b border-slate-100 pb-2">
                            <dt class="text-slate-500">Jumlah Rusak</dt>
                            <dd class="font-bold text-red-600">{{ $r->jumlah_rusak }} item(s)</dd>
                        </div>
                        @endif
                        <div class="flex justify-between border-b border-slate-100 pb-2">
                            <dt class="text-slate-500">Kondisi Barang</dt>
                            <dd>
                                @php
                                    $kondisiClass = match($r->kondisi_barang) {
                                        'sesuai' => 'bg-emerald-100 text-emerald-700',
                                        'diterima_dengan_catatan' => 'bg-yellow-100 text-yellow-700',
                                        'kerusakan' => 'bg-red-100 text-red-700',
                                        'tidak_sesuai_spesifikasi' => 'bg-orange-100 text-orange-700',
                                        default => 'bg-slate-100 text-slate-700',
                                    };
                                @endphp
                                <span class="inline-flex px-2.5 py-1 rounded-full text-xs font-bold {{ $kondisiClass }}">
                                    {{ $r->kondisi_label }}
                                </span>
                            </dd>
                        </div>
                        @if ($r->tindakan_selanjutnya)
                        <div class="flex justify-between border-b border-slate-100 pb-2">
                            <dt class="text-slate-500">Tindakan</dt>
                            <dd class="font-semibold text-slate-700 text-right max-w-[200px]">{{ $r->tindakan_label }}</dd>
                        </div>
                        @endif
                        <div class="flex justify-between">
                            <dt class="text-slate-500">Foto Dokumentasi</dt>
                            <dd class="font-bold text-slate-900">{{ $r->photos->count() }} foto</dd>
                        </div>
                    </dl>
                </div>
            </div>

            {{-- ============================================================
                 DETAIL MATERIAL
                 ============================================================ --}}
            <div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden">
                <div class="px-6 py-4 border-b border-slate-200">
                    <h3 class="text-base font-bold text-slate-900">📦 Detail Material</h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-slate-50 border-b border-slate-100">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Nama Barang</th>
                                <th class="px-6 py-3 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Spesifikasi</th>
                                <th class="px-6 py-3 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Qty Pesanan</th>
                                <th class="px-6 py-3 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Satuan</th>
                                <th class="px-6 py-3 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Harga Satuan</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @foreach ($r->purchaseOrder->items as $item)
                            <tr>
                                <td class="px-6 py-4 text-sm font-semibold text-slate-900">{{ $item->nama_barang }}</td>
                                <td class="px-6 py-4 text-sm text-slate-600 max-w-[200px] truncate">{{ $item->spesifikasi ?? '-' }}</td>
                                <td class="px-6 py-4 text-sm font-bold text-blue-700">{{ $item->qty }}</td>
                                <td class="px-6 py-4 text-sm text-slate-600">{{ $item->satuan ?? '-' }}</td>
                                <td class="px-6 py-4 text-sm text-slate-700">Rp {{ number_format($item->harga_satuan, 0, ',', '.') }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- ============================================================
                 CATATAN & PERMASALAHAN
                 ============================================================ --}}
            <div class="bg-white rounded-3xl border border-slate-200 shadow-sm p-6 space-y-4">
                <h3 class="text-base font-bold text-slate-900">📝 Catatan Gudang</h3>

                @if ($r->catatan_gudang)
                <div class="p-4 bg-slate-50 rounded-2xl">
                    <p class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Catatan Umum</p>
                    <p class="text-sm text-slate-700 leading-relaxed">{{ $r->catatan_gudang }}</p>
                </div>
                @endif

                @if ($r->detail_permasalahan)
                <div class="p-4 bg-red-50 border border-red-200 rounded-2xl">
                    <p class="text-xs font-bold text-red-600 uppercase tracking-wider mb-2">⚠️ Detail Permasalahan</p>
                    <p class="text-sm text-red-800 leading-relaxed">{{ $r->detail_permasalahan }}</p>
                </div>
                @endif

                @if (!$r->catatan_gudang && !$r->detail_permasalahan)
                    <p class="text-sm text-slate-400 text-center py-4">Tidak ada catatan tambahan dari gudang</p>
                @endif
            </div>

            {{-- ============================================================
                 FOTO DOKUMENTASI
                 ============================================================ --}}
            @if ($r->photos->count() > 0)
            <div class="bg-white rounded-3xl border border-slate-200 shadow-sm p-6">
                <h3 class="text-base font-bold text-slate-900 mb-5">
                    📷 Foto Dokumentasi Gudang
                    <span class="text-sm font-normal text-slate-500 ml-2">({{ $r->photos->count() }} foto)</span>
                </h3>
                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                    @foreach ($r->photos as $photo)
                    <div class="group">
                        <div class="aspect-square rounded-2xl overflow-hidden bg-slate-100 border border-slate-200 cursor-pointer"
                            onclick="openLightbox('{{ Storage::url($photo->file_path) }}', '{{ $photo->keterangan ?? '' }}')">
                            <img src="{{ Storage::url($photo->file_path) }}"
                                alt="{{ $photo->keterangan ?? 'Foto dokumentasi' }}"
                                class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
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
                 TOMBOL TINDAK LANJUT
                 ============================================================ --}}
            <div class="bg-white rounded-3xl border border-slate-200 shadow-sm p-6">
                <h3 class="text-base font-bold text-slate-900 mb-2">⚡ Tindak Lanjut Supply Chain</h3>
                <p class="text-sm text-slate-500 mb-5">Pilih tindakan yang akan diambil berdasarkan laporan penerimaan dari gudang</p>

                <div class="flex flex-wrap gap-3">
                    @if ($r->status_penerimaan !== 'diterima_sesuai')
                    <form action="{{ route('supply-chain.goods-receipt-reports.confirm', $r->id) }}" method="POST"
                        onsubmit="return confirm('Konfirmasi bahwa masalah telah diselesaikan?')">
                        @csrf
                        <button type="submit"
                            class="inline-flex items-center gap-2 px-6 py-3 bg-emerald-600 text-white rounded-xl font-semibold hover:bg-emerald-700 transition shadow-sm">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            Konfirmasi Penyelesaian
                        </button>
                    </form>
                    @endif

                    @if ($r->purchaseOrder->vendor?->email)
                    <a href="mailto:{{ $r->purchaseOrder->vendor->email }}?subject=Masalah Pengiriman PO {{ $r->purchaseOrder->kode_po }}&body=Yth. {{ $r->purchaseOrder->vendor->nama_vendor }},%0A%0AKami menemukan masalah pada pengiriman PO {{ $r->purchaseOrder->kode_po }}. Kondisi: {{ $r->kondisi_label }}.%0A%0AMohon segera ditindaklanjuti.%0A%0ATerima kasih."
                        class="inline-flex items-center gap-2 px-6 py-3 bg-blue-900 text-white rounded-xl font-semibold hover:bg-blue-950 transition shadow-sm">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                        Hubungi Vendor
                    </a>
                    @else
                    <button type="button" disabled
                        class="inline-flex items-center gap-2 px-6 py-3 bg-blue-900/50 text-white rounded-xl font-semibold cursor-not-allowed">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                        Hubungi Vendor
                    </button>
                    @endif

                    @if (in_array($r->kondisi_barang, ['kerusakan', 'tidak_sesuai_spesifikasi']) && $r->status_penerimaan !== 'retur_barang')
                    <form action="{{ route('supply-chain.goods-receipt-reports.return', $r->id) }}" method="POST"
                        onsubmit="return confirm('Proses retur barang ke vendor? Gudang akan diberitahu.')">
                        @csrf
                        <button type="submit"
                            class="inline-flex items-center gap-2 px-6 py-3 bg-orange-600 text-white rounded-xl font-semibold hover:bg-orange-700 transition shadow-sm">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 15v-1a4 4 0 00-4-4H8m0 0l3 3m-3-3l3-3m9 14V5a2 2 0 00-2-2H6a2 2 0 00-2 2v16l4-2 4 2 4-2 4 2z"/></svg>
                            Proses Retur
                        </button>
                    </form>
                    @endif

                    @if ($r->status_penerimaan === 'retur_barang')
                    <div class="inline-flex items-center gap-2 px-6 py-3 bg-orange-100 text-orange-700 rounded-xl font-semibold text-sm">
                        🔄 Retur sedang diproses
                    </div>
                    @endif

                    @if ($r->status_penerimaan === 'diterima_sesuai')
                    <div class="inline-flex items-center gap-2 px-6 py-3 bg-emerald-100 text-emerald-700 rounded-xl font-semibold text-sm">
                        ✅ Penerimaan telah dikonfirmasi selesai
                    </div>
                    @endif
                </div>
            </div>

        </div>
    </div>

    {{-- Lightbox Modal --}}
    <div id="lightbox" onclick="closeLightbox()" class="fixed inset-0 z-50 hidden bg-black/80 backdrop-blur-sm items-center justify-center p-4">
        <div class="max-w-4xl w-full relative" onclick="event.stopPropagation()">
            <img id="lightbox-img" src="" alt="" class="w-full max-h-[80vh] object-contain rounded-2xl shadow-2xl">
            <p id="lightbox-caption" class="text-white text-center mt-3 text-sm font-medium opacity-80"></p>
            <button onclick="closeLightbox()" class="absolute top-2 right-2 text-white bg-white/20 rounded-full p-2 hover:bg-white/30 transition">
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
        }
        function closeLightbox() {
            const lb = document.getElementById('lightbox');
            lb.classList.add('hidden');
            lb.classList.remove('flex');
        }
    </script>
</x-app-layout>
