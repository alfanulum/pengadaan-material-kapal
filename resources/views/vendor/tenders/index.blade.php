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

            <a href="{{ route('vendor.dashboard') }}"
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

        {{-- Ringkasan --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-5 mb-8">
            <div class="bg-white rounded-2xl p-5 shadow-sm border border-slate-200">
                <p class="text-sm text-slate-500">Tender Masuk</p>
                <h3 class="text-2xl font-bold text-slate-900 mt-2">
                    {{ $invitations->count() }}
                </h3>
                <p class="text-xs text-slate-400 mt-2">
                    Undangan tender diterima.
                </p>
            </div>

            <div class="bg-white rounded-2xl p-5 shadow-sm border border-slate-200">
                <p class="text-sm text-slate-500">Sudah Ditawar</p>
                <h3 class="text-2xl font-bold text-slate-900 mt-2">
                    {{ $invitations->where('status', 'ditawar')->count() + $invitations->where('status', 'terpilih')->count() + $invitations->where('status', 'tidak_terpilih')->count() }}
                </h3>
                <p class="text-xs text-slate-400 mt-2">
                    Tender yang sudah dikirim penawaran.
                </p>
            </div>

            <div class="bg-white rounded-2xl p-5 shadow-sm border border-slate-200">
                <p class="text-sm text-slate-500">Terpilih</p>
                <h3 class="text-2xl font-bold text-slate-900 mt-2">
                    {{ $invitations->where('status', 'terpilih')->count() }}
                </h3>
                <p class="text-xs text-slate-400 mt-2">
                    Tender yang dimenangkan vendor.
                </p>
            </div>
        </div>

        {{-- Table --}}
        <div class="bg-white rounded-3xl shadow-sm border border-slate-200 overflow-hidden">

            <div class="px-6 py-5 border-b border-slate-200">
                <h3 class="text-lg font-bold text-slate-900">
                    Tender Masuk Vendor
                </h3>
                <p class="text-sm text-slate-500 mt-1">
                    Vendor: {{ $vendor->nama_vendor }}
                </p>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-slate-50 border-b border-slate-200">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">
                                Kode Tender
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">
                                Tender
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">
                                Project
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">
                                Deadline
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">
                                Status
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">
                                Aksi
                            </th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-slate-100">
                        @forelse ($invitations as $invitation)
                            <tr class="hover:bg-slate-50 transition">
                                <td class="px-6 py-4 text-sm font-bold text-slate-900 whitespace-nowrap">
                                    {{ $invitation->tender->kode_tender }}
                                </td>

                                <td class="px-6 py-4 text-sm text-slate-700">
                                    <div class="font-bold text-slate-900">
                                        {{ $invitation->tender->nama_tender }}
                                    </div>
                                    <div class="text-xs text-slate-500 mt-1">
                                        {{ $invitation->tender->materialRequest->kode_pengajuan ?? '-' }}
                                    </div>
                                </td>

                                <td class="px-6 py-4 text-sm text-slate-700 whitespace-nowrap">
                                    {{ $invitation->tender->materialRequest->project->nama_project ?? '-' }}
                                </td>

                                <td class="px-6 py-4 text-sm text-slate-700 whitespace-nowrap">
                                    {{ \Carbon\Carbon::parse($invitation->tender->deadline)->format('d-m-Y') }}
                                </td>

                                <td class="px-6 py-4 text-sm whitespace-nowrap">
                                    @if ($invitation->status == 'dikirim')
                                        <span
                                            class="inline-flex px-3 py-1 rounded-full bg-yellow-100 text-yellow-700 text-xs font-bold">
                                            Dikirim
                                        </span>
                                    @elseif ($invitation->status == 'dibaca')
                                        <span
                                            class="inline-flex px-3 py-1 rounded-full bg-blue-100 text-blue-700 text-xs font-bold">
                                            Dibaca
                                        </span>
                                    @elseif ($invitation->status == 'ditawar')
                                        <span
                                            class="inline-flex px-3 py-1 rounded-full bg-green-100 text-green-700 text-xs font-bold">
                                            Ditawar
                                        </span>
                                    @elseif ($invitation->status == 'terpilih')
                                        <span
                                            class="inline-flex px-3 py-1 rounded-full bg-emerald-100 text-emerald-700 text-xs font-bold">
                                            Terpilih
                                        </span>
                                    @elseif ($invitation->status == 'tidak_terpilih')
                                        <span
                                            class="inline-flex px-3 py-1 rounded-full bg-red-100 text-red-700 text-xs font-bold">
                                            Tidak Terpilih
                                        </span>
                                    @else
                                        <span
                                            class="inline-flex px-3 py-1 rounded-full bg-slate-100 text-slate-700 text-xs font-bold">
                                            {{ str_replace('_', ' ', $invitation->status) }}
                                        </span>
                                    @endif
                                </td>

                                <td class="px-6 py-4 text-sm whitespace-nowrap">
                                    <a href="{{ route('vendor.tenders.show', $invitation->id) }}"
                                        class="inline-flex px-4 py-2 bg-blue-900 text-white rounded-xl text-xs font-semibold hover:bg-blue-950 transition">
                                        Detail Tender
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
