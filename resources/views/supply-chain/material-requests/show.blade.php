<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3">
            <div>
                <h2 class="font-bold text-2xl text-slate-900 leading-tight">
                    Detail Permintaan dari Planner
                </h2>
                <p class="text-sm text-slate-500 mt-1">
                    Detail pengajuan material yang sudah diverifikasi Planner.
                </p>
            </div>

            
            <a href="{{ route('supply-chain.material-requests.index') }}"
                class="inline-flex items-center gap-2 px-5 py-2.5 bg-white border border-slate-200 hover:bg-slate-50 text-slate-700 rounded-xl text-sm font-semibold shadow-sm transition hover:-translate-y-0.5">
                <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                <span>Kembali ke Permintaan</span>
            </a>
        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

            {{-- Kiri --}}
            <div class="lg:col-span-2 space-y-8">

                {{-- Informasi Pengajuan --}}
                <div class="bg-white rounded-3xl shadow-sm border border-slate-200 overflow-hidden">
                    <div class="px-6 py-5 border-b border-slate-200">
                        <h3 class="text-lg font-bold text-slate-900">
                            Informasi Pengajuan
                        </h3>
                        <p class="text-sm text-slate-500 mt-1">
                            Data utama pengajuan material dari Engineer yang sudah diverifikasi Planner.
                        </p>
                    </div>

                    <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div class="rounded-2xl bg-slate-50 p-4">
                            <p class="text-xs text-slate-500 mb-1">Kode Pengajuan</p>
                            <p class="font-bold text-slate-900">
                                {{ $materialRequest->kode_pengajuan ?? 'REQ-' . str_pad($materialRequest->id, 4, '0', STR_PAD_LEFT) }}
                            </p>
                        </div>

                        <div class="rounded-2xl bg-slate-50 p-4">
                            <p class="text-xs text-slate-500 mb-1">Project</p>
                            <p class="font-bold text-slate-900">
                                {{ $materialRequest->project->nama_project ?? '-' }}
                            </p>
                        </div>

                        <div class="rounded-2xl bg-slate-50 p-4">
                            <p class="text-xs text-slate-500 mb-1">Engineer</p>
                            <p class="font-bold text-slate-900">
                                {{ $materialRequest->user->name ?? '-' }}
                            </p>
                        </div>

                        <div class="rounded-2xl bg-slate-50 p-4">
                            <p class="text-xs text-slate-500 mb-1">Status</p>
                            <p class="font-bold text-slate-900 capitalize">
                                {{ str_replace('_', ' ', $materialRequest->status) }}
                            </p>
                        </div>

                        <div class="rounded-2xl bg-slate-50 p-4">
                            <p class="text-xs text-slate-500 mb-1">Tanggal Pengajuan</p>
                            <p class="font-bold text-slate-900">
                                {{ $materialRequest->created_at->format('d-m-Y H:i') }}
                            </p>
                        </div>

                        <div class="rounded-2xl bg-slate-50 p-4">
                            <p class="text-xs text-slate-500 mb-1">Jumlah Item</p>
                            <p class="font-bold text-slate-900">
                                {{ $materialRequest->items->count() }} Item
                            </p>
                        </div>

                        <div class="rounded-2xl bg-slate-50 p-4 md:col-span-2">
                            <p class="text-xs text-slate-500 mb-1">Total RAB (Anggaran)</p>
                            <p class="font-bold text-emerald-700 text-lg">
                                Rp {{ number_format($materialRequest->total_rab, 0, ',', '.') }}
                            </p>
                        </div>

                        <div class="rounded-2xl bg-slate-50 p-4">
                            <p class="text-xs text-slate-500 mb-1">Dokumen RAB</p>
                            @if($materialRequest->file_rab)
                                <a href="{{ asset('storage/' . $materialRequest->file_rab) }}" target="_blank"
                                    class="inline-flex items-center gap-1.5 text-sm font-semibold text-blue-700 hover:text-blue-900 underline mt-1">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"></path></svg>
                                    Lihat RAB
                                </a>
                            @else
                                <p class="text-sm font-medium text-slate-500 mt-1">Tidak ada file RAB</p>
                            @endif
                        </div>

                        <div class="rounded-2xl bg-slate-50 p-4">
                            <p class="text-xs text-slate-500 mb-1">Dokumen Perizinan</p>
                            @if($materialRequest->file_perizinan)
                                <a href="{{ asset('storage/' . $materialRequest->file_perizinan) }}" target="_blank"
                                    class="inline-flex items-center gap-1.5 text-sm font-semibold text-blue-700 hover:text-blue-900 underline mt-1">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"></path></svg>
                                    Lihat Perizinan
                                </a>
                            @else
                                <p class="text-sm font-medium text-slate-500 mt-1">Tidak ada file perizinan</p>
                            @endif
                        </div>

                        <div class="rounded-2xl bg-slate-50 p-4 md:col-span-2">
                            <p class="text-xs text-slate-500 mb-1">Catatan</p>
                            <p class="font-medium text-slate-900">
                                {{ $materialRequest->catatan ?? '-' }}
                            </p>
                        </div>
                    </div>
                </div>

                {{-- Item Material --}}
                <div class="bg-white rounded-3xl shadow-sm border border-slate-200 overflow-hidden">
                    <div class="px-6 py-5 border-b border-slate-200">
                        <h3 class="text-lg font-bold text-slate-900">
                            Daftar Item Material
                        </h3>
                        <p class="text-sm text-slate-500 mt-1">
                            Item material yang akan diproses ke tahap tender.
                        </p>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead class="bg-slate-50 border-b border-slate-200">
                                <tr>
                                    <th
                                        class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">
                                        No
                                    </th>
                                    <th
                                        class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">
                                        Nama Barang
                                    </th>
                                    <th
                                        class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">
                                        Spesifikasi
                                    </th>
                                    <th
                                        class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">
                                        Qty
                                    </th>
                                    <th
                                        class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">
                                        Satuan
                                    </th>
                                </tr>
                            </thead>

                            <tbody class="divide-y divide-slate-100">
                                @forelse ($materialRequest->items as $item)
                                    <tr class="hover:bg-slate-50 transition">
                                        <td class="px-6 py-4 text-sm font-bold text-slate-900">
                                            {{ $loop->iteration }}
                                        </td>

                                        <td class="px-6 py-4 text-sm font-bold text-slate-900">
                                            {{ $item->nama_barang ?? '-' }}
                                        </td>

                                        <td class="px-6 py-4 text-sm text-slate-700">
                                            {{ $item->spesifikasi ?? '-' }}
                                        </td>

                                        <td class="px-6 py-4 text-sm text-slate-700 whitespace-nowrap">
                                            {{ $item->qty ?? '-' }}
                                        </td>

                                        <td class="px-6 py-4 text-sm text-slate-700 whitespace-nowrap">
                                            {{ $item->satuan ?? '-' }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-6 py-16 text-center">
                                            <div
                                                class="mx-auto w-16 h-16 rounded-2xl bg-slate-100 text-slate-400 flex items-center justify-center font-bold mb-4">
                                                IT
                                            </div>

                                            <h3 class="text-lg font-bold text-slate-900">
                                                Belum Ada Item Material
                                            </h3>

                                            <p class="text-sm text-slate-500 mt-2">
                                                Item material akan tampil di bagian ini.
                                            </p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>

            {{-- Kanan --}}
            <div class="lg:col-span-1 space-y-6">

                {{-- Action Tender --}}
                <div class="bg-white rounded-3xl shadow-sm border border-slate-200 p-6">
                    <h3 class="text-lg font-bold text-slate-900">
                        Proses Tender
                    </h3>

                    <p class="text-sm text-slate-500 mt-2 leading-relaxed">
                        Buat tender berdasarkan permintaan material ini dan undang vendor untuk mengirim penawaran.
                    </p>

                    <div class="mt-6 space-y-3">
                        <a href="{{ route('supply-chain.tenders.create', $materialRequest->id) }}"
                            class="w-full inline-flex items-center justify-center px-5 py-3 bg-gradient-to-r from-slate-900 to-blue-900 text-white rounded-xl font-semibold shadow-lg hover:from-slate-800 hover:to-blue-800 hover:shadow-lg transition">
                            Buat Tender
                        </a>

                        <a href="{{ route('supply-chain.material-requests.index') }}"
                            class="w-full inline-flex items-center justify-center px-5 py-3 bg-slate-100 text-slate-700 rounded-xl font-semibold hover:bg-slate-200 transition">
                            Kembali ke Daftar
                        </a>
                    </div>
                </div>

                
                </div>

                

    </div>
</x-app-layout>
