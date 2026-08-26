<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3">
            <div>
                <h2 class="font-bold text-2xl text-slate-900 leading-tight">
                    Diskusi Negosiasi: {{ $tender->nama_tender }}
                </h2>
                <p class="text-sm text-slate-500 mt-1">
                    Jawab dan negosiasikan komersial tender dengan vendor.
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
        @if (session('success'))
            <div class="mb-4 bg-emerald-50 border border-emerald-200 text-emerald-800 p-4 rounded-xl text-sm flex items-center gap-2">
                <svg class="w-5 h-5 text-emerald-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                <span>{{ session('success') }}</span>
            </div>
        @endif
        @if (session('error'))
            <div class="mb-4 bg-rose-50 border border-rose-200 text-rose-800 p-4 rounded-xl text-sm flex items-center gap-2">
                <svg class="w-5 h-5 text-rose-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                </svg>
                <span>{{ session('error') }}</span>
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
                            <input type="text" id="negosiasiSearch"
                                class="w-full pl-9 pr-3 py-2 bg-white rounded-lg border-slate-200 focus:border-blue-500 focus:ring-blue-500 placeholder-slate-400 text-sm shadow-sm"
                                placeholder="Cari vendor...">
                        </div>
                        <button type="button" class="px-3 py-2 bg-slate-900 hover:bg-gradient-to-r from-slate-900 to-blue-900 text-white rounded-lg text-sm font-bold shadow-sm transition-colors">
                            Cari
                        </button>
                    </div>
                    <a href="{{ route('supply-chain.chat.negosiasi.index', $tenderId) }}" class="text-slate-400 hover:text-slate-600 shrink-0" title="Kembali ke Daftar">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7"></path>
                        </svg>
                    </a>
                </div>

                {{-- Daftar Chat List --}}
                <div class="overflow-y-auto flex-1 divide-y divide-slate-50" id="negosiasiList">
                    <div id="negosiasiNoResult" class="hidden p-6 text-center text-xs text-slate-500">
                        Tidak ada vendor yang ditemukan.
                    </div>

                    @forelse ($vendors as $item)
                        @php
                            $v = $item->vendor;
                            $unreadCount = $item->unread ?? 0;
                            $lastMessage = $item->last_message ?? null;
                            $vendorName = $v->nama_vendor ?? 'Vendor';
                            $initials = substr($vendorName, 0, 2);
                            $isActive = ($v->id == $vendorId);
                        @endphp

                        <a href="{{ route('supply-chain.chat.negosiasi.show', [$tenderId, $v->id]) }}" class="negosiasi-item flex items-center p-4 transition-colors hover:bg-slate-50 {{ $isActive ? 'bg-blue-50/50 border-l-4 border-blue-600' : ($unreadCount > 0 ? 'bg-slate-900/10 border-l-4 border-slate-900' : 'border-l-4 border-transparent') }}">
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
                                    @if($lastMessage)
                                    <span class="text-[10px] text-slate-500 shrink-0 font-medium">
                                        {{ $lastMessage->created_at->format('H:i') }}
                                    </span>
                                    @endif
                                </div>
                                <div class="flex justify-between items-center">
                                    <p class="text-xs text-slate-500 truncate pr-2 {{ $unreadCount > 0 && !$isActive ? 'font-semibold text-slate-800' : '' }}">
                                        @if($lastMessage)
                                            {{ $lastMessage->sender_id == auth()->id() ? 'Anda: ' : '' }}{{ \Illuminate\Support\Str::limit($lastMessage->message, 50) }}
                                        @else
                                            Klik untuk membuka percakapan
                                        @endif
                                    </p>
                                    @if($unreadCount > 0 && !$isActive)
                                        <span class="w-5 h-5 rounded-full bg-blue-600 text-white flex items-center justify-center text-[10px] font-bold shrink-0">
                                            {{ $unreadCount }}
                                        </span>
                                    @endif
                                </div>
                                <div class="text-[10px] font-medium text-blue-600 mt-1 truncate">
                                    Status: Negosiasi
                                </div>
                            </div>
                        </a>
                    @empty
                        <div class="p-6 text-center text-xs text-slate-500">Belum ada vendor di tender ini.</div>
                    @endforelse
                </div>
            </div>

            {{-- Main Content Area (Chat Interface) --}}
            <div class="flex flex-col w-full lg:w-2/3 bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden h-[600px]">
                
                {{-- Chat Header --}}
                <div class="p-4 border-b border-slate-200 bg-white flex items-center justify-between shadow-sm z-10 relative">
                    <div class="flex items-center gap-4">
                        <a href="{{ route('supply-chain.chat.negosiasi.index', $tenderId) }}" class="lg:hidden w-8 h-8 rounded-full bg-slate-100 flex items-center justify-center text-slate-600 hover:bg-slate-200 transition-colors">
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
                                {{ $tender->nama_tender }}
                            </p>
                        </div>
                    </div>
                </div>

                {{-- Chat Messages Area --}}
                <div id="chatBox" class="flex-1 p-6 overflow-y-auto space-y-4 bg-slate-50/60 bg-[url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNjAiIGhlaWdodD0iNjAiIHZpZXdCb3g9IjAgMCA2MCA2MCIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj48ZyBmaWxsPSJub25lIiBmaWxsLXJ1bGU9ImV2ZW5vZGQiPjxnIGZpbGw9IiM2NDc0OGIiIGZpbGwtb3BhY2l0eT0iMC4wMiI+PHBhdGggZD0iTTM2IDM0aDEydjEySDM2eiIvPjwvZz48L2c+PC9zdmc+')]">
                    
                    @forelse ($messages as $chat)
                        @if ($chat->sender_id == auth()->id())
                            {{-- Bubble Saya (Kanan) --}}
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
                                        @if($chat->is_read)
                                            <span class="ml-1 text-blue-500">✓✓</span>
                                        @else
                                            <span class="ml-1">✓</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @else
                            {{-- Bubble Vendor (Kiri) --}}
                            <div class="flex justify-start" data-msg-id="{{ $chat->id }}">
                                <div class="max-w-[85%] md:max-w-[75%]">
                                    <div class="mb-1">
                                        <span class="text-[11px] font-bold text-slate-600 ml-1">
                                            {{ $vendor->nama_vendor }}
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
                            <p class="text-sm">Mulai percakapan negosiasi</p>
                        </div>
                    @endforelse

                </div>

                {{-- Form Balasan --}}
                <form action="{{ route('supply-chain.chat.negosiasi.send', [$tenderId, $vendorId]) }}" method="POST" id="chatForm" enctype="multipart/form-data" class="bg-white border-t border-slate-200 p-4 relative z-20">
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
                            <textarea name="message" id="messageInput" rows="1" class="w-full bg-transparent border-0 focus:ring-0 text-sm p-3 max-h-32 resize-none" placeholder="Ketik pesan negosiasi..."></textarea>
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
        const searchInput = document.getElementById('negosiasiSearch');
        const list = document.getElementById('negosiasiList');
        const noResult = document.getElementById('negosiasiNoResult');

        if (searchInput && list) {
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
        }

        const sendUrl     = "{{ route('supply-chain.chat.negosiasi.send', [$tenderId, $vendorId]) }}";
        const pollUrl     = "{{ route('supply-chain.chat.negosiasi.messages.ajax', [$tenderId, $vendorId]) }}";
        const csrfToken   = document.querySelector('meta[name="csrf-token"]').content;

        let lastId    = {{ $messages->last()->id ?? 0 }};
        let isPolling = true;
        let isSending = false;

        /* ── Helpers ── */
        const escHtml = (s) => {
            const d = document.createElement('div');
            d.appendChild(document.createTextNode(s));
            return d.innerHTML;
        };

        const scrollBottom = () => { chatBox.scrollTop = chatBox.scrollHeight; };

        const toast = (title, body, type = 'warning') => {
            if (window.showToastNotification) {
                window.showToastNotification(title, body, type);
            }
        };

        const compressImage = async (file, maxWidth = 800, quality = 0.7) => {
            return new Promise((resolve) => {
                const reader = new FileReader();
                reader.readAsDataURL(file);
                reader.onload = (event) => {
                    const img = new Image();
                    img.src = event.target.result;
                    img.onload = () => {
                        const canvas = document.createElement('canvas');
                        let width = img.width, height = img.height;
                        if (width > maxWidth) {
                            height = Math.round((height * maxWidth) / width);
                            width = maxWidth;
                        }
                        canvas.width = width;
                        canvas.height = height;
                        const ctx = canvas.getContext('2d');
                        ctx.drawImage(img, 0, 0, width, height);
                        canvas.toBlob((blob) => {
                            resolve(new File([blob], file.name, { type: 'image/jpeg' }));
                        }, 'image/jpeg', quality);
                    };
                };
            });
        };

        /* ── Build bubble ── */
        const buildBubble = (msg, tempId = null) => {
            const id  = tempId ? `data-temp-id="${tempId}"` : `data-msg-id="${msg.id}"`;
            const isMe = msg.role === 'me';
            const attachmentHtml = msg.attachment_url ? `<a href="${msg.attachment_url}" target="_blank"><img src="${msg.attachment_url}" class="max-w-full h-auto rounded-xl mb-3 shadow-sm border ${isMe ? 'border-blue-800' : 'border-slate-100'}" alt="Lampiran" /></a>` : '';

            if (isMe) {
                return `<div class="flex justify-end" ${id}>
                    <div class="max-w-[85%] md:max-w-[75%]">
                        <div class="rounded-2xl rounded-tr-sm bg-gradient-to-br from-slate-900 to-blue-900 text-white px-4 py-3 shadow-sm text-sm ${tempId ? 'opacity-70' : ''}">
                            ${attachmentHtml}
                            <p class="leading-relaxed whitespace-pre-line">${escHtml(msg.message || '')}</p>
                        </div>
                        <div class="text-[10px] text-slate-400 mt-1 text-right font-medium">
                            ${msg.time}
                            <span class="ml-1">${msg.is_read ? '✓✓' : '✓'}</span>
                        </div>
                    </div>
                </div>`;
            } else {
                return `<div class="flex justify-start" ${id}>
                    <div class="max-w-[85%] md:max-w-[75%]">
                        <div class="mb-1">
                            <span class="text-[11px] font-bold text-slate-600 ml-1">
                                {{ $vendor->nama_vendor }}
                            </span>
                        </div>
                        <div class="rounded-2xl rounded-tl-sm bg-white border border-slate-200 text-slate-800 px-4 py-3 shadow-sm text-sm">
                            ${attachmentHtml}
                            <p class="leading-relaxed whitespace-pre-line">${escHtml(msg.message || '')}</p>
                        </div>
                        <div class="text-[10px] text-slate-400 mt-1 ml-1 font-medium">
                            ${msg.time}
                        </div>
                    </div>
                </div>`;
            }
        };

        /* ── Event Listeners ── */
        input.addEventListener('keydown', function(e) {
            if (e.key === 'Enter' && !e.shiftKey) {
                e.preventDefault();
                if (input.value.trim() !== '' || attachmentInput.files.length > 0) {
                    sendForm.dispatchEvent(new Event('submit'));
                }
            }
        });

        attachmentInput.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                if (file.size > 5 * 1024 * 1024) {
                    toast('Error', 'Ukuran file tidak boleh lebih dari 5MB', 'error');
                    this.value = '';
                    return;
                }
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
            imagePreview.src = '';
            imagePreviewContainer.classList.add('hidden');
        });

        /* ── Submit handler (AJAX) ── */
        sendForm.addEventListener('submit', async function(e) {
            e.preventDefault();
            if (isSending) return;

            const text = input.value.trim();
            const file = attachmentInput.files[0];

            if (!text && !file) return;

            isSending = true;
            sendBtn.disabled = true;
            input.disabled = true;

            const tempId = 'temp_' + Date.now();
            const d = new Date();
            const timeStr = String(d.getHours()).padStart(2,'0') + ':' + String(d.getMinutes()).padStart(2,'0');

            let tempAttachmentUrl = null;
            let compressedFile = null;

            if (file) {
                compressedFile = await compressImage(file);
                tempAttachmentUrl = URL.createObjectURL(compressedFile);
            }

            // Hapus label kosong jika ada
            if (chatBox.innerHTML.includes('Mulai percakapan negosiasi')) {
                chatBox.innerHTML = '';
            }

            chatBox.insertAdjacentHTML('beforeend', buildBubble({
                role: 'me',
                message: text,
                time: timeStr,
                is_read: false,
                attachment_url: tempAttachmentUrl
            }, tempId));
            
            scrollBottom();

            input.value = '';
            input.style.height = 'auto';
            attachmentInput.value = '';
            imagePreviewContainer.classList.add('hidden');

            const formData = new FormData();
            formData.append('_token', csrfToken);
            if (text) formData.append('message', text);
            if (compressedFile) formData.append('attachment', compressedFile);

            try {
                const res = await fetch(sendUrl, {
                    method: 'POST',
                    headers: { 'Accept': 'application/json' },
                    body: formData
                });
                const data = await res.json();
                
                if (!res.ok) throw new Error(data.message || 'Gagal mengirim pesan');

                const tempEl = document.querySelector(`[data-temp-id="${tempId}"]`);
                if (tempEl) {
                    tempEl.outerHTML = buildBubble(data.data);
                }
                lastId = data.data.id;
            } catch (err) {
                console.error(err);
                toast('Error', err.message, 'error');
                const tempEl = document.querySelector(`[data-temp-id="${tempId}"]`);
                if (tempEl) tempEl.remove();
                
                input.value = text;
            } finally {
                isSending = false;
                sendBtn.disabled = false;
                input.disabled = false;
                input.focus();
                if (tempAttachmentUrl) URL.revokeObjectURL(tempAttachmentUrl);
            }
        });

        /* ── Auto-resize textarea ── */
        input.addEventListener('input', function() {
            this.style.height = 'auto';
            this.style.height = (this.scrollHeight < 128 ? this.scrollHeight : 128) + 'px';
        });

        /* ── Polling logic ── */
        const checkNewMessages = async () => {
            if (!isPolling) return;
            try {
                const res = await fetch(`${pollUrl}?last_id=${lastId}`, {
                    headers: {
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                });
                if (!res.ok) return;
                const data = await res.json();
                
                if (data.data && data.data.length > 0) {
                    // Hapus label kosong jika ada
                    if (chatBox.innerHTML.includes('Mulai percakapan negosiasi')) {
                        chatBox.innerHTML = '';
                    }

                    data.data.forEach(msg => {
                        const exists = document.querySelector(`[data-msg-id="${msg.id}"]`);
                        if (!exists) {
                            chatBox.insertAdjacentHTML('beforeend', buildBubble(msg));
                            lastId = Math.max(lastId, msg.id);
                        }
                    });
                    scrollBottom();
                    
                    const newVendors = data.data.filter(m => m.role === 'vendor');
                    if (newVendors.length > 0) {
                        toast('Pesan Baru', `Ada ${newVendors.length} pesan baru dari Vendor`, 'info');
                    }
                }
            } catch (e) {
                console.error('Polling error:', e);
            }
        };

        setInterval(checkNewMessages, 5000);
        
        // Initial scroll
        setTimeout(scrollBottom, 100);
    })();
    </script>
</x-app-layout>
