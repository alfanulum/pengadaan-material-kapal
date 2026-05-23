<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3">
            <div>
                <h2 class="font-bold text-2xl text-slate-900 leading-tight">
                    Permintaan dari Planner
                </h2>
                <p class="text-sm text-slate-500 mt-1">
                    Daftar pengajuan material yang sudah disetujui Planner dan siap diproses Supply Chain.
                </p>
            </div>

            <a href="{{ route('supply-chain.dashboard') }}"
                class="inline-flex items-center justify-center px-5 py-3 bg-slate-100 text-slate-700 rounded-xl font-semibold border border-slate-200 hover:bg-slate-200 transition">
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
                        Planner Approved Request
                    </p>

                    <h3 class="text-3xl md:text-4xl font-bold leading-tight">
                        Permintaan Material Siap Diproses
                    </h3>

                    <p class="mt-4 text-blue-100 max-w-3xl text-base leading-relaxed">
                        Supply Chain dapat melihat pengajuan material yang sudah disetujui Planner,
                        membuka detail kebutuhan material, lalu membuat tender untuk mengundang vendor.
                    </p>
                </div>

                <div class="bg-white/10 border border-white/10 rounded-2xl p-5 min-w-[190px]">
                    <p class="text-sm text-blue-100">Total Permintaan</p>
                    <p class="text-3xl font-bold mt-1">{{ $materialRequests->total() }}</p>
                </div>
            </div>
        </div>

        {{-- Table --}}
        <div class="bg-white rounded-3xl shadow-sm border border-slate-200 overflow-hidden">
            <div class="px-6 py-5 border-b border-slate-200">
                <h3 class="text-lg font-bold text-slate-900">
                    Daftar Permintaan Material
                </h3>
                <p class="text-sm text-slate-500 mt-1">
                    Pengajuan yang telah lolos verifikasi Planner.
                </p>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-slate-50 border-b border-slate-200">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">
                                Kode Pengajuan
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">
                                Project
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">
                                Engineer
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">
                                Status
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">
                                Tanggal
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">
                                Aksi
                            </th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-slate-100">
                        @forelse ($materialRequests as $request)
                            <tr class="hover:bg-slate-50 transition">
                                <td class="px-6 py-4 text-sm font-bold text-slate-900 whitespace-nowrap">
                                    {{ $request->kode_pengajuan ?? 'REQ-' . str_pad($request->id, 4, '0', STR_PAD_LEFT) }}
                                </td>

                                <td class="px-6 py-4 text-sm">
                                    <div class="font-bold text-slate-900">
                                        {{ $request->project->nama_project ?? '-' }}
                                    </div>
                                    <div class="text-xs text-slate-500 mt-1">
                                        Material request approved by Planner
                                    </div>
                                </td>

                                <td class="px-6 py-4 text-sm text-slate-700 whitespace-nowrap">
                                    {{ $request->user->name ?? '-' }}
                                </td>

                                <td class="px-6 py-4 text-sm whitespace-nowrap">
                                    @if ($request->status == 'disetujui')
                                        <span
                                            class="inline-flex px-3 py-1 rounded-full bg-green-100 text-green-700 text-xs font-bold">
                                            Disetujui
                                        </span>
                                    @elseif ($request->status == 'diajukan')
                                        <span
                                            class="inline-flex px-3 py-1 rounded-full bg-yellow-100 text-yellow-700 text-xs font-bold">
                                            Diajukan
                                        </span>
                                    @elseif ($request->status == 'ditolak')
                                        <span
                                            class="inline-flex px-3 py-1 rounded-full bg-red-100 text-red-700 text-xs font-bold">
                                            Ditolak
                                        </span>
                                    @else
                                        <span
                                            class="inline-flex px-3 py-1 rounded-full bg-slate-100 text-slate-700 text-xs font-bold">
                                            {{ str_replace('_', ' ', ucfirst($request->status)) }}
                                        </span>
                                    @endif
                                </td>

                                <td class="px-6 py-4 text-sm text-slate-700 whitespace-nowrap">
                                    {{ $request->created_at->format('d-m-Y') }}
                                </td>

                                <td class="px-6 py-4 text-sm whitespace-nowrap">
                                    <a href="{{ route('supply-chain.material-requests.show', $request->id) }}"
                                        class="inline-flex px-4 py-2 bg-blue-900 text-white rounded-xl text-xs font-semibold hover:bg-blue-950 transition">
                                        Detail
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-16 text-center">
                                    <div
                                        class="mx-auto w-16 h-16 rounded-2xl bg-slate-100 text-slate-400 flex items-center justify-center font-bold mb-4">
                                        MR
                                    </div>

                                    <h3 class="text-lg font-bold text-slate-900">
                                        Belum Ada Permintaan Disetujui
                                    </h3>

                                    <p class="text-sm text-slate-500 mt-2">
                                        Permintaan yang sudah disetujui Planner akan tampil di halaman ini.
                                    </p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="mt-6">
            {{ $materialRequests->links() }}
        </div>

    </div>
</x-app-layout>
