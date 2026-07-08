<x-app-layout>

    <x-slot name="header">
        <div class="flex justify-between items-center">

            <div>
                <h2 class="text-2xl font-bold text-slate-900">
                    {{ $vendor->nama_vendor }}
                </h2>
                <p class="text-sm text-slate-500">
                    {{ $tender->nama_tender }}
                </p>
            </div>

            <a href="{{ route('supply-chain.chat.negosiasi.index', $tenderId) }}"
                class="px-5 py-3 bg-white border rounded-xl shadow-sm hover:shadow-md transition">
                Back
            </a>

        </div>
    </x-slot>

    <div class="max-w-5xl mx-auto px-4 lg:px-8 py-6">

        <div class="bg-white border rounded-3xl shadow-sm overflow-hidden">

            {{-- HEADER --}}
            <div class="p-5 bg-gradient-to-r from-slate-950 to-indigo-900 text-white">
                <h3 class="font-bold">Negotiation Chat</h3>
                <p class="text-sm text-blue-100">Commercial discussion thread</p>
            </div>

            {{-- CHAT AREA --}}
            <div id="chatBox" class="h-[550px] overflow-y-auto p-6 space-y-4 bg-slate-50">

                @forelse($messages as $msg)
                    @if ($msg->sender_id == auth()->id())
                        {{-- SENDER --}}
                        <div class="flex justify-end">
                            <div class="max-w-[70%]">

                                <div class="bg-blue-600 text-white px-4 py-3 rounded-2xl shadow-md">
                                    @if ($msg->attachment)
                                        <img src="{{ asset('storage/' . $msg->attachment) }}" class="max-w-full rounded mb-2" alt="Lampiran">
                                    @endif
                                    {{ $msg->message }}
                                </div>

                                <div class="text-xs text-right text-slate-400 mt-1">
                                    {{ $msg->created_at->format('d M H:i') }}
                                </div>

                            </div>
                        </div>
                    @else
                        {{-- VENDOR --}}
                        <div class="flex justify-start">
                            <div class="max-w-[70%]">

                                <div class="bg-white border px-4 py-3 rounded-2xl shadow-sm">
                                    <div class="text-xs font-semibold text-slate-500 mb-1">
                                        {{ $vendor->nama_vendor }}
                                    </div>
                                    @if ($msg->attachment)
                                        <img src="{{ asset('storage/' . $msg->attachment) }}" class="max-w-full rounded mb-2" alt="Lampiran">
                                    @endif
                                    {{ $msg->message }}
                                </div>

                                <div class="text-xs text-slate-400 mt-1">
                                    {{ $msg->created_at->format('d M H:i') }}
                                </div>

                            </div>
                        </div>
                    @endif

                @empty

                    <div class="text-center text-slate-400 py-20">
                        No messages yet
                    </div>
                @endforelse

            </div>

            {{-- INPUT BAR (MODERN FLOAT STYLE) --}}
            <form method="POST" action="{{ route('supply-chain.chat.negosiasi.send', [$tenderId, $vendorId]) }}" id="chatForm" enctype="multipart/form-data"
                class="relative p-4 border-t bg-white flex gap-3 items-center">

                @csrf

                <div id="imagePreviewContainer" class="hidden absolute bottom-full left-4 mb-2 border border-slate-200 p-2 bg-white rounded-lg shadow-lg">
                    <img id="imagePreview" src="" class="max-h-32 rounded">
                    <button type="button" id="removeImageBtn" class="absolute -top-2 -right-2 bg-red-500 text-white rounded-full w-6 h-6 flex items-center justify-center font-bold shadow">&times;</button>
                </div>

                <label class="cursor-pointer text-slate-500 hover:text-blue-600 transition" title="Lampirkan Gambar">
                    <input type="file" name="attachment" id="attachmentInput" accept="image/*" class="hidden">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                </label>

                <input type="text" name="message" id="messageInput"
                    class="flex-1 rounded-2xl border-slate-200 focus:border-blue-500 focus:ring-blue-500"
                    placeholder="Type negotiation message...">

                <button type="submit" id="sendBtn" class="px-6 py-3 rounded-2xl bg-blue-600 text-white font-semibold hover:bg-blue-700 transition">
                    Send
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

        const sendUrl     = "{{ route('supply-chain.chat.negosiasi.send', [$tenderId, $vendorId]) }}";
        const pollUrl     = "{{ route('supply-chain.chat.negosiasi.messages.ajax', [$tenderId, $vendorId]) }}";
        const csrfToken   = document.querySelector('meta[name="csrf-token"]').content;

        let lastId    = {{ $messages->last()->id ?? 0 }};
        let isPolling = true;
        let isSending = false;

        /* ── Helpers ── */
        const now = () => {
            const d = new Date();
            const months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
            return `${d.getDate()} ${months[d.getMonth()]} ${String(d.getHours()).padStart(2,'0')}:${String(d.getMinutes()).padStart(2,'0')}`;
        };

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
            const attachmentHtml = msg.attachment_url ? `<img src="${msg.attachment_url}" class="max-w-full rounded mb-2" />` : '';

            if (isMe) {
                return `<div class="flex justify-end" ${id}>
                    <div class="max-w-[70%]">
                        <div class="bg-blue-600 text-white px-4 py-3 rounded-2xl shadow-md ${tempId ? 'opacity-70' : ''}">
                            ${attachmentHtml}
                            ${escHtml(msg.message || '')}
                        </div>
                        <div class="text-xs text-right text-slate-400 mt-1">${msg.time}</div>
                    </div>
                </div>`;
            }
            return `<div class="flex justify-start" ${id}>
                <div class="max-w-[70%]">
                    <div class="bg-white border px-4 py-3 rounded-2xl shadow-sm">
                        <div class="text-xs font-semibold text-slate-500 mb-1">{{ $vendor->nama_vendor }}</div>
                        ${attachmentHtml}
                        ${escHtml(msg.message || '')}
                    </div>
                    <div class="text-xs text-slate-400 mt-1">${msg.time}</div>
                </div>
            </div>`;
        };

        const appendBubble = (html) => {
            document.querySelector('#chatBox .text-center.text-slate-400.py-20')?.remove();
            const wrap = document.createElement('div');
            wrap.innerHTML = html.trim();
            const el = wrap.firstElementChild;
            chatBox.appendChild(el);
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
                    el.querySelector('div > div')?.classList.remove('opacity-70');
                } else {
                    el.remove();
                    toast('Error Sending', 'Failed to send message, please retry.', 'error');
                    input.value = text;
                }
            } catch (err) {
                el.remove();
                toast('Network Error', 'Please check your connection.', 'error');
                input.value = text;
            } finally {
                isSending = false;
                sendBtn.disabled = false;
                sendBtn.innerHTML = 'Send';
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

                    if (msg.role === 'me') {
                        const existing = chatBox.querySelector(`[data-msg-id="${msg.id}"]`);
                        if (existing) return;
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
                            window.showToastNotification('💰 Negosiasi dari ' + msg.sender_name, msg.message.substring(0, 80));
                        }
                    }
                });

            } catch (e) { /* silent */ }

            setTimeout(poll, 5000);
        };

        /* ── Visibility API ── */
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
