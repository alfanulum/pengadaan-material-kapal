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
            <form action="{{ route('vendor.tenders.chat.send', $invitation->id) }}" method="POST"
                class="p-6 md:p-8 border-t border-slate-200 bg-white flex gap-3 items-center">

                @csrf

                <input type="text" name="message" id="messageInput" required
                    class="flex-1 rounded-2xl border-slate-300 focus:border-blue-800 focus:ring-blue-800"
                    placeholder="Tulis pesan...">

                <button type="submit" id="sendBtn"
                    class="px-6 py-3 bg-blue-900 text-white rounded-2xl font-bold hover:bg-blue-950 transition">
                    Kirim
                </button>

            </form>

        </div>

    </div>

    {{-- AUTO SCROLL + TYPING SCRIPT --}}
    <script>
        function scrollToBottom() {
            let chatBox = document.getElementById('chatBox');
            chatBox.scrollTop = chatBox.scrollHeight;
        }

        window.onload = scrollToBottom;

        // typing indicator (simple demo)
        let input = document.getElementById('messageInput');
        let typing = document.getElementById('typing');

        input.addEventListener('input', function() {
            typing.classList.remove('hidden');

            clearTimeout(window.typingTimer);
            window.typingTimer = setTimeout(() => {
                typing.classList.add('hidden');
            }, 1000);
        });
    </script>

</x-app-layout>
