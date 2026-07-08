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
            <form method="POST" action="{{ route('supply-chain.chat.negosiasi.send', [$tenderId, $vendorId]) }}"
                class="p-4 border-t bg-white flex gap-3">

                @csrf

                <input type="text" name="message"
                    class="flex-1 rounded-2xl border-slate-200 focus:border-blue-500 focus:ring-blue-500"
                    placeholder="Type negotiation message...">

                <button class="px-6 py-3 rounded-2xl bg-blue-600 text-white font-semibold hover:bg-blue-700 transition">
                    Send
                </button>

            </form>

        </div>

    </div>

    <script>
        let box = document.getElementById('chatBox');
        box.scrollTop = box.scrollHeight;
    </script>

</x-app-layout>
