<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3">
            <div>
                <h2 class="font-bold text-2xl text-slate-900 leading-tight">
                    Klarifikasi Spesifikasi
                </h2>
                <p class="text-sm text-slate-500 mt-1">
                    Pertanyaan vendor terkait spesifikasi material pada tender.
                </p>
            </div>

            <a href="{{ route('engineer.dashboard') }}"
                class="inline-flex items-center justify-center px-5 py-3 bg-slate-100 text-slate-700 rounded-xl font-semibold border border-slate-200 hover:bg-slate-200 transition">
                Kembali ke Dashboard
            </a>
        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <div
            class="bg-gradient-to-r from-slate-950 via-blue-950 to-blue-800 rounded-3xl p-8 md:p-10 shadow-xl text-white mb-8 overflow-hidden relative">
            <div class="absolute -top-24 -right-24 w-80 h-80 bg-cyan-400/20 rounded-full blur-3xl"></div>
            <div class="absolute -bottom-24 -left-24 w-80 h-80 bg-blue-400/20 rounded-full blur-3xl"></div>

            <div class="relative z-10">
                <p
                    class="inline-flex px-4 py-2 rounded-full bg-white/10 border border-white/10 text-sm text-blue-100 mb-5">
                    Technical Clarification
                </p>

                <h3 class="text-3xl md:text-4xl font-bold leading-tight">
                    Pertanyaan Spesifikasi dari Vendor
                </h3>

                <p class="mt-4 text-blue-100 max-w-3xl text-base leading-relaxed">
                    Engineer dapat menjawab pertanyaan teknis agar vendor memahami kebutuhan material sebelum mengirim
                    penawaran.
                </p>
            </div>
        </div>

        <div class="bg-white rounded-3xl shadow-sm border border-slate-200 overflow-hidden">
            <div class="px-6 py-5 border-b border-slate-200">
                <h3 class="text-lg font-bold text-slate-900">
                    Daftar Klarifikasi
                </h3>
            </div>

            <div class="divide-y divide-slate-100">
                @forelse ($clarifications as $group)
                    @php
                        $first = $group->first();

                        $lastMessage = $group->sortByDesc('created_at')->first();

                        $unreadCount = $group
                            ->where('status', 'terkirim')
                            ->where('sender_id', '!=', auth()->id())
                            ->count();

                        $totalMessages = $group->count();
                    @endphp

                    <a href="{{ route('engineer.clarifications.show', [$first->tender_id, $first->vendor_id]) }}"
                        class="block p-6 transition duration-200
        {{ $unreadCount > 0 ? 'bg-red-50 border-l-4 border-red-500 hover:bg-red-100' : 'hover:bg-slate-50' }}">

                        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">

                            <div class="flex-1">

                                <div class="flex items-center gap-2 flex-wrap">

                                    <h4 class="font-bold text-slate-900 text-lg">
                                        {{ $first->tender->nama_tender ?? '-' }}
                                    </h4>

                                    @if ($unreadCount > 0)
                                        <span
                                            class="inline-flex items-center px-3 py-1 rounded-full bg-red-100 text-red-700 text-xs font-semibold">
                                            {{ $unreadCount }} Pesan Baru
                                        </span>
                                    @endif

                                </div>

                                <p class="text-sm text-slate-500 mt-1">
                                    Vendor : {{ $first->vendor->nama_vendor ?? '-' }}
                                </p>

                                <p class="text-sm text-slate-700 mt-3 leading-relaxed">
                                    {{ \Illuminate\Support\Str::limit($lastMessage->message, 120) }}
                                </p>

                                <div class="flex items-center gap-2 mt-4">

                                    <span
                                        class="inline-flex items-center px-3 py-1 rounded-full bg-slate-100 text-slate-600 text-xs">
                                        {{ $totalMessages }} Pesan
                                    </span>

                                    <span
                                        class="inline-flex items-center px-3 py-1 rounded-full bg-blue-100 text-blue-700 text-xs">
                                        Klarifikasi Teknis
                                    </span>

                                </div>

                            </div>

                            <div class="text-right shrink-0">

                                <p class="text-sm font-medium text-slate-700">
                                    {{ $lastMessage->created_at->format('d-m-Y') }}
                                </p>

                                <p class="text-xs text-slate-400 mt-1">
                                    {{ $lastMessage->created_at->format('H:i') }}
                                </p>

                            </div>

                        </div>

                    </a>
                @empty
                    <div class="px-6 py-16 text-center">

                        <div
                            class="mx-auto w-16 h-16 rounded-2xl bg-slate-100 text-slate-400 flex items-center justify-center font-bold mb-4">
                            CH
                        </div>

                        <h3 class="text-lg font-bold text-slate-900">
                            Belum Ada Pertanyaan
                        </h3>

                        <p class="text-sm text-slate-500 mt-2">
                            Pertanyaan vendor terkait spesifikasi akan tampil di halaman ini.
                        </p>

                    </div>
                @endforelse
            </div>
        </div>

    </div>
</x-app-layout>
