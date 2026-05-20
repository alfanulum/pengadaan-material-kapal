<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Permintaan dari Planner
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white shadow rounded-lg overflow-hidden">
                <table class="w-full text-sm">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="px-4 py-3 text-left">Kode Pengajuan</th>
                            <th class="px-4 py-3 text-left">Project</th>
                            <th class="px-4 py-3 text-left">Engineer</th>
                            <th class="px-4 py-3 text-left">Status</th>
                            <th class="px-4 py-3 text-left">Tanggal</th>
                            <th class="px-4 py-3 text-left">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($materialRequests as $request)
                            <tr class="border-t">
                                <td class="px-4 py-3">
                                    REQ-{{ str_pad($request->id, 4, '0', STR_PAD_LEFT) }}
                                </td>

                                <td class="px-4 py-3">
                                    {{ $request->project->nama_project ?? '-' }}
                                </td>

                                <td class="px-4 py-3">
                                    {{ $request->user->name ?? '-' }}
                                </td>

                                <td class="px-4 py-3">
                                    <span class="px-2 py-1 bg-green-100 text-green-700 rounded text-xs">
                                        {{ str_replace('_', ' ', ucfirst($request->status)) }}
                                    </span>
                                </td>

                                <td class="px-4 py-3">
                                    {{ $request->created_at->format('d-m-Y') }}
                                </td>

                                <td class="px-4 py-3">
                                    <a href="{{ route('supply-chain.material-requests.show', $request->id) }}"
                                        class="text-blue-600">
                                        Detail
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-4 py-6 text-center text-gray-500">
                                    Belum ada permintaan yang disetujui planner.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-4">
                {{ $materialRequests->links() }}
            </div>

        </div>
    </div>
</x-app-layout>
