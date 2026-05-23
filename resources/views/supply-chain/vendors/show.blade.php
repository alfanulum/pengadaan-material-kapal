<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3">
            <div>
                <h2 class="font-bold text-2xl text-slate-900 leading-tight">
                    Detail Vendor
                </h2>
                <p class="text-sm text-slate-500 mt-1">
                    Informasi lengkap vendor penyedia material kapal.
                </p>
            </div>

            <a href="{{ route('supply-chain.vendors.index') }}"
                class="inline-flex items-center justify-center px-4 py-2 bg-slate-900 text-white rounded-xl text-sm font-semibold hover:bg-slate-800 transition">
                Kembali ke Vendor
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
                        {{ $vendor->kode_vendor }}
                    </p>

                    <h3 class="text-3xl md:text-4xl font-bold leading-tight">
                        {{ $vendor->nama_vendor }}
                    </h3>

                    <p class="mt-4 text-blue-100 max-w-3xl text-base leading-relaxed">
                        Detail vendor yang dapat digunakan dalam proses tender dan pengadaan material kapal.
                    </p>
                </div>

                <div>
                    @if ($vendor->status == 'aktif')
                        <span class="inline-flex px-4 py-2 rounded-full bg-green-100 text-green-800 text-sm font-bold">
                            Vendor Aktif
                        </span>
                    @else
                        <span class="inline-flex px-4 py-2 rounded-full bg-red-100 text-red-800 text-sm font-bold">
                            Vendor Nonaktif
                        </span>
                    @endif
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

            <div class="lg:col-span-2">
                <div class="bg-white rounded-3xl shadow-sm border border-slate-200 overflow-hidden">
                    <div class="px-6 py-5 border-b border-slate-200">
                        <h3 class="text-lg font-bold text-slate-900">
                            Informasi Vendor
                        </h3>
                        <p class="text-sm text-slate-500 mt-1">
                            Data utama vendor.
                        </p>
                    </div>

                    <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div class="rounded-2xl bg-slate-50 p-4">
                            <p class="text-xs text-slate-500 mb-1">Kode Vendor</p>
                            <p class="font-bold text-slate-900">{{ $vendor->kode_vendor }}</p>
                        </div>

                        <div class="rounded-2xl bg-slate-50 p-4">
                            <p class="text-xs text-slate-500 mb-1">Nama Vendor</p>
                            <p class="font-bold text-slate-900">{{ $vendor->nama_vendor }}</p>
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
                            <p class="text-xs text-slate-500 mb-1">PIC</p>
                            <p class="font-bold text-slate-900">{{ $vendor->pic ?? '-' }}</p>
                        </div>

                        <div class="rounded-2xl bg-slate-50 p-4">
                            <p class="text-xs text-slate-500 mb-1">Status</p>
                            <p class="font-bold text-slate-900 capitalize">{{ $vendor->status }}</p>
                        </div>

                        <div class="rounded-2xl bg-slate-50 p-4 md:col-span-2">
                            <p class="text-xs text-slate-500 mb-1">Kategori</p>
                            <p class="font-medium text-slate-900">{{ $vendor->kategori ?? '-' }}</p>
                        </div>

                        <div class="rounded-2xl bg-slate-50 p-4 md:col-span-2">
                            <p class="text-xs text-slate-500 mb-1">Alamat</p>
                            <p class="font-medium text-slate-900">{{ $vendor->alamat ?? '-' }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="lg:col-span-1 space-y-6">
                <div class="bg-white rounded-3xl shadow-sm border border-slate-200 p-6">
                    <h3 class="text-lg font-bold text-slate-900">
                        Aksi Vendor
                    </h3>

                    <p class="text-sm text-slate-500 mt-2">
                        Perbarui data vendor atau kembali ke daftar vendor.
                    </p>

                    <div class="mt-6 space-y-3">
                        <a href="{{ route('supply-chain.vendors.edit', $vendor) }}"
                            class="w-full inline-flex items-center justify-center px-5 py-3 bg-yellow-500 text-white rounded-xl font-semibold hover:bg-yellow-600 transition">
                            Edit Vendor
                        </a>

                        <a href="{{ route('supply-chain.vendors.index') }}"
                            class="w-full inline-flex items-center justify-center px-5 py-3 bg-slate-100 text-slate-700 rounded-xl font-semibold hover:bg-slate-200 transition">
                            Kembali ke Daftar
                        </a>
                    </div>
                </div>

                <div class="bg-white rounded-3xl shadow-sm border border-slate-200 p-6">
                    <h3 class="text-lg font-bold text-slate-900">
                        Keterangan
                    </h3>

                    <p class="text-sm text-slate-500 mt-2 leading-relaxed">
                        Vendor dengan status aktif dapat dipilih saat Supply Chain membuat tender
                        dan mengirim undangan penawaran.
                    </p>
                </div>
            </div>

        </div>

    </div>
</x-app-layout>
