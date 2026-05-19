<x-app-layout>
    <x-slot name="header">
        <div class="bg-gradient-to-r from-blue-600 to-blue-800 shadow-lg rounded-2xl mx-4">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
                <h2 class="font-bold text-3xl text-white leading-tight">
                    <svg class="w-8 h-8 inline-block mr-3 text-blue-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    Dashboard Engineer
                </h2>
            </div>
        </div>
    </x-slot>

    <div class="py-12 bg-gradient-to-b from-blue-50 to-white min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <!-- Welcome Card -->
            <div class="bg-white shadow-lg rounded-xl p-8 mb-8 border-l-4 border-blue-600">
                <div class="flex items-center justify-between mb-6">
                    <div>
                        <h1 class="text-3xl font-bold text-blue-900 mb-2">
                            Selamat Datang, Engineer
                        </h1>
                        <p class="text-blue-600 font-medium">Kelola pengajuan material kapal Anda</p>
                    </div>
                    <svg class="w-16 h-16 text-blue-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 10l-2 1m0 0l-2-1m2 1v2.5M20 7l-2 1m2-1l-2-1m2 1v2.5M14 4l-2 1m2-1l-2-1m2 1v2.5"></path>
                    </svg>
                </div>

                <p class="text-gray-700 leading-relaxed mb-6">
                    Platform manajemen material kapal yang profesional. Buat pengajuan material baru, pantau status pengajuan, 
                    dan kelola seluruh proses pembelian material dengan mudah dan efisien.
                </p>

                <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                    <p class="text-sm text-blue-900">
                        <svg class="w-5 h-5 inline-block mr-2 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 5v8a2 2 0 01-2 2h-5l-5 4v-4H4a2 2 0 01-2-2V5a2 2 0 012-2h12a2 2 0 012 2zm-11-1a1 1 0 11-2 0 1 1 0 012 0zM8 9a1 1 0 100-2 1 1 0 000 2zm5-1a1 1 0 11-2 0 1 1 0 012 0z" clip-rule="evenodd"></path>
                        </svg>
                        Hubungi tim support jika ada pertanyaan atau memerlukan bantuan teknis
                    </p>
                </div>
            </div>

            <!-- Action Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                <!-- Create Request Card -->
                <div class="bg-gradient-to-br from-blue-500 to-blue-700 shadow-lg rounded-xl p-8 text-white transform hover:scale-105 transition-transform duration-300 cursor-pointer">
                    <div class="flex items-start justify-between mb-6">
                        <div>
                            <h3 class="text-2xl font-bold mb-2">Buat Pengajuan</h3>
                            <p class="text-blue-100 text-sm">Ajukan material baru untuk kebutuhan kapal</p>
                        </div>
                        <svg class="w-12 h-12 text-blue-200 opacity-80" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                    </div>
                    <p class="text-blue-100 text-sm mb-6">
                        Tambahkan material baru dengan detail lengkap termasuk spesifikasi dan kuantitas
                    </p>
                    <a href="{{ route('material-requests.create') }}"
                        class="inline-flex items-center bg-white text-blue-700 px-6 py-3 rounded-lg font-semibold hover:bg-blue-50 transition-colors duration-200">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 9l3 3m0 0l-3 3m3-3H8m13 0a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Buat Sekarang
                    </a>
                </div>

                <!-- View Requests Card -->
                <div class="bg-gradient-to-br from-blue-600 to-blue-800 shadow-lg rounded-xl p-8 text-white transform hover:scale-105 transition-transform duration-300 cursor-pointer">
                    <div class="flex items-start justify-between mb-6">
                        <div>
                            <h3 class="text-2xl font-bold mb-2">Lihat Pengajuan</h3>
                            <p class="text-blue-100 text-sm">Pantau semua pengajuan material Anda</p>
                        </div>
                        <svg class="w-12 h-12 text-blue-200 opacity-80" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                    </div>
                    <p class="text-blue-100 text-sm mb-6">
                        Lihat status semua pengajuan material, filter berdasarkan status, dan kelola dokumen
                    </p>
                    <a href="{{ route('material-requests.index') }}"
                        class="inline-flex items-center bg-white text-blue-700 px-6 py-3 rounded-lg font-semibold hover:bg-blue-50 transition-colors duration-200">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 9l3 3m0 0l-3 3m3-3H8m13 0a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Lihat Daftar
                    </a>
                </div>
            </div>

            <!-- Info Section -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Info Card 1 -->
                <div class="bg-white shadow-md rounded-lg p-6 border-t-4 border-blue-500">
                    <div class="flex items-center mb-4">
                        <div class="bg-blue-100 rounded-lg p-3 mr-4">
                            <svg class="w-6 h-6 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v2h8v-2zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-2a4 4 0 00-8 0v2a2 2 0 002 2h4a2 2 0 002-2z"></path>
                            </svg>
                        </div>
                        <h4 class="font-semibold text-gray-800">Akses Mudah</h4>
                    </div>
                    <p class="text-gray-600 text-sm">
                        Interface yang intuitif dan mudah digunakan untuk semua pengguna
                    </p>
                </div>

                <!-- Info Card 2 -->
                <div class="bg-white shadow-md rounded-lg p-6 border-t-4 border-blue-500">
                    <div class="flex items-center mb-4">
                        <div class="bg-blue-100 rounded-lg p-3 mr-4">
                            <svg class="w-6 h-6 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5 2a1 1 0 011-1h8a1 1 0 011 1v12a1 1 0 11-2 0V3H7v12a1 1 0 11-2 0V2z" clip-rule="evenodd"></path>
                                <path fill-rule="evenodd" d="M4 15a1 1 0 011 1v1h10v-1a1 1 0 112 0v1a2 2 0 01-2 2H5a2 2 0 01-2-2v-1a1 1 0 011-1z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                        <h4 class="font-semibold text-gray-800">Pantau Status</h4>
                    </div>
                    <p class="text-gray-600 text-sm">
                        Lacak status pengajuan material Anda secara real-time
                    </p>
                </div>

                <!-- Info Card 3 -->
                <div class="bg-white shadow-md rounded-lg p-6 border-t-4 border-blue-500">
                    <div class="flex items-center mb-4">
                        <div class="bg-blue-100 rounded-lg p-3 mr-4">
                            <svg class="w-6 h-6 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 3.062v6.757a1 1 0 01-.940 1.069 60.513 60.513 0 01-9.5 0 1 1 0 01-.94-1.069v-6.757a3.066 3.066 0 012.812-3.062zM9 13a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                        <h4 class="font-semibold text-gray-800">Aman & Terpercaya</h4>
                    </div>
                    <p class="text-gray-600 text-sm">
                        Sistem keamanan berlapis untuk melindungi data pengajuan Anda
                    </p>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
