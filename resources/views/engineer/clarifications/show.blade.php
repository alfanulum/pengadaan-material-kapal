<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3">
            <div>
                <h2 class="font-bold text-2xl text-slate-900 leading-tight">
                    Chat Klarifikasi Spesifikasi
                </h2>
                <p class="text-sm text-slate-500 mt-1">
                    Jawab pertanyaan vendor terkait spesifikasi material.
                </p>
            </div>

            <a href="{{ route('engineer.clarifications.index') }}"
                class="inline-flex items-center justify-center px-5 py-3 bg-slate-100 text-slate-700 rounded-xl font-semibold border border-slate-200 hover:bg-slate-200 transition">
                Kembali ke Klarifikasi
            </a>
        </div>
    </x-slot>

    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">

        @if (session('success'))
            <div class="mb-6 bg-green-50 border border-green-200 text-green-700 p-4 rounded-2xl">
                {{ session('success') }}
            </div>
        @endif

        <div class="bg-gradient-to-r from-slate-950 via-blue-950 to-blue-800 rounded-3xl p-8 shadow-xl text-white mb-8">
            <p class="inline-flex px-4 py-2 rounded-full bg-white/10 border border-white/10 text-sm text-blue-100 mb-5">
                {{ $tender->kode_tender }}
            </p>

            <h3 class="text-3xl font-bold">
                {{ $tender->nama_tender }}
            </h3>

            <p class="text-blue-100 mt-3">
                Vendor: {{ $vendor->nama_vendor }}
            </p>
        </div>

        <div class="bg-white rounded-3xl shadow-sm border border-slate-200 overflow-hidden">

            {{-- Header Chat --}}
            <div class="px-6 py-5 border-b border-slate-200 bg-white">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3">
                    <div>
                        <h3 class="text-xl font-bold text-slate-900">
                            Percakapan Klarifikasi Spesifikasi
                        </h3>
                        <p class="text-sm text-slate-500 mt-1">
                            Chat antara Vendor dan Engineer untuk memastikan spesifikasi material sudah jelas.
                        </p>
                    </div>

                    <div class="inline-flex items-center gap-2 px-4 py-2 rounded-2xl bg-blue-50 border border-blue-100">
                        <span class="w-2.5 h-2.5 rounded-full bg-blue-600"></span>
                        <span class="text-sm font-bold text-blue-800">
                            Mode Chat Teknis
                        </span>
                    </div>
                </div>
            </div>

            {{-- Chat Area --}}
            <div class="p-6 md:p-8 max-h-[560px] overflow-y-auto space-y-5 bg-slate-50">

                @forelse ($messages as $chat)
                    @if ($chat->sender_id == auth()->id())
                        {{-- Bubble Engineer --}}
                        <div class="flex justify-end">
                            <div class="max-w-[78%]">
                                <div class="mb-1 text-right">
                                    <span class="text-xs font-bold text-blue-800">
                                        Engineer
                                    </span>
                                </div>

                                <div class="rounded-3xl rounded-tr-md bg-blue-900 text-white px-5 py-4 shadow-sm">
                                    <p class="text-base leading-relaxed">
                                        {{ $chat->message }}
                                    </p>

                                    <p class="text-xs text-blue-100 mt-3">
                                        {{ $chat->created_at->format('d-m-Y H:i') }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    @else
                        {{-- Bubble Vendor --}}
                        <div class="flex justify-start">
                            <div class="max-w-[78%]">
                                <div class="mb-1">
                                    <span class="text-xs font-bold text-slate-600">
                                        {{ $chat->sender->name ?? 'Vendor' }}
                                    </span>
                                </div>

                                <div
                                    class="rounded-3xl rounded-tl-md bg-white border border-slate-200 text-slate-800 px-5 py-4 shadow-sm">
                                    <p class="text-base leading-relaxed">
                                        {{ $chat->message }}
                                    </p>

                                    <p class="text-xs text-slate-400 mt-3">
                                        {{ $chat->created_at->format('d-m-Y H:i') }}
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
                            Pertanyaan vendor terkait spesifikasi akan tampil di sini.
                        </p>
                    </div>
                @endforelse

            </div>

            {{-- Form Balasan --}}
            <form action="{{ route('engineer.clarifications.reply', [$tender->id, $vendor->id]) }}" method="POST"
                class="p-6 md:p-8 border-t border-slate-200 bg-white">
                @csrf

                <div class="mb-4">
                    <h4 class="text-lg font-bold text-slate-900">
                        Balas Klarifikasi
                    </h4>
                    <p class="text-sm text-slate-500 mt-1">
                        Tulis jawaban teknis yang akan dikirim kepada vendor.
                    </p>
                </div>

                <textarea name="message" rows="5"
                    class="w-full rounded-2xl border-slate-300 focus:border-blue-800 focus:ring-blue-800 text-base"
                    placeholder="Contoh: Gunakan material grade AH36 sesuai kebutuhan konstruksi kapal.">{{ old('message') }}</textarea>

                @error('message')
                    <p class="text-sm text-red-600 mt-2">{{ $message }}</p>
                @enderror

                <div class="mt-5 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                    <p class="text-xs text-slate-400">
                        Jawaban ini akan langsung tampil di halaman detail tender vendor.
                    </p>

                    <button type="submit"
                        class="inline-flex items-center justify-center px-8 py-4 bg-blue-900 text-white rounded-2xl font-bold hover:bg-blue-950 transition shadow-lg">
                        Kirim Jawaban
                    </button>
                </div>
            </form>
        </div>

    </div>
</x-app-layout>
