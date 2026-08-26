<section class="space-y-6">
    <button x-data="" x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')" class="inline-flex items-center gap-2 px-6 py-3 bg-rose-600 text-white rounded-xl font-bold shadow-sm hover:bg-rose-700 hover:-translate-y-0.5 transition-all">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
        {{ __('Hapus Akun Permanen') }}
    </button>

    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}" class="p-8">
            @csrf
            @method('delete')

            <h2 class="text-xl font-bold text-slate-900 mb-2">
                {{ __('Apakah Anda yakin ingin menghapus akun ini?') }}
            </h2>

            <p class="text-sm text-slate-600 leading-relaxed mb-6">
                {{ __('Setelah akun Anda dihapus, semua sumber daya dan data yang terkait akan dihapus secara permanen. Silakan masukkan kata sandi Anda untuk mengonfirmasi bahwa Anda ingin menghapus akun Anda secara permanen.') }}
            </p>

            <div class="mb-8">
                <label for="password" class="block text-sm font-bold text-slate-700 mb-2">{{ __('Kata Sandi') }}</label>
                <input id="password" name="password" type="password" class="w-full px-4 py-3 rounded-xl border border-slate-200 bg-slate-50 focus:bg-white text-slate-900 focus:ring-2 focus:ring-rose-500 focus:border-rose-500 transition outline-none font-medium" placeholder="{{ __('Masukkan kata sandi Anda') }}" />
                @error('password', 'userDeletion')
                    <p class="text-sm text-rose-500 font-medium mt-2">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex items-center justify-end gap-3 pt-6 border-t border-slate-100">
                <button type="button" x-on:click="$dispatch('close')" class="px-6 py-3 bg-white text-slate-700 border border-slate-200 rounded-xl font-bold hover:bg-slate-50 transition-colors">
                    {{ __('Batal') }}
                </button>

                <button type="submit" class="px-6 py-3 bg-rose-600 text-white rounded-xl font-bold shadow-sm hover:bg-rose-700 transition-colors">
                    {{ __('Ya, Hapus Akun') }}
                </button>
            </div>
        </form>
    </x-modal>
</section>
