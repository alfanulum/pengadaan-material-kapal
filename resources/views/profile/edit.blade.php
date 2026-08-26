<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3">
            <div>
                <h2 class="font-bold text-2xl text-slate-900 leading-tight">
                    Pengaturan Profil
                </h2>
                <p class="text-sm text-slate-500 mt-1">
                    Kelola informasi akun, email, dan keamanan kata sandi Anda.
                </p>
            </div>
            
            <a href="{{ route('dashboard') }}" class="inline-flex items-center gap-2 px-5 py-2.5 bg-white text-slate-700 rounded-xl font-semibold border border-slate-200 hover:bg-slate-50 transition shadow-sm text-sm">
                Kembali ke Dashboard
            </a>
        </div>
    </x-slot>

    <div class="py-8 relative z-10">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">
            
            {{-- Profile Information Card --}}
            <div class="bg-white shadow-sm border border-slate-200 rounded-3xl overflow-hidden">
                <div class="px-6 md:px-8 py-6 border-b border-slate-100 bg-slate-50/50">
                    <h3 class="text-lg font-bold text-slate-900">Informasi Profil</h3>
                    <p class="text-sm text-slate-500 mt-1">Perbarui nama lengkap dan alamat email akun Anda.</p>
                </div>
                <div class="p-6 md:p-8">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            {{-- Update Password Card --}}
            <div class="bg-white shadow-sm border border-slate-200 rounded-3xl overflow-hidden">
                <div class="px-6 md:px-8 py-6 border-b border-slate-100 bg-slate-50/50">
                    <h3 class="text-lg font-bold text-slate-900">Perbarui Kata Sandi</h3>
                    <p class="text-sm text-slate-500 mt-1">Pastikan akun Anda menggunakan kata sandi yang panjang dan acak agar tetap aman.</p>
                </div>
                <div class="p-6 md:p-8">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            {{-- Delete Account Card --}}
            <div class="bg-white shadow-sm border border-rose-100 rounded-3xl overflow-hidden relative group">
                <div class="absolute inset-0 bg-gradient-to-br from-rose-50/50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity"></div>
                <div class="relative z-10">
                    <div class="px-6 md:px-8 py-6 border-b border-rose-100 bg-rose-50/50">
                        <h3 class="text-lg font-bold text-rose-700">Hapus Akun</h3>
                        <p class="text-sm text-rose-600/80 mt-1">Hapus akun Anda beserta semua data yang terkait secara permanen.</p>
                    </div>
                    <div class="p-6 md:p-8">
                        @include('profile.partials.delete-user-form')
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
