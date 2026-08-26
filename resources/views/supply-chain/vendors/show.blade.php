<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <h2 class="font-bold text-2xl text-slate-900 leading-tight">
                    Detail Vendor
                </h2>
                <p class="text-sm text-slate-500 mt-1">
                    Informasi lengkap vendor dan verifikasi registrasi.
                </p>
            </div>
            
            <div class="flex items-center gap-3">
                <a href="{{ route('supply-chain.vendors.edit', $vendor) }}" class="inline-flex items-center justify-center gap-2 px-4 py-2 bg-white border border-slate-300 text-slate-700 rounded-lg text-sm font-semibold hover:bg-slate-50 transition shadow-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4 text-slate-500">
                        <path d="M5.433 13.917l1.262-3.155A4 4 0 017.58 9.42l6.92-6.918a2.121 2.121 0 013 3l-6.92 6.918c-.383.383-.84.685-1.343.886l-3.154 1.262a.5.5 0 01-.65-.65z" />
                        <path d="M3.5 5.75c0-.69.56-1.25 1.25-1.25H10A.75.75 0 0010 3H4.75A2.75 2.75 0 002 5.75v9.5A2.75 2.75 0 004.75 18h9.5A2.75 2.75 0 0017 15.25V10a.75.75 0 00-1.5 0v5.25c0 .69-.56 1.25-1.25 1.25h-9.5c-.69 0-1.25-.56-1.25-1.25v-9.5z" />
                    </svg>
                    Edit Data Vendor
                </a>
                
                <a href="{{ route('supply-chain.vendors.index') }}" class="inline-flex items-center justify-center gap-2 px-4 py-2 bg-slate-100 border border-slate-300 text-slate-700 rounded-lg text-sm font-semibold hover:bg-slate-200 transition shadow-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-4 h-4">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" />
                    </svg>
                    Kembali
                </a>
            </div>
        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-12">
        @if (session('success'))
            <div class="mb-6 p-4 bg-emerald-50 border-l-4 border-emerald-500 text-emerald-800 rounded-r-lg shadow-sm">
                <div class="flex items-center">
                    <svg class="w-5 h-5 mr-3 text-emerald-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                    <p class="text-sm font-medium">{{ session('success') }}</p>
                </div>
            </div>
        @endif
        
        @if (session('error'))
            <div class="mb-6 p-4 bg-rose-50 border-l-4 border-rose-500 text-rose-800 rounded-r-lg shadow-sm">
                <div class="flex items-center">
                    <svg class="w-5 h-5 mr-3 text-rose-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path></svg>
                    <p class="text-sm font-medium">{{ session('error') }}</p>
                </div>
            </div>
        @endif

        @php
            $regStatus = $vendor->status_registrasi ?? 'disetujui';
        @endphp

        <!-- Header Card -->
        <div class="bg-white rounded-xl shadow-sm border border-slate-200 mb-6 overflow-hidden">
            <div class="px-6 py-8 md:px-8 flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
                <div>
                    <div class="flex items-center gap-3 mb-3">
                        <span class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-semibold bg-slate-100 text-slate-700 border border-slate-200">
                            {{ $vendor->kode_vendor }}
                        </span>
                        @if ($vendor->status == 'aktif')
                            <span class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                Vendor Aktif
                            </span>
                        @else
                            <span class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-semibold bg-rose-50 text-rose-700 border border-rose-200">
                                Vendor Nonaktif
                            </span>
                        @endif
                    </div>
                    
                    <h1 class="text-2xl md:text-3xl font-extrabold text-slate-900 tracking-tight">
                        {{ $vendor->nama_vendor }}
                    </h1>
                    
                    <p class="text-slate-500 mt-2 text-sm md:text-base font-medium">
                        Kategori: <span class="text-slate-700">{{ $vendor->kategori ?? 'Belum diisi' }}</span>
                    </p>
                </div>
                
                <div class="flex shrink-0">
                    @if ($regStatus === 'menunggu')
                        <div class="inline-flex items-center gap-2.5 px-4 py-3 rounded-xl bg-amber-50 border border-amber-200 text-amber-800 font-semibold shadow-sm text-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5 text-amber-500"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm.75-13a.75.75 0 00-1.5 0v5c0 .414.336.75.75.75h4a.75.75 0 000-1.5h-3.25V5z" clip-rule="evenodd" /></svg>
                            Menunggu Verifikasi
                        </div>
                    @elseif ($regStatus === 'disetujui')
                        <div class="inline-flex items-center gap-2.5 px-4 py-3 rounded-xl bg-blue-50 border border-blue-200 text-blue-800 font-semibold shadow-sm text-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5 text-blue-500"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd" /></svg>
                            Registrasi Disetujui
                        </div>
                    @elseif ($regStatus === 'ditolak')
                        <div class="inline-flex items-center gap-2.5 px-4 py-3 rounded-xl bg-slate-100 border border-slate-300 text-slate-700 font-semibold shadow-sm text-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5 text-slate-500"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.28 7.22a.75.75 0 00-1.06 1.06L8.94 10l-1.72 1.72a.75.75 0 101.06 1.06L10 11.06l1.72 1.72a.75.75 0 101.06-1.06L11.06 10l1.72-1.72a.75.75 0 00-1.06-1.06L10 8.94 8.28 7.22z" clip-rule="evenodd" /></svg>
                            Registrasi Ditolak
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">
            
            <div class="xl:col-span-2 space-y-6">
                <!-- Data Perusahaan -->
                <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
                    <div class="px-6 py-5 border-b border-slate-200 bg-slate-50/50">
                        <h3 class="text-base font-bold leading-6 text-slate-900">Informasi Perusahaan</h3>
                        <p class="mt-1 text-sm text-slate-500">Detail kontak dan profil vendor.</p>
                    </div>
                    <div class="px-6 py-6">
                        <dl class="grid grid-cols-1 sm:grid-cols-2 gap-x-6 gap-y-6">
                            <div>
                                <dt class="text-sm font-medium text-slate-500">Nama PIC</dt>
                                <dd class="mt-1 text-sm text-slate-900 font-semibold">{{ $vendor->pic ?? '-' }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-slate-500">Email</dt>
                                <dd class="mt-1 text-sm text-slate-900 font-semibold">{{ $vendor->email ?? '-' }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-slate-500">Telepon</dt>
                                <dd class="mt-1 text-sm text-slate-900 font-semibold">{{ $vendor->telepon ?? '-' }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-slate-500">Kategori Utama</dt>
                                <dd class="mt-1 text-sm text-slate-900 font-semibold">{{ $vendor->kategori ?? '-' }}</dd>
                            </div>
                            <div class="sm:col-span-2">
                                <dt class="text-sm font-medium text-slate-500">Alamat Lengkap</dt>
                                <dd class="mt-1 text-sm text-slate-900 font-semibold leading-relaxed">{{ $vendor->alamat ?? '-' }}</dd>
                            </div>
                        </dl>
                    </div>
                </div>

                <!-- Informasi Registrasi Detail -->
                <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
                    <div class="px-6 py-5 border-b border-slate-200 bg-slate-50/50">
                        <h3 class="text-base font-bold leading-6 text-slate-900">Status & Riwayat Verifikasi</h3>
                    </div>
                    <div class="px-6 py-6">
                        <dl class="grid grid-cols-1 sm:grid-cols-2 gap-x-6 gap-y-6">
                            <div>
                                <dt class="text-sm font-medium text-slate-500">Tanggal Registrasi</dt>
                                <dd class="mt-1 text-sm text-slate-900 font-semibold">
                                    @if ($vendor->tanggal_daftar)
                                        {{ $vendor->tanggal_daftar->format('d M Y, H:i') }}
                                    @else
                                        {{ $vendor->created_at->format('d M Y, H:i') }}
                                    @endif
                                </dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-slate-500">Tanggal Verifikasi</dt>
                                <dd class="mt-1 text-sm text-slate-900 font-semibold">
                                    {{ $vendor->tanggal_verifikasi ? $vendor->tanggal_verifikasi->format('d M Y, H:i') : '-' }}
                                </dd>
                            </div>
                            @if ($vendor->verifikator)
                            <div>
                                <dt class="text-sm font-medium text-slate-500">Diverifikasi Oleh</dt>
                                <dd class="mt-1 text-sm text-slate-900 font-semibold">{{ $vendor->verifikator->name }}</dd>
                            </div>
                            @endif
                            
                            @if ($vendor->alasan_penolakan)
                            <div class="sm:col-span-2 mt-2">
                                <div class="bg-rose-50 border border-rose-200 p-4 rounded-xl">
                                    <h4 class="text-xs font-bold text-rose-600 uppercase tracking-wider mb-2">Alasan Penolakan</h4>
                                    <p class="text-sm text-rose-800 font-medium">{{ $vendor->alasan_penolakan }}</p>
                                </div>
                            </div>
                            @endif
                        </dl>
                    </div>
                </div>
            </div>

            <!-- Panel Kanan (Aksi & Info) -->
            <div class="xl:col-span-1 space-y-6">
                
                @if ($regStatus === 'menunggu')
                <!-- Verifikasi Card -->
                <div class="bg-white rounded-xl shadow-sm border border-amber-200 overflow-hidden relative">
                    <div class="absolute top-0 left-0 w-1.5 h-full bg-amber-400"></div>
                    <div class="px-6 py-5 border-b border-slate-100">
                        <h3 class="text-base font-bold leading-6 text-slate-900 flex items-center gap-2">
                            Aksi Verifikasi
                        </h3>
                    </div>
                    <div class="px-6 py-6">
                        <p class="text-sm text-slate-600 mb-6 leading-relaxed">
                            Tinjau informasi vendor dengan saksama sebelum menyetujui atau menolak pendaftaran ini.
                        </p>
                        
                        <div class="space-y-3">
                            <form action="{{ route('supply-chain.vendors.approve', $vendor) }}" method="POST"
                                onsubmit="return confirm('Apakah Anda yakin ingin menyetujui registrasi Vendor ini?')">
                                @csrf
                                <button type="submit"
                                    class="w-full inline-flex justify-center items-center gap-2 rounded-lg bg-emerald-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-emerald-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-emerald-600 transition-all">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4"><path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z" clip-rule="evenodd" /></svg>
                                    Setujui Registrasi
                                </button>
                            </form>

                            <button type="button" onclick="document.getElementById('modal-tolak').classList.remove('hidden')"
                                class="w-full inline-flex justify-center items-center gap-2 rounded-lg bg-white px-4 py-2.5 text-sm font-semibold text-rose-600 shadow-sm ring-1 ring-inset ring-rose-300 hover:bg-rose-50 transition-all">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4"><path d="M6.28 5.22a.75.75 0 00-1.06 1.06L8.94 10l-3.72 3.72a.75.75 0 101.06 1.06L10 11.06l3.72 3.72a.75.75 0 101.06-1.06L11.06 10l3.72-3.72a.75.75 0 00-1.06-1.06L10 8.94 6.28 5.22z" /></svg>
                                Tolak Registrasi
                            </button>
                        </div>
                    </div>
                </div>
                @endif

                <!-- Info Card -->
                <div class="bg-slate-50 rounded-xl border border-slate-200 p-6">
                    <div class="flex gap-4">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5 text-slate-400 shrink-0 mt-0.5"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a.75.75 0 000 1.5h.253a.25.25 0 01.244.304l-.459 2.066A1.75 1.75 0 0010.747 15H11a.75.75 0 000-1.5h-.253a.25.25 0 01-.244-.304l.459-2.066A1.75 1.75 0 009.253 9H9z" clip-rule="evenodd" /></svg>
                        <div>
                            <h4 class="text-sm font-bold text-slate-900">Tentang Status Vendor</h4>
                            <p class="mt-2 text-sm text-slate-600 leading-relaxed">
                                Vendor yang telah memiliki status <span class="font-semibold text-slate-900">Disetujui</span> akan tersedia dan dapat dipilih di dalam daftar saat Supply Chain membuat dokumen tender atau mengirim undangan penawaran.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Tolak Registrasi -->
    <div id="modal-tolak" class="hidden relative z-50" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm transition-opacity"></div>
      
        <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
            <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
                <div class="relative transform overflow-hidden rounded-2xl bg-white text-left shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-lg">
                    <form action="{{ route('supply-chain.vendors.reject', $vendor) }}" method="POST">
                        @csrf
                        <div class="bg-white px-4 pb-4 pt-5 sm:p-6 sm:pb-4">
                            <div class="sm:flex sm:items-start">
                                <div class="mx-auto flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-full bg-rose-100 sm:mx-0 sm:h-10 sm:w-10">
                                    <svg class="h-6 w-6 text-rose-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                    </svg>
                                </div>
                                <div class="mt-3 text-center sm:ml-4 sm:mt-0 sm:text-left w-full">
                                    <h3 class="text-base font-bold leading-6 text-slate-900" id="modal-title">Tolak Registrasi Vendor</h3>
                                    <div class="mt-2">
                                        <p class="text-sm text-slate-500 mb-4">
                                            Berikan alasan penolakan yang jelas. Alasan ini akan dikirim ke vendor agar mereka dapat memperbaiki data registrasinya.
                                        </p>
                                        <label for="alasan_penolakan" class="block text-sm font-semibold text-slate-700 mb-1">
                                            Alasan Penolakan <span class="text-rose-600">*</span>
                                        </label>
                                        <textarea id="alasan_penolakan" name="alasan_penolakan" rows="4" required minlength="10"
                                            class="block w-full rounded-lg border-0 py-2 text-slate-900 shadow-sm ring-1 ring-inset ring-slate-300 placeholder:text-slate-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                                            placeholder="Contoh: Dokumen izin usaha tidak lengkap atau tidak valid..."></textarea>
                                        @error('alasan_penolakan')
                                            <p class="text-rose-600 text-sm mt-1 font-medium">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="bg-slate-50 px-4 py-4 sm:flex sm:flex-row-reverse sm:px-6 gap-3">
                            <button type="submit" class="inline-flex w-full justify-center items-center rounded-lg bg-rose-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-rose-500 sm:w-auto transition-all">Konfirmasi Penolakan</button>
                            <button type="button" onclick="document.getElementById('modal-tolak').classList.add('hidden')" class="mt-3 inline-flex w-full justify-center items-center rounded-lg bg-white px-4 py-2.5 text-sm font-semibold text-slate-900 shadow-sm ring-1 ring-inset ring-slate-300 hover:bg-slate-50 sm:mt-0 sm:w-auto transition-all">Batal</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
