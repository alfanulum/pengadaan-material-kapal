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
                    <h2 class="text-4xl font-bold leading-tight mb-4">
                        Registrasi Akun Sistem
                    </h2>
                    <p class="text-blue-100 leading-relaxed">
                        Buat akun untuk mengakses sistem pengadaan material kapal.
                        Setelah registrasi, silakan login menggunakan akun yang telah dibuat.
                    </p>

                    <div class="mt-8 space-y-3 text-blue-100">
                        <p>✓ Pengelolaan pengajuan material</p>
                        <p>✓ Workflow approval terstruktur</p>
                        <p>✓ Monitoring proses procurement</p>
                        <p>✓ Dokumentasi pengadaan terpusat</p>
                    </div>
                </div>

                <div class="relative z-10 text-sm text-blue-100">
                    © {{ date('Y') }} PT PAL Indonesia
                </div>
            </div>

            <!-- Right Section -->
            <div class="p-8 md:p-12">
                <div class="mb-8">
                    <h2 class="text-3xl font-bold text-slate-900">
                        Daftar Akun
                    </h2>
                    <p class="mt-2 text-slate-500">
                        Isi data berikut untuk membuat akun sistem.
                    </p>
                </div>

                <form method="POST" action="{{ route('register') }}">
                    @csrf

                    <div>
                        <x-input-label for="name" value="Nama Lengkap" />
                        <x-text-input id="name"
                            class="block mt-2 w-full rounded-xl border-slate-300 focus:border-blue-700 focus:ring-blue-700"
                            type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>

                    <div class="mt-5">
                        <x-input-label for="email" value="Email" />
                        <x-text-input id="email"
                            class="block mt-2 w-full rounded-xl border-slate-300 focus:border-blue-700 focus:ring-blue-700"
                            type="email" name="email" :value="old('email')" required autocomplete="username" />
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <div class="mt-5">
                        <x-input-label for="password" value="Password" />
                        <x-text-input id="password"
                            class="block mt-2 w-full rounded-xl border-slate-300 focus:border-blue-700 focus:ring-blue-700"
                            type="password" name="password" required autocomplete="new-password" />
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    <div class="mt-5">
                        <x-input-label for="password_confirmation" value="Konfirmasi Password" />
                        <x-text-input id="password_confirmation"
                            class="block mt-2 w-full rounded-xl border-slate-300 focus:border-blue-700 focus:ring-blue-700"
                            type="password" name="password_confirmation" required autocomplete="new-password" />
                        <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                    </div>

                    <button type="submit"
                        class="w-full mt-8 py-3 bg-blue-900 text-white font-semibold rounded-xl shadow-lg hover:bg-blue-950 transition">
                        Daftar
                    </button>

                    <div class="mt-6 text-center text-sm text-slate-600">
                        Sudah punya akun?
                        <a href="{{ route('login') }}" class="font-semibold text-blue-800 hover:text-blue-950">
                            Login di sini
                        </a>
                    </div>

                    <div class="mt-6 text-center">
                        <a href="{{ url('/') }}" class="text-sm text-slate-500 hover:text-blue-800">
                            ← Kembali ke halaman utama
                        </a>
                    </div>
                </form>
            </div>

        </div>
    </div>
</x-guest-layout>
