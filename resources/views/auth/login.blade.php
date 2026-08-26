<x-guest-layout>
    <div class="min-h-screen flex items-center justify-center p-4 sm:p-6 lg:p-8 bg-[#0B1120] relative overflow-hidden">
        <!-- Subtle Navy Background Aura & Grid (Consistent with Homepage) -->
        <div class="absolute inset-0 z-0 pointer-events-none overflow-hidden">
            <div class="absolute inset-0 bg-[url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNjAiIGhlaWdodD0iNjAiIHZpZXdCb3g9IjAgMCA2MCA2MCIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj48ZyBmaWxsPSJub25lIiBmaWxsLXJ1bGU9ImV2ZW5vZGQiPjxnIGZpbGw9IiMzMzQxNTUiIGZpbGwtb3BhY2l0eT0iMC4wOCI+PHBhdGggZD0iTTM2IDM0aDEydjEySDM2eiIvPjwvZz48L2c+PC9zdmc+')] opacity-50"></div>
            <div class="absolute -top-24 -left-24 w-96 h-96 bg-blue-600/15 rounded-full blur-[120px]"></div>
            <div class="absolute -bottom-24 -right-24 w-96 h-96 bg-indigo-600/15 rounded-full blur-[120px]"></div>
        </div>

        <!-- Main Card Container (Split Layout) -->
        <div class="relative z-10 w-full max-w-4xl bg-white rounded-2xl shadow-2xl shadow-black/50 border border-slate-800/80 overflow-hidden grid grid-cols-1 lg:grid-cols-12 min-h-[540px]">

            <!-- ================= SISI KIRI: Identitas PT XYZ (Navy Enterprise) ================= -->
            <div class="lg:col-span-5 bg-[#080E1B] bg-gradient-to-b from-[#0B1120] via-[#080E1B] to-[#060A14] p-8 sm:p-10 lg:p-12 flex flex-col justify-between text-white relative border-b lg:border-b-0 lg:border-r border-slate-800">
                <div>
                    <!-- Logo PT XYZ -->
                    <div class="w-14 h-14 bg-gradient-to-br from-blue-600 via-blue-500 to-indigo-600 rounded-2xl flex items-center justify-center text-white shadow-lg shadow-blue-500/25 ring-1 ring-white/10 mb-6">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                        </svg>
                    </div>

                    <!-- Nama Perusahaan -->
                    <h1 class="text-2xl sm:text-3xl font-bold text-white tracking-tight">
                        PT XYZ
                    </h1>

                    <!-- Subjudul Sistem -->
                    <p class="mt-2.5 text-slate-300 text-sm font-medium leading-relaxed">
                        Sistem Informasi Manajemen Supply Chain Pengadaan Material Kapal
                    </p>

                    <!-- Deskripsi Singkat -->
                    <p class="mt-4 text-slate-400 text-xs sm:text-sm leading-relaxed">
                        Akses sistem pengadaan material kapal secara terstruktur.
                    </p>
                </div>

                <!-- Footer Sisi Kiri -->
                <div class="mt-8 pt-6 border-t border-slate-800 text-xs text-slate-400">
                    &copy; 2026 PT XYZ
                </div>
            </div>

            <!-- ================= SISI KANAN: Form Login (Clean Light-Blue Tint) ================= -->
            <div class="lg:col-span-7 bg-[#FBFDFF] p-8 sm:p-10 lg:p-12 flex flex-col justify-center">
                <div class="mb-6">
                    <h2 class="text-2xl sm:text-3xl font-bold text-slate-900 tracking-tight">
                        Login Sistem
                    </h2>
                    <p class="mt-1.5 text-sm text-slate-500">
                        Masukkan akun Anda untuk mengakses sistem.
                    </p>
                </div>

                <!-- Flash Messages -->
                <x-auth-session-status class="mb-4" :status="session('status')" />

                @if (session('success'))
                    <div class="mb-5 p-3.5 bg-blue-50 border border-blue-200 text-blue-800 rounded-xl text-sm flex items-center gap-2">
                        <svg class="w-4 h-4 text-blue-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        <span>{{ session('success') }}</span>
                    </div>
                @endif

                @if (session('error'))
                    <div class="mb-5 p-3.5 bg-red-50 border border-red-200 text-red-700 rounded-xl text-sm flex items-center gap-2">
                        <svg class="w-4 h-4 text-red-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                        <span>{{ session('error') }}</span>
                    </div>
                @endif

                <!-- Login Form -->
                <form method="POST" action="{{ route('login') }}" class="space-y-4">
                    @csrf

                    <!-- Email Field -->
                    <div>
                        <label for="email" class="block text-sm font-medium text-slate-700 mb-1.5">
                            Email
                        </label>
                        <input id="email"
                            type="email"
                            name="email"
                            value="{{ old('email') }}"
                            required
                            autofocus
                            autocomplete="username"
                            placeholder="nama@email.com"
                            class="w-full px-4 py-3 bg-[#F0F5FA]/70 border border-slate-200 focus:bg-white focus:border-blue-600 focus:ring-2 focus:ring-blue-100 rounded-xl text-slate-900 text-sm transition placeholder-slate-400 outline-none" />
                        <x-input-error :messages="$errors->get('email')" class="mt-1.5 text-xs text-red-600" />
                    </div>

                    <!-- Password Field -->
                    <div>
                        <label for="password" class="block text-sm font-medium text-slate-700 mb-1.5">
                            Password
                        </label>
                        <div class="relative">
                            <input id="password"
                                type="password"
                                name="password"
                                required
                                autocomplete="current-password"
                                placeholder="Masukkan password"
                                class="w-full pl-4 pr-11 py-3 bg-[#F0F5FA]/70 border border-slate-200 focus:bg-white focus:border-blue-600 focus:ring-2 focus:ring-blue-100 rounded-xl text-slate-900 text-sm transition placeholder-slate-400 outline-none" />
                            <button type="button" id="toggle-password" class="absolute inset-y-0 right-0 flex items-center pr-3.5 text-slate-400 hover:text-slate-600 focus:outline-none transition">
                                <svg id="eye-icon" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                                <svg id="eye-off-icon" class="h-5 w-5 hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a10.025 10.025 0 014.132-5.4M9.75 9.75l4.5 4.5m0-4.5l-4.5 4.5M21 12a10.025 10.025 0 01-4.132 5.4M3 3l18 18" />
                                </svg>
                            </button>
                        </div>
                        <x-input-error :messages="$errors->get('password')" class="mt-1.5 text-xs text-red-600" />
                    </div>

                    <!-- Remember Me & Forgot Password -->
                    <div class="flex items-center justify-between pt-1">
                        <label for="remember_me" class="inline-flex items-center cursor-pointer">
                            <input id="remember_me"
                                type="checkbox"
                                name="remember"
                                class="w-4 h-4 rounded border-slate-300 text-blue-600 focus:ring-blue-500 cursor-pointer">
                            <span class="ms-2 text-sm text-slate-600 select-none">
                                Ingat saya
                            </span>
                        </label>

                        @if (Route::has('password.request'))
                            <a class="text-sm text-blue-600 hover:text-blue-700 font-medium transition"
                                href="{{ route('password.request') }}">
                                Lupa password?
                            </a>
                        @endif
                    </div>

                    <!-- Submit Button -->
                    <button type="submit"
                        class="w-full mt-2 py-3 px-4 bg-blue-600 hover:bg-blue-500 active:bg-blue-700 text-white text-sm font-semibold rounded-xl shadow-md shadow-blue-600/25 transition-all active:scale-[0.99] flex items-center justify-center">
                        Masuk
                    </button>

                    <!-- Opsi Rekanan Vendor -->
                    <div class="mt-6 pt-5 border-t border-slate-100 text-center text-sm text-slate-600">
                        Rekanan baru?
                        <a href="{{ route('vendor.register') }}" class="font-semibold text-blue-600 hover:text-blue-700 ml-1 transition">
                            Daftar Vendor
                        </a>
                    </div>

                    <!-- Link Kembali ke Halaman Utama -->
                    <div class="mt-3 text-center">
                        <a href="{{ url('/') }}" class="text-xs text-slate-500 hover:text-blue-600 inline-flex items-center gap-1.5 transition">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                            </svg>
                            Kembali ke Halaman Utama
                        </a>
                    </div>
                </form>
            </div>

        </div>
    </div>

    <!-- Toggle Password Script -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const togglePassword = document.querySelector('#toggle-password');
            const passwordInput = document.querySelector('#password');
            const eyeIcon = document.querySelector('#eye-icon');
            const eyeOffIcon = document.querySelector('#eye-off-icon');

            if (togglePassword && passwordInput) {
                togglePassword.addEventListener('click', function () {
                    const isPassword = passwordInput.getAttribute('type') === 'password';
                    passwordInput.setAttribute('type', isPassword ? 'text' : 'password');
                    
                    if (isPassword) {
                        eyeIcon.classList.add('hidden');
                        eyeOffIcon.classList.remove('hidden');
                    } else {
                        eyeIcon.classList.remove('hidden');
                        eyeOffIcon.classList.add('hidden');
                    }
                });
            }
        });
    </script>
</x-guest-layout>
