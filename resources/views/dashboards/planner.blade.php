<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Dashboard Planner
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white shadow-sm rounded-lg p-6">
                <h1 class="text-2xl font-bold mb-4">
                    Selamat Datang Planner
                </h1>

                <p class="mb-6 text-gray-600">
                    Di sini planner dapat melihat dan memverifikasi pengajuan material dari engineer.
                </p>

                <a href="{{ route('planner.material-requests.index') }}"
                   class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">
                    Lihat Pengajuan Material
                </a>
            </div>

        </div>
    </div>
</x-app-layout>