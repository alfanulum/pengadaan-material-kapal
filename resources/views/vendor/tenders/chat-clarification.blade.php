<x-app-layout>

    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3">
            <div>
                <h2 class="font-bold text-2xl text-slate-900 leading-tight">
                    Klarifikasi Spesifikasi
                </h2>
                <p class="text-sm text-slate-500 mt-1">
                    Diskusi teknis dengan Engineer terkait detail material.
                </p>
            </div>
            <a href="{{ route('vendor.tenders.show', $invitation->id) }}"
                class="inline-flex items-center gap-2 px-5 py-2.5 bg-white text-slate-700 border border-slate-200 rounded-xl text-sm font-semibold hover:bg-slate-50 hover:text-blue-600 transition-all shadow-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Kembali ke Tender
            </a>
        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">

        <div class="flex flex-col lg:flex-row gap-6 h-[75vh] min-h-[600px]">
            
            {{-- SIDEBAR TENDER INFO --}}
            <div class="w-full lg:w-1/3 flex flex-col gap-6">
                <div class="bg-gradient-to-br from-slate-900 to-blue-900 rounded-3xl p-6 text-white shadow-lg shadow-blue-900/20 relative overflow-hidden flex-shrink-0">
                    <div class="absolute -top-24 -right-24 w-64 h-64 bg-blue-500/20 rounded-full blur-3xl"></div>
                    <div class="relative z-10">
                        <span class="inline-flex px-3 py-1 rounded-lg bg-white/10 border border-white/20 text-xs font-bold mb-4 backdrop-blur-sm">
                            {{ $invitation->tender->kode_tender }}
                        </span>
                        <h3 class="text-xl font-bold leading-tight mb-2">
                            {{ $invitation->tender->nama_tender }}
                        </h3>
                        <p class="text-blue-200 text-sm">
                            Project: {{ $invitation->tender->materialRequest->project->nama_project ?? '-' }}
                        </p>
                    </div>
                </div>

                <div class="bg-white rounded-3xl p-6 border border-slate-200 shadow-sm flex-1">
                    <h4 class="text-sm font-bold text-slate-900 uppercase tracking-wider mb-4 flex items-center gap-2">
                        <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        Informasi
                    </h4>
                    <div class="space-y-4">
                        <div>
                            <p class="text-xs text-slate-500 mb-1">Status Tender</p>
                            <span class="inline-flex px-2.5 py-1 rounded-md bg-slate-100 text-slate-700 text-xs font-bold capitalize">
                                {{ str_replace('_', ' ', $invitation->status) }}
                            </span>
                        </div>
                        <div>
                            <p class="text-xs text-slate-500 mb-1">Perusahaan Anda</p>
                            <p class="text-sm font-semibold text-slate-900">{{ $invitation->vendor->nama_vendor ?? 'Vendor' }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-slate-500 mb-1">Lawan Bicara</p>
                            <p class="text-sm font-semibold text-slate-900 flex items-center gap-2">
                                <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                                Tim Engineer
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- CHAT AREA --}}
            <div class="w-full lg:w-2/3 bg-white rounded-3xl shadow-sm border border-slate-200 flex flex-col overflow-hidden relative">
                
                {{-- Chat Header --}}
                <div class="px-6 py-4 border-b border-slate-100 bg-white/80 backdrop-blur-md z-10 flex items-center justify-between shadow-sm">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center shrink-0 border border-blue-200">
                            <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8h2a2 2 0 012 2v6a2 2 0 01-2 2h-2v4l-4-4H9a1.994 1.994 0 01-1.414-.586m0 0L11 14h4a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2v4l.586-.586z"></path></svg>
                        </div>
                        <div>
                            <h3 class="text-base font-bold text-slate-900">Ruang Klarifikasi</h3>
                            <p class="text-xs text-slate-500 flex items-center gap-1">
                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Online
                            </p>
                        </div>
                    </div>
                </div>

                {{-- Chat Messages (Scrollable) --}}
                <div id="chatBox" class="flex-1 p-6 overflow-y-auto bg-slate-50/50 space-y-6">
                    @forelse ($messages as $msg)
                        @if ($msg->sender_id == auth()->id())
                            {{-- VENDOR (ME) --}}
                            <div class="flex justify-end mb-4 group" data-msg-id="{{ $msg->id }}">
                                <div class="max-w-[75%] lg:max-w-[65%] flex flex-col items-end">
                                    <span class="text-[10px] font-bold text-slate-400 mb-1 px-1">Anda</span>
                                    <div class="bg-blue-600 text-white px-5 py-3.5 rounded-2xl rounded-tr-sm shadow-sm">
                                        @if ($msg->attachment)
                                            <div class="mb-2 rounded-xl overflow-hidden bg-white/10 p-1">
                                                <img src="{{ asset('storage/' . $msg->attachment) }}" class="max-w-full rounded-lg cursor-pointer hover:opacity-90 transition object-cover max-h-48 w-auto" alt="Lampiran" onclick="openLightbox('{{ asset('storage/' . $msg->attachment) }}')">
                                            </div>
                                        @endif
                                        <p class="text-sm leading-relaxed whitespace-pre-line">{{ $msg->message }}</p>
                                    </div>
                                    <span class="text-[10px] font-medium text-slate-400 mt-1 px-1 opacity-0 group-hover:opacity-100 transition-opacity">{{ $msg->created_at->format('H:i') }}</span>
                                </div>
                            </div>
                        @else
                            {{-- ENGINEER (OTHER) --}}
                            <div class="flex justify-start mb-4 group" data-msg-id="{{ $msg->id }}">
                                <div class="max-w-[75%] lg:max-w-[65%] flex flex-col items-start">
                                    <span class="text-[10px] font-bold text-slate-400 mb-1 px-1">Engineer</span>
                                    <div class="bg-white border border-slate-200 text-slate-800 px-5 py-3.5 rounded-2xl rounded-tl-sm shadow-sm">
                                        @if ($msg->attachment)
                                            <div class="mb-2 rounded-xl overflow-hidden bg-slate-50 p-1 border border-slate-100">
                                                <img src="{{ asset('storage/' . $msg->attachment) }}" class="max-w-full rounded-lg cursor-pointer hover:opacity-90 transition object-cover max-h-48 w-auto" alt="Lampiran" onclick="openLightbox('{{ asset('storage/' . $msg->attachment) }}')">
                                            </div>
                                        @endif
                                        <p class="text-sm leading-relaxed whitespace-pre-line">{{ $msg->message }}</p>
                                    </div>
                                    <span class="text-[10px] font-medium text-slate-400 mt-1 px-1 opacity-0 group-hover:opacity-100 transition-opacity">{{ $msg->created_at->format('H:i') }}</span>
                                </div>
                            </div>
                        @endif
                    @empty
                        <div class="flex flex-col items-center justify-center h-full text-center opacity-50 py-10">
                            <div class="w-20 h-20 bg-slate-200 rounded-full flex items-center justify-center mb-4">
                                <svg class="w-10 h-10 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
                            </div>
                            <p class="text-slate-600 font-bold">Mulai Percakapan</p>
                            <p class="text-xs text-slate-500 mt-1 max-w-xs">Kirim pesan untuk berdiskusi terkait spesifikasi material dengan tim Engineer.</p>
                        </div>
                    @endforelse

                    <div id="typing" class="hidden">
                        <div class="flex justify-start">
                            <div class="bg-white border border-slate-200 px-4 py-3 rounded-2xl rounded-tl-sm shadow-sm flex items-center gap-1">
                                <span class="w-2 h-2 bg-slate-400 rounded-full animate-bounce"></span>
                                <span class="w-2 h-2 bg-slate-400 rounded-full animate-bounce" style="animation-delay: 0.1s"></span>
                                <span class="w-2 h-2 bg-slate-400 rounded-full animate-bounce" style="animation-delay: 0.2s"></span>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Chat Input Form --}}
                <div class="p-4 bg-white border-t border-slate-100 z-10">
                    <form action="{{ route('vendor.tenders.chat.send', $invitation->id) }}" method="POST" id="chatForm" enctype="multipart/form-data" class="relative">
                        @csrf
                        
                        {{-- Image Preview Floating --}}
                        <div id="imagePreviewContainer" class="hidden absolute bottom-full left-0 mb-3 bg-white p-2 rounded-xl shadow-lg border border-slate-200">
                            <div class="relative">
                                <img id="imagePreview" src="" class="h-24 w-auto rounded-lg object-cover">
                                <button type="button" id="removeImageBtn" class="absolute -top-2 -right-2 bg-slate-800 text-white rounded-full w-6 h-6 flex items-center justify-center text-xs hover:bg-red-500 transition shadow">&times;</button>
                            </div>
                        </div>

                        <div class="flex items-end gap-2 bg-slate-50 p-2 rounded-2xl border border-slate-200 focus-within:border-blue-300 focus-within:ring-4 focus-within:ring-blue-50 transition-all">
                            
                            <label class="shrink-0 p-2 text-slate-400 hover:text-blue-600 hover:bg-blue-50 rounded-xl cursor-pointer transition">
                                <input type="file" name="attachment" id="attachmentInput" accept="image/*" class="hidden">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            </label>

                            <textarea name="message" id="messageInput" rows="1" 
                                class="flex-1 max-h-32 bg-transparent border-0 focus:ring-0 resize-none text-sm p-2 text-slate-900 placeholder-slate-400"
                                placeholder="Ketik pesan klarifikasi di sini..."></textarea>

                            <button type="submit" id="sendBtn" class="shrink-0 p-3 bg-blue-600 text-white rounded-xl hover:bg-blue-700 transition shadow-sm shadow-blue-600/30">
                                <svg class="w-5 h-5 translate-x-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path></svg>
                            </button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>

    {{-- CHAT ENGINE --}}
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
        const typingEl    = document.getElementById('typing');

        const sendUrl     = "{{ route('vendor.tenders.chat.send', $invitation->id) }}";
        const pollUrl     = "{{ route('vendor.tenders.chat.messages.ajax', $invitation->id) }}";
        const csrfToken   = document.querySelector('meta[name="csrf-token"]').content;

        let lastId    = {{ $messages->last()->id ?? 0 }};
        let isPolling = true;
        let isSending = false;

        /* Auto-resize textarea */
        input.addEventListener('input', function() {
            this.style.height = 'auto';
            this.style.height = (this.scrollHeight) + 'px';
            if(this.value === '') this.style.height = 'auto';
        });

        const escHtml = (s) => {
            const d = document.createElement('div');
            d.appendChild(document.createTextNode(s));
            return d.innerHTML;
        };

        const scrollBottom = () => { chatBox.scrollTop = chatBox.scrollHeight; };

        const toast = (title, body, type = 'info') => {
            if (window.showToastNotification) window.showToastNotification(title, body, type);
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

        const buildBubble = (msg, tempId = null) => {
            const id  = tempId ? `data-temp-id="${tempId}"` : `data-msg-id="${msg.id}"`;
            const isMe = msg.role === 'me';
            const attachmentHtml = msg.attachment_url ? 
                `<div class="mb-2 rounded-xl overflow-hidden bg-white/10 p-1 border border-white/20">
                    <img src="${msg.attachment_url}" class="max-w-full rounded-lg cursor-pointer hover:opacity-90 transition object-cover max-h-48 w-auto" onclick="openLightbox('${msg.attachment_url}')" />
                </div>` : '';
            const attachmentHtmlOther = msg.attachment_url ? 
                `<div class="mb-2 rounded-xl overflow-hidden bg-slate-50 p-1 border border-slate-100">
                    <img src="${msg.attachment_url}" class="max-w-full rounded-lg cursor-pointer hover:opacity-90 transition object-cover max-h-48 w-auto" onclick="openLightbox('${msg.attachment_url}')" />
                </div>` : '';

            const timeStr = msg.time.split(' ')[1] || msg.time;

            if (isMe) {
                return `
                <div class="flex justify-end mb-4 group" ${id}>
                    <div class="max-w-[75%] lg:max-w-[65%] flex flex-col items-end">
                        <span class="text-[10px] font-bold text-slate-400 mb-1 px-1">Anda</span>
                        <div class="bg-blue-600 text-white px-5 py-3.5 rounded-2xl rounded-tr-sm shadow-sm ${tempId ? 'opacity-70' : ''}">
                            ${attachmentHtml}
                            <p class="text-sm leading-relaxed whitespace-pre-line">${escHtml(msg.message || '')}</p>
                        </div>
                        <span class="text-[10px] font-medium text-slate-400 mt-1 px-1 opacity-0 group-hover:opacity-100 transition-opacity">${timeStr}</span>
                    </div>
                </div>`;
            }
            return `
            <div class="flex justify-start mb-4 group" ${id}>
                <div class="max-w-[75%] lg:max-w-[65%] flex flex-col items-start">
                    <span class="text-[10px] font-bold text-slate-400 mb-1 px-1">${escHtml(msg.sender_name || 'Engineer')}</span>
                    <div class="bg-white border border-slate-200 text-slate-800 px-5 py-3.5 rounded-2xl rounded-tl-sm shadow-sm">
                        ${attachmentHtmlOther}
                        <p class="text-sm leading-relaxed whitespace-pre-line">${escHtml(msg.message || '')}</p>
                    </div>
                    <span class="text-[10px] font-medium text-slate-400 mt-1 px-1 opacity-0 group-hover:opacity-100 transition-opacity">${timeStr}</span>
                </div>
            </div>`;
        };

        const appendBubble = (html) => {
            const emptyState = chatBox.querySelector('.flex.flex-col.items-center.justify-center.h-full');
            if(emptyState) emptyState.remove();

            const wrap = document.createElement('div');
            wrap.innerHTML = html.trim();
            const el = wrap.firstElementChild;
            if (typingEl && typingEl.parentNode === chatBox) {
                chatBox.insertBefore(el, typingEl);
            } else {
                chatBox.appendChild(el);
            }
            scrollBottom();
            return el;
        };

        attachmentInput.addEventListener('change', function() {
            if (this.files && this.files[0]) {
                const file = this.files[0];
                if (!file.type.startsWith('image/')) {
                    toast('Error', 'Hanya file gambar.', 'error');
                    this.value = '';
                    return;
                }
                const reader = new FileReader();
                reader.onload = (e) => {
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

        /* Enter to send */
        input.addEventListener('keydown', function(e) {
            if (e.key === 'Enter' && !e.shiftKey) {
                e.preventDefault();
                sendForm.dispatchEvent(new Event('submit'));
            }
        });

        sendForm.addEventListener('submit', async (e) => {
            e.preventDefault();
            const text = input.value.trim();
            const file = attachmentInput.files[0];
            if (!text && !file) return;
            if (isSending) return;

            isSending = true;
            sendBtn.disabled = true;
            sendBtn.innerHTML = `<svg class="w-5 h-5 animate-spin" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>`;

            const tempId = 'temp-' + Date.now();
            const previewUrl = file ? imagePreview.src : null;
            const nowTime = new Date().getHours() + ':' + String(new Date().getMinutes()).padStart(2,'0');
            const el = appendBubble(buildBubble({ role: 'me', message: text, time: nowTime, id: 0, attachment_url: previewUrl }, tempId));

            input.value = '';
            input.style.height = 'auto';
            attachmentInput.value = '';
            imagePreviewContainer.classList.add('hidden');
            input.focus();
            typingEl.classList.add('hidden');

            try {
                const formData = new FormData();
                if (text) formData.append('message', text);
                if (file) {
                    const compressedFile = await compressImage(file);
                    formData.append('attachment', compressedFile);
                }

                const res = await fetch(sendUrl, {
                    method: 'POST',
                    headers: { 'X-CSRF-TOKEN': csrfToken, 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' },
                    body: formData,
                });

                if (res.ok) {
                    el.querySelector('div > div.bg-blue-600')?.classList.remove('opacity-70');
                } else {
                    el.remove();
                    toast('Error', 'Gagal kirim pesan.', 'error');
                }
            } catch (err) {
                el.remove();
                toast('Error', 'Koneksi bermasalah.', 'error');
            } finally {
                isSending = false;
                sendBtn.disabled = false;
                sendBtn.innerHTML = `<svg class="w-5 h-5 translate-x-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path></svg>`;
            }
        });

        const poll = async () => {
            if (!isPolling) return;
            try {
                const res = await fetch(pollUrl, { headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' } });
                const data = await res.json();
                const fresh = data.messages.filter(m => m.id > lastId);
                fresh.forEach(msg => {
                    lastId = Math.max(lastId, msg.id);
                    if (msg.role === 'me') {
                        if (chatBox.querySelector(`[data-msg-id="${msg.id}"]`)) return;
                        const temp = chatBox.querySelector('[data-temp-id]');
                        if (temp) { temp.dataset.msgId = msg.id; delete temp.dataset.tempId; return; }
                    }
                    appendBubble(buildBubble(msg));
                    if (msg.role === 'other') toast('Klarifikasi: ' + msg.sender_name, msg.message.substring(0, 50));
                });
            } catch (e) { }
            setTimeout(poll, 5000);
        };

        input.addEventListener('input', () => {
            typingEl.classList.remove('hidden');
            scrollBottom();
            clearTimeout(window._typingTimer);
            window._typingTimer = setTimeout(() => typingEl.classList.add('hidden'), 1500);
        });

        document.addEventListener('visibilitychange', () => {
            isPolling = !document.hidden;
            if (!document.hidden) poll();
        });

        scrollBottom();
        setTimeout(poll, 5000);
    })();
    </script>

    {{-- LIGHTBOX MODAL --}}
    <div id="imageLightbox" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-slate-900/90 backdrop-blur-sm" onclick="closeLightbox()">
        <div class="relative max-w-5xl max-h-[90vh] mx-4">
            <img id="lightboxImg" src="" alt="Gambar Penuh" class="max-w-full max-h-[85vh] rounded-xl shadow-2xl object-contain" onclick="event.stopPropagation()">
            <button onclick="closeLightbox()" class="absolute -top-4 -right-4 w-10 h-10 bg-white/10 hover:bg-white/20 text-white border border-white/20 rounded-full flex items-center justify-center transition">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
            <a id="lightboxDownload" href="" download target="_blank" onclick="event.stopPropagation()" class="absolute -bottom-6 left-1/2 -translate-x-1/2 px-4 py-2 bg-slate-800 text-white text-xs font-bold rounded-full shadow-lg hover:bg-slate-700 transition flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg> Download
            </a>
        </div>
    </div>
    <script>
    function openLightbox(src) {
        document.getElementById('lightboxImg').src = src;
        document.getElementById('lightboxDownload').href = src;
        document.getElementById('imageLightbox').classList.remove('hidden');
    }
    function closeLightbox() {
        document.getElementById('imageLightbox').classList.add('hidden');
    }
    document.addEventListener('keydown', e => { if (e.key === 'Escape') closeLightbox(); });
    </script>

</x-app-layout>
