<section>
    <header class="border-b border-slate-100 dark:border-slate-800 pb-5 mb-6">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-orange-100 dark:bg-orange-950/60 text-orange-600 dark:text-orange-400 flex items-center justify-center text-lg shrink-0">
                <i class="fa-solid fa-key"></i>
            </div>
            <div>
                <h2 class="text-lg font-bold text-slate-900 dark:text-white">
                    Perbarui Kata Sandi
                </h2>
                <p class="text-xs sm:text-sm text-slate-500 dark:text-slate-400">
                    Pastikan akun Anda menggunakan kata sandi yang kuat dan aman untuk melindungi data usaha Anda.
                </p>
            </div>
        </div>
    </header>

    <form method="POST" action="{{ route('password.update') }}" class="space-y-5">
        @csrf
        @method('put')

        <div>
            <label for="update_password_current_password" class="block text-xs font-bold uppercase tracking-wider text-slate-700 dark:text-slate-300 mb-1.5">
                <i class="fa-solid fa-lock text-orange-600 dark:text-orange-400 mr-1"></i> Kata Sandi Saat Ini <span class="text-rose-500">*</span>
            </label>
            <input type="password" id="update_password_current_password" name="current_password" autocomplete="current-password"
                class="w-full px-4 py-2.5 rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-900 dark:text-slate-100 text-sm focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition"
                placeholder="Masukkan kata sandi lama">
            @if($errors->updatePassword->has('current_password'))
                <p class="mt-1.5 text-xs font-semibold text-rose-600 dark:text-rose-400">
                    {{ $errors->updatePassword->first('current_password') }}
                </p>
            @endif
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
            <div>
                <label for="update_password_password" class="block text-xs font-bold uppercase tracking-wider text-slate-700 dark:text-slate-300 mb-1.5">
                    <i class="fa-solid fa-shield-halved text-orange-600 dark:text-orange-400 mr-1"></i> Kata Sandi Baru <span class="text-rose-500">*</span>
                </label>
                <input type="password" id="update_password_password" name="password" autocomplete="new-password"
                    class="w-full px-4 py-2.5 rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-900 dark:text-slate-100 text-sm focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition"
                    placeholder="Minimal 8 karakter kombinasi">
                @if($errors->updatePassword->has('password'))
                    <p class="mt-1.5 text-xs font-semibold text-rose-600 dark:text-rose-400">
                        {{ $errors->updatePassword->first('password') }}
                    </p>
                @endif
            </div>

            <div>
                <label for="update_password_password_confirmation" class="block text-xs font-bold uppercase tracking-wider text-slate-700 dark:text-slate-300 mb-1.5">
                    <i class="fa-solid fa-check-double text-orange-600 dark:text-orange-400 mr-1"></i> Konfirmasi Kata Sandi Baru <span class="text-rose-500">*</span>
                </label>
                <input type="password" id="update_password_password_confirmation" name="password_confirmation" autocomplete="new-password"
                    class="w-full px-4 py-2.5 rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-900 dark:text-slate-100 text-sm focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition"
                    placeholder="Ketik ulang kata sandi baru">
                @if($errors->updatePassword->has('password_confirmation'))
                    <p class="mt-1.5 text-xs font-semibold text-rose-600 dark:text-rose-400">
                        {{ $errors->updatePassword->first('password_confirmation') }}
                    </p>
                @endif
            </div>
        </div>

        <div class="pt-4 border-t border-slate-100 dark:border-slate-800 flex items-center justify-end">
            <button type="submit"
                class="inline-flex items-center justify-center gap-2 px-6 py-2.5 rounded-xl bg-slate-900 hover:bg-slate-800 dark:bg-slate-100 dark:hover:bg-white dark:text-slate-900 text-white font-bold text-sm shadow-md transition">
                <i class="fa-solid fa-key"></i>
                <span>Perbarui Kata Sandi</span>
            </button>
        </div>
    </form>
</section>
