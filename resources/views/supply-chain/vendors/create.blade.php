<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3">
            <div>
                <h2 class="font-bold text-2xl text-slate-900 leading-tight">
                    Tambah Vendor
                </h2>
                <p class="text-sm text-slate-500 mt-1">
                    Tambahkan data vendor baru untuk kebutuhan proses tender material kapal.
                </p>
            </div>

            <a href="{{ route('supply-chain.vendors.index') }}"
                class="inline-flex items-center justify-center px-4 py-2 bg-slate-900 text-white rounded-xl text-sm font-semibold hover:bg-slate-800 transition">
                Kembali ke Vendor
            </a>
        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        {{-- Hero --}}
        <div
            class="bg-gradient-to-r from-slate-950 via-blue-950 to-blue-800 rounded-3xl p-8 md:p-10 shadow-xl text-white mb-8 overflow-hidden relative">
            <div class="absolute -top-24 -right-24 w-80 h-80 bg-cyan-400/20 rounded-full blur-3xl"></div>
            <div class="absolute -bottom-24 -left-24 w-80 h-80 bg-blue-400/20 rounded-full blur-3xl"></div>

            <div class="relative z-10 max-w-4xl">
                <p
                    class="inline-flex px-4 py-2 rounded-full bg-white/10 border border-white/10 text-sm text-blue-100 mb-5">
                    Vendor Registration
                </p>

                <h3 class="text-3xl md:text-4xl font-bold leading-tight">
                    Input Data Vendor Penyedia Material
                </h3>

                <p class="mt-4 text-blue-100 max-w-3xl text-base leading-relaxed">
                    Lengkapi informasi vendor seperti identitas perusahaan, kontak, PIC,
                    kategori material, alamat, dan status vendor.
                </p>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

            {{-- Info Card --}}
            <div class="lg:col-span-1">
                <div class="bg-white rounded-3xl shadow-sm border border-slate-200 p-6 sticky top-6">
                    <div
                        class="w-14 h-14 rounded-2xl bg-blue-100 text-blue-900 flex items-center justify-center font-bold text-lg mb-4">
                        VD
                    </div>

                    <h3 class="text-lg font-bold text-slate-900">
                        Panduan Input Vendor
                    </h3>

                    <p class="text-sm text-slate-500 mt-2 leading-relaxed">
                        Pastikan email vendor aktif karena dapat digunakan untuk akun login vendor
                        dan undangan tender.
                    </p>

                    <div class="mt-6 space-y-4">
                        <div class="flex gap-3">
                            <span
                                class="w-7 h-7 rounded-full bg-blue-100 text-blue-900 flex items-center justify-center text-xs font-bold shrink-0">1</span>
                            <p class="text-sm text-slate-600">Isi kode dan nama vendor dengan jelas.</p>
                        </div>

                        <div class="flex gap-3">
                            <span
                                class="w-7 h-7 rounded-full bg-blue-100 text-blue-900 flex items-center justify-center text-xs font-bold shrink-0">2</span>
                            <p class="text-sm text-slate-600">Tambahkan email, telepon, dan PIC vendor.</p>
                        </div>

                        <div class="flex gap-3">
                            <span
                                class="w-7 h-7 rounded-full bg-blue-100 text-blue-900 flex items-center justify-center text-xs font-bold shrink-0">3</span>
                            <p class="text-sm text-slate-600">Pilih status aktif agar vendor bisa digunakan pada tender.
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Form --}}
            <div class="lg:col-span-2">
                <div class="bg-white rounded-3xl shadow-sm border border-slate-200 overflow-hidden">
                    <div class="px-6 py-5 border-b border-slate-200">
                        <h3 class="text-lg font-bold text-slate-900">
                            Form Tambah Vendor
                        </h3>
                        <p class="text-sm text-slate-500 mt-1">
                            Masukkan detail vendor baru.
                        </p>
                    </div>

                    <form action="{{ route('supply-chain.vendors.store') }}" method="POST" class="p-6 md:p-8">
                        @csrf

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-2">Kode Vendor</label>
                                <input type="text" name="kode_vendor" value="{{ old('kode_vendor') }}"
                                    class="w-full rounded-xl border-slate-300 focus:border-blue-800 focus:ring-blue-800"
                                    placeholder="Contoh: VND-001">
                                @error('kode_vendor')
                                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-2">Nama Vendor</label>
                                <input type="text" name="nama_vendor" value="{{ old('nama_vendor') }}"
                                    class="w-full rounded-xl border-slate-300 focus:border-blue-800 focus:ring-blue-800"
                                    placeholder="Contoh: CV Logam Samudra Jaya">
                                @error('nama_vendor')
                                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-2">Email</label>
                                <input type="email" name="email" value="{{ old('email') }}"
                                    class="w-full rounded-xl border-slate-300 focus:border-blue-800 focus:ring-blue-800"
                                    placeholder="vendor@email.com">
                                @error('email')
                                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-2">Telepon</label>
                                <input type="text" name="telepon" value="{{ old('telepon') }}"
                                    class="w-full rounded-xl border-slate-300 focus:border-blue-800 focus:ring-blue-800"
                                    placeholder="Contoh: 082145678901">
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-2">PIC / Kontak
                                    Person</label>
                                <input type="text" name="pic" value="{{ old('pic') }}"
                                    class="w-full rounded-xl border-slate-300 focus:border-blue-800 focus:ring-blue-800"
                                    placeholder="Contoh: Andi Pratama">
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-2">Status</label>
                                <select name="status"
                                    class="w-full rounded-xl border-slate-300 focus:border-blue-800 focus:ring-blue-800">
                                    <option value="aktif" {{ old('status') == 'aktif' ? 'selected' : '' }}>Aktif
                                    </option>
                                    <option value="nonaktif" {{ old('status') == 'nonaktif' ? 'selected' : '' }}>
                                        Nonaktif</option>
                                </select>
                            </div>

                            <div class="md:col-span-2">
                                <label class="block text-sm font-semibold text-slate-700 mb-2">Kategori</label>
                                <input type="text" name="kategori" value="{{ old('kategori') }}"
                                    class="w-full rounded-xl border-slate-300 focus:border-blue-800 focus:ring-blue-800"
                                    placeholder="Contoh: Material Baja, Electrical, Mesin">
                            </div>

                            <div class="md:col-span-2">
                                <label class="block text-sm font-semibold text-slate-700 mb-2">Alamat</label>
                                <textarea name="alamat" rows="4"
                                    class="w-full rounded-xl border-slate-300 focus:border-blue-800 focus:ring-blue-800"
                                    placeholder="Alamat lengkap vendor">{{ old('alamat') }}</textarea>
                            </div>
                        </div>

                        <div class="mt-8 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                            <a href="{{ route('supply-chain.vendors.index') }}"
                                class="inline-flex items-center justify-center px-5 py-3 bg-slate-100 text-slate-700 rounded-xl font-semibold hover:bg-slate-200 transition">
                                Kembali
                            </a>

                            <button type="submit"
                                class="inline-flex items-center justify-center px-6 py-3 bg-blue-900 text-white rounded-xl font-semibold shadow-lg hover:bg-blue-950 transition">
                                Simpan Vendor
                            </button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
