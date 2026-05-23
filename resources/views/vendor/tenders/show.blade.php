<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3">
            <div>
                <h2 class="font-bold text-2xl text-slate-900 leading-tight">
                    Detail Tender
                </h2>
                <p class="text-sm text-slate-500 mt-1">
                    Detail kebutuhan material, informasi tender, dan penawaran vendor.
                </p>
            </div>

            <div class="flex flex-col sm:flex-row gap-3">
                <a href="{{ route('vendor.dashboard') }}"
                    class="inline-flex items-center justify-center px-5 py-3 bg-slate-100 text-slate-700 rounded-xl font-semibold border border-slate-200 hover:bg-slate-200 transition">
                    Dashboard
                </a>

                <a href="{{ route('vendor.tenders.index') }}"
                    class="inline-flex items-center justify-center px-5 py-3 bg-slate-900 text-white rounded-xl font-semibold hover:bg-slate-800 transition">
                    Tender Masuk
                </a>
            </div>
        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        @if (session('success'))
            <div class="mb-6 bg-green-50 border border-green-200 text-green-700 p-4 rounded-2xl">
                {{ session('success') }}
            </div>
        @endif

        {{-- Hero --}}
        <div
            class="bg-gradient-to-r from-slate-950 via-blue-950 to-blue-800 rounded-3xl p-8 md:p-10 shadow-xl text-white mb-8 overflow-hidden relative">
            <div class="absolute -top-24 -right-24 w-80 h-80 bg-cyan-400/20 rounded-full blur-3xl"></div>
            <div class="absolute -bottom-24 -left-24 w-80 h-80 bg-blue-400/20 rounded-full blur-3xl"></div>

            <div class="relative z-10 flex flex-col lg:flex-row lg:items-end lg:justify-between gap-6">
                <div>
                    <p
                        class="inline-flex px-4 py-2 rounded-full bg-white/10 border border-white/10 text-sm text-blue-100 mb-5">
                        {{ $invitation->tender->kode_tender }}
                    </p>

                    <h3 class="text-3xl md:text-4xl font-bold leading-tight">
                        {{ $invitation->tender->nama_tender }}
                    </h3>

                    <p class="mt-4 text-blue-100 max-w-3xl text-base leading-relaxed">
                        Periksa detail tender, material yang dibutuhkan, deadline penawaran,
                        dan catatan dari Supply Chain sebelum mengirimkan penawaran.
                    </p>
                </div>

                <div>
                    @if ($invitation->status == 'dikirim')
                        <span
                            class="inline-flex px-4 py-2 rounded-full bg-yellow-100 text-yellow-800 text-sm font-bold">
                            Dikirim
                        </span>
                    @elseif ($invitation->status == 'dibaca')
                        <span class="inline-flex px-4 py-2 rounded-full bg-blue-100 text-blue-800 text-sm font-bold">
                            Dibaca
                        </span>
                    @elseif ($invitation->status == 'ditawar')
                        <span class="inline-flex px-4 py-2 rounded-full bg-green-100 text-green-800 text-sm font-bold">
                            Ditawar
                        </span>
                    @elseif ($invitation->status == 'terpilih')
                        <span
                            class="inline-flex px-4 py-2 rounded-full bg-emerald-100 text-emerald-800 text-sm font-bold">
                            Terpilih
                        </span>
                    @elseif ($invitation->status == 'tidak_terpilih')
                        <span class="inline-flex px-4 py-2 rounded-full bg-red-100 text-red-800 text-sm font-bold">
                            Tidak Terpilih
                        </span>
                    @else
                        <span class="inline-flex px-4 py-2 rounded-full bg-slate-100 text-slate-800 text-sm font-bold">
                            {{ str_replace('_', ' ', $invitation->status) }}
                        </span>
                    @endif
                </div>
            </div>
        </div>

        @if ($invitation->status == 'terpilih')
            <div class="mb-8 bg-green-50 border border-green-200 rounded-3xl p-6 text-green-800">
                <h3 class="text-xl font-bold">
                    Selamat, Vendor Terpilih
                </h3>
                <p class="text-sm mt-2">
                    Penawaran vendor telah dipilih oleh Supply Chain sebagai pemenang tender.
                    Tahap berikutnya akan dilanjutkan ke proses Purchase Order.
                </p>
            </div>
        @elseif ($invitation->status == 'tidak_terpilih')
            <div class="mb-8 bg-red-50 border border-red-200 rounded-3xl p-6 text-red-800">
                <h3 class="text-xl font-bold">
                    Vendor Tidak Terpilih
                </h3>
                <p class="text-sm mt-2">
                    Penawaran pada tender ini belum dipilih sebagai pemenang.
                    Vendor tetap dapat mengikuti tender lain yang dikirim oleh Supply Chain.
                </p>
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

            {{-- Kiri --}}
            <div class="lg:col-span-2 space-y-8">

                {{-- Informasi Tender --}}
                <div class="bg-white rounded-3xl shadow-sm border border-slate-200 overflow-hidden">
                    <div class="px-6 py-5 border-b border-slate-200">
                        <h3 class="text-lg font-bold text-slate-900">
                            Informasi Tender
                        </h3>
                        <p class="text-sm text-slate-500 mt-1">
                            Informasi utama tender dari Supply Chain.
                        </p>
                    </div>

                    <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div class="rounded-2xl bg-slate-50 p-4">
                            <p class="text-xs text-slate-500 mb-1">Kode Tender</p>
                            <p class="font-bold text-slate-900">{{ $invitation->tender->kode_tender }}</p>
                        </div>

                        <div class="rounded-2xl bg-slate-50 p-4">
                            <p class="text-xs text-slate-500 mb-1">Nama Tender</p>
                            <p class="font-bold text-slate-900">{{ $invitation->tender->nama_tender }}</p>
                        </div>

                        <div class="rounded-2xl bg-slate-50 p-4">
                            <p class="text-xs text-slate-500 mb-1">Project</p>
                            <p class="font-bold text-slate-900">
                                {{ $invitation->tender->materialRequest->project->nama_project ?? '-' }}
                            </p>
                        </div>

                        <div class="rounded-2xl bg-slate-50 p-4">
                            <p class="text-xs text-slate-500 mb-1">Deadline</p>
                            <p class="font-bold text-slate-900">
                                {{ \Carbon\Carbon::parse($invitation->tender->deadline)->format('d-m-Y') }}
                            </p>
                        </div>

                        <div class="rounded-2xl bg-slate-50 p-4 md:col-span-2">
                            <p class="text-xs text-slate-500 mb-1">Catatan Tender</p>
                            <p class="font-medium text-slate-900">
                                {{ $invitation->tender->catatan ?? '-' }}
                            </p>
                        </div>
                    </div>
                </div>

                {{-- Data Material --}}
                <div class="bg-white rounded-3xl shadow-sm border border-slate-200 overflow-hidden">
                    <div class="px-6 py-5 border-b border-slate-200">
                        <h3 class="text-lg font-bold text-slate-900">
                            Data Material
                        </h3>
                        <p class="text-sm text-slate-500 mt-1">
                            Material yang dibutuhkan pada tender ini.
                        </p>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead class="bg-slate-50 border-b border-slate-200">
                                <tr>
                                    <th
                                        class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">
                                        Nama Barang
                                    </th>
                                    <th
                                        class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">
                                        Spesifikasi
                                    </th>
                                    <th
                                        class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">
                                        Qty
                                    </th>
                                    <th
                                        class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">
                                        Satuan
                                    </th>
                                </tr>
                            </thead>

                            <tbody class="divide-y divide-slate-100">
                                @forelse ($invitation->tender->materialRequest->items as $item)
                                    <tr class="hover:bg-slate-50 transition">
                                        <td class="px-6 py-4 text-sm font-semibold text-slate-900">
                                            {{ $item->nama_barang }}
                                        </td>
                                        <td class="px-6 py-4 text-sm text-slate-700">
                                            {{ $item->spesifikasi ?? '-' }}
                                        </td>
                                        <td class="px-6 py-4 text-sm text-slate-700 whitespace-nowrap">
                                            {{ $item->qty }}
                                        </td>
                                        <td class="px-6 py-4 text-sm text-slate-700 whitespace-nowrap">
                                            {{ $item->satuan }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="px-6 py-12 text-center text-slate-500">
                                            Belum ada data material.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>

            {{-- Kanan --}}
            <div class="lg:col-span-1 space-y-8">

                {{-- Informasi Vendor --}}
                <div class="bg-white rounded-3xl shadow-sm border border-slate-200 p-6">
                    <h3 class="text-lg font-bold text-slate-900">
                        Informasi Vendor
                    </h3>

                    <div class="mt-5 space-y-4">
                        <div>
                            <p class="text-xs text-slate-500">Nama Vendor</p>
                            <p class="font-bold text-slate-900">{{ $vendor->nama_vendor }}</p>
                        </div>

                        <div>
                            <p class="text-xs text-slate-500">Email</p>
                            <p class="font-bold text-slate-900">{{ $vendor->email ?? '-' }}</p>
                        </div>

                        <div>
                            <p class="text-xs text-slate-500">PIC</p>
                            <p class="font-bold text-slate-900">{{ $vendor->pic ?? '-' }}</p>
                        </div>

                        <div>
                            <p class="text-xs text-slate-500">Status Undangan</p>
                            <p class="font-bold text-slate-900 capitalize">
                                {{ str_replace('_', ' ', $invitation->status) }}
                            </p>
                        </div>
                    </div>
                </div>

                {{-- Penawaran Vendor --}}
                <div class="bg-white rounded-3xl shadow-sm border border-slate-200 p-6">
                    <h3 class="text-lg font-bold text-slate-900">
                        Penawaran Vendor
                    </h3>

                    <p class="text-sm text-slate-500 mt-2">
                        Masukkan harga penawaran, estimasi pengiriman, dan catatan penawaran untuk tender ini.
                    </p>

                    @php
                        $quotation = \App\Models\VendorQuotation::where('tender_id', $invitation->tender_id)
                            ->where('vendor_id', $vendor->id)
                            ->first();
                    @endphp

                    @if ($quotation)
                        <div class="mt-5 bg-green-50 border border-green-200 text-green-700 rounded-2xl p-4">
                            <p class="font-bold">Penawaran sudah dikirim</p>

                            <p class="text-sm mt-2">
                                Harga: Rp {{ number_format($quotation->harga_penawaran, 0, ',', '.') }}
                            </p>

                            @if ($quotation->estimasi_pengiriman)
                                <p class="text-sm mt-1">
                                    Estimasi: {{ $quotation->estimasi_pengiriman }} hari
                                </p>
                            @endif

                            @if ($quotation->catatan)
                                <p class="text-sm mt-1">
                                    Catatan: {{ $quotation->catatan }}
                                </p>
                            @endif

                            @if ($quotation->file_penawaran)
                                <a href="{{ asset('storage/' . $quotation->file_penawaran) }}" target="_blank"
                                    class="inline-flex mt-3 text-sm font-semibold text-blue-800 hover:text-blue-950">
                                    Lihat File Penawaran
                                </a>
                            @endif
                        </div>
                    @else
                        <form action="{{ route('vendor.tenders.quotation.store', $invitation->id) }}" method="POST"
                            enctype="multipart/form-data" class="mt-5 space-y-4">
                            @csrf

                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-2">
                                    Harga Penawaran
                                </label>
                                <input type="number" name="harga_penawaran"
                                    class="w-full rounded-xl border-slate-300 focus:border-blue-800 focus:ring-blue-800"
                                    placeholder="Contoh: 25000000" value="{{ old('harga_penawaran') }}">
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-2">
                                    Estimasi Pengiriman
                                </label>
                                <input type="number" name="estimasi_pengiriman"
                                    class="w-full rounded-xl border-slate-300 focus:border-blue-800 focus:ring-blue-800"
                                    placeholder="Contoh: 14" value="{{ old('estimasi_pengiriman') }}">
                                <p class="text-xs text-slate-400 mt-1">Isi dalam satuan hari.</p>
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-2">
                                    Catatan Penawaran
                                </label>
                                <textarea name="catatan" rows="4"
                                    class="w-full rounded-xl border-slate-300 focus:border-blue-800 focus:ring-blue-800"
                                    placeholder="Contoh: Harga sudah termasuk pengiriman ke gudang">{{ old('catatan') }}</textarea>
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-2">
                                    Upload File Penawaran
                                </label>
                                <input type="file" name="file_penawaran"
                                    class="w-full rounded-xl border border-slate-300 px-3 py-2 text-sm text-slate-700">
                                <p class="text-xs text-slate-400 mt-1">
                                    Format: PDF, DOC, DOCX, XLS, XLSX. Maksimal 10 MB.
                                </p>
                            </div>

                            <button type="submit"
                                class="w-full inline-flex items-center justify-center px-5 py-3 bg-blue-900 text-white rounded-xl font-semibold hover:bg-blue-950 transition">
                                Kirim Penawaran
                            </button>
                        </form>
                    @endif
                </div>

                {{-- Navigasi --}}
                <div class="bg-white rounded-3xl shadow-sm border border-slate-200 p-6">
                    <div class="space-y-3">
                        <a href="{{ route('vendor.tenders.index') }}"
                            class="w-full inline-flex items-center justify-center px-5 py-3 bg-slate-100 text-slate-700 rounded-xl font-semibold hover:bg-slate-200 transition">
                            Kembali ke Tender Masuk
                        </a>

                        <a href="{{ route('vendor.dashboard') }}"
                            class="w-full inline-flex items-center justify-center px-5 py-3 bg-slate-900 text-white rounded-xl font-semibold hover:bg-slate-800 transition">
                            Kembali ke Dashboard
                        </a>
                    </div>
                </div>

            </div>

        </div>
    </div>
</x-app-layout>
