<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Data Tender
            </h2>

            <a href="{{ route('supply-chain.material-requests.index') }}"
                class="px-4 py-2 bg-gray-600 text-white rounded-lg">
                + Buat dari Pengajuan
            </a>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if (session('success'))
                <div class="mb-4 p-4 bg-green-100 text-green-700 rounded-lg">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white shadow rounded-lg overflow-hidden">
                <table class="w-full text-sm">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="px-4 py-3 text-left">Kode Tender</th>
                            <th class="px-4 py-3 text-left">Nama Tender</th>
                            <th class="px-4 py-3 text-left">Pengajuan</th>
                            <th class="px-4 py-3 text-left">Deadline</th>
                            <th class="px-4 py-3 text-left">Status</th>
                            <th class="px-4 py-3 text-left">Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($tenders as $tender)
                            <tr class="border-t">
                                <td class="px-4 py-3">{{ $tender->kode_tender }}</td>
                                <td class="px-4 py-3">{{ $tender->nama_tender }}</td>
                                <td class="px-4 py-3">
                                    REQ-{{ str_pad($tender->material_request_id, 4, '0', STR_PAD_LEFT) }}
                                </td>
                                <td class="px-4 py-3">{{ $tender->deadline }}</td>
                                <td class="px-4 py-3">
                                    <span class="px-2 py-1 bg-blue-100 text-blue-700 rounded text-xs">
                                        {{ str_replace('_', ' ', ucfirst($tender->status)) }}
                                    </span>
                                </td>
                                <td class="px-4 py-3">
                                    <a href="{{ route('supply-chain.tenders.show', $tender) }}" class="text-blue-600">
                                        Detail
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-4 py-6 text-center text-gray-500">
                                    Belum ada data tender.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-4">
                {{ $tenders->links() }}
            </div>

        </div>
    </div>
</x-app-layout>
