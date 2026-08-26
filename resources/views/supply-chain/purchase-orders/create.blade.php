<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <h2 class="font-bold text-2xl text-slate-900 leading-tight">
                    Buat Purchase Order
                </h2>
                <p class="text-sm text-slate-500 mt-1">
                    PO untuk Tender: <span class="font-semibold text-slate-700">{{ $tender->kode_tender }}</span>
                </p>
            </div>

            <div class="flex flex-col sm:flex-row sm:items-center gap-3 md:gap-4">
                <div class="bg-white border border-slate-200 shadow-sm rounded-xl py-2 px-4 md:px-5 flex flex-col text-right">
                    <span class="text-[10px] font-bold text-slate-500 uppercase tracking-wider mb-0.5">Total Disetujui</span>
                    <span class="text-xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-slate-900 to-blue-900 leading-none">
                        Rp {{ number_format($quotation->harga_negosiasi ?? $quotation->harga_penawaran, 0, ',', '.') }}
                    </span>
                </div>

                <a href="{{ route('supply-chain.tenders.show', $tender->id) }}" class="inline-flex items-center justify-center gap-2 px-4 py-2 bg-white border border-slate-300 text-slate-700 rounded-xl text-sm font-semibold hover:bg-slate-50 transition shadow-sm h-full max-h-[52px]">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-4 h-4 shrink-0">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" />
                    </svg>
                    Kembali
                </a>
            </div>
        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-12">

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            {{-- Bagian Kiri: Info Tender & Vendor --}}
            <div class="lg:col-span-1 space-y-6">
                {{-- Card Info Tender --}}
                <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
                    <div class="px-6 py-4 border-b border-slate-200 bg-slate-50">
                        <h3 class="text-sm font-bold text-slate-900 uppercase tracking-wide">
                            Informasi Tender
                        </h3>
                    </div>
                    <div class="px-6 py-5">
                        <dl class="space-y-4">
                            <div>
                                <dt class="text-xs font-medium text-slate-500">Kode Tender</dt>
                                <dd class="mt-1 text-sm font-semibold text-slate-900">{{ $tender->kode_tender }}</dd>
                            </div>
                            <div class="pt-4 border-t border-slate-100">
                                <dt class="text-xs font-medium text-slate-500">Nama Tender</dt>
                                <dd class="mt-1 text-sm font-semibold text-slate-900">{{ $tender->nama_tender }}</dd>
                            </div>
                            <div class="pt-4 border-t border-slate-100">
                                <dt class="text-xs font-medium text-slate-500">Project Terkait</dt>
                                <dd class="mt-1 text-sm font-semibold text-slate-900">
                                    {{ $tender->materialRequest->project->nama_project ?? '-' }}
                                </dd>
                            </div>
                        </dl>
                    </div>
                </div>

                {{-- Card Vendor Terpilih --}}
                <div class="bg-white rounded-xl shadow-sm border border-emerald-200 overflow-hidden relative">
                    <div class="absolute top-0 left-0 right-0 h-1 bg-emerald-500"></div>
                    <div class="px-6 py-4 border-b border-slate-100 bg-emerald-50/50 flex items-center gap-3">
                        <div class="w-8 h-8 rounded-full bg-emerald-100 flex items-center justify-center shrink-0">
                            <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                        </div>
                        <h3 class="text-sm font-bold text-emerald-900 uppercase tracking-wide">
                            Vendor Terpilih
                        </h3>
                    </div>
                    <div class="px-6 py-5">
                        <dl class="space-y-4">
                            <div>
                                <dt class="text-xs font-medium text-slate-500">Nama Perusahaan / Vendor</dt>
                                <dd class="mt-1 text-base font-bold text-slate-900">{{ $quotation->vendor->nama_vendor ?? '-' }}</dd>
                            </div>
                            <div class="pt-4 border-t border-slate-100">
                                <dt class="text-xs font-medium text-slate-500">Email Vendor</dt>
                                <dd class="mt-1 text-sm font-medium text-slate-700">{{ $quotation->vendor->email ?? '-' }}</dd>
                            </div>
                            <div class="pt-4 border-t border-slate-100">
                                <dt class="text-xs font-medium text-slate-500">Estimasi Pengiriman (Janji Vendor)</dt>
                                <dd class="mt-1 text-sm font-semibold text-emerald-700">
                                    {{ $quotation->estimasi_pengiriman ?? '-' }} hari kerja
                                </dd>
                            </div>
                        </dl>
                    </div>
                </div>
            </div>

            {{-- Bagian Kanan: Form PO --}}
            <div class="lg:col-span-2">
                <form action="{{ route('supply-chain.purchase-orders.store') }}" method="POST" class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden flex flex-col h-full">
                    @csrf
                    <input type="hidden" name="tender_id" value="{{ $tender->id }}">
                    <input type="hidden" name="vendor_quotation_id" value="{{ $quotation->id }}">

                    <div class="px-6 py-5 border-b border-slate-200 bg-slate-50/50">
                        <h3 class="text-base font-bold leading-6 text-slate-900">
                            Form Purchase Order
                        </h3>
                        <p class="text-sm text-slate-500 mt-1">
                            Lengkapi tanggal dan catatan untuk Purchase Order ini.
                        </p>
                    </div>

                    <div class="px-6 py-6 sm:p-8 flex-1">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-6 mb-8">
                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-2">Tanggal PO</label>
                                <input type="date" name="tanggal_po" value="{{ old('tanggal_po', now()->format('Y-m-d')) }}"
                                    class="block w-full rounded-lg border-0 py-2.5 text-slate-900 shadow-sm ring-1 ring-inset ring-slate-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6 transition-shadow">
                                @error('tanggal_po')
                                    <p class="text-rose-600 text-sm mt-1 font-medium">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-2">Deadline Pengiriman</label>
                                <input type="date" name="deadline_pengiriman" value="{{ old('deadline_pengiriman') }}"
                                    class="block w-full rounded-lg border-0 py-2.5 text-slate-900 shadow-sm ring-1 ring-inset ring-slate-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6 transition-shadow">
                                @error('deadline_pengiriman')
                                    <p class="text-rose-600 text-sm mt-1 font-medium">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="md:col-span-2">
                                <label class="block text-sm font-semibold text-slate-700 mb-2">Catatan Khusus PO</label>
                                <textarea name="catatan" rows="3"
                                    class="block w-full rounded-lg border-0 py-2.5 text-slate-900 shadow-sm ring-1 ring-inset ring-slate-300 placeholder:text-slate-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6 transition-shadow"
                                    placeholder="Instruksi tambahan untuk vendor terkait pengiriman atau packing...">{{ old('catatan') }}</textarea>
                            </div>
                        </div>

                        {{-- Tabel Item PO --}}
                        <div>
                            <div class="flex items-center justify-between mb-3">
                                <h4 class="text-sm font-bold text-slate-900">Rincian Material</h4>
                                <span class="text-xs text-slate-500">Berdasarkan Material Request</span>
                            </div>
                            <div class="border border-slate-200 rounded-lg overflow-hidden">
                                <table class="min-w-full divide-y divide-slate-200">
                                    <thead class="bg-slate-50">
                                        <tr>
                                            <th scope="col" class="px-4 py-3 text-left text-xs font-semibold text-slate-600 uppercase tracking-wider">Item Barang</th>
                                            <th scope="col" class="px-4 py-3 text-left text-xs font-semibold text-slate-600 uppercase tracking-wider">Spesifikasi</th>
                                            <th scope="col" class="px-4 py-3 text-right text-xs font-semibold text-slate-600 uppercase tracking-wider">Kuantitas</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-slate-200">
                                        @foreach ($tender->materialRequest->items as $item)
                                            <tr class="hover:bg-slate-50 transition-colors">
                                                <td class="px-4 py-3 text-sm font-medium text-slate-900">
                                                    {{ $item->nama_barang }}
                                                </td>
                                                <td class="px-4 py-3 text-sm text-slate-600">
                                                    {{ $item->spesifikasi ?? '-' }}
                                                </td>
                                                <td class="px-4 py-3 text-sm font-semibold text-slate-700 text-right">
                                                    {{ $item->qty }} <span class="text-slate-500 font-normal ml-1">{{ $item->satuan }}</span>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="px-6 py-4 border-t border-slate-200 bg-slate-50 flex flex-col-reverse sm:flex-row sm:items-center sm:justify-end gap-3">
                        <a href="{{ route('supply-chain.tenders.show', $tender->id) }}"
                            class="inline-flex items-center justify-center px-5 py-2.5 bg-white border border-slate-300 text-slate-700 rounded-lg text-sm font-semibold hover:bg-slate-50 transition shadow-sm">
                            Batal
                        </a>
                        <button type="submit"
                            class="inline-flex items-center justify-center px-6 py-2.5 bg-gradient-to-r from-slate-900 to-blue-900 text-white rounded-lg text-sm font-semibold shadow-md hover:from-slate-800 hover:to-blue-800 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-slate-900 transition-all">
                            Buat & Kirim Purchase Order
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
