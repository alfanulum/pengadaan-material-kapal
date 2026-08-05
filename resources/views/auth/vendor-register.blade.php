<x-guest-layout>
    <div
        class="min-h-screen flex items-center justify-center bg-gradient-to-br from-slate-950 via-blue-950 to-blue-900 px-6 py-10">

        <div class="w-full max-w-5xl bg-white rounded-3xl shadow-2xl overflow-hidden grid grid-cols-1 lg:grid-cols-2">

            <!-- Left Section -->
            <div
                class="hidden lg:flex flex-col justify-between p-10 bg-gradient-to-br from-blue-950 via-blue-900 to-cyan-800 text-white relative overflow-hidden">
                <div class="absolute -top-24 -left-24 w-72 h-72 bg-cyan-400/20 rounded-full blur-3xl"></div>
                <div class="absolute bottom-0 right-0 w-72 h-72 bg-blue-400/20 rounded-full blur-3xl"></div>

                <div class="relative z-10">
                    <h1 class="text-3xl font-bold tracking-wide">
                        PT PAL INDONESIA
                    </h1>
                    <p class="mt-2 text-blue-100">
                        Sistem Informasi Pengadaan Material Kapal
                    </p>
                </div>

                <div class="relative z-10">
                    <span class="inline-flex px-4 py-2 rounded-full bg-white/10 border border-white/10 text-sm text-blue-100 mb-5">
                        Registrasi Vendor
                    </span>
                    <h2 class="text-4xl font-bold leading-tight mb-4">
                        Daftarkan Perusahaan Anda sebagai Vendor
                    </h2>
                    <p class="text-blue-100 leading-relaxed">
                        Setelah registrasi, akun Anda akan diverifikasi oleh tim Supply Chain.
                        Vendor yang telah disetujui dapat mengikuti tender pengadaan material kapal.
                    </p>

                    <div class="mt-8 space-y-3 text-blue-100">
                        <div class="flex items-center gap-3">
                            <div class="w-7 h-7 rounded-full bg-white/20 flex items-center justify-center text-sm font-bold shrink-0">1</div>
                            <p class="text-sm">Isi formulir registrasi perusahaan</p>
                        </div>
                        <div class="flex items-center gap-3">
                            <div class="w-7 h-7 rounded-full bg-white/20 flex items-center justify-center text-sm font-bold shrink-0">2</div>
                            <p class="text-sm">Tunggu verifikasi dari Supply Chain</p>
                        </div>
                        <div class="flex items-center gap-3">
                            <div class="w-7 h-7 rounded-full bg-white/20 flex items-center justify-center text-sm font-bold shrink-0">3</div>
                            <p class="text-sm">Akun disetujui → Ikuti tender pengadaan</p>
                        </div>
                    </div>
                </div>

                <div class="relative z-10 text-sm text-blue-100">
                    © {{ date('Y') }} PT PAL Indonesia
                </div>
            </div>

            <!-- Right Section -->
            <div class="p-8 md:p-10 overflow-y-auto max-h-screen">
                <div class="mb-6">
                    <h2 class="text-2xl font-bold text-slate-900">
                        Daftar sebagai Vendor
                    </h2>
                    <p class="mt-1 text-slate-500 text-sm">
                        Isi data perusahaan dan akun Anda untuk mendaftar sebagai Vendor.
                    </p>
                </div>

                @if ($errors->any())
                    <div class="mb-4 p-4 bg-red-50 border border-red-200 text-red-700 rounded-xl text-sm">
                        <p class="font-semibold mb-1">Terdapat kesalahan pada formulir:</p>
                        <ul class="list-disc list-inside space-y-1">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('vendor.register.store') }}">
                    @csrf

                    {{-- ===== DATA PERUSAHAAN ===== --}}
                    <p class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-3">Data Perusahaan</p>

                    <div>
                        <x-input-label for="nama_vendor" value="Nama Perusahaan / Vendor *" class="auth-label" />
                        <x-text-input id="nama_vendor"
                            class="auth-input"
                            type="text" name="nama_vendor" :value="old('nama_vendor')" required autofocus
                            placeholder="Contoh: PT. Sumber Jaya Makmur" />
                        <x-input-error :messages="$errors->get('nama_vendor')" class="mt-2" />
                    </div>

                    <div class="mt-4">
                        <x-input-label for="pic" value="Nama PIC / Penanggung Jawab *" class="auth-label" />
                        <x-text-input id="pic"
                            class="auth-input"
                            type="text" name="pic" :value="old('pic')" required
                            placeholder="Nama penanggung jawab perusahaan" />
                        <x-input-error :messages="$errors->get('pic')" class="mt-2" />
                    </div>

                    <div class="mt-4">
                        <x-input-label for="telepon" value="Nomor Telepon *" class="auth-label" />
                        <x-text-input id="telepon"
                            class="auth-input"
                            type="text" name="telepon" :value="old('telepon')" required
                            placeholder="Contoh: 031-xxxxxxxx atau 08xxxxxxxxxx" />
                        <x-input-error :messages="$errors->get('telepon')" class="mt-2" />
                    </div>

                    <div class="mt-4">
                        <x-input-label for="kategori" value="Kategori Vendor" class="auth-label" />
                        <x-text-input id="kategori"
                            class="auth-input"
                            type="text" name="kategori" :value="old('kategori')"
                            placeholder="Contoh: Material Baja, Elektronik Kapal, Peralatan Mesin" />
                        <x-input-error :messages="$errors->get('kategori')" class="mt-2" />
                        <p class="text-xs text-slate-400 mt-1">Opsional. Isi kategori produk/jasa yang disediakan.</p>
                    </div>

                    <div class="mt-4">
                        <x-input-label for="alamat" value="Alamat Perusahaan *" class="auth-label" />
                        <textarea id="alamat" name="alamat" rows="3" required
                            class="auth-input text-sm"
                            placeholder="Alamat lengkap perusahaan">{{ old('alamat') }}</textarea>
                        <x-input-error :messages="$errors->get('alamat')" class="mt-2" />
                    </div>

                    {{-- ===== DATA AKUN ===== --}}
                    <p class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-3 mt-6">Data Akun</p>

                    <div>
                        <x-input-label for="email" value="Email *" class="auth-label" />
                        <x-text-input id="email"
                            class="auth-input"
                            type="email" name="email" :value="old('email')" required autocomplete="username"
                            placeholder="email@perusahaan.com" />
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <div class="mt-4">
                        <x-input-label for="password" value="Password *" class="auth-label" />
                        <x-text-input id="password"
                            class="auth-input"
                            type="password" name="password" required autocomplete="new-password"
                            placeholder="Minimal 8 karakter" />
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    <div class="mt-4">
                        <x-input-label for="password_confirmation" value="Konfirmasi Password *" class="auth-label" />
                        <x-text-input id="password_confirmation"
                            class="auth-input"
                            type="password" name="password_confirmation" required autocomplete="new-password"
                            placeholder="Ulangi password Anda" />
                        <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                    </div>

                    <button type="submit"
                        class="w-full mt-7 py-3 bg-blue-900 text-white font-semibold rounded-xl shadow-lg hover:bg-blue-950 transition">
                        Kirim Registrasi Vendor
                    </button>

                    <div class="mt-4 text-center text-sm text-slate-600">
                        Sudah punya akun?
                        <a href="{{ route('login') }}" class="font-semibold text-blue-800 hover:text-blue-950">
                            Login di sini
                        </a>
                    </div>

                    <div class="mt-3 text-center">
                        <a href="{{ url('/') }}" class="text-sm text-slate-500 hover:text-blue-800">
                            ← Kembali ke halaman utama
                        </a>
                    </div>
                </form>
            </div>

        </div>
    </div>
</x-guest-layout>
