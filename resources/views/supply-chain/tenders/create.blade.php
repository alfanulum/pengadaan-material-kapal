<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Buat Tender
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">

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
                </div>
            </div>

            <div class="bg-white p-6 shadow rounded-lg">
                <form action="{{ route('supply-chain.tenders.store') }}" method="POST">
                    @csrf

                    <input type="hidden" name="material_request_id" value="{{ $materialRequest->id }}">

                    <div class="mb-4">
                        <label class="block mb-1">Nama Tender</label>
                        <input type="text" name="nama_tender"
                            value="{{ old('nama_tender', 'Tender Pengadaan Material REQ-' . str_pad($materialRequest->id, 4, '0', STR_PAD_LEFT)) }}"
                            class="w-full border-gray-300 rounded-lg">
                        @error('nama_tender')
                            <p class="text-red-600 text-sm">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block mb-1">Deadline Penawaran</label>
                        <input type="date" name="deadline" value="{{ old('deadline') }}"
                            class="w-full border-gray-300 rounded-lg">
                        @error('deadline')
                            <p class="text-red-600 text-sm">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block mb-1">Catatan Tender</label>
                        <textarea name="catatan" rows="3" class="w-full border-gray-300 rounded-lg"
                            placeholder="Contoh: Mohon lampirkan quotation dan estimasi pengiriman.">{{ old('catatan') }}</textarea>
                    </div>

                    <div class="mb-4">
                        <label class="block mb-2">Pilih Vendor yang Diundang</label>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                            @forelse ($vendors as $vendor)
                                <label class="flex items-start gap-2 p-3 border rounded-lg">
                                    <input type="checkbox" name="vendor_ids[]" value="{{ $vendor->id }}"
                                        class="mt-1">

                                    <span>
                                        <span class="font-semibold">{{ $vendor->nama_vendor }}</span>
                                        <small class="block text-gray-500">
                                            {{ $vendor->email ?? '-' }} | {{ $vendor->kategori ?? '-' }}
                                        </small>
                                    </span>
                                </label>
                            @empty
                                <p class="text-gray-500">
                                    Belum ada vendor aktif. Tambahkan vendor terlebih dahulu.
                                </p>
                            @endforelse
                        </div>

                        @error('vendor_ids')
                            <p class="text-red-600 text-sm mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex justify-end gap-2">
                        <a href="{{ route('supply-chain.material-requests.show', $materialRequest->id) }}"
                            class="px-4 py-2 bg-gray-500 text-white rounded-lg">
                            Kembali
                        </a>

                        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg">
                            Kirim Tender
                        </button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</x-app-layout>
