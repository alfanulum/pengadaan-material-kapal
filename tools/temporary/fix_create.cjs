const fs = require('fs');
const path = require('path');

const tenderCreatePath = path.join(__dirname, 'resources', 'views', 'supply-chain', 'tenders', 'create.blade.php');
let content = fs.readFileSync(tenderCreatePath, 'utf8');

// 1. Remove the left sidebar (Kiri)
const kiriRegex = /\{\{-- Kiri --\}\}[\s\S]*?<\/div>\s*<\/div>/;
content = content.replace(kiriRegex, '');

// 2. Change the layout grid to a centered max-w container
const gridRegex = /<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">/;
content = content.replace(gridRegex, '<div class="max-w-4xl mx-auto">');

// 3. Remove the lg:col-span-2 wrapper from Form
const formWrapperRegex = /\{\{-- Form --\}\}\s*<div class="lg:col-span-2">/;
content = content.replace(formWrapperRegex, '{{-- Form --}}');
// Now we need to remove the closing </div> of that lg:col-span-2.
// Let's just remove the first </div> that closes it.
// Actually, it's safer to do this with string replacement precisely.
// Let's replace the whole grid and form setup.

const formRegex = /<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">\s*\{\{-- Form --\}\}\s*<div class="lg:col-span-2">/;
// Wait, after step 1, the Kiri is gone, so it looks like:
// <div class="max-w-4xl mx-auto">
//
//      {{-- Form --}}
//      <div class="lg:col-span-2">
//          <div class="bg-white rounded-3xl ...">
content = content.replace(/<div class="max-w-4xl mx-auto">\s*\{\{-- Form --\}\}\s*<div class="lg:col-span-2">/, '<div class="max-w-4xl mx-auto">\n{{-- Form --}}');
// Then the last </div> before @endsection or </x-app-layout> needs to be removed.
content = content.replace(/<\/div>\s*<\/div>\s*<\/x-app-layout>/, '</div>\n</x-app-layout>');

// 4. Update the Back Button in header
const backRegex = /<a href="\{\{ route\('supply-chain\.material-requests\.show', \$materialRequest->id\) \}\}"[\s\S]*?Kembali ke Detail Pengajuan[\s\S]*?<\/a>/;
const modernBackButton = `
            <a href="{{ route('supply-chain.material-requests.show', $materialRequest->id) }}"
                class="inline-flex items-center gap-2 px-5 py-2.5 bg-white border border-slate-200 hover:bg-slate-50 text-slate-700 rounded-xl text-sm font-semibold shadow-sm transition hover:-translate-y-0.5">
                <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                <span>Kembali</span>
            </a>`;
content = content.replace(backRegex, modernBackButton);

fs.writeFileSync(tenderCreatePath, content, 'utf8');

console.log('Tender Create page updated.');
