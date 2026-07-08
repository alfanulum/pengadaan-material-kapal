<x-app-layout>

    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3">

            <div>
                <h2 class="text-2xl font-bold text-slate-900">
                    Negotiation Center
                </h2>
                <p class="text-sm text-slate-500">
                    Tender conversation hub per vendor
                </p>
            </div>

            <a href="{{ route('supply-chain.tenders.show', $tenderId) }}"
                class="px-5 py-3 rounded-xl bg-white border shadow-sm hover:shadow-md transition">
                Back to Tender Detail
            </a>

        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto px-4 lg:px-8 py-6">

        {{-- HERO --}}
        <div
            class="relative overflow-hidden rounded-3xl p-8 text-white shadow-xl
                bg-gradient-to-r from-slate-950 via-indigo-900 to-blue-800">

            <div class="absolute -top-20 -right-20 w-72 h-72 bg-white/10 blur-3xl rounded-full"></div>
            <div class="absolute -bottom-20 -left-20 w-72 h-72 bg-cyan-400/10 blur-3xl rounded-full"></div>

            <h3 class="text-2xl font-bold relative z-10">
                {{ $tender->nama_tender }}
            </h3>

            <p class="text-sm text-blue-100 mt-2 relative z-10">
                Select vendor to continue negotiation
            </p>
        </div>

        {{-- LIST --}}
        <div class="mt-6 grid gap-4">

            @forelse($vendors as $item)
                @php
                    $vendor = $item->vendor;
                    $unread = $item->unread ?? 0;
                    $lastMessage = $item->last_message ?? null;
                @endphp

                <a href="{{ route('supply-chain.chat.negosiasi.show', [$tenderId, $vendor->id]) }}"
                    class="group bg-white border rounded-2xl p-5 hover:shadow-lg transition">

                    <div class="flex items-start justify-between">

                        <div>

                            <div class="flex items-center gap-2">

                                <h4 class="font-semibold text-slate-900 group-hover:text-blue-600 transition">
                                    {{ $vendor->nama_vendor }}
                                </h4>

                                {{-- UNREAD BADGE --}}
                                @if ($unread > 0)
                                    <span class="px-2 py-1 text-xs rounded-full bg-red-500 text-white animate-pulse">
                                        {{ $unread }}
                                    </span>
                                @endif

                                {{-- STATUS BADGE --}}
                                <span class="px-2 py-1 text-xs rounded-full bg-indigo-100 text-indigo-700">
                                    Negotiation
                                </span>

                            </div>

                            <p class="text-sm text-slate-500 mt-1">
                                Click to open conversation
                            </p>

                            @if ($lastMessage)
                                <p class="text-sm text-slate-700 mt-2 line-clamp-1">
                                    {{ $lastMessage->message }}
                                </p>
                            @endif

                        </div>

                        <div class="text-right text-xs text-slate-400">
                            ▶
                        </div>

                    </div>

                </a>

            @empty

                <div class="text-center py-16 text-slate-400">
                    No negotiation chats yet
                </div>
            @endforelse

        </div>

    </div>

</x-app-layout>
