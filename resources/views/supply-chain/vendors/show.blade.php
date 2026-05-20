<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Detail Vendor
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 shadow rounded-lg">

                <div class="mb-4">
                    <p class="text-sm text-gray-500">Kode Vendor</p>
                    <p class="font-semibold">{{ $vendor->kode_vendor }}</p>
                </div>

                <div class="mb-4">
                    <p class="text-sm text-gray-500">Nama Vendor</p>
                    <p class="font-semibold">{{ $vendor->nama_vendor }}</p>
                </div>

                <div class="mb-4">
                    <p class="text-sm text-gray-500">Email</p>
                    <p>{{ $vendor->email ?? '-' }}</p>
                </div>

                <div class="mb-4">
                    <p class="text-sm text-gray-500">Telepon</p>
                    <p>{{ $vendor->telepon ?? '-' }}</p>
                </div>

                <div class="mb-4">
                    <p class="text-sm text-gray-500">PIC</p>
                    <p>{{ $vendor->pic ?? '-' }}</p>
                </div>

                <div class="mb-4">
                    <p class="text-sm text-gray-500">Kategori</p>
                    <p>{{ $vendor->kategori ?? '-' }}</p>
                </div>

                <div class="mb-4">
                    <p class="text-sm text-gray-500">Alamat</p>
                    <p>{{ $vendor->alamat ?? '-' }}</p>
                </div>

                <div class="mb-4">
                    <p class="text-sm text-gray-500">Status</p>
                    <p>{{ ucfirst($vendor->status) }}</p>
                </div>

                <div class="flex justify-end gap-2">
                    <a href="{{ route('supply-chain.vendors.index') }}"
                        class="px-4 py-2 bg-gray-500 text-white rounded-lg">
                        Kembali
                    </a>

                    <a href="{{ route('supply-chain.vendors.edit', $vendor) }}"
                        class="px-4 py-2 bg-yellow-500 text-white rounded-lg">
                        Edit
                    </a>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
