<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3">
            <div>
                <h2 class="font-bold text-2xl text-slate-900 leading-tight">
                    Pusat Negosiasi: {{ $tender->nama_tender }}
                </h2>
                <p class="text-sm text-slate-500 mt-1">
                    Pusat percakapan tender per vendor.
                </p>
            </div>

            <a href="{{ route('supply-chain.tenders.show', $tenderId) }}"
                class="inline-flex items-center gap-2 px-5 py-2.5 bg-white border border-slate-200 hover:bg-slate-50 text-slate-700 rounded-xl text-sm font-semibold shadow-sm transition">
                <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                <span>Kembali ke Detail Tender</span>
            </a>
        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">

        <div class="flex flex-col lg:flex-row gap-6">

            {{-- Sidebar (Daftar Chat) --}}
            <div class="w-full lg:w-1/3 bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden flex flex-col h-[600px]">
                
                {{-- Search Header --}}
                <div class="p-4 border-b border-slate-100 bg-slate-50/50">
                    <div class="flex gap-2">
                        <div class="relative flex-1">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-4 w-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>
                            </div>
                            <input type="text" id="negosiasiSearch"
                                class="w-full pl-9 pr-3 py-2 bg-white rounded-lg border-slate-200 focus:border-blue-500 focus:ring-blue-500 placeholder-slate-400 text-sm shadow-sm"
                                placeholder="Cari vendor...">
                        </div>
                        <button type="button" class="px-3 py-2 bg-slate-900 hover:bg-gradient-to-r from-slate-900 to-blue-900 text-white rounded-lg text-sm font-bold shadow-sm transition-colors">
                            Cari
                        </button>
                    </div>
                </div>

                {{-- Daftar Chat List --}}
                <div class="overflow-y-auto flex-1 divide-y divide-slate-50" id="negosiasiList">
                    
                    <div id="negosiasiNoResult" class="hidden p-6 text-center text-xs text-slate-500">
                        Tidak ada vendor yang cocok dengan pencarian.
                    </div>

                    @forelse($vendors as $item)
                        @php
                            $vendor = $item->vendor;
                            $unread = $item->unread ?? 0;
                            $lastMessage = $item->last_message ?? null;
                            $vendorName = $vendor->nama_vendor ?? 'Vendor';
                            $initials = substr($vendorName, 0, 2);
                        @endphp

                        <a href="{{ route('supply-chain.chat.negosiasi.show', [$tenderId, $vendor->id]) }}" class="negosiasi-item flex items-center p-4 transition-colors hover:bg-slate-50 {{ $unread > 0 ? 'bg-slate-900/10 border-l-4 border-slate-900' : 'border-l-4 border-transparent' }}">
                            
                            {{-- Avatar --}}
                            <div class="relative shrink-0">
                                <div class="w-12 h-12 rounded-full bg-gradient-to-br from-slate-900 to-blue-900 text-white flex items-center justify-center text-sm font-bold uppercase shadow-sm">
                                    {{ $initials }}
                                </div>
                                @if($unread > 0)
                                    <span class="absolute top-0 right-0 w-3.5 h-3.5 bg-blue-500 border-2 border-white rounded-full animate-pulse"></span>
                                @endif
                            </div>

                            {{-- Info --}}
                            <div class="ml-4 flex-1 min-w-0">
                                <div class="flex justify-between items-baseline mb-0.5">
                                    <h4 class="text-sm font-bold text-slate-900 truncate pr-2">
                                        {{ $vendorName }}
                                    </h4>
                                    @if($lastMessage)
                                    <span class="text-[10px] text-slate-500 shrink-0 font-medium">
                                        {{ $lastMessage->created_at->format('H:i') }}
                                    </span>
                                    @endif
                                </div>
                                <div class="flex justify-between items-center">
                                    <p class="text-xs text-slate-500 truncate pr-2 {{ $unread > 0 ? 'font-semibold text-slate-800' : '' }}">
                                        @if($lastMessage)
                                            {{ $lastMessage->sender_id == auth()->id() ? 'Anda: ' : '' }}{{ \Illuminate\Support\Str::limit($lastMessage->message, 50) }}
                                        @else
                                            Klik untuk membuka percakapan
                                        @endif
                                    </p>
                                    @if($unread > 0)
                                        <span class="w-5 h-5 rounded-full bg-blue-600 text-white flex items-center justify-center text-[10px] font-bold shrink-0">
                                            {{ $unread }}
                                        </span>
                                    @endif
                                </div>
                                <div class="text-[10px] font-medium text-blue-600 mt-1 truncate">
                                    Status: Negosiasi
                                </div>
                            </div>
                        </a>
                    @empty
                        <div class="px-6 py-12 text-center">
                            <div class="mx-auto w-12 h-12 rounded-full bg-slate-100 flex items-center justify-center mb-3">
                                <svg class="w-6 h-6 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                                </svg>
                            </div>
                            <p class="text-xs text-slate-500 font-medium">Belum ada obrolan negosiasi.</p>
                        </div>
                    @endforelse
                </div>
            </div>

            {{-- Main Content Area (Empty State untuk Index) --}}
            <div class="hidden lg:flex w-full lg:w-2/3 bg-white rounded-2xl shadow-sm border border-slate-200 h-[600px] items-center justify-center bg-[url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNjAiIGhlaWdodD0iNjAiIHZpZXdCb3g9IjAgMCA2MCA2MCIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj48ZyBmaWxsPSJub25lIiBmaWxsLXJ1bGU9ImV2ZW5vZGQiPjxnIGZpbGw9IiM2NDc0OGIiIGZpbGwtb3BhY2l0eT0iMC4wMyI+PHBhdGggZD0iTTM2IDM0aDEydjEySDM2eiIvPjwvZz48L2c+PC9zdmc+')]">
                <div class="text-center px-6">
                    <div class="w-20 h-20 bg-blue-50 rounded-full flex items-center justify-center mx-auto mb-4 border border-blue-100">
                        <svg class="w-10 h-10 text-blue-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 8h2a2 2 0 012 2v6a2 2 0 01-2 2h-2v4l-4-4H9a1.994 1.994 0 01-1.414-.586m0 0L11 14h4a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2v4l.586-.586z"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-slate-900 mb-2">Pusat Negosiasi Vendor</h3>
                    <p class="text-sm text-slate-500 max-w-sm mx-auto">Pilih salah satu vendor di sebelah kiri untuk memulai proses negosiasi tender.</p>
                </div>
            </div>

        </div>

    </div>

    <script>
    (function() {
        const searchInput = document.getElementById('negosiasiSearch');
        const list = document.getElementById('negosiasiList');
        const noResult = document.getElementById('negosiasiNoResult');

        if (!searchInput || !list) return;

        searchInput.addEventListener('input', function() {
            const keyword = this.value.toLowerCase().trim();
            const items = list.querySelectorAll('a.negosiasi-item');
            let visible = 0;
            items.forEach(function(item) {
                const text = item.textContent.toLowerCase();
                if (!keyword || text.includes(keyword)) {
                    item.style.display = 'flex';
                    visible++;
                } else {
                    item.style.display = 'none';
                }
            });
            noResult.classList.toggle('hidden', visible > 0 || items.length === 0);
        });
    })();
    </script>
</x-app-layout>
