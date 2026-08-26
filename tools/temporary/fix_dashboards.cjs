const fs = require('fs');
const path = require('path');

const replaceHero = (filePath, regex, replacement) => {
    let content = fs.readFileSync(filePath, 'utf8');
    content = content.replace(regex, replacement);
    fs.writeFileSync(filePath, content, 'utf8');
};

const viewsDir = path.join(__dirname, 'resources', 'views', 'dashboards');

// 1. Engineer Dashboard
const engPath = path.join(viewsDir, 'engineer.blade.php');
const engRegex = /<div class="bg-white rounded-2xl p-8 md:p-10 shadow-sm border border-slate-200 mb-8 relative overflow-hidden group">[\s\S]*?<div class="absolute bottom-0 left-0 w-64 h-64 bg-indigo-50 rounded-full blur-3xl opacity-60 translate-y-1\/2 -translate-x-1\/2 group-hover:scale-110 transition-transform duration-700 pointer-events-none"><\/div>\s*<div class="relative z-10 max-w-3xl">/m;
const engReplacement = `<div class="bg-white rounded-2xl p-8 md:p-10 shadow-sm border border-slate-200 mb-8 flex flex-col lg:flex-row gap-8 items-center justify-between">
            <div class="max-w-3xl">`;
replaceHero(engPath, engRegex, engReplacement);

// 2. Planner Dashboard
const planPath = path.join(viewsDir, 'planner.blade.php');
const planRegex = /<div class="bg-white rounded-2xl p-8 md:p-10 shadow-sm border border-slate-200 mb-8 relative overflow-hidden group flex flex-col md:flex-row items-center justify-between gap-6">\s*<!-- Decorative background elements -->\s*<div class="absolute -right-20 -top-20 w-64 h-64 bg-indigo-50 rounded-full blur-3xl opacity-80 pointer-events-none group-hover:scale-110 transition-transform duration-700"><\/div>\s*<div class="absolute -left-20 -bottom-20 w-64 h-64 bg-blue-50 rounded-full blur-3xl opacity-80 pointer-events-none group-hover:scale-110 transition-transform duration-700"><\/div>\s*<div class="relative z-10 max-w-2xl">/m;
const planReplacement = `<div class="bg-white rounded-2xl p-8 md:p-10 shadow-sm border border-slate-200 mb-8 flex flex-col lg:flex-row items-center justify-between gap-6">
            <div class="max-w-2xl">`;
replaceHero(planPath, planRegex, planReplacement);

// 3. Gudang Dashboard
const gudPath = path.join(viewsDir, 'gudang.blade.php');
const gudRegex = /<div class="relative overflow-hidden rounded-3xl bg-gradient-to-r from-slate-950 via-blue-950 to-blue-800 p-8 md:p-10 shadow-xl text-white">\s*<div class="absolute -top-24 -right-24 w-80 h-80 bg-cyan-400\/20 rounded-full blur-3xl"><\/div>\s*<div class="absolute -bottom-24 -left-24 w-80 h-80 bg-blue-400\/20 rounded-full blur-3xl"><\/div>\s*<div class="absolute top-6 right-6 opacity-10">\s*<svg class="w-40 h-40" fill="currentColor" viewBox="0 0 24 24"><path d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"\/><\/svg>\s*<\/div>\s*<div class="relative z-10 grid grid-cols-1 lg:grid-cols-2 gap-8 items-center">\s*<div>\s*<p class="inline-flex px-4 py-2 rounded-full bg-white\/10 border border-white\/10 text-sm text-blue-100 mb-5">/m;
const gudReplacement = `<div class="bg-white rounded-2xl p-8 md:p-10 shadow-sm border border-slate-200 flex flex-col lg:flex-row gap-8 items-center justify-between">
                <div class="max-w-3xl">
                    <p class="inline-flex px-4 py-2 rounded-full bg-slate-100 border border-slate-200 text-sm text-slate-600 mb-5 font-medium">`;

// Read gudang and make sure the text color is dark
let gudContent = fs.readFileSync(gudPath, 'utf8');
gudContent = gudContent.replace(gudRegex, gudReplacement);
gudContent = gudContent.replace(/<h3 class="text-3xl md:text-5xl font-bold leading-tight">/, '<h3 class="text-3xl md:text-4xl font-extrabold leading-tight text-slate-900 tracking-tight">');
gudContent = gudContent.replace(/<p class="mt-5 text-blue-100 max-w-3xl text-base md:text-lg leading-relaxed">/, '<p class="mt-5 text-slate-600 max-w-3xl text-sm md:text-base leading-relaxed">');
gudContent = gudContent.replace(/class="inline-flex items-center justify-center px-7 py-4 bg-white text-blue-950 rounded-2xl font-bold shadow-lg hover:bg-slate-100 hover:-translate-y-1 transition"/, 'class="inline-flex items-center justify-center px-7 py-4 bg-gradient-to-r from-slate-900 to-blue-900 text-white rounded-xl font-bold shadow-md hover:from-slate-800 hover:to-blue-800 transition-all hover:-translate-y-0.5"');
gudContent = gudContent.replace(/<div class="bg-white\/10 border border-white\/10 rounded-3xl p-6 md:p-8">[\s\S]*?<\/div>\s*<\/div>\s*<\/div>\s*<\/div>/, '</div>\n            </div>');
fs.writeFileSync(gudPath, gudContent, 'utf8');

console.log('Update complete.');
