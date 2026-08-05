<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3">
            <div>
                <h2 class="font-bold text-2xl text-slate-900 leading-tight">
                    Detail Vendor
                </h2>
                <p class="text-sm text-slate-500 mt-1">
                    Informasi lengkap vendor dan verifikasi registrasi.
                </p>
            </div>

            <a href="{{ route('supply-chain.vendors.index') }}"
                class="inline-flex items-center justify-center px-4 py-2 bg-slate-900 text-white rounded-xl text-sm font-semibold hover:bg-slate-800 transition">
                Kembali ke Vendor
            </a>
        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        @if (session('success'))
            <div class="mb-6 p-4 bg-green-50 border border-green-200 text-green-700 rounded-2xl">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="mb-6 p-4 bg-red-50 border border-red-200 text-red-700 rounded-2xl">
                {{ session('error') }}
            </div>
        @endif

        @php
            $regStatus = $vendor->status_registrasi ?? 'disetujui';
        @endphp

        {{-- Hero Banner --}}
        <div
            class="bg-gradient-to-r from-slate-950 via-blue-950 to-blue-800 rounded-3xl p-8 md:p-10 shadow-xl text-white mb-8 overflow-hidden relative">
            <div class="absolute -top-24 -right-24 w-80 h-80 bg-cyan-400/20 rounded-full blur-3xl"></div>
            <div class="absolute -bottom-24 -left-24 w-80 h-80 bg-blue-400/20 rounded-full blur-3xl"></div>

            <div class="relative z-10 flex flex-col lg:flex-row lg:items-end lg:justify-between gap-6">
                <div>
                    <p
                        class="inline-flex px-4 py-2 rounded-full bg-white/10 border border-white/10 text-sm text-blue-100 mb-5">
                        {{ $vendor->kode_vendor }}
                    </p>

                    <h3 class="text-3xl md:text-4xl font-bold leading-tight">
                        {{ $vendor->nama_vendor }}
                    </h3>

                    <p class="mt-4 text-blue-100 max-w-3xl text-base leading-relaxed">
                        {{ $vendor->kategori ?? 'Kategori belum diisi' }}
                    </p>
                </div>

                <div class="flex flex-col gap-2 items-start">
                    {{-- Badge status aktif/nonaktif --}}
                    @if ($vendor->status == 'aktif')
                        <span class="inline-flex px-4 py-2 rounded-full bg-green-100 text-green-800 text-sm font-bold">
                            Vendor Aktif
                        </span>
                    @else
                        <span class="inline-flex px-4 py-2 rounded-full bg-red-100 text-red-800 text-sm font-bold">
                            Vendor Nonaktif
                        </span>
                    @endif

                    {{-- Badge status registrasi --}}
                    @if ($regStatus === 'menunggu')
                        <span class="inline-flex px-4 py-2 rounded-full bg-amber-100 text-amber-800 text-sm font-bold">
                            ⏳ Menunggu Verifikasi
                        </span>
                    @elseif ($regStatus === 'disetujui')
                        <span class="inline-flex px-4 py-2 rounded-full bg-emerald-100 text-emerald-800 text-sm font-bold">
                            ✅ Registrasi Disetujui
                        </span>
                    @elseif ($regStatus === 'ditolak')
                        <span class="inline-flex px-4 py-2 rounded-full bg-red-100 text-red-800 text-sm font-bold">
                            ❌ Registrasi Ditolak
                        </span>
                    @endif
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

            {{-- Informasi Vendor --}}
            <div class="lg:col-span-2 space-y-6">
                <div class="bg-white rounded-3xl shadow-sm border border-slate-200 overflow-hidden">
                    <div class="px-6 py-5 border-b border-slate-200">
                        <h3 class="text-lg font-bold text-slate-900">Informasi Vendor</h3>
                        <p class="text-sm text-slate-500 mt-1">Data lengkap perusahaan vendor.</p>
                    </div>

                    <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div class="rounded-2xl bg-slate-50 p-4">
                            <p class="text-xs text-slate-500 mb-1">Kode Vendor</p>
                            <p class="font-bold text-slate-900">{{ $vendor->kode_vendor }}</p>
                        </div>

                        <div class="rounded-2xl bg-slate-50 p-4">
                            <p class="text-xs text-slate-500 mb-1">Nama Vendor / Perusahaan</p>
                            <p class="font-bold text-slate-900">{{ $vendor->nama_vendor }}</p>
                        </div>

                        <div class="rounded-2xl bg-slate-50 p-4">
                            <p class="text-xs text-slate-500 mb-1">Nama PIC</p>
                            <p class="font-bold text-slate-900">{{ $vendor->pic ?? '-' }}</p>
                        </div>

                        <div class="rounded-2xl bg-slate-50 p-4">
                            <p class="text-xs text-slate-500 mb-1">Email</p>
                            <p class="font-bold text-slate-900">{{ $vendor->email ?? '-' }}</p>
                        </div>

                        <div class="rounded-2xl bg-slate-50 p-4">
                            <p class="text-xs text-slate-500 mb-1">Telepon</p>
                            <p class="font-bold text-slate-900">{{ $vendor->telepon ?? '-' }}</p>
                        </div>

                        <div class="rounded-2xl bg-slate-50 p-4">
                            <p class="text-xs text-slate-500 mb-1">Kategori</p>
                            <p class="font-medium text-slate-900">{{ $vendor->kategori ?? '-' }}</p>
                        </div>

                        <div class="rounded-2xl bg-slate-50 p-4 md:col-span-2">
                            <p class="text-xs text-slate-500 mb-1">Alamat</p>
                            <p class="font-medium text-slate-900">{{ $vendor->alamat ?? '-' }}</p>
                        </div>
                    </div>
                </div>

                {{-- Informasi Registrasi --}}
                <div class="bg-white rounded-3xl shadow-sm border border-slate-200 overflow-hidden">
                    <div class="px-6 py-5 border-b border-slate-200">
                        <h3 class="text-lg font-bold text-slate-900">Informasi Registrasi</h3>
                    </div>
                    <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div class="rounded-2xl bg-slate-50 p-4">
                            <p class="text-xs text-slate-500 mb-1">Tanggal Registrasi</p>
                            <p class="font-bold text-slate-900">
                                @if ($vendor->tanggal_daftar)
                                    {{ $vendor->tanggal_daftar->format('d M Y H:i') }}
                                @else
                                    {{ $vendor->created_at->format('d M Y H:i') }}
                                @endif
                            </p>
                        </div>

                        <div class="rounded-2xl bg-slate-50 p-4">
                            <p class="text-xs text-slate-500 mb-1">Tanggal Verifikasi</p>
                            <p class="font-bold text-slate-900">
                                {{ $vendor->tanggal_verifikasi ? $vendor->tanggal_verifikasi->format('d M Y H:i') : '-' }}
                            </p>
                        </div>

                        @if ($vendor->verifikator)
                        <div class="rounded-2xl bg-slate-50 p-4">
                            <p class="text-xs text-slate-500 mb-1">Diverifikasi oleh</p>
                            <p class="font-bold text-slate-900">{{ $vendor->verifikator->name }}</p>
                        </div>
                        @endif

                        <div class="rounded-2xl bg-slate-50 p-4">
                            <p class="text-xs text-slate-500 mb-1">Status Registrasi</p>
                            <p class="font-bold text-slate-900">{{ $vendor->status_registrasi_label }}</p>
                        </div>

                        @if ($vendor->alasan_penolakan)
                        <div class="rounded-2xl bg-red-50 border border-red-200 p-4 md:col-span-2">
                            <p class="text-xs text-red-600 font-bold uppercase tracking-wider mb-1">Alasan Penolakan</p>
                            <p class="text-sm text-red-800">{{ $vendor->alasan_penolakan }}</p>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Panel Aksi --}}
            <div class="lg:col-span-1 space-y-6">

                {{-- Verifikasi Registrasi --}}
                @if ($regStatus === 'menunggu')
                <div class="bg-amber-50 border-2 border-amber-300 rounded-3xl p-6">
                    <h3 class="text-lg font-bold text-amber-900">⏳ Verifikasi Registrasi</h3>
                    <p class="text-sm text-amber-800 mt-2">
                        Vendor ini mendaftar secara mandiri dan menunggu keputusan verifikasi dari Supply Chain.
                    </p>

                    <div class="mt-5 space-y-3">
                        <form action="{{ route('supply-chain.vendors.approve', $vendor) }}" method="POST"
                            onsubmit="return confirm('Apakah Anda yakin ingin menyetujui registrasi Vendor ini?')">
                            @csrf
                            <button type="submit"
                                class="w-full inline-flex items-center justify-center px-5 py-3 bg-green-600 text-white rounded-xl font-semibold hover:bg-green-700 transition">
                                ✅ Setujui Registrasi
                            </button>
                        </form>

                        <button type="button" onclick="document.getElementById('modal-tolak').classList.remove('hidden')"
                            class="w-full inline-flex items-center justify-center px-5 py-3 bg-red-600 text-white rounded-xl font-semibold hover:bg-red-700 transition">
                            ❌ Tolak Registrasi
                        </button>
                    </div>
                </div>
                @endif

                {{-- Aksi Umum --}}
                <div class="bg-white rounded-3xl shadow-sm border border-slate-200 p-6">
                    <h3 class="text-lg font-bold text-slate-900">Aksi Vendor</h3>

                    <div class="mt-5 space-y-3">
                        <a href="{{ route('supply-chain.vendors.edit', $vendor) }}"
                            class="w-full inline-flex items-center justify-center px-5 py-3 bg-yellow-500 text-white rounded-xl font-semibold hover:bg-yellow-600 transition">
                            Edit Data Vendor
                        </a>

                        <a href="{{ route('supply-chain.vendors.index') }}"
                            class="w-full inline-flex items-center justify-center px-5 py-3 bg-slate-100 text-slate-700 rounded-xl font-semibold hover:bg-slate-200 transition">
                            Kembali ke Daftar
                        </a>
                    </div>
                </div>

                <div class="bg-white rounded-3xl shadow-sm border border-slate-200 p-6">
                    <h3 class="text-lg font-bold text-slate-900">Keterangan</h3>
                    <p class="text-sm text-slate-500 mt-2 leading-relaxed">
                        Vendor dengan status <strong>Disetujui</strong> dapat dipilih saat Supply Chain membuat tender
                        dan mengirim undangan penawaran.
                    </p>
                </div>
            </div>

        </div>

    </div>

    {{-- Modal Tolak Registrasi --}}
    <div id="modal-tolak" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/60 backdrop-blur-sm p-4">
        <div class="bg-white rounded-3xl shadow-2xl max-w-lg w-full p-8">
            <h3 class="text-xl font-bold text-slate-900 mb-2">❌ Tolak Registrasi Vendor</h3>
            <p class="text-sm text-slate-600 mb-5">
                Masukkan alasan penolakan. Vendor akan dapat melihat alasan ini dan memperbaiki data registrasinya.
            </p>

            <form action="{{ route('supply-chain.vendors.reject', $vendor) }}" method="POST">
                @csrf
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2" for="alasan_penolakan">
                        Alasan Penolakan <span class="text-red-600">*</span>
                    </label>
                    <textarea id="alasan_penolakan" name="alasan_penolakan" rows="4" required minlength="10"
                        class="block w-full rounded-xl border-slate-300 focus:border-red-500 focus:ring-red-500 text-sm"
                        placeholder="Contoh: Data perusahaan belum lengkap. Nomor telepon tidak dapat diverifikasi."></textarea>
                    @error('alasan_penolakan')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mt-5 flex gap-3">
                    <button type="submit"
                        class="flex-1 inline-flex items-center justify-center px-5 py-3 bg-red-600 text-white rounded-xl font-semibold hover:bg-red-700 transition">
                        Konfirmasi Penolakan
                    </button>
                    <button type="button"
                        onclick="document.getElementById('modal-tolak').classList.add('hidden')"
                        class="flex-1 inline-flex items-center justify-center px-5 py-3 bg-slate-100 text-slate-700 rounded-xl font-semibold hover:bg-slate-200 transition">
                        Batal
                    </button>
                </div>
            </form>
        </div>
    </div>

</x-app-layout>
