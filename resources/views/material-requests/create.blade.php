<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3">
            <div>
                <h2 class="font-bold text-2xl text-slate-900 leading-tight">
                    Buat Pengajuan Material
                </h2>
                <p class="text-sm text-slate-500 mt-1">
                    Input kebutuhan material kapal untuk diajukan ke Planner.
                </p>
            </div>

            <a href="{{ route('engineer.dashboard') }}"
                class="inline-flex items-center justify-center px-4 py-2 bg-slate-900 text-white rounded-xl text-sm font-semibold hover:bg-slate-800 transition">
                Kembali ke Dashboard
            </a>
        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        {{-- Hero --}}
        <div
            class="bg-gradient-to-r from-slate-950 via-blue-950 to-blue-800 rounded-3xl p-8 md:p-10 shadow-xl text-white mb-8 overflow-hidden relative">
            <div class="absolute -top-24 -right-24 w-80 h-80 bg-cyan-400/20 rounded-full blur-3xl"></div>
            <div class="absolute -bottom-24 -left-24 w-80 h-80 bg-blue-400/20 rounded-full blur-3xl"></div>

            <div class="relative z-10 max-w-4xl">
                <p
                    class="inline-flex px-4 py-2 rounded-full bg-white/10 border border-white/10 text-sm text-blue-100 mb-5">
                    Material Request Form
                </p>

                <h3 class="text-3xl md:text-4xl font-bold leading-tight">
                    Form Pengajuan Kebutuhan Material
                </h3>

                <p class="mt-4 text-blue-100 max-w-3xl text-base leading-relaxed">
                    Lengkapi data project, nama barang, spesifikasi, jumlah, satuan,
                    tanggal kebutuhan, dan catatan agar Planner dapat melakukan verifikasi
                    pengajuan dengan jelas.
                </p>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

            {{-- Informasi --}}
            <div class="lg:col-span-1">
                <div class="bg-white rounded-3xl shadow-sm border border-slate-200 p-6 sticky top-6">
                    <div
                        class="w-12 h-12 rounded-2xl bg-blue-100 text-blue-900 flex items-center justify-center font-bold mb-4">
                        MR
                    </div>

                    <h3 class="text-lg font-bold text-slate-900">
                        Catatan Pengajuan
                    </h3>

                    <p class="text-sm text-slate-500 mt-2 leading-relaxed">
                        Pastikan data material yang diajukan sudah sesuai dengan kebutuhan pekerjaan kapal.
                        Data yang jelas akan mempermudah Planner melakukan approval.
                    </p>

                    <div class="mt-6 space-y-3 text-sm text-slate-600">
                        <div class="flex gap-3">
                            <span
                                class="w-6 h-6 rounded-full bg-blue-100 text-blue-900 flex items-center justify-center text-xs font-bold">1</span>
                            <p>Pilih project yang sesuai.</p>
                        </div>

                        <div class="flex gap-3">
                            <span
                                class="w-6 h-6 rounded-full bg-blue-100 text-blue-900 flex items-center justify-center text-xs font-bold">2</span>
                            <p>Isi spesifikasi material dengan lengkap.</p>
                        </div>

                        <div class="flex gap-3">
                            <span
                                class="w-6 h-6 rounded-full bg-blue-100 text-blue-900 flex items-center justify-center text-xs font-bold">3</span>
                            <p>Tentukan quantity dan tanggal dibutuhkan.</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Form --}}
            <div class="lg:col-span-2">
                <div class="bg-white rounded-3xl shadow-sm border border-slate-200 p-6 md:p-8">

                    @if ($errors->any())
                        <div class="mb-6 bg-red-50 border border-red-200 text-red-700 p-4 rounded-2xl">
                            <strong>Terjadi kesalahan:</strong>
                            <ul class="list-disc ml-5 mt-2 text-sm">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('material-requests.store') }}" method="POST">
                        @csrf

                        <div class="space-y-5">
                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-2">
                                    Project
                                </label>
                                <select name="project_id"
                                    class="w-full rounded-xl border-slate-300 focus:border-blue-800 focus:ring-blue-800">
                                    <option value="">-- Pilih Project --</option>
                                    @foreach ($projects as $project)
                                        <option value="{{ $project->id }}"
                                            {{ old('project_id') == $project->id ? 'selected' : '' }}>
                                            {{ $project->nama_project }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-2">
                                    Nama Barang
                                </label>
                                <input type="text" name="nama_barang"
                                    class="w-full rounded-xl border-slate-300 focus:border-blue-800 focus:ring-blue-800"
                                    placeholder="Contoh: Plat Baja" value="{{ old('nama_barang') }}">
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-2">
                                    Spesifikasi
                                </label>
                                <textarea name="spesifikasi" rows="4"
                                    class="w-full rounded-xl border-slate-300 focus:border-blue-800 focus:ring-blue-800"
                                    placeholder="Contoh: Plat baja ASTM A36 tebal 10mm ukuran 1200 x 2400 mm">{{ old('spesifikasi') }}</textarea>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                                <div>
                                    <label class="block text-sm font-semibold text-slate-700 mb-2">
                                        Quantity
                                    </label>
                                    <input type="number" name="qty"
                                        class="w-full rounded-xl border-slate-300 focus:border-blue-800 focus:ring-blue-800"
                                        placeholder="Contoh: 20" value="{{ old('qty') }}">
                                </div>

                                <div>
                                    <label class="block text-sm font-semibold text-slate-700 mb-2">
                                        Satuan
                                    </label>
                                    <select name="satuan"
                                        class="w-full rounded-xl border-slate-300 focus:border-blue-800 focus:ring-blue-800">
                                        <option value="">-- Pilih Satuan --</option>
                                        <option value="Lembar" {{ old('satuan') == 'Lembar' ? 'selected' : '' }}>Lembar
                                        </option>
                                        <option value="Batang" {{ old('satuan') == 'Batang' ? 'selected' : '' }}>Batang
                                        </option>
                                        <option value="Kg" {{ old('satuan') == 'Kg' ? 'selected' : '' }}>Kg
                                        </option>
                                        <option value="Unit" {{ old('satuan') == 'Unit' ? 'selected' : '' }}>Unit
                                        </option>
                                        <option value="Meter" {{ old('satuan') == 'Meter' ? 'selected' : '' }}>Meter
                                        </option>
                                        <option value="Liter" {{ old('satuan') == 'Liter' ? 'selected' : '' }}>Liter
                                        </option>
                                        <option value="Box" {{ old('satuan') == 'Box' ? 'selected' : '' }}>Box
                                        </option>
                                    </select>
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-2">
                                    Tanggal Dibutuhkan
                                </label>
                                <input type="date" name="tanggal_dibutuhkan"
                                    class="w-full rounded-xl border-slate-300 focus:border-blue-800 focus:ring-blue-800"
                                    value="{{ old('tanggal_dibutuhkan') }}">
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-2">
                                    Catatan
                                </label>
                                <textarea name="catatan" rows="4"
                                    class="w-full rounded-xl border-slate-300 focus:border-blue-800 focus:ring-blue-800"
                                    placeholder="Contoh: Material dibutuhkan untuk pekerjaan lambung kapal bagian kiri">{{ old('catatan') }}</textarea>
                            </div>
                        </div>

                        <div class="mt-8 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                            <a href="{{ route('engineer.dashboard') }}"
                                class="inline-flex items-center justify-center px-5 py-3 bg-slate-100 text-slate-700 rounded-xl font-semibold hover:bg-slate-200 transition">
                                Kembali ke Dashboard
                            </a>

                            <button type="submit"
                                class="inline-flex items-center justify-center px-6 py-3 bg-blue-900 text-white rounded-xl font-semibold shadow-lg hover:bg-blue-950 transition">
                                Simpan Pengajuan
                            </button>
                        </div>
                    </form>

                </div>
            </div>

        </div>
    </div>
</x-app-layout>
