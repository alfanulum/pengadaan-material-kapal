<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3">
            <div>
                <h2 class="font-bold text-2xl text-slate-900 leading-tight">
                    Buat Tender
                </h2>
                <p class="text-sm text-slate-500 mt-1">
                    Buat tender dari permintaan material yang telah disetujui Planner.
                </p>
            </div>

            
            <a href="{{ route('supply-chain.material-requests.show', $materialRequest->id) }}"
                class="inline-flex items-center gap-2 px-5 py-2.5 bg-white border border-slate-200 hover:bg-slate-50 text-slate-700 rounded-xl text-sm font-semibold shadow-sm transition hover:-translate-y-0.5">
                <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                <span>Kembali</span>
            </a>
        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        {{-- Hero --}}
        

        <div class="max-w-4xl mx-auto">

            
            {{-- Form --}}
                <div class="bg-white rounded-3xl shadow-sm border border-slate-200 overflow-hidden">
                    <div class="px-6 py-5 border-b border-slate-200">
                        <h3 class="text-lg font-bold text-slate-900">
                            Form Tender
                        </h3>
                        <p class="text-sm text-slate-500 mt-1">
                            Masukkan detail tender dan pilih vendor yang diundang.
                        </p>
                    </div>

                    <form action="{{ route('supply-chain.tenders.store') }}" method="POST" class="p-6 md:p-8">
                        @csrf

                        <input type="hidden" name="material_request_id" value="{{ $materialRequest->id }}">

                        {{-- Kirim tender_induk_id jika ini adalah proses Tender Ulang (dari session) --}}
                        @if (session('tender_induk_id'))
                            <input type="hidden" name="tender_induk_id" value="{{ session('tender_induk_id') }}">
                            <div class="mb-5 p-4 bg-amber-50 border border-amber-200 rounded-2xl">
                                <p class="text-sm font-semibold text-amber-900">⚠ Tender Ulang</p>
                                <p class="text-xs text-amber-700 mt-1">
                                    Anda sedang membuat Tender baru sebagai pengganti tender sebelumnya yang vendornya
                                    mengundurkan diri. Tender dan Purchase Order lama tetap tersimpan sebagai histori.
                                </p>
                            </div>
                        @endif

                        <div class="space-y-5">
                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-2">
                                    Nama Tender
                                </label>

                                <input type="text" name="nama_tender"
                                    value="{{ old('nama_tender', 'Tender Pengadaan Material ' . ($materialRequest->kode_pengajuan ?? 'REQ-' . str_pad($materialRequest->id, 4, '0', STR_PAD_LEFT))) }}"
                                    class="w-full rounded-xl border-slate-300 focus:border-blue-800 focus:ring-blue-800"
                                    placeholder="Contoh: Tender Pengadaan Material REQ-0001">

                                @error('nama_tender')
                                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-2">
                                    Deadline Penawaran
                                </label>

                                <input type="date" name="deadline" value="{{ old('deadline') }}"
                                    class="w-full rounded-xl border-slate-300 focus:border-blue-800 focus:ring-blue-800">

                                @error('deadline')
                                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-2">
                                    Catatan Tender
                                </label>

                                <textarea name="catatan" rows="4"
                                    class="w-full rounded-xl border-slate-300 focus:border-blue-800 focus:ring-blue-800"
                                    placeholder="Contoh: Mohon lampirkan quotation dan estimasi pengiriman.">{{ old('catatan') }}</textarea>

                                @error('catatan')
                                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-2 mb-3">
                                    <div>
                                        <label class="block text-sm font-semibold text-slate-700">
                                            Pilih Vendor yang Diundang
                                        </label>
                                        <p class="text-xs text-slate-500 mt-1">
                                            Pilih minimal satu vendor aktif untuk menerima undangan tender.
                                        </p>
                                    </div>

                                    <span
                                        class="inline-flex px-3 py-1 rounded-full bg-blue-50 text-blue-700 text-xs font-bold">
                                        {{ $vendors->count() }} Vendor Aktif
                                    </span>
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 max-h-[430px] overflow-y-auto pr-1">
                                    @forelse ($vendors as $vendor)
                                        <label
                                            class="group flex items-start gap-3 p-4 border border-slate-200 rounded-2xl hover:border-blue-300 hover:bg-blue-50/40 transition cursor-pointer">
                                            <input type="checkbox" name="vendor_ids[]" value="{{ $vendor->id }}"
                                                {{ in_array($vendor->id, old('vendor_ids', [])) ? 'checked' : '' }}
                                                class="mt-1 rounded border-slate-300 text-blue-900 focus:ring-blue-800">

                                            <span class="block">
                                                <span class="block font-bold text-slate-900 group-hover:text-blue-900">
                                                    {{ $vendor->nama_vendor }}
                                                </span>

                                                <span class="block text-xs text-slate-500 mt-1">
                                                    {{ $vendor->email ?? '-' }}
                                                </span>

                                                <span class="block text-xs text-slate-400 mt-1">
                                                    {{ $vendor->kategori ?? 'Kategori belum diisi' }}
                                                </span>
                                            </span>
                                        </label>
                                    @empty
                                        <div
                                            class="md:col-span-2 p-6 rounded-2xl bg-slate-50 border border-slate-200 text-center">
                                            <p class="font-bold text-slate-900">
                                                Belum Ada Vendor Aktif
                                            </p>
                                            <p class="text-sm text-slate-500 mt-2">
                                                Tambahkan vendor aktif terlebih dahulu sebelum membuat tender.
                                            </p>
                                        </div>
                                    @endforelse
                                </div>

                                @error('vendor_ids')
                                    <p class="text-red-600 text-sm mt-2">{{ $message }}</p>
                                @enderror

                                @error('vendor_ids.*')
                                    <p class="text-red-600 text-sm mt-2">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="mt-8 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                            <a href="{{ route('supply-chain.material-requests.show', $materialRequest->id) }}"
                                class="inline-flex items-center justify-center px-5 py-3 bg-slate-100 text-slate-700 rounded-xl font-semibold hover:bg-slate-200 transition">
                                Kembali
                            </a>

                            <button type="submit"
                                class="inline-flex items-center justify-center px-6 py-3 bg-gradient-to-r from-slate-900 to-blue-900 text-white rounded-xl font-semibold shadow-lg hover:from-slate-800 hover:to-blue-800 hover:shadow-lg transition">
                                Kirim Tender ke Vendor
                            </button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
</x-app-layout>
