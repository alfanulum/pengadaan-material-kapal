<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3">
            <div>
                <h2 class="font-bold text-2xl text-slate-900 leading-tight">
                    Buat Purchase Order
                </h2>
                <p class="text-sm text-slate-500 mt-1">
                    Buat PO berdasarkan tender dan vendor pemenang.
                </p>
            </div>

            <a href="{{ route('supply-chain.tenders.show', $tender->id) }}"
                class="inline-flex items-center justify-center px-5 py-3 bg-slate-100 text-slate-700 rounded-xl font-semibold border border-slate-200 hover:bg-slate-200 transition">
                Kembali ke Detail Tender
            </a>
        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <div
            class="bg-gradient-to-r from-slate-950 via-blue-950 to-blue-800 rounded-3xl p-8 md:p-10 shadow-xl text-white mb-8 overflow-hidden relative">
            <div class="absolute -top-24 -right-24 w-80 h-80 bg-cyan-400/20 rounded-full blur-3xl"></div>
            <div class="absolute -bottom-24 -left-24 w-80 h-80 bg-blue-400/20 rounded-full blur-3xl"></div>

            <div class="relative z-10 flex flex-col lg:flex-row lg:items-end lg:justify-between gap-6">
                <div>
                    <p
                        class="inline-flex px-4 py-2 rounded-full bg-white/10 border border-white/10 text-sm text-blue-100 mb-5">
                        Purchase Order Creation
                    </p>

                    <h3 class="text-3xl md:text-4xl font-bold leading-tight">
                        PO untuk Vendor Terpilih
                    </h3>

                    <p class="mt-4 text-blue-100 max-w-3xl text-base leading-relaxed">
                        Sistem mengambil data tender, vendor pemenang, item material,
                        dan harga penawaran yang sudah disetujui.
                    </p>
                </div>

                <div class="bg-white/10 border border-white/10 rounded-2xl p-5 min-w-[210px]">
                    <p class="text-sm text-blue-100">Total Penawaran</p>
                    <p class="text-2xl font-bold mt-1">
                        Rp {{ number_format($quotation->harga_penawaran, 0, ',', '.') }}
                    </p>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

            <div class="lg:col-span-1 space-y-6">
                <div class="bg-white rounded-3xl shadow-sm border border-slate-200 overflow-hidden">
                    <div class="px-6 py-5 border-b border-slate-200">
                        <h3 class="text-lg font-bold text-slate-900">
                            Informasi Tender
                        </h3>
                    </div>

                    <div class="p-6 space-y-4">
                        <div class="rounded-2xl bg-slate-50 p-4">
                            <p class="text-xs text-slate-500 mb-1">Kode Tender</p>
                            <p class="font-bold text-slate-900">{{ $tender->kode_tender }}</p>
                        </div>

                        <div class="rounded-2xl bg-slate-50 p-4">
                            <p class="text-xs text-slate-500 mb-1">Nama Tender</p>
                            <p class="font-bold text-slate-900">{{ $tender->nama_tender }}</p>
                        </div>

                        <div class="rounded-2xl bg-slate-50 p-4">
                            <p class="text-xs text-slate-500 mb-1">Project</p>
                            <p class="font-bold text-slate-900">
                                {{ $tender->materialRequest->project->nama_project ?? '-' }}
                            </p>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-3xl shadow-sm border border-slate-200 overflow-hidden">
                    <div class="px-6 py-5 border-b border-slate-200">
                        <h3 class="text-lg font-bold text-slate-900">
                            Vendor Terpilih
                        </h3>
                    </div>

                    <div class="p-6 space-y-4">
                        <div class="rounded-2xl bg-green-50 border border-green-100 p-4">
                            <p class="text-xs text-green-700 mb-1">Nama Vendor</p>
                            <p class="font-bold text-slate-900">{{ $quotation->vendor->nama_vendor ?? '-' }}</p>
                        </div>

                        <div class="rounded-2xl bg-slate-50 p-4">
                            <p class="text-xs text-slate-500 mb-1">Email</p>
                            <p class="font-bold text-slate-900">{{ $quotation->vendor->email ?? '-' }}</p>
                        </div>

                        <div class="rounded-2xl bg-slate-50 p-4">
                            <p class="text-xs text-slate-500 mb-1">Estimasi Vendor</p>
                            <p class="font-bold text-slate-900">
                                {{ $quotation->estimasi_pengiriman ?? '-' }} hari
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="lg:col-span-2">
                <div class="bg-white rounded-3xl shadow-sm border border-slate-200 overflow-hidden">
                    <div class="px-6 py-5 border-b border-slate-200">
                        <h3 class="text-lg font-bold text-slate-900">
                            Form Purchase Order
                        </h3>
                        <p class="text-sm text-slate-500 mt-1">
                            Lengkapi tanggal PO, deadline pengiriman, dan catatan untuk vendor.
                        </p>
                    </div>

                    <form action="{{ route('supply-chain.purchase-orders.store') }}" method="POST" class="p-6 md:p-8">
                        @csrf

                        <input type="hidden" name="tender_id" value="{{ $tender->id }}">
                        <input type="hidden" name="vendor_quotation_id" value="{{ $quotation->id }}">

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-2">
                                    Tanggal PO
                                </label>
                                <input type="date" name="tanggal_po"
                                    value="{{ old('tanggal_po', now()->format('Y-m-d')) }}"
                                    class="w-full rounded-xl border-slate-300 focus:border-blue-800 focus:ring-blue-800">
                                @error('tanggal_po')
                                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-2">
                                    Deadline Pengiriman
                                </label>
                                <input type="date" name="deadline_pengiriman"
                                    value="{{ old('deadline_pengiriman') }}"
                                    class="w-full rounded-xl border-slate-300 focus:border-blue-800 focus:ring-blue-800">
                                @error('deadline_pengiriman')
                                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="md:col-span-2">
                                <label class="block text-sm font-semibold text-slate-700 mb-2">
                                    Catatan PO
                                </label>
                                <textarea name="catatan" rows="4"
                                    class="w-full rounded-xl border-slate-300 focus:border-blue-800 focus:ring-blue-800"
                                    placeholder="Contoh: Mohon diproses sesuai spesifikasi dan dikirim sebelum deadline.">{{ old('catatan') }}</textarea>
                            </div>
                        </div>

                        <div class="mt-8 bg-slate-50 rounded-2xl border border-slate-200 overflow-hidden">
                            <div class="px-5 py-4 border-b border-slate-200">
                                <h4 class="font-bold text-slate-900">Item Material PO</h4>
                                <p class="text-sm text-slate-500 mt-1">
                                    Item otomatis diambil dari material request tender.
                                </p>
                            </div>

                            <div class="overflow-x-auto">
                                <table class="w-full">
                                    <thead class="bg-white">
                                        <tr>
                                            <th class="px-5 py-3 text-left text-xs font-bold text-slate-500 uppercase">
                                                Barang</th>
                                            <th class="px-5 py-3 text-left text-xs font-bold text-slate-500 uppercase">
                                                Spesifikasi</th>
                                            <th class="px-5 py-3 text-left text-xs font-bold text-slate-500 uppercase">
                                                Qty</th>
                                            <th class="px-5 py-3 text-left text-xs font-bold text-slate-500 uppercase">
                                                Satuan</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-slate-200">
                                        @foreach ($tender->materialRequest->items as $item)
                                            <tr>
                                                <td class="px-5 py-3 text-sm font-semibold text-slate-900">
                                                    {{ $item->nama_barang }}
                                                </td>
                                                <td class="px-5 py-3 text-sm text-slate-700">
                                                    {{ $item->spesifikasi ?? '-' }}
                                                </td>
                                                <td class="px-5 py-3 text-sm text-slate-700">
                                                    {{ $item->qty }}
                                                </td>
                                                <td class="px-5 py-3 text-sm text-slate-700">
                                                    {{ $item->satuan }}
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="mt-8 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                            <a href="{{ route('supply-chain.tenders.show', $tender->id) }}"
                                class="inline-flex items-center justify-center px-5 py-3 bg-slate-100 text-slate-700 rounded-xl font-semibold hover:bg-slate-200 transition">
                                Kembali
                            </a>

                            <button type="submit"
                                class="inline-flex items-center justify-center px-6 py-3 bg-blue-900 text-white rounded-xl font-semibold shadow-lg hover:bg-blue-950 transition">
                                Buat dan Kirim PO
                            </button>
                        </div>
                    </form>
                </div>
            </div>

        </div>

    </div>
</x-app-layout>
