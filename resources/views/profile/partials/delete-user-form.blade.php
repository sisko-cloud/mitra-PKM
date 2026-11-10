<section class="space-y-6">
    <header class="border-b border-rose-100 dark:border-rose-950/60 pb-5">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-rose-100 dark:bg-rose-950/60 text-rose-600 dark:text-rose-400 flex items-center justify-center text-lg shrink-0">
                <i class="fa-solid fa-triangle-exclamation"></i>
            </div>
            <div>
                <h2 class="text-lg font-bold text-rose-600 dark:text-rose-400">
                    Zona Bahaya: Hapus Akun
                </h2>
                <p class="text-xs sm:text-sm text-slate-500 dark:text-slate-400">
                    Setelah akun dihapus, seluruh data profil dan konten website terkait akan dihapus secara permanen.
                </p>
            </div>
        </div>
    </header>

    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <p class="text-xs text-slate-600 dark:text-slate-400 max-w-xl leading-relaxed">
            Harap pastikan Anda telah mencadangkan data yang mungkin masih dibutuhkan sebelum memutuskan untuk menghapus akun secara permanen.
        </p>

        <button type="button"
            x-data=""
            x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
            class="inline-flex items-center justify-center gap-2 px-5 py-2.5 rounded-xl bg-rose-600 hover:bg-rose-700 text-white font-bold text-xs shadow-sm transition whitespace-nowrap">
            <i class="fa-regular fa-trash-can"></i>
            <span>Hapus Akun Pengguna</span>
        </button>
    </div>

    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}" class="p-6">
            @csrf
            @method('delete')

            <div class="flex items-center gap-3 text-rose-600 mb-3">
                <i class="fa-solid fa-triangle-exclamation text-2xl"></i>
                <h3 class="text-lg font-bold text-slate-900 dark:text-white">
                    Konfirmasi Penghapusan Akun
                </h3>
            </div>

            <p class="text-xs sm:text-sm text-slate-600 dark:text-slate-400 leading-relaxed">
                Tindakan ini tidak dapat dibatalkan. Masukkan kata sandi akun Anda untuk mengonfirmasi bahwa Anda benar-benar ingin menghapus akun ini secara permanen.
            </p>

            <div class="mt-5">
                <label for="delete_password" class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase mb-1">
                    Kata Sandi Akun
                </label>
                <input
                    id="delete_password"
                    name="password"
                    type="password"
                    class="w-full px-4 py-2.5 rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-900 dark:text-slate-100 text-sm focus:ring-2 focus:ring-rose-500"
                    placeholder="Masukkan kata sandi Anda untuk konfirmasi"
                />
                @if($errors->userDeletion->has('password'))
                    <p class="mt-1.5 text-xs font-semibold text-rose-600 dark:text-rose-400">
                        {{ $errors->userDeletion->first('password') }}
                    </p>
                @endif
            </div>

            <div class="mt-6 flex justify-end gap-2.5">
                <button type="button" x-on:click="$dispatch('close')"
                    class="px-4 py-2 rounded-xl border border-slate-200 dark:border-slate-700 text-slate-700 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800 text-xs font-semibold transition">
                    Batal
                </button>

                <button type="submit"
                    class="px-5 py-2 rounded-xl bg-rose-600 hover:bg-rose-700 text-white font-bold text-xs transition shadow-sm">
                    Ya, Hapus Akun Saya
                </button>
            </div>
        </form>
    </x-modal>
</section>
