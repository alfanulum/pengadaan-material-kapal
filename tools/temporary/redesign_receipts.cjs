const fs = require('fs');
const path = require('path');

const filePath = path.join(__dirname, 'resources', 'views', 'supply-chain', 'goods-receipt-reports', 'index.blade.php');
let content = fs.readFileSync(filePath, 'utf8');

// 1. Delete Hero
const heroRegex = /\{\{-- ============================================================\s*HERO\s*============================================================ --\}\}[\s\S]*?<\/div>\s*<\/div>\s*<\/div>/;
content = content.replace(heroRegex, '');

// 2. Redesign Table
const tableRegex = /<table class="w-full">[\s\S]*?<\/table>/;
const modernTable = `<table class="w-full text-left border-collapse">
                        <thead class="bg-slate-50 border-b border-slate-200">
                            <tr>
                                <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Nomor PO</th>
                                <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Vendor</th>
                                <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Material</th>
                                <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Tanggal Diterima</th>
                                <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Jml Diterima</th>
                                <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Kondisi</th>
                                <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-4 text-center text-xs font-bold text-slate-500 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-slate-100">
                            @forelse ($receipts as $receipt)
                                <tr class="hover:bg-slate-50/80 transition-colors group">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-xs font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-slate-900 to-blue-900">{{ $receipt->purchaseOrder->kode_po }}</div>
                                        <div class="text-[10px] text-slate-500 mt-0.5">{{ $receipt->purchaseOrder->tender->kode_tender ?? '-' }}</div>
                                    </td>

                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-2">
                                            <div class="w-6 h-6 rounded-full bg-blue-50 text-blue-600 border border-blue-100 flex items-center justify-center font-bold text-[10px] uppercase shadow-sm">
                                                {{ substr($receipt->purchaseOrder->vendor->nama_vendor ?? 'V', 0, 2) }}
                                            </div>
                                            <span class="text-xs font-bold text-slate-800">{{ $receipt->purchaseOrder->vendor->nama_vendor ?? '-' }}</span>
                                        </div>
                                    </td>

                                    <td class="px-6 py-4 text-xs text-slate-700 max-w-[180px]">
                                        <div class="truncate font-medium">{{ $receipt->purchaseOrder->items->first()->nama_barang ?? '-' }}</div>
                                        @if ($receipt->purchaseOrder->items->count() > 1)
                                            <div class="text-[10px] text-slate-400 mt-0.5">+{{ $receipt->purchaseOrder->items->count() - 1 }} item lain</div>
                                        @endif
                                    </td>

                                    <td class="px-6 py-4 text-xs font-medium text-slate-500 whitespace-nowrap">
                                        {{ $receipt->tanggal_diterima?->format('d M Y') }}
                                    </td>

                                    <td class="px-6 py-4 text-xs font-bold text-slate-800 whitespace-nowrap">
                                        {{ $receipt->jumlah_diterima }} <span class="font-normal text-slate-500">item(s)</span>
                                        @if ($receipt->jumlah_rusak)
                                            <div class="text-[10px] text-rose-500 font-semibold">{{ $receipt->jumlah_rusak }} rusak</div>
                                        @endif
                                    </td>

                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @php
                                            $kondisiClass = match($receipt->kondisi_barang) {
                                                'sesuai' => 'bg-emerald-100 text-emerald-700 border border-emerald-200',
                                                'diterima_dengan_catatan' => 'bg-amber-100 text-amber-700 border border-amber-200',
                                                'kerusakan' => 'bg-rose-100 text-rose-700 border border-rose-200',
                                                'tidak_sesuai_spesifikasi' => 'bg-orange-100 text-orange-700 border border-orange-200',
                                                default => 'bg-slate-100 text-slate-700 border border-slate-200',
                                            };
                                        @endphp
                                        <span class="inline-flex px-2.5 py-1 rounded-full text-[10px] font-bold shadow-sm {{ $kondisiClass }}">
                                            {{ $receipt->kondisi_label }}
                                        </span>
                                    </td>

                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @php
                                            $statusCustomClass = str_replace(['bg-', 'text-'], ['bg-', 'text-'], $receipt->status_badge_class);
                                        @endphp
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-bold shadow-sm border {{ $statusCustomClass }}">
                                            {{ $receipt->status_label }}
                                        </span>
                                    </td>

                                    <td class="px-6 py-4 whitespace-nowrap text-center">
                                        <a href="{{ route('supply-chain.goods-receipt-reports.show', $receipt->id) }}" title="Detail"
                                            class="inline-flex items-center justify-center w-7 h-7 bg-white text-indigo-600 hover:bg-indigo-50 border border-slate-200 hover:border-indigo-200 rounded-md transition shadow-sm">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="px-6 py-16 text-center">
                                        <div class="mx-auto w-16 h-16 rounded-2xl bg-slate-50 border border-slate-200 flex items-center justify-center mb-4">
                                            <svg class="w-8 h-8 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                        </div>
                                        <h3 class="text-base font-bold text-slate-800 mb-1">Belum Ada Data</h3>
                                        <p class="text-xs text-slate-500 max-w-sm mx-auto mb-6">
                                            Saat ini belum ada laporan penerimaan dari gudang.
                                        </p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>`;

content = content.replace(tableRegex, modernTable);
fs.writeFileSync(filePath, content, 'utf8');

console.log('Goods receipt updated.');
