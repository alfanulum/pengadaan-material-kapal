<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Detail Permintaan dari Planner
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white p-6 shadow rounded-lg mb-6">
                <h3 class="text-lg font-semibold mb-4">Informasi Pengajuan</h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <p class="text-sm text-gray-500">Kode Pengajuan</p>
                        <p class="font-semibold">
                            REQ-{{ str_pad($materialRequest->id, 4, '0', STR_PAD_LEFT) }}
                        </p>
                    </div>

                    <div>
                        <p class="text-sm text-gray-500">Project</p>
                        <p class="font-semibold">
                            {{ $materialRequest->project->nama_project ?? '-' }}
                        </p>
                    </div>

                    <div>
                        <p class="text-sm text-gray-500">Engineer</p>
                        <p class="font-semibold">
                            {{ $materialRequest->user->name ?? '-' }}
                        </p>
                    </div>

                    <div>
                        <p class="text-sm text-gray-500">Status</p>
                        <p class="font-semibold">
                            {{ str_replace('_', ' ', ucfirst($materialRequest->status)) }}
                        </p>
                    </div>

                    <div>
                        <p class="text-sm text-gray-500">Tanggal Pengajuan</p>
                        <p class="font-semibold">
                            {{ $materialRequest->created_at->format('d-m-Y H:i') }}
                        </p>
                    </div>

                    <div>
                        <p class="text-sm text-gray-500">Catatan</p>
                        <p class="font-semibold">
                            {{ $materialRequest->catatan ?? '-' }}
                        </p>
                    </div>
                </div>
            </div>

            <div class="bg-white p-6 shadow rounded-lg">
                <h3 class="text-lg font-semibold mb-4">Daftar Item Material</h3>

                <table class="w-full text-sm">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="px-4 py-3 text-left">No</th>
                            <th class="px-4 py-3 text-left">Nama Barang</th>
                            <th class="px-4 py-3 text-left">Spesifikasi</th>
                            <th class="px-4 py-3 text-left">Qty</th>
                            <th class="px-4 py-3 text-left">Satuan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($materialRequest->items as $item)
                            <tr class="border-t">
                                <td class="px-4 py-3">{{ $loop->iteration }}</td>
                                <td class="px-4 py-3">{{ $item->nama_barang ?? '-' }}</td>
                                <td class="px-4 py-3">{{ $item->spesifikasi ?? '-' }}</td>
                                <td class="px-4 py-3">{{ $item->qty ?? '-' }}</td>
                                <td class="px-4 py-3">{{ $item->satuan ?? '-' }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-4 py-6 text-center text-gray-500">
                                    Belum ada item material.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                <div class="mt-6 flex justify-end gap-2">
                    <a href="{{ route('supply-chain.material-requests.index') }}"
                        class="px-4 py-2 bg-gray-500 text-white rounded-lg">
                        Kembali
                    </a>

                    <a href="{{ route('supply-chain.tenders.create', $materialRequest->id) }}"
                        class="px-4 py-2 bg-blue-600 text-white rounded-lg">
                        Buat Tender
                    </a>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
