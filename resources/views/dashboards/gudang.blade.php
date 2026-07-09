<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3">
            <div>
                <h2 class="font-bold text-2xl text-slate-900 leading-tight">
                    Dashboard Gudang
                </h2>
                <p class="text-sm text-slate-500 mt-1">
                    Monitoring penerimaan material — pantau status barang masuk dari vendor secara real-time.
                </p>
            </div>
            <div class="flex items-center gap-3">
                <div class="text-sm text-slate-600 bg-white px-4 py-2 rounded-xl border border-slate-200 shadow-sm">
                    📅 {{ now()->format('d M Y') }}
                </div>
                <a href="{{ route('gudang.goods-receipts.index') }}"
                    class="inline-flex items-center gap-2 px-5 py-2.5 bg-blue-900 text-white rounded-xl font-semibold shadow-lg hover:bg-blue-950 transition text-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                    Semua PO
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">

            {{-- ============================================================
                 HERO SECTION
                 ============================================================ --}}
            <div class="relative overflow-hidden rounded-3xl bg-gradient-to-r from-slate-950 via-blue-950 to-blue-800 p-8 md:p-10 shadow-xl text-white">
                <div class="absolute -top-24 -right-24 w-80 h-80 bg-cyan-400/20 rounded-full blur-3xl"></div>
                <div class="absolute -bottom-24 -left-24 w-80 h-80 bg-blue-400/20 rounded-full blur-3xl"></div>
                <div class="absolute top-6 right-6 opacity-10">
                    <svg class="w-40 h-40" fill="currentColor" viewBox="0 0 24 24"><path d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                </div>

                <div class="relative z-10 grid grid-cols-1 lg:grid-cols-2 gap-8 items-center">
                    <div>
                        <p class="inline-flex px-4 py-2 rounded-full bg-white/10 border border-white/10 text-sm text-blue-100 mb-5">
                            🏭 Warehouse Management — PT PAL
                        </p>
                        <h3 class="text-3xl md:text-4xl font-bold leading-tight">
                            Penerimaan Material Kapal
                        </h3>
                        <p class="mt-4 text-blue-100 max-w-xl text-base leading-relaxed">
                            Kelola penerimaan barang dari vendor, lakukan pemeriksaan kualitas material, dan dokumentasikan
                            kondisi barang secara sistematis untuk memastikan standar pengadaan kapal terpenuhi.
                        </p>
                        <div class="mt-7 flex flex-wrap gap-3">
                            <a href="{{ route('gudang.goods-receipts.index') }}"
                                class="inline-flex items-center gap-2 px-6 py-3 bg-white text-blue-950 rounded-2xl font-bold shadow-lg hover:bg-slate-100 hover:-translate-y-1 transition">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2M15 11l-3 3m0 0l-3-3m3 3V8"/></svg>
                                Periksa Barang Masuk
                            </a>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div class="bg-white/10 border border-white/10 rounded-2xl p-5 backdrop-blur-sm">
                            <p class="text-xs text-blue-200 font-semibold uppercase tracking-wider">Menunggu Penerimaan</p>
                            <p class="text-4xl font-black mt-2">{{ $poMenunggu }}</p>
                            <p class="text-xs text-blue-200 mt-1">Purchase Order</p>
                        </div>
                        <div class="bg-white/10 border border-white/10 rounded-2xl p-5 backdrop-blur-sm">
                            <p class="text-xs text-blue-200 font-semibold uppercase tracking-wider">Sudah Diterima</p>
                            <p class="text-4xl font-black mt-2 text-emerald-300">{{ $poSudahDiterima }}</p>
                            <p class="text-xs text-blue-200 mt-1">Laporan selesai</p>
                        </div>
                        <div class="bg-white/10 border border-white/10 rounded-2xl p-5 backdrop-blur-sm">
                            <p class="text-xs text-blue-200 font-semibold uppercase tracking-wider">Barang Bermasalah</p>
                            <p class="text-4xl font-black mt-2 text-red-300">{{ $poMasalah }}</p>
                            <p class="text-xs text-blue-200 mt-1">Perlu perhatian</p>
                        </div>
                        <div class="bg-white/10 border border-white/10 rounded-2xl p-5 backdrop-blur-sm">
                            <p class="text-xs text-blue-200 font-semibold uppercase tracking-wider">Tindak Lanjut</p>
                            <p class="text-4xl font-black mt-2 text-amber-300">{{ $perluTindakLanjut }}</p>
                            <p class="text-xs text-blue-200 mt-1">Menunggu keputusan</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- ============================================================
                 STAT CARDS
                 ============================================================ --}}
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-5">
                {{-- Card 1 --}}
                <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 flex items-start gap-4 hover:shadow-md transition">
                    <div class="w-12 h-12 rounded-xl bg-blue-50 flex items-center justify-center shrink-0">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                    </div>
                    <div>
                        <p class="text-2xl font-black text-slate-900">{{ $poMenunggu }}</p>
                        <p class="text-sm font-semibold text-slate-700 mt-0.5">PO Menunggu</p>
                        <p class="text-xs text-blue-600 mt-1 font-medium">⏳ Perlu diperiksa</p>
                    </div>
                </div>

                {{-- Card 2 --}}
                <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 flex items-start gap-4 hover:shadow-md transition">
                    <div class="w-12 h-12 rounded-xl bg-emerald-50 flex items-center justify-center shrink-0">
                        <svg class="w-6 h-6 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <div>
                        <p class="text-2xl font-black text-slate-900">{{ $poSudahDiterima }}</p>
                        <p class="text-sm font-semibold text-slate-700 mt-0.5">Sudah Diterima</p>
                        <p class="text-xs text-emerald-600 mt-1 font-medium">✅ Laporan lengkap</p>
                    </div>
                </div>

                {{-- Card 3 --}}
                <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 flex items-start gap-4 hover:shadow-md transition">
                    <div class="w-12 h-12 rounded-xl bg-red-50 flex items-center justify-center shrink-0">
                        <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                    </div>
                    <div>
                        <p class="text-2xl font-black text-slate-900">{{ $poMasalah }}</p>
                        <p class="text-sm font-semibold text-slate-700 mt-0.5">Barang Bermasalah</p>
                        <p class="text-xs text-red-600 mt-1 font-medium">⚠️ Cacat / tidak sesuai</p>
                    </div>
                </div>

                {{-- Card 4 --}}
                <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 flex items-start gap-4 hover:shadow-md transition">
                    <div class="w-12 h-12 rounded-xl bg-amber-50 flex items-center justify-center shrink-0">
                        <svg class="w-6 h-6 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <div>
                        <p class="text-2xl font-black text-slate-900">{{ $perluTindakLanjut }}</p>
                        <p class="text-sm font-semibold text-slate-700 mt-0.5">Perlu Tindak Lanjut</p>
                        <p class="text-xs text-amber-600 mt-1 font-medium">🔄 Menunggu keputusan</p>
                    </div>
                </div>
            </div>

            {{-- ============================================================
                 TABEL DAFTAR PO MENUNGGU PENERIMAAN
                 ============================================================ --}}
            <div class="bg-white rounded-3xl shadow-sm border border-slate-200 overflow-hidden">
                <div class="px-6 py-5 border-b border-slate-200 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                    <div>
                        <h3 class="text-lg font-bold text-slate-900">Daftar Barang Menunggu Penerimaan</h3>
                        <p class="text-sm text-slate-500 mt-0.5">Purchase Order yang perlu dilakukan pemeriksaan barang masuk</p>
                    </div>
                    <a href="{{ route('gudang.goods-receipts.index') }}"
                        class="inline-flex items-center gap-2 text-sm text-blue-700 hover:text-blue-900 font-semibold transition">
                        Lihat semua →
                    </a>
                </div>

                @if (session('success'))
                    <div class="mx-6 mt-4 p-4 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-xl text-sm">
                        ✅ {{ session('success') }}
                    </div>
                @endif

                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-slate-50 border-b border-slate-200">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">No. PO</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Vendor</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Tender / Material</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Jml Pesanan</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Deadline Kirim</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-slate-100">
                            @forelse ($purchaseOrders as $po)
                                <tr class="hover:bg-slate-50/70 transition">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="text-sm font-black text-slate-900">{{ $po->kode_po }}</span>
                                    </td>

                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-3">
                                            <div class="w-8 h-8 rounded-lg bg-blue-100 flex items-center justify-center shrink-0">
                                                <span class="text-xs font-bold text-blue-700">{{ substr($po->vendor->nama_vendor ?? 'V', 0, 1) }}</span>
                                            </div>
                                            <span class="text-sm font-semibold text-slate-800">{{ $po->vendor->nama_vendor ?? '-' }}</span>
                                        </div>
                                    </td>

                                    <td class="px-6 py-4">
                                        <div class="text-sm font-semibold text-slate-900">{{ $po->tender->nama_tender ?? '-' }}</div>
                                        <div class="text-xs text-slate-500 mt-0.5">
                                            {{ $po->items->first()->nama_barang ?? 'Material tidak tersedia' }}
                                        </div>
                                    </td>

                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-700">
                                        {{ $po->items->sum('qty') }} item(s)
                                    </td>

                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if ($po->deadline_pengiriman)
                                            @php $deadline = \Carbon\Carbon::parse($po->deadline_pengiriman); @endphp
                                            <span class="text-sm {{ $deadline->isPast() ? 'text-red-600 font-bold' : 'text-slate-700' }}">
                                                {{ $deadline->format('d M Y') }}
                                            </span>
                                            @if ($deadline->isPast() && !$po->goodsReceipt)
                                                <span class="block text-xs text-red-500 font-semibold">Terlambat!</span>
                                            @endif
                                        @else
                                            <span class="text-slate-400 text-sm">-</span>
                                        @endif
                                    </td>

                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if ($po->goodsReceipt)
                                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold {{ $po->goodsReceipt->status_badge_class }}">
                                                <span class="w-1.5 h-1.5 rounded-full bg-current"></span>
                                                {{ $po->goodsReceipt->status_label }}
                                            </span>
                                        @elseif ($po->status === 'dikirim')
                                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-purple-100 text-purple-700">
                                                <span class="w-1.5 h-1.5 rounded-full bg-current"></span>
                                                Menunggu Pemeriksaan
                                            </span>
                                        @elseif ($po->status === 'selesai')
                                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-emerald-100 text-emerald-700">
                                                <span class="w-1.5 h-1.5 rounded-full bg-current"></span>
                                                Selesai
                                            </span>
                                        @else
                                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-slate-100 text-slate-700">
                                                {{ str_replace('_', ' ', ucfirst($po->status)) }}
                                            </span>
                                        @endif
                                    </td>

                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if ($po->goodsReceipt)
                                            <a href="{{ route('gudang.goods-receipts.report', $po->goodsReceipt->id) }}"
                                                class="inline-flex items-center gap-1.5 px-4 py-2 bg-slate-100 text-slate-700 rounded-xl text-xs font-semibold hover:bg-slate-200 transition">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                                Lihat Laporan
                                            </a>
                                        @else
                                            <a href="{{ route('gudang.goods-receipts.show', $po->id) }}"
                                                class="inline-flex items-center gap-1.5 px-4 py-2 bg-blue-900 text-white rounded-xl text-xs font-semibold hover:bg-blue-950 transition shadow-sm">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2M15 11l-3 3m0 0l-3-3m3 3V8"/></svg>
                                                Periksa Barang
                                            </a>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="px-6 py-20 text-center">
                                        <div class="mx-auto w-16 h-16 rounded-2xl bg-slate-100 flex items-center justify-center mb-4">
                                            <svg class="w-8 h-8 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                                        </div>
                                        <h3 class="text-lg font-bold text-slate-900">Belum Ada Barang Menunggu Penerimaan</h3>
                                        <p class="text-sm text-slate-500 mt-2">Purchase Order akan muncul di sini ketika vendor telah mengirimkan barang.</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if ($purchaseOrders->hasPages())
                    <div class="px-6 py-4 border-t border-slate-200">
                        {{ $purchaseOrders->links() }}
                    </div>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>
