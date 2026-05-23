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
                class="inline-flex items-center justify-center px-5 py-3 bg-slate-100 text-slate-700 rounded-xl font-semibold border border-slate-200 hover:bg-slate-200 transition">
                Kembali ke Permintaan
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
                        {{ $materialRequest->kode_pengajuan ?? 'REQ-' . str_pad($materialRequest->id, 4, '0', STR_PAD_LEFT) }}
                    </p>

                    <h3 class="text-3xl md:text-4xl font-bold leading-tight">
                        Permintaan Material dari Planner
                    </h3>

                    <p class="mt-4 text-blue-100 max-w-3xl text-base leading-relaxed">
                        Periksa detail pengajuan material, project, engineer, item material,
                        dan lanjutkan ke proses pembuatan tender vendor.
                    </p>
                </div>

                <div>
                    @if ($materialRequest->status == 'disetujui')
                        <span class="inline-flex px-4 py-2 rounded-full bg-green-100 text-green-800 text-sm font-bold">
                            Disetujui Planner
                        </span>
                    @else
                        <span class="inline-flex px-4 py-2 rounded-full bg-slate-100 text-slate-800 text-sm font-bold">
                            {{ str_replace('_', ' ', ucfirst($materialRequest->status)) }}
                        </span>
                    @endif
                </div>
            </div>
        </div>

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
                            class="w-full inline-flex items-center justify-center px-5 py-3 bg-blue-900 text-white rounded-xl font-semibold shadow-lg hover:bg-blue-950 transition">
                            Buat Tender
                        </a>

                        <a href="{{ route('supply-chain.material-requests.index') }}"
                            class="w-full inline-flex items-center justify-center px-5 py-3 bg-slate-100 text-slate-700 rounded-xl font-semibold hover:bg-slate-200 transition">
                            Kembali ke Daftar
                        </a>
                    </div>
                </div>

                {{-- Alur --}}
                <div class="bg-white rounded-3xl shadow-sm border border-slate-200 p-6">
                    <h3 class="text-lg font-bold text-slate-900">
                        Alur Berikutnya
                    </h3>

                    <div class="mt-5 space-y-4">
                        <div class="flex gap-3">
                            <span
                                class="w-8 h-8 rounded-xl bg-blue-100 text-blue-900 flex items-center justify-center text-xs font-bold shrink-0">
                                1
                            </span>
                            <div>
                                <p class="font-semibold text-slate-900 text-sm">Buat Tender</p>
                                <p class="text-xs text-slate-500 mt-1">Supply Chain membuat tender dari permintaan ini.
                                </p>
                            </div>
                        </div>

                        <div class="flex gap-3">
                            <span
                                class="w-8 h-8 rounded-xl bg-blue-100 text-blue-900 flex items-center justify-center text-xs font-bold shrink-0">
                                2
                            </span>
                            <div>
                                <p class="font-semibold text-slate-900 text-sm">Undang Vendor</p>
                                <p class="text-xs text-slate-500 mt-1">Vendor dipilih dan menerima undangan tender.</p>
                            </div>
                        </div>

                        <div class="flex gap-3">
                            <span
                                class="w-8 h-8 rounded-xl bg-blue-100 text-blue-900 flex items-center justify-center text-xs font-bold shrink-0">
                                3
                            </span>
                            <div>
                                <p class="font-semibold text-slate-900 text-sm">Penawaran Vendor</p>
                                <p class="text-xs text-slate-500 mt-1">Vendor mengirim harga, estimasi, dan dokumen
                                    penawaran.</p>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Ringkasan --}}
                <div
                    class="bg-gradient-to-r from-slate-950 via-blue-950 to-blue-800 rounded-3xl shadow-xl text-white p-6">
                    <p class="text-sm text-blue-100">
                        Status Pengajuan
                    </p>

                    <h3 class="text-2xl font-bold mt-2 capitalize">
                        {{ str_replace('_', ' ', $materialRequest->status) }}
                    </h3>

                    <p class="text-sm text-blue-100 mt-3">
                        Permintaan ini sudah dapat diproses oleh Supply Chain untuk proses tender vendor.
                    </p>
                </div>

            </div>

        </div>

    </div>
</x-app-layout>
