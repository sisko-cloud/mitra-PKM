<section x-data="{
    photoPreview: null,
    hapusFoto: false,
    currentPhoto: {{ $user->avatar_url ? "'" . addslashes($user->avatar_url) . "'" : 'null' }},
    handleFileChange(event) {
        const file = event.target.files[0];
        if (file) {
            if (file.size > 3 * 1024 * 1024) {
                alert('Ukuran file foto maksimal adalah 3MB.');
                event.target.value = '';
                return;
            }
            const reader = new FileReader();
            reader.onload = (e) => {
                this.photoPreview = e.target.result;
                this.hapusFoto = false;
            };
            reader.readAsDataURL(file);
        }
    },
    removePhoto() {
        this.photoPreview = null;
        this.hapusFoto = true;
        const input = document.getElementById('foto_profil_input');
        if (input) input.value = '';
    }
}">
    <header class="border-b border-slate-100 dark:border-slate-800 pb-5 mb-6">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-orange-100 dark:bg-orange-950/60 text-orange-600 dark:text-orange-400 flex items-center justify-center text-lg shrink-0">
                <i class="fa-solid fa-id-card"></i>
            </div>
            <div>
                <h2 class="text-lg font-bold text-slate-900 dark:text-white">
                    Data Pribadi & Foto Profil
                </h2>
                <p class="text-xs sm:text-sm text-slate-500 dark:text-slate-400">
                    Perbarui foto avatar, nama lengkap, alamat email, dan nomor telepon akun Anda.
                </p>
            </div>
        </div>
    </header>

    <form id="profile-info-form" method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @method('patch')

        <!-- Hidden flag hapus foto -->
        <input type="hidden" name="hapus_foto" :value="hapusFoto ? 1 : 0">

        <!-- Avatar Upload & Preview Section -->
        <div class="p-5 rounded-2xl bg-slate-50 dark:bg-slate-800/50 border border-slate-200 dark:border-slate-800 flex flex-col sm:flex-row items-center sm:items-start gap-5">
            <!-- Avatar Display -->
            <div class="relative shrink-0">
                <!-- Preview saat user memilih file baru -->
                <template x-if="photoPreview">
                    <img :src="photoPreview" alt="Pratinjau Foto" class="w-24 h-24 rounded-2xl object-cover ring-4 ring-orange-500/20 shadow-md">
                </template>

                <!-- Foto saat ini jika ada dan belum dihapus -->
                <template x-if="!photoPreview && !hapusFoto && currentPhoto">
                    <img :src="currentPhoto" alt="{{ $user->name }}" class="w-24 h-24 rounded-2xl object-cover ring-4 ring-orange-500/20 shadow-md">
                </template>

                <!-- Avatar default huruf inisial -->
                <template x-if="!photoPreview && (hapusFoto || !currentPhoto)">
                    <div class="w-24 h-24 rounded-2xl bg-gradient-to-tr from-orange-600 to-amber-500 text-white flex items-center justify-center font-black text-3xl shadow-md ring-4 ring-orange-500/20 uppercase">
                        {{ substr($user->name, 0, 1) }}
                    </div>
                </template>

                <div class="absolute -bottom-1 -right-1 w-7 h-7 rounded-full bg-orange-600 text-white flex items-center justify-center text-xs shadow-sm ring-2 ring-white dark:ring-slate-900">
                    <i class="fa-solid fa-camera"></i>
                </div>
            </div>

            <!-- Avatar Upload Controls -->
            <div class="flex-grow text-center sm:text-left">
                <h3 class="text-sm font-bold text-slate-800 dark:text-slate-100">Foto Profil Pengguna</h3>
                <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5 leading-relaxed">
                    Format gambar didukung: JPG, PNG, atau WEBP (Maksimal 3MB). Foto akan tampil pada bilah navigasi dan kartu profil.
                </p>

                <!-- File Input (Hidden) -->
                <input type="file" id="foto_profil_input" name="foto_profil" accept="image/jpeg,image/png,image/jpg,image/webp" class="hidden" @change="handleFileChange($event)">

                <div class="mt-3 flex items-center justify-center sm:justify-start gap-2.5 flex-wrap">
                    <button type="button" onclick="document.getElementById('foto_profil_input').click()"
                        class="px-4 py-2 rounded-xl bg-orange-600 hover:bg-orange-700 text-white font-bold text-xs flex items-center gap-2 shadow-xs transition">
                        <i class="fa-solid fa-cloud-arrow-up"></i>
                        <span x-text="photoPreview || (!hapusFoto && currentPhoto) ? 'Ganti Foto' : 'Unggah Foto'">Unggah Foto</span>
                    </button>

                    <button type="button" x-show="photoPreview || (!hapusFoto && currentPhoto)" @click="removePhoto()"
                        class="px-3.5 py-2 rounded-xl bg-slate-200 dark:bg-slate-700 hover:bg-rose-100 hover:text-rose-600 dark:hover:bg-rose-950/50 dark:hover:text-rose-400 text-slate-700 dark:text-slate-200 font-semibold text-xs flex items-center gap-1.5 transition">
                        <i class="fa-regular fa-trash-can"></i>
                        <span>Hapus Foto</span>
                    </button>
                </div>

                @if($errors->has('foto_profil'))
                    <p class="mt-2 text-xs font-semibold text-rose-600 dark:text-rose-400">
                        {{ $errors->first('foto_profil') }}
                    </p>
                @endif
            </div>
        </div>

        <!-- Form Inputs Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
            <!-- Nama Lengkap -->
            <div class="md:col-span-2">
                <label for="name" class="block text-xs font-bold uppercase tracking-wider text-slate-700 dark:text-slate-300 mb-1.5">
                    <i class="fa-solid fa-user text-orange-600 dark:text-orange-400 mr-1"></i> Nama Lengkap <span class="text-rose-500">*</span>
                </label>
                <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}" required autocomplete="name"
                    class="w-full px-4 py-2.5 rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-900 dark:text-slate-100 text-sm focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition"
                    placeholder="Masukkan nama lengkap Anda">
                @if($errors->has('name'))
                    <p class="mt-1.5 text-xs font-semibold text-rose-600 dark:text-rose-400">
                        {{ $errors->first('name') }}
                    </p>
                @endif
            </div>

            <!-- Alamat Email -->
            <div>
                <label for="email" class="block text-xs font-bold uppercase tracking-wider text-slate-700 dark:text-slate-300 mb-1.5">
                    <i class="fa-solid fa-envelope text-orange-600 dark:text-orange-400 mr-1"></i> Alamat Email <span class="text-rose-500">*</span>
                </label>
                <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}" required autocomplete="username"
                    class="w-full px-4 py-2.5 rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-900 dark:text-slate-100 text-sm focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition"
                    placeholder="nama@email.com">
                @if($errors->has('email'))
                    <p class="mt-1.5 text-xs font-semibold text-rose-600 dark:text-rose-400">
                        {{ $errors->first('email') }}
                    </p>
                @endif
            </div>

            <!-- Nomor Telepon / WhatsApp -->
            <div>
                <label for="phone" class="block text-xs font-bold uppercase tracking-wider text-slate-700 dark:text-slate-300 mb-1.5">
                    <i class="fa-solid fa-phone text-orange-600 dark:text-orange-400 mr-1"></i> Nomor Telepon / WhatsApp
                </label>
                <input type="text" id="phone" name="phone" value="{{ old('phone', $user->phone) }}" autocomplete="tel"
                    class="w-full px-4 py-2.5 rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-900 dark:text-slate-100 text-sm focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition"
                    placeholder="Contoh: 081234567890">
                <span class="text-[11px] text-slate-500 dark:text-slate-400 mt-1 block">
                    Digunakan untuk kontak konfirmasi dan koordinasi mitra.
                </span>
                @if($errors->has('phone'))
                    <p class="mt-1.5 text-xs font-semibold text-rose-600 dark:text-rose-400">
                        {{ $errors->first('phone') }}
                    </p>
                @endif
            </div>
        </div>

        <!-- Submit Button -->
        <div class="pt-4 border-t border-slate-100 dark:border-slate-800 flex items-center justify-between flex-wrap gap-3">
            <span class="text-xs text-slate-500 dark:text-slate-400">
                Pastikan data yang Anda isi sudah benar sebelum menyimpan.
            </span>
            <button type="submit"
                class="inline-flex items-center justify-center gap-2 px-6 py-2.5 rounded-xl bg-gradient-to-r from-orange-600 to-amber-500 hover:from-orange-500 hover:to-amber-400 text-white font-bold text-sm shadow-md shadow-orange-500/20 transition">
                <i class="fa-solid fa-floppy-disk"></i>
                <span>Simpan Perubahan Profil</span>
            </button>
        </div>
    </form>
</section>
