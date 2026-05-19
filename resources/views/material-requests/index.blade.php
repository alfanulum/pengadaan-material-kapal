<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Daftar Pengajuan Material
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if (session('success'))
                <div class="mb-4 bg-green-100 text-green-700 p-4 rounded">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="mb-4 bg-red-100 text-red-700 p-4 rounded">
                    {{ session('error') }}
                </div>
            @endif

            <div class="mb-4 flex justify-between items-center">
                <a href="{{ route('material-requests.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded">
                    + Buat Pengajuan Material
                </a>
            </div>

            <div class="bg-white shadow-sm sm:rounded-lg p-6 overflow-x-auto">
                <table class="w-full border">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="border p-2 text-left">Kode</th>
                            <th class="border p-2 text-left">Project</th>
                            <th class="border p-2 text-left">Barang</th>
                            <th class="border p-2 text-left">Qty</th>
                            <th class="border p-2 text-left">Tanggal Dibutuhkan</th>
                            <th class="border p-2 text-left">Status</th>
                            <th class="border p-2 text-left">Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($requests as $request)
                            <tr>
                                <td class="border p-2">
                                    {{ $request->kode_pengajuan }}
                                </td>

                                <td class="border p-2">
                                    {{ $request->project->nama_project }}
                                </td>

                                <td class="border p-2">
                                    @foreach ($request->items as $item)
                                        <div>{{ $item->nama_barang }}</div>
                                    @endforeach
                                </td>

                                <td class="border p-2">
                                    @foreach ($request->items as $item)
                                        <div>{{ $item->qty }} {{ $item->satuan }}</div>
                                    @endforeach
                                </td>

                                <td class="border p-2">
                                    {{ \Carbon\Carbon::parse($request->tanggal_dibutuhkan)->format('d-m-Y') }}
                                </td>

                                <td class="border p-2">
                                    @if ($request->status == 'diajukan')
                                        <span class="px-2 py-1 bg-yellow-100 text-yellow-700 rounded">
                                            Diajukan
                                        </span>
                                    @elseif ($request->status == 'disetujui')
                                        <span class="px-2 py-1 bg-green-100 text-green-700 rounded">
                                            Disetujui
                                        </span>
                                    @elseif ($request->status == 'ditolak')
                                        <span class="px-2 py-1 bg-red-100 text-red-700 rounded">
                                            Ditolak
                                        </span>
                                    @else
                                        <span class="px-2 py-1 bg-gray-100 text-gray-700 rounded">
                                            {{ $request->status }}
                                        </span>
                                    @endif
                                </td>

                                <td class="border p-2">
                                    <div class="flex gap-2">
                                        <a href="{{ route('material-requests.show', $request->id) }}"
                                            class="bg-blue-600 text-white px-3 py-1 rounded text-sm">
                                            Detail
                                        </a>

                                        @if ($request->status == 'diajukan')
                                            <a href="{{ route('material-requests.edit', $request->id) }}"
                                                class="bg-yellow-500 text-white px-3 py-1 rounded text-sm">
                                                Edit
                                            </a>

                                            <form action="{{ route('material-requests.destroy', $request->id) }}"
                                                method="POST"
                                                onsubmit="return confirm('Yakin ingin menghapus pengajuan ini?')">
                                                @csrf
                                                @method('DELETE')

                                                <button type="submit"
                                                    class="bg-red-600 text-white px-3 py-1 rounded text-sm">
                                                    Hapus
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="border p-4 text-center text-gray-500">
                                    Belum ada pengajuan material.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</x-app-layout>
