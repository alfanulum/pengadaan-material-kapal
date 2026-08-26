<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3">
            <div>
                <h2 class="font-bold text-2xl text-slate-900 leading-tight">
                    Data Tender
                </h2>
                <p class="text-sm text-slate-500 mt-1">
                    Kelola tender, undangan vendor, penawaran masuk, dan pemilihan vendor pemenang.
                </p>
            </div>

            <div class="flex flex-col sm:flex-row gap-3">
                <a href="{{ route('supply-chain.dashboard') }}"
                class="inline-flex items-center gap-2 px-5 py-2.5 bg-white border border-slate-200 hover:bg-slate-50 text-slate-700 rounded-xl text-sm font-semibold shadow-sm transition hover:-translate-y-0.5">
                <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                <span>Kembali ke Dashboard</span>
            </a>

                <a href="{{ route('supply-chain.material-requests.index') }}"
                    class="inline-flex items-center justify-center px-5 py-3 bg-gradient-to-r from-slate-900 to-blue-900 text-white rounded-xl font-semibold shadow-lg hover:from-slate-800 hover:to-blue-800 hover:shadow-lg transition">
                    + Buat dari Pengajuan
                </a>
            </div>
        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        {{-- Hero --}}
        <div
            class="bg-gradient-to-r from-slate-950 via-blue-950 to-blue-800 rounded-3xl p-8 md:p-10 shadow-xl text-white mb-8 overflow-hidden relative">
            <div class="absolute -top-24 -right-24 w-80 h-80 bg-cyan-400/20 rounded-full blur-3xl"></div>
            <div class="absolute -bottom-24 -left-24 w-80 h-80 bg-blue-400/20 rounded-full blur-3xl"></div>

            <div class="relative z-10 flex flex-col lg:flex-row lg:items-end lg:justify-between gap-6">
                <div>
                    <p
                        class="inline-flex px-4 py-2 rounded-full bg-white/10 border border-white/10 text-sm text-blue-100 mb-5">
                        Tender Management
                    </p>

                    <h3 class="text-3xl md:text-4xl font-bold leading-tight">
                        Monitoring Tender Vendor
                    </h3>


                </div>

                <div class="bg-white/10 border border-white/10 rounded-2xl p-5 min-w-[180px]">
                    <p class="text-sm text-blue-100">Total Tender</p>
                    <p class="text-3xl font-bold mt-1">{{ $tenders->total() }}</p>
                </div>
            </div>
        </div>

        @if (session('success'))
            <div class="mb-6 p-4 bg-green-50 border border-green-200 text-green-700 rounded-2xl">
                {{ session('success') }}
            </div>
        @endif

        {{-- Table Container --}}
        <div class="bg-white rounded-3xl shadow-sm border border-slate-200 overflow-hidden">
            <div class="px-6 py-5 border-b border-slate-200">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                    <div>
                        <h3 class="text-lg font-bold text-slate-900">
                            Daftar Tender
                        </h3>
                        <p class="text-sm text-slate-500 mt-1">
                            Data tender yang telah dibuat dan dikirim ke vendor.
                        </p>
                    </div>
                </div>
            </div>

            {{-- Search Section --}}
            <div class="px-6 py-4 bg-white border-b border-slate-200 bg-slate-50/50">
                <form action="{{ route('supply-chain.tenders.index') }}" method="GET" class="flex flex-col sm:flex-row gap-4">
                    <div class="flex-1 relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </div>
                        <input type="text" name="search" value="{{ request('search') }}"
                            class="w-full pl-12 pr-4 py-3 rounded-xl border border-slate-200 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 placeholder-slate-400 text-sm text-slate-900 transition-colors"
                            placeholder="Cari berdasarkan kode, nama tender, atau status...">
                    </div>
                    <button type="submit" class="inline-flex items-center justify-center gap-2 px-6 py-3 bg-gradient-to-r from-slate-900 to-blue-900 hover:from-slate-800 hover:to-blue-800 text-white rounded-xl text-sm font-bold shadow-sm shadow-blue-900/20 transition hover:-translate-y-0.5">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                        <span>Cari Data</span>
                    </button>
                    @if(request('search'))
                        <a href="{{ request()->url() }}" class="inline-flex items-center justify-center px-6 py-3 bg-slate-100 text-slate-600 rounded-xl text-sm font-bold hover:bg-slate-200 transition">Reset</a>
                    @endif
                </form>
                @if(request('search'))
                    <p class="text-xs text-blue-700 mt-3">Hasil pencarian: <strong>"{{ request('search') }}"</strong></p>
                @endif
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead class="bg-slate-50 border-b border-slate-200">
                        <tr>
                            <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Kode Tender</th>
                            <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Tender</th>
                            <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Pengajuan</th>
                            <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Deadline</th>
                            <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Dibuat Oleh</th>
                            <th class="px-6 py-4 text-center text-xs font-bold text-slate-500 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-slate-100">
                        @forelse ($tenders as $tender)
                            <tr class="hover:bg-slate-50/80 transition-colors group">
                                <td class="px-6 py-4 text-xs font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-slate-900 to-blue-900 whitespace-nowrap">
                                    {{ $tender->kode_tender }}
                                </td>

                                <td class="px-6 py-4 text-xs font-bold text-slate-800 whitespace-nowrap">
                                    {{ $tender->nama_tender }}
                                </td>

                                <td class="px-6 py-4 text-xs font-medium text-slate-700 whitespace-nowrap">
                                    {{ $tender->materialRequest->kode_pengajuan ?? 'REQ-' . str_pad($tender->material_request_id, 4, '0', STR_PAD_LEFT) }}
                                </td>

                                <td class="px-6 py-4 text-xs text-slate-500 whitespace-nowrap font-medium">
                                    {{ \Carbon\Carbon::parse($tender->deadline)->format('d-m-Y') }}
                                </td>

                                <td class="px-6 py-4 text-xs whitespace-nowrap">
                                    @if ($tender->status == 'dikirim')
                                        <span class="inline-flex px-2.5 py-1 rounded-full bg-blue-100 text-blue-700 border border-blue-200 text-[10px] font-bold shadow-sm">Dikirim</span>
                                    @elseif ($tender->status == 'penawaran_masuk')
                                        <span class="inline-flex px-2.5 py-1 rounded-full bg-amber-100 text-amber-700 border border-amber-200 text-[10px] font-bold shadow-sm">Penawaran Masuk</span>
                                    @elseif ($tender->status == 'negosiasi')
                                        <span class="inline-flex px-2.5 py-1 rounded-full bg-purple-100 text-purple-700 border border-purple-200 text-[10px] font-bold shadow-sm">Negosiasi</span>
                                    @elseif ($tender->status == 'vendor_terpilih')
                                        <span class="inline-flex px-2.5 py-1 rounded-full bg-emerald-100 text-emerald-700 border border-emerald-200 text-[10px] font-bold shadow-sm">Vendor Terpilih</span>
                                    @elseif ($tender->status == 'selesai')
                                        <span class="inline-flex px-2.5 py-1 rounded-full bg-teal-100 text-teal-700 border border-teal-200 text-[10px] font-bold shadow-sm">Selesai</span>
                                    @elseif ($tender->status == 'dibatalkan')
                                        <span class="inline-flex px-2.5 py-1 rounded-full bg-rose-100 text-rose-700 border border-rose-200 text-[10px] font-bold shadow-sm">Dibatalkan</span>
                                    @else
                                        <span class="inline-flex px-2.5 py-1 rounded-full bg-slate-100 text-slate-700 border border-slate-200 text-[10px] font-bold shadow-sm capitalize">{{ str_replace('_', ' ', ucfirst($tender->status)) }}</span>
                                    @endif
                                </td>

                                <td class="px-6 py-4 text-xs text-slate-800 font-medium whitespace-nowrap flex items-center gap-2">
                                    <div class="w-6 h-6 rounded-full bg-indigo-50 text-indigo-600 border border-indigo-100 flex items-center justify-center font-bold text-[10px] uppercase shadow-sm">
                                        {{ substr($tender->pembuatTender->name ?? '-', 0, 2) }}
                                    </div>
                                    {{ $tender->pembuatTender->name ?? '-' }}
                                </td>

                                <td class="px-6 py-4 text-xs whitespace-nowrap text-center">
                                    <a href="{{ route('supply-chain.tenders.show', $tender) }}" title="Detail"
                                        class="inline-flex items-center justify-center w-7 h-7 bg-white text-indigo-600 hover:bg-indigo-50 border border-slate-200 hover:border-indigo-200 rounded-md transition shadow-sm">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                        </svg>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-6 py-16 text-center">
                                    <div class="mx-auto w-16 h-16 rounded-2xl bg-slate-50 border border-slate-200 flex items-center justify-center mb-4">
                                        <svg class="w-8 h-8 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                        </svg>
                                    </div>
                                    <h3 class="text-base font-bold text-slate-800 mb-1">Belum Ada Data</h3>
                                    <p class="text-xs text-slate-500 max-w-sm mx-auto mb-6">
                                        Saat ini tidak ada tender yang tersedia.
                                    </p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="mt-6">
            {{ $tenders->links() }}
        </div>

    </div>
</x-app-layout>
