<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Data Vendor
            </h2>

            <a href="{{ route('supply-chain.vendors.create') }}" class="px-4 py-2 bg-blue-600 text-white rounded-lg">
                + Tambah Vendor
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
                            <th class="px-4 py-3 text-left">Kode</th>
                            <th class="px-4 py-3 text-left">Nama Vendor</th>
                            <th class="px-4 py-3 text-left">Email</th>
                            <th class="px-4 py-3 text-left">Telepon</th>
                            <th class="px-4 py-3 text-left">PIC</th>
                            <th class="px-4 py-3 text-left">Status</th>
                            <th class="px-4 py-3 text-left">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($vendors as $vendor)
                            <tr class="border-t">
                                <td class="px-4 py-3">{{ $vendor->kode_vendor }}</td>
                                <td class="px-4 py-3">{{ $vendor->nama_vendor }}</td>
                                <td class="px-4 py-3">{{ $vendor->email ?? '-' }}</td>
                                <td class="px-4 py-3">{{ $vendor->telepon ?? '-' }}</td>
                                <td class="px-4 py-3">{{ $vendor->pic ?? '-' }}</td>
                                <td class="px-4 py-3">
                                    <span
                                        class="px-2 py-1 rounded text-xs {{ $vendor->status == 'aktif' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                        {{ ucfirst($vendor->status) }}
                                    </span>
                                </td>
                                <td class="px-4 py-3 flex gap-2">
                                    <a href="{{ route('supply-chain.vendors.show', $vendor) }}"
                                        class="text-blue-600">Detail</a>

                                    <a href="{{ route('supply-chain.vendors.edit', $vendor) }}"
                                        class="text-yellow-600">Edit</a>

                                    <form action="{{ route('supply-chain.vendors.destroy', $vendor) }}" method="POST"
                                        onsubmit="return confirm('Yakin ingin menghapus vendor ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600">
                                            Hapus
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-4 py-6 text-center text-gray-500">
                                    Belum ada data vendor.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-4">
                {{ $vendors->links() }}
            </div>

        </div>
    </div>
</x-app-layout>
