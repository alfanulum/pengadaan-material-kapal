<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3">
            <div>
                <div class="flex items-center gap-2 text-sm text-slate-500 mb-1">
                    <a href="{{ route('supply-chain.dashboard') }}" class="hover:text-blue-700 transition">Dashboard</a>
                    <span>/</span>
                    <a href="{{ route('supply-chain.goods-receipts.index') }}" class="hover:text-blue-700 transition">Laporan Penerimaan</a>
                    <span>/</span>
                    <span class="text-slate-900 font-semibold">Detail</span>
                </div>
                <h2 class="font-bold text-2xl text-slate-900 leading-tight">
                    Detail Laporan Penerimaan
                </h2>
                <p class="text-sm text-slate-500 mt-1">
                    PO <span class="font-bold text-blue-700">{{ $goodsReceipt->purchaseOrder->kode_po }}</span> —
                    {{ $goodsReceipt->purchaseOrder->vendor->nama_vendor ?? '-' }}
                </p>
            </div>
            <a href="{{ route('supply-chain.goods-receipts.index') }}"
                class="inline-flex items-center gap-2 px-5 py-2.5 bg-slate-100 text-slate-700 rounded-xl font-semibold border border-slate-200 hover:bg-slate-200 transition text-sm">
                ← Kembali ke Daftar
            </a>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

            {{-- Hero PO Info --}}
            <div class="bg-gradient-to-r from-slate-950 via-blue-950 to-blue-800 rounded-3xl p-6 md:p-8 text-white shadow-xl relative overflow-hidden">
                <div class="absolute -top-12 -right-12 w-48 h-48 bg-cyan-400/20 rounded-full blur-3xl"></div>
                <div class="relative z-10">
                    <div class="flex items-start justify-between mb-5">
                        <div>
                            <p class="inline-flex px-3 py-1 rounded-full bg-white/10 border border-white/10 text-xs text-blue-100 mb-2">
                                Laporan Penerimaan Gudang
                            </p>
                            <h3 class="text-2xl font-black">{{ $goodsReceipt->purchaseOrder->kode_po }}</h3>
                            <p class="text-blue-200 text-sm mt-1">{{ $goodsReceipt->purchaseOrder->vendor->nama_vendor ?? '-' }}</p>
                        </div>
                        <span class="inline-flex px-4 py-2 rounded-full text-sm font-bold {{ $goodsReceipt->status_badge_class }}">
                            {{ $goodsReceipt->status_label }}
                        </span>
                    </div>

                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                        <div class="bg-white/10 rounded-2xl p-4 border border-white/10">
                            <p class="text-xs text-blue-200">Tanggal Diterima</p>
                            <p class="font-bold mt-1">{{ \Carbon\Carbon::parse($goodsReceipt->tanggal_diterima)->format('d M Y') }}</p>
                        </div>
                        <div class="bg-white/10 rounded-2xl p-4 border border-white/10">
                            <p class="text-xs text-blue-200">Jumlah Diterima</p>
                            <p class="font-bold mt-1">{{ $goodsReceipt->jumlah_diterima }} item</p>
                        </div>
                        <div class="bg-white/10 rounded-2xl p-4 border border-white/10">
                            <p class="text-xs text-blue-200">Kondisi Barang</p>
                            <p class="font-bold mt-1">{{ $goodsReceipt->kondisi_label }}</p>
                        </div>
                        <div class="bg-white/10 rounded-2xl p-4 border border-white/10">
                            <p class="text-xs text-blue-200">Dibuat oleh</p>
                            <p class="font-bold mt-1">{{ $goodsReceipt->creator->name ?? '-' }}</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Tracking Timeline --}}
            <div class="bg-white rounded-3xl shadow-sm border border-slate-200 p-6 md:p-8">
                <h3 class="text-lg font-bold text-slate-900 mb-6">Perjalanan Pengadaan Material</h3>
                <div class="relative">
                    <div class="absolute left-4 md:left-[10%] top-6 bottom-6 w-1 bg-slate-200 md:w-auto md:h-1 md:top-3 md:left-8 md:right-8 md:bottom-auto z-0 rounded"></div>
                    <div class="absolute left-4 md:left-[10%] top-6 w-1 bg-emerald-500 z-0 rounded md:w-auto md:h-1 md:top-3 md:left-8 md:bottom-auto" style="height: 100%;"></div>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-8 relative z-10 pl-10 md:pl-0">
                        {{-- Step 1 --}}
                        <div class="relative md:text-center">
                            <div class="absolute -left-10 md:relative md:left-0 md:mx-auto w-8 h-8 rounded-full flex items-center justify-center border-4 bg-emerald-500 border-white shadow-md">
                                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                            </div>
                            <div class="mt-0 md:mt-4">
                                <h5 class="font-bold text-emerald-700">Pesanan Dibuat</h5>
                                <p class="text-xs text-slate-500 mt-1">{{ \Carbon\Carbon::parse($goodsReceipt->purchaseOrder->created_at)->format('d M Y') }}</p>
                                <p class="text-xs text-slate-600 mt-0.5">{{ $goodsReceipt->purchaseOrder->kode_po }}</p>
                            </div>
                        </div>
                        {{-- Step 2 --}}
                        <div class="relative md:text-center">
                            <div class="absolute -left-10 md:relative md:left-0 md:mx-auto w-8 h-8 rounded-full flex items-center justify-center border-4 bg-emerald-500 border-white shadow-md">
                                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                            </div>
                            <div class="mt-0 md:mt-4">
                                <h5 class="font-bold text-emerald-700">Barang Dikirim Vendor</h5>
                                <p class="text-xs text-slate-500 mt-1">{{ $goodsReceipt->purchaseOrder->tanggal_pengiriman ? \Carbon\Carbon::parse($goodsReceipt->purchaseOrder->tanggal_pengiriman)->format('d M Y') : '-' }}</p>
                                <p class="text-xs text-slate-600 mt-0.5">{{ $goodsReceipt->purchaseOrder->vendor->nama_vendor ?? '-' }}</p>
                            </div>
                        </div>
                        {{-- Step 3 --}}
                        <div class="relative md:text-center">
                            <div class="absolute -left-10 md:relative md:left-0 md:mx-auto w-8 h-8 rounded-full flex items-center justify-center border-4 bg-emerald-500 border-white shadow-md">
                                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                            </div>
                            <div class="mt-0 md:mt-4">
                                <h5 class="font-bold text-emerald-700">Diterima Gudang</h5>
                                <p class="text-xs text-slate-500 mt-1">{{ \Carbon\Carbon::parse($goodsReceipt->tanggal_diterima)->format('d M Y') }}</p>
                                <p class="text-xs font-semibold {{ in_array($goodsReceipt->kondisi_barang, ['kerusakan', 'tidak_sesuai_spesifikasi']) ? 'text-red-600' : 'text-emerald-600' }} mt-0.5">
                                    {{ $goodsReceipt->kondisi_label }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                {{-- Detail Penerimaan --}}
                <div class="bg-white rounded-3xl shadow-sm border border-slate-200 overflow-hidden">
                    <div class="px-6 py-5 border-b border-slate-200">
                        <h3 class="text-lg font-bold text-slate-900">Detail Penerimaan</h3>
                    </div>
                    <div class="p-6 space-y-4">
                        <div class="rounded-2xl bg-slate-50 p-4">
                            <p class="text-xs text-slate-500 mb-1">Kondisi Barang</p>
                            <p class="font-bold text-slate-900">{{ $goodsReceipt->kondisi_label }}</p>
                        </div>
                        @if($goodsReceipt->jumlah_rusak)
                            <div class="rounded-2xl bg-red-50 p-4">
                                <p class="text-xs text-red-600 mb-1">Jumlah Barang Rusak</p>
                                <p class="font-bold text-red-700">{{ $goodsReceipt->jumlah_rusak }} item</p>
                            </div>
                        @endif
                        @if($goodsReceipt->catatan_gudang)
                            <div class="rounded-2xl bg-slate-50 p-4">
                                <p class="text-xs text-slate-500 mb-1">Catatan Gudang</p>
                                <p class="text-sm text-slate-700 leading-relaxed">{{ $goodsReceipt->catatan_gudang }}</p>
                            </div>
                        @endif
                        @if($goodsReceipt->detail_permasalahan)
                            <div class="rounded-2xl bg-amber-50 border border-amber-100 p-4">
                                <p class="text-xs text-amber-600 mb-1">Detail Permasalahan</p>
                                <p class="text-sm text-amber-800 leading-relaxed">{{ $goodsReceipt->detail_permasalahan }}</p>
                            </div>
                        @endif
                        @if($goodsReceipt->tindakan_selanjutnya)
                            <div class="rounded-2xl bg-blue-50 border border-blue-100 p-4">
                                <p class="text-xs text-blue-600 mb-1">Tindakan Selanjutnya</p>
                                <p class="text-sm font-semibold text-blue-800">{{ $goodsReceipt->tindakan_label }}</p>
                            </div>
                        @endif
                    </div>
                </div>

                {{-- Info PO --}}
                <div class="bg-white rounded-3xl shadow-sm border border-slate-200 overflow-hidden">
                    <div class="px-6 py-5 border-b border-slate-200">
                        <h3 class="text-lg font-bold text-slate-900">Informasi Purchase Order</h3>
                    </div>
                    <div class="p-6 space-y-4">
                        <div class="rounded-2xl bg-slate-50 p-4">
                            <p class="text-xs text-slate-500 mb-1">Kode PO</p>
                            <p class="font-bold text-slate-900">{{ $goodsReceipt->purchaseOrder->kode_po }}</p>
                        </div>
                        <div class="rounded-2xl bg-slate-50 p-4">
                            <p class="text-xs text-slate-500 mb-1">Vendor</p>
                            <p class="font-bold text-slate-900">{{ $goodsReceipt->purchaseOrder->vendor->nama_vendor ?? '-' }}</p>
                        </div>
                        <div class="rounded-2xl bg-slate-50 p-4">
                            <p class="text-xs text-slate-500 mb-1">Project</p>
                            <p class="font-bold text-slate-900">{{ $goodsReceipt->purchaseOrder->tender->materialRequest->project->nama_project ?? '-' }}</p>
                        </div>
                        <div class="rounded-2xl bg-slate-50 p-4">
                            <p class="text-xs text-slate-500 mb-1">Total Nilai PO</p>
                            <p class="font-bold text-slate-900">Rp {{ number_format($goodsReceipt->purchaseOrder->total_harga, 0, ',', '.') }}</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Daftar Item --}}
            <div class="bg-white rounded-3xl shadow-sm border border-slate-200 overflow-hidden">
                <div class="px-6 py-5 border-b border-slate-200">
                    <h3 class="text-lg font-bold text-slate-900">Daftar Material yang Diterima</h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-slate-50 border-b border-slate-200">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase">Nama Barang</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase">Spesifikasi</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase">Qty Pesan</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase">Satuan</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @forelse($goodsReceipt->purchaseOrder->items as $item)
                                <tr class="hover:bg-slate-50 transition">
                                    <td class="px-6 py-4 text-sm font-bold text-slate-900">{{ $item->nama_barang }}</td>
                                    <td class="px-6 py-4 text-sm text-slate-600">{{ $item->spesifikasi ?? '-' }}</td>
                                    <td class="px-6 py-4 text-sm text-slate-700">{{ $item->qty }}</td>
                                    <td class="px-6 py-4 text-sm text-slate-700">{{ $item->satuan }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-10 text-center text-slate-500 text-sm">Tidak ada item.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- Foto Dokumentasi --}}
            @if($goodsReceipt->photos->count() > 0)
                <div class="bg-white rounded-3xl shadow-sm border border-slate-200 overflow-hidden">
                    <div class="px-6 py-5 border-b border-slate-200">
                        <h3 class="text-lg font-bold text-slate-900">Foto Dokumentasi</h3>
                        <p class="text-sm text-slate-500 mt-0.5">{{ $goodsReceipt->photos->count() }} foto dilampirkan oleh gudang.</p>
                    </div>
                    <div class="p-6 grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                        @foreach($goodsReceipt->photos as $photo)
                            <div class="group relative rounded-2xl overflow-hidden border border-slate-200 bg-slate-50">
                                <a href="{{ Storage::url($photo->file_path) }}" target="_blank">
                                    <img src="{{ Storage::url($photo->file_path) }}"
                                         alt="{{ $photo->keterangan ?? 'Foto penerimaan' }}"
                                         class="w-full h-36 object-cover group-hover:scale-105 transition duration-300">
                                </a>
                                @if($photo->keterangan)
                                    <div class="px-3 py-2">
                                        <p class="text-xs text-slate-600 truncate">{{ $photo->keterangan }}</p>
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

        </div>
    </div>
</x-app-layout>
