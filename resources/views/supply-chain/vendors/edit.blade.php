<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <h2 class="font-bold text-2xl text-slate-900 leading-tight">
                    Edit Data Vendor
                </h2>
                <p class="text-sm text-slate-500 mt-1">
                    Perbarui informasi, kontak, dan status untuk <span class="font-semibold text-slate-700">{{ $vendor->nama_vendor }}</span>.
                </p>
            </div>
            
            <div class="flex items-center gap-3">
                <a href="{{ route('supply-chain.vendors.index') }}" class="inline-flex items-center justify-center gap-2 px-4 py-2 bg-slate-100 border border-slate-300 text-slate-700 rounded-lg text-sm font-semibold hover:bg-slate-200 transition shadow-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-4 h-4">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" />
                    </svg>
                    Kembali
                </a>
            </div>
        </div>
    </x-slot>

    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 pb-12">
        <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
            <div class="px-6 py-5 border-b border-slate-200 bg-slate-50/50 flex justify-between items-center">
                <div>
                    <h3 class="text-base font-bold leading-6 text-slate-900">
                        Form Informasi Vendor
                    </h3>
                    <p class="text-sm text-slate-500 mt-1">
                        Pastikan data vendor diperbarui sesuai informasi terbaru.
                    </p>
                </div>
                <div class="shrink-0 text-right">
                    <span class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-semibold bg-slate-100 text-slate-700 border border-slate-200">
                        {{ $vendor->kode_vendor }}
                    </span>
                </div>
            </div>

            <form action="{{ route('supply-chain.vendors.update', $vendor) }}" method="POST" class="px-6 py-6 sm:p-8">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-6">
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">Kode Vendor</label>
                        <input type="text" name="kode_vendor" value="{{ old('kode_vendor', $vendor->kode_vendor) }}"
                            class="block w-full rounded-lg border-0 py-2.5 text-slate-900 shadow-sm ring-1 ring-inset ring-slate-300 placeholder:text-slate-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6 transition-shadow">
                        @error('kode_vendor')
                            <p class="text-rose-600 text-sm mt-1 font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">Nama Vendor / Perusahaan</label>
                        <input type="text" name="nama_vendor" value="{{ old('nama_vendor', $vendor->nama_vendor) }}"
                            class="block w-full rounded-lg border-0 py-2.5 text-slate-900 shadow-sm ring-1 ring-inset ring-slate-300 placeholder:text-slate-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6 transition-shadow">
                        @error('nama_vendor')
                            <p class="text-rose-600 text-sm mt-1 font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">Email</label>
                        <input type="email" name="email" value="{{ old('email', $vendor->email) }}"
                            class="block w-full rounded-lg border-0 py-2.5 text-slate-900 shadow-sm ring-1 ring-inset ring-slate-300 placeholder:text-slate-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6 transition-shadow">
                        @error('email')
                            <p class="text-rose-600 text-sm mt-1 font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">Telepon</label>
                        <input type="text" name="telepon" value="{{ old('telepon', $vendor->telepon) }}"
                            class="block w-full rounded-lg border-0 py-2.5 text-slate-900 shadow-sm ring-1 ring-inset ring-slate-300 placeholder:text-slate-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6 transition-shadow">
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">PIC / Kontak Person</label>
                        <input type="text" name="pic" value="{{ old('pic', $vendor->pic) }}"
                            class="block w-full rounded-lg border-0 py-2.5 text-slate-900 shadow-sm ring-1 ring-inset ring-slate-300 placeholder:text-slate-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6 transition-shadow">
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">Status Vendor</label>
                        <select name="status"
                            class="block w-full rounded-lg border-0 py-2.5 text-slate-900 shadow-sm ring-1 ring-inset ring-slate-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6 transition-shadow">
                            <option value="aktif" {{ old('status', $vendor->status) == 'aktif' ? 'selected' : '' }}>
                                Aktif</option>
                            <option value="nonaktif"
                                {{ old('status', $vendor->status) == 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                        </select>
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-sm font-semibold text-slate-700 mb-2">Kategori Utama</label>
                        <input type="text" name="kategori" value="{{ old('kategori', $vendor->kategori) }}"
                            class="block w-full rounded-lg border-0 py-2.5 text-slate-900 shadow-sm ring-1 ring-inset ring-slate-300 placeholder:text-slate-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6 transition-shadow">
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-sm font-semibold text-slate-700 mb-2">Alamat Lengkap</label>
                        <textarea name="alamat" rows="4"
                            class="block w-full rounded-lg border-0 py-2 text-slate-900 shadow-sm ring-1 ring-inset ring-slate-300 placeholder:text-slate-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6 transition-shadow">{{ old('alamat', $vendor->alamat) }}</textarea>
                    </div>
                </div>

                <div class="mt-8 pt-6 border-t border-slate-200 flex flex-col-reverse sm:flex-row sm:items-center sm:justify-end gap-3">
                    <a href="{{ route('supply-chain.vendors.index') }}"
                        class="inline-flex items-center justify-center px-5 py-2.5 bg-white text-slate-700 border border-slate-300 rounded-lg font-semibold hover:bg-slate-50 transition shadow-sm">
                        Batal
                    </a>

                    <button type="submit"
                        class="inline-flex items-center justify-center px-6 py-2.5 bg-indigo-600 text-white rounded-lg font-semibold shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 transition-all">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
