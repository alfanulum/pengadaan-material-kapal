<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Tambah Vendor
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 shadow rounded-lg">

                <form action="{{ route('supply-chain.vendors.store') }}" method="POST">
                    @csrf

                    <div class="mb-4">
                        <label class="block mb-1">Kode Vendor</label>
                        <input type="text" name="kode_vendor" value="{{ old('kode_vendor') }}"
                            class="w-full border-gray-300 rounded-lg">
                        @error('kode_vendor')
                            <p class="text-red-600 text-sm">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block mb-1">Nama Vendor</label>
                        <input type="text" name="nama_vendor" value="{{ old('nama_vendor') }}"
                            class="w-full border-gray-300 rounded-lg">
                        @error('nama_vendor')
                            <p class="text-red-600 text-sm">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block mb-1">Email</label>
                        <input type="email" name="email" value="{{ old('email') }}"
                            class="w-full border-gray-300 rounded-lg">
                        @error('email')
                            <p class="text-red-600 text-sm">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block mb-1">Telepon</label>
                        <input type="text" name="telepon" value="{{ old('telepon') }}"
                            class="w-full border-gray-300 rounded-lg">
                    </div>

                    <div class="mb-4">
                        <label class="block mb-1">PIC / Kontak Person</label>
                        <input type="text" name="pic" value="{{ old('pic') }}"
                            class="w-full border-gray-300 rounded-lg">
                    </div>

                    <div class="mb-4">
                        <label class="block mb-1">Kategori</label>
                        <input type="text" name="kategori" value="{{ old('kategori') }}"
                            placeholder="Contoh: Material Baja, Electrical, Mesin"
                            class="w-full border-gray-300 rounded-lg">
                    </div>

                    <div class="mb-4">
                        <label class="block mb-1">Alamat</label>
                        <textarea name="alamat" rows="3" class="w-full border-gray-300 rounded-lg">{{ old('alamat') }}</textarea>
                    </div>

                    <div class="mb-4">
                        <label class="block mb-1">Status</label>
                        <select name="status" class="w-full border-gray-300 rounded-lg">
                            <option value="aktif">Aktif</option>
                            <option value="nonaktif">Nonaktif</option>
                        </select>
                    </div>

                    <div class="flex justify-end gap-2">
                        <a href="{{ route('supply-chain.vendors.index') }}"
                            class="px-4 py-2 bg-gray-500 text-white rounded-lg">
                            Kembali
                        </a>

                        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg">
                            Simpan
                        </button>
                    </div>

                </form>

            </div>
        </div>
    </div>
</x-app-layout>
