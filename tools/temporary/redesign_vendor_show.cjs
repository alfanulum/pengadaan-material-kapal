const fs = require('fs');
const path = require('path');

const showPath = path.join(__dirname, 'resources', 'views', 'supply-chain', 'vendors', 'show.blade.php');
let content = fs.readFileSync(showPath, 'utf8');

const heroReplacement = `
        {{-- Hero Banner --}}
        <div class="bg-white rounded-2xl p-8 md:p-10 shadow-sm border border-slate-200 mb-8 flex flex-col lg:flex-row gap-8 items-center justify-between">
            <div class="flex-1">
                <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-lg bg-blue-50 border border-blue-100 text-blue-700 text-xs font-bold mb-4 shadow-sm">
                    <span class="w-1.5 h-1.5 rounded-full bg-blue-500"></span>
                    {{ $vendor->kode_vendor }}
                </div>

                <h3 class="text-3xl md:text-4xl font-extrabold mb-2 tracking-tight text-slate-900">
                    {{ $vendor->nama_vendor }}
                </h3>

                <p class="text-slate-600 text-sm md:text-base leading-relaxed max-w-2xl">
                    {{ $vendor->kategori ?? 'Kategori belum diisi' }}
                </p>
            </div>

            <div class="flex flex-col gap-3 items-end shrink-0">
                {{-- Badge status aktif/nonaktif --}}
                @if ($vendor->status == 'aktif')
                    <span class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-700 text-sm font-bold shadow-sm">
                        <span class="w-2 h-2 rounded-full bg-emerald-500"></span> Vendor Aktif
                    </span>
                @else
                    <span class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl bg-rose-50 border border-rose-200 text-rose-700 text-sm font-bold shadow-sm">
                        <span class="w-2 h-2 rounded-full bg-rose-500"></span> Vendor Nonaktif
                    </span>
                @endif

                {{-- Badge status registrasi --}}
                @if ($regStatus === 'menunggu')
                    <span class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl bg-amber-50 border border-amber-200 text-amber-700 text-sm font-bold shadow-sm">
                        ?3 Menunggu Verifikasi
                    </span>
                @elseif ($regStatus === 'disetujui')
                    <span class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl bg-blue-50 border border-blue-200 text-blue-700 text-sm font-bold shadow-sm">
                        o. Registrasi Disetujui
                    </span>
                @elseif ($regStatus === 'ditolak')
                    <span class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl bg-slate-100 border border-slate-300 text-slate-700 text-sm font-bold shadow-sm">
                        ?O Registrasi Ditolak
                    </span>
                @endif
            </div>
        </div>`;

const heroRegex = /\{\{-- Hero Banner --\}\}[\s\S]*?<\/div>\s*<\/div>\s*<\/div>/;
content = content.replace(heroRegex, heroReplacement);

fs.writeFileSync(showPath, content, 'utf8');
console.log('Vendor Show Updated.');
