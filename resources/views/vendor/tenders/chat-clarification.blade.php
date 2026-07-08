<x-app-layout>

    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3">

            <div>
                <h2 class="font-bold text-2xl text-slate-900 leading-tight">
                    Percakapan Klarifikasi Spesifikasi
                </h2>
                <p class="text-sm text-slate-500 mt-1">
                    Chat antara Vendor dan Engineer untuk memastikan spesifikasi material sudah jelas.
                </p>
            </div>

            <a href="{{ route('vendor.tenders.show', $invitation->id) }}"
                class="inline-flex items-center justify-center px-5 py-3 bg-slate-100 text-slate-700 rounded-xl font-semibold border border-slate-200 hover:bg-slate-200 transition">
                Kembali ke Tender
            </a>

        </div>
    </x-slot>

    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">

        {{-- HERO --}}
        <div
            class="bg-gradient-to-r from-slate-950 via-blue-950 to-blue-800 rounded-3xl p-8 shadow-xl text-white mb-8 relative overflow-hidden">

            <div class="absolute -top-24 -right-24 w-80 h-80 bg-cyan-400/20 rounded-full blur-3xl"></div>

            <p class="inline-flex px-4 py-2 rounded-full bg-white/10 border border-white/10 text-sm text-blue-100 mb-5">
                {{ $invitation->tender->kode_tender }}
            </p>

            <h3 class="text-3xl font-bold">
                {{ $invitation->tender->nama_tender }}
            </h3>

            <p class="text-blue-100 mt-2">
                Vendor: {{ $invitation->vendor->nama_vendor ?? 'Anda' }}
            </p>

        </div>

        {{-- CHAT CARD --}}
        <div class="bg-white rounded-3xl shadow-sm border border-slate-200 overflow-hidden">

            {{-- HEADER --}}
            <div class="px-6 py-5 border-b border-slate-200 bg-white">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3">

                    <div>
                        <h3 class="text-xl font-bold text-slate-900">
                            Percakapan Klarifikasi Spesifikasi
                        </h3>
                        <p class="text-sm text-slate-500 mt-1">
                            Diskusi teknis antara Vendor dan Engineer.
                        </p>
                    </div>

                    <div class="inline-flex items-center gap-2 px-4 py-2 rounded-2xl bg-blue-50 border border-blue-100">
                        <span class="w-2.5 h-2.5 rounded-full bg-blue-600 animate-pulse"></span>
                        <span class="text-sm font-bold text-blue-800">
                            Mode Chat Teknis
                        </span>
                    </div>

                </div>
            </div>

            {{-- CHAT AREA --}}
            <div id="chatBox" class="p-6 md:p-8 max-h-[560px] overflow-y-auto space-y-5 bg-slate-50">

                @forelse ($messages as $msg)
                    @if ($msg->sender_id == auth()->id())
                        {{-- VENDOR --}}
                        <div class="flex justify-end">
                            <div class="max-w-[75%]">

                                <div class="mb-1 text-right">
                                    <span class="text-xs font-bold text-blue-800">
                                        Anda / Vendor
                                    </span>
                                </div>

                                <div class="rounded-3xl rounded-tr-md bg-blue-900 text-white px-5 py-4 shadow-sm">
                                    @if ($msg->attachment)
                                        <img src="{{ asset('storage/' . $msg->attachment) }}" class="max-w-full rounded mb-2" alt="Lampiran">
                                    @endif
                                    <p class="text-base leading-relaxed whitespace-pre-line">
                                        {{ $msg->message }}
                                    </p>

                                    <p class="text-xs text-blue-100 mt-3 text-right">
                                        {{ $msg->created_at->format('d-m-Y H:i') }}
                                    </p>

                                </div>

                            </div>
                        </div>
                    @else
                        {{-- ENGINEER --}}
                        <div class="flex justify-start">
                            <div class="max-w-[75%]">

                                <div class="mb-1">
                                    <span class="text-xs font-bold text-slate-600">
                                        Engineer
                                    </span>
                                </div>

                                <div
                                    class="rounded-3xl rounded-tl-md bg-white border border-slate-200 text-slate-800 px-5 py-4 shadow-sm">
                                    @if ($msg->attachment)
                                        <img src="{{ asset('storage/' . $msg->attachment) }}" class="max-w-full rounded mb-2" alt="Lampiran">
                                    @endif
                                    <p class="text-base leading-relaxed whitespace-pre-line">
                                        {{ $msg->message }}
                                    </p>

                                    <p class="text-xs text-slate-400 mt-3">
                                        {{ $msg->created_at->format('d-m-Y H:i') }}
                                    </p>

                                </div>

                            </div>
                        </div>
                    @endif

                @empty

                    <div class="text-center py-16">
                        <div
                            class="mx-auto w-16 h-16 rounded-2xl bg-slate-100 text-slate-400 flex items-center justify-center font-bold mb-4">
                            CH
                        </div>

                        <h3 class="text-lg font-bold text-slate-900">
                            Belum Ada Percakapan
                        </h3>

                        <p class="text-sm text-slate-500 mt-2">
                            Mulai chat untuk klarifikasi spesifikasi dengan engineer.
                        </p>
                    </div>
                @endforelse

                {{-- TYPING INDICATOR --}}
                <div id="typing" class="hidden text-sm text-slate-500">
                    Engineer sedang mengetik...
                </div>

            </div>

            {{-- INPUT --}}
            <form action="{{ route('vendor.tenders.chat.send', $invitation->id) }}" method="POST" id="chatForm" enctype="multipart/form-data"
                class="relative p-6 md:p-8 border-t border-slate-200 bg-white flex gap-3 items-center">

                @csrf

                <div id="imagePreviewContainer" class="hidden absolute bottom-full left-6 mb-2 border border-slate-200 p-2 bg-white rounded-lg shadow-lg">
                    <img id="imagePreview" src="" class="max-h-32 rounded">
                    <button type="button" id="removeImageBtn" class="absolute -top-2 -right-2 bg-red-500 text-white rounded-full w-6 h-6 flex items-center justify-center font-bold shadow">&times;</button>
                </div>

                <label class="cursor-pointer text-slate-500 hover:text-blue-800 transition" title="Lampirkan Gambar">
                    <input type="file" name="attachment" id="attachmentInput" accept="image/*" class="hidden">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                </label>

                <input type="text" name="message" id="messageInput"
                    class="flex-1 rounded-2xl border-slate-300 focus:border-blue-800 focus:ring-blue-800"
                    placeholder="Tulis pesan...">

                <button type="submit" id="sendBtn"
                    class="px-6 py-3 bg-blue-900 text-white rounded-2xl font-bold hover:bg-blue-950 transition">
                    Kirim
                </button>

            </form>

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
        const typingEl    = document.getElementById('typing');

        const sendUrl     = "{{ route('vendor.tenders.chat.send', $invitation->id) }}";
        const pollUrl     = "{{ route('vendor.tenders.chat.messages.ajax', $invitation->id) }}";
        const csrfToken   = document.querySelector('meta[name="csrf-token"]').content;

        let lastId    = {{ $messages->last()->id ?? 0 }};
        let isPolling = true;
        let isSending = false;

        /* ── Helpers ── */
        const now = () => {
            const d = new Date();
            return `${String(d.getDate()).padStart(2,'0')}-${String(d.getMonth()+1).padStart(2,'0')}-${d.getFullYear()} ${String(d.getHours()).padStart(2,'0')}:${String(d.getMinutes()).padStart(2,'0')}`;
        };

        const escHtml = (s) => {
            const d = document.createElement('div');
            d.appendChild(document.createTextNode(s));
            return d.innerHTML;
        };

        const scrollBottom = () => { chatBox.scrollTop = chatBox.scrollHeight; };

        const toast = (title, body, type = 'info') => {
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
            const attachmentHtml = msg.attachment_url ? `<img src="${msg.attachment_url}" class="max-w-full rounded mb-2" />` : '';

            if (isMe) {
                return `<div class="flex justify-end" ${id}>
                    <div class="max-w-[75%]">
                        <div class="mb-1 text-right">
                            <span class="text-xs font-bold text-blue-800">Anda / Vendor</span>
                        </div>
                        <div class="rounded-3xl rounded-tr-md bg-blue-900 text-white px-5 py-4 shadow-sm ${tempId ? 'opacity-70' : ''}">
                            ${attachmentHtml}
                            <p class="text-base leading-relaxed whitespace-pre-line">${escHtml(msg.message || '')}</p>
                            <p class="text-xs text-blue-100 mt-3 text-right">${msg.time}</p>
                        </div>
                    </div>
                </div>`;
            }
            return `<div class="flex justify-start" ${id}>
                <div class="max-w-[75%]">
                    <div class="mb-1">
                        <span class="text-xs font-bold text-slate-600">${escHtml(msg.sender_name || 'Engineer')}</span>
                    </div>
                    <div class="rounded-3xl rounded-tl-md bg-white border border-slate-200 text-slate-800 px-5 py-4 shadow-sm">
                        ${attachmentHtml}
                        <p class="text-base leading-relaxed whitespace-pre-line">${escHtml(msg.message || '')}</p>
                        <p class="text-xs text-slate-400 mt-3">${msg.time}</p>
                    </div>
                </div>
            </div>`;
        };

        const appendBubble = (html) => {
            document.querySelector('#chatBox .text-center.py-16')?.remove();
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
                    toast('Error', 'Hanya file gambar yang diperbolehkan.', 'error');
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

        /* ── AJAX SEND ── */
        sendForm.addEventListener('submit', async (e) => {
            e.preventDefault();

            const text = input.value.trim();
            const file = attachmentInput.files[0];

            if (!text && !file) return;
            if (isSending) return;

            isSending = true;
            sendBtn.disabled = true;
            sendBtn.innerHTML = `<span class="inline-block w-4 h-4 border-2 border-white border-t-transparent rounded-full animate-spin"></span>`;

            // Optimistic UI
            const tempId = 'temp-' + Date.now();
            const previewUrl = file ? imagePreview.src : null;
            const el = appendBubble(buildBubble({ role: 'me', message: text, time: now(), id: 0, attachment_url: previewUrl }, tempId));

            input.value = '';
            attachmentInput.value = '';
            imagePreview.src = '';
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
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json',
                    },
                    body: formData,
                });

                if (res.ok) {
                    // Confirm: remove temp opacity
                    el.querySelector('div > div')?.classList.remove('opacity-70');
                } else {
                    el.remove();
                    toast('Gagal Kirim', 'Pesan gagal dikirim, coba lagi.', 'error');
                    input.value = text;
                }
            } catch (err) {
                el.remove();
                toast('Koneksi Error', 'Periksa koneksi internet Anda.', 'error');
                input.value = text;
            } finally {
                isSending = false;
                sendBtn.disabled = false;
                sendBtn.innerHTML = 'Kirim';
            }
        });

        /* ── POLLING (5s) ── */
        const poll = async () => {
            if (!isPolling) return;
            try {
                const res  = await fetch(pollUrl, {
                    headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' }
                });
                const data = await res.json();

                const fresh = data.messages.filter(m => m.id > lastId);

                fresh.forEach(msg => {
                    lastId = Math.max(lastId, msg.id);

                    // Skip if we already have a temp bubble for our own message
                    if (msg.role === 'me') {
                        const existing = chatBox.querySelector(`[data-msg-id="${msg.id}"]`);
                        if (existing) return;
                        // Promote temp bubble if exists
                        const temp = chatBox.querySelector('[data-temp-id]');
                        if (temp) {
                            temp.dataset.msgId = msg.id;
                            delete temp.dataset.tempId;
                            return;
                        }
                    }

                    appendBubble(buildBubble(msg));

                    if (msg.role === 'other') {
                        if (window.showToastNotification) {
                            window.showToastNotification('💬 Klarifikasi dari ' + msg.sender_name, msg.message.substring(0, 80));
                        }
                    }
                });

            } catch (e) { /* silent */ }

            setTimeout(poll, 5000);
        };

        /* ── Typing indicator ── */
        input.addEventListener('input', () => {
            typingEl.classList.remove('hidden');
            clearTimeout(window._typingTimer);
            window._typingTimer = setTimeout(() => typingEl.classList.add('hidden'), 1500);
        });

        /* ── Visibility API: pause/resume polling ── */
        document.addEventListener('visibilitychange', () => {
            isPolling = !document.hidden;
            if (!document.hidden) poll();
        });

        /* ── Init ── */
        scrollBottom();
        setTimeout(poll, 5000);
    })();
    </script>

</x-app-layout>
