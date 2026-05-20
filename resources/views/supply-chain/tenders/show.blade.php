<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Detail Tender
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white p-6 shadow rounded-lg mb-6">
                <h3 class="text-lg font-semibold mb-4">Informasi Tender</h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <p class="text-sm text-gray-500">Kode Tender</p>
                        <p class="font-semibold">{{ $tender->kode_tender }}</p>
                    </div>

                    <div>
                        <p class="text-sm text-gray-500">Nama Tender</p>
                        <p class="font-semibold">{{ $tender->nama_tender }}</p>
                    </div>

                    <div>
                        <p class="text-sm text-gray-500">Kode Pengajuan</p>
                        <p class="font-semibold">
                            REQ-{{ str_pad($tender->material_request_id, 4, '0', STR_PAD_LEFT) }}
                        </p>
                    </div>

                    <div>
                        <p class="text-sm text-gray-500">Deadline</p>
                        <p class="font-semibold">{{ $tender->deadline }}</p>
                    </div>

                    <div>
                        <p class="text-sm text-gray-500">Status</p>
                        <p class="font-semibold">
                            {{ str_replace('_', ' ', ucfirst($tender->status)) }}
                        </p>
                    </div>

                    <div>
                        <p class="text-sm text-gray-500">Catatan</p>
                        <p class="font-semibold">{{ $tender->catatan ?? '-' }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white p-6 shadow rounded-lg">
                <h3 class="text-lg font-semibold mb-4">Vendor yang Diundang</h3>

                <table class="w-full text-sm">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="px-4 py-3 text-left">No</th>
                            <th class="px-4 py-3 text-left">Nama Vendor</th>
                            <th class="px-4 py-3 text-left">Email</th>
                            <th class="px-4 py-3 text-left">Kategori</th>
                            <th class="px-4 py-3 text-left">Status Undangan</th>
                            <th class="px-4 py-3 text-left">Waktu Kirim</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($tender->invitations as $invitation)
                            <tr class="border-t">
                                <td class="px-4 py-3">{{ $loop->iteration }}</td>
                                <td class="px-4 py-3">{{ $invitation->vendor->nama_vendor ?? '-' }}</td>
                                <td class="px-4 py-3">{{ $invitation->vendor->email ?? '-' }}</td>
                                <td class="px-4 py-3">{{ $invitation->vendor->kategori ?? '-' }}</td>
                                <td class="px-4 py-3">
                                    <span class="px-2 py-1 bg-green-100 text-green-700 rounded text-xs">
                                        {{ str_replace('_', ' ', ucfirst($invitation->status)) }}
                                    </span>
                                </td>
                                <td class="px-4 py-3">
                                    {{ $invitation->sent_at ? \Carbon\Carbon::parse($invitation->sent_at)->format('d-m-Y H:i') : '-' }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-4 py-6 text-center text-gray-500">
                                    Belum ada vendor yang diundang.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                <div class="mt-6 flex justify-end gap-2">
                    <a href="{{ route('supply-chain.tenders.index') }}"
                        class="px-4 py-2 bg-gray-500 text-white rounded-lg">
                        Kembali
                    </a>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
