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
                        Masuk ke Sistem Procurement
                    </h2>
                    <p class="text-blue-100 leading-relaxed">
                        Kelola pengajuan material, verifikasi planner, tender vendor,
                        purchase order, dan monitoring pengadaan secara terintegrasi.
                    </p>

                    <div class="mt-8 grid grid-cols-2 gap-4">
                        <div class="bg-white/10 border border-white/10 rounded-2xl p-4">
                            <p class="text-2xl font-bold">6</p>
                            <p class="text-sm text-blue-100">Role Sistem</p>
                        </div>

                        <div class="bg-white/10 border border-white/10 rounded-2xl p-4">
                            <p class="text-2xl font-bold">Real-time</p>
                            <p class="text-sm text-blue-100">Monitoring</p>
                        </div>
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
                        Login Sistem
                    </h2>
                    <p class="mt-2 text-slate-500">
                        Masukkan email dan password untuk mengakses sistem.
                    </p>
                </div>

                <x-auth-session-status class="mb-4" :status="session('status')" />

                @if (session('success'))
                    <div class="mb-4 p-4 bg-green-100 text-green-700 rounded-xl">
                        {{ session('success') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <div>
                        <x-input-label for="email" value="Email" />
                        <x-text-input id="email"
                            class="block mt-2 w-full rounded-xl border-slate-300 focus:border-blue-700 focus:ring-blue-700"
                            type="email" name="email" :value="old('email')" required autofocus
                            autocomplete="username" />
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <div class="mt-5">
                        <x-input-label for="password" value="Password" />
                        <div class="relative mt-2">
                            <x-text-input id="password"
                                class="block w-full pr-10 rounded-xl border-slate-300 focus:border-blue-700 focus:ring-blue-700"
                                type="password" name="password" required autocomplete="current-password" />
                            <button type="button" id="toggle-password" class="absolute inset-y-0 right-0 flex items-center pr-3 text-slate-400 hover:text-slate-600 focus:outline-none">
                                <svg id="eye-icon" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                                <svg id="eye-off-icon" class="h-5 w-5 hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a10.025 10.025 0 014.132-5.4M9.75 9.75l4.5 4.5m0-4.5l-4.5 4.5M21 12a10.025 10.025 0 01-4.132 5.4M3 3l18 18" />
                                </svg>
                            </button>
                        </div>
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    <div class="flex items-center justify-between mt-5">
                        <label for="remember_me" class="inline-flex items-center">
                            <input id="remember_me" type="checkbox"
                                class="rounded border-slate-300 text-blue-800 shadow-sm focus:ring-blue-700"
                                name="remember">
                            <span class="ms-2 text-sm text-slate-600">
                                Ingat saya
                            </span>
                        </label>

                        @if (Route::has('password.request'))
                            <a class="text-sm text-blue-800 hover:text-blue-950 font-medium"
                                href="{{ route('password.request') }}">
                                Lupa password?
                            </a>
                        @endif
                    </div>

                    <button type="submit"
                        class="w-full mt-8 py-3 bg-blue-900 text-white font-semibold rounded-xl shadow-lg hover:bg-blue-950 transition">
                        Masuk
                    </button>

                    <div class="mt-6 text-center text-sm text-slate-600">
                        Belum punya akun?
                        <a href="{{ route('register') }}" class="font-semibold text-blue-800 hover:text-blue-950">
                            Daftar sekarang
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

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const togglePassword = document.querySelector('#toggle-password');
            const passwordInput = document.querySelector('#password');
            const eyeIcon = document.querySelector('#eye-icon');
            const eyeOffIcon = document.querySelector('#eye-off-icon');

            if (togglePassword && passwordInput) {
                togglePassword.addEventListener('click', function () {
                    const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                    passwordInput.setAttribute('type', type);
                    
                    if (type === 'password') {
                        eyeIcon.classList.remove('hidden');
                        eyeOffIcon.classList.add('hidden');
                    } else {
                        eyeIcon.classList.add('hidden');
                        eyeOffIcon.classList.remove('hidden');
                    }
                });
            }
        });
    </script>
</x-guest-layout>
