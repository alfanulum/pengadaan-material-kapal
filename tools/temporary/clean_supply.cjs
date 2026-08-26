const fs = require('fs');
const path = require('path');

function walk(dir, callback) {
    fs.readdirSync(dir).forEach(f => {
        let dirPath = path.join(dir, f);
        let isDirectory = fs.statSync(dirPath).isDirectory();
        isDirectory ? walk(dirPath, callback) : callback(path.join(dir, f));
    });
}

const targetDir = path.join(__dirname, 'resources', 'views', 'supply-chain');

const badClasses = [
    { regex: /bg-gradient-to-r from-slate-950 via-blue-950 to-blue-800/g, replacement: 'bg-gradient-to-br from-slate-900 to-blue-900' },
    { regex: /<div class="absolute[^>]*blur-3xl[^>]*><\/div>\s*/g, replacement: '' },
    { regex: /bg-blue-600 hover:bg-blue-700 text-white/g, replacement: 'bg-gradient-to-r from-slate-900 to-blue-900 hover:from-slate-800 hover:to-blue-800 text-white' },
    { regex: /bg-blue-900 hover:bg-blue-950 text-white/g, replacement: 'bg-gradient-to-r from-slate-900 to-blue-900 hover:from-slate-800 hover:to-blue-800 text-white' },
    { regex: /bg-indigo-600 hover:bg-indigo-700 text-white/g, replacement: 'bg-gradient-to-r from-slate-900 to-blue-900 hover:from-slate-800 hover:to-blue-800 text-white' },
];

walk(targetDir, (filePath) => {
    if (!filePath.endsWith('.blade.php')) return;

    let content = fs.readFileSync(filePath, 'utf8');
    let original = content;

    for (let rule of badClasses) {
        content = content.replace(rule.regex, rule.replacement);
    }

    if (content !== original) {
        fs.writeFileSync(filePath, content, 'utf8');
        console.log('Updated: ' + filePath);
    }
});
