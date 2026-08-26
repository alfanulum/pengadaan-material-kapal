<section>
    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="space-y-6">
        @csrf
        @method('patch')

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label for="name" class="block text-sm font-bold text-slate-700 mb-2">{{ __('Nama Lengkap') }}</label>
                <input id="name" name="name" type="text" class="w-full px-4 py-3 rounded-xl border border-slate-200 bg-slate-50 focus:bg-white text-slate-900 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition outline-none font-medium" value="{{ old('name', $user->name) }}" required autofocus autocomplete="name" />
                @error('name')
                    <p class="text-sm text-rose-500 font-medium mt-2">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="email" class="block text-sm font-bold text-slate-700 mb-2">{{ __('Alamat Email') }}</label>
                <input id="email" name="email" type="email" class="w-full px-4 py-3 rounded-xl border border-slate-200 bg-slate-50 focus:bg-white text-slate-900 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition outline-none font-medium" value="{{ old('email', $user->email) }}" required autocomplete="username" />
                @error('email')
                    <p class="text-sm text-rose-500 font-medium mt-2">{{ $message }}</p>
                @enderror

                @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                    <div class="mt-4 p-4 rounded-xl bg-amber-50 border border-amber-200">
                        <p class="text-sm text-amber-800 font-medium">
                            {{ __('Email Anda belum diverifikasi.') }}
                            <button form="send-verification" class="underline text-amber-600 hover:text-amber-900 transition ml-1">
                                {{ __('Kirim ulang email verifikasi.') }}
                            </button>
                        </p>

                        @if (session('status') === 'verification-link-sent')
                            <p class="mt-2 text-sm font-bold text-emerald-600">
                                {{ __('Tautan verifikasi baru telah dikirim ke email Anda.') }}
                            </p>
                        @endif
                    </div>
                @endif
            </div>
        </div>

        <div class="flex items-center gap-4 pt-4">
            <button type="submit" class="inline-flex items-center gap-2 px-6 py-3 bg-slate-900 text-white rounded-xl font-bold shadow-md hover:bg-blue-900 hover:-translate-y-0.5 transition-all">
                {{ __('Simpan Perubahan') }}
            </button>

            @if (session('status') === 'profile-updated')
                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)" class="text-sm font-bold text-emerald-600 flex items-center gap-1.5">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    {{ __('Berhasil disimpan.') }}
                </p>
            @endif
        </div>
    </form>
</section>
