<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <h2 class="font-bold text-2xl text-slate-900 leading-tight">
                    Buat Pengajuan Material
                </h2>
                <p class="text-sm text-slate-500 mt-1">
                    Ajukan kebutuhan material kapal untuk proses verifikasi Planner.
                </p>
            </div>

            <a href="{{ route('engineer.dashboard') }}"
                class="inline-flex items-center gap-2 px-6 py-2.5 bg-white hover:bg-slate-50 text-slate-700 rounded-xl text-sm font-bold shadow-sm border border-slate-200 transition-all duration-300 hover:-translate-y-0.5">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                <span>Kembali ke Dashboard</span>
            </a>
        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 relative z-10">

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 relative z-10">

            {{-- Informasi --}}
            <div class="lg:col-span-1">
                <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6 sticky top-6">
                    <h3 class="text-lg font-bold text-slate-900 mb-2 flex items-center gap-2">
                        <span class="w-2 h-5 bg-blue-500 rounded-full inline-block"></span>
                        Panduan Pengisian
                    </h3>
                    <p class="text-sm text-slate-600 mb-6 leading-relaxed">
                        Harap lengkapi data material dengan teliti sesuai kebutuhan riil proyek kapal.
                    </p>

                    <div class="space-y-5">
                        <div class="flex gap-4 items-start group">
                            <span class="w-7 h-7 rounded-full bg-blue-50 text-blue-600 border border-blue-100 flex items-center justify-center text-xs font-bold shrink-0 shadow-sm group-hover:bg-blue-600 group-hover:text-white transition-colors">1</span>
                            <p class="text-sm text-slate-600 pt-1 leading-relaxed">Pilih <strong class="text-slate-900 font-semibold">Proyek Kapal</strong> dan tentukan <strong class="text-slate-900 font-semibold">Nama Material</strong> yang diajukan.</p>
                        </div>
                        <div class="flex gap-4 items-start group">
                            <span class="w-7 h-7 rounded-full bg-blue-50 text-blue-600 border border-blue-100 flex items-center justify-center text-xs font-bold shrink-0 shadow-sm group-hover:bg-blue-600 group-hover:text-white transition-colors">2</span>
                            <p class="text-sm text-slate-600 pt-1 leading-relaxed">Isi <strong class="text-slate-900 font-semibold">Spesifikasi Teknis</strong> secara detail agar Vendor dapat memberikan penawaran yang tepat.</p>
                        </div>
                        <div class="flex gap-4 items-start group">
                            <span class="w-7 h-7 rounded-full bg-blue-50 text-blue-600 border border-blue-100 flex items-center justify-center text-xs font-bold shrink-0 shadow-sm group-hover:bg-blue-600 group-hover:text-white transition-colors">3</span>
                            <p class="text-sm text-slate-600 pt-1 leading-relaxed">Tentukan <strong class="text-slate-900 font-semibold">Jumlah (Qty)</strong>, satuan, dan <strong class="text-slate-900 font-semibold">Tanggal Dibutuhkan</strong>.</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Form --}}
            <div class="lg:col-span-2">
                <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6 md:p-8">

                    @if ($errors->any())
                        <div class="mb-6 bg-rose-50 border border-rose-200 text-rose-700 p-5 rounded-xl">
                            <div class="flex items-center gap-3 mb-2">
                                <svg class="w-5 h-5 text-rose-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                                </svg>
                                <strong class="font-bold text-sm">Terjadi kesalahan pada input:</strong>
                            </div>
                            <ul class="list-disc ml-8 text-sm space-y-1">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('material-requests.store') }}" method="POST">
                        @csrf

                        <div class="space-y-6">
                            <div>
                                <label class="block text-sm font-semibold text-slate-800 mb-2">
                                    Proyek Kapal <span class="text-rose-500">*</span>
                                </label>
                                <select name="project_id"
                                    class="w-full rounded-xl py-3 px-4 shadow-sm border-slate-200 focus:border-blue-500 focus:ring-blue-500 transition-colors">
                                    <option value="">-- Pilih Proyek --</option>
                                    @foreach ($projects as $project)
                                        <option value="{{ $project->id }}"
                                            {{ old('project_id') == $project->id ? 'selected' : '' }}>
                                            {{ $project->nama_project }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-slate-800 mb-2">
                                    Nama Barang / Material <span class="text-rose-500">*</span>
                                </label>
                                <input type="text" name="nama_barang"
                                    class="w-full rounded-xl py-3 px-4 shadow-sm border-slate-200 focus:border-blue-500 focus:ring-blue-500 transition-colors"
                                    placeholder="Contoh: Plat Baja Marine Grade" value="{{ old('nama_barang') }}">
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-slate-800 mb-2">
                                    Spesifikasi <span class="text-rose-500">*</span>
                                </label>
                                <textarea name="spesifikasi" rows="3"
                                    class="w-full rounded-xl py-3 px-4 leading-relaxed shadow-sm border-slate-200 focus:border-blue-500 focus:ring-blue-500 transition-colors"
                                    placeholder="Contoh: Plat baja ASTM A36 / Grade A tebal 10mm bersertifikat">{{ old('spesifikasi') }}</textarea>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-sm font-semibold text-slate-800 mb-2">
                                        Quantity <span class="text-rose-500">*</span>
                                    </label>
                                    <input type="number" name="qty"
                                        class="w-full rounded-xl py-3 px-4 shadow-sm border-slate-200 focus:border-blue-500 focus:ring-blue-500 transition-colors"
                                        placeholder="0" value="{{ old('qty') }}">
                                </div>

                                <div>
                                    <label class="block text-sm font-semibold text-slate-800 mb-2">
                                        Satuan <span class="text-rose-500">*</span>
                                    </label>
                                    <select name="satuan"
                                        class="w-full rounded-xl py-3 px-4 shadow-sm border-slate-200 focus:border-blue-500 focus:ring-blue-500 transition-colors">
                                        <option value="">-- Pilih Satuan --</option>
                                        <option value="Lembar" {{ old('satuan') == 'Lembar' ? 'selected' : '' }}>Lembar</option>
                                        <option value="Batang" {{ old('satuan') == 'Batang' ? 'selected' : '' }}>Batang</option>
                                        <option value="Kg" {{ old('satuan') == 'Kg' ? 'selected' : '' }}>Kg</option>
                                        <option value="Unit" {{ old('satuan') == 'Unit' ? 'selected' : '' }}>Unit</option>
                                        <option value="Meter" {{ old('satuan') == 'Meter' ? 'selected' : '' }}>Meter</option>
                                        <option value="Liter" {{ old('satuan') == 'Liter' ? 'selected' : '' }}>Liter</option>
                                        <option value="Box" {{ old('satuan') == 'Box' ? 'selected' : '' }}>Box</option>
                                    </select>
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-slate-800 mb-2">
                                    Tanggal Dibutuhkan <span class="text-rose-500">*</span>
                                </label>
                                <input type="date" name="tanggal_dibutuhkan"
                                    class="w-full rounded-xl py-3 px-4 shadow-sm border-slate-200 focus:border-blue-500 focus:ring-blue-500 transition-colors"
                                    value="{{ old('tanggal_dibutuhkan') }}">
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-slate-800 mb-2">
                                    Catatan (Opsional)
                                </label>
                                <textarea name="catatan" rows="2"
                                    class="w-full rounded-xl py-3 px-4 leading-relaxed shadow-sm border-slate-200 focus:border-blue-500 focus:ring-blue-500 transition-colors"
                                    placeholder="Tambahan keterangan...">{{ old('catatan') }}</textarea>
                            </div>
                        </div>

                        <div class="mt-8 flex flex-col sm:flex-row sm:items-center sm:justify-end gap-4 pt-6 border-t border-slate-100">
                            <a href="{{ route('engineer.dashboard') }}"
                                class="inline-flex items-center justify-center px-6 py-3.5 bg-white border border-slate-200 text-slate-700 rounded-xl text-sm font-bold hover:bg-slate-50 transition-colors shadow-sm">
                                Batal
                            </a>

                            <button type="submit"
                                class="inline-flex items-center justify-center px-8 py-3.5 bg-gradient-to-r from-slate-900 to-blue-900 hover:from-slate-800 hover:to-blue-800 text-white rounded-xl text-sm font-bold shadow-md shadow-blue-500/20 transition-all duration-300 hover:-translate-y-0.5">
                                Simpan Pengajuan
                            </button>
                        </div>
                    </form>

                </div>
            </div>

        </div>
    </div>
</x-app-layout>
