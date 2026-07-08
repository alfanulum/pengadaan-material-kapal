<x-app-layout>

    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3">

            <div>
                <h2 class="text-2xl font-bold text-slate-900">Detail Tender</h2>
                <p class="text-sm text-slate-500">
                    Informasi lengkap pengadaan material
                </p>
            </div>

            <div class="flex gap-3">
                <a href="{{ route('vendor.dashboard') }}"
                    class="px-5 py-3 rounded-xl bg-slate-100 hover:bg-slate-200 font-semibold">
                    Dashboard
                </a>

                <a href="{{ route('vendor.tenders.index') }}"
                    class="px-5 py-3 rounded-xl bg-slate-900 text-white hover:bg-slate-800 font-semibold">
                    Tender Masuk
                </a>
            </div>

        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto px-4 py-6">

        {{-- HERO --}}
        <div
            class="relative overflow-hidden rounded-3xl bg-gradient-to-r from-slate-950 via-blue-950 to-blue-700 text-white p-8 mb-8">

            <div class="absolute -top-20 -right-20 w-72 h-72 bg-blue-400/20 rounded-full blur-3xl"></div>

            <div class="relative">
                <p class="text-sm text-blue-200">
                    {{ $invitation->tender->kode_tender }}
                </p>

                <h1 class="text-3xl font-bold mt-2">
                    {{ $invitation->tender->nama_tender }}
                </h1>

                <p class="text-blue-100 mt-3 max-w-2xl">
                    Periksa detail material sebelum mengirim penawaran.
                </p>
            </div>

        </div>

        {{-- GRID --}}
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">

            {{-- LEFT SIDE --}}
            <div class="lg:col-span-8 space-y-6">

                {{-- INFORMASI TENDER --}}
                <div class="bg-white rounded-3xl shadow border border-slate-100 p-6">

                    <h3 class="text-xl font-bold mb-5">Informasi Tender</h3>

                    <div class="grid grid-cols-2 gap-4">

                        <div class="bg-slate-50 p-4 rounded-2xl">
                            <p class="text-xs text-slate-500">Kode Tender</p>
                            <p class="font-bold">{{ $invitation->tender->kode_tender }}</p>
                        </div>

                        <div class="bg-slate-50 p-4 rounded-2xl">
                            <p class="text-xs text-slate-500">Nama Tender</p>
                            <p class="font-bold">{{ $invitation->tender->nama_tender }}</p>
                        </div>

                        <div class="bg-slate-50 p-4 rounded-2xl">
                            <p class="text-xs text-slate-500">Project</p>
                            <p class="font-bold">
                                {{ $invitation->tender->materialRequest->project->nama_project }}
                            </p>
                        </div>

                        <div class="bg-slate-50 p-4 rounded-2xl">
                            <p class="text-xs text-slate-500">Deadline</p>
                            <p class="font-bold">
                                {{ \Carbon\Carbon::parse($invitation->tender->deadline)->format('d-m-Y') }}
                            </p>
                        </div>

                        <div class="col-span-2 bg-slate-50 p-4 rounded-2xl">
                            <p class="text-xs text-slate-500">Catatan Tender</p>
                            <p class="font-semibold">
                                {{ $invitation->tender->catatan ?? '-' }}
                            </p>
                        </div>

                    </div>
                </div>

                {{-- DATA MATERIAL --}}
                <div class="bg-white rounded-3xl shadow border border-slate-100 overflow-hidden">

                    <div class="p-6 border-b">
                        <h3 class="text-xl font-bold">Data Material</h3>
                        <p class="text-sm text-slate-500">Spesifikasi barang yang dibutuhkan</p>
                    </div>

                    <table class="w-full text-sm">

                        <thead class="bg-slate-50 text-slate-600">
                            <tr>
                                <th class="p-4 text-left">Barang</th>
                                <th class="p-4 text-left">Spesifikasi</th>
                                <th class="p-4 text-left">Qty</th>
                                <th class="p-4 text-left">Satuan</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($invitation->tender->materialRequest->items as $item)
                                <tr class="border-t hover:bg-slate-50">
                                    <td class="p-4 font-semibold">{{ $item->nama_barang }}</td>
                                    <td class="p-4 text-slate-600">{{ $item->spesifikasi }}</td>
                                    <td class="p-4">{{ $item->qty }}</td>
                                    <td class="p-4">{{ $item->satuan }}</td>
                                </tr>
                            @endforeach
                        </tbody>

                    </table>
                </div>

            </div>

            {{-- RIGHT SIDE --}}
            <div class="lg:col-span-4 space-y-6">

                {{-- VENDOR INFO --}}
                <div class="bg-white rounded-3xl shadow border border-slate-100 p-6">

                    <h3 class="text-xl font-bold mb-5">Informasi Vendor</h3>

                    <div class="space-y-4">

                        <div>
                            <p class="text-xs text-slate-500">Nama Vendor</p>
                            <p class="text-lg font-bold text-slate-900">
                                {{ $vendor->nama_vendor }}
                            </p>
                        </div>

                        <div>
                            <p class="text-xs text-slate-500">Email</p>
                            <p class="text-lg font-semibold text-slate-800">
                                {{ $vendor->email }}
                            </p>
                        </div>

                        <div>
                            <p class="text-xs text-slate-500">PIC</p>
                            <p class="text-lg font-semibold text-slate-800">
                                {{ $vendor->pic }}
                            </p>
                        </div>

                    </div>

                </div>

                {{-- CHAT --}}
                <div class="bg-white rounded-3xl shadow border border-slate-100 p-6 space-y-3">

                    <a href="{{ route('vendor.tenders.chat', $invitation->id) }}"
                        class="block text-center bg-cyan-100 text-cyan-800 py-3 rounded-2xl font-semibold">
                        Chat Klarifikasi Produk
                    </a>

                    <a href="{{ route('vendor.tenders.chat.negotiation', $invitation->id) }}"
                        class="block text-center bg-amber-100 text-amber-800 py-3 rounded-2xl font-semibold hover:bg-amber-200">
                        Chat Negosiasi Penawaran
                    </a>

                </div>

                {{-- PENAWARAN --}}
                <div class="bg-white rounded-3xl shadow border border-slate-100 p-6">

                    <h3 class="text-xl font-bold mb-5">Penawaran Vendor</h3>

                    <form action="{{ route('vendor.tenders.quotation.store', $invitation->id) }}" method="POST">
                        @csrf

                        <div class="space-y-4">

                            {{-- HARGA --}}
                            <div>
                                <label class="text-xs text-slate-500">Harga Penawaran</label>
                                <input type="number" name="harga_penawaran"
                                    class="w-full mt-1 rounded-2xl border-slate-200 focus:ring-blue-500 focus:border-blue-500"
                                    placeholder="Contoh: 25000000">
                            </div>

                            {{-- ESTIMASI --}}
                            <div>
                                <label class="text-xs text-slate-500">Estimasi Pengiriman</label>
                                <input type="number" name="estimasi_pengiriman"
                                    class="w-full mt-1 rounded-2xl border-slate-200 focus:ring-blue-500 focus:border-blue-500"
                                    placeholder="Contoh: 14">
                                <p class="text-xs text-slate-400 mt-1">Isi dalam satuan hari</p>
                            </div>

                            {{-- CATATAN --}}
                            <div>
                                <label class="text-xs text-slate-500">Catatan Penawaran</label>
                                <textarea name="catatan" class="w-full mt-1 rounded-2xl border-slate-200 focus:ring-blue-500 focus:border-blue-500"
                                    placeholder="Contoh: Harga sudah termasuk pengiriman ke gudang"></textarea>
                            </div>

                            {{-- UPLOAD --}}
                            <div>
                                <label class="text-xs text-slate-500">Upload File Penawaran</label>
                                <input type="file" class="w-full mt-1 text-sm" name="file">
                                <p class="text-xs text-slate-400 mt-1">
                                    Format: PDF, DOC, DOCX, XLS, XLSX. Maks 10MB
                                </p>
                            </div>

                            {{-- BUTTON --}}
                            <button
                                class="w-full bg-blue-900 text-white py-3 rounded-2xl font-bold hover:bg-blue-950 transition">
                                Kirim Penawaran
                            </button>

                        </div>

                    </form>

                </div>

                {{-- BACK --}}
                <div class="space-y-3">

                    <a href="{{ route('vendor.tenders.index') }}"
                        class="block text-center bg-slate-200 py-3 rounded-2xl font-semibold">
                        Kembali Tender
                    </a>

                    <a href="{{ route('vendor.dashboard') }}"
                        class="block text-center bg-slate-900 text-white py-3 rounded-2xl font-semibold">
                        Dashboard
                    </a>

                </div>

            </div>

        </div>

    </div>

</x-app-layout>
