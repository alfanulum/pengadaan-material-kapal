<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Detail Pengajuan Material
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white shadow-sm sm:rounded-lg p-6">

                @if (session('success'))
                    <div class="mb-4 bg-green-100 text-green-700 p-4 rounded">
                        {{ session('success') }}
                    </div>
                @endif

                @if ($errors->any())
                    <div class="mb-4 bg-red-100 text-red-700 p-4 rounded">
                        <strong>Terjadi kesalahan:</strong>
                        <ul class="list-disc ml-5 mt-2">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <h3 class="text-lg font-bold mb-4">Informasi Pengajuan</h3>

                <table class="w-full border mb-6">
                    <tr>
                        <td class="border p-2 font-semibold w-1/3">Kode Pengajuan</td>
                        <td class="border p-2">{{ $requestMaterial->kode_pengajuan }}</td>
                    </tr>

                    <tr>
                        <td class="border p-2 font-semibold">Engineer</td>
                        <td class="border p-2">{{ $requestMaterial->user->name }}</td>
                    </tr>

                    <tr>
                        <td class="border p-2 font-semibold">Project</td>
                        <td class="border p-2">{{ $requestMaterial->project->nama_project }}</td>
                    </tr>

                    <tr>
                        <td class="border p-2 font-semibold">Tanggal Dibutuhkan</td>
                        <td class="border p-2">
                            {{ \Carbon\Carbon::parse($requestMaterial->tanggal_dibutuhkan)->format('d-m-Y') }}
                        </td>
                    </tr>

                    <tr>
                        <td class="border p-2 font-semibold">Total RAB</td>
                        <td class="border p-2">
                            @if ($requestMaterial->total_rab)
                                Rp {{ number_format($requestMaterial->total_rab, 0, ',', '.') }}
                            @else
                                -
                            @endif
                        </td>
                    </tr>

                    <tr>
                        <td class="border p-2 font-semibold">Status</td>
                        <td class="border p-2">
                            @if ($requestMaterial->status == 'diajukan')
                                <span class="px-2 py-1 bg-yellow-100 text-yellow-700 rounded">
                                    Diajukan
                                </span>
                            @elseif ($requestMaterial->status == 'disetujui')
                                <span class="px-2 py-1 bg-green-100 text-green-700 rounded">
                                    Disetujui
                                </span>
                            @elseif ($requestMaterial->status == 'ditolak')
                                <span class="px-2 py-1 bg-red-100 text-red-700 rounded">
                                    Ditolak
                                </span>
                            @else
                                <span class="px-2 py-1 bg-gray-100 text-gray-700 rounded">
                                    {{ $requestMaterial->status }}
                                </span>
                            @endif
                        </td>
                    </tr>

                    <tr>
                        <td class="border p-2 font-semibold">Catatan Engineer</td>
                        <td class="border p-2">{{ $requestMaterial->catatan ?? '-' }}</td>
                    </tr>

                    <tr>
                        <td class="border p-2 font-semibold">Catatan Planner</td>
                        <td class="border p-2">{{ $requestMaterial->catatan_planner ?? '-' }}</td>
                    </tr>
                </table>

                <h3 class="text-lg font-bold mb-4">Data Material</h3>

                <table class="w-full border mb-6">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="border p-2 text-left">Nama Barang</th>
                            <th class="border p-2 text-left">Spesifikasi</th>
                            <th class="border p-2 text-left">Qty</th>
                            <th class="border p-2 text-left">Satuan</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($requestMaterial->items as $item)
                            <tr>
                                <td class="border p-2">{{ $item->nama_barang }}</td>
                                <td class="border p-2">{{ $item->spesifikasi ?? '-' }}</td>
                                <td class="border p-2">{{ $item->qty }}</td>
                                <td class="border p-2">{{ $item->satuan }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="border-t pt-6 mb-6">
                    <h3 class="text-lg font-bold mb-4">Dokumen Planner</h3>

                    <form action="{{ route('planner.material-requests.documents', $requestMaterial->id) }}"
                        method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="mb-4">
                            <label class="block font-medium mb-1">Total RAB</label>
                            <input type="number" name="total_rab" class="w-full border-gray-300 rounded"
                                placeholder="Contoh: 25000000"
                                value="{{ old('total_rab', $requestMaterial->total_rab) }}">
                        </div>

                        <div class="mb-4">
                            <label class="block font-medium mb-1">Upload Dokumen RAB</label>
                            <input type="file" name="file_rab" class="w-full border-gray-300 rounded">

                            @if ($requestMaterial->file_rab)
                                <p class="mt-2">
                                    <a href="{{ asset('storage/' . $requestMaterial->file_rab) }}" target="_blank"
                                        class="text-blue-600 underline">
                                        Lihat Dokumen RAB
                                    </a>
                                </p>
                            @endif
                        </div>

                        <div class="mb-4">
                            <label class="block font-medium mb-1">Upload Dokumen Perizinan</label>
                            <input type="file" name="file_perizinan" class="w-full border-gray-300 rounded">

                            @if ($requestMaterial->file_perizinan)
                                <p class="mt-2">
                                    <a href="{{ asset('storage/' . $requestMaterial->file_perizinan) }}"
                                        target="_blank" class="text-blue-600 underline">
                                        Lihat Dokumen Perizinan
                                    </a>
                                </p>
                            @endif
                        </div>

                        <div class="mb-4">
                            <label class="block font-medium mb-1">Catatan Planner</label>
                            <textarea name="catatan_planner" class="w-full border-gray-300 rounded" rows="3"
                                placeholder="Contoh: RAB sudah dibuat berdasarkan kebutuhan material">{{ old('catatan_planner', $requestMaterial->catatan_planner) }}</textarea>
                        </div>

                        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">
                            Simpan Dokumen Planner
                        </button>
                    </form>
                </div>

                @if ($requestMaterial->status == 'diajukan')
                    <div class="border-t pt-6 mb-6">
                        <h3 class="text-lg font-bold mb-4">Verifikasi Planner</h3>

                        <div class="flex gap-3 mb-6">
                            <form action="{{ route('planner.material-requests.approve', $requestMaterial->id) }}"
                                method="POST">
                                @csrf

                                <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded">
                                    Setujui Pengajuan
                                </button>
                            </form>
                        </div>

                        <div class="border-t pt-6">
                            <h3 class="text-lg font-bold mb-3">Tolak Pengajuan</h3>

                            <form action="{{ route('planner.material-requests.reject', $requestMaterial->id) }}"
                                method="POST">
                                @csrf

                                <div class="mb-4">
                                    <label class="block font-medium mb-1">Alasan Penolakan</label>
                                    <textarea name="catatan" class="w-full border-gray-300 rounded" rows="3" placeholder="Masukkan alasan penolakan"></textarea>
                                </div>

                                <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded">
                                    Tolak Pengajuan
                                </button>
                            </form>
                        </div>
                    </div>
                @else
                    <div class="bg-gray-100 text-gray-700 p-4 rounded mb-6">
                        Pengajuan ini sudah diproses dengan status:
                        <strong>{{ $requestMaterial->status }}</strong>
                    </div>
                @endif

                <div class="mt-6">
                    <a href="{{ route('planner.material-requests.index') }}"
                        class="bg-gray-600 text-white px-4 py-2 rounded">
                        Kembali
                    </a>
                </div>

            </div>

        </div>
    </div>
</x-app-layout>
