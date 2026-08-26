const fs = require('fs');
const path = require('path');

const vendorIndexPath = path.join(__dirname, 'resources', 'views', 'supply-chain', 'vendors', 'index.blade.php');
let content = fs.readFileSync(vendorIndexPath, 'utf8');

// 1. Delete Hero
const heroRegex = /\{\{-- Hero --\}\}[\s\S]*?<\/div>\s*<\/div>\s*<\/div>/;
content = content.replace(heroRegex, '');

// 2. Remove the inline search bar from tabs block
const inlineSearchRegex = /\{\{-- SEARCH BAR --\}\}[\s\S]*?<\/div>\s*<\/div>\s*\{\{-- Tabel --\}\}/;
content = content.replace(inlineSearchRegex, '</div>\n\n            {{-- Tabel --}}');

// 3. Create the standalone Search Section right after @endif for session messages (or right before Tab Filters)
const searchSection = `
        {{-- Search Section --}}
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6 mb-8 mt-4 relative z-10">
            <form action="{{ route('supply-chain.vendors.index') }}" method="GET" class="flex flex-col sm:flex-row gap-4">
                <input type="hidden" name="filter" value="{{ $filterStatus }}">
                <div class="flex-1 relative">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>
                    <input type="text" name="search" value="{{ request('search') }}"
                        class="w-full pl-12 pr-4 py-3 rounded-xl border border-slate-200 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 placeholder-slate-400 text-sm text-slate-900 transition-colors"
                        placeholder="Cari berdasarkan kode, nama, PIC, atau kategori...">
                </div>
                <button type="submit" class="inline-flex items-center justify-center gap-2 px-6 py-3 bg-gradient-to-r from-slate-900 to-blue-900 hover:from-slate-800 hover:to-blue-800 text-white rounded-xl text-sm font-bold shadow-sm shadow-blue-900/20 transition hover:-translate-y-0.5">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                    <span>Cari Data</span>
                </button>
                @if(request('search'))
                    <a href="{{ request()->fullUrlWithQuery(['search' => null]) }}" class="inline-flex items-center justify-center px-6 py-3 bg-slate-100 text-slate-600 rounded-xl text-sm font-bold hover:bg-slate-200 transition">Reset</a>
                @endif
            </form>
            @if(request('search'))
                <p class="text-xs text-blue-700 mt-3">Hasil pencarian: <strong>"{{ request('search') }}"</strong></p>
            @endif
        </div>
`;

const tabFilterRegex = /\{\{-- Tab Filter Status Registrasi --\}\}/;
content = content.replace(tabFilterRegex, searchSection + '\n        {{-- Tab Filter Status Registrasi --}}');

fs.writeFileSync(vendorIndexPath, content, 'utf8');
console.log('Vendor Index Updated.');
