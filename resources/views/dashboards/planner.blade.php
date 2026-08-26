<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3">
            <div>
                <h2 class="font-bold text-2xl text-slate-900 leading-tight">
                    Dashboard Planner
                </h2>
                <p class="text-sm text-slate-500 mt-1">
                    Verifikasi pengajuan material dari Engineer sebelum diproses ke Supply Chain.
                </p>
            </div>

            <div class="inline-flex items-center gap-2 text-sm text-indigo-700 bg-indigo-50 px-4 py-2.5 rounded-xl border border-indigo-100 shadow-sm font-medium">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                <span>{{ now()->format('d M Y') }}</span>
            </div>
        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 relative z-10">

        {{-- Hero --}}
        <div class="bg-white rounded-2xl p-8 md:p-10 shadow-sm border border-slate-200 mb-8 flex flex-col lg:flex-row items-center justify-between gap-6">
            <div class="max-w-2xl">

                <h3 class="text-3xl md:text-4xl font-extrabold mb-3 tracking-tight text-slate-900">Selamat Datang, <span class="text-transparent bg-clip-text bg-gradient-to-r from-slate-900 to-blue-900">{{ Auth::user()->name }}</span></h3>
                <p class="text-slate-600 text-sm md:text-base leading-relaxed max-w-xl">
                    Pantau dan verifikasi pengajuan material yang masuk. Pastikan seluruh dokumen kelengkapan terpenuhi sebelum diteruskan ke departemen Supply Chain.
                </p>
            </div>

            <div class="relative z-10 shrink-0 mt-6 md:mt-0">
                <a href="{{ route('planner.material-requests.index') }}" class="inline-flex items-center gap-2 px-8 py-4 bg-gradient-to-r from-slate-900 to-blue-900 text-white rounded-xl font-bold shadow-md shadow-indigo-500/20 hover:from-slate-800 hover:to-blue-800 hover:-translate-y-1 transition-all duration-300">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                    Lihat Pengajuan Material
                </a>
            </div>
        </div>

        {{-- Quick Stats / Info --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            
            {{-- Stat 1 --}}
            <div class="bg-white rounded-2xl p-6 border border-slate-200 shadow-sm relative overflow-hidden group hover:border-blue-300 transition-colors">
                <div class="absolute top-0 right-0 w-24 h-24 bg-gradient-to-bl from-blue-50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity rounded-bl-full"></div>
                <div class="w-12 h-12 rounded-xl bg-blue-50 border border-blue-100 text-blue-600 flex items-center justify-center mb-5 group-hover:scale-110 transition-transform">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                </div>
                <h3 class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Pengajuan Masuk</h3>
                <p class="text-sm text-slate-600 leading-relaxed">Review pengajuan kebutuhan material yang baru dikirim oleh Engineer untuk proyek kapal.</p>
            </div>

            {{-- Stat 2 --}}
            <div class="bg-white rounded-2xl p-6 border border-slate-200 shadow-sm relative overflow-hidden group hover:border-amber-300 transition-colors">
                <div class="absolute top-0 right-0 w-24 h-24 bg-gradient-to-bl from-amber-50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity rounded-bl-full"></div>
                <div class="w-12 h-12 rounded-xl bg-amber-50 border border-amber-100 text-amber-600 flex items-center justify-center mb-5 group-hover:scale-110 transition-transform">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                </div>
                <h3 class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Kelengkapan Dokumen</h3>
                <p class="text-sm text-slate-600 leading-relaxed">Tambahkan lampiran seperti RAB, perizinan, dan catatan persetujuan sebelum diproses.</p>
            </div>

            {{-- Stat 3 --}}
            <div class="bg-white rounded-2xl p-6 border border-slate-200 shadow-sm relative overflow-hidden group hover:border-emerald-300 transition-colors">
                <div class="absolute top-0 right-0 w-24 h-24 bg-gradient-to-bl from-emerald-50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity rounded-bl-full"></div>
                <div class="w-12 h-12 rounded-xl bg-emerald-50 border border-emerald-100 text-emerald-600 flex items-center justify-center mb-5 group-hover:scale-110 transition-transform">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <h3 class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Approval & Verifikasi</h3>
                <p class="text-sm text-slate-600 leading-relaxed">Tentukan persetujuan pengajuan agar siap dilanjutkan ke tahap Tender oleh Supply Chain.</p>
            </div>

        </div>

    </div>
</x-app-layout>
