const fs = require('fs');
const path = require('path');

const vendorPath = path.join(__dirname, 'resources', 'views', 'dashboards', 'vendor.blade.php');
let vendorContent = fs.readFileSync(vendorPath, 'utf8');

const vendorReplacement = `<div class="bg-white rounded-2xl p-8 md:p-10 shadow-sm border border-slate-200 mb-8 flex flex-col lg:flex-row gap-8 items-center justify-between">
                <div class="max-w-3xl">
                    <p class="inline-flex px-4 py-2 rounded-full bg-slate-50 border border-slate-200 text-sm text-slate-600 mb-5 font-medium">
                        PT PAL Vendor Portal
                    </p>

                    <h3 class="text-3xl md:text-4xl font-extrabold mb-4 tracking-tight text-slate-900">
                        Pantau Tender & Purchase Order, <span class="text-transparent bg-clip-text bg-gradient-to-r from-slate-900 to-blue-900">{{ Auth::user()->name }}</span>
                    </h3>

                    <p class="text-slate-600 text-sm md:text-base leading-relaxed mb-8 max-w-2xl">
                        Vendor dapat membuka tender yang diterima, mengirim penawaran harga,
                        melihat Purchase Order setelah terpilih, dan menyiapkan proses pengiriman material.
                    </p>

                    <div class="flex flex-col sm:flex-row gap-4">
                        <a href="{{ route('vendor.tenders.index') }}"
                            class="inline-flex items-center justify-center px-7 py-4 bg-gradient-to-r from-slate-900 to-blue-900 text-white rounded-xl font-bold shadow-md hover:from-slate-800 hover:to-blue-800 transition-all hover:-translate-y-0.5">
                            Buka Tender Masuk
                        </a>

                        <a href="{{ route('vendor.purchase-orders.index') }}"
                            class="inline-flex items-center justify-center px-7 py-4 bg-white text-slate-700 border border-slate-300 rounded-xl font-bold shadow-sm hover:bg-slate-50 transition-all hover:-translate-y-0.5">
                            Lihat Purchase Order
                        </a>
                    </div>
                </div>
            </div>`;

// Delete the dark hero section and its inner Focus Vendor block.
const vendorRegex = /<div\s*class="bg-gradient-to-r from-slate-950 via-blue-950 to-blue-800 rounded-3xl p-8 md:p-10 shadow-xl text-white mb-8 overflow-hidden relative">[\s\S]*?<\/div>\s*<\/div>\s*<\/div>/;
vendorContent = vendorContent.replace(vendorRegex, vendorReplacement);

fs.writeFileSync(vendorPath, vendorContent, 'utf8');

console.log('Update vendor complete.');
