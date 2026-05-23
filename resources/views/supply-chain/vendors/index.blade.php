<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3">
            <div>
                <h2 class="font-bold text-2xl text-slate-900 leading-tight">
                    Data Vendor
                </h2>
                <p class="text-sm text-slate-500 mt-1">
                    Kelola data vendor penyedia material kapal untuk proses tender dan procurement.
                </p>
            </div>

            <div class="flex flex-col sm:flex-row gap-3">
                <a href="{{ route('supply-chain.dashboard') }}"
                    class="inline-flex items-center justify-center px-5 py-3 bg-slate-100 text-slate-700 rounded-xl font-semibold border border-slate-200 hover:bg-slate-200 transition">
                    Kembali ke Dashboard
                </a>

                <a href="{{ route('supply-chain.vendors.create') }}"
                    class="inline-flex items-center justify-center px-5 py-3 bg-blue-900 text-white rounded-xl font-semibold shadow-lg hover:bg-blue-950 transition">
                    + Tambah Vendor
                </a>
            </div>
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
                        Vendor Management
                    </p>

                    <h3 class="text-3xl md:text-4xl font-bold leading-tight">
                        Kelola Vendor Pengadaan Material
                    </h3>

                    <p class="mt-4 text-blue-100 max-w-3xl text-base leading-relaxed">
                        Supply Chain dapat menambahkan vendor, mengelola data kontak,
                        melihat detail vendor, serta menentukan status vendor aktif atau nonaktif.
                    </p>
                </div>

                <div class="bg-white/10 border border-white/10 rounded-2xl p-5 min-w-[180px]">
                    <p class="text-sm text-blue-100">Total Vendor</p>
                    <p class="text-3xl font-bold mt-1">{{ $vendors->total() }}</p>
                </div>
            </div>
        </div>

        @if (session('success'))
            <div class="mb-6 p-4 bg-green-50 border border-green-200 text-green-700 rounded-2xl">
                {{ session('success') }}
            </div>
        @endif

        {{-- Table --}}
        <div class="bg-white rounded-3xl shadow-sm border border-slate-200 overflow-hidden">
            <div class="px-6 py-5 border-b border-slate-200">
                <h3 class="text-lg font-bold text-slate-900">
                    Daftar Vendor
                </h3>
                <p class="text-sm text-slate-500 mt-1">
                    Data vendor yang dapat diundang dalam proses tender.
                </p>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-slate-50 border-b border-slate-200">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">
                                Kode
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">
                                Vendor
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">
                                Kontak
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">
                                PIC
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
                        @forelse ($vendors as $vendor)
                            <tr class="hover:bg-slate-50 transition">
                                <td class="px-6 py-4 text-sm font-bold text-slate-900 whitespace-nowrap">
                                    {{ $vendor->kode_vendor }}
                                </td>

                                <td class="px-6 py-4 text-sm">
                                    <div class="font-bold text-slate-900">
                                        {{ $vendor->nama_vendor }}
                                    </div>
                                    <div class="text-xs text-slate-500 mt-1">
                                        {{ $vendor->kategori ?? 'Kategori belum diisi' }}
                                    </div>
                                </td>

                                <td class="px-6 py-4 text-sm text-slate-700">
                                    <div>{{ $vendor->email ?? '-' }}</div>
                                    <div class="text-xs text-slate-500 mt-1">
                                        {{ $vendor->telepon ?? '-' }}
                                    </div>
                                </td>

                                <td class="px-6 py-4 text-sm text-slate-700 whitespace-nowrap">
                                    {{ $vendor->pic ?? '-' }}
                                </td>

                                <td class="px-6 py-4 text-sm whitespace-nowrap">
                                    @if ($vendor->status == 'aktif')
                                        <span
                                            class="inline-flex px-3 py-1 rounded-full bg-green-100 text-green-700 text-xs font-bold">
                                            Aktif
                                        </span>
                                    @else
                                        <span
                                            class="inline-flex px-3 py-1 rounded-full bg-red-100 text-red-700 text-xs font-bold">
                                            Nonaktif
                                        </span>
                                    @endif
                                </td>

                                <td class="px-6 py-4 text-sm whitespace-nowrap">
                                    <div class="flex flex-wrap gap-2">
                                        <a href="{{ route('supply-chain.vendors.show', $vendor) }}"
                                            class="inline-flex px-3 py-2 bg-blue-900 text-white rounded-lg text-xs font-semibold hover:bg-blue-950 transition">
                                            Detail
                                        </a>

                                        <a href="{{ route('supply-chain.vendors.edit', $vendor) }}"
                                            class="inline-flex px-3 py-2 bg-yellow-500 text-white rounded-lg text-xs font-semibold hover:bg-yellow-600 transition">
                                            Edit
                                        </a>

                                        <form action="{{ route('supply-chain.vendors.destroy', $vendor) }}"
                                            method="POST"
                                            onsubmit="return confirm('Yakin ingin menghapus vendor ini?')">
                                            @csrf
                                            @method('DELETE')

                                            <button type="submit"
                                                class="inline-flex px-3 py-2 bg-red-600 text-white rounded-lg text-xs font-semibold hover:bg-red-700 transition">
                                                Hapus
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-16 text-center">
                                    <div
                                        class="mx-auto w-16 h-16 rounded-2xl bg-slate-100 text-slate-400 flex items-center justify-center font-bold mb-4">
                                        VD
                                    </div>

                                    <h3 class="text-lg font-bold text-slate-900">
                                        Belum Ada Data Vendor
                                    </h3>

                                    <p class="text-sm text-slate-500 mt-2">
                                        Data vendor yang ditambahkan Supply Chain akan tampil di halaman ini.
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
