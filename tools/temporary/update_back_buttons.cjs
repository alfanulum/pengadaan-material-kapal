const fs = require('fs');
const path = require('path');

const viewsDir = path.join(__dirname, 'resources', 'views', 'supply-chain');

const backButtonRegex = /<a href="\{\{ route\('supply-chain\.dashboard'\) \}\}"[\s\S]*?Kembali ke Dashboard[\s\S]*?<\/a>/;
const modernBackButton = `<a href="{{ route('supply-chain.dashboard') }}"
                class="inline-flex items-center gap-2 px-5 py-2.5 bg-white border border-slate-200 hover:bg-slate-50 text-slate-700 rounded-xl text-sm font-semibold shadow-sm transition hover:-translate-y-0.5">
                <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                <span>Kembali ke Dashboard</span>
            </a>`;

const walkDir = (dir, callback) => {
    fs.readdirSync(dir).forEach(f => {
        let dirPath = path.join(dir, f);
        let isDirectory = fs.statSync(dirPath).isDirectory();
        isDirectory ? walkDir(dirPath, callback) : callback(path.join(dir, f));
    });
};

// 1. Update "Kembali ke Dashboard" on all supply chain views
walkDir(viewsDir, (filePath) => {
    if (filePath.endsWith('.blade.php')) {
        let content = fs.readFileSync(filePath, 'utf8');
        if (content.match(backButtonRegex)) {
            content = content.replace(backButtonRegex, modernBackButton);
            fs.writeFileSync(filePath, content, 'utf8');
        }
    }
});

console.log('Kembali ke dashboard buttons updated.');
