<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Pengadaan Material Kapal | PT PAL</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-slate-100 text-slate-800 antialiased">

    <!-- HERO WRAPPER -->
    <section class="relative overflow-hidden bg-gradient-to-br from-slate-950 via-blue-950 to-blue-900 text-white">

        <!-- Decorative Background -->
        <div class="absolute inset-0 opacity-30">
            <div class="absolute -top-24 -left-24 w-96 h-96 bg-blue-500 rounded-full blur-3xl"></div>
            <div class="absolute top-40 right-0 w-96 h-96 bg-cyan-400 rounded-full blur-3xl"></div>
            <div class="absolute bottom-0 left-1/3 w-[500px] h-[300px] bg-blue-700 rounded-full blur-3xl"></div>
        </div>

        <!-- Navbar -->
        <header class="relative z-10 max-w-7xl mx-auto px-6 lg:px-8 py-6">
            <div
                class="flex items-center justify-between bg-white/10 backdrop-blur-md border border-white/10 rounded-2xl px-6 py-4 shadow-lg">

                <div>
                    <h1 class="text-xl md:text-2xl font-bold tracking-wide">
                        PT PAL INDONESIA
                    </h1>
                    <p class="text-blue-100 text-sm">
                        Sistem Informasi Pengadaan Material Kapal
                    </p>
                </div>

                <div class="flex items-center gap-3">
                    @auth
                        <a href="{{ route('dashboard') }}"
                            class="px-5 py-2.5 rounded-xl bg-white text-blue-900 font-semibold shadow hover:bg-slate-100 transition">
                            Dashboard
                        </a>
                    @else
                        <a href="{{ route('login') }}"
                            class="px-5 py-2.5 rounded-xl border border-white/30 text-white font-medium hover:bg-white/10 transition">
                            Login
                        </a>

                        <a href="{{ route('register') }}"
                            class="px-5 py-2.5 rounded-xl bg-white text-blue-900 font-semibold shadow hover:bg-slate-100 transition">
                            Register
                        </a>
                    @endauth
                </div>

            </div>
        </header>

        <!-- Hero Content -->
        <div class="relative z-10 max-w-7xl mx-auto px-6 lg:px-8 pt-12 pb-24">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">

                <div>
                    <div
                        class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-white/10 border border-white/10 text-sm text-blue-100 mb-6">
                        <span class="w-2 h-2 rounded-full bg-cyan-300"></span>
                        Digital Procurement Platform
                    </div>

                    <h2 class="text-4xl md:text-5xl lg:text-6xl font-bold leading-tight">
                        Sistem Pengadaan
                        <span class="text-cyan-300">Material Kapal</span>
                        Terintegrasi
                    </h2>

                    <p class="mt-6 text-lg text-blue-100 leading-relaxed max-w-xl">
                        Platform digital untuk mengelola pengajuan material, verifikasi planner,
                        tender vendor, purchase order, tracking pengiriman, hingga validasi penerimaan
                        barang secara terstruktur dan terdokumentasi.
                    </p>

                    <div class="mt-8 flex flex-wrap gap-4">
                        <a href="{{ route('login') }}"
                            class="px-6 py-3 rounded-xl bg-white text-blue-900 font-semibold shadow-lg hover:bg-slate-100 transition">
                            Masuk ke Sistem
                        </a>

                        <a href="{{ route('register') }}"
                            class="px-6 py-3 rounded-xl border border-white/30 text-white font-medium hover:bg-white/10 transition">
                            Daftar Akun
                        </a>
                    </div>

                    <div class="mt-10 grid grid-cols-1 sm:grid-cols-3 gap-4">
                        <div class="bg-white/10 border border-white/10 backdrop-blur-md rounded-2xl p-4">
                            <p class="text-2xl font-bold">6</p>
                            <p class="text-sm text-blue-100">Role Sistem</p>
                        </div>

                        <div class="bg-white/10 border border-white/10 backdrop-blur-md rounded-2xl p-4">
                            <p class="text-2xl font-bold">100%</p>
                            <p class="text-sm text-blue-100">Digital Workflow</p>
                        </div>

                        <div class="bg-white/10 border border-white/10 backdrop-blur-md rounded-2xl p-4">
                            <p class="text-2xl font-bold">Real-time</p>
                            <p class="text-sm text-blue-100">Monitoring</p>
                        </div>
                    </div>
                </div>

                <div>
                    <div class="bg-white rounded-3xl shadow-2xl overflow-hidden border border-slate-200 text-slate-800">
                        <div class="bg-gradient-to-r from-blue-950 via-blue-900 to-cyan-700 p-6">
                            <h3 class="text-white text-2xl font-bold">
                                Alur Sistem Pengadaan
                            </h3>
                            <p class="text-blue-100 mt-2 text-sm">
                                Alur kerja digital dalam proses pengadaan material kapal.
                            </p>
                        </div>

                        <div class="p-6 space-y-4">
                            <div class="flex items-start gap-4 p-4 rounded-2xl bg-slate-50 border">
                                <div
                                    class="w-10 h-10 rounded-xl bg-blue-900 text-white flex items-center justify-center font-bold">
                                    1</div>
                                <div>
                                    <h4 class="font-semibold">Engineer</h4>
                                    <p class="text-sm text-slate-600">Membuat pengajuan kebutuhan material kapal.</p>
                                </div>
                            </div>

                            <div class="flex items-start gap-4 p-4 rounded-2xl bg-slate-50 border">
                                <div
                                    class="w-10 h-10 rounded-xl bg-blue-800 text-white flex items-center justify-center font-bold">
                                    2</div>
                                <div>
                                    <h4 class="font-semibold">Planner</h4>
                                    <p class="text-sm text-slate-600">Memverifikasi dokumen, kuantitas, dan kebutuhan
                                        material.</p>
                                </div>
                            </div>

                            <div class="flex items-start gap-4 p-4 rounded-2xl bg-slate-50 border">
                                <div
                                    class="w-10 h-10 rounded-xl bg-blue-700 text-white flex items-center justify-center font-bold">
                                    3</div>
                                <div>
                                    <h4 class="font-semibold">Supply Chain</h4>
                                    <p class="text-sm text-slate-600">Mengelola vendor, tender, dan purchase order.</p>
                                </div>
                            </div>

                            <div class="flex items-start gap-4 p-4 rounded-2xl bg-slate-50 border">
                                <div
                                    class="w-10 h-10 rounded-xl bg-cyan-700 text-white flex items-center justify-center font-bold">
                                    4</div>
                                <div>
                                    <h4 class="font-semibold">Vendor & Gudang</h4>
                                    <p class="text-sm text-slate-600">Vendor mengirim penawaran, gudang memvalidasi
                                        barang.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- FEATURES -->
    <section class="bg-slate-100 py-20">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">

            <div class="text-center mb-12">
                <h3 class="text-3xl font-bold text-slate-900">
                    Fitur Utama Sistem
                </h3>
                <p class="mt-3 text-slate-600 max-w-2xl mx-auto">
                    Sistem dirancang untuk membantu pengelolaan procurement material kapal
                    secara efisien, akurat, dan terdokumentasi.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6">
                <div class="bg-white rounded-2xl p-6 shadow-md border border-slate-100 hover:shadow-lg transition">
                    <div
                        class="w-12 h-12 rounded-xl bg-blue-100 text-blue-900 flex items-center justify-center text-xl font-bold mb-4">
                        01
                    </div>
                    <h4 class="font-semibold text-lg mb-2">Pengajuan Material</h4>
                    <p class="text-sm text-slate-600">
                        Engineer membuat pengajuan material lengkap dengan item dan dokumen pendukung.
                    </p>
                </div>

                <div class="bg-white rounded-2xl p-6 shadow-md border border-slate-100 hover:shadow-lg transition">
                    <div
                        class="w-12 h-12 rounded-xl bg-blue-100 text-blue-900 flex items-center justify-center text-xl font-bold mb-4">
                        02
                    </div>
                    <h4 class="font-semibold text-lg mb-2">Verifikasi Planner</h4>
                    <p class="text-sm text-slate-600">
                        Planner melakukan review, validasi, dan approval terhadap pengajuan material.
                    </p>
                </div>

                <div class="bg-white rounded-2xl p-6 shadow-md border border-slate-100 hover:shadow-lg transition">
                    <div
                        class="w-12 h-12 rounded-xl bg-blue-100 text-blue-900 flex items-center justify-center text-xl font-bold mb-4">
                        03
                    </div>
                    <h4 class="font-semibold text-lg mb-2">Tender & Vendor</h4>
                    <p class="text-sm text-slate-600">
                        Supply Chain membuat tender, mengundang vendor, dan membandingkan penawaran.
                    </p>
                </div>

                <div class="bg-white rounded-2xl p-6 shadow-md border border-slate-100 hover:shadow-lg transition">
                    <div
                        class="w-12 h-12 rounded-xl bg-blue-100 text-blue-900 flex items-center justify-center text-xl font-bold mb-4">
                        04
                    </div>
                    <h4 class="font-semibold text-lg mb-2">Monitoring Pengadaan</h4>
                    <p class="text-sm text-slate-600">
                        Memantau status PO, pengiriman barang, dan validasi penerimaan gudang.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- ROLE SECTION -->
    <section class="bg-white py-20">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">
            <div class="bg-gradient-to-r from-slate-950 via-blue-950 to-blue-900 rounded-3xl p-8 md:p-10 shadow-xl">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-10 items-center">
                    <div>
                        <h3 class="text-3xl font-bold text-white">
                            Role Pengguna Sistem
                        </h3>
                        <p class="mt-3 text-blue-100">
                            Setiap role memiliki hak akses dan tanggung jawab sesuai alur pengadaan material kapal.
                        </p>
                    </div>

                    <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                        <div class="bg-white/10 text-white rounded-2xl px-4 py-4 text-center border border-white/10">
                            Admin</div>
                        <div class="bg-white/10 text-white rounded-2xl px-4 py-4 text-center border border-white/10">
                            Engineer</div>
                        <div class="bg-white/10 text-white rounded-2xl px-4 py-4 text-center border border-white/10">
                            Planner</div>
                        <div class="bg-white/10 text-white rounded-2xl px-4 py-4 text-center border border-white/10">
                            Supply Chain</div>
                        <div class="bg-white/10 text-white rounded-2xl px-4 py-4 text-center border border-white/10">
                            Vendor</div>
                        <div class="bg-white/10 text-white rounded-2xl px-4 py-4 text-center border border-white/10">
                            Gudang</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- FOOTER -->
    <footer class="bg-slate-100 py-8">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">
            <div
                class="bg-white rounded-2xl border border-slate-200 shadow-sm px-6 py-5 flex flex-col md:flex-row items-center justify-between gap-4">
                <div>
                    <p class="font-semibold text-slate-800">
                        Sistem Informasi Pengadaan Material Kapal
                    </p>
                    <p class="text-sm text-slate-500">
                        PT PAL Indonesia • Solusi digital pengadaan material kapal
                    </p>
                </div>

                <div class="text-sm text-slate-500">
                    © {{ date('Y') }} PT PAL Indonesia. All rights reserved.
                </div>
            </div>
        </div>
    </footer>

</body>

</html>
