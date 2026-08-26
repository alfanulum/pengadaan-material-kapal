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
                    Pemeriksaan Barang Masuk
                </h2>
                <p class="text-sm text-slate-500 mt-1">
                    PO <span class="font-bold text-slate-900">{{ $purchaseOrder->kode_po }}</span> &mdash;
                    {{ $purchaseOrder->vendor->nama_vendor ?? '-' }}
                </p>
            </div>
            <a href="{{ route('gudang.dashboard') }}"
                class="inline-flex items-center gap-2 px-5 py-2.5 bg-white text-slate-700 rounded-xl font-semibold border border-slate-200 hover:bg-slate-50 transition shadow-sm text-sm">
                Kembali
            </a>
        </div>
    </x-slot>

    <div class="py-8" x-data="goodsReceiptForm()">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">

            @if ($purchaseOrder->goodsReceipt)
                <div class="p-4 bg-amber-50 border border-amber-200 text-amber-800 rounded-2xl flex items-start gap-3 shadow-sm">
                    <svg class="w-5 h-5 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                    <div>
                        <p class="font-bold">Laporan penerimaan sudah ada</p>
                        <p class="text-sm mt-0.5">PO ini sudah memiliki laporan penerimaan. Mengisi form ini akan <strong>mengganti</strong> laporan sebelumnya.</p>
                    </div>
                </div>
            @endif

            @if ($errors->any())
                <div class="p-4 bg-red-50 border border-red-200 text-red-700 rounded-2xl shadow-sm">
                    <ul class="list-disc list-inside space-y-1 text-sm font-medium">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- Info PO --}}
            <div class="bg-white rounded-3xl p-8 border border-slate-200 shadow-sm">
                <div class="flex flex-col md:flex-row md:items-start justify-between gap-6 mb-8 border-b border-slate-100 pb-8">
                    <div>
                        <p class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Purchase Order</p>
                        <h3 class="text-2xl font-black text-slate-900">{{ $purchaseOrder->kode_po }}</h3>
                    </div>
                    <div class="md:text-right">
                        <p class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Total Nilai</p>
                        <p class="text-xl font-black text-slate-900">Rp {{ number_format($purchaseOrder->total_harga, 0, ',', '.') }}</p>
                    </div>
                </div>

                <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                    <div>
                        <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Vendor</p>
                        <p class="text-sm font-semibold text-slate-900 mt-1">{{ $purchaseOrder->vendor->nama_vendor ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Tender</p>
                        <p class="text-sm font-semibold text-slate-900 mt-1">{{ $purchaseOrder->tender->kode_tender ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Tanggal PO</p>
                        <p class="text-sm font-semibold text-slate-900 mt-1">
                            {{ $purchaseOrder->tanggal_po ? \Carbon\Carbon::parse($purchaseOrder->tanggal_po)->format('d M Y') : '-' }}
                        </p>
                    </div>
                    <div>
                        <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Target Kirim</p>
                        <p class="text-sm font-semibold text-slate-900 mt-1">
                            {{ $purchaseOrder->deadline_pengiriman ? \Carbon\Carbon::parse($purchaseOrder->deadline_pengiriman)->format('d M Y') : '-' }}
                        </p>
                    </div>
                </div>
            </div>

            {{-- Detail Material --}}
            <div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden">
                <div class="px-6 py-5 border-b border-slate-100">
                    <h3 class="text-base font-bold text-slate-900">Spesifikasi Material</h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="bg-slate-50/50 border-b border-slate-100">
                                <th class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Nama Barang</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Spesifikasi</th>
                                <th class="px-6 py-4 text-center text-xs font-bold text-slate-500 uppercase tracking-wider">Qty Pesanan</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Satuan</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @foreach ($purchaseOrder->items as $item)
                                <tr class="hover:bg-slate-50/50 transition">
                                    <td class="px-6 py-4 text-sm font-bold text-slate-900">{{ $item->nama_barang }}</td>
                                    <td class="px-6 py-4 text-sm text-slate-600">{{ $item->spesifikasi }}</td>
                                    <td class="px-6 py-4 text-sm font-black text-blue-600 text-center">{{ $item->qty }}</td>
                                    <td class="px-6 py-4 text-sm text-slate-600">{{ $item->satuan }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <form action="{{ route('gudang.goods-receipts.store', $purchaseOrder->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden mb-8">
                    <div class="px-6 py-5 border-b border-slate-100">
                        <h3 class="text-base font-bold text-slate-900">Formulir Pemeriksaan</h3>
                        <p class="text-sm text-slate-500 mt-0.5">Isi data aktual barang yang Anda terima</p>
                    </div>

                    <div class="p-6 md:p-8 space-y-8">
                        {{-- Data Penerimaan --}}
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-bold text-slate-700 mb-2">Tanggal Diterima <span class="text-red-500">*</span></label>
                                <input type="date" name="tanggal_diterima" value="{{ old('tanggal_diterima', date('Y-m-d')) }}" required
                                    class="w-full px-4 py-3 rounded-xl border border-slate-200 bg-slate-50 text-slate-900 focus:bg-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition outline-none font-medium">
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-slate-700 mb-2">Jumlah Barang Aktual <span class="text-red-500">*</span></label>
                                <input type="number" name="jumlah_diterima" value="{{ old('jumlah_diterima', $purchaseOrder->items->sum('qty')) }}" required min="0"
                                    class="w-full px-4 py-3 rounded-xl border border-slate-200 bg-slate-50 text-slate-900 focus:bg-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition outline-none font-medium">
                            </div>
                        </div>

                        <hr class="border-slate-100">

                        {{-- Kondisi Barang --}}
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-4">Hasil Pemeriksaan Fisik <span class="text-red-500">*</span></label>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <label class="relative flex p-4 rounded-2xl border-2 cursor-pointer transition-all"
                                    :class="kondisi === 'sesuai' ? 'border-emerald-500 bg-emerald-50' : 'border-slate-200 hover:border-slate-300'">
                                    <input type="radio" name="kondisi_barang" value="sesuai" x-model="kondisi" class="absolute opacity-0">
                                    <div>
                                        <p class="font-bold text-slate-900 text-sm">Sesuai Pesanan</p>
                                        <p class="text-xs text-slate-500 mt-1">Jumlah, spesifikasi, dan kondisi sempurna sesuai PO</p>
                                    </div>
                                    <div class="ml-auto w-5 h-5 rounded-full border-2 flex items-center justify-center shrink-0 transition-colors"
                                        :class="kondisi === 'sesuai' ? 'border-emerald-500' : 'border-slate-300'">
                                        <div class="w-2.5 h-2.5 rounded-full bg-emerald-500 scale-0 transition-transform"
                                            :class="kondisi === 'sesuai' ? 'scale-100' : ''"></div>
                                    </div>
                                </label>

                                <label class="relative flex p-4 rounded-2xl border-2 cursor-pointer transition-all"
                                    :class="kondisi === 'diterima_dengan_catatan' ? 'border-blue-500 bg-blue-50' : 'border-slate-200 hover:border-slate-300'">
                                    <input type="radio" name="kondisi_barang" value="diterima_dengan_catatan" x-model="kondisi" class="absolute opacity-0">
                                    <div>
                                        <p class="font-bold text-slate-900 text-sm">Diterima dengan Catatan</p>
                                        <p class="text-xs text-slate-500 mt-1">Perbedaan minor yang masih dapat diterima</p>
                                    </div>
                                    <div class="ml-auto w-5 h-5 rounded-full border-2 flex items-center justify-center shrink-0 transition-colors"
                                        :class="kondisi === 'diterima_dengan_catatan' ? 'border-blue-500' : 'border-slate-300'">
                                        <div class="w-2.5 h-2.5 rounded-full bg-blue-500 scale-0 transition-transform"
                                            :class="kondisi === 'diterima_dengan_catatan' ? 'scale-100' : ''"></div>
                                    </div>
                                </label>

                                <label class="relative flex p-4 rounded-2xl border-2 cursor-pointer transition-all"
                                    :class="kondisi === 'kerusakan' ? 'border-amber-500 bg-amber-50' : 'border-slate-200 hover:border-slate-300'">
                                    <input type="radio" name="kondisi_barang" value="kerusakan" x-model="kondisi" class="absolute opacity-0">
                                    <div>
                                        <p class="font-bold text-slate-900 text-sm">Mengalami Kerusakan</p>
                                        <p class="text-xs text-slate-500 mt-1">Barang rusak fisik, cacat produksi, dsb</p>
                                    </div>
                                    <div class="ml-auto w-5 h-5 rounded-full border-2 flex items-center justify-center shrink-0 transition-colors"
                                        :class="kondisi === 'kerusakan' ? 'border-amber-500' : 'border-slate-300'">
                                        <div class="w-2.5 h-2.5 rounded-full bg-amber-500 scale-0 transition-transform"
                                            :class="kondisi === 'kerusakan' ? 'scale-100' : ''"></div>
                                    </div>
                                </label>

                                <label class="relative flex p-4 rounded-2xl border-2 cursor-pointer transition-all"
                                    :class="kondisi === 'tidak_sesuai_spesifikasi' ? 'border-red-500 bg-red-50' : 'border-slate-200 hover:border-slate-300'">
                                    <input type="radio" name="kondisi_barang" value="tidak_sesuai_spesifikasi" x-model="kondisi" class="absolute opacity-0">
                                    <div>
                                        <p class="font-bold text-slate-900 text-sm">Tidak Sesuai Spesifikasi</p>
                                        <p class="text-xs text-slate-500 mt-1">Spesifikasi teknis, dimensi, atau material berbeda</p>
                                    </div>
                                    <div class="ml-auto w-5 h-5 rounded-full border-2 flex items-center justify-center shrink-0 transition-colors"
                                        :class="kondisi === 'tidak_sesuai_spesifikasi' ? 'border-red-500' : 'border-slate-300'">
                                        <div class="w-2.5 h-2.5 rounded-full bg-red-500 scale-0 transition-transform"
                                            :class="kondisi === 'tidak_sesuai_spesifikasi' ? 'scale-100' : ''"></div>
                                    </div>
                                </label>
                            </div>
                        </div>

                        {{-- Catatan (Normal) --}}
                        <div x-show="kondisi === 'sesuai' || kondisi === 'diterima_dengan_catatan'" style="display: none;">
                            <label class="block text-sm font-bold text-slate-700 mb-2">Catatan Pemeriksaan</label>
                            <textarea name="catatan_gudang" rows="3"
                                class="w-full px-4 py-3 rounded-xl border border-slate-200 bg-slate-50 text-slate-900 focus:bg-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition outline-none font-medium text-sm"
                                placeholder="Opsional: Tuliskan catatan dari tim gudang..."></textarea>
                        </div>

                        {{-- Form Bermasalah --}}
                        <div x-show="kondisi === 'kerusakan' || kondisi === 'tidak_sesuai_spesifikasi'" style="display: none;"
                            class="bg-red-50/50 rounded-2xl border border-red-100 p-6 space-y-6">
                            
                            <div>
                                <label class="block text-sm font-bold text-red-900 mb-2">Detail Permasalahan <span class="text-red-500">*</span></label>
                                <textarea name="detail_permasalahan" rows="4"
                                    class="w-full px-4 py-3 rounded-xl border border-red-200 bg-white text-slate-900 focus:ring-2 focus:ring-red-500 focus:border-red-500 transition outline-none font-medium text-sm"
                                    placeholder="Jelaskan secara rinci kerusakan atau ketidaksesuaian yang ditemukan..."></textarea>
                            </div>

                            <div>
                                <label class="block text-sm font-bold text-red-900 mb-2">Estimasi Jumlah Barang Rusak / Tidak Sesuai</label>
                                <input type="number" name="jumlah_rusak" value="0" min="0"
                                    class="w-full md:w-64 px-4 py-3 rounded-xl border border-red-200 bg-white text-slate-900 focus:ring-2 focus:ring-red-500 focus:border-red-500 transition outline-none font-medium">
                            </div>
                        </div>

                        <hr class="border-slate-100">

                        {{-- Upload Bukti --}}
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2">Foto Dokumentasi (Maks 10 foto)</label>
                            <p class="text-xs text-slate-500 mb-4">Format: JPG, PNG, WEBP. Maksimal 5 MB per gambar. Wajib jika barang bermasalah.</p>
                            
                            <div id="foto-container" class="space-y-4">
                                <div class="foto-item bg-slate-50 rounded-2xl p-4 border border-slate-200">
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        <div>
                                            <input type="file" name="foto[]" accept="image/*" class="w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 cursor-pointer" onchange="previewImage(this)">
                                        </div>
                                        <div>
                                            <input type="text" name="keterangan_foto[]" placeholder="Keterangan foto (opsional)..." class="w-full px-4 py-2 rounded-xl border border-slate-200 text-sm focus:ring-2 focus:ring-blue-500 outline-none">
                                        </div>
                                    </div>
                                    <div class="preview-container hidden mt-4">
                                        <img src="" class="preview-img h-32 w-auto rounded-lg border border-slate-200 object-cover shadow-sm">
                                    </div>
                                </div>
                            </div>
                            
                            <button type="button" onclick="tambahFoto()" class="mt-4 inline-flex items-center gap-2 text-sm font-bold text-blue-600 hover:text-blue-800 transition">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                                Tambah Foto Lain
                            </button>
                        </div>
                    </div>
                </div>

                {{-- Action Buttons --}}
                <div class="bg-white rounded-3xl border border-slate-200 shadow-sm p-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                    <div>
                        <p class="font-bold text-slate-900">Selesaikan Pemeriksaan</p>
                        <p class="text-sm text-slate-500 mt-0.5">Laporan akan diteruskan ke Supply Chain</p>
                    </div>
                    <div class="flex gap-3">
                        <a href="{{ route('gudang.dashboard') }}" class="px-6 py-3 rounded-xl border border-slate-200 text-slate-700 font-bold hover:bg-slate-50 transition">Batal</a>
                        <button type="submit" x-bind:disabled="kondisi === ''" class="px-8 py-3 rounded-xl bg-blue-600 text-white font-bold hover:bg-blue-700 disabled:opacity-50 transition shadow-sm">
                            Simpan Laporan
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
            
            item.querySelectorAll('input[type=file]').forEach(i => i.value = '');
            item.querySelectorAll('input[type=text]').forEach(i => i.value = '');
            item.querySelectorAll('.preview-container').forEach(c => c.classList.add('hidden'));

            const removeBtn = document.createElement('button');
            removeBtn.type = 'button';
            removeBtn.className = 'mt-3 text-xs text-red-500 hover:text-red-700 font-bold tracking-wide uppercase';
            removeBtn.textContent = 'Hapus Foto';
            removeBtn.onclick = () => item.remove();
            item.appendChild(removeBtn);

            item.querySelector('input[type=file]').addEventListener('change', function() {
                previewImage(this);
            });

            container.appendChild(item);
        }
    </script>
</x-app-layout>
