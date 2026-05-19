<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Edit Pengajuan Material
        </h2>
    </x-slot>

    @php
        $item = $requestMaterial->items->first();
    @endphp

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg p-6">

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

                <form action="{{ route('material-requests.update', $requestMaterial->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-4">
                        <label class="block font-medium mb-1">Project</label>
                        <select name="project_id" class="w-full border-gray-300 rounded">
                            <option value="">-- Pilih Project --</option>
                            @foreach ($projects as $project)
                                <option value="{{ $project->id }}"
                                    {{ old('project_id', $requestMaterial->project_id) == $project->id ? 'selected' : '' }}>
                                    {{ $project->nama_project }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-4">
                        <label class="block font-medium mb-1">Nama Barang</label>
                        <input type="text" name="nama_barang" class="w-full border-gray-300 rounded"
                            value="{{ old('nama_barang', $item->nama_barang ?? '') }}">
                    </div>

                    <div class="mb-4">
                        <label class="block font-medium mb-1">Spesifikasi</label>
                        <textarea name="spesifikasi" class="w-full border-gray-300 rounded" rows="3">{{ old('spesifikasi', $item->spesifikasi ?? '') }}</textarea>
                    </div>

                    <div class="grid grid-cols-2 gap-4 mb-4">
                        <div>
                            <label class="block font-medium mb-1">Quantity</label>
                            <input type="number" name="qty" class="w-full border-gray-300 rounded"
                                value="{{ old('qty', $item->qty ?? '') }}">
                        </div>

                        <div>
                            <label class="block font-medium mb-1">Satuan</label>
                            <select name="satuan" class="w-full border-gray-300 rounded">
                                <option value="">-- Pilih Satuan --</option>
                                @foreach (['Lembar', 'Batang', 'Kg', 'Unit', 'Meter', 'Liter', 'Box'] as $satuan)
                                    <option value="{{ $satuan }}"
                                        {{ old('satuan', $item->satuan ?? '') == $satuan ? 'selected' : '' }}>
                                        {{ $satuan }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="block font-medium mb-1">Tanggal Dibutuhkan</label>
                        <input type="date" name="tanggal_dibutuhkan" class="w-full border-gray-300 rounded"
                            value="{{ old('tanggal_dibutuhkan', $requestMaterial->tanggal_dibutuhkan) }}">
                    </div>

                    <div class="mb-4">
                        <label class="block font-medium mb-1">Catatan</label>
                        <textarea name="catatan" class="w-full border-gray-300 rounded" rows="3">{{ old('catatan', $requestMaterial->catatan) }}</textarea>
                    </div>

                    <div class="flex justify-between">
                        <a href="{{ route('material-requests.index') }}"
                            class="px-4 py-2 bg-gray-500 text-white rounded">
                            Kembali
                        </a>

                        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded">
                            Update Pengajuan
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>
