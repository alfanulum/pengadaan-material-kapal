<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3">
            <div>
                <h2 class="font-bold text-2xl text-slate-900 leading-tight">
                    Data Vendor
                </h2>
                <p class="text-sm text-slate-500 mt-1">
                    Kelola data vendor dan verifikasi registrasi vendor baru.
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

                <a href="{{ route('supply-chain.vendors.create') }}"
                    class="inline-flex items-center justify-center px-5 py-3 bg-gradient-to-r from-slate-900 to-blue-900 text-white rounded-xl font-semibold shadow-lg hover:from-slate-800 hover:to-blue-800 hover:shadow-lg transition">
                    + Tambah Vendor
                </a>
            </div>
        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        
        </div>

        @if (session('success'))
            <div class="mb-6 p-4 bg-green-50 border border-green-200 text-green-700 rounded-2xl">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="mb-6 p-4 bg-red-50 border border-red-200 text-red-700 rounded-2xl">
                {{ session('error') }}
            </div>
        @endif

        
        {{-- Search Section --}}
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6 mb-8 mt-4 relative z-10">
            <form action="{{ route('supply-chain.vendors.index') }}" method="GET" class="flex flex-col sm:flex-row gap-4">
                <input type="hidden" name="filter" value="{{ $filterStatus }}">
                <div class="flex-1 relative">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>
                    <input type="text" name="search" value="{{ request('search') }}"
                        class="w-full pl-12 pr-4 py-3 rounded-xl border border-slate-200 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 placeholder-slate-400 text-sm text-slate-900 transition-colors"
                        placeholder="Cari berdasarkan kode, nama, PIC, atau kategori...">
                </div>
                <button type="submit" class="inline-flex items-center justify-center gap-2 px-6 py-3 bg-gradient-to-r from-slate-900 to-blue-900 hover:from-slate-800 hover:to-blue-800 text-white rounded-xl text-sm font-bold shadow-sm shadow-blue-900/20 transition hover:-translate-y-0.5">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                    <span>Cari Data</span>
                </button>
                @if(request('search'))
                    <a href="{{ request()->fullUrlWithQuery(['search' => null]) }}" class="inline-flex items-center justify-center px-6 py-3 bg-slate-100 text-slate-600 rounded-xl text-sm font-bold hover:bg-slate-200 transition">Reset</a>
                @endif
            </form>
            @if(request('search'))
                <p class="text-xs text-blue-700 mt-3">Hasil pencarian: <strong>"{{ request('search') }}"</strong></p>
            @endif
        </div>

        {{-- Tab Filter Status Registrasi --}}
        <div class="bg-white rounded-3xl shadow-sm border border-slate-200 overflow-hidden">
            <div class="px-6 pt-5 border-b border-slate-200">
                <div class="flex flex-wrap gap-1">
                    @foreach ([
                        'semua'     => ['label' => 'Semua Vendor',          'count' => $counts['semua'],    'color' => 'blue'],
                        'menunggu'  => ['label' => 'Menunggu Verifikasi',   'count' => $counts['menunggu'], 'color' => 'amber'],
                        'disetujui' => ['label' => 'Disetujui',             'count' => $counts['disetujui'],'color' => 'green'],
                        'ditolak'   => ['label' => 'Ditolak',               'count' => $counts['ditolak'],  'color' => 'red'],
                    ] as $key => $tab)
                        @php
                            $isActive = $filterStatus === $key;
                            $colorClasses = match($tab['color']) {
                                'amber' => $isActive ? 'border-amber-500 text-amber-700 bg-amber-50' : 'border-transparent text-slate-500 hover:text-amber-600',
                                'green' => $isActive ? 'border-green-600 text-green-700 bg-green-50' : 'border-transparent text-slate-500 hover:text-green-600',
                                'red'   => $isActive ? 'border-red-600 text-red-700 bg-red-50' : 'border-transparent text-slate-500 hover:text-red-600',
                                default => $isActive ? 'border-blue-700 text-blue-900 bg-blue-50' : 'border-transparent text-slate-500 hover:text-blue-700',
                            };
                        @endphp
                        <a href="{{ request()->fullUrlWithQuery(['filter' => $key, 'search' => $search ?? '']) }}"
                            class="inline-flex items-center gap-2 px-4 py-2.5 border-b-2 text-sm font-semibold transition {{ $colorClasses }}">
                            {{ $tab['label'] }}
                            <span class="px-2 py-0.5 rounded-full bg-slate-100 text-slate-600 text-xs font-bold">{{ $tab['count'] }}</span>
                        </a>
                    @endforeach
                </div>
                </div>

            
            {{-- Tabel --}}
            <div class="px-6 py-5 border-b border-slate-200 flex flex-col md:flex-row md:items-center md:justify-between gap-3 bg-slate-50/50">
                <div>
                    <h3 class="text-base font-bold text-slate-800 flex items-center gap-2">
                        <span class="w-2 h-5 bg-blue-500 rounded-full inline-block"></span>
                        Data Vendor
                    </h3>
                    <p class="text-xs text-slate-500 mt-1 pl-4">
                        Daftar vendor yang terdaftar di sistem.
                    </p>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead class="bg-slate-50 border-b border-slate-200">
                        <tr>
                            <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Kode</th>
                            <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Vendor / Perusahaan</th>
                            <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">PIC</th>
                            <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Kontak</th>
                            <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Tanggal Daftar</th>
                            <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-4 text-center text-xs font-bold text-slate-500 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-slate-100">
                        @forelse ($vendors as $vendor)
                            <tr class="hover:bg-slate-50/80 transition-colors group">
                                <td class="px-6 py-4 text-xs font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-slate-900 to-blue-900 whitespace-nowrap">
                                    {{ $vendor->kode_vendor }}
                                </td>

                                <td class="px-6 py-4 text-xs text-slate-800 font-medium whitespace-nowrap flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-full bg-blue-50 text-blue-600 border border-blue-100 flex items-center justify-center font-bold text-xs uppercase shadow-sm">
                                        {{ substr($vendor->nama_vendor, 0, 2) }}
                                    </div>
                                    <div>
                                        <div class="font-bold text-slate-900">{{ $vendor->nama_vendor }}</div>
                                        <div class="text-[10px] text-slate-500 mt-0.5">{{ $vendor->kategori ?? 'Kategori belum diisi' }}</div>
                                    </div>
                                </td>

                                <td class="px-6 py-4 text-xs text-slate-700 whitespace-nowrap font-medium">
                                    {{ $vendor->pic ?? '-' }}
                                </td>

                                <td class="px-6 py-4 text-xs text-slate-700">
                                    <div class="font-medium mb-0.5">{{ $vendor->email ?? '-' }}</div>
                                    <div class="text-[10px] text-slate-500">{{ $vendor->telepon ?? '-' }}</div>
                                </td>

                                <td class="px-6 py-4 text-xs text-slate-500 whitespace-nowrap font-medium">
                                    @if ($vendor->tanggal_daftar)
                                        {{ $vendor->tanggal_daftar->format('d M Y') }}
                                    @elseif ($vendor->created_at)
                                        {{ $vendor->created_at->format('d M Y') }}
                                    @else
                                        -
                                    @endif
                                </td>

                                <td class="px-6 py-4 text-xs whitespace-nowrap">
                                    @php
                                        $regStatus = $vendor->status_registrasi ?? 'disetujui';
                                    @endphp
                                    @if ($regStatus === 'menunggu')
                                        <span class="inline-flex px-2.5 py-1 rounded-full bg-amber-100 text-amber-700 border border-amber-200 text-[10px] font-bold shadow-sm">
                                            Menunggu Verifikasi
                                        </span>
                                    @elseif ($regStatus === 'disetujui')
                                        <span class="inline-flex px-2.5 py-1 rounded-full bg-emerald-100 text-emerald-700 border border-emerald-200 text-[10px] font-bold shadow-sm">
                                            Disetujui
                                        </span>
                                    @elseif ($regStatus === 'ditolak')
                                        <span class="inline-flex px-2.5 py-1 rounded-full bg-rose-100 text-rose-700 border border-rose-200 text-[10px] font-bold shadow-sm">
                                            Ditolak
                                        </span>
                                    @else
                                        <span class="inline-flex px-2.5 py-1 rounded-full bg-slate-100 text-slate-700 border border-slate-200 text-[10px] font-bold shadow-sm capitalize">
                                            {{ $regStatus }}
                                        </span>
                                    @endif
                                </td>

                                <td class="px-6 py-4 text-xs whitespace-nowrap text-center">
                                    <div class="flex items-center justify-center gap-1.5">
                                        <a href="{{ route('supply-chain.vendors.show', $vendor) }}" title="Detail"
                                            class="inline-flex items-center justify-center w-7 h-7 bg-white text-indigo-600 hover:bg-indigo-50 border border-slate-200 hover:border-indigo-200 rounded-md transition shadow-sm">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                            </svg>
                                        </a>

                                        <a href="{{ route('supply-chain.vendors.edit', $vendor) }}" title="Edit"
                                            class="inline-flex items-center justify-center w-7 h-7 bg-white text-amber-600 hover:bg-amber-50 border border-slate-200 hover:border-amber-200 rounded-md transition shadow-sm">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path>
                                            </svg>
                                        </a>

                                        <form action="{{ route('supply-chain.vendors.destroy', $vendor) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus vendor ini?')" class="inline-block">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" title="Hapus"
                                                class="inline-flex items-center justify-center w-7 h-7 bg-white text-rose-600 hover:bg-rose-50 border border-slate-200 hover:border-rose-200 rounded-md transition shadow-sm">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
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
                                    <h3 class="text-base font-bold text-slate-800 mb-1">Belum Ada Data Vendor</h3>
                                    <p class="text-xs text-slate-500 max-w-sm mx-auto mb-6">
                                        Saat ini tidak ada vendor yang terdaftar sesuai pencarian Anda.
                                    </p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="mt-6">
            {{ $vendors->links() }}
        </div>

    </div>
</x-app-layout>
