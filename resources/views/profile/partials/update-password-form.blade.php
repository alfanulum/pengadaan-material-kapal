<section>
    <form method="post" action="{{ route('password.update') }}" class="space-y-6">
        @csrf
        @method('put')

        <div class="space-y-6">
            <div>
                <label for="update_password_current_password" class="block text-sm font-bold text-slate-700 mb-2">{{ __('Kata Sandi Saat Ini') }}</label>
                <input id="update_password_current_password" name="current_password" type="password" class="w-full md:w-2/3 px-4 py-3 rounded-xl border border-slate-200 bg-slate-50 focus:bg-white text-slate-900 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition outline-none font-medium" autocomplete="current-password" />
                @error('current_password', 'updatePassword')
                    <p class="text-sm text-rose-500 font-medium mt-2">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="update_password_password" class="block text-sm font-bold text-slate-700 mb-2">{{ __('Kata Sandi Baru') }}</label>
                <input id="update_password_password" name="password" type="password" class="w-full md:w-2/3 px-4 py-3 rounded-xl border border-slate-200 bg-slate-50 focus:bg-white text-slate-900 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition outline-none font-medium" autocomplete="new-password" />
                @error('password', 'updatePassword')
                    <p class="text-sm text-rose-500 font-medium mt-2">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="update_password_password_confirmation" class="block text-sm font-bold text-slate-700 mb-2">{{ __('Konfirmasi Kata Sandi Baru') }}</label>
                <input id="update_password_password_confirmation" name="password_confirmation" type="password" class="w-full md:w-2/3 px-4 py-3 rounded-xl border border-slate-200 bg-slate-50 focus:bg-white text-slate-900 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition outline-none font-medium" autocomplete="new-password" />
                @error('password_confirmation', 'updatePassword')
                    <p class="text-sm text-rose-500 font-medium mt-2">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="flex items-center gap-4 pt-4 border-t border-slate-100">
            <button type="submit" class="inline-flex items-center gap-2 px-6 py-3 bg-slate-900 text-white rounded-xl font-bold shadow-md hover:bg-blue-900 hover:-translate-y-0.5 transition-all">
                {{ __('Perbarui Kata Sandi') }}
            </button>

            @if (session('status') === 'password-updated')
                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)" class="text-sm font-bold text-emerald-600 flex items-center gap-1.5">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    {{ __('Berhasil diperbarui.') }}
                </p>
            @endif
        </div>
    </form>
</section>
