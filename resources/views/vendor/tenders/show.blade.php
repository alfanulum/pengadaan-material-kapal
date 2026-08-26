<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <h2 class="text-2xl font-bold text-slate-900 tracking-tight">Detail Tender</h2>
                <p class="text-sm text-slate-500 mt-1">
                    Informasi lengkap pengadaan material dan form penawaran
                </p>
            </div>

            <div class="flex items-center gap-3">
                <a href="{{ route('vendor.tenders.index') }}"
                    class="inline-flex items-center gap-2 px-5 py-2.5 bg-white text-slate-700 border border-slate-200 rounded-xl text-sm font-semibold hover:bg-slate-50 hover:text-blue-600 transition-all group shadow-sm">
                    <svg class="w-4 h-4 text-slate-400 group-hover:text-blue-600 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    Kembali ke Tender Masuk
                </a>
            </div>
        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-8">

        {{-- ALERTS --}}
        @if (session('success'))
            <div class="bg-emerald-50 border border-emerald-200 text-emerald-800 px-5 py-4 rounded-2xl flex items-center gap-3 shadow-sm">
                <div class="w-8 h-8 rounded-full bg-emerald-100 flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                </div>
                <p class="font-medium text-sm">{{ session('success') }}</p>
            </div>
        @endif

        @if (session('error'))
            <div class="bg-rose-50 border border-rose-200 text-rose-800 px-5 py-4 rounded-2xl flex items-center gap-3 shadow-sm">
                <div class="w-8 h-8 rounded-full bg-rose-100 flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5 text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </div>
                <p class="font-medium text-sm">{{ session('error') }}</p>
            </div>
        @endif

        @if ($errors->any())
            <div class="bg-rose-50 border border-rose-200 text-rose-800 px-5 py-4 rounded-2xl shadow-sm">
                <div class="flex items-center gap-3 mb-2">
                    <div class="w-8 h-8 rounded-full bg-rose-100 flex items-center justify-center shrink-0">
                        <svg class="w-5 h-5 text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                    </div>
                    <p class="font-bold text-sm">Terdapat kesalahan pengisian form:</p>
                </div>
                <ul class="list-disc list-inside text-sm ml-11 space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- HERO HEADER --}}
        <div class="relative overflow-hidden rounded-3xl bg-slate-900 p-8 md:p-10 shadow-xl flex flex-col md:flex-row md:items-end justify-between gap-6 border border-slate-800">
            <!-- Decorative Background -->
            <div class="absolute inset-0 bg-gradient-to-r from-blue-900/40 to-slate-900/40 z-0"></div>
            <div class="absolute -top-24 -right-24 w-96 h-96 bg-blue-500/20 rounded-full blur-3xl z-0"></div>
            
            <div class="relative z-10">
                <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-lg bg-white/10 border border-white/20 text-blue-100 text-xs font-bold mb-4 backdrop-blur-sm">
                    <span class="w-2 h-2 rounded-full bg-blue-400 shadow-[0_0_8px_rgba(96,165,250,0.8)]"></span>
                    Tender Pengadaan
                </div>
                <h1 class="text-3xl md:text-4xl font-extrabold text-white tracking-tight mb-2">
                    {{ $invitation->tender->nama_tender }}
                </h1>
                <p class="text-slate-400 font-medium font-mono text-sm">
                    {{ $invitation->tender->kode_tender }}
                </p>
            </div>

            <div class="relative z-10 shrink-0">
                <div class="bg-white/10 backdrop-blur-md border border-white/20 rounded-2xl p-5 min-w-[200px]">
                    <p class="text-xs text-slate-400 uppercase tracking-wider font-bold mb-1">Status Tender</p>
                    @if ($invitation->status == 'dikirim')
                        <span class="inline-flex px-3 py-1 rounded-full bg-blue-500/20 text-blue-300 border border-blue-500/30 text-sm font-bold">Menunggu Respon</span>
                    @elseif ($invitation->status == 'dibaca')
                        <span class="inline-flex px-3 py-1 rounded-full bg-indigo-500/20 text-indigo-300 border border-indigo-500/30 text-sm font-bold">Dibaca</span>
                    @elseif ($invitation->status == 'ditawar')
                        <span class="inline-flex px-3 py-1 rounded-full bg-amber-500/20 text-amber-300 border border-amber-500/30 text-sm font-bold">Sudah Ditawar</span>
                    @elseif ($invitation->status == 'terpilih')
                        <span class="inline-flex px-3 py-1 rounded-full bg-emerald-500/20 text-emerald-300 border border-emerald-500/30 text-sm font-bold">Terpilih (Pemenang)</span>
                    @elseif ($invitation->status == 'tidak_terpilih')
                        <span class="inline-flex px-3 py-1 rounded-full bg-rose-500/20 text-rose-300 border border-rose-500/30 text-sm font-bold">Tidak Terpilih</span>
                    @else
                        <span class="inline-flex px-3 py-1 rounded-full bg-slate-500/20 text-slate-300 border border-slate-500/30 text-sm font-bold capitalize">{{ str_replace('_', ' ', $invitation->status) }}</span>
                    @endif
                </div>
            </div>
        </div>

        {{-- TOP GRID: TENDER INFO & VENDOR INFO --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            {{-- INFORMASI TENDER (2 Columns) --}}
            <div class="lg:col-span-2 bg-white rounded-3xl shadow-sm border border-slate-200 overflow-hidden flex flex-col">
                <div class="px-8 py-6 border-b border-slate-100 flex items-center justify-between bg-slate-50/50">
                    <h3 class="text-lg font-bold text-slate-900 flex items-center gap-2">
                        <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        Informasi Tender
                    </h3>
                </div>
                
                <div class="p-8 flex-1">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 h-full">
                        <div>
                            <p class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-1.5">Project</p>
                            <p class="text-sm font-semibold text-slate-900 bg-slate-50 px-4 py-3 rounded-xl border border-slate-100">
                                {{ $invitation->tender->materialRequest->project->nama_project }}
                            </p>
                        </div>
                        <div>
                            <p class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-1.5">Deadline Penawaran</p>
                            <p class="text-sm font-bold text-rose-600 bg-rose-50 px-4 py-3 rounded-xl border border-rose-100 flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                {{ \Carbon\Carbon::parse($invitation->tender->deadline)->format('d F Y, H:i') }}
                            </p>
                        </div>
                        <div class="md:col-span-2">
                            <p class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-1.5">Catatan Tender</p>
                            <div class="text-sm font-medium text-slate-700 bg-slate-50 px-5 py-4 rounded-2xl border border-slate-100 leading-relaxed min-h-[80px]">
                                {{ $invitation->tender->catatan ?: 'Tidak ada catatan tambahan dari Supply Chain.' }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- VENDOR INFO & ACTIONS (1 Column) --}}
            <div class="space-y-6 flex flex-col h-full">
                {{-- Vendor Info --}}
                <div class="bg-white rounded-3xl shadow-sm border border-slate-200 overflow-hidden flex-1">
                    <div class="px-6 py-5 border-b border-slate-100 bg-slate-50/50">
                        <h3 class="text-base font-bold text-slate-900 flex items-center gap-2">
                            <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                            Profil Vendor
                        </h3>
                    </div>
                    <div class="p-6 space-y-4">
                        <div>
                            <p class="text-xs font-medium text-slate-500 mb-1">Nama Perusahaan</p>
                            <p class="text-sm font-bold text-slate-900">{{ $vendor->nama_vendor }}</p>
                        </div>
                        <div>
                            <p class="text-xs font-medium text-slate-500 mb-1">Email Kontak</p>
                            <p class="text-sm font-semibold text-slate-700">{{ $vendor->email }}</p>
                        </div>
                        <div>
                            <p class="text-xs font-medium text-slate-500 mb-1">PIC (Penanggung Jawab)</p>
                            <p class="text-sm font-semibold text-slate-700">{{ $vendor->pic }}</p>
                        </div>
                    </div>
                </div>

                {{-- Komunikasi Actions --}}
                <div class="bg-white rounded-3xl shadow-sm border border-slate-200 p-3 space-y-2">
                    <a href="{{ route('vendor.tenders.chat', $invitation->id) }}"
                        class="flex items-center justify-center gap-2 w-full bg-blue-50 text-blue-700 hover:bg-blue-100 hover:text-blue-800 py-3 rounded-2xl font-bold text-sm transition-colors border border-blue-100">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path></svg>
                        Chat Klarifikasi Produk
                    </a>

                    @if ($invitation->status !== 'tidak_terpilih' && $invitation->status !== 'ditolak')
                        <a href="{{ route('vendor.tenders.chat.negotiation', $invitation->id) }}"
                            class="flex items-center justify-center gap-2 w-full bg-amber-50 text-amber-700 hover:bg-amber-100 hover:text-amber-800 py-3 rounded-2xl font-bold text-sm transition-colors border border-amber-100">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            Chat Negosiasi Harga
                        </a>
                    @endif
                </div>
            </div>
        </div>

        {{-- FULL WIDTH: DATA MATERIAL --}}
        <div class="bg-white rounded-3xl shadow-sm border border-slate-200 overflow-hidden">
            <div class="px-8 py-6 border-b border-slate-100 flex items-center justify-between bg-slate-50/50">
                <div>
                    <h3 class="text-lg font-bold text-slate-900 flex items-center gap-2">
                        <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                        Data Kebutuhan Material
                    </h3>
                    <p class="text-sm text-slate-500 mt-1">Spesifikasi barang yang dibutuhkan untuk tender ini.</p>
                </div>
                <div class="hidden md:block">
                    <span class="bg-indigo-100 text-indigo-800 text-xs font-bold px-3 py-1.5 rounded-lg border border-indigo-200">
                        Total {{ $invitation->tender->materialRequest->items->count() }} Item
                    </span>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead class="bg-slate-50/80 border-b border-slate-200">
                        <tr>
                            <th class="px-8 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider w-16">No</th>
                            <th class="px-8 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Barang</th>
                            <th class="px-8 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Spesifikasi Detail</th>
                            <th class="px-8 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider text-right">Kuantitas</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @foreach ($invitation->tender->materialRequest->items as $index => $item)
                            <tr class="hover:bg-slate-50/50 transition-colors">
                                <td class="px-8 py-5 text-sm font-semibold text-slate-400">{{ $index + 1 }}</td>
                                <td class="px-8 py-5">
                                    <p class="text-sm font-bold text-slate-900">{{ $item->nama_barang }}</p>
                                </td>
                                <td class="px-8 py-5">
                                    <p class="text-sm text-slate-600 max-w-xl leading-relaxed">{{ $item->spesifikasi }}</p>
                                </td>
                                <td class="px-8 py-5 text-right">
                                    <span class="inline-flex items-center justify-center bg-slate-100 text-slate-800 text-sm font-bold px-3 py-1 rounded-lg border border-slate-200">
                                        {{ $item->qty }} <span class="text-slate-500 font-medium ml-1 text-xs">{{ $item->satuan }}</span>
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        {{-- UBAH NOMINAL NEGOSIASI (Jika ada penawaran dan status memungkinkan) --}}
        @if ($invitation->status !== 'tidak_terpilih' && $invitation->status !== 'ditolak' && $quotation && $invitation->status == 'ditawar')
            <div class="bg-white rounded-3xl shadow-sm border border-slate-200 overflow-hidden">
                <div class="px-8 py-6 border-b border-slate-100 bg-amber-50/30 flex items-center gap-3">
                    <div class="w-10 h-10 rounded-full bg-amber-100 flex items-center justify-center shrink-0">
                        <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-slate-900">Ubah Nominal Penawaran (Hasil Negosiasi)</h3>
                        <p class="text-sm text-slate-500">Sesuaikan nominal keseluruhan setelah mencapai kesepakatan dengan Supply Chain melalui fitur chat.</p>
                    </div>
                </div>
                
                <div class="p-8">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 items-end">
                        <div class="bg-slate-50 p-5 rounded-2xl border border-slate-100">
                            <p class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Total Penawaran Awal</p>
                            <p class="text-xl font-bold text-slate-900">Rp {{ number_format($quotation->harga_penawaran, 0, ',', '.') }}</p>
                        </div>

                        @if ($quotation->harga_negosiasi)
                            <div class="bg-blue-50 p-5 rounded-2xl border border-blue-100">
                                <p class="text-xs font-bold text-blue-500 uppercase tracking-wider mb-1">Nominal Terbaru Disepakati</p>
                                <p class="text-xl font-bold text-blue-900">Rp {{ number_format($quotation->harga_negosiasi, 0, ',', '.') }}</p>
                            </div>
                        @endif

                        <div class="lg:col-span-3">
                            @if ($invitation->tender->purchaseOrder)
                                <div class="bg-slate-50 border border-slate-200 p-4 rounded-2xl flex items-center justify-center gap-3 mt-2 text-slate-600">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                                    <div>
                                        <p class="text-sm font-bold">Nominal Tidak Dapat Diubah</p>
                                        <p class="text-xs">Purchase Order telah diterbitkan oleh Supply Chain.</p>
                                    </div>
                                </div>
                            @else
                                <form action="{{ route('vendor.tenders.quotation.negotiation', $invitation->id) }}" method="POST" class="mt-4 bg-white p-6 rounded-3xl border border-slate-200 shadow-sm flex flex-col md:flex-row gap-4 items-end">
                                    @csrf
                                    <div class="flex-1 w-full">
                                        <label class="text-sm font-bold text-slate-700 block mb-2">Input Nominal Baru Keseluruhan</label>
                                        <div class="relative">
                                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                                <span class="text-slate-500 font-semibold text-sm">Rp</span>
                                            </div>
                                            <input type="number" name="harga_negosiasi"
                                                value="{{ old('harga_negosiasi', $quotation->harga_negosiasi ?? '') }}"
                                                class="w-full pl-12 pr-4 py-3 rounded-xl border-slate-200 focus:ring-amber-500 focus:border-amber-500 text-slate-900 font-bold"
                                                placeholder="Contoh: 24000000" required>
                                        </div>
                                    </div>
                                    <button class="w-full md:w-auto px-8 py-3 bg-gradient-to-r from-amber-500 to-amber-600 text-white rounded-xl font-bold shadow-md shadow-amber-500/20 hover:from-amber-600 hover:to-amber-700 transition-all hover:-translate-y-0.5 whitespace-nowrap">
                                        Simpan Perubahan
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @endif

        {{-- FORM PENAWARAN VENDOR --}}
        <div class="bg-white rounded-3xl shadow-lg shadow-slate-200/50 border border-slate-200 overflow-hidden relative" id="form-penawaran">
            
            <div class="absolute top-0 left-0 w-full h-2 bg-gradient-to-r from-blue-600 to-indigo-600"></div>

            <div class="px-8 py-6 border-b border-slate-100 flex flex-col md:flex-row md:items-center justify-between gap-4 mt-2">
                <div>
                    <h3 class="text-xl font-bold text-slate-900 flex items-center gap-2">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path></svg>
                        Formulir Penawaran Vendor
                    </h3>
                    <p class="text-sm text-slate-500 mt-1">Lengkapi form di bawah ini untuk mengirimkan harga penawaran Anda.</p>
                </div>
                @if(isset($quotation))
                    <span class="bg-emerald-100 text-emerald-800 text-xs font-bold px-3 py-1.5 rounded-lg border border-emerald-200 flex items-center gap-1.5">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        Penawaran Telah Dikirim
                    </span>
                @endif
            </div>

            <div class="p-8">
                <form action="{{ route('vendor.tenders.quotation.store', $invitation->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="space-y-8">

                        {{-- Rincian Harga --}}
                        <div>
                            <h4 class="text-base font-bold text-slate-900 mb-4 border-b border-slate-100 pb-2">1. Rincian Harga Satuan Material</h4>
                            <div class="space-y-4">
                                @foreach ($invitation->tender->materialRequest->items as $item)
                                    @php
                                        $hargaSatuan = 0;
                                        if (isset($quotation)) {
                                            $qItem = \App\Models\VendorQuotationItem::where('vendor_quotation_id', $quotation->id)
                                                        ->where('material_request_item_id', $item->id)->first();
                                            if ($qItem) $hargaSatuan = $qItem->harga_satuan;
                                        }
                                    @endphp
                                    <div class="grid grid-cols-1 md:grid-cols-12 gap-6 p-5 bg-slate-50 rounded-2xl border border-slate-200 items-center transition-colors focus-within:bg-white focus-within:border-blue-300 focus-within:shadow-sm">
                                        <div class="md:col-span-5">
                                            <p class="text-sm font-bold text-slate-900 mb-1">{{ $item->nama_barang }}</p>
                                            <p class="text-xs text-slate-500 bg-slate-200/50 inline-block px-2 py-1 rounded">Kuantitas: {{ $item->qty }} {{ $item->satuan }}</p>
                                        </div>
                                        <div class="md:col-span-4">
                                            <label class="text-xs font-bold text-slate-500 mb-1 block uppercase tracking-wider">Harga Satuan</label>
                                            <div class="relative">
                                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                                    <span class="text-slate-500 font-semibold text-sm">Rp</span>
                                                </div>
                                                <input type="number" name="items[{{ $item->id }}][harga_satuan]" 
                                                    value="{{ old('items.'.$item->id.'.harga_satuan', $hargaSatuan > 0 ? $hargaSatuan : '') }}"
                                                    class="w-full pl-12 pr-4 py-2.5 text-sm rounded-xl border-slate-300 focus:ring-blue-500 focus:border-blue-500 harga-satuan-input font-semibold text-slate-900"
                                                    data-qty="{{ $item->qty }}"
                                                    placeholder="0" required>
                                            </div>
                                        </div>
                                        <div class="md:col-span-3 text-right">
                                            <p class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Subtotal Item</p>
                                            <p class="font-bold text-emerald-600 subtotal-text text-lg tracking-tight">Rp 0</p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        {{-- Total Keseluruhan --}}
                        <div class="p-6 bg-gradient-to-r from-slate-900 to-blue-900 rounded-2xl flex flex-col md:flex-row items-center justify-between text-white shadow-md">
                            <div>
                                <h4 class="text-sm font-medium text-blue-200 uppercase tracking-wider mb-1">Total Harga Penawaran</h4>
                                <p class="text-xs text-slate-400">Total dari seluruh subtotal item di atas secara otomatis dihitung.</p>
                            </div>
                            <div class="mt-4 md:mt-0 bg-white/10 px-6 py-3 rounded-xl border border-white/10 backdrop-blur-sm">
                                <p class="text-2xl md:text-3xl font-extrabold tracking-tight" id="total-harga-text">Rp 0</p>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            {{-- Estimasi & Dokumen --}}
                            <div class="space-y-6">
                                <div>
                                    <h4 class="text-sm font-bold text-slate-900 mb-2">2. Estimasi Pengiriman (Hari)</h4>
                                    <div class="relative">
                                        <input type="number" name="estimasi_pengiriman"
                                            value="{{ old('estimasi_pengiriman', $quotation->estimasi_pengiriman ?? '') }}"
                                            class="w-full pr-16 py-3 rounded-xl border-slate-200 focus:ring-blue-500 focus:border-blue-500 font-semibold text-slate-900"
                                            placeholder="Contoh: 14" required>
                                        <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none">
                                            <span class="text-slate-400 text-sm font-medium">Hari</span>
                                        </div>
                                    </div>
                                </div>

                                <div>
                                    <h4 class="text-sm font-bold text-slate-900 mb-2">3. Upload File Penawaran (Opsional)</h4>
                                    <div class="flex items-center justify-center w-full">
                                        <label class="flex flex-col items-center justify-center w-full h-32 border-2 border-slate-300 border-dashed rounded-xl cursor-pointer bg-slate-50 hover:bg-slate-100 transition-colors">
                                            <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                                <svg class="w-8 h-8 mb-3 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path></svg>
                                                <p class="mb-1 text-sm text-slate-500"><span class="font-semibold text-blue-600">Klik untuk upload</span> atau drag and drop</p>
                                                <p class="text-xs text-slate-400">PDF, DOC, DOCX, XLS (Maks 10MB)</p>
                                            </div>
                                            <input type="file" name="file_penawaran" class="hidden" accept=".pdf,.doc,.docx,.xls,.xlsx" />
                                        </label>
                                    </div>
                                    @if (isset($quotation) && $quotation->file_penawaran)
                                        <div class="mt-3 p-3 bg-blue-50 border border-blue-100 rounded-xl flex items-center justify-between">
                                            <div class="flex items-center gap-2">
                                                <svg class="w-5 h-5 text-blue-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 6a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1zm1 3a1 1 0 100 2h6a1 1 0 100-2H7z" clip-rule="evenodd"></path></svg>
                                                <span class="text-sm font-semibold text-blue-700">File Tersimpan</span>
                                            </div>
                                            <a href="{{ asset('storage/' . $quotation->file_penawaran) }}" target="_blank" class="text-xs font-bold text-white bg-blue-600 px-3 py-1.5 rounded-lg hover:bg-blue-700 transition">
                                                Lihat Dokumen
                                            </a>
                                        </div>
                                    @endif
                                </div>
                            </div>

                            {{-- Catatan --}}
                            <div>
                                <h4 class="text-sm font-bold text-slate-900 mb-2">4. Catatan Tambahan (Opsional)</h4>
                                <textarea name="catatan" rows="6" class="w-full py-3 px-4 rounded-xl border-slate-200 focus:ring-blue-500 focus:border-blue-500 text-sm text-slate-700 resize-none leading-relaxed"
                                    placeholder="Contoh: Harga sudah termasuk biaya bongkar muat di pelabuhan. Garansi 1 tahun untuk seluruh material.">{{ old('catatan', $quotation->catatan ?? '') }}</textarea>
                            </div>
                        </div>

                        <div class="pt-6 border-t border-slate-100">
                            <button type="submit" class="w-full md:w-auto px-10 py-4 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white rounded-xl font-bold text-base shadow-lg shadow-blue-500/30 transition-all hover:-translate-y-1 flex items-center justify-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path></svg>
                                {{ isset($quotation) ? 'Perbarui Penawaran' : 'Kirim Penawaran Harga' }}
                            </button>
                            <p class="text-xs text-center md:text-left text-slate-400 mt-3">
                                Pastikan harga yang dimasukkan sudah benar. Anda dapat memperbarui form ini sebelum batas deadline berakhir.
                            </p>
                        </div>

                    </div>
                </form>
            </div>
        </div>
        
        {{-- BOTTOM SPACING --}}
        <div class="h-8"></div>

    </div>

</x-app-layout>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const inputs = document.querySelectorAll('.harga-satuan-input');
    const totalText = document.getElementById('total-harga-text');
    const fileInput = document.querySelector('input[type="file"]');

    function formatRupiah(number) {
        return new Intl.NumberFormat('id-ID').format(number);
    }

    function calculateTotal() {
        let grandTotal = 0;
        
        inputs.forEach(input => {
            const qty = parseFloat(input.dataset.qty) || 0;
            const price = parseFloat(input.value) || 0;
            const subtotal = qty * price;
            
            // Update subtotal text
            const subtotalEl = input.closest('.grid').querySelector('.subtotal-text');
            if(subtotalEl) subtotalEl.innerText = 'Rp ' + formatRupiah(subtotal);
            
            grandTotal += subtotal;
        });
        
        if(totalText) totalText.innerText = 'Rp ' + formatRupiah(grandTotal);
    }

    // Bind event listeners
    inputs.forEach(input => {
        input.addEventListener('input', calculateTotal);
    });

    // Handle File input display (optional visual feedback)
    if(fileInput) {
        fileInput.addEventListener('change', function(e) {
            const fileName = e.target.files[0]?.name;
            const textEl = e.target.parentElement.querySelector('p:first-of-type');
            if(fileName && textEl) {
                textEl.innerHTML = `<span class="font-bold text-blue-600 truncate block max-w-[200px]">${fileName}</span>`;
            } else if (textEl) {
                textEl.innerHTML = `<span class="font-semibold text-blue-600">Klik untuk upload</span> atau drag and drop`;
            }
        });
    }

    // Initial calculation on load
    calculateTotal();
});
</script>
