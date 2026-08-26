const fs = require('fs');
const path = require('path');

const gudPath = path.join(__dirname, 'resources', 'views', 'dashboards', 'gudang.blade.php');
let gudContent = fs.readFileSync(gudPath, 'utf8');

const gudReplacement = `<div class="bg-white rounded-2xl p-8 md:p-10 shadow-sm border border-slate-200 flex flex-col lg:flex-row gap-8 items-center justify-between">
                <div class="max-w-3xl">
                    <p class="inline-flex px-4 py-2 rounded-full bg-slate-50 border border-slate-200 text-sm text-slate-600 mb-5 font-medium">
                        📦 Manajemen Gudang - PT PAL
                    </p>
                    <h3 class="text-3xl md:text-4xl font-extrabold leading-tight text-slate-900 tracking-tight">
                        Penerimaan Material Kapal, <span class="text-transparent bg-clip-text bg-gradient-to-r from-slate-900 to-blue-900">{{ Auth::user()->name }}</span>
                    </h3>
                    <p class="mt-4 text-slate-600 max-w-xl text-base leading-relaxed">
                        Kelola penerimaan barang dari vendor, lakukan pemeriksaan kualitas material, dan dokumentasikan
                        kondisi barang secara sistematis untuk memastikan standar pengadaan kapal terpenuhi.
                    </p>
                    <div class="mt-7 flex flex-wrap gap-3">
                        <a href="{{ route('gudang.goods-receipts.index') }}"
                            class="inline-flex items-center gap-2 px-6 py-3 bg-gradient-to-r from-slate-900 to-blue-900 text-white rounded-xl font-bold shadow-md hover:from-slate-800 hover:to-blue-800 transition-all hover:-translate-y-0.5">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2M15 11l-3 3m0 0l-3-3m3 3V8"/></svg>
                            Periksa Barang Masuk
                        </a>
                    </div>
                </div>
            </div>`;

const gudRegex = /<div class="bg-white rounded-2xl p-8 md:p-10 shadow-sm border border-slate-200 flex flex-col lg:flex-row gap-8 items-center justify-between">[\s\S]*?<\/div>\s*<\/div>/;
gudContent = gudContent.replace(gudRegex, gudReplacement);

fs.writeFileSync(gudPath, gudContent, 'utf8');

console.log('Update gudang complete.');
