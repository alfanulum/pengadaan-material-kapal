<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3">
            <div>
                <h2 class="font-bold text-2xl text-slate-900 leading-tight">
                    Pengajuan Material Masuk
                </h2>
                <p class="text-sm text-slate-500 mt-1">
                    Daftar pengajuan material dari Engineer yang perlu diverifikasi.
                </p>
            </div>

            <a href="{{ route('planner.dashboard') }}"
                class="inline-flex items-center gap-2 px-5 py-2.5 bg-white border border-slate-200 hover:bg-slate-50 text-slate-700 rounded-xl text-sm font-semibold shadow-sm transition hover:-translate-y-0.5">
                <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                <span>Dashboard</span>
            </a>
        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 relative z-10">

        {{-- Search Section --}}
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6 mb-8 mt-4 relative z-10">
            <form action="{{ route('planner.material-requests.index') }}" method="GET" class="flex flex-col sm:flex-row gap-4">
                <div class="flex-1 relative">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>
                    <input type="text" name="search" value="{{ request('search') }}"
                        class="w-full pl-12 pr-4 py-3 rounded-xl border border-slate-200 focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 placeholder-slate-400 text-sm text-slate-900 transition-colors"
                        placeholder="Cari berdasarkan kode, proyek, barang, atau nama engineer...">
                </div>
                <button type="submit" class="inline-flex items-center justify-center gap-2 px-6 py-3 bg-gradient-to-r from-slate-900 to-blue-900 hover:from-slate-800 hover:to-blue-800 text-white rounded-xl text-sm font-bold shadow-sm shadow-blue-900/20 transition hover:-translate-y-0.5">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                    <span>Cari Data</span>
                </button>
            </form>
        </div>

        @if (session('success'))
            <div class="mb-6 bg-emerald-50 border border-emerald-200 text-emerald-700 p-4 rounded-xl text-sm flex items-center gap-3 shadow-sm relative z-10">
                <svg class="w-5 h-5 text-emerald-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                <span class="font-medium">{{ session('success') }}</span>
            </div>
        @endif

        {{-- Table Card --}}
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden mb-12 relative z-10">

            <div class="px-6 py-5 border-b border-slate-200 flex flex-col md:flex-row md:items-center md:justify-between gap-3 bg-slate-50/50">
                <div>
                    <h3 class="text-base font-bold text-slate-800 flex items-center gap-2">
                        <span class="w-2 h-5 bg-indigo-500 rounded-full inline-block"></span>
                        Data Pengajuan Material
                    </h3>
                    <p class="text-xs text-slate-500 mt-1 pl-4">
                        Daftar permintaan kebutuhan material yang masuk dari Engineer.
                    </p>
                </div>

                <div class="text-xs text-slate-600 bg-white px-3 py-1.5 rounded-lg border border-slate-200 shadow-sm font-medium">
                    Total Pengajuan: <span class="font-bold text-indigo-600">{{ $requests->count() }}</span>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead class="bg-slate-50 border-b border-slate-200">
                        <tr>
                            <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Kode</th>
                            <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Engineer</th>
                            <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Proyek</th>
                            <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Barang</th>
                            <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Jumlah</th>
                            <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Tanggal Kebutuhan</th>
                            <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-4 text-center text-xs font-bold text-slate-500 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-slate-100">
                        @forelse ($requests as $request)
                            <tr class="hover:bg-slate-50/80 transition-colors group">
                                <td class="px-6 py-4 text-xs font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-slate-900 to-blue-900 whitespace-nowrap">
                                    {{ $request->kode_pengajuan }}
                                </td>

                                <td class="px-6 py-4 text-xs text-slate-800 font-medium whitespace-nowrap flex items-center gap-2">
                                    <div class="w-6 h-6 rounded-full bg-indigo-50 text-indigo-600 border border-indigo-100 flex items-center justify-center font-bold text-[10px] uppercase">
                                        {{ substr($request->user->name, 0, 2) }}
                                    </div>
                                    {{ $request->user->name }}
                                </td>

                                <td class="px-6 py-4 text-xs text-slate-800 font-semibold whitespace-nowrap">
                                    {{ $request->project->nama_project }}
                                </td>

                                <td class="px-6 py-4 text-xs text-slate-700">
                                    @foreach ($request->items as $item)
                                        <div class="font-medium mb-1 last:mb-0">{{ $item->nama_barang }}</div>
                                    @endforeach
                                </td>

                                <td class="px-6 py-4 text-xs text-slate-700 whitespace-nowrap">
                                    @foreach ($request->items as $item)
                                        <div class="font-semibold mb-1 last:mb-0">{{ $item->qty }} <span class="text-slate-500 font-normal">{{ $item->satuan }}</span></div>
                                    @endforeach
                                </td>

                                <td class="px-6 py-4 text-xs text-slate-500 whitespace-nowrap">
                                    {{ \Carbon\Carbon::parse($request->tanggal_dibutuhkan)->format('d-m-Y') }}
                                </td>

                                <td class="px-6 py-4 text-xs whitespace-nowrap">
                                    @if ($request->status == 'diajukan')
                                        <span class="inline-flex px-2.5 py-1 rounded-full bg-amber-100 text-amber-700 border border-amber-200 text-[11px] font-bold shadow-sm">
                                            Menunggu Verifikasi
                                        </span>
                                    @elseif ($request->status == 'disetujui')
                                        <span class="inline-flex px-2.5 py-1 rounded-full bg-emerald-100 text-emerald-700 border border-emerald-200 text-[11px] font-bold shadow-sm">
                                            Disetujui
                                        </span>
                                    @elseif ($request->status == 'ditolak')
                                        <span class="inline-flex px-2.5 py-1 rounded-full bg-rose-100 text-rose-700 border border-rose-200 text-[11px] font-bold shadow-sm">
                                            Ditolak
                                        </span>
                                    @else
                                        <span class="inline-flex px-2.5 py-1 rounded-full bg-slate-100 text-slate-700 border border-slate-200 text-[11px] font-bold capitalize shadow-sm">
                                            {{ $request->status }}
                                        </span>
                                    @endif
                                </td>

                                <td class="px-6 py-4 text-xs whitespace-nowrap text-center">
                                    <a href="{{ route('planner.material-requests.show', $request->id) }}"
                                        class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-white text-indigo-600 hover:bg-indigo-50 border border-slate-200 hover:border-indigo-200 rounded-lg text-xs font-bold transition shadow-sm">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                        </svg>
                                        <span>Detail & Verifikasi</span>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="px-6 py-16 text-center">
                                    <div class="mx-auto w-16 h-16 rounded-2xl bg-slate-50 border border-slate-200 flex items-center justify-center mb-4">
                                        <svg class="w-8 h-8 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                        </svg>
                                    </div>
                                    <h3 class="text-base font-bold text-slate-800 mb-1">Belum Ada Data Pengajuan</h3>
                                    <p class="text-xs text-slate-500 max-w-sm mx-auto mb-6">
                                        Saat ini tidak ada pengajuan material yang perlu direview.
                                    </p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</x-app-layout>
