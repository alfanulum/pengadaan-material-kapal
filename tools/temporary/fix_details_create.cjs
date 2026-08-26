const fs = require('fs');
const path = require('path');

// Modern Back Button HTML
const modernBackButton = (route, text = 'Kembali') => `
            <a href="${route}"
                class="inline-flex items-center gap-2 px-5 py-2.5 bg-white border border-slate-200 hover:bg-slate-50 text-slate-700 rounded-xl text-sm font-semibold shadow-sm transition hover:-translate-y-0.5">
                <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                <span>${text}</span>
            </a>`;

// 1. material-requests/show.blade.php
const mrPath = path.join(__dirname, 'resources', 'views', 'supply-chain', 'material-requests', 'show.blade.php');
if (fs.existsSync(mrPath)) {
    let mrContent = fs.readFileSync(mrPath, 'utf8');
    // Delete Alur Berikutnya
    const alurRegex = /\{\{-- Alur --\}\}[\s\S]*?<\/div>\s*<\/div>\s*<\/div>/;
    mrContent = mrContent.replace(alurRegex, '');

    // Replace Back Button in header
    const mrBackRegex = /<a href="\{\{ route\('supply-chain\.material-requests\.index'\) \}\}"[\s\S]*?Kembali ke Permintaan[\s\S]*?<\/a>/;
    mrContent = mrContent.replace(mrBackRegex, modernBackButton("{{ route('supply-chain.material-requests.index') }}", 'Kembali ke Permintaan'));

    fs.writeFileSync(mrPath, mrContent, 'utf8');
}

// 2. tenders/create.blade.php
const tenderCreatePath = path.join(__dirname, 'resources', 'views', 'supply-chain', 'tenders', 'create.blade.php');
if (fs.existsSync(tenderCreatePath)) {
    let tenderCreateContent = fs.readFileSync(tenderCreatePath, 'utf8');
    
    // Delete Hero
    const tcHeroRegex = /<div\s+class="bg-gradient-to-br from-slate-900 to-blue-900 rounded-3xl p-8 md:p-10 shadow-xl text-white mb-8 overflow-hidden relative">[\s\S]*?<\/div>\s*<\/div>\s*<\/div>/;
    tenderCreateContent = tenderCreateContent.replace(tcHeroRegex, '');

    // Delete Alur Tender too, since it is basically AI slop sidebar
    const tcAlurRegex = /\{\{-- Alur --\}\}[\s\S]*?<\/div>\s*<\/div>\s*<\/div>/;
    tenderCreateContent = tenderCreateContent.replace(tcAlurRegex, '');

    // Replace Back Button in header
    const tcBackRegex = /<a href="\{\{ route\('supply-chain\.material-requests\.show', \$materialRequest->id\) \}\}"[\s\S]*?Kembali ke Permintaan[\s\S]*?<\/a>/;
    tenderCreateContent = tenderCreateContent.replace(tcBackRegex, modernBackButton("{{ route('supply-chain.material-requests.show', $materialRequest->id) }}", 'Kembali ke Permintaan'));

    fs.writeFileSync(tenderCreatePath, tenderCreateContent, 'utf8');
}

// 3. tenders/show.blade.php
const tenderShowPath = path.join(__dirname, 'resources', 'views', 'supply-chain', 'tenders', 'show.blade.php');
if (fs.existsSync(tenderShowPath)) {
    let tenderShowContent = fs.readFileSync(tenderShowPath, 'utf8');
    const tsBackRegex = /<a href="\{\{ route\('supply-chain\.tenders\.index'\) \}\}"[\s\S]*?Kembali ke Daftar[\s\S]*?<\/a>/;
    tenderShowContent = tenderShowContent.replace(tsBackRegex, modernBackButton("{{ route('supply-chain.tenders.index') }}", 'Kembali ke Daftar'));
    fs.writeFileSync(tenderShowPath, tenderShowContent, 'utf8');
}

// 4. goods-receipt-reports/show.blade.php
const grShowPath = path.join(__dirname, 'resources', 'views', 'supply-chain', 'goods-receipt-reports', 'show.blade.php');
if (fs.existsSync(grShowPath)) {
    let grShowContent = fs.readFileSync(grShowPath, 'utf8');
    const grBackRegex = /<a href="\{\{ route\('supply-chain\.goods-receipt-reports\.index'\) \}\}"[\s\S]*?Kembali ke Laporan[\s\S]*?<\/a>/;
    grShowContent = grShowContent.replace(grBackRegex, modernBackButton("{{ route('supply-chain.goods-receipt-reports.index') }}", 'Kembali ke Laporan'));
    fs.writeFileSync(grShowPath, grShowContent, 'utf8');
}

// 5. purchase-orders/show.blade.php
const poShowPath = path.join(__dirname, 'resources', 'views', 'supply-chain', 'purchase-orders', 'show.blade.php');
if (fs.existsSync(poShowPath)) {
    let poShowContent = fs.readFileSync(poShowPath, 'utf8');
    const poBackRegex = /<a href="\{\{ route\('supply-chain\.purchase-orders\.index'\) \}\}"[\s\S]*?Daftar PO[\s\S]*?<\/a>/;
    poShowContent = poShowContent.replace(poBackRegex, modernBackButton("{{ route('supply-chain.purchase-orders.index') }}", 'Kembali ke Daftar PO'));
    
    // There is another button in the header "Dashboard", we can style it too or just leave it.
    // The user said "redesain tombol kembali pada semua halaman semuanya".
    fs.writeFileSync(poShowPath, poShowContent, 'utf8');
}

// 6. monitoring/show.blade.php
const monShowPath = path.join(__dirname, 'resources', 'views', 'supply-chain', 'monitoring', 'show.blade.php');
if (fs.existsSync(monShowPath)) {
    let monShowContent = fs.readFileSync(monShowPath, 'utf8');
    const monBackRegex = /<a href="\{\{ route\('supply-chain\.monitoring\.index'\) \}\}"[\s\S]*?Kembali ke Monitoring[\s\S]*?<\/a>/;
    if (monShowContent.match(monBackRegex)) {
        monShowContent = monShowContent.replace(monBackRegex, modernBackButton("{{ route('supply-chain.monitoring.index') }}", 'Kembali ke Monitoring'));
        fs.writeFileSync(monShowPath, monShowContent, 'utf8');
    }
}

console.log('Update detail and create pages completed.');
