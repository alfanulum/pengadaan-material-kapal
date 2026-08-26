<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3">
            <div>
                <h2 class="font-bold text-2xl text-slate-900 leading-tight">
                    Tender Masuk
                </h2>
                <p class="text-sm text-slate-500 mt-1">
                    Daftar undangan tender yang dikirim oleh Supply Chain kepada vendor.
                </p>
            </div>

            <a href="{{ route('vendor.dashboard') }}" class="inline-flex items-center gap-2 px-5 py-2.5 bg-white text-slate-700 border border-slate-200 rounded-xl text-sm font-semibold hover:bg-slate-50 hover:text-blue-600 transition-all group shadow-sm">
                <svg class="w-4 h-4 text-slate-400 group-hover:text-blue-600 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Kembali ke Dashboard
            </a>
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
                        Vendor Tender Portal
                    </p>

                    <h3 class="text-3xl md:text-4xl font-bold leading-tight">
                        Daftar Tender yang Diterima
                    </h3>

                    <p class="mt-4 text-blue-100 max-w-3xl text-base leading-relaxed">
                        Vendor dapat melihat undangan tender, membuka detail kebutuhan material,
                        memeriksa deadline, mengirim penawaran, dan melihat status hasil pemilihan vendor.
                    </p>
                </div>

                <div class="bg-white/10 border border-white/10 rounded-2xl p-5 min-w-[190px]">
                    <p class="text-sm text-blue-100">Total Tender</p>
                    <p class="text-3xl font-bold mt-1">{{ $invitations->count() }}</p>
                </div>
            </div>
        </div>

        @if (session('success'))
            <div class="mb-6 bg-green-50 border border-green-200 text-green-700 p-4 rounded-2xl">
                {{ session('success') }}
            </div>
        @endif



        {{-- Table --}}
        <div class="bg-white rounded-3xl shadow-sm border border-slate-200 overflow-hidden">

            <div class="px-6 py-5 border-b border-slate-200">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                    <div>
                        <h3 class="text-lg font-bold text-slate-900">
                            Tender Masuk Vendor
                        </h3>
                        <p class="text-sm text-slate-500 mt-1">
                            Vendor: {{ $vendor->nama_vendor }}
                        </p>
                    </div>
                </div>
            </div>

            {{-- Search Section --}}
            <div class="px-6 py-4 bg-white border-b border-slate-200 bg-slate-50/50">
                <div class="flex flex-col sm:flex-row gap-4">
                    <div class="flex-1 relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </div>
                        <input type="text" id="vendorTenderSearch"
                            class="w-full pl-12 pr-4 py-3 rounded-xl border border-slate-200 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 placeholder-slate-400 text-sm text-slate-900 transition-colors"
                            placeholder="Cari kode tender, nama, project...">
                    </div>
                    <button type="button" id="vendorTenderSearchBtn" class="inline-flex items-center justify-center gap-2 px-6 py-3 bg-gradient-to-r from-slate-900 to-blue-900 hover:from-slate-800 hover:to-blue-800 text-white rounded-xl text-sm font-bold shadow-sm shadow-blue-900/20 transition hover:-translate-y-0.5">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                        <span>Cari Data</span>
                    </button>
                    <button type="button" id="vendorTenderResetBtn" class="hidden inline-flex items-center justify-center px-6 py-3 bg-slate-100 text-slate-600 rounded-xl text-sm font-bold hover:bg-slate-200 transition">Reset</button>
                </div>
                <p id="vendorTenderNoResult" class="hidden text-xs text-blue-700 mt-3 font-medium">Tidak ada tender yang cocok dengan pencarian.</p>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead class="bg-slate-50 border-b border-slate-200">
                        <tr>
                            <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Kode Tender</th>
                            <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Tender</th>
                            <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Project</th>
                            <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Deadline</th>
                            <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-4 text-center text-xs font-bold text-slate-500 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-slate-100" id="vendorTenderTbody">
                        @forelse ($invitations as $invitation)
                            <tr class="vendor-tender-row hover:bg-slate-50/80 transition-colors group">
                                <td class="px-6 py-4 text-xs font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-slate-900 to-blue-900 whitespace-nowrap">
                                    {{ $invitation->tender->kode_tender }}
                                </td>

                                <td class="px-6 py-4 text-xs text-slate-700">
                                    <div class="font-bold text-slate-800">
                                        {{ $invitation->tender->nama_tender }}
                                    </div>
                                    <div class="text-[10px] text-slate-500 mt-1">
                                        {{ $invitation->tender->materialRequest->kode_pengajuan ?? '-' }}
                                    </div>
                                </td>

                                <td class="px-6 py-4 text-xs font-medium text-slate-700 whitespace-nowrap">
                                    {{ $invitation->tender->materialRequest->project->nama_project ?? '-' }}
                                </td>

                                <td class="px-6 py-4 text-xs text-slate-500 whitespace-nowrap font-medium">
                                    {{ \Carbon\Carbon::parse($invitation->tender->deadline)->format('d-m-Y') }}
                                </td>

                                <td class="px-6 py-4 text-xs whitespace-nowrap">
                                    @if ($invitation->status == 'dikirim')
                                        <span class="inline-flex px-2.5 py-1 rounded-full bg-blue-100 text-blue-700 border border-blue-200 text-[10px] font-bold shadow-sm">Dikirim</span>
                                    @elseif ($invitation->status == 'dibaca')
                                        <span class="inline-flex px-2.5 py-1 rounded-full bg-indigo-100 text-indigo-700 border border-indigo-200 text-[10px] font-bold shadow-sm">Dibaca</span>
                                    @elseif ($invitation->status == 'ditawar')
                                        <span class="inline-flex px-2.5 py-1 rounded-full bg-amber-100 text-amber-700 border border-amber-200 text-[10px] font-bold shadow-sm">Ditawar</span>
                                    @elseif ($invitation->status == 'terpilih')
                                        <span class="inline-flex px-2.5 py-1 rounded-full bg-emerald-100 text-emerald-700 border border-emerald-200 text-[10px] font-bold shadow-sm">Terpilih</span>
                                    @elseif ($invitation->status == 'tidak_terpilih')
                                        <span class="inline-flex px-2.5 py-1 rounded-full bg-rose-100 text-rose-700 border border-rose-200 text-[10px] font-bold shadow-sm">Tidak Terpilih</span>
                                    @else
                                        <span class="inline-flex px-2.5 py-1 rounded-full bg-slate-100 text-slate-700 border border-slate-200 text-[10px] font-bold shadow-sm capitalize">{{ str_replace('_', ' ', $invitation->status) }}</span>
                                    @endif
                                </td>

                                <td class="px-6 py-4 text-xs whitespace-nowrap text-center">
                                    <a href="{{ route('vendor.tenders.show', $invitation->id) }}" title="Detail"
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
                                <td colspan="6" class="px-6 py-16 text-center">
                                    <div
                                        class="mx-auto w-16 h-16 rounded-2xl bg-slate-100 text-slate-400 flex items-center justify-center font-bold mb-4">
                                        TD
                                    </div>

                                    <h3 class="text-lg font-bold text-slate-900">
                                        Belum Ada Tender Masuk
                                    </h3>

                                    <p class="text-sm text-slate-500 mt-2">
                                        Undangan tender dari Supply Chain akan tampil di halaman ini.
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

<script>
(function() {
    const searchInput = document.getElementById('vendorTenderSearch');
    const searchBtn = document.getElementById('vendorTenderSearchBtn');
    const resetBtn = document.getElementById('vendorTenderResetBtn');
    const tbody = document.getElementById('vendorTenderTbody');
    const noResult = document.getElementById('vendorTenderNoResult');

    if (!searchInput || !tbody) return;

    function performSearch() {
        const keyword = searchInput.value.toLowerCase().trim();
        const rows = tbody.querySelectorAll('tr.vendor-tender-row');
        let visible = 0;
        
        rows.forEach(function(row) {
            const text = row.textContent.toLowerCase();
            if (!keyword || text.includes(keyword)) {
                row.style.display = '';
                visible++;
            } else {
                row.style.display = 'none';
            }
        });
        
        if (noResult) {
            noResult.classList.toggle('hidden', visible > 0 || rows.length === 0);
        }
        
        if (keyword.length > 0) {
            if(resetBtn) resetBtn.classList.remove('hidden');
        } else {
            if(resetBtn) resetBtn.classList.add('hidden');
        }
    }

    if (searchBtn) {
        searchBtn.addEventListener('click', performSearch);
    }
    
    searchInput.addEventListener('keyup', function(e) {
        if (e.key === 'Enter') {
            performSearch();
        }
    });

    if (resetBtn) {
        resetBtn.addEventListener('click', function() {
            searchInput.value = '';
            performSearch();
            searchInput.focus();
        });
    }
})();
</script>
