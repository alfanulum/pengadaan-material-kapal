<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Dashboard Supply Chain
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white p-6 rounded-lg shadow mb-6">
                <h3 class="text-lg font-semibold mb-2">Dashboard Supply Chain</h3>
                <p class="text-gray-600">
                    Selamat datang di halaman Supply Chain. Silakan pilih menu fitur di bawah ini.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

                <a href="{{ route('supply-chain.vendors.index') }}"
                    class="block bg-white p-6 rounded-lg shadow hover:bg-gray-50">
                    <h3 class="text-lg font-semibold text-gray-800">
                        Kelola Vendor
                    </h3>
                    <p class="text-sm text-gray-500 mt-2">
                        Tambah, edit, detail, dan hapus data vendor.
                    </p>
                </a>

                <a href="{{ route('supply-chain.material-requests.index') }}"
                    class="block bg-white p-6 rounded-lg shadow hover:bg-gray-50">
                    <h3 class="text-lg font-semibold text-gray-800">
                        Permintaan dari Planner
                    </h3>
                    <p class="text-sm text-gray-500 mt-2">
                        Melihat pengajuan material yang sudah disetujui planner.
                    </p>
                </a>

                <a href="{{ route('supply-chain.tenders.index') }}"
                    class="block bg-white p-6 rounded-lg shadow hover:bg-gray-50">
                    <h3 class="text-lg font-semibold text-gray-800">
                        Tender
                    </h3>
                    <p class="text-sm text-gray-500 mt-2">
                        Membuat tender dan mengirim undangan ke vendor.
                    </p>
                </a>

                <a href="#" class="block bg-white p-6 rounded-lg shadow hover:bg-gray-50">
                    <h3 class="text-lg font-semibold text-gray-800">
                        Purchase Order
                    </h3>
                    <p class="text-sm text-gray-500 mt-2">
                        Membuat dan mengelola PO.
                    </p>
                </a>

                <a href="#" class="block bg-white p-6 rounded-lg shadow hover:bg-gray-50">
                    <h3 class="text-lg font-semibold text-gray-800">
                        Pengiriman Barang
                    </h3>
                    <p class="text-sm text-gray-500 mt-2">
                        Tracking status pengiriman material.
                    </p>
                </a>

                <a href="#" class="block bg-white p-6 rounded-lg shadow hover:bg-gray-50">
                    <h3 class="text-lg font-semibold text-gray-800">
                        Histori Procurement
                    </h3>
                    <p class="text-sm text-gray-500 mt-2">
                        Melihat riwayat aktivitas pengadaan.
                    </p>
                </a>

            </div>
        </div>
    </div>
</x-app-layout>
