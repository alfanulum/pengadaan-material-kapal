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
                class="inline-flex items-center justify-center px-5 py-3 bg-slate-100 text-slate-700 rounded-xl font-semibold border border-slate-200 hover:bg-slate-200 transition">
                Kembali ke Detail Pengajuan
            </a>
        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        {{-- Hero --}}
        <div
            class="bg-gradient-to-r from-slate-950 via-blue-950 to-blue-800 rounded-3xl p-8 md:p-10 shadow-xl text-white mb-8 overflow-hidden relative">
            <div class="absolute -top-24 -right-24 w-80 h-80 bg-cyan-400/20 rounded-full blur-3xl"></div>
            <div class="absolute -bottom-24 -left-24 w-80 h-80 bg-blue-400/20 rounded-full blur-3xl"></div>

            <div class="relative z-10 flex flex-col lg:flex-row lg:items-end lg:justify-between gap-6">
                <div>
                    <p
                        class="inline-flex px-4 py-2 rounded-full bg-white/10 border border-white/10 text-sm text-blue-100 mb-5">
                        Tender Creation
                    </p>

                    <h3 class="text-3xl md:text-4xl font-bold leading-tight">
                        Buat Undangan Tender Vendor
                    </h3>

                    <p class="mt-4 text-blue-100 max-w-3xl text-base leading-relaxed">
                        Lengkapi informasi tender, tentukan deadline penawaran,
                        dan pilih vendor aktif yang akan menerima undangan tender.
                    </p>
                </div>

                <div class="bg-white/10 border border-white/10 rounded-2xl p-5 min-w-[190px]">
                    <p class="text-sm text-blue-100">Vendor Aktif</p>
                    <p class="text-3xl font-bold mt-1">{{ $vendors->count() }}</p>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

            {{-- Kiri --}}
            <div class="lg:col-span-1 space-y-6">

                {{-- Informasi Pengajuan --}}
                <div class="bg-white rounded-3xl shadow-sm border border-slate-200 overflow-hidden">
                    <div class="px-6 py-5 border-b border-slate-200">
                        <h3 class="text-lg font-bold text-slate-900">
                            Informasi Pengajuan
                        </h3>
                        <p class="text-sm text-slate-500 mt-1">
                            Data pengajuan yang menjadi dasar tender.
                        </p>
                    </div>

                    <div class="p-6 space-y-4">
                        <div class="rounded-2xl bg-slate-50 p-4">
                            <p class="text-xs text-slate-500 mb-1">Kode Pengajuan</p>
                            <p class="font-bold text-slate-900">
                                {{ $materialRequest->kode_pengajuan ?? 'REQ-' . str_pad($materialRequest->id, 4, '0', STR_PAD_LEFT) }}
                            </p>
                        </div>

                        <div class="rounded-2xl bg-slate-50 p-4">
                            <p class="text-xs text-slate-500 mb-1">Project</p>
                            <p class="font-bold text-slate-900">
                                {{ $materialRequest->project->nama_project ?? '-' }}
                            </p>
                        </div>

                        <div class="rounded-2xl bg-slate-50 p-4">
                            <p class="text-xs text-slate-500 mb-1">Engineer</p>
                            <p class="font-bold text-slate-900">
                                {{ $materialRequest->user->name ?? '-' }}
                            </p>
                        </div>

                        <div class="rounded-2xl bg-slate-50 p-4">
                            <p class="text-xs text-slate-500 mb-1">Status</p>
                            <p class="font-bold text-slate-900 capitalize">
                                {{ str_replace('_', ' ', $materialRequest->status) }}
                            </p>
                        </div>
                    </div>
                </div>

                {{-- Alur --}}
                <div
                    class="bg-gradient-to-r from-slate-950 via-blue-950 to-blue-800 rounded-3xl shadow-xl text-white p-6">
                    <h3 class="text-lg font-bold">
                        Alur Tender
                    </h3>

                    <div class="mt-5 space-y-4">
                        <div class="flex gap-3">
                            <span
                                class="w-8 h-8 rounded-xl bg-white text-blue-950 flex items-center justify-center text-xs font-bold shrink-0">
                                1
                            </span>
                            <div>
                                <p class="font-semibold text-sm">Isi Tender</p>
                                <p class="text-xs text-blue-100 mt-1">Tentukan nama, deadline, dan catatan.</p>
                            </div>
                        </div>

                        <div class="flex gap-3">
                            <span
                                class="w-8 h-8 rounded-xl bg-white text-blue-950 flex items-center justify-center text-xs font-bold shrink-0">
                                2
                            </span>
                            <div>
                                <p class="font-semibold text-sm">Pilih Vendor</p>
                                <p class="text-xs text-blue-100 mt-1">Vendor aktif akan menerima undangan tender.</p>
                            </div>
                        </div>

                        <div class="flex gap-3">
                            <span
                                class="w-8 h-8 rounded-xl bg-white text-blue-950 flex items-center justify-center text-xs font-bold shrink-0">
                                3
                            </span>
                            <div>
                                <p class="font-semibold text-sm">Kirim Tender</p>
                                <p class="text-xs text-blue-100 mt-1">Vendor dapat melihat tender di portal vendor.</p>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            {{-- Form --}}
            <div class="lg:col-span-2">
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
                                class="inline-flex items-center justify-center px-6 py-3 bg-blue-900 text-white rounded-xl font-semibold shadow-lg hover:bg-blue-950 transition">
                                Kirim Tender ke Vendor
                            </button>
                        </div>
                    </form>
                </div>
            </div>

        </div>

    </div>
</x-app-layout>
