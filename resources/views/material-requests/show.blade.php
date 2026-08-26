<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3">
            <div>
                <h2 class="font-bold text-2xl text-slate-900 leading-tight">
                    Detail Pengajuan Material
                </h2>
                <p class="text-sm text-slate-500 mt-1">
                    Informasi lengkap mengenai kebutuhan material pengadaan kapal.
                </p>
            </div>

            <div class="flex items-center gap-3">
                <a href="{{ route('material-requests.index') }}"
                    class="inline-flex items-center gap-2 px-5 py-2.5 bg-white border border-slate-300 hover:bg-slate-50 text-slate-700 rounded-xl text-sm font-semibold shadow-sm transition">
                    <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    <span>Daftar Pengajuan</span>
                </a>

                @if ($requestMaterial->status == 'diajukan')
                    <a href="{{ route('material-requests.edit', $requestMaterial->id) }}"
                        class="inline-flex items-center gap-2 px-5 py-2.5 bg-amber-500 hover:bg-amber-600 text-white rounded-xl text-sm font-bold shadow-sm transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                        <span>Edit Pengajuan</span>
                    </a>
                @endif
            </div>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

            {{-- Informasi Pengajuan Card --}}
            <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6 md:p-8">
                <h3 class="text-base font-bold text-slate-900 mb-6 flex items-center gap-2 border-b border-slate-100 pb-3">
                    <span class="w-2 h-4 bg-blue-900 rounded-full inline-block"></span>
                    Informasi Pengajuan
                </h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 text-sm">
                    <div class="space-y-4">
                        <div>
                            <span class="text-xs font-bold uppercase tracking-wider text-slate-400 block mb-1">Kode Pengajuan</span>
                            <span class="font-bold text-blue-900 text-base">{{ $requestMaterial->kode_pengajuan }}</span>
                        </div>

                        <div>
                            <span class="text-xs font-bold uppercase tracking-wider text-slate-400 block mb-1">Proyek Kapal</span>
                            <span class="font-semibold text-slate-800">{{ $requestMaterial->project->nama_project }}</span>
                        </div>

                        <div>
                            <span class="text-xs font-bold uppercase tracking-wider text-slate-400 block mb-1">Status Verifikasi</span>
                            @if ($requestMaterial->status == 'diajukan')
                                <span class="inline-flex px-3 py-1 rounded-full bg-amber-50 text-amber-700 border border-amber-200 text-xs font-bold">
                                    Diajukan (Menunggu Verifikasi)
                                </span>
                            @elseif ($requestMaterial->status == 'disetujui')
                                <span class="inline-flex px-3 py-1 rounded-full bg-emerald-50 text-emerald-700 border border-emerald-200 text-xs font-bold">
                                    Disetujui
                                </span>
                            @elseif ($requestMaterial->status == 'ditolak')
                                <span class="inline-flex px-3 py-1 rounded-full bg-rose-50 text-rose-700 border border-rose-200 text-xs font-bold">
                                    Ditolak
                                </span>
                            @else
                                <span class="inline-flex px-3 py-1 rounded-full bg-slate-100 text-slate-700 border border-slate-200 text-xs font-bold capitalize">
                                    {{ $requestMaterial->status }}
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="space-y-4">
                        <div>
                            <span class="text-xs font-bold uppercase tracking-wider text-slate-400 block mb-1">Tanggal Dibutuhkan</span>
                            <span class="font-semibold text-slate-800">{{ \Carbon\Carbon::parse($requestMaterial->tanggal_dibutuhkan)->translatedFormat('d F Y') }}</span>
                        </div>

                        <div>
                            <span class="text-xs font-bold uppercase tracking-wider text-slate-400 block mb-1">Tanggal Diajukan</span>
                            <span class="text-slate-600">{{ $requestMaterial->created_at->translatedFormat('d F Y, H:i') }} WIB</span>
                        </div>

                        <div>
                            <span class="text-xs font-bold uppercase tracking-wider text-slate-400 block mb-1">Catatan Tambahan</span>
                            <p class="text-slate-700 text-xs leading-relaxed bg-slate-50 p-3 rounded-xl border border-slate-100">{{ $requestMaterial->catatan ?: 'Tidak ada catatan tambahan.' }}</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Data Material Card --}}
            <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
                <div class="px-6 py-5 border-b border-slate-200 bg-slate-50/50">
                    <h3 class="text-base font-bold text-slate-900 flex items-center gap-2">
                        <span class="w-2 h-4 bg-blue-900 rounded-full inline-block"></span>
                        Rincian Item Material
                    </h3>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-slate-50 border-b border-slate-200">
                            <tr>
                                <th class="px-6 py-3.5 text-left text-xs font-bold text-slate-600 uppercase tracking-wider">Nama Barang</th>
                                <th class="px-6 py-3.5 text-left text-xs font-bold text-slate-600 uppercase tracking-wider">Spesifikasi Teknis</th>
                                <th class="px-6 py-3.5 text-center text-xs font-bold text-slate-600 uppercase tracking-wider">Jumlah (Qty)</th>
                                <th class="px-6 py-3.5 text-left text-xs font-bold text-slate-600 uppercase tracking-wider">Satuan</th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-slate-100 text-xs">
                            @foreach ($requestMaterial->items as $item)
                                <tr class="hover:bg-slate-50/80 transition">
                                    <td class="px-6 py-4 font-bold text-slate-900">{{ $item->nama_barang }}</td>
                                    <td class="px-6 py-4 text-slate-600 leading-relaxed">{{ $item->spesifikasi ?? '-' }}</td>
                                    <td class="px-6 py-4 text-center font-bold text-slate-900">{{ $item->qty }}</td>
                                    <td class="px-6 py-4 text-slate-600">{{ $item->satuan }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
