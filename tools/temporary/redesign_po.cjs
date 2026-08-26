const fs = require('fs');
const path = require('path');

const filePath = path.join(__dirname, 'resources', 'views', 'supply-chain', 'purchase-orders', 'index.blade.php');
let content = fs.readFileSync(filePath, 'utf8');

// 1. Delete Hero
const heroRegex = /\{\{-- Hero --\}\}[\s\S]*?<\/div>\s*<\/div>\s*<\/div>/;
content = content.replace(heroRegex, '');

// 2. Remove inline search from table header and add standalone search block
const searchRegex = /\{\{-- SEARCH BAR --\}\}[\s\S]*?<\/div>\s*@if\(\$search \?\? false\)[\s\S]*?@endif\s*<\/div>/;
const standaloneSearch = `</div>

            {{-- Search Section --}}
            <div class="px-6 py-4 bg-white border-t border-slate-200 bg-slate-50/50">
                <form action="{{ route('supply-chain.purchase-orders.index') }}" method="GET" class="flex flex-col sm:flex-row gap-4">
                    <div class="flex-1 relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </div>
                        <input type="text" name="search" value="{{ request('search') }}"
                            class="w-full pl-12 pr-4 py-3 rounded-xl border border-slate-200 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 placeholder-slate-400 text-sm text-slate-900 transition-colors"
                            placeholder="Cari berdasarkan kode PO, vendor, atau status...">
                    </div>
                    <button type="submit" class="inline-flex items-center justify-center gap-2 px-6 py-3 bg-gradient-to-r from-slate-900 to-blue-900 hover:from-slate-800 hover:to-blue-800 text-white rounded-xl text-sm font-bold shadow-sm shadow-blue-900/20 transition hover:-translate-y-0.5">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                        <span>Cari Data</span>
                    </button>
                    @if(request('search'))
                        <a href="{{ request()->url() }}" class="inline-flex items-center justify-center px-6 py-3 bg-slate-100 text-slate-600 rounded-xl text-sm font-bold hover:bg-slate-200 transition">Reset</a>
                    @endif
                </form>
                @if(request('search'))
                    <p class="text-xs text-blue-700 mt-3">Hasil pencarian: <strong>"{{ request('search') }}"</strong></p>
                @endif
            </div>`;

content = content.replace(searchRegex, standaloneSearch);

// 3. Redesign Table
const tableRegex = /<table class="w-full">[\s\S]*?<\/table>/;
const modernTable = `<table class="w-full text-left border-collapse">
                    <thead class="bg-slate-50 border-b border-slate-200">
                        <tr>
                            <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Kode PO</th>
                            <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Tender</th>
                            <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Vendor</th>
                            <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Tanggal PO</th>
                            <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Total</th>
                            <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-4 text-center text-xs font-bold text-slate-500 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-slate-100">
                        @forelse ($purchaseOrders as $po)
                            <tr class="hover:bg-slate-50/80 transition-colors group">
                                <td class="px-6 py-4 text-xs font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-slate-900 to-blue-900 whitespace-nowrap">
                                    {{ $po->kode_po }}
                                </td>

                                <td class="px-6 py-4 text-xs text-slate-700">
                                    <div class="font-bold text-slate-800">{{ $po->tender->nama_tender ?? '-' }}</div>
                                    <div class="text-[10px] text-slate-500 mt-0.5">{{ $po->tender->kode_tender ?? '-' }}</div>
                                </td>

                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-2">
                                        <div class="w-6 h-6 rounded-full bg-blue-50 text-blue-600 border border-blue-100 flex items-center justify-center font-bold text-[10px] uppercase shadow-sm">
                                            {{ substr($po->vendor->nama_vendor ?? 'V', 0, 2) }}
                                        </div>
                                        <span class="text-xs font-bold text-slate-800">{{ $po->vendor->nama_vendor ?? '-' }}</span>
                                    </div>
                                </td>

                                <td class="px-6 py-4 text-xs text-slate-500 font-medium whitespace-nowrap">
                                    {{ \Carbon\Carbon::parse($po->tanggal_po)->format('d-m-Y') }}
                                </td>

                                <td class="px-6 py-4 text-xs font-black text-slate-900 whitespace-nowrap">
                                    Rp {{ number_format($po->total_harga, 0, ',', '.') }}
                                </td>

                                <td class="px-6 py-4 text-xs whitespace-nowrap">
                                    @if ($po->status == 'vendor_mundur')
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-rose-100 text-rose-700 border border-rose-200 text-[10px] font-bold shadow-sm">
                                            Vendor Mundur
                                        </span>
                                    @elseif ($po->status == 'dikirim_ke_vendor')
                                        <span class="inline-flex px-2.5 py-1 rounded-full bg-blue-100 text-blue-700 border border-blue-200 text-[10px] font-bold shadow-sm">
                                            Dikirim ke Vendor
                                        </span>
                                    @elseif ($po->status == 'diproses_vendor')
                                        <span class="inline-flex px-2.5 py-1 rounded-full bg-amber-100 text-amber-700 border border-amber-200 text-[10px] font-bold shadow-sm">
                                            Diproses Vendor
                                        </span>
                                    @elseif ($po->status == 'dikirim')
                                        <span class="inline-flex px-2.5 py-1 rounded-full bg-purple-100 text-purple-700 border border-purple-200 text-[10px] font-bold shadow-sm">
                                            Dikirim
                                        </span>
                                    @elseif ($po->status == 'selesai')
                                        <span class="inline-flex px-2.5 py-1 rounded-full bg-emerald-100 text-emerald-700 border border-emerald-200 text-[10px] font-bold shadow-sm">
                                            Selesai
                                        </span>
                                    @else
                                        <span class="inline-flex px-2.5 py-1 rounded-full bg-slate-100 text-slate-700 border border-slate-200 text-[10px] font-bold shadow-sm capitalize">
                                            {{ str_replace('_', ' ', ucfirst($po->status)) }}
                                        </span>
                                    @endif
                                </td>

                                <td class="px-6 py-4 text-xs whitespace-nowrap text-center">
                                    <a href="{{ route('supply-chain.purchase-orders.show', $po->id) }}" title="Detail"
                                        class="inline-flex items-center justify-center w-7 h-7 bg-white text-indigo-600 hover:bg-indigo-50 border border-slate-200 hover:border-indigo-200 rounded-md transition shadow-sm">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-6 py-16 text-center">
                                    <div class="mx-auto w-16 h-16 rounded-2xl bg-slate-50 border border-slate-200 flex items-center justify-center mb-4">
                                        <svg class="w-8 h-8 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                    </div>
                                    @if(request('search'))
                                        <h3 class="text-base font-bold text-slate-800 mb-1">Tidak Ada Hasil Pencarian</h3>
                                        <p class="text-xs text-slate-500 mt-2">Tidak ada PO yang cocok dengan "<strong>{{ request('search') }}</strong>".</p>
                                    @else
                                        <h3 class="text-base font-bold text-slate-800 mb-1">Belum Ada Purchase Order</h3>
                                        <p class="text-xs text-slate-500 mt-2">PO akan muncul setelah dibuat dari tender dengan vendor terpilih.</p>
                                    @endif
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>`;

content = content.replace(tableRegex, modernTable);
fs.writeFileSync(filePath, content, 'utf8');

console.log('Purchase Orders updated.');
