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
            <form method="POST" action="{{ route('supply-chain.chat.negosiasi.send', [$tenderId, $vendorId]) }}" id="chatForm"
                class="p-4 border-t bg-white flex gap-3">

                @csrf

                <input type="text" name="message" id="messageInput" required
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

        /* ── Build bubble ── */
        const buildBubble = (msg, tempId = null) => {
            const id  = tempId ? `data-temp-id="${tempId}"` : `data-msg-id="${msg.id}"`;
            const isMe = msg.role === 'me';

            if (isMe) {
                return `<div class="flex justify-end" ${id}>
                    <div class="max-w-[70%]">
                        <div class="bg-blue-600 text-white px-4 py-3 rounded-2xl shadow-md ${tempId ? 'opacity-70' : ''}">
                            ${escHtml(msg.message)}
                        </div>
                        <div class="text-xs text-right text-slate-400 mt-1">${msg.time}</div>
                    </div>
                </div>`;
            }
            return `<div class="flex justify-start" ${id}>
                <div class="max-w-[70%]">
                    <div class="bg-white border px-4 py-3 rounded-2xl shadow-sm">
                        <div class="text-xs font-semibold text-slate-500 mb-1">{{ $vendor->nama_vendor }}</div>
                        ${escHtml(msg.message)}
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

        /* ── AJAX SEND ── */
        sendForm.addEventListener('submit', async (e) => {
            e.preventDefault();

            const text = input.value.trim();
            if (!text || isSending) return;

            isSending = true;
            sendBtn.disabled = true;
            sendBtn.innerHTML = `<span class="inline-block w-4 h-4 border-2 border-white border-t-transparent rounded-full animate-spin"></span>`;

            // Optimistic UI: show bubble immediately
            const tempId = 'temp-' + Date.now();
            const el = appendBubble(buildBubble({ role: 'me', message: text, time: now(), id: 0 }, tempId));

            input.value = '';
            input.focus();

            try {
                const res = await fetch(sendUrl, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                        'X-CSRF-TOKEN': csrfToken,
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json',
                    },
                    body: new URLSearchParams({ message: text }),
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
