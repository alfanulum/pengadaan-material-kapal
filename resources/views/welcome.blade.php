<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Informasi Manajemen Supply Chain | PT XYZ</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
        .glass-card {
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }
        .animate-float {
            animation: float 6s ease-in-out infinite;
        }
        .animate-float-delayed {
            animation: float 6s ease-in-out 3s infinite;
        }
        @keyframes float {
            0% { transform: translateY(0px); }
            50% { transform: translateY(-15px); }
            100% { transform: translateY(0px); }
        }
    </style>
</head>
<body class="bg-slate-50 text-slate-800 antialiased overflow-x-hidden">

    <!-- Header -->
    <header class="bg-[#0B1120]/90 backdrop-blur-md border-b border-slate-800/80 sticky top-0 z-50 transition-all duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-20">
                <!-- Logo PT XYZ -->
                <div class="flex items-center gap-3.5">
                    <div class="w-11 h-11 bg-gradient-to-br from-blue-600 via-blue-500 to-indigo-600 flex items-center justify-center rounded-xl shadow-lg shadow-blue-500/20 ring-1 ring-white/10">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                    </div>
                    <div>
                        <h1 class="text-xl font-bold text-white tracking-tight">PT XYZ</h1>
                        <p class="text-[11px] text-slate-400 font-medium hidden sm:block">Sistem Pengadaan Material Kapal</p>
                    </div>
                </div>

                <!-- Nav Links (Removed by request) -->
                <nav class="hidden md:flex items-center gap-8">
                </nav>

                <!-- Auth / CTA -->
                <div class="flex items-center gap-4">
                    @auth
                        <a href="{{ route('dashboard') }}" class="text-sm font-medium text-slate-300 hover:text-white transition-colors hidden sm:block">Dasbor Utama</a>
                        <a href="{{ route('dashboard') }}" class="inline-flex items-center justify-center px-4 py-2.5 text-sm font-semibold rounded-lg text-white bg-blue-600 hover:bg-blue-500 shadow-md shadow-blue-600/30 ring-1 ring-blue-400/30 transition-all hover:-translate-y-0.5">
                            Buka Sistem
                            <svg class="w-4 h-4 ml-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="inline-flex items-center justify-center px-5 py-2.5 text-sm font-semibold rounded-lg text-white bg-gradient-to-r from-slate-900 to-blue-900 hover:from-slate-800 hover:to-blue-800 shadow-lg shadow-blue-600/30 ring-1 ring-white/10 transition-all hover:-translate-y-0.5">
                            Masuk Sistem
                            <svg class="w-4 h-4 ml-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path></svg>
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </header>

    <!-- Hero Section -->
    <section class="relative bg-[#0B1120] overflow-hidden">
        <!-- Background Decor -->
        <div class="absolute inset-0 z-0">
            <div class="absolute inset-0 bg-[url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNjAiIGhlaWdodD0iNjAiIHZpZXdCb3g9IjAgMCA2MCA2MCIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj48ZyBmaWxsPSJub25lIiBmaWxsLXJ1bGU9ImV2ZW5vZGQiPjxnIGZpbGw9IiMzMzQxNTUiIGZpbGwtb3BhY2l0eT0iMC4xIj48cGF0aCBkPSJNMzYgMzRoMTJ2MTJIMzZ6Ii8+PC9nPjwvZz48L3N2Zz4=')] opacity-20"></div>
            <div class="absolute top-0 right-0 -translate-y-12 translate-x-1/3 w-[800px] h-[800px] bg-blue-600/20 rounded-full blur-[120px]"></div>
            <div class="absolute bottom-0 left-0 translate-y-1/3 -translate-x-1/3 w-[600px] h-[600px] bg-indigo-600/20 rounded-full blur-[120px]"></div>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 py-20 lg:py-32">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">
                <div>
                    <h2 class="text-4xl sm:text-5xl lg:text-6xl font-extrabold text-white leading-[1.1] mb-6 tracking-tight">
                        Sistem Informasi Manajemen <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-400 to-indigo-400">Supply Chain</span> Pengadaan Material Kapal
                    </h2>
                    <p class="text-lg text-slate-400 mb-10 max-w-xl leading-relaxed">
                        Platform terintegrasi untuk mengelola proses pengadaan material kapal mulai dari pengajuan kebutuhan hingga penerimaan material dengan standar industri maritim.
                    </p>
                    <div class="flex flex-wrap gap-4">
                        <a href="{{ route('login') }}" class="inline-flex items-center justify-center px-8 py-4 text-base font-semibold rounded-xl text-white bg-blue-600 hover:bg-blue-500 shadow-[0_0_20px_rgba(37,99,235,0.4)] transition-all hover:-translate-y-1">
                            Masuk Sistem
                            <svg class="w-5 h-5 ml-2 -mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                        </a>
                        <a href="#alur" class="inline-flex items-center justify-center px-8 py-4 text-base font-semibold rounded-xl text-slate-300 bg-white/5 hover:bg-white/10 border border-slate-700 transition-all hover:-translate-y-1 backdrop-blur-sm">
                            Pelajari Alur
                        </a>
                    </div>
                </div>
                <div class="relative hidden lg:block h-[500px]">
                    <!-- Floating Dashboard Elements (Data Aktual) -->
                    <div class="absolute inset-0 flex items-center justify-center">
                        
                        <!-- Main Dashboard Card -->
                        <div class="glass-card rounded-2xl p-6 w-[450px] shadow-2xl relative z-20 animate-float border-slate-700/50 bg-slate-800/80">
                            <div class="flex justify-between items-center mb-6">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-lg bg-blue-500/20 flex items-center justify-center text-blue-400">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>
                                    </div>
                                    <div>
                                        <h4 class="text-white font-semibold text-sm">Total Pengadaan Aktif</h4>
                                        <p class="text-slate-400 text-xs">Pembaruan langsung (Total: {{ $mr_total }})</p>
                                    </div>
                                </div>
                                <span class="bg-emerald-500/20 text-emerald-400 text-xs font-bold px-2.5 py-1 rounded-md">Live</span>
                            </div>
                            <div class="space-y-4">
                                <!-- Progress bars -->
                                <div>
                                    <div class="flex justify-between text-xs mb-1"><span class="text-slate-300">Pengajuan Kebutuhan (MR)</span><span class="text-blue-400">{{ $mr_percent }}%</span></div>
                                    <div class="w-full bg-slate-700 rounded-full h-1.5"><div class="bg-blue-500 h-1.5 rounded-full" style="width: {{ $mr_percent }}%"></div></div>
                                </div>
                                <div>
                                    <div class="flex justify-between text-xs mb-1"><span class="text-slate-300">Proses Tender</span><span class="text-indigo-400">{{ $tender_percent }}%</span></div>
                                    <div class="w-full bg-slate-700 rounded-full h-1.5"><div class="bg-indigo-500 h-1.5 rounded-full" style="width: {{ $tender_percent }}%"></div></div>
                                </div>
                                <div>
                                    <div class="flex justify-between text-xs mb-1"><span class="text-slate-300">Purchase Order (PO)</span><span class="text-purple-400">{{ $po_percent }}%</span></div>
                                    <div class="w-full bg-slate-700 rounded-full h-1.5"><div class="bg-purple-500 h-1.5 rounded-full" style="width: {{ $po_percent }}%"></div></div>
                                </div>
                            </div>
                        </div>

                        <!-- Small Floating Card 1 (PO Status) -->
                        @if($po_latest)
                        <div class="glass-card rounded-xl p-4 w-[220px] absolute -right-4 top-10 z-30 animate-float-delayed border-slate-700/50 bg-slate-800/90 shadow-xl">
                            <div class="flex items-center gap-3 mb-2">
                                <div class="w-8 h-8 rounded-full bg-amber-500/20 flex items-center justify-center text-amber-400">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                </div>
                                <div>
                                    <p class="text-white text-xs font-bold">{{ $po_latest->kode_po }}</p>
                                    <p class="text-slate-400 text-[10px]">{{ ucwords(str_replace('_', ' ', $po_latest->status)) }}</p>
                                </div>
                            </div>
                        </div>
                        @endif

                        <!-- Small Floating Card 2 (Vessel/Shipment) -->
                        @if($gr_latest)
                        <div class="glass-card rounded-xl p-4 w-[240px] absolute -left-10 bottom-10 z-30 animate-float border-slate-700/50 bg-slate-800/90 shadow-xl" style="animation-delay: 1.5s;">
                            <div class="flex gap-3">
                                <div class="w-12 h-12 rounded bg-indigo-500/20 flex items-center justify-center flex-shrink-0 text-indigo-400">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"></path></svg>
                                </div>
                                <div>
                                    <h5 class="text-white text-xs font-bold mb-1">Penerimaan Gudang</h5>
                                    <p class="text-slate-400 text-[10px] leading-tight">PO {{ $gr_latest->purchaseOrder->kode_po ?? 'terbaru' }} telah diterima.</p>
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Procurement Workflow (Timeline) -->
    <section id="alur" class="py-24 bg-white relative">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h3 class="text-3xl font-bold text-slate-900 mb-4">Alur Pengadaan Material Terintegrasi</h3>
                <p class="text-slate-600 max-w-2xl mx-auto text-lg">Proses terpadu dari awal hingga akhir untuk memastikan efisiensi, transparansi, dan ketepatan waktu dalam rantai pasok industri maritim.</p>
            </div>
            
            <div class="relative max-w-5xl mx-auto mt-12">
                <!-- Connecting Line -->
                <div class="hidden md:block absolute top-12 left-[10%] right-[10%] h-1 bg-gradient-to-r from-blue-100 via-blue-500 to-indigo-100 rounded-full z-0"></div>
                
                <div class="grid grid-cols-1 md:grid-cols-5 gap-8 relative z-10">
                    <!-- Step 1 -->
                    <div class="group flex flex-col items-center text-center cursor-pointer">
                        <div class="w-24 h-24 bg-white rounded-2xl shadow-lg border border-slate-100 flex items-center justify-center mb-6 group-hover:-translate-y-2 group-hover:shadow-blue-200 transition-all duration-300 relative z-10">
                            <div class="w-16 h-16 bg-blue-50 rounded-xl flex items-center justify-center text-blue-600 group-hover:bg-blue-600 group-hover:text-white transition-colors duration-300">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                            </div>
                        </div>
                        <h4 class="font-bold text-slate-900 text-lg mb-2">1. Engineer</h4>
                        <p class="text-sm text-slate-500">Pengajuan kebutuhan material kapal</p>
                    </div>
                    <!-- Step 2 -->
                    <div class="group flex flex-col items-center text-center cursor-pointer">
                        <div class="w-24 h-24 bg-white rounded-2xl shadow-lg border border-slate-100 flex items-center justify-center mb-6 group-hover:-translate-y-2 group-hover:shadow-blue-200 transition-all duration-300 relative z-10">
                            <div class="w-16 h-16 bg-blue-50 rounded-xl flex items-center justify-center text-blue-600 group-hover:bg-blue-600 group-hover:text-white transition-colors duration-300">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path></svg>
                            </div>
                        </div>
                        <h4 class="font-bold text-slate-900 text-lg mb-2">2. Planner</h4>
                        <p class="text-sm text-slate-500">Verifikasi & persetujuan kebutuhan</p>
                    </div>
                    <!-- Step 3 -->
                    <div class="group flex flex-col items-center text-center cursor-pointer">
                        <div class="w-24 h-24 bg-white rounded-2xl shadow-lg border border-slate-100 flex items-center justify-center mb-6 group-hover:-translate-y-2 group-hover:shadow-indigo-200 transition-all duration-300 relative z-10">
                            <div class="w-16 h-16 bg-indigo-50 rounded-xl flex items-center justify-center text-indigo-600 group-hover:bg-indigo-600 group-hover:text-white transition-colors duration-300">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                            </div>
                        </div>
                        <h4 class="font-bold text-slate-900 text-lg mb-2">3. Supply Chain</h4>
                        <p class="text-sm text-slate-500">Tender & Purchase Order</p>
                    </div>
                    <!-- Step 4 -->
                    <div class="group flex flex-col items-center text-center cursor-pointer">
                        <div class="w-24 h-24 bg-white rounded-2xl shadow-lg border border-slate-100 flex items-center justify-center mb-6 group-hover:-translate-y-2 group-hover:shadow-indigo-200 transition-all duration-300 relative z-10">
                            <div class="w-16 h-16 bg-indigo-50 rounded-xl flex items-center justify-center text-indigo-600 group-hover:bg-indigo-600 group-hover:text-white transition-colors duration-300">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                            </div>
                        </div>
                        <h4 class="font-bold text-slate-900 text-lg mb-2">4. Vendor</h4>
                        <p class="text-sm text-slate-500">Penawaran & pengiriman material</p>
                    </div>
                    <!-- Step 5 -->
                    <div class="group flex flex-col items-center text-center cursor-pointer">
                        <div class="w-24 h-24 bg-white rounded-2xl shadow-lg border border-slate-100 flex items-center justify-center mb-6 group-hover:-translate-y-2 group-hover:shadow-blue-200 transition-all duration-300 relative z-10">
                            <div class="w-16 h-16 bg-blue-50 rounded-xl flex items-center justify-center text-blue-600 group-hover:bg-blue-600 group-hover:text-white transition-colors duration-300">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                            </div>
                        </div>
                        <h4 class="font-bold text-slate-900 text-lg mb-2">5. Gudang</h4>
                        <p class="text-sm text-slate-500">Penerimaan material fisik</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Main Modules -->
    <section id="modul" class="py-24 bg-slate-50 relative border-t border-slate-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row justify-between items-end mb-12 gap-6">
                <div>
                    <h3 class="text-3xl font-bold text-slate-900 mb-4">Modul Utama Sistem</h3>
                    <p class="text-slate-600 text-lg max-w-2xl">Fitur komprehensif untuk mendukung seluruh kegiatan manajemen material kapal.</p>
                </div>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Module 1 -->
                <div class="bg-white rounded-2xl p-8 shadow-sm hover:shadow-xl border border-slate-200 hover:border-blue-300 transition-all duration-300 group relative overflow-hidden">
                    <div class="absolute top-0 right-0 w-24 h-24 bg-gradient-to-bl from-blue-100 to-transparent opacity-50 rounded-bl-full transform translate-x-12 -translate-y-12 group-hover:translate-x-0 group-hover:translate-y-0 transition-transform duration-500"></div>
                    <div class="w-14 h-14 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center mb-6 group-hover:bg-blue-600 group-hover:text-white transition-colors duration-300">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    </div>
                    <h4 class="text-xl font-bold text-slate-900 mb-3">Pengajuan Kebutuhan (MR)</h4>
                    <p class="text-slate-600">Pengelolaan pengajuan kebutuhan material dengan alur persetujuan terstruktur dan pelacakan status.</p>
                </div>
                
                <!-- Module 2 -->
                <div class="bg-white rounded-2xl p-8 shadow-sm hover:shadow-xl border border-slate-200 hover:border-indigo-300 transition-all duration-300 group relative overflow-hidden">
                    <div class="absolute top-0 right-0 w-24 h-24 bg-gradient-to-bl from-indigo-100 to-transparent opacity-50 rounded-bl-full transform translate-x-12 -translate-y-12 group-hover:translate-x-0 group-hover:translate-y-0 transition-transform duration-500"></div>
                    <div class="w-14 h-14 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center mb-6 group-hover:bg-indigo-600 group-hover:text-white transition-colors duration-300">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 6l3 1m0 0l-3 9a5.002 5.002 0 006.001 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5.002 5.002 0 006.001 0M18 7l3 9m-3-9l-6-2m0-2v2m0 16V5m0 16H9m3 0h3"></path></svg>
                    </div>
                    <h4 class="text-xl font-bold text-slate-900 mb-3">Manajemen Tender</h4>
                    <p class="text-slate-600">Fasilitas pengadaan kompetitif, evaluasi penawaran Vendor, dan transparansi proses tender.</p>
                </div>
                
                <!-- Module 3 -->
                <div class="bg-white rounded-2xl p-8 shadow-sm hover:shadow-xl border border-slate-200 hover:border-purple-300 transition-all duration-300 group relative overflow-hidden">
                    <div class="absolute top-0 right-0 w-24 h-24 bg-gradient-to-bl from-purple-100 to-transparent opacity-50 rounded-bl-full transform translate-x-12 -translate-y-12 group-hover:translate-x-0 group-hover:translate-y-0 transition-transform duration-500"></div>
                    <div class="w-14 h-14 rounded-xl bg-purple-50 text-purple-600 flex items-center justify-center mb-6 group-hover:bg-purple-600 group-hover:text-white transition-colors duration-300">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                    </div>
                    <h4 class="text-xl font-bold text-slate-900 mb-3">Manajemen Vendor</h4>
                    <p class="text-slate-600">Basis data rekanan perusahaan, evaluasi kinerja, verifikasi legalitas, dan komunikasi langsung.</p>
                </div>
                
                <!-- Module 4 -->
                <div class="bg-white rounded-2xl p-8 shadow-sm hover:shadow-xl border border-slate-200 hover:border-blue-300 transition-all duration-300 group relative overflow-hidden">
                    <div class="absolute top-0 right-0 w-24 h-24 bg-gradient-to-bl from-blue-100 to-transparent opacity-50 rounded-bl-full transform translate-x-12 -translate-y-12 group-hover:translate-x-0 group-hover:translate-y-0 transition-transform duration-500"></div>
                    <div class="w-14 h-14 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center mb-6 group-hover:bg-blue-600 group-hover:text-white transition-colors duration-300">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    </div>
                    <h4 class="text-xl font-bold text-slate-900 mb-3">Manajemen Purchase Order</h4>
                    <p class="text-slate-600">Penerbitan dokumen Purchase Order resmi, manajemen adendum, dan rekam jejak pesanan.</p>
                </div>
                
                <!-- Module 5 -->
                <div class="bg-white rounded-2xl p-8 shadow-sm hover:shadow-xl border border-slate-200 hover:border-teal-300 transition-all duration-300 group relative overflow-hidden">
                    <div class="absolute top-0 right-0 w-24 h-24 bg-gradient-to-bl from-teal-100 to-transparent opacity-50 rounded-bl-full transform translate-x-12 -translate-y-12 group-hover:translate-x-0 group-hover:translate-y-0 transition-transform duration-500"></div>
                    <div class="w-14 h-14 rounded-xl bg-teal-50 text-teal-600 flex items-center justify-center mb-6 group-hover:bg-teal-600 group-hover:text-white transition-colors duration-300">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                    </div>
                    <h4 class="text-xl font-bold text-slate-900 mb-3">Pemantauan Pengiriman</h4>
                    <p class="text-slate-600">Pemantauan estimasi kedatangan (ETA) dan status pengiriman material secara langsung.</p>
                </div>
                
                <!-- Module 6 -->
                <div class="bg-white rounded-2xl p-8 shadow-sm hover:shadow-xl border border-slate-200 hover:border-emerald-300 transition-all duration-300 group relative overflow-hidden">
                    <div class="absolute top-0 right-0 w-24 h-24 bg-gradient-to-bl from-emerald-100 to-transparent opacity-50 rounded-bl-full transform translate-x-12 -translate-y-12 group-hover:translate-x-0 group-hover:translate-y-0 transition-transform duration-500"></div>
                    <div class="w-14 h-14 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center mb-6 group-hover:bg-emerald-600 group-hover:text-white transition-colors duration-300">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"></path></svg>
                    </div>
                    <h4 class="text-xl font-bold text-slate-900 mb-3">Penerimaan Barang (GR)</h4>
                    <p class="text-slate-600">Pemeriksaan kualitas fisik barang (QC), dokumen penerimaan (GR), dan pencatatan inventaris gudang.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- User Roles -->
    <section id="akses" class="py-24 bg-[#0B1120] relative border-t border-slate-800 overflow-hidden">
        <!-- Abstract shape -->
        <div class="absolute right-0 top-0 w-96 h-96 bg-blue-900/20 rounded-full blur-3xl transform translate-x-1/2 -translate-y-1/2"></div>
        <div class="absolute left-0 bottom-0 w-96 h-96 bg-indigo-900/20 rounded-full blur-3xl transform -translate-x-1/2 translate-y-1/2"></div>
        
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="mb-16 text-center">
                <h3 class="text-3xl font-bold text-white mb-4">Akses & Hak Pengguna</h3>
                <p class="text-slate-400 max-w-2xl mx-auto text-lg">Keamanan dan integritas data terjamin melalui sistem otorisasi berbasis peran.</p>
            </div>
            
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-6">
                <!-- Role Card -->
                <div class="glass-card rounded-2xl p-6 flex flex-col items-center text-center hover:bg-white/10 transition-colors cursor-default border border-slate-700/50">
                    <div class="w-16 h-16 rounded-full bg-slate-800 border border-slate-700 flex items-center justify-center mb-4 text-slate-300">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                    </div>
                    <h4 class="font-bold text-white text-lg mb-1">Engineer</h4>
                    <p class="text-sm text-blue-400 font-medium">Inisiator Kebutuhan</p>
                </div>
                <!-- Role Card -->
                <div class="glass-card rounded-2xl p-6 flex flex-col items-center text-center hover:bg-white/10 transition-colors cursor-default border border-slate-700/50">
                    <div class="w-16 h-16 rounded-full bg-slate-800 border border-slate-700 flex items-center justify-center mb-4 text-slate-300">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                    </div>
                    <h4 class="font-bold text-white text-lg mb-1">Planner</h4>
                    <p class="text-sm text-indigo-400 font-medium">Verifikator Anggaran</p>
                </div>
                <!-- Role Card -->
                <div class="glass-card rounded-2xl p-6 flex flex-col items-center text-center hover:bg-white/10 transition-colors cursor-default border border-slate-700/50">
                    <div class="w-16 h-16 rounded-full bg-slate-800 border border-slate-700 flex items-center justify-center mb-4 text-slate-300">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                    </div>
                    <h4 class="font-bold text-white text-lg mb-1">Supply Chain</h4>
                    <p class="text-sm text-purple-400 font-medium">Eksekutor Pengadaan</p>
                </div>
                <!-- Role Card -->
                <div class="glass-card rounded-2xl p-6 flex flex-col items-center text-center hover:bg-white/10 transition-colors cursor-default border border-slate-700/50">
                    <div class="w-16 h-16 rounded-full bg-slate-800 border border-slate-700 flex items-center justify-center mb-4 text-slate-300">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                    </div>
                    <h4 class="font-bold text-white text-lg mb-1">Vendor</h4>
                    <p class="text-sm text-teal-400 font-medium">Mitra Penyedia</p>
                </div>
                <!-- Role Card -->
                <div class="glass-card rounded-2xl p-6 flex flex-col items-center text-center hover:bg-white/10 transition-colors cursor-default border border-slate-700/50">
                    <div class="w-16 h-16 rounded-full bg-slate-800 border border-slate-700 flex items-center justify-center mb-4 text-slate-300">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"></path></svg>
                    </div>
                    <h4 class="font-bold text-white text-lg mb-1">Gudang</h4>
                    <p class="text-sm text-emerald-400 font-medium">Penerima Material</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-[#060913] border-t border-slate-800/80 relative">
        <!-- Top Accent Glow Line -->
        <div class="h-[1px] w-full bg-gradient-to-r from-transparent via-blue-500/40 to-transparent"></div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="flex flex-col md:flex-row justify-between items-center gap-6">
                <!-- Brand & Description -->
                <div class="flex items-center gap-3.5">
                    <div class="w-11 h-11 bg-gradient-to-br from-blue-600 via-blue-500 to-indigo-600 flex items-center justify-center rounded-xl shadow-lg shadow-blue-500/20 ring-1 ring-white/10">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                    </div>
                    <div>
                        <h2 class="text-xl font-bold text-white tracking-tight">PT XYZ</h2>
                        <p class="text-xs text-slate-400 font-medium">Sistem Pengadaan Material Kapal</p>
                    </div>
                </div>

                <!-- Quick Navigation in Footer -->
                <div class="flex items-center gap-6 text-xs text-slate-400 font-medium">
                    <a href="#alur" class="hover:text-blue-400 transition-colors">Alur Pengadaan</a>
                    <span class="text-slate-700">•</span>
                    <a href="#modul" class="hover:text-blue-400 transition-colors">Modul Sistem</a>
                    <span class="text-slate-700">•</span>
                    <a href="#akses" class="hover:text-blue-400 transition-colors">Hak Akses</a>
                </div>
                
                <!-- Copyright & App Details -->
                <div class="text-xs text-slate-400 text-center md:text-right">
                    <p class="text-slate-300 font-medium">Sistem Informasi Manajemen Supply Chain</p>
                    <p class="text-slate-500 mt-1">&copy; {{ date('Y') }} PT XYZ. Seluruh hak cipta dilindungi.</p>
                </div>
            </div>
        </div>
    </footer>

</body>
</html>
