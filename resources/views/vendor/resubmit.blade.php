<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3">
            <div>
                <h2 class="font-bold text-2xl text-slate-900 leading-tight">
                    Perbaiki Data Registrasi
                </h2>
                <p class="text-sm text-slate-500 mt-1">
                    Perbaiki data registrasi Vendor yang ditolak dan kirim ulang untuk diverifikasi.
                </p>
            </div>
        </div>
    </x-slot>

    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">

        {{-- Alasan Penolakan --}}
        <div class="mb-6 rounded-3xl border-2 border-red-300 bg-red-50 p-6">
            <h3 class="text-base font-bold text-red-900 mb-2">❌ Alasan Penolakan dari Supply Chain</h3>
            <p class="text-sm text-red-800 leading-relaxed">{{ $vendor->alasan_penolakan ?? 'Tidak ada keterangan.' }}</p>
        </div>

        @if ($errors->any())
            <div class="mb-6 p-4 bg-red-50 border border-red-200 text-red-700 rounded-xl text-sm">
                <p class="font-semibold mb-1">Terdapat kesalahan pada formulir:</p>
                <ul class="list-disc list-inside space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="bg-white rounded-3xl shadow-sm border border-slate-200 overflow-hidden">
            <div class="px-6 py-5 border-b border-slate-200">
                <h3 class="text-lg font-bold text-slate-900">Form Perbaikan Data</h3>
                <p class="text-sm text-slate-500 mt-1">
                    Email dan akun Anda tidak berubah. Hanya data perusahaan yang dapat diperbaiki.
                </p>
            </div>

            <div class="p-6">
                {{-- Informasi akun (readonly) --}}
                <div class="mb-6 p-4 bg-slate-50 rounded-2xl">
                    <p class="text-xs text-slate-500 mb-1">Email Akun (tidak dapat diubah)</p>
                    <p class="font-bold text-slate-900">{{ auth()->user()->email }}</p>
                </div>

                <form method="POST" action="{{ route('vendor.resubmit.store') }}">
                    @csrf

                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2" for="nama_vendor">
                            Nama Perusahaan / Vendor <span class="text-red-600">*</span>
                        </label>
                        <input type="text" id="nama_vendor" name="nama_vendor"
                            value="{{ old('nama_vendor', $vendor->nama_vendor) }}"
                            required
                            class="block w-full rounded-xl border-slate-300 focus:border-blue-700 focus:ring-blue-700 text-sm"
                            placeholder="Nama perusahaan Anda">
                        @error('nama_vendor')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mt-4">
                        <label class="block text-sm font-semibold text-slate-700 mb-2" for="pic">
                            Nama PIC / Penanggung Jawab <span class="text-red-600">*</span>
                        </label>
                        <input type="text" id="pic" name="pic"
                            value="{{ old('pic', $vendor->pic) }}"
                            required
                            class="block w-full rounded-xl border-slate-300 focus:border-blue-700 focus:ring-blue-700 text-sm"
                            placeholder="Nama penanggung jawab">
                        @error('pic')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mt-4">
                        <label class="block text-sm font-semibold text-slate-700 mb-2" for="telepon">
                            Nomor Telepon <span class="text-red-600">*</span>
                        </label>
                        <input type="text" id="telepon" name="telepon"
                            value="{{ old('telepon', $vendor->telepon) }}"
                            required
                            class="block w-full rounded-xl border-slate-300 focus:border-blue-700 focus:ring-blue-700 text-sm"
                            placeholder="Nomor telepon perusahaan">
                        @error('telepon')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mt-4">
                        <label class="block text-sm font-semibold text-slate-700 mb-2" for="kategori">
                            Kategori Vendor
                        </label>
                        <input type="text" id="kategori" name="kategori"
                            value="{{ old('kategori', $vendor->kategori) }}"
                            class="block w-full rounded-xl border-slate-300 focus:border-blue-700 focus:ring-blue-700 text-sm"
                            placeholder="Kategori produk/jasa (opsional)">
                        @error('kategori')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mt-4">
                        <label class="block text-sm font-semibold text-slate-700 mb-2" for="alamat">
                            Alamat Perusahaan <span class="text-red-600">*</span>
                        </label>
                        <textarea id="alamat" name="alamat" rows="3" required
                            class="block w-full rounded-xl border-slate-300 focus:border-blue-700 focus:ring-blue-700 text-sm"
                            placeholder="Alamat lengkap perusahaan">{{ old('alamat', $vendor->alamat) }}</textarea>
                        @error('alamat')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mt-7 flex flex-col sm:flex-row gap-3">
                        <button type="submit"
                            class="flex-1 inline-flex items-center justify-center px-5 py-3 bg-blue-900 text-white rounded-xl font-semibold hover:bg-blue-950 transition">
                            Kirim Ulang Registrasi
                        </button>

                        <a href="{{ route('vendor.dashboard') }}"
                            class="flex-1 inline-flex items-center justify-center px-5 py-3 bg-slate-100 text-slate-700 rounded-xl font-semibold hover:bg-slate-200 transition">
                            Batal
                        </a>
                    </div>
                </form>
            </div>
        </div>

    </div>
</x-app-layout>
