const fs = require('fs');
const path = require('path');

// 1. Fix PO page
const poPath = path.join(__dirname, 'resources', 'views', 'supply-chain', 'purchase-orders', 'index.blade.php');
let poContent = fs.readFileSync(poPath, 'utf8');

// Remove Hero
const poHeroRegex = /<div\s+class="bg-gradient-to-br from-slate-900 to-blue-900 rounded-3xl p-8 md:p-10 shadow-xl text-white mb-8 overflow-hidden relative">[\s\S]*?<\/div>\s*<\/div>\s*<\/div>/;
poContent = poContent.replace(poHeroRegex, '');

// Add Status Filter to search form
const poSearchRegex = /<input type="text" name="search" value="\{\{ request\('search'\) \}\}"[\s\S]*?placeholder="Cari berdasarkan kode PO, vendor, atau status...">\s*<\/div>/;
const poSearchReplace = `<input type="text" name="search" value="{{ request('search') }}"
                            class="w-full pl-12 pr-4 py-3 rounded-xl border border-slate-200 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 placeholder-slate-400 text-sm text-slate-900 transition-colors"
                            placeholder="Cari berdasarkan kode PO, vendor, atau status...">
                    </div>
                    <div class="min-w-[180px]">
                        <select name="status" class="w-full px-4 py-3 rounded-xl border border-slate-200 text-sm text-slate-700 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition-colors bg-white appearance-none cursor-pointer">
                            <option value="">Semua Status</option>
                            <option value="vendor_mundur" {{ request('status') == 'vendor_mundur' ? 'selected' : '' }}>Vendor Mundur</option>
                            <option value="dikirim_ke_vendor" {{ request('status') == 'dikirim_ke_vendor' ? 'selected' : '' }}>Dikirim ke Vendor</option>
                            <option value="diproses_vendor" {{ request('status') == 'diproses_vendor' ? 'selected' : '' }}>Diproses Vendor</option>
                            <option value="dikirim" {{ request('status') == 'dikirim' ? 'selected' : '' }}>Dikirim</option>
                            <option value="selesai" {{ request('status') == 'selesai' ? 'selected' : '' }}>Selesai</option>
                        </select>
                    </div>`;
poContent = poContent.replace(poSearchRegex, poSearchReplace);
fs.writeFileSync(poPath, poContent, 'utf8');


// 2. Fix Monitoring page
const monPath = path.join(__dirname, 'resources', 'views', 'supply-chain', 'monitoring', 'index.blade.php');
let monContent = fs.readFileSync(monPath, 'utf8');

const monSearchRegex = /<div class="relative">\s*<svg class="absolute left-3 top-1\/2 -translate-y-1\/2 w-4 h-4 text-slate-400"[\s\S]*?<\/div>/;
const monSearchReplace = `<div class="flex flex-col sm:flex-row gap-3">
                    <div class="relative flex-1">
                        <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                        <input type="text" id="monitoringSearch" placeholder="Cari vendor, tender, atau material..."
                            class="w-full pl-9 pr-4 py-3 rounded-xl border border-slate-200 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                    </div>
                    <button type="button" class="inline-flex items-center justify-center gap-2 px-6 py-3 bg-gradient-to-r from-slate-900 to-blue-900 hover:from-slate-800 hover:to-blue-800 text-white rounded-xl text-sm font-bold shadow-sm shadow-blue-900/20 transition hover:-translate-y-0.5 whitespace-nowrap">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                        <span>Cari Data</span>
                    </button>
                </div>`;
monContent = monContent.replace(monSearchRegex, monSearchReplace);

// Also need to fix the back button in monitoring that wasn't updated because it was different text (Kembali instead of Kembali ke Dashboard)
const monBackRegex = /<a href="\{\{ route\('supply-chain\.dashboard'\) \}\}"[\s\S]*?Kembali[\s\S]*?<\/a>/;
const modernBackButton = `<a href="{{ route('supply-chain.dashboard') }}"
                class="inline-flex items-center gap-2 px-5 py-2.5 bg-white border border-slate-200 hover:bg-slate-50 text-slate-700 rounded-xl text-sm font-semibold shadow-sm transition hover:-translate-y-0.5">
                <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                <span>Dashboard</span>
            </a>`;
if (monContent.match(monBackRegex)) {
    monContent = monContent.replace(monBackRegex, modernBackButton);
}

fs.writeFileSync(monPath, monContent, 'utf8');

console.log('PO and Monitoring updated.');
