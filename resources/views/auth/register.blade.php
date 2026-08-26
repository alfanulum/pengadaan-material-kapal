<x-guest-layout>
    <div class="min-h-screen flex items-center justify-center p-4 sm:p-6 lg:p-10 relative bg-[#060913]">
        <!-- Background Grid -->
        <div class="absolute inset-0 z-0 pointer-events-none overflow-hidden">
            <div class="absolute inset-0 bg-[linear-gradient(to_right,#1e293b15_1px,transparent_1px),linear-gradient(to_bottom,#1e293b15_1px,transparent_1px)] bg-[size:32px_32px]"></div>
            <div class="absolute top-0 left-1/4 w-96 h-96 bg-blue-900/15 rounded-full blur-3xl"></div>
            <div class="absolute bottom-0 right-1/4 w-96 h-96 bg-indigo-900/15 rounded-full blur-3xl"></div>
        </div>

        <div class="relative z-10 w-full max-w-5xl bg-[#0B1120] border border-slate-800/90 rounded-2xl shadow-2xl overflow-hidden grid grid-cols-1 lg:grid-cols-12">

            <!-- Left Section -->
            <div class="lg:col-span-5 bg-[#080E1B] border-b lg:border-b-0 lg:border-r border-slate-800 p-8 sm:p-10 flex flex-col justify-between relative overflow-hidden">
                <div class="absolute top-0 left-0 right-0 h-[2px] bg-gradient-to-r from-slate-900 to-blue-900"></div>

                <div>
                    <div class="flex items-center gap-3.5 mb-8">
                        <div class="w-11 h-11 bg-gradient-to-br from-blue-600 to-blue-700 flex items-center justify-center rounded-xl shadow-md shadow-blue-900/40 ring-1 ring-white/10 shrink-0">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                            </svg>
                        </div>
                        <div>
                            <h1 class="text-xl font-bold text-white tracking-tight leading-none">PT XYZ</h1>
                            <p class="text-xs text-slate-400 font-medium mt-1">Sistem Informasi Manajemen Supply Chain</p>
                        </div>
                    </div>

                    <div class="mt-6">
                        <h2 class="text-2xl sm:text-3xl font-bold text-white tracking-tight mb-3">
                            Registrasi Akun Internal
                        </h2>
                        <p class="text-slate-400 text-sm leading-relaxed">
                            Pendaftaran akun staf internal untuk modul Engineer, Planner, Supply Chain, dan Gudang.
                        </p>
                    </div>

                    <div class="mt-6 space-y-2.5 text-xs text-slate-300">
                        <div class="flex items-center gap-2.5 bg-[#0e1626] border border-slate-800 rounded-lg p-2.5">
                            <svg class="w-4 h-4 text-blue-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            <span>Otorisasi berbasis peran kerja terstruktur</span>
                        </div>
                        <div class="flex items-center gap-2.5 bg-[#0e1626] border border-slate-800 rounded-lg p-2.5">
                            <svg class="w-4 h-4 text-indigo-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            <span>Workflow persetujuan pengadaan material</span>
                        </div>
                    </div>
                </div>

                <div class="pt-6 border-t border-slate-800/80 text-xs text-slate-400 mt-6">
                    <p class="font-medium text-slate-300">PT XYZ</p>
                    <p class="text-slate-400 text-[11px] mt-0.5">Sistem Informasi Manajemen Supply Chain Pengadaan Material Kapal</p>
                    <p class="text-slate-400 text-[11px] mt-2">&copy; 2026 PT XYZ</p>
                </div>
            </div>

            <!-- Right Section -->
            <div class="lg:col-span-7 p-8 sm:p-10 flex flex-col justify-center bg-[#0B1120]">
                <div class="mb-6">
                    <h2 class="text-2xl font-bold text-white tracking-tight">
                        Buat Akun Sistem
                    </h2>
                    <p class="mt-1 text-sm text-slate-400">
                        Isi formulir berikut untuk registrasi akun sistem.
                    </p>
                </div>

                <form method="POST" action="{{ route('register') }}" class="space-y-4">
                    @csrf

                    <div>
                        <label for="name" class="block text-xs font-semibold text-slate-300 uppercase tracking-wider mb-2">Nama Lengkap</label>
                        <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name"
                            placeholder="Nama lengkap staf"
                            class="w-full bg-[#101726] border border-slate-700/80 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 text-white placeholder-slate-400 rounded-xl px-4 py-3 text-sm transition outline-none" />
                        <x-input-error :messages="$errors->get('name')" class="mt-1" />
                    </div>

                    <div>
                        <label for="email" class="block text-xs font-semibold text-slate-300 uppercase tracking-wider mb-2">Email Perusahaan</label>
                        <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="username"
                            placeholder="nama@company.com"
                            class="w-full bg-[#101726] border border-slate-700/80 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 text-white placeholder-slate-400 rounded-xl px-4 py-3 text-sm transition outline-none" />
                        <x-input-error :messages="$errors->get('email')" class="mt-1" />
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label for="password" class="block text-xs font-semibold text-slate-300 uppercase tracking-wider mb-2">Password</label>
                            <input id="password" type="password" name="password" required autocomplete="new-password"
                                placeholder="••••••••"
                                class="w-full bg-[#101726] border border-slate-700/80 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 text-white placeholder-slate-400 rounded-xl px-4 py-3 text-sm transition outline-none" />
                            <x-input-error :messages="$errors->get('password')" class="mt-1" />
                        </div>
                        <div>
                            <label for="password_confirmation" class="block text-xs font-semibold text-slate-300 uppercase tracking-wider mb-2">Konfirmasi Password</label>
                            <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password"
                                placeholder="••••••••"
                                class="w-full bg-[#101726] border border-slate-700/80 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 text-white placeholder-slate-400 rounded-xl px-4 py-3 text-sm transition outline-none" />
                            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-1" />
                        </div>
                    </div>

                    <button type="submit"
                        class="w-full mt-2 py-3 px-4 bg-blue-600 hover:bg-blue-500 active:bg-blue-700 text-white text-sm font-semibold rounded-xl shadow-md shadow-blue-600/20 transition-all flex items-center justify-center gap-2">
                        <span>Daftar Akun</span>
                    </button>

                    <div class="pt-2 flex items-center justify-between text-xs text-slate-400">
                        <div>
                            Sudah punya akun?
                            <a href="{{ route('login') }}" class="font-medium text-blue-400 hover:text-blue-300">
                                Login di sini
                            </a>
                        </div>
                        <a href="{{ url('/') }}" class="hover:text-slate-200 transition">
                            ← Halaman Utama
                        </a>
                    </div>
                </form>
            </div>

        </div>
    </div>
</x-guest-layout>
