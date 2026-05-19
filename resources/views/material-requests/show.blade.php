<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Detail Pengajuan Material
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white shadow-sm sm:rounded-lg p-6">

                <div class="mb-6">
                    <h3 class="text-lg font-bold mb-4">Informasi Pengajuan</h3>

                    <table class="w-full border">
                        <tr>
                            <td class="border p-2 font-semibold w-1/3">Kode Pengajuan</td>
                            <td class="border p-2">{{ $requestMaterial->kode_pengajuan }}</td>
                        </tr>

                        <tr>
                            <td class="border p-2 font-semibold">Project</td>
                            <td class="border p-2">{{ $requestMaterial->project->nama_project }}</td>
                        </tr>

                        <tr>
                            <td class="border p-2 font-semibold">Tanggal Dibutuhkan</td>
                            <td class="border p-2">
                                {{ \Carbon\Carbon::parse($requestMaterial->tanggal_dibutuhkan)->format('d-m-Y') }}
                            </td>
                        </tr>

                        <tr>
                            <td class="border p-2 font-semibold">Status</td>
                            <td class="border p-2">{{ $requestMaterial->status }}</td>
                        </tr>

                        <tr>
                            <td class="border p-2 font-semibold">Catatan</td>
                            <td class="border p-2">{{ $requestMaterial->catatan ?? '-' }}</td>
                        </tr>
                    </table>
                </div>

                <div class="mb-6">
                    <h3 class="text-lg font-bold mb-4">Data Material</h3>

                    <table class="w-full border">
                        <thead>
                            <tr class="bg-gray-100">
                                <th class="border p-2 text-left">Nama Barang</th>
                                <th class="border p-2 text-left">Spesifikasi</th>
                                <th class="border p-2 text-left">Qty</th>
                                <th class="border p-2 text-left">Satuan</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($requestMaterial->items as $item)
                                <tr>
                                    <td class="border p-2">{{ $item->nama_barang }}</td>
                                    <td class="border p-2">{{ $item->spesifikasi ?? '-' }}</td>
                                    <td class="border p-2">{{ $item->qty }}</td>
                                    <td class="border p-2">{{ $item->satuan }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="flex gap-2">
                    <a href="{{ route('material-requests.index') }}" class="bg-gray-600 text-white px-4 py-2 rounded">
                        Kembali
                    </a>

                    @if ($requestMaterial->status == 'diajukan')
                        <a href="{{ route('material-requests.edit', $requestMaterial->id) }}"
                            class="bg-yellow-500 text-white px-4 py-2 rounded">
                            Edit Pengajuan
                        </a>
                    @endif
                </div>

            </div>

        </div>
    </div>
</x-app-layout>
