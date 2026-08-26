<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3">
            <div>
                <h2 class="font-bold text-2xl text-slate-900 leading-tight">
                    Diskusi Klarifikasi Spesifikasi
                </h2>
                <p class="text-sm text-slate-500 mt-1">
                    Jawab pertanyaan teknis vendor terkait spesifikasi material tender kapal.
                </p>
            </div>

            <a href="{{ route('engineer.dashboard') }}"
                class="inline-flex items-center gap-2 px-5 py-2.5 bg-white border border-slate-200 hover:bg-slate-50 text-slate-700 rounded-xl text-sm font-semibold shadow-sm transition">
                <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                <span>Dashboard</span>
            </a>
        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
        @if (session('success'))
            <div class="mb-4 bg-emerald-50 border border-emerald-200 text-emerald-800 p-4 rounded-xl text-sm flex items-center gap-2">
                <svg class="w-5 h-5 text-emerald-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        <div class="flex flex-col lg:flex-row gap-6">

            {{-- Sidebar (Daftar Chat) --}}
            <div class="hidden lg:flex flex-col w-1/3 bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden h-[600px]">
                
                {{-- Search Header --}}
                <div class="p-4 border-b border-slate-100 bg-slate-50/50 flex flex-col sm:flex-row sm:items-center gap-2">
                    <div class="flex gap-2 flex-1">
                        <div class="relative flex-1">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-4 w-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>
                            </div>
                            <input type="text" id="clarificationSearch"
                                class="w-full pl-9 pr-3 py-2 bg-white rounded-lg border-slate-200 focus:border-blue-500 focus:ring-blue-500 placeholder-slate-400 text-sm shadow-sm"
                                placeholder="Cari obrolan...">
                        </div>
                        <button type="button" id="searchBtn" class="px-3 py-2 bg-slate-900 hover:bg-blue-900 text-white rounded-lg text-sm font-bold shadow-sm transition-colors">
                            Cari
                        </button>
                    </div>
                    <a href="{{ route('engineer.clarifications.index') }}" class="text-slate-400 hover:text-slate-600 shrink-0" title="Kembali ke Daftar">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7"></path>
                        </svg>
                    </a>
                </div>

                {{-- Daftar Chat List --}}
                <div class="overflow-y-auto flex-1 divide-y divide-slate-50">
                    <div id="clarificationNoResult" class="hidden p-6 text-center text-xs text-slate-500">
                        Tidak ada obrolan yang ditemukan.
                    </div>

                    @forelse ($clarifications as $group)
                        @php
                            $first = $group->first();
                            $lastMessage = $group->sortByDesc('created_at')->first();
                            $unreadCount = $group
                                ->where('status', 'terkirim')
                                ->where('sender_id', '!=', auth()->id())
                                ->count();
                            $vendorName = $first->vendor->nama_vendor ?? 'Vendor';
                            $initials = substr($vendorName, 0, 2);
                            $isActive = ($first->tender_id == $tender->id && $first->vendor_id == $vendor->id);
                        @endphp

                        <a href="{{ route('engineer.clarifications.show', [$first->tender_id, $first->vendor_id]) }}" class="clarification-item flex items-center p-4 transition-colors hover:bg-slate-50 {{ $isActive ? 'bg-blue-50/50 border-l-4 border-blue-600' : ($unreadCount > 0 ? 'bg-slate-900/10 border-l-4 border-slate-900' : 'border-l-4 border-transparent') }}">
                            {{-- Avatar --}}
                            <div class="relative shrink-0 {{ $isActive ? '-ml-1' : '' }}">
                                <div class="w-12 h-12 rounded-full bg-gradient-to-br from-slate-900 to-blue-900 text-white flex items-center justify-center text-sm font-bold uppercase shadow-sm">
                                    {{ $initials }}
                                </div>
                                @if($unreadCount > 0 && !$isActive)
                                    <span class="absolute top-0 right-0 w-3.5 h-3.5 bg-blue-500 border-2 border-white rounded-full animate-pulse"></span>
                                @endif
                            </div>

                            {{-- Info --}}
                            <div class="ml-4 flex-1 min-w-0">
                                <div class="flex justify-between items-baseline mb-0.5">
                                    <h4 class="text-sm font-bold text-slate-900 truncate pr-2">
                                        {{ $vendorName }}
                                    </h4>
                                    <span class="text-[10px] text-slate-500 shrink-0 font-medium">
                                        {{ $lastMessage->created_at->format('H:i') }}
                                    </span>
                                </div>
                                <div class="flex justify-between items-center">
                                    <p class="text-xs text-slate-500 truncate pr-2 {{ $unreadCount > 0 && !$isActive ? 'font-semibold text-slate-800' : '' }}">
                                        {{ $lastMessage->sender_id == auth()->id() ? 'Anda: ' : '' }}{{ \Illuminate\Support\Str::limit($lastMessage->message, 50) }}
                                    </p>
                                    @if($unreadCount > 0 && !$isActive)
                                        <span class="w-5 h-5 rounded-full bg-blue-600 text-white flex items-center justify-center text-[10px] font-bold shrink-0">
                                            {{ $unreadCount }}
                                        </span>
                                    @endif
                                </div>
                                <div class="text-[10px] font-medium text-blue-600 mt-1 truncate">
                                    {{ $first->tender->nama_tender ?? '-' }}
                                </div>
                            </div>
                        </a>
                    @empty
                        <div class="p-6 text-center text-xs text-slate-500">Belum ada obrolan.</div>
                    @endforelse
                </div>
            </div>

            {{-- Main Content Area (Chat Interface) --}}
            <div class="flex flex-col w-full lg:w-2/3 bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden h-[600px]">
                
                {{-- Chat Header --}}
                <div class="p-4 border-b border-slate-200 bg-white flex items-center justify-between shadow-sm z-10 relative">
                    <div class="flex items-center gap-4">
                        <a href="{{ route('engineer.clarifications.index') }}" class="lg:hidden w-8 h-8 rounded-full bg-slate-100 flex items-center justify-center text-slate-600 hover:bg-slate-200 transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                        </a>
                        <div class="w-12 h-12 rounded-full bg-gradient-to-br from-slate-900 to-blue-900 text-white flex items-center justify-center text-sm font-bold uppercase shadow-sm">
                            {{ substr($vendor->nama_vendor, 0, 2) }}
                        </div>
                        <div>
                            <h3 class="text-base font-bold text-slate-900 leading-none mb-1">
                                {{ $vendor->nama_vendor }}
                            </h3>
                            <p class="text-xs text-blue-600 font-medium">
                                {{ $tender->nama_tender }} ({{ $tender->kode_tender }})
                            </p>
                        </div>
                    </div>
                </div>

                {{-- Chat Messages Area --}}
                <div id="chatBox" class="flex-1 p-6 overflow-y-auto space-y-4 bg-slate-50/60 bg-[url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNjAiIGhlaWdodD0iNjAiIHZpZXdCb3g9IjAgMCA2MCA2MCIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj48ZyBmaWxsPSJub25lIiBmaWxsLXJ1bGU9ImV2ZW5vZGQiPjxnIGZpbGw9IiM2NDc0OGIiIGZpbGwtb3BhY2l0eT0iMC4wMiI+PHBhdGggZD0iTTM2IDM0aDEydjEySDM2eiIvPjwvZz48L2c+PC9zdmc+')]">
                    
                    @forelse ($messages as $chat)
                        @if ($chat->sender_id == auth()->id())
                            {{-- Bubble Engineer (Right) --}}
                            <div class="flex justify-end" data-msg-id="{{ $chat->id }}">
                                <div class="max-w-[85%] md:max-w-[75%]">
                                    <div class="rounded-2xl rounded-tr-sm bg-gradient-to-br from-slate-900 to-blue-900 text-white px-4 py-3 shadow-sm text-sm">
                                        @if ($chat->attachment)
                                            <a href="{{ asset('storage/' . $chat->attachment) }}" target="_blank">
                                                <img src="{{ asset('storage/' . $chat->attachment) }}" class="max-w-full h-auto rounded-xl mb-3 shadow-sm border border-blue-800" alt="Lampiran">
                                            </a>
                                        @endif
                                        <p class="leading-relaxed whitespace-pre-line">{{ $chat->message }}</p>
                                    </div>
                                    <div class="text-[10px] text-slate-400 mt-1 text-right font-medium">
                                        {{ $chat->created_at->format('H:i') }}
                                        @if($chat->status == 'dibaca')
                                            <span class="ml-1 text-blue-500">✓✓</span>
                                        @else
                                            <span class="ml-1">✓</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @else
                            {{-- Bubble Vendor (Left) --}}
                            <div class="flex justify-start" data-msg-id="{{ $chat->id }}">
                                <div class="max-w-[85%] md:max-w-[75%]">
                                    <div class="mb-1">
                                        <span class="text-[11px] font-bold text-slate-600 ml-1">
                                            {{ $chat->sender->name ?? 'Vendor' }}
                                        </span>
                                    </div>
                                    <div class="rounded-2xl rounded-tl-sm bg-white border border-slate-200 text-slate-800 px-4 py-3 shadow-sm text-sm">
                                        @if ($chat->attachment)
                                            <a href="{{ asset('storage/' . $chat->attachment) }}" target="_blank">
                                                <img src="{{ asset('storage/' . $chat->attachment) }}" class="max-w-full h-auto rounded-xl mb-3 shadow-sm border border-slate-100" alt="Lampiran">
                                            </a>
                                        @endif
                                        <p class="leading-relaxed whitespace-pre-line">{{ $chat->message }}</p>
                                    </div>
                                    <div class="text-[10px] text-slate-400 mt-1 ml-1 font-medium">
                                        {{ $chat->created_at->format('H:i') }}
                                    </div>
                                </div>
                            </div>
                        @endif
                    @empty
                        <div class="h-full flex flex-col items-center justify-center text-slate-400">
                            <svg class="w-12 h-12 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
                            <p class="text-sm">Mulai percakapan klarifikasi spesifikasi</p>
                        </div>
                    @endforelse

                </div>

                {{-- Form Balasan --}}
                <form action="{{ route('engineer.clarifications.reply', [$tender->id, $vendor->id]) }}" method="POST" id="chatForm" enctype="multipart/form-data" class="bg-white border-t border-slate-200 p-4 relative z-20">
                    @csrf
                    
                    {{-- Image Preview Popup --}}
                    <div id="imagePreviewContainer" class="hidden absolute bottom-full left-4 mb-2 bg-white border border-slate-200 p-2 rounded-xl shadow-lg">
                        <div class="relative">
                            <img id="imagePreview" src="" class="h-24 rounded-lg object-cover">
                            <button type="button" id="removeImageBtn" class="absolute -top-3 -right-3 bg-white text-rose-500 border border-slate-200 rounded-full w-7 h-7 flex items-center justify-center shadow-md hover:bg-rose-50 transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                            </button>
                        </div>
                    </div>

                    <div class="flex items-end gap-3">
                        <label class="shrink-0 flex items-center justify-center w-10 h-10 rounded-full text-slate-500 hover:text-blue-600 hover:bg-blue-50 transition-colors cursor-pointer" title="Lampirkan Gambar">
                            <input type="file" name="attachment" id="attachmentInput" accept="image/*" class="hidden">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"></path></svg>
                        </label>
                        
                        <div class="flex-1 bg-slate-50 border border-slate-200 rounded-2xl overflow-hidden focus-within:ring-1 focus-within:ring-blue-500 focus-within:border-blue-500 transition-all">
                            <textarea name="message" id="messageInput" rows="1" class="w-full bg-transparent border-0 focus:ring-0 text-sm p-3 max-h-32 resize-none" placeholder="Ketik jawaban teknis..."></textarea>
                        </div>
                        
                        <button type="submit" id="sendBtn" class="shrink-0 flex items-center justify-center w-10 h-10 rounded-full bg-gradient-to-r from-slate-900 to-blue-900 text-white shadow-md hover:shadow-lg transition-all hover:scale-105 disabled:opacity-50 disabled:cursor-not-allowed">
                            <svg class="w-4 h-4 ml-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path></svg>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- ============================================================
         CHAT ENGINE: AJAX SEND + 5s POLLING + TOAST NOTIFICATION
         ============================================================ --}}
    <script>
    (function () {
        const chatBox     = document.getElementById('chatBox');
        const sendForm    = document.getElementById('chatForm');
        const input       = document.getElementById('messageInput');
        const attachmentInput = document.getElementById('attachmentInput');
        const imagePreviewContainer = document.getElementById('imagePreviewContainer');
        const imagePreview = document.getElementById('imagePreview');
        const removeImageBtn = document.getElementById('removeImageBtn');
        const sendBtn     = document.getElementById('sendBtn');

        const searchInput = document.getElementById('clarificationSearch');
        const noResult = document.getElementById('clarificationNoResult');

        if(searchInput) {
            searchInput.addEventListener('input', function() {
                const keyword = this.value.toLowerCase().trim();
                const items = document.querySelectorAll('.clarification-item');
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
                if(noResult) noResult.classList.toggle('hidden', visible > 0 || items.length === 0);
            });
        }

        // Auto-resize textarea
        input.addEventListener('input', function() {
            this.style.height = 'auto';
            this.style.height = (this.scrollHeight) + 'px';
            if (this.value.trim() === '') this.style.height = 'auto';
        });

        // Scroll to bottom on load
        chatBox.scrollTop = chatBox.scrollHeight;

        // Image Preview Logic
        attachmentInput.addEventListener('change', function() {
            const file = this.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    imagePreview.src = e.target.result;
                    imagePreviewContainer.classList.remove('hidden');
                }
                reader.readAsDataURL(file);
            }
        });

        removeImageBtn.addEventListener('click', function() {
            attachmentInput.value = '';
            imagePreviewContainer.classList.add('hidden');
            imagePreview.src = '';
        });

        const showToast = (message, isError = false) => {
            const toast = document.createElement('div');
            toast.className = `fixed bottom-4 right-4 text-white px-4 py-2 rounded-lg shadow-lg text-sm z-50 transition-opacity duration-300 ${isError ? 'bg-rose-500' : 'bg-emerald-500'}`;
            toast.textContent = message;
            document.body.appendChild(toast);
            setTimeout(() => {
                toast.style.opacity = '0';
                setTimeout(() => toast.remove(), 300);
            }, 3000);
        };

        // AJAX Send Message
        sendForm.addEventListener('submit', function (e) {
            e.preventDefault();
            const message = input.value.trim();
            const file = attachmentInput.files[0];

            if (!message && !file) return;

            const originalBtnContent = sendBtn.innerHTML;
            sendBtn.disabled = true;
            sendBtn.innerHTML = '<svg class="animate-spin w-4 h-4 text-white" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>';

            const formData = new FormData(this);

            fetch(this.action, {
                method: 'POST',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                },
                body: formData
            })
            .then(res => res.json())
            .then(data => {
                if (data.status === 'success') {
                    // Reset Form
                    input.value = '';
                    input.style.height = 'auto';
                    attachmentInput.value = '';
                    imagePreviewContainer.classList.add('hidden');
                    
                    fetchNewMessages();
                } else {
                    showToast(data.message || 'Gagal mengirim pesan.', true);
                }
            })
            .catch(err => {
                console.error(err);
                showToast('Terjadi kesalahan jaringan.', true);
            })
            .finally(() => {
                sendBtn.disabled = false;
                sendBtn.innerHTML = originalBtnContent;
            });
        });

        // Polling Messages
        let isPolling = false;
        function fetchNewMessages() {
            if (isPolling) return;
            isPolling = true;

            const url = window.location.href;

            fetch(url, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            })
            .then(res => res.json())
            .then(data => {
                if (data.status === 'success' && data.html) {
                    chatBox.innerHTML = data.html;
                    chatBox.scrollTop = chatBox.scrollHeight;
                }
            })
            .catch(console.error)
            .finally(() => {
                isPolling = false;
            });
        }

        setInterval(fetchNewMessages, 5000);
    })();
    </script>
</x-app-layout>
