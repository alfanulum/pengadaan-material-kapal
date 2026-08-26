<x-guest-layout>
    <div class="min-h-screen flex items-center justify-center p-4 sm:p-6 lg:p-8 bg-[#0B1120] relative overflow-hidden">
        <!-- Navy Background Aura & Grid -->
        <div class="absolute inset-0 z-0 pointer-events-none overflow-hidden">
            <div class="absolute inset-0 bg-[url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNjAiIGhlaWdodD0iNjAiIHZpZXdCb3g9IjAgMCA2MCA2MCIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj48ZyBmaWxsPSJub25lIiBmaWxsLXJ1bGU9ImV2ZW5vZGQiPjxnIGZpbGw9IiMzMzQxNTUiIGZpbGwtb3BhY2l0eT0iMC4wOCI+PHBhdGggZD0iTTM2IDM0aDEydjEySDM2eiIvPjwvZz48L2c+PC9zdmc+')] opacity-50"></div>
            <div class="absolute -top-24 -left-24 w-96 h-96 bg-blue-600/15 rounded-full blur-[120px]"></div>
            <div class="absolute -bottom-24 -right-24 w-96 h-96 bg-indigo-600/15 rounded-full blur-[120px]"></div>
        </div>

        <div class="relative z-10 w-full max-w-4xl bg-white rounded-2xl shadow-2xl shadow-black/50 border border-slate-800/80 overflow-hidden grid grid-cols-1 lg:grid-cols-12 min-h-[580px]">

            <!-- Left: Navy Brand -->
            <div class="lg:col-span-5 bg-[#080E1B] bg-gradient-to-b from-[#0B1120] via-[#080E1B] to-[#060A14] p-8 sm:p-10 lg:p-12 flex flex-col justify-between text-white relative border-b lg:border-b-0 lg:border-r border-slate-800">
                <div>
                    <div class="w-14 h-14 bg-gradient-to-br from-blue-600 via-blue-500 to-indigo-600 rounded-2xl flex items-center justify-center text-white shadow-lg shadow-blue-500/25 ring-1 ring-white/10 mb-6">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                        </svg>
                    </div>

                    <h1 class="text-2xl sm:text-3xl font-bold text-white tracking-tight">
                        PT XYZ
                    </h1>

                    <p class="mt-2.5 text-slate-300 text-sm font-medium leading-relaxed">
                        Sistem Informasi Manajemen Supply Chain Pengadaan Material Kapal
                    </p>

                    <p class="mt-4 text-slate-400 text-xs sm:text-sm leading-relaxed">
                        Pendaftaran akun rekanan vendor untuk proses pengadaan material kapal.
                    </p>
                </div>

                <div class="mt-8 pt-6 border-t border-slate-800 text-xs text-slate-400">
                    &copy; 2026 PT XYZ
                </div>
            </div>

            <!-- Right: Light Form -->
            <div class="lg:col-span-7 bg-[#FBFDFF] p-8 sm:p-10 lg:p-12 flex flex-col justify-center max-h-[90vh] overflow-y-auto">
                <div class="mb-6">
                    <h2 class="text-2xl sm:text-3xl font-bold text-slate-900 tracking-tight">
                        Daftar Vendor
                    </h2>
                    <p class="mt-1.5 text-sm text-slate-500">
                        Lengkapi profil perusahaan Anda untuk mendaftar sebagai vendor.
                    </p>
                </div>

                @if ($errors->any())
                    <div class="mb-5 p-3.5 bg-red-50 border border-red-200 text-red-700 rounded-xl text-xs">
                        <p class="font-semibold mb-1">Terdapat kesalahan:</p>
                        <ul class="list-disc list-inside space-y-0.5">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('vendor.register.store') }}" class="space-y-4">
                    @csrf

                    <div>
                        <label for="nama_vendor" class="block text-sm font-medium text-slate-700 mb-1">Nama Perusahaan *</label>
                        <input id="nama_vendor" type="text" name="nama_vendor" value="{{ old('nama_vendor') }}" required autofocus
                            placeholder="PT. Sumber Material"
                            class="w-full px-4 py-2.5 bg-[#F0F5FA]/70 border border-slate-200 focus:bg-white focus:border-blue-600 focus:ring-2 focus:ring-blue-100 rounded-xl text-slate-900 text-sm transition placeholder-slate-400 outline-none" />
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label for="pic" class="block text-sm font-medium text-slate-700 mb-1">Nama PIC *</label>
                            <input id="pic" type="text" name="pic" value="{{ old('pic') }}" required
                                placeholder="Nama PIC"
                                class="w-full px-4 py-2.5 bg-[#F0F5FA]/70 border border-slate-200 focus:bg-white focus:border-blue-600 focus:ring-2 focus:ring-blue-100 rounded-xl text-slate-900 text-sm transition placeholder-slate-400 outline-none" />
                        </div>
                        <div>
                            <label for="telepon" class="block text-sm font-medium text-slate-700 mb-1">Nomor Telepon *</label>
                            <input id="telepon" type="text" name="telepon" value="{{ old('telepon') }}" required
                                placeholder="08xxxxxxxxxx"
                                class="w-full px-4 py-2.5 bg-[#F0F5FA]/70 border border-slate-200 focus:bg-white focus:border-blue-600 focus:ring-2 focus:ring-blue-100 rounded-xl text-slate-900 text-sm transition placeholder-slate-400 outline-none" />
                        </div>
                    </div>

                    <div>
                        <label for="kategori" class="block text-sm font-medium text-slate-700 mb-1">Kategori Usaha</label>
                        <input id="kategori" type="text" name="kategori" value="{{ old('kategori') }}"
                            placeholder="Contoh: Plat Baja, Mesin Propulsi"
                            class="w-full px-4 py-2.5 bg-[#F0F5FA]/70 border border-slate-200 focus:bg-white focus:border-blue-600 focus:ring-2 focus:ring-blue-100 rounded-xl text-slate-900 text-sm transition placeholder-slate-400 outline-none" />
                    </div>

                    <div>
                        <label for="alamat" class="block text-sm font-medium text-slate-700 mb-1">Alamat Lengkap *</label>
                        <textarea id="alamat" name="alamat" rows="2" required
                            placeholder="Alamat kantor / gudang"
                            class="w-full px-4 py-2.5 bg-[#F0F5FA]/70 border border-slate-200 focus:bg-white focus:border-blue-600 focus:ring-2 focus:ring-blue-100 rounded-xl text-slate-900 text-sm transition placeholder-slate-400 outline-none">{{ old('alamat') }}</textarea>
                    </div>

                    <div>
                        <label for="email" class="block text-sm font-medium text-slate-700 mb-1">Email Perusahaan (Untuk Login) *</label>
                        <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="username"
                            placeholder="vendor@company.com"
                            class="w-full px-4 py-2.5 bg-[#F0F5FA]/70 border border-slate-200 focus:bg-white focus:border-blue-600 focus:ring-2 focus:ring-blue-100 rounded-xl text-slate-900 text-sm transition placeholder-slate-400 outline-none" />
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label for="password" class="block text-sm font-medium text-slate-700 mb-1">Password *</label>
                            <input id="password" type="password" name="password" required autocomplete="new-password"
                                placeholder="Minimal 8 karakter"
                                class="w-full px-4 py-2.5 bg-[#F0F5FA]/70 border border-slate-200 focus:bg-white focus:border-blue-600 focus:ring-2 focus:ring-blue-100 rounded-xl text-slate-900 text-sm transition placeholder-slate-400 outline-none" />
                        </div>
                        <div>
                            <label for="password_confirmation" class="block text-sm font-medium text-slate-700 mb-1">Konfirmasi Password *</label>
                            <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password"
                                placeholder="Ulangi password"
                                class="w-full px-4 py-2.5 bg-[#F0F5FA]/70 border border-slate-200 focus:bg-white focus:border-blue-600 focus:ring-2 focus:ring-blue-100 rounded-xl text-slate-900 text-sm transition placeholder-slate-400 outline-none" />
                        </div>
                    </div>

                    <button type="submit"
                        class="w-full mt-2 py-3 px-4 bg-blue-600 hover:bg-blue-500 active:bg-blue-700 text-white text-sm font-semibold rounded-xl shadow-md shadow-blue-600/25 transition-all active:scale-[0.99] flex items-center justify-center">
                        Kirim Registrasi Vendor
                    </button>

                    <div class="mt-4 pt-4 border-t border-slate-100 flex items-center justify-between text-xs text-slate-600">
                        <div>
                            Sudah punya akun?
                            <a href="{{ route('login') }}" class="font-semibold text-blue-600 hover:text-blue-700 ml-1">
                                Login
                            </a>
                        </div>
                        <a href="{{ url('/') }}" class="text-slate-500 hover:text-blue-600">
                            ← Halaman Utama
                        </a>
                    </div>
                </form>
            </div>

        </div>
    </div>
</x-guest-layout>
