<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3">
            <div>
                <div class="flex items-center gap-2 text-sm text-slate-500 mb-1">
                    <a href="{{ route('gudang.dashboard') }}" class="hover:text-blue-700 transition">Dashboard</a>
                    <span>/</span>
                    <span class="text-slate-900 font-semibold">Periksa Barang</span>
                </div>
                <h2 class="font-bold text-2xl text-slate-900 leading-tight">
                    Detail Penerimaan Barang
                </h2>
                <p class="text-sm text-slate-500 mt-1">
                    PO <span class="font-bold text-blue-700">{{ $purchaseOrder->kode_po }}</span> —
                    {{ $purchaseOrder->vendor->nama_vendor ?? '-' }}
                </p>
            </div>
            <a href="{{ route('gudang.dashboard') }}"
                class="inline-flex items-center gap-2 px-5 py-2.5 bg-slate-100 text-slate-700 rounded-xl font-semibold border border-slate-200 hover:bg-slate-200 transition text-sm">
                ← Kembali
            </a>
        </div>
    </x-slot>

    <div class="py-6" x-data="goodsReceiptForm()">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

            @if ($purchaseOrder->goodsReceipt)
                <div class="p-4 bg-amber-50 border border-amber-200 text-amber-800 rounded-2xl flex items-start gap-3">
                    <svg class="w-5 h-5 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                    <div>
                        <p class="font-semibold">Laporan penerimaan sudah ada</p>
                        <p class="text-sm mt-0.5">PO ini sudah memiliki laporan penerimaan. Mengisi form ini akan <strong>mengganti</strong> laporan sebelumnya.</p>
                    </div>
                </div>
            @endif

            @if ($errors->any())
                <div class="p-4 bg-red-50 border border-red-200 text-red-700 rounded-2xl">
                    <ul class="list-disc list-inside space-y-1 text-sm">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- ============================================================
                 INFO PO
                 ============================================================ --}}
            <div class="bg-gradient-to-r from-slate-950 via-blue-950 to-blue-800 rounded-3xl p-6 md:p-8 text-white shadow-xl relative overflow-hidden">
                <div class="absolute -top-12 -right-12 w-48 h-48 bg-cyan-400/20 rounded-full blur-3xl"></div>
                <div class="relative z-10">
                    <div class="flex items-start justify-between mb-5">
                        <div>
                            <p class="inline-flex px-3 py-1 rounded-full bg-white/10 border border-white/10 text-xs text-blue-100 mb-2">
                                Purchase Order
                            </p>
                            <h3 class="text-2xl font-black">{{ $purchaseOrder->kode_po }}</h3>
                        </div>
                        <div class="text-right">
                            <p class="text-xs text-blue-200">Total Nilai PO</p>
                            <p class="text-xl font-black mt-1">Rp {{ number_format($purchaseOrder->total_harga, 0, ',', '.') }}</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                        <div class="bg-white/10 rounded-xl p-4">
                            <p class="text-xs text-blue-200">Vendor</p>
                            <p class="text-sm font-bold mt-1">{{ $purchaseOrder->vendor->nama_vendor ?? '-' }}</p>
                        </div>
                        <div class="bg-white/10 rounded-xl p-4">
                            <p class="text-xs text-blue-200">Tender</p>
                            <p class="text-sm font-bold mt-1">{{ $purchaseOrder->tender->kode_tender ?? '-' }}</p>
                        </div>
                        <div class="bg-white/10 rounded-xl p-4">
                            <p class="text-xs text-blue-200">Tanggal PO</p>
                            <p class="text-sm font-bold mt-1">
                                {{ $purchaseOrder->tanggal_po ? \Carbon\Carbon::parse($purchaseOrder->tanggal_po)->format('d M Y') : '-' }}
                            </p>
                        </div>
                        <div class="bg-white/10 rounded-xl p-4">
                            <p class="text-xs text-blue-200">Deadline Pengiriman</p>
                            <p class="text-sm font-bold mt-1">
                                {{ $purchaseOrder->deadline_pengiriman ? \Carbon\Carbon::parse($purchaseOrder->deadline_pengiriman)->format('d M Y') : '-' }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- ============================================================
                 DETAIL MATERIAL
                 ============================================================ --}}
            <div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden">
                <div class="px-6 py-4 border-b border-slate-200">
                    <h3 class="text-base font-bold text-slate-900">📦 Spesifikasi Material</h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-slate-50 border-b border-slate-100">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Nama Barang</th>
                                <th class="px-6 py-3 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Spesifikasi</th>
                                <th class="px-6 py-3 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Qty Pesanan</th>
                                <th class="px-6 py-3 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Satuan</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @forelse ($purchaseOrder->items as $item)
                                <tr>
                                    <td class="px-6 py-4 text-sm font-semibold text-slate-900">{{ $item->nama_barang }}</td>
                                    <td class="px-6 py-4 text-sm text-slate-600">{{ $item->spesifikasi ?? '-' }}</td>
                                    <td class="px-6 py-4 text-sm font-bold text-blue-700">{{ $item->qty }}</td>
                                    <td class="px-6 py-4 text-sm text-slate-600">{{ $item->satuan ?? '-' }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-8 text-center text-sm text-slate-400">Tidak ada item material</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- ============================================================
                 FORM PENERIMAAN BARANG
                 ============================================================ --}}
            <form action="{{ route('gudang.goods-receipts.store', $purchaseOrder->id) }}"
                  method="POST"
                  enctype="multipart/form-data"
                  id="form-penerimaan">
                @csrf

                {{-- --- Informasi Penerimaan --- --}}
                <div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden mb-6">
                    <div class="px-6 py-4 border-b border-slate-200">
                        <h3 class="text-base font-bold text-slate-900">📋 Informasi Penerimaan</h3>
                        <p class="text-sm text-slate-500 mt-0.5">Isi data aktual barang yang diterima dari vendor</p>
                    </div>

                    <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="tanggal_diterima" class="block text-sm font-semibold text-slate-700 mb-1.5">
                                Tanggal Barang Diterima <span class="text-red-500">*</span>
                            </label>
                            <input type="date" id="tanggal_diterima" name="tanggal_diterima"
                                value="{{ old('tanggal_diterima', date('Y-m-d')) }}"
                                class="w-full px-4 py-3 rounded-xl border border-slate-200 text-slate-900 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition"
                                required>
                        </div>

                        <div>
                            <label for="jumlah_diterima" class="block text-sm font-semibold text-slate-700 mb-1.5">
                                Jumlah Barang Aktual Diterima <span class="text-red-500">*</span>
                            </label>
                            <input type="number" id="jumlah_diterima" name="jumlah_diterima"
                                value="{{ old('jumlah_diterima', $purchaseOrder->items->sum('qty')) }}"
                                min="0"
                                class="w-full px-4 py-3 rounded-xl border border-slate-200 text-slate-900 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition"
                                required>
                        </div>
                    </div>
                </div>

                {{-- --- Kondisi Barang --- --}}
                <div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden mb-6">
                    <div class="px-6 py-4 border-b border-slate-200">
                        <h3 class="text-base font-bold text-slate-900">🔍 Pemeriksaan Kondisi Barang</h3>
                        <p class="text-sm text-slate-500 mt-0.5">Pilih kondisi barang berdasarkan hasil pemeriksaan fisik</p>
                    </div>

                    <div class="p-6 space-y-3">
                        <label class="flex items-start gap-4 p-4 rounded-2xl border-2 cursor-pointer transition"
                            :class="kondisi === 'sesuai' ? 'border-emerald-500 bg-emerald-50' : 'border-slate-200 hover:border-slate-300'">
                            <input type="radio" name="kondisi_barang" value="sesuai" x-model="kondisi"
                                class="mt-1 accent-emerald-600">
                            <div>
                                <p class="font-semibold text-slate-900">✅ Barang diterima sesuai pesanan</p>
                                <p class="text-xs text-slate-500 mt-0.5">Jumlah, spesifikasi, dan kondisi sesuai dengan Purchase Order</p>
                            </div>
                        </label>

                        <label class="flex items-start gap-4 p-4 rounded-2xl border-2 cursor-pointer transition"
                            :class="kondisi === 'diterima_dengan_catatan' ? 'border-yellow-500 bg-yellow-50' : 'border-slate-200 hover:border-slate-300'">
                            <input type="radio" name="kondisi_barang" value="diterima_dengan_catatan" x-model="kondisi"
                                class="mt-1 accent-yellow-600">
                            <div>
                                <p class="font-semibold text-slate-900">📝 Barang diterima dengan catatan</p>
                                <p class="text-xs text-slate-500 mt-0.5">Ada perbedaan minor yang masih dapat diterima dengan dokumentasi</p>
                            </div>
                        </label>

                        <label class="flex items-start gap-4 p-4 rounded-2xl border-2 cursor-pointer transition"
                            :class="kondisi === 'kerusakan' ? 'border-red-500 bg-red-50' : 'border-slate-200 hover:border-slate-300'">
                            <input type="radio" name="kondisi_barang" value="kerusakan" x-model="kondisi"
                                class="mt-1 accent-red-600">
                            <div>
                                <p class="font-semibold text-slate-900">⚠️ Barang mengalami kerusakan / cacat</p>
                                <p class="text-xs text-slate-500 mt-0.5">Barang rusak secara fisik, cacat produksi, atau tidak dapat digunakan</p>
                            </div>
                        </label>

                        <label class="flex items-start gap-4 p-4 rounded-2xl border-2 cursor-pointer transition"
                            :class="kondisi === 'tidak_sesuai_spesifikasi' ? 'border-orange-500 bg-orange-50' : 'border-slate-200 hover:border-slate-300'">
                            <input type="radio" name="kondisi_barang" value="tidak_sesuai_spesifikasi" x-model="kondisi"
                                class="mt-1 accent-orange-600">
                            <div>
                                <p class="font-semibold text-slate-900">❌ Barang tidak sesuai spesifikasi</p>
                                <p class="text-xs text-slate-500 mt-0.5">Spesifikasi teknis tidak sesuai, dimensi berbeda, atau material berbeda</p>
                            </div>
                        </label>
                    </div>

                    <div class="px-6 pb-6">
                        <label for="catatan_gudang" class="block text-sm font-semibold text-slate-700 mb-1.5">
                            Catatan Pemeriksaan Gudang
                        </label>
                        <textarea id="catatan_gudang" name="catatan_gudang" rows="3"
                            placeholder="Tuliskan catatan hasil pemeriksaan gudang..."
                            class="w-full px-4 py-3 rounded-xl border border-slate-200 text-slate-900 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition resize-none">{{ old('catatan_gudang') }}</textarea>
                    </div>
                </div>

                {{-- --- Form Tambahan jika Bermasalah --- --}}
                <div x-show="kondisi === 'kerusakan' || kondisi === 'tidak_sesuai_spesifikasi'"
                    x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0 -translate-y-2"
                    x-transition:enter-end="opacity-100 translate-y-0"
                    x-transition:leave="transition ease-in duration-200"
                    x-transition:leave-start="opacity-100 translate-y-0"
                    x-transition:leave-end="opacity-0 -translate-y-2"
                    class="bg-red-50 border-2 border-red-200 rounded-3xl overflow-hidden mb-6">

                    <div class="px-6 py-4 border-b border-red-200 flex items-center gap-3">
                        <div class="w-8 h-8 rounded-lg bg-red-500 flex items-center justify-center">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                        </div>
                        <div>
                            <h3 class="text-base font-bold text-red-900">⚠️ Detail Permasalahan Barang</h3>
                            <p class="text-xs text-red-600 mt-0.5">Dokumen masalah secara rinci untuk proses klaim ke vendor</p>
                        </div>
                    </div>

                    <div class="p-6 space-y-5">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <div class="md:col-span-2">
                                <label for="detail_permasalahan" class="block text-sm font-semibold text-red-800 mb-1.5">
                                    Detail Permasalahan <span class="text-red-500">*</span>
                                </label>
                                <textarea id="detail_permasalahan" name="detail_permasalahan" rows="4"
                                    placeholder="Jelaskan secara detail permasalahan yang ditemukan pada barang..."
                                    class="w-full px-4 py-3 rounded-xl border border-red-200 bg-white text-slate-900 text-sm focus:ring-2 focus:ring-red-400 focus:border-red-400 transition resize-none">{{ old('detail_permasalahan') }}</textarea>
                            </div>

                            <div>
                                <label for="jumlah_rusak" class="block text-sm font-semibold text-red-800 mb-1.5">
                                    Jumlah Barang Rusak / Tidak Sesuai
                                </label>
                                <input type="number" id="jumlah_rusak" name="jumlah_rusak"
                                    value="{{ old('jumlah_rusak', 0) }}" min="0"
                                    class="w-full px-4 py-3 rounded-xl border border-red-200 bg-white text-slate-900 text-sm focus:ring-2 focus:ring-red-400 focus:border-red-400 transition">
                            </div>
                        </div>

                        {{-- Upload Foto Dokumentasi --}}
                        <div>
                            <label class="block text-sm font-semibold text-red-800 mb-2">
                                📷 Upload Foto Dokumentasi
                            </label>
                            <p class="text-xs text-red-600 mb-4">Upload foto bukti: kondisi material, label barang, jumlah barang, dan kerusakan (maks. 5 MB per foto)</p>

                            <div id="foto-container" class="space-y-3">
                                {{-- Item foto pertama --}}
                                <div class="foto-item bg-white rounded-2xl border border-red-200 p-4">
                                    <div class="grid grid-cols-1 md:grid-cols-3 gap-3 items-center">
                                        <div class="md:col-span-2">
                                            <label class="block text-xs font-semibold text-slate-600 mb-1">Pilih Foto</label>
                                            <input type="file" name="foto[]" accept="image/*"
                                                class="w-full text-sm text-slate-600 file:mr-3 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-red-50 file:text-red-700 hover:file:bg-red-100 transition"
                                                onchange="previewImage(this)">
                                            <div class="mt-2 hidden preview-container">
                                                <img src="" alt="Preview" class="h-20 rounded-lg object-cover border border-slate-200 preview-img">
                                            </div>
                                        </div>
                                        <div>
                                            <label class="block text-xs font-semibold text-slate-600 mb-1">Keterangan Foto</label>
                                            <input type="text" name="keterangan_foto[]"
                                                placeholder="cth: Foto kerusakan bagian depan"
                                                class="w-full px-3 py-2 rounded-lg border border-slate-200 text-sm text-slate-700 focus:ring-2 focus:ring-red-300 focus:border-red-300 transition">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <button type="button" onclick="tambahFoto()"
                                class="mt-3 inline-flex items-center gap-2 px-4 py-2 bg-white border-2 border-dashed border-red-300 text-red-600 rounded-xl text-sm font-semibold hover:bg-red-50 transition">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                                Tambah Foto
                            </button>
                        </div>
                    </div>
                </div>

                {{-- --- Tindakan Selanjutnya --- --}}
                <div x-show="kondisi !== '' && kondisi !== 'sesuai'"
                    x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0 -translate-y-2"
                    x-transition:enter-end="opacity-100 translate-y-0"
                    class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden mb-6">

                    <div class="px-6 py-4 border-b border-slate-200">
                        <h3 class="text-base font-bold text-slate-900">🔄 Tindakan Selanjutnya</h3>
                        <p class="text-sm text-slate-500 mt-0.5">Tentukan tindakan yang akan diambil atas ketidaksesuaian ini</p>
                    </div>

                    <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-3">
                        <label class="flex items-start gap-3 p-4 rounded-2xl border-2 cursor-pointer transition"
                            :class="tindakan === 'terima_dengan_catatan' ? 'border-blue-500 bg-blue-50' : 'border-slate-200 hover:border-slate-300'">
                            <input type="radio" name="tindakan_selanjutnya" value="terima_dengan_catatan" x-model="tindakan"
                                class="mt-1 accent-blue-600">
                            <div>
                                <p class="font-semibold text-slate-900 text-sm">Terima barang dengan catatan</p>
                                <p class="text-xs text-slate-500 mt-0.5">Barang diterima namun dengan dokumentasi ketidaksesuaian</p>
                            </div>
                        </label>

                        <label class="flex items-start gap-3 p-4 rounded-2xl border-2 cursor-pointer transition"
                            :class="tindakan === 'minta_penggantian' ? 'border-purple-500 bg-purple-50' : 'border-slate-200 hover:border-slate-300'">
                            <input type="radio" name="tindakan_selanjutnya" value="minta_penggantian" x-model="tindakan"
                                class="mt-1 accent-purple-600">
                            <div>
                                <p class="font-semibold text-slate-900 text-sm">Minta penggantian barang kepada vendor</p>
                                <p class="text-xs text-slate-500 mt-0.5">Vendor wajib mengganti barang yang rusak/tidak sesuai</p>
                            </div>
                        </label>

                        <label class="flex items-start gap-3 p-4 rounded-2xl border-2 cursor-pointer transition"
                            :class="tindakan === 'retur_sebagian' ? 'border-orange-500 bg-orange-50' : 'border-slate-200 hover:border-slate-300'">
                            <input type="radio" name="tindakan_selanjutnya" value="retur_sebagian" x-model="tindakan"
                                class="mt-1 accent-orange-600">
                            <div>
                                <p class="font-semibold text-slate-900 text-sm">Retur sebagian barang</p>
                                <p class="text-xs text-slate-500 mt-0.5">Sebagian barang dikembalikan ke vendor untuk diganti</p>
                            </div>
                        </label>

                        <label class="flex items-start gap-3 p-4 rounded-2xl border-2 cursor-pointer transition"
                            :class="tindakan === 'tolak_barang' ? 'border-red-500 bg-red-50' : 'border-slate-200 hover:border-slate-300'">
                            <input type="radio" name="tindakan_selanjutnya" value="tolak_barang" x-model="tindakan"
                                class="mt-1 accent-red-600">
                            <div>
                                <p class="font-semibold text-slate-900 text-sm">Tolak barang</p>
                                <p class="text-xs text-slate-500 mt-0.5">Seluruh pengiriman ditolak dan dikembalikan ke vendor</p>
                            </div>
                        </label>
                    </div>
                </div>

                {{-- --- Tombol Submit --- --}}
                <div class="bg-white rounded-3xl border border-slate-200 shadow-sm p-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                    <div>
                        <p class="font-semibold text-slate-900">Simpan Laporan Penerimaan</p>
                        <p class="text-sm text-slate-500 mt-0.5">Laporan akan dikirim ke Supply Chain sebagai notifikasi</p>
                    </div>
                    <div class="flex gap-3">
                        <a href="{{ route('gudang.dashboard') }}"
                            class="inline-flex items-center gap-2 px-6 py-3 bg-slate-100 text-slate-700 rounded-xl font-semibold border border-slate-200 hover:bg-slate-200 transition">
                            Batal
                        </a>
                        <button type="submit" x-bind:disabled="kondisi === ''"
                            class="inline-flex items-center gap-2 px-8 py-3 bg-blue-900 text-white rounded-xl font-bold shadow-lg hover:bg-blue-950 disabled:opacity-50 disabled:cursor-not-allowed transition">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            Simpan Laporan Penerimaan
                        </button>
                    </div>
                </div>

            </form>

        </div>
    </div>

    <script>
        function goodsReceiptForm() {
            return {
                kondisi: '{{ old('kondisi_barang', '') }}',
                tindakan: '{{ old('tindakan_selanjutnya', '') }}',
            }
        }

        function previewImage(input) {
            const container = input.closest('.foto-item').querySelector('.preview-container');
            const img = input.closest('.foto-item').querySelector('.preview-img');
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    img.src = e.target.result;
                    container.classList.remove('hidden');
                };
                reader.readAsDataURL(input.files[0]);
            }
        }

        function tambahFoto() {
            const container = document.getElementById('foto-container');
            const item = document.querySelector('.foto-item').cloneNode(true);
            // Reset cloned inputs
            item.querySelectorAll('input[type=file]').forEach(i => i.value = '');
            item.querySelectorAll('input[type=text]').forEach(i => i.value = '');
            item.querySelectorAll('.preview-container').forEach(c => c.classList.add('hidden'));

            // Add remove button
            const removeBtn = document.createElement('button');
            removeBtn.type = 'button';
            removeBtn.className = 'mt-2 text-xs text-red-500 hover:text-red-700 font-semibold';
            removeBtn.textContent = '✕ Hapus foto ini';
            removeBtn.onclick = () => item.remove();
            item.appendChild(removeBtn);

            // Wire up preview
            item.querySelector('input[type=file]').addEventListener('change', function() {
                previewImage(this);
            });

            container.appendChild(item);
        }
    </script>
</x-app-layout>
