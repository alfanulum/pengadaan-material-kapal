const fs = require('fs');
const path = require('path');

// 1. Material Requests Detail
const mrPath = path.join(__dirname, 'resources', 'views', 'supply-chain', 'material-requests', 'show.blade.php');
let mrContent = fs.readFileSync(mrPath, 'utf8');

// Remove Hero completely
const mrHeroRegex = /\{\{-- Hero --\}\}[\s\S]*?<\/div>\s*<\/div>\s*<\/div>/;
mrContent = mrContent.replace(mrHeroRegex, '');

// Remove Ringkasan (Status Pengajuan dark blue card)
const mrRingkasanRegex = /\{\{-- Ringkasan --\}\}[\s\S]*?<\/div>\s*<\/div>\s*<\/div>/;
mrContent = mrContent.replace(mrRingkasanRegex, '');

fs.writeFileSync(mrPath, mrContent, 'utf8');


// 2. Tenders Detail
const tenderPath = path.join(__dirname, 'resources', 'views', 'supply-chain', 'tenders', 'show.blade.php');
let tenderContent = fs.readFileSync(tenderPath, 'utf8');

// Remove Hero
const tenderHeroRegex = /\{\{-- Hero --\}\}[\s\S]*?<\/div>\s*<\/div>\s*<\/div>/;
tenderContent = tenderContent.replace(tenderHeroRegex, '');

// Fix Vendor yang diundang (tampilkan 3 scroll)
// Wrapping the inner flex div with max-h and scroll
const vendorListRegex = /<div class="mt-6 flex flex-col gap-4">([\s\S]*?@forelse[\s\S]*?@endforelse\s*)<\/div>/;
if (tenderContent.match(vendorListRegex)) {
    tenderContent = tenderContent.replace(vendorListRegex, '<div class="mt-6 flex flex-col gap-4 max-h-[300px] overflow-y-auto pr-2 custom-scrollbar">$1</div>');
} else {
    // try finding just the space-y-3 block
    const altVendorRegex = /<div class="mt-4 space-y-3">([\s\S]*?@forelse[\s\S]*?@endforelse\s*)<\/div>/;
    if (tenderContent.match(altVendorRegex)) {
        tenderContent = tenderContent.replace(altVendorRegex, '<div class="mt-4 space-y-3 max-h-[250px] overflow-y-auto pr-2 custom-scrollbar">$1</div>');
    }
}

fs.writeFileSync(tenderPath, tenderContent, 'utf8');


// 3. Goods Receipt Detail
const grPath = path.join(__dirname, 'resources', 'views', 'supply-chain', 'goods-receipt-reports', 'show.blade.php');
let grContent = fs.readFileSync(grPath, 'utf8');

// Remove Hero
const grHeroRegex = /\{\{-- ============================================================\s*HERO\s*============================================================ --\}\}[\s\S]*?<\/div>\s*<\/div>\s*<\/div>/;
grContent = grContent.replace(grHeroRegex, '');

// Remove badges, just text for condition
const grKondisiRegex = /@php\s*\$kondisiClass = match\(\$r->kondisi_barang\)[\s\S]*?<\/span>/;
grContent = grContent.replace(grKondisiRegex, '<span class="font-bold text-slate-900">{{ $r->kondisi_label }}</span>');

const grStatusRegex = /<span class="inline-flex px-3 py-1 rounded-full text-xs font-bold bg-\{\{ \$r->status_color \}\}-100 text-\{\{ \$r->status_color \}\}-700 border border-\{\{ \$r->status_color \}\}-200">[\s\S]*?<\/span>/;
if (grContent.match(grStatusRegex)) {
    grContent = grContent.replace(grStatusRegex, '<span class="font-bold text-slate-900">{{ $r->status_label }}</span>');
}

// Another check for generic status badge
const grStatusGenRegex = /<span class="inline-flex items-center gap-1\.5 px-3 py-1 rounded-full text-xs font-bold \w+-\w+-\w+ \w+-\w+-\w+">[\s\S]*?\{\{ \$r->status_label \}\}?\s*<\/span>/g;
grContent = grContent.replace(grStatusGenRegex, '<span class="font-bold text-slate-900">{{ $r->status_label }}</span>');

fs.writeFileSync(grPath, grContent, 'utf8');


// 4. Purchase Orders Detail
const poPath = path.join(__dirname, 'resources', 'views', 'supply-chain', 'purchase-orders', 'show.blade.php');
let poContent = fs.readFileSync(poPath, 'utf8');

// Remove Hero
const poHeroRegex = /<div class="bg-gradient-to-br from-slate-900 to-blue-900 rounded-3xl p-8 md:p-10 shadow-xl text-white mb-8 overflow-hidden relative">[\s\S]*?<\/div>\s*<\/div>\s*<\/div>/;
poContent = poContent.replace(poHeroRegex, '');

fs.writeFileSync(poPath, poContent, 'utf8');

console.log('All 4 details updated.');
