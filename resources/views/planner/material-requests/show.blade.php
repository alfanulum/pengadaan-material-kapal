<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3">
            <div>
                <h2 class="font-bold text-2xl text-slate-900 leading-tight">
                    Detail Pengajuan Material
                </h2>
                <p class="text-sm text-slate-500 mt-1">
                    Review detail material, dokumen Planner, dan proses verifikasi pengajuan.
                </p>
            </div>

            <a href="{{ route('planner.material-requests.index') }}"
                class="inline-flex items-center justify-center px-4 py-2 bg-slate-900 text-white rounded-xl text-sm font-semibold hover:bg-slate-800 transition">
                Kembali ke Daftar
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
                        Kode Pengajuan: {{ $requestMaterial->kode_pengajuan }}
                    </p>

                    <h3 class="text-3xl md:text-4xl font-bold leading-tight">
                        Review Detail Pengajuan Material
                    </h3>

                    <p class="mt-4 text-blue-100 max-w-3xl text-base leading-relaxed">
                        Periksa data pengajuan material dari Engineer, lengkapi dokumen RAB dan perizinan,
                        lalu lakukan persetujuan atau penolakan pengajuan.
                    </p>
                </div>

                <div>
                    @if ($requestMaterial->status == 'diajukan')
                        <span
                            class="inline-flex px-4 py-2 rounded-full bg-yellow-100 text-yellow-800 text-sm font-bold">
                            Diajukan
                        </span>
                    @elseif ($requestMaterial->status == 'disetujui')
                        <span class="inline-flex px-4 py-2 rounded-full bg-green-100 text-green-800 text-sm font-bold">
                            Disetujui
                        </span>
                    @elseif ($requestMaterial->status == 'ditolak')
                        <span class="inline-flex px-4 py-2 rounded-full bg-red-100 text-red-800 text-sm font-bold">
                            Ditolak
                        </span>
                    @else
                        <span class="inline-flex px-4 py-2 rounded-full bg-slate-100 text-slate-800 text-sm font-bold">
                            {{ $requestMaterial->status }}
                        </span>
                    @endif
                </div>
            </div>
        </div>

        @if (session('success'))
            <div class="mb-6 bg-green-50 border border-green-200 text-green-700 p-4 rounded-2xl">
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="mb-6 bg-red-50 border border-red-200 text-red-700 p-4 rounded-2xl">
                <strong>Terjadi kesalahan:</strong>
                <ul class="list-disc ml-5 mt-2 text-sm">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

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
                            Data utama pengajuan material dari Engineer.
                        </p>
                    </div>

                    <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div class="rounded-2xl bg-slate-50 p-4">
                            <p class="text-xs text-slate-500 mb-1">Kode Pengajuan</p>
                            <p class="font-bold text-slate-900">{{ $requestMaterial->kode_pengajuan }}</p>
                        </div>

                        <div class="rounded-2xl bg-slate-50 p-4">
                            <p class="text-xs text-slate-500 mb-1">Engineer</p>
                            <p class="font-bold text-slate-900">{{ $requestMaterial->user->name }}</p>
                        </div>

                        <div class="rounded-2xl bg-slate-50 p-4">
                            <p class="text-xs text-slate-500 mb-1">Project</p>
                            <p class="font-bold text-slate-900">{{ $requestMaterial->project->nama_project }}</p>
                        </div>

                        <div class="rounded-2xl bg-slate-50 p-4">
                            <p class="text-xs text-slate-500 mb-1">Tanggal Dibutuhkan</p>
                            <p class="font-bold text-slate-900">
                                {{ \Carbon\Carbon::parse($requestMaterial->tanggal_dibutuhkan)->format('d-m-Y') }}
                            </p>
                        </div>

                        <div class="rounded-2xl bg-slate-50 p-4">
                            <p class="text-xs text-slate-500 mb-1">Total RAB</p>
                            <p class="font-bold text-slate-900">
                                @if ($requestMaterial->total_rab)
                                    Rp {{ number_format($requestMaterial->total_rab, 0, ',', '.') }}
                                @else
                                    -
                                @endif
                            </p>
                        </div>

                        <div class="rounded-2xl bg-slate-50 p-4">
                            <p class="text-xs text-slate-500 mb-1">Status</p>
                            <p class="font-bold text-slate-900 capitalize">{{ $requestMaterial->status }}</p>
                        </div>

                        <div class="rounded-2xl bg-slate-50 p-4 md:col-span-2">
                            <p class="text-xs text-slate-500 mb-1">Catatan Engineer</p>
                            <p class="font-medium text-slate-900">{{ $requestMaterial->catatan ?? '-' }}</p>
                        </div>

                        <div class="rounded-2xl bg-slate-50 p-4 md:col-span-2">
                            <p class="text-xs text-slate-500 mb-1">Catatan Planner</p>
                            <p class="font-medium text-slate-900">{{ $requestMaterial->catatan_planner ?? '-' }}</p>
                        </div>
                    </div>
                </div>

                {{-- Data Material --}}
                <div class="bg-white rounded-3xl shadow-sm border border-slate-200 overflow-hidden">
                    <div class="px-6 py-5 border-b border-slate-200">
                        <h3 class="text-lg font-bold text-slate-900">
                            Data Material
                        </h3>
                        <p class="text-sm text-slate-500 mt-1">
                            Daftar item material yang diajukan.
                        </p>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead class="bg-slate-50 border-b border-slate-200">
                                <tr>
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
                                @foreach ($requestMaterial->items as $item)
                                    <tr class="hover:bg-slate-50 transition">
                                        <td class="px-6 py-4 text-sm font-semibold text-slate-900">
                                            {{ $item->nama_barang }}
                                        </td>
                                        <td class="px-6 py-4 text-sm text-slate-700">
                                            {{ $item->spesifikasi ?? '-' }}
                                        </td>
                                        <td class="px-6 py-4 text-sm text-slate-700">
                                            {{ $item->qty }}
                                        </td>
                                        <td class="px-6 py-4 text-sm text-slate-700">
                                            {{ $item->satuan }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                {{-- Dokumen Planner --}}
                <div class="bg-white rounded-3xl shadow-sm border border-slate-200 overflow-hidden">
                    <div class="px-6 py-5 border-b border-slate-200">
                        <h3 class="text-lg font-bold text-slate-900">
                            Dokumen Planner
                        </h3>
                        <p class="text-sm text-slate-500 mt-1">
                            Lengkapi dokumen RAB, perizinan, dan catatan hasil review.
                        </p>
                    </div>

                    <form action="{{ route('planner.material-requests.documents', $requestMaterial->id) }}"
                        method="POST" enctype="multipart/form-data" class="p-6">
                        @csrf

                        <div class="space-y-5">
                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-2">
                                    Total RAB
                                </label>
                                <input type="number" name="total_rab"
                                    class="w-full rounded-xl border-slate-300 focus:border-blue-800 focus:ring-blue-800"
                                    placeholder="Contoh: 25000000"
                                    value="{{ old('total_rab', $requestMaterial->total_rab) }}">
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-2">
                                    Upload Dokumen RAB
                                </label>
                                <input type="file" name="file_rab"
                                    class="w-full rounded-xl border border-slate-300 px-3 py-2 text-sm text-slate-700">

                                @if ($requestMaterial->file_rab)
                                    <a href="{{ asset('storage/' . $requestMaterial->file_rab) }}" target="_blank"
                                        class="inline-flex mt-3 text-sm font-semibold text-blue-800 hover:text-blue-950">
                                        Lihat Dokumen RAB
                                    </a>
                                @endif
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-2">
                                    Upload Dokumen Perizinan
                                </label>
                                <input type="file" name="file_perizinan"
                                    class="w-full rounded-xl border border-slate-300 px-3 py-2 text-sm text-slate-700">

                                @if ($requestMaterial->file_perizinan)
                                    <a href="{{ asset('storage/' . $requestMaterial->file_perizinan) }}"
                                        target="_blank"
                                        class="inline-flex mt-3 text-sm font-semibold text-blue-800 hover:text-blue-950">
                                        Lihat Dokumen Perizinan
                                    </a>
                                @endif
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-2">
                                    Catatan Planner
                                </label>
                                <textarea name="catatan_planner" rows="4"
                                    class="w-full rounded-xl border-slate-300 focus:border-blue-800 focus:ring-blue-800"
                                    placeholder="Contoh: RAB sudah dibuat berdasarkan kebutuhan material">{{ old('catatan_planner', $requestMaterial->catatan_planner) }}</textarea>
                            </div>
                        </div>

                        <button type="submit"
                            class="mt-6 inline-flex items-center justify-center px-6 py-3 bg-blue-900 text-white rounded-xl font-semibold shadow-lg hover:bg-blue-950 transition">
                            Simpan Dokumen Planner
                        </button>
                    </form>
                </div>

            </div>

            {{-- Kanan --}}
            <div class="lg:col-span-1 space-y-8">

                {{-- Panel Verifikasi --}}
                <div class="bg-white rounded-3xl shadow-sm border border-slate-200 overflow-hidden">
                    <div class="px-6 py-5 border-b border-slate-200">
                        <h3 class="text-lg font-bold text-slate-900">
                            Verifikasi Planner
                        </h3>
                        <p class="text-sm text-slate-500 mt-1">
                            Keputusan akhir dari Planner.
                        </p>
                    </div>

                    <div class="p-6">
                        @if ($requestMaterial->status == 'diajukan')
                            <form action="{{ route('planner.material-requests.approve', $requestMaterial->id) }}"
                                method="POST">
                                @csrf

                                <button type="submit"
                                    class="w-full inline-flex items-center justify-center px-5 py-3 bg-green-600 text-white rounded-xl font-semibold hover:bg-green-700 transition">
                                    Setujui Pengajuan
                                </button>
                            </form>

                            <div class="my-6 border-t border-slate-200"></div>

                            <form action="{{ route('planner.material-requests.reject', $requestMaterial->id) }}"
                                method="POST">
                                @csrf

                                <label class="block text-sm font-semibold text-slate-700 mb-2">
                                    Alasan Penolakan
                                </label>

                                <textarea name="catatan" rows="4"
                                    class="w-full rounded-xl border-slate-300 focus:border-red-600 focus:ring-red-600"
                                    placeholder="Masukkan alasan penolakan"></textarea>

                                <button type="submit"
                                    class="mt-4 w-full inline-flex items-center justify-center px-5 py-3 bg-red-600 text-white rounded-xl font-semibold hover:bg-red-700 transition">
                                    Tolak Pengajuan
                                </button>
                            </form>
                        @else
                            <div class="bg-slate-50 border border-slate-200 text-slate-700 p-4 rounded-2xl">
                                Pengajuan ini sudah diproses dengan status:
                                <strong class="capitalize">{{ $requestMaterial->status }}</strong>
                            </div>
                        @endif
                    </div>
                </div>

                {{-- Navigasi --}}
                <div class="bg-white rounded-3xl shadow-sm border border-slate-200 p-6">
                    <h3 class="text-lg font-bold text-slate-900">
                        Navigasi
                    </h3>

                    <div class="mt-5 space-y-3">
                        <a href="{{ route('planner.material-requests.index') }}"
                            class="w-full inline-flex items-center justify-center px-5 py-3 bg-slate-100 text-slate-700 rounded-xl font-semibold hover:bg-slate-200 transition">
                            Kembali ke Daftar
                        </a>

                        <a href="{{ route('planner.dashboard') }}"
                            class="w-full inline-flex items-center justify-center px-5 py-3 bg-slate-900 text-white rounded-xl font-semibold hover:bg-slate-800 transition">
                            Kembali ke Dashboard
                        </a>
                    </div>
                </div>

            </div>

        </div>
    </div>
</x-app-layout>
