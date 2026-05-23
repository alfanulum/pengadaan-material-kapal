<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3">
            <div>
                <h2 class="font-bold text-2xl text-slate-900 leading-tight">
                    Daftar Pengajuan Material
                </h2>
                <p class="text-sm text-slate-500 mt-1">
                    Monitoring seluruh pengajuan material yang telah dibuat oleh Engineer.
                </p>
            </div>

            <a href="{{ route('engineer.dashboard') }}"
                class="inline-flex items-center justify-center px-4 py-2 bg-slate-900 text-white rounded-xl text-sm font-semibold hover:bg-slate-800 transition">
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

            <div class="relative z-10 max-w-4xl">
                <p
                    class="inline-flex px-4 py-2 rounded-full bg-white/10 border border-white/10 text-sm text-blue-100 mb-5">
                    Material Request Monitoring
                </p>

                <h3 class="text-3xl md:text-4xl font-bold leading-tight">
                    Pantau Status Pengajuan Material
                </h3>

                <p class="mt-4 text-blue-100 max-w-3xl text-base leading-relaxed">
                    Halaman ini digunakan untuk melihat daftar pengajuan material,
                    status verifikasi Planner, serta detail kebutuhan material yang telah diajukan.
                </p>
            </div>
        </div>

        @if (session('success'))
            <div class="mb-6 bg-green-50 border border-green-200 text-green-700 p-4 rounded-2xl">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="mb-6 bg-red-50 border border-red-200 text-red-700 p-4 rounded-2xl">
                {{ session('error') }}
            </div>
        @endif

        {{-- Table Card --}}
        <div class="bg-white rounded-3xl shadow-sm border border-slate-200 overflow-hidden">

            <div
                class="px-6 py-5 border-b border-slate-200 flex flex-col md:flex-row md:items-center md:justify-between gap-3">
                <div>
                    <h3 class="text-lg font-bold text-slate-900">
                        Data Pengajuan Material
                    </h3>
                    <p class="text-sm text-slate-500 mt-1">
                        Daftar material request yang telah masuk ke sistem.
                    </p>
                </div>

                <div class="text-sm text-slate-500">
                    Total Data: <span class="font-bold text-slate-900">{{ $requests->count() }}</span>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-slate-50 border-b border-slate-200">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">
                                Kode
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">
                                Project
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">
                                Barang
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">
                                Qty
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">
                                Tanggal Dibutuhkan
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
                        @forelse ($requests as $request)
                            <tr class="hover:bg-slate-50 transition">
                                <td class="px-6 py-4 text-sm font-semibold text-slate-900 whitespace-nowrap">
                                    {{ $request->kode_pengajuan }}
                                </td>

                                <td class="px-6 py-4 text-sm text-slate-700 whitespace-nowrap">
                                    {{ $request->project->nama_project }}
                                </td>

                                <td class="px-6 py-4 text-sm text-slate-700">
                                    @foreach ($request->items as $item)
                                        <div class="font-medium">{{ $item->nama_barang }}</div>
                                    @endforeach
                                </td>

                                <td class="px-6 py-4 text-sm text-slate-700 whitespace-nowrap">
                                    @foreach ($request->items as $item)
                                        <div>{{ $item->qty }} {{ $item->satuan }}</div>
                                    @endforeach
                                </td>

                                <td class="px-6 py-4 text-sm text-slate-700 whitespace-nowrap">
                                    {{ \Carbon\Carbon::parse($request->tanggal_dibutuhkan)->format('d-m-Y') }}
                                </td>

                                <td class="px-6 py-4 text-sm whitespace-nowrap">
                                    @if ($request->status == 'diajukan')
                                        <span
                                            class="inline-flex px-3 py-1 rounded-full bg-yellow-100 text-yellow-700 text-xs font-bold">
                                            Diajukan
                                        </span>
                                    @elseif ($request->status == 'disetujui')
                                        <span
                                            class="inline-flex px-3 py-1 rounded-full bg-green-100 text-green-700 text-xs font-bold">
                                            Disetujui
                                        </span>
                                    @elseif ($request->status == 'ditolak')
                                        <span
                                            class="inline-flex px-3 py-1 rounded-full bg-red-100 text-red-700 text-xs font-bold">
                                            Ditolak
                                        </span>
                                    @else
                                        <span
                                            class="inline-flex px-3 py-1 rounded-full bg-slate-100 text-slate-700 text-xs font-bold">
                                            {{ $request->status }}
                                        </span>
                                    @endif
                                </td>

                                <td class="px-6 py-4 text-sm whitespace-nowrap">
                                    <div class="flex flex-wrap gap-2">
                                        <a href="{{ route('material-requests.show', $request->id) }}"
                                            class="inline-flex px-3 py-2 bg-blue-900 text-white rounded-lg text-xs font-semibold hover:bg-blue-950 transition">
                                            Detail
                                        </a>

                                        @if ($request->status == 'diajukan')
                                            <a href="{{ route('material-requests.edit', $request->id) }}"
                                                class="inline-flex px-3 py-2 bg-yellow-500 text-white rounded-lg text-xs font-semibold hover:bg-yellow-600 transition">
                                                Edit
                                            </a>

                                            <form action="{{ route('material-requests.destroy', $request->id) }}"
                                                method="POST"
                                                onsubmit="return confirm('Yakin ingin menghapus pengajuan ini?')">
                                                @csrf
                                                @method('DELETE')

                                                <button type="submit"
                                                    class="inline-flex px-3 py-2 bg-red-600 text-white rounded-lg text-xs font-semibold hover:bg-red-700 transition">
                                                    Hapus
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-6 py-16 text-center">
                                    <div
                                        class="mx-auto w-16 h-16 rounded-2xl bg-slate-100 text-slate-400 flex items-center justify-center font-bold mb-4">
                                        MR
                                    </div>

                                    <h3 class="text-lg font-bold text-slate-900">
                                        Belum Ada Pengajuan Material
                                    </h3>

                                    <p class="text-sm text-slate-500 mt-2">
                                        Data pengajuan material yang dibuat oleh Engineer akan tampil di halaman ini.
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
