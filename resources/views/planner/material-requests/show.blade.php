<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3">
            <div>
                <h2 class="font-bold text-2xl text-slate-900 leading-tight">
                    Detail Pengajuan: {{ $requestMaterial->kode_pengajuan }}
                </h2>
                <p class="text-sm text-slate-500 mt-1">
                    Informasi lengkap pengajuan material untuk diverifikasi.
                </p>
            </div>

            <div class="flex flex-wrap items-center gap-3">
                <a href="{{ route('planner.material-requests.index') }}"
                    class="inline-flex items-center gap-2 px-5 py-2.5 bg-white border border-slate-200 hover:bg-slate-50 text-slate-700 rounded-xl text-sm font-semibold shadow-sm transition">
                    <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    <span>Kembali</span>
                </a>

                @if ($requestMaterial->status == 'diajukan')
                    <span class="inline-flex px-3 py-1.5 rounded-lg bg-amber-50 text-amber-700 border border-amber-200 text-sm font-bold shadow-sm">
                        Menunggu Verifikasi
                    </span>
                @elseif ($requestMaterial->status == 'disetujui')
                    <span class="inline-flex px-3 py-1.5 rounded-lg bg-emerald-50 text-emerald-700 border border-emerald-200 text-sm font-bold shadow-sm">
                        Disetujui
                    </span>
                @elseif ($requestMaterial->status == 'ditolak')
                    <span class="inline-flex px-3 py-1.5 rounded-lg bg-rose-50 text-rose-700 border border-rose-200 text-sm font-bold shadow-sm">
                        Ditolak
                    </span>
                @else
                    <span class="inline-flex px-3 py-1.5 rounded-lg bg-slate-100 text-slate-700 border border-slate-200 text-sm font-bold shadow-sm capitalize">
                        {{ $requestMaterial->status }}
                    </span>
                @endif
            </div>
        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

        @if (session('success'))
            <div class="mb-6 bg-emerald-50 border border-emerald-200 text-emerald-800 p-4 rounded-xl text-sm flex items-center gap-2 shadow-sm">
                <svg class="w-5 h-5 text-emerald-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        @if ($errors->any())
            <div class="mb-6 bg-rose-50 border border-rose-200 text-rose-800 p-4 rounded-xl text-sm flex items-start gap-2 shadow-sm">
                <svg class="w-5 h-5 text-rose-600 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <div>
                    <strong class="block font-bold mb-1">Terjadi kesalahan:</strong>
                    <ul class="list-disc ml-5 space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            {{-- Main Content --}}
            <div class="lg:col-span-2 space-y-6">

                {{-- Informasi Utama --}}
                <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
                    <div class="px-6 py-5 border-b border-slate-200 bg-slate-50/50">
                        <h3 class="text-base font-bold text-slate-900">Informasi Pengajuan</h3>
                    </div>
                    <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1">Engineer</p>
                            <p class="text-sm font-bold text-slate-900">{{ $requestMaterial->user->name }}</p>
                        </div>
                        <div>
                            <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1">Proyek</p>
                            <p class="text-sm font-bold text-slate-900">{{ $requestMaterial->project->nama_project }}</p>
                        </div>
                        <div>
                            <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1">Tgl Kebutuhan</p>
                            <p class="text-sm font-bold text-slate-900">{{ \Carbon\Carbon::parse($requestMaterial->tanggal_dibutuhkan)->format('d F Y') }}</p>
                        </div>
                        <div>
                            <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1">Total RAB</p>
                            <p class="text-sm font-bold text-slate-900">
                                @if ($requestMaterial->total_rab)
                                    Rp {{ number_format($requestMaterial->total_rab, 0, ',', '.') }}
                                @else
                                    <span class="text-slate-400 font-medium">Belum diinput</span>
                                @endif
                            </p>
                        </div>
                        <div class="md:col-span-2 bg-slate-50 rounded-xl p-4 border border-slate-100">
                            <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1">Catatan Engineer</p>
                            <p class="text-sm text-slate-700">{{ $requestMaterial->catatan ?: '-' }}</p>
                        </div>
                        @if($requestMaterial->catatan_planner)
                        <div class="md:col-span-2 bg-blue-50 rounded-xl p-4 border border-blue-100">
                            <p class="text-xs font-semibold text-blue-800 uppercase tracking-wider mb-1">Catatan Planner</p>
                            <p class="text-sm text-blue-900">{{ $requestMaterial->catatan_planner }}</p>
                        </div>
                        @endif
                    </div>
                </div>

                {{-- Daftar Material --}}
                <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
                    <div class="px-6 py-5 border-b border-slate-200 bg-slate-50/50">
                        <h3 class="text-base font-bold text-slate-900">Daftar Material</h3>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead class="bg-slate-50 border-b border-slate-200">
                                <tr>
                                    <th class="px-6 py-4 text-left text-xs font-bold text-slate-600 uppercase tracking-wider">Nama Barang</th>
                                    <th class="px-6 py-4 text-left text-xs font-bold text-slate-600 uppercase tracking-wider">Spesifikasi</th>
                                    <th class="px-6 py-4 text-left text-xs font-bold text-slate-600 uppercase tracking-wider">Jumlah</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100">
                                @foreach ($requestMaterial->items as $item)
                                    <tr class="hover:bg-slate-50/80 transition">
                                        <td class="px-6 py-4 text-sm font-semibold text-slate-900">{{ $item->nama_barang }}</td>
                                        <td class="px-6 py-4 text-sm text-slate-600">{{ $item->spesifikasi ?: '-' }}</td>
                                        <td class="px-6 py-4 text-sm font-medium text-slate-900">
                                            {{ $item->qty }} <span class="text-slate-500 font-normal">{{ $item->satuan }}</span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                {{-- Upload Dokumen --}}
                @if ($requestMaterial->status == 'disetujui')
                <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
                    <div class="px-6 py-5 border-b border-slate-200 bg-slate-50/50">
                        <h3 class="text-base font-bold text-slate-900">Kelengkapan Dokumen Planner</h3>
                    </div>
                    <div class="p-6">
                        <form action="{{ route('planner.material-requests.documents', $requestMaterial->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                            @csrf
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-sm font-semibold text-slate-700 mb-2">Total RAB (Rp)</label>
                                    <input type="number" name="total_rab" class="w-full rounded-xl border-slate-300 focus:border-blue-900 focus:ring-blue-900 shadow-sm text-sm" placeholder="Contoh: 25000000" value="{{ old('total_rab', $requestMaterial->total_rab) }}">
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold text-slate-700 mb-2">Dokumen RAB</label>
                                    <input type="file" name="file_rab" class="block w-full text-sm text-slate-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-900 hover:file:bg-blue-100 transition border border-slate-300 rounded-xl">
                                    @if ($requestMaterial->file_rab)
                                        <div class="mt-2 text-xs">
                                            <a href="{{ asset('storage/' . $requestMaterial->file_rab) }}" target="_blank" class="text-blue-600 hover:text-blue-800 font-medium flex items-center gap-1">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                                Lihat Dokumen Saat Ini
                                            </a>
                                        </div>
                                    @endif
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold text-slate-700 mb-2">Dokumen Perizinan</label>
                                    <input type="file" name="file_perizinan" class="block w-full text-sm text-slate-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-900 hover:file:bg-blue-100 transition border border-slate-300 rounded-xl">
                                    @if ($requestMaterial->file_perizinan)
                                        <div class="mt-2 text-xs">
                                            <a href="{{ asset('storage/' . $requestMaterial->file_perizinan) }}" target="_blank" class="text-blue-600 hover:text-blue-800 font-medium flex items-center gap-1">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                                Lihat Dokumen Saat Ini
                                            </a>
                                        </div>
                                    @endif
                                </div>
                                <div class="md:col-span-2">
                                    <label class="block text-sm font-semibold text-slate-700 mb-2">Catatan Planner</label>
                                    <textarea name="catatan_planner" rows="3" class="w-full rounded-xl border-slate-300 focus:border-blue-900 focus:ring-blue-900 shadow-sm text-sm" placeholder="Tuliskan catatan khusus terkait perencanaan">{{ old('catatan_planner', $requestMaterial->catatan_planner) }}</textarea>
                                </div>
                            </div>
                            
                            <div class="pt-2 flex justify-end">
                                <button type="submit" class="inline-flex items-center gap-2 px-6 py-2.5 bg-blue-900 hover:bg-blue-950 text-white rounded-xl text-sm font-bold shadow-sm transition hover:shadow">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"></path></svg>
                                    Simpan Dokumen
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
                @endif
            </div>

            {{-- Sidebar (Aksi) --}}
            <div class="lg:col-span-1 space-y-6">
                @if ($requestMaterial->status == 'diajukan')
                <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
                    <div class="px-6 py-5 border-b border-slate-200 bg-slate-50/50">
                        <h3 class="text-base font-bold text-slate-900">Verifikasi</h3>
                    </div>
                    <div class="p-6 space-y-6">
                        <form action="{{ route('planner.material-requests.approve', $requestMaterial->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="w-full inline-flex items-center justify-center gap-2 px-5 py-3 bg-emerald-600 text-white rounded-xl font-bold hover:bg-emerald-700 transition shadow-sm">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                Setujui Pengajuan
                            </button>
                        </form>

                        <div class="relative flex items-center py-2">
                            <div class="flex-grow border-t border-slate-200"></div>
                            <span class="flex-shrink-0 mx-4 text-slate-400 text-xs font-semibold">ATAU</span>
                            <div class="flex-grow border-t border-slate-200"></div>
                        </div>

                        <form action="{{ route('planner.material-requests.reject', $requestMaterial->id) }}" method="POST" class="space-y-4">
                            @csrf
                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-2">Alasan Penolakan</label>
                                <textarea name="catatan" rows="3" required class="w-full rounded-xl border-slate-300 focus:border-rose-600 focus:ring-rose-600 shadow-sm text-sm" placeholder="Tuliskan alasan spesifik menolak pengajuan..."></textarea>
                            </div>
                            <button type="submit" class="w-full inline-flex items-center justify-center gap-2 px-5 py-3 bg-rose-600 text-white rounded-xl font-bold hover:bg-rose-700 transition shadow-sm">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                Tolak Pengajuan
                            </button>
                        </form>
                    </div>
                </div>
                @else
                <div class="bg-slate-50 border border-slate-200 rounded-2xl p-6 text-center">
                    <div class="w-12 h-12 bg-white rounded-full flex items-center justify-center mx-auto mb-3 shadow-sm border border-slate-100">
                        @if($requestMaterial->status == 'disetujui')
                            <svg class="w-6 h-6 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        @elseif($requestMaterial->status == 'ditolak')
                            <svg class="w-6 h-6 text-rose-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                        @else
                            <svg class="w-6 h-6 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        @endif
                    </div>
                    <h4 class="font-bold text-slate-900 mb-1">Status: <span class="capitalize">{{ $requestMaterial->status }}</span></h4>
                    <p class="text-xs text-slate-500">Pengajuan ini tidak dapat diverifikasi ulang.</p>
                </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
