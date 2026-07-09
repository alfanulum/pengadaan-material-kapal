<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3">
            <div>
                <div class="flex items-center gap-2 text-sm text-slate-500 mb-1">
                    <a href="{{ route('supply-chain.dashboard') }}" class="hover:text-blue-700 transition">Dashboard</a>
                    <span>/</span>
                    <a href="{{ route('supply-chain.monitoring.index') }}" class="hover:text-blue-700 transition">Monitoring</a>
                    <span>/</span>
                    <span class="text-slate-900 font-semibold">Edit</span>
                </div>
                <h2 class="font-bold text-2xl text-slate-900 leading-tight">
                    Edit Monitoring Pengadaan
                </h2>
                <p class="text-sm text-slate-500 mt-1">
                    PO <span class="font-bold text-blue-700">{{ $po->kode_po }}</span>
                </p>
            </div>
            <a href="{{ route('supply-chain.monitoring.show', $po->id) }}"
                class="inline-flex items-center gap-2 px-5 py-2.5 bg-slate-100 text-slate-700 rounded-xl font-semibold border border-slate-200 hover:bg-slate-200 transition text-sm">
                ← Batal
            </a>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">

            <div class="bg-white rounded-3xl shadow-sm border border-slate-200 overflow-hidden">
                <div class="px-6 py-5 border-b border-slate-200 bg-slate-50">
                    <h3 class="text-lg font-bold text-slate-900">Form Koreksi Tanggal Monitoring</h3>
                    <p class="text-sm text-slate-500 mt-1">Gunakan form ini untuk memperbaiki tanggal jika terdapat kesalahan input dari vendor atau gudang.</p>
                </div>

                <form action="{{ route('supply-chain.monitoring.update', $po->id) }}" method="POST" class="p-6 md:p-8 space-y-6">
                    @csrf
                    @method('PUT')

                    <div>
                        <label for="tanggal_pengiriman" class="block text-sm font-bold text-slate-700 mb-2">Tanggal Barang Dikirim (Oleh Vendor)</label>
                        <input type="date" id="tanggal_pengiriman" name="tanggal_pengiriman" 
                            class="w-full rounded-xl border-slate-200 focus:border-blue-500 focus:ring-blue-500"
                            value="{{ $po->tanggal_pengiriman ? \Carbon\Carbon::parse($po->tanggal_pengiriman)->format('Y-m-d') : '' }}"
                            {{ in_array($po->status, ['dikirim', 'selesai', 'diterima_gudang']) ? '' : 'readonly' }}>
                        @if(!in_array($po->status, ['dikirim', 'selesai', 'diterima_gudang']))
                            <p class="text-xs text-amber-600 mt-1">Hanya bisa diisi jika vendor sudah memproses pengiriman.</p>
                        @endif
                        @error('tanggal_pengiriman') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="tanggal_diterima" class="block text-sm font-bold text-slate-700 mb-2">Tanggal Diterima (Oleh Gudang)</label>
                        <input type="date" id="tanggal_diterima" name="tanggal_diterima" 
                            class="w-full rounded-xl border-slate-200 focus:border-blue-500 focus:ring-blue-500"
                            value="{{ $po->goodsReceipt ? \Carbon\Carbon::parse($po->goodsReceipt->tanggal_diterima)->format('Y-m-d') : '' }}"
                            {{ $po->goodsReceipt ? '' : 'readonly' }}>
                        @if(!$po->goodsReceipt)
                            <p class="text-xs text-amber-600 mt-1">Hanya bisa diisi jika gudang sudah membuat laporan penerimaan.</p>
                        @endif
                        @error('tanggal_diterima') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="pt-4 border-t border-slate-100 flex justify-end gap-3">
                        <button type="submit" class="px-6 py-2.5 bg-blue-900 text-white rounded-xl font-semibold hover:bg-blue-950 transition">
                            Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</x-app-layout>
