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
    { regex: /bg-blue-900 text-white/g, replacement: 'bg-gradient-to-r from-slate-900 to-blue-900 text-white' },
    { regex: /hover:bg-blue-950/g, replacement: 'hover:from-slate-800 hover:to-blue-800 hover:shadow-lg' }
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
