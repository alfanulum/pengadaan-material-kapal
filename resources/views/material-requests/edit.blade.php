<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3">
            <div>
                <h2 class="font-bold text-2xl text-slate-900 leading-tight">
                    Edit Pengajuan Material
                </h2>
                <p class="text-sm text-slate-500 mt-1">
                    Perbarui data kebutuhan material kapal sebelum diproses oleh Planner.
                </p>
            </div>

            <a href="{{ route('material-requests.index') }}"
                class="inline-flex items-center gap-2 px-5 py-2.5 bg-white border border-slate-300 hover:bg-slate-50 text-slate-700 rounded-xl text-sm font-semibold shadow-sm transition">
                <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                <span>Daftar Pengajuan</span>
            </a>
        </div>
    </x-slot>

    @php
        $item = $requestMaterial->items->first();
    @endphp

    <div class="py-6">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6 md:p-8">

                @if ($errors->any())
                    <div class="mb-6 bg-red-50 border border-red-200 text-red-700 p-4 rounded-xl">
                        <strong class="font-bold text-sm">Terjadi kesalahan pada input:</strong>
                        <ul class="list-disc ml-5 mt-2 text-xs space-y-1">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('material-requests.update', $requestMaterial->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="space-y-5">
                        <div>
                            <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">
                                Proyek Kapal <span class="text-red-500">*</span>
                            </label>
                            <select name="project_id" class="w-full rounded-xl border-slate-300 text-sm focus:border-blue-900 focus:ring-blue-900">
                                <option value="">-- Pilih Proyek Kapal --</option>
                                @foreach ($projects as $project)
                                    <option value="{{ $project->id }}"
                                        {{ old('project_id', $requestMaterial->project_id) == $project->id ? 'selected' : '' }}>
                                        {{ $project->nama_project }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">
                                Nama Barang / Material <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="nama_barang" class="w-full rounded-xl border-slate-300 text-sm focus:border-blue-900 focus:ring-blue-900"
                                value="{{ old('nama_barang', $item->nama_barang ?? '') }}" placeholder="Contoh: Plat Baja Marine Grade">
                        </div>

                        <div>
                            <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">
                                Spesifikasi Teknis <span class="text-red-500">*</span>
                            </label>
                            <textarea name="spesifikasi" class="w-full rounded-xl border-slate-300 text-sm focus:border-blue-900 focus:ring-blue-900 leading-relaxed" rows="4">{{ old('spesifikasi', $item->spesifikasi ?? '') }}</textarea>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <div>
                                <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">
                                    Jumlah Kebutuhan (Qty) <span class="text-red-500">*</span>
                                </label>
                                <input type="number" name="qty" class="w-full rounded-xl border-slate-300 text-sm focus:border-blue-900 focus:ring-blue-900"
                                    value="{{ old('qty', $item->qty ?? '') }}">
                            </div>

                            <div>
                                <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">
                                    Satuan Ukuran <span class="text-red-500">*</span>
                                </label>
                                <select name="satuan" class="w-full rounded-xl border-slate-300 text-sm focus:border-blue-900 focus:ring-blue-900">
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

                        <div>
                            <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">
                                Tanggal Dibutuhkan di Galangan <span class="text-red-500">*</span>
                            </label>
                            <input type="date" name="tanggal_dibutuhkan" class="w-full rounded-xl border-slate-300 text-sm focus:border-blue-900 focus:ring-blue-900"
                                value="{{ old('tanggal_dibutuhkan', $requestMaterial->tanggal_dibutuhkan) }}">
                        </div>

                        <div>
                            <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">
                                Catatan Tambahan (Opsional)
                            </label>
                            <textarea name="catatan" class="w-full rounded-xl border-slate-300 text-sm focus:border-blue-900 focus:ring-blue-900" rows="3">{{ old('catatan', $requestMaterial->catatan) }}</textarea>
                        </div>
                    </div>

                    <div class="mt-8 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 pt-6 border-t border-slate-100">
                        <a href="{{ route('material-requests.index') }}"
                            class="inline-flex items-center justify-center px-5 py-3 bg-white border border-slate-300 text-slate-700 rounded-xl text-sm font-semibold hover:bg-slate-50 transition shadow-sm">
                            Batal
                        </a>

                        <button type="submit" class="inline-flex items-center justify-center gap-2 px-6 py-3 bg-blue-900 hover:bg-blue-950 text-white rounded-xl text-sm font-bold shadow-sm transition hover:shadow">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            <span>Simpan Perubahan Pengajuan</span>
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>
