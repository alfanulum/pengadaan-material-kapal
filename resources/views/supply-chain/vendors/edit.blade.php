<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3">
            <div>
                <h2 class="font-bold text-2xl text-slate-900 leading-tight">
                    Edit Vendor
                </h2>
                <p class="text-sm text-slate-500 mt-1">
                    Perbarui informasi vendor penyedia material kapal.
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
                        Edit data vendor, kontak, kategori, alamat, dan status vendor.
                    </p>
                </div>

                <div>
                    @if ($vendor->status == 'aktif')
                        <span class="inline-flex px-4 py-2 rounded-full bg-green-100 text-green-800 text-sm font-bold">
                            Aktif
                        </span>
                    @else
                        <span class="inline-flex px-4 py-2 rounded-full bg-red-100 text-red-800 text-sm font-bold">
                            Nonaktif
                        </span>
                    @endif
                </div>
            </div>
        </div>

        <div class="bg-white rounded-3xl shadow-sm border border-slate-200 overflow-hidden max-w-5xl mx-auto">
            <div class="px-6 py-5 border-b border-slate-200">
                <h3 class="text-lg font-bold text-slate-900">
                    Form Edit Vendor
                </h3>
                <p class="text-sm text-slate-500 mt-1">
                    Pastikan data vendor diperbarui sesuai informasi terbaru.
                </p>
            </div>

            <form action="{{ route('supply-chain.vendors.update', $vendor) }}" method="POST" class="p-6 md:p-8">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">Kode Vendor</label>
                        <input type="text" name="kode_vendor" value="{{ old('kode_vendor', $vendor->kode_vendor) }}"
                            class="w-full rounded-xl border-slate-300 focus:border-blue-800 focus:ring-blue-800">
                        @error('kode_vendor')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">Nama Vendor</label>
                        <input type="text" name="nama_vendor" value="{{ old('nama_vendor', $vendor->nama_vendor) }}"
                            class="w-full rounded-xl border-slate-300 focus:border-blue-800 focus:ring-blue-800">
                        @error('nama_vendor')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">Email</label>
                        <input type="email" name="email" value="{{ old('email', $vendor->email) }}"
                            class="w-full rounded-xl border-slate-300 focus:border-blue-800 focus:ring-blue-800">
                        @error('email')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">Telepon</label>
                        <input type="text" name="telepon" value="{{ old('telepon', $vendor->telepon) }}"
                            class="w-full rounded-xl border-slate-300 focus:border-blue-800 focus:ring-blue-800">
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">PIC / Kontak Person</label>
                        <input type="text" name="pic" value="{{ old('pic', $vendor->pic) }}"
                            class="w-full rounded-xl border-slate-300 focus:border-blue-800 focus:ring-blue-800">
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">Status</label>
                        <select name="status"
                            class="w-full rounded-xl border-slate-300 focus:border-blue-800 focus:ring-blue-800">
                            <option value="aktif" {{ old('status', $vendor->status) == 'aktif' ? 'selected' : '' }}>
                                Aktif</option>
                            <option value="nonaktif"
                                {{ old('status', $vendor->status) == 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                        </select>
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-sm font-semibold text-slate-700 mb-2">Kategori</label>
                        <input type="text" name="kategori" value="{{ old('kategori', $vendor->kategori) }}"
                            class="w-full rounded-xl border-slate-300 focus:border-blue-800 focus:ring-blue-800">
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-sm font-semibold text-slate-700 mb-2">Alamat</label>
                        <textarea name="alamat" rows="4"
                            class="w-full rounded-xl border-slate-300 focus:border-blue-800 focus:ring-blue-800">{{ old('alamat', $vendor->alamat) }}</textarea>
                    </div>
                </div>

                <div class="mt-8 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                    <a href="{{ route('supply-chain.vendors.index') }}"
                        class="inline-flex items-center justify-center px-5 py-3 bg-slate-100 text-slate-700 rounded-xl font-semibold hover:bg-slate-200 transition">
                        Kembali
                    </a>

                    <button type="submit"
                        class="inline-flex items-center justify-center px-6 py-3 bg-blue-900 text-white rounded-xl font-semibold shadow-lg hover:bg-blue-950 transition">
                        Update Vendor
                    </button>
                </div>
            </form>
        </div>

    </div>
</x-app-layout>
