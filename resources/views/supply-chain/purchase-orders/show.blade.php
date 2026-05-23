<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3">
            <div>
                <h2 class="font-bold text-2xl text-slate-900 leading-tight">
                    Detail Purchase Order
                </h2>
                <p class="text-sm text-slate-500 mt-1">
                    Detail PO yang dikirim kepada vendor terpilih.
                </p>
            </div>

            <div class="flex flex-col sm:flex-row gap-3">
                <a href="{{ route('supply-chain.purchase-orders.index') }}"
                    class="inline-flex items-center justify-center px-5 py-3 bg-slate-100 text-slate-700 rounded-xl font-semibold border border-slate-200 hover:bg-slate-200 transition">
                    Daftar PO
                </a>

                <a href="{{ route('supply-chain.dashboard') }}"
                    class="inline-flex items-center justify-center px-5 py-3 bg-slate-900 text-white rounded-xl font-semibold hover:bg-slate-800 transition">
                    Dashboard
                </a>
            </div>
        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        @if (session('success'))
            <div class="mb-6 p-4 bg-green-50 border border-green-200 text-green-700 rounded-2xl">
                {{ session('success') }}
            </div>
        @endif

        <div
            class="bg-gradient-to-r from-slate-950 via-blue-950 to-blue-800 rounded-3xl p-8 md:p-10 shadow-xl text-white mb-8 overflow-hidden relative">
            <div class="absolute -top-24 -right-24 w-80 h-80 bg-cyan-400/20 rounded-full blur-3xl"></div>
            <div class="absolute -bottom-24 -left-24 w-80 h-80 bg-blue-400/20 rounded-full blur-3xl"></div>

            <div class="relative z-10 flex flex-col lg:flex-row lg:items-end lg:justify-between gap-6">
                <div>
                    <p
                        class="inline-flex px-4 py-2 rounded-full bg-white/10 border border-white/10 text-sm text-blue-100 mb-5">
                        {{ $purchaseOrder->kode_po }}
                    </p>

                    <h3 class="text-3xl md:text-4xl font-bold leading-tight">
                        Purchase Order Vendor
                    </h3>

                    <p class="mt-4 text-blue-100 max-w-3xl text-base leading-relaxed">
                        PO dibuat berdasarkan tender yang telah memiliki vendor pemenang
                        dan dikirim kepada vendor untuk proses pengadaan material.
                    </p>
                </div>

                <div class="bg-white/10 border border-white/10 rounded-2xl p-5 min-w-[210px]">
                    <p class="text-sm text-blue-100">Total PO</p>
                    <p class="text-2xl font-bold mt-1">
                        Rp {{ number_format($purchaseOrder->total_harga, 0, ',', '.') }}
                    </p>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

            <div class="lg:col-span-2 space-y-8">
                <div class="bg-white rounded-3xl shadow-sm border border-slate-200 overflow-hidden">
                    <div class="px-6 py-5 border-b border-slate-200">
                        <h3 class="text-lg font-bold text-slate-900">
                            Informasi Purchase Order
                        </h3>
                    </div>

                    <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div class="rounded-2xl bg-slate-50 p-4">
                            <p class="text-xs text-slate-500 mb-1">Kode PO</p>
                            <p class="font-bold text-slate-900">{{ $purchaseOrder->kode_po }}</p>
                        </div>

                        <div class="rounded-2xl bg-slate-50 p-4">
                            <p class="text-xs text-slate-500 mb-1">Kode Tender</p>
                            <p class="font-bold text-slate-900">{{ $purchaseOrder->tender->kode_tender ?? '-' }}</p>
                        </div>

                        <div class="rounded-2xl bg-slate-50 p-4">
                            <p class="text-xs text-slate-500 mb-1">Vendor</p>
                            <p class="font-bold text-slate-900">{{ $purchaseOrder->vendor->nama_vendor ?? '-' }}</p>
                        </div>

                        <div class="rounded-2xl bg-slate-50 p-4">
                            <p class="text-xs text-slate-500 mb-1">Project</p>
                            <p class="font-bold text-slate-900">
                                {{ $purchaseOrder->tender->materialRequest->project->nama_project ?? '-' }}
                            </p>
                        </div>

                        <div class="rounded-2xl bg-slate-50 p-4">
                            <p class="text-xs text-slate-500 mb-1">Tanggal PO</p>
                            <p class="font-bold text-slate-900">
                                {{ \Carbon\Carbon::parse($purchaseOrder->tanggal_po)->format('d-m-Y') }}
                            </p>
                        </div>

                        <div class="rounded-2xl bg-slate-50 p-4">
                            <p class="text-xs text-slate-500 mb-1">Deadline Pengiriman</p>
                            <p class="font-bold text-slate-900">
                                {{ $purchaseOrder->deadline_pengiriman ? \Carbon\Carbon::parse($purchaseOrder->deadline_pengiriman)->format('d-m-Y') : '-' }}
                            </p>
                        </div>

                        <div class="rounded-2xl bg-slate-50 p-4">
                            <p class="text-xs text-slate-500 mb-1">Status</p>
                            <p class="font-bold text-slate-900 capitalize">
                                {{ str_replace('_', ' ', $purchaseOrder->status) }}
                            </p>
                        </div>

                        <div class="rounded-2xl bg-slate-50 p-4">
                            <p class="text-xs text-slate-500 mb-1">Total Harga</p>
                            <p class="font-bold text-slate-900">
                                Rp {{ number_format($purchaseOrder->total_harga, 0, ',', '.') }}
                            </p>
                        </div>

                        <div class="rounded-2xl bg-slate-50 p-4 md:col-span-2">
                            <p class="text-xs text-slate-500 mb-1">Catatan</p>
                            <p class="font-medium text-slate-900">
                                {{ $purchaseOrder->catatan ?? '-' }}
                            </p>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-3xl shadow-sm border border-slate-200 overflow-hidden">
                    <div class="px-6 py-5 border-b border-slate-200">
                        <h3 class="text-lg font-bold text-slate-900">
                            Item Purchase Order
                        </h3>
                        <p class="text-sm text-slate-500 mt-1">
                            Daftar material yang masuk dalam PO.
                        </p>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead class="bg-slate-50 border-b border-slate-200">
                                <tr>
                                    <th class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase">Barang
                                    </th>
                                    <th class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase">
                                        Spesifikasi</th>
                                    <th class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase">Qty</th>
                                    <th class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase">Satuan
                                    </th>
                                </tr>
                            </thead>

                            <tbody class="divide-y divide-slate-100">
                                @forelse ($purchaseOrder->items as $item)
                                    <tr class="hover:bg-slate-50 transition">
                                        <td class="px-6 py-4 text-sm font-bold text-slate-900">
                                            {{ $item->nama_barang }}
                                        </td>
                                        <td class="px-6 py-4 text-sm text-slate-700">
                                            {{ $item->spesifikasi ?? '-' }}
                                        </td>
                                        <td class="px-6 py-4 text-sm text-slate-700">
                                            {{ $item->qty }}
                                        </td>
                                        <td class="px-6 py-4 text-sm text-slate-700">
                                            {{ $item->satuan }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="px-6 py-12 text-center text-slate-500">
                                            Belum ada item PO.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="lg:col-span-1 space-y-6">
                <div class="bg-white rounded-3xl shadow-sm border border-slate-200 p-6">
                    <h3 class="text-lg font-bold text-slate-900">
                        Vendor Penerima PO
                    </h3>

                    <div class="mt-5 space-y-4">
                        <div>
                            <p class="text-xs text-slate-500">Nama Vendor</p>
                            <p class="font-bold text-slate-900">{{ $purchaseOrder->vendor->nama_vendor ?? '-' }}</p>
                        </div>

                        <div>
                            <p class="text-xs text-slate-500">Email</p>
                            <p class="font-bold text-slate-900">{{ $purchaseOrder->vendor->email ?? '-' }}</p>
                        </div>

                        <div>
                            <p class="text-xs text-slate-500">PIC</p>
                            <p class="font-bold text-slate-900">{{ $purchaseOrder->vendor->pic ?? '-' }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-3xl shadow-sm border border-slate-200 p-6">
                    <div class="space-y-3">
                        <a href="{{ route('supply-chain.purchase-orders.index') }}"
                            class="w-full inline-flex items-center justify-center px-5 py-3 bg-slate-100 text-slate-700 rounded-xl font-semibold hover:bg-slate-200 transition">
                            Kembali ke Daftar PO
                        </a>

                        <a href="{{ route('supply-chain.tenders.show', $purchaseOrder->tender_id) }}"
                            class="w-full inline-flex items-center justify-center px-5 py-3 bg-blue-900 text-white rounded-xl font-semibold hover:bg-blue-950 transition">
                            Detail Tender
                        </a>
                    </div>
                </div>
            </div>

        </div>

    </div>
</x-app-layout>
