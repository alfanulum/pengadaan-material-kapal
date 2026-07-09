<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3">
            <div>
                <h2 class="font-bold text-2xl text-slate-900 leading-tight">
                    Detail Purchase Order
                </h2>
                <p class="text-sm text-slate-500 mt-1">
                    Detail PO yang diterima vendor dari Supply Chain.
                </p>
            </div>

            <div class="flex flex-col sm:flex-row gap-3">
                <a href="{{ route('vendor.purchase-orders.index') }}"
                    class="inline-flex items-center justify-center px-5 py-3 bg-slate-100 text-slate-700 rounded-xl font-semibold border border-slate-200 hover:bg-slate-200 transition">
                    Daftar PO
                </a>

                <a href="{{ route('vendor.dashboard') }}"
                    class="inline-flex items-center justify-center px-5 py-3 bg-slate-900 text-white rounded-xl font-semibold hover:bg-slate-800 transition">
                    Dashboard
                </a>
            </div>
        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        {{-- Flash Messages --}}
        @if(session('success'))
            <div class="mb-6 p-4 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-2xl flex items-center gap-3">
                <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="mb-6 p-4 bg-red-50 border border-red-200 text-red-700 rounded-2xl flex items-center gap-3">
                <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                {{ session('error') }}
            </div>
        @endif

        {{-- Tentukan status tampilan berdasarkan status PO --}}
        @php
            $statusPO = $purchaseOrder->status;
            $hasShipment = $purchaseOrder->shipment !== null;
            $hasReceipt  = $purchaseOrder->goodsReceipt !== null;

            // Logika badge status
            if ($hasReceipt || in_array($statusPO, ['selesai', 'diterima_gudang'])) {
                $badgeLabel = 'Barang Diterima Gudang';
                $badgeClass = 'bg-emerald-100 text-emerald-700 border border-emerald-200';
                $heroBg     = 'from-emerald-950 via-emerald-900 to-emerald-700';
            } elseif ($hasShipment || $statusPO === 'dikirim') {
                $badgeLabel = 'Barang Dikirim';
                $badgeClass = 'bg-orange-100 text-orange-700 border border-orange-200';
                $heroBg     = 'from-orange-950 via-orange-900 to-orange-700';
            } else {
                $badgeLabel = 'PO Diterbitkan';
                $badgeClass = 'bg-blue-100 text-blue-700 border border-blue-200';
                $heroBg     = 'from-slate-950 via-blue-950 to-blue-800';
            }

            $canShip = ($statusPO === 'dikirim_ke_vendor') && !$hasShipment;
        @endphp

        {{-- Hero --}}
        <div class="bg-gradient-to-r {{ $heroBg }} rounded-3xl p-8 md:p-10 shadow-xl text-white mb-8 overflow-hidden relative">
            <div class="absolute -top-24 -right-24 w-80 h-80 bg-cyan-400/20 rounded-full blur-3xl"></div>
            <div class="absolute -bottom-24 -left-24 w-80 h-80 bg-blue-400/20 rounded-full blur-3xl"></div>

            <div class="relative z-10 flex flex-col lg:flex-row lg:items-end lg:justify-between gap-6">
                <div>
                    <div class="flex items-center gap-3 mb-5">
                        <p class="inline-flex px-4 py-2 rounded-full bg-white/10 border border-white/10 text-sm text-blue-100">
                            {{ $purchaseOrder->kode_po }}
                        </p>
                        <span class="inline-flex px-3 py-1 rounded-full text-xs font-bold {{ $badgeClass }}">
                            {{ $badgeLabel }}
                        </span>
                    </div>

                    <h3 class="text-3xl md:text-4xl font-bold leading-tight">
                        Purchase Order Diterima
                    </h3>

                    <p class="mt-4 text-blue-100 max-w-3xl text-base leading-relaxed">
                        PO ini diterbitkan oleh Supply Chain berdasarkan tender yang dimenangkan vendor.
                    </p>
                </div>

                <div class="bg-white/10 border border-white/10 rounded-2xl p-5 min-w-[210px]">
                    <p class="text-sm text-blue-100">Total PO</p>
                    <p class="text-2xl font-bold mt-1">
                        Rp {{ number_format($purchaseOrder->total_harga, 0, ',', '.') }}
                    </p>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

            <div class="lg:col-span-2 space-y-8">

                <div class="bg-white rounded-3xl shadow-sm border border-slate-200 overflow-hidden">
                    <div class="px-6 py-5 border-b border-slate-200">
                        <h3 class="text-lg font-bold text-slate-900">
                            Informasi Purchase Order
                        </h3>
                    </div>

                    <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div class="rounded-2xl bg-slate-50 p-4">
                            <p class="text-xs text-slate-500 mb-1">Kode PO</p>
                            <p class="font-bold text-slate-900">{{ $purchaseOrder->kode_po }}</p>
                        </div>

                        <div class="rounded-2xl bg-slate-50 p-4">
                            <p class="text-xs text-slate-500 mb-1">Kode Tender</p>
                            <p class="font-bold text-slate-900">{{ $purchaseOrder->tender->kode_tender ?? '-' }}</p>
                        </div>

                        <div class="rounded-2xl bg-slate-50 p-4">
                            <p class="text-xs text-slate-500 mb-1">Project</p>
                            <p class="font-bold text-slate-900">
                                {{ $purchaseOrder->tender->materialRequest->project->nama_project ?? '-' }}
                            </p>
                        </div>

                        <div class="rounded-2xl bg-slate-50 p-4">
                            <p class="text-xs text-slate-500 mb-1">Vendor</p>
                            <p class="font-bold text-slate-900">{{ $purchaseOrder->vendor->nama_vendor ?? '-' }}</p>
                        </div>

                        <div class="rounded-2xl bg-slate-50 p-4">
                            <p class="text-xs text-slate-500 mb-1">Tanggal PO</p>
                            <p class="font-bold text-slate-900">
                                {{ \Carbon\Carbon::parse($purchaseOrder->tanggal_po)->format('d-m-Y') }}
                            </p>
                        </div>

                        <div class="rounded-2xl bg-slate-50 p-4">
                            <p class="text-xs text-slate-500 mb-1">Deadline Pengiriman</p>
                            <p class="font-bold text-slate-900">
                                {{ $purchaseOrder->deadline_pengiriman ? \Carbon\Carbon::parse($purchaseOrder->deadline_pengiriman)->format('d-m-Y') : '-' }}
                            </p>
                        </div>

                        <div class="rounded-2xl bg-slate-50 p-4">
                            <p class="text-xs text-slate-500 mb-1">Status PO</p>
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold {{ $badgeClass }}">
                                <span class="w-1.5 h-1.5 rounded-full bg-current"></span>
                                {{ $badgeLabel }}
                            </span>
                        </div>

                        <div class="rounded-2xl bg-slate-50 p-4">
                            <p class="text-xs text-slate-500 mb-1">Total Harga</p>
                            <p class="font-bold text-slate-900">
                                Rp {{ number_format($purchaseOrder->total_harga, 0, ',', '.') }}
                            </p>
                        </div>

                        <div class="rounded-2xl bg-slate-50 p-4 md:col-span-2">
                            <p class="text-xs text-slate-500 mb-1">Catatan Supply Chain</p>
                            <p class="font-medium text-slate-900">
                                {{ $purchaseOrder->catatan ?? '-' }}
                            </p>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-3xl shadow-sm border border-slate-200 overflow-hidden">
                    <div class="px-6 py-5 border-b border-slate-200">
                        <h3 class="text-lg font-bold text-slate-900">
                            Item Purchase Order
                        </h3>
                        <p class="text-sm text-slate-500 mt-1">
                            Daftar material yang harus diproses vendor.
                        </p>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead class="bg-slate-50 border-b border-slate-200">
                                <tr>
                                    <th class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase">Barang
                                    </th>
                                    <th class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase">
                                        Spesifikasi</th>
                                    <th class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase">Qty</th>
                                    <th class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase">Satuan
                                    </th>
                                </tr>
                            </thead>

                            <tbody class="divide-y divide-slate-100">
                                @forelse ($purchaseOrder->items as $item)
                                    <tr class="hover:bg-slate-50 transition">
                                        <td class="px-6 py-4 text-sm font-bold text-slate-900">
                                            {{ $item->nama_barang }}
                                        </td>
                                        <td class="px-6 py-4 text-sm text-slate-700">
                                            {{ $item->spesifikasi ?? '-' }}
                                        </td>
                                        <td class="px-6 py-4 text-sm text-slate-700">
                                            {{ $item->qty }}
                                        </td>
                                        <td class="px-6 py-4 text-sm text-slate-700">
                                            {{ $item->satuan }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="px-6 py-12 text-center text-slate-500">
                                            Belum ada item PO.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>

            <div class="lg:col-span-1 space-y-6">

                {{-- Panel Tindak Lanjut / Status --}}
                <div class="bg-white rounded-3xl shadow-sm border border-slate-200 p-6">
                    <h3 class="text-lg font-bold text-slate-900">
                        Status Pengiriman
                    </h3>

                    <p class="text-sm text-slate-500 mt-2 leading-relaxed">
                        Pantau status pengiriman barang untuk Purchase Order ini.
                    </p>

                    {{-- Badge Status Besar --}}
                    <div class="mt-5 rounded-2xl p-4 {{ $hasReceipt || in_array($statusPO, ['selesai','diterima_gudang']) ? 'bg-emerald-50 border border-emerald-100' : ($hasShipment || $statusPO === 'dikirim' ? 'bg-orange-50 border border-orange-100' : 'bg-blue-50 border border-blue-100') }}">
                        <p class="text-xs {{ $hasReceipt || in_array($statusPO, ['selesai','diterima_gudang']) ? 'text-emerald-700' : ($hasShipment || $statusPO === 'dikirim' ? 'text-orange-700' : 'text-blue-700') }}">Status PO</p>
                        <p class="font-bold text-slate-900 mt-1 text-lg">{{ $badgeLabel }}</p>
                    </div>

                    {{-- Tombol Kirim Barang (hanya muncul jika belum dikirim) --}}
                    @if($canShip)
                        <div class="mt-6">
                            <form action="{{ route('vendor.purchase-orders.ship', $purchaseOrder->id) }}" method="POST"
                                id="form-kirim-barang"
                                onsubmit="return confirmShip(event)">
                                @csrf
                                <button type="submit" id="btn-kirim-barang"
                                    class="w-full inline-flex items-center justify-center gap-2 px-5 py-3.5 bg-blue-900 text-white rounded-xl font-semibold hover:bg-blue-950 active:scale-95 transition-all duration-150 shadow-lg shadow-blue-900/30">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"/></svg>
                                    Kirim Barang ke Gudang
                                </button>
                            </form>
                            <p class="text-xs text-slate-500 mt-3 text-center">
                                Tekan tombol ini jika barang sudah siap dikirimkan ke gudang.
                            </p>
                        </div>

                    {{-- Badge: Barang Sedang Dikirim (sudah klik kirim, belum diterima gudang) --}}
                    @elseif(($hasShipment || $statusPO === 'dikirim') && !$hasReceipt && !in_array($statusPO, ['selesai','diterima_gudang']))
                        <div class="mt-6 p-4 rounded-xl bg-orange-50 border border-orange-200">
                            <div class="flex items-center gap-3">
                                <div class="w-9 h-9 rounded-full bg-orange-100 flex items-center justify-center shrink-0">
                                    <svg class="w-5 h-5 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8a1 1 0 011-1h2.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1m-6-1a1 1 0 001 1h1M5 17a2 2 0 104 0m-4 0a2 2 0 114 0m6 0a2 2 0 104 0m-4 0a2 2 0 114 0"/></svg>
                                </div>
                                <div>
                                    <p class="text-sm font-bold text-orange-900">Barang Sedang Dikirim</p>
                                    @if($purchaseOrder->tanggal_pengiriman)
                                        <p class="text-xs text-orange-700 mt-0.5">
                                            Dikirim pada: {{ \Carbon\Carbon::parse($purchaseOrder->tanggal_pengiriman)->format('d M Y H:i') }}
                                        </p>
                                    @endif
                                    <p class="text-xs text-orange-600 mt-1">Menunggu konfirmasi penerimaan dari Gudang.</p>
                                </div>
                            </div>
                        </div>

                    {{-- Badge: Barang Diterima Gudang --}}
                    @elseif($hasReceipt || in_array($statusPO, ['selesai','diterima_gudang']))
                        <div class="mt-6 p-4 rounded-xl bg-emerald-50 border border-emerald-200">
                            <div class="flex items-center gap-3">
                                <div class="w-9 h-9 rounded-full bg-emerald-100 flex items-center justify-center shrink-0">
                                    <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                </div>
                                <div>
                                    <p class="text-sm font-bold text-emerald-900">Barang Diterima Gudang</p>
                                    @if($purchaseOrder->goodsReceipt?->tanggal_diterima)
                                        <p class="text-xs text-emerald-700 mt-0.5">
                                            Diterima: {{ \Carbon\Carbon::parse($purchaseOrder->goodsReceipt->tanggal_diterima)->format('d M Y') }}
                                        </p>
                                    @endif
                                    <p class="text-xs text-emerald-600 mt-1">Proses pengadaan selesai.</p>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>

                {{-- Timeline Mini --}}
                <div class="bg-white rounded-3xl shadow-sm border border-slate-200 p-6">
                    <h3 class="text-sm font-bold text-slate-900 mb-5">Progress Pengiriman</h3>

                    <div class="space-y-4">
                        {{-- Step 1: PO Dibuat --}}
                        <div class="flex items-start gap-3">
                            <div class="w-7 h-7 rounded-full bg-emerald-100 border-2 border-emerald-500 flex items-center justify-center shrink-0 mt-0.5">
                                <svg class="w-3.5 h-3.5 text-emerald-600" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                            </div>
                            <div>
                                <p class="text-xs font-bold text-slate-900">PO Diterbitkan</p>
                                <p class="text-xs text-slate-500 mt-0.5">
                                    {{ \Carbon\Carbon::parse($purchaseOrder->tanggal_po)->format('d M Y') }}
                                </p>
                            </div>
                        </div>

                        {{-- Step 2: Barang Dikirim --}}
                        <div class="flex items-start gap-3">
                            <div class="w-7 h-7 rounded-full {{ $hasShipment || in_array($statusPO, ['dikirim','selesai','diterima_gudang']) ? 'bg-orange-100 border-2 border-orange-500' : 'bg-slate-100 border-2 border-slate-300' }} flex items-center justify-center shrink-0 mt-0.5">
                                @if($hasShipment || in_array($statusPO, ['dikirim','selesai','diterima_gudang']))
                                    <svg class="w-3.5 h-3.5 text-orange-600" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                                @else
                                    <span class="w-2 h-2 rounded-full bg-slate-300"></span>
                                @endif
                            </div>
                            <div>
                                <p class="text-xs font-bold {{ $hasShipment || in_array($statusPO, ['dikirim','selesai','diterima_gudang']) ? 'text-slate-900' : 'text-slate-400' }}">Barang Dikirim</p>
                                @if($purchaseOrder->tanggal_pengiriman && ($hasShipment || in_array($statusPO, ['dikirim','selesai','diterima_gudang'])))
                                    <p class="text-xs text-slate-500 mt-0.5">
                                        {{ \Carbon\Carbon::parse($purchaseOrder->tanggal_pengiriman)->format('d M Y H:i') }}
                                    </p>
                                @else
                                    <p class="text-xs text-slate-400 mt-0.5">Menunggu pengiriman</p>
                                @endif
                            </div>
                        </div>

                        {{-- Step 3: Diterima Gudang --}}
                        <div class="flex items-start gap-3">
                            <div class="w-7 h-7 rounded-full {{ $hasReceipt || in_array($statusPO, ['selesai','diterima_gudang']) ? 'bg-emerald-100 border-2 border-emerald-500' : 'bg-slate-100 border-2 border-slate-300' }} flex items-center justify-center shrink-0 mt-0.5">
                                @if($hasReceipt || in_array($statusPO, ['selesai','diterima_gudang']))
                                    <svg class="w-3.5 h-3.5 text-emerald-600" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                                @else
                                    <span class="w-2 h-2 rounded-full bg-slate-300"></span>
                                @endif
                            </div>
                            <div>
                                <p class="text-xs font-bold {{ $hasReceipt || in_array($statusPO, ['selesai','diterima_gudang']) ? 'text-slate-900' : 'text-slate-400' }}">Barang Diterima Gudang</p>
                                @if($purchaseOrder->goodsReceipt?->tanggal_diterima)
                                    <p class="text-xs text-slate-500 mt-0.5">
                                        {{ \Carbon\Carbon::parse($purchaseOrder->goodsReceipt->tanggal_diterima)->format('d M Y') }}
                                    </p>
                                @else
                                    <p class="text-xs text-slate-400 mt-0.5">Menunggu penerimaan gudang</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Navigasi --}}
                <div class="bg-white rounded-3xl shadow-sm border border-slate-200 p-6">
                    <div class="space-y-3">
                        <a href="{{ route('vendor.purchase-orders.index') }}"
                            class="w-full inline-flex items-center justify-center px-5 py-3 bg-slate-100 text-slate-700 rounded-xl font-semibold hover:bg-slate-200 transition">
                            Kembali ke Daftar PO
                        </a>

                        <a href="{{ route('vendor.dashboard') }}"
                            class="w-full inline-flex items-center justify-center px-5 py-3 bg-slate-900 text-white rounded-xl font-semibold hover:bg-slate-800 transition">
                            Kembali ke Dashboard
                        </a>
                    </div>
                </div>

            </div>

        </div>

    </div>

    <script>
        function confirmShip(e) {
            e.preventDefault();
            if (!confirm('Anda yakin ingin mengirim barang ke gudang?\n\nGudang dan Supply Chain akan mendapatkan notifikasi secara otomatis.')) {
                return false;
            }

            const btn = document.getElementById('btn-kirim-barang');
            btn.disabled = true;
            btn.innerHTML = `
                <svg class="w-5 h-5 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                Memproses...
            `;
            document.getElementById('form-kirim-barang').submit();
        }
    </script>
</x-app-layout>
