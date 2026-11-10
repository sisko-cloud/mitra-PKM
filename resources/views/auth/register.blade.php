@extends('layouts.public')

@section('title', 'Pendaftaran Mitra Baru - Mitra PKM')

@section('content')
<div class="py-12 sm:px-6 lg:px-8 max-w-4xl mx-auto">
    <div class="text-center mb-8">
        <div class="flex justify-center">
            <x-application-logo class="w-16 h-16 mb-4" />
        </div>
        <h1 class="text-3xl sm:text-4xl font-extrabold text-slate-900 dark:text-white tracking-tight">Formulir Pendaftaran Mitra PKM</h1>
        <p class="mt-2 text-sm sm:text-base text-slate-600 dark:text-slate-400 max-w-xl mx-auto">
            Daftarkan UMKM atau Koperasi Anda untuk mendapatkan website promosi resmi mandiri serta tampil di direktori publik Mitra PKM.
        </p>
    </div>

    <!-- Registration Card -->
    <div class="bg-white dark:bg-slate-900 py-8 px-6 sm:px-12 shadow-xl shadow-slate-200/50 dark:shadow-none rounded-2xl border border-slate-200 dark:border-slate-800 transition-colors">
        
        <!-- Workflow Info Banner -->
        <div class="mb-8 p-4 bg-orange-50 dark:bg-orange-950/40 border border-orange-200 dark:border-orange-800/60 rounded-xl text-xs sm:text-sm text-orange-900 dark:text-orange-300 flex items-start gap-3">
            <i class="fa-solid fa-circle-info text-orange-600 dark:text-orange-400 text-lg mt-0.5 shrink-0"></i>
            <div class="leading-relaxed">
                <span class="font-bold block mb-1">Alur Pendaftaran & Verifikasi:</span>
                <p>Setelah mengirimkan formulir ini, akun Anda akan berstatus <strong>"Menunggu Verifikasi" (Pending)</strong>. Tim Superadmin akan meninjau data usaha Anda. Begitu disetujui, website promosi Anda otomatis dibuat dan siap untuk Anda kelola.</p>
            </div>
        </div>

        @if (session('error'))
            <div class="mb-6 p-4 bg-rose-50 dark:bg-rose-950/40 border border-rose-200 dark:border-rose-800/60 rounded-xl text-xs sm:text-sm text-rose-800 dark:text-rose-300 flex items-start gap-3">
                <i class="fa-solid fa-triangle-exclamation text-rose-600 dark:text-rose-400 text-lg mt-0.5 shrink-0"></i>
                <div>
                    <div class="font-bold mb-1">Terjadi Kendala</div>
                    <div>{{ session('error') }}</div>
                </div>
            </div>
        @endif

        @if ($errors->any())
            <div class="mb-6 p-4 bg-rose-50 dark:bg-rose-950/40 border border-rose-200 dark:border-rose-800/60 rounded-xl text-xs sm:text-sm text-rose-800 dark:text-rose-300">
                <div class="font-bold flex items-center gap-2 mb-2">
                    <i class="fa-solid fa-circle-exclamation text-rose-600 dark:text-rose-400"></i> Mohon periksa kembali formulir Anda:
                </div>
                <ul class="list-disc list-inside space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data" class="space-y-8">
            @csrf

            <!-- BAGIAN 1: DATA AKUN PEMILIK -->
            <div>
                <div class="flex items-center gap-2 pb-3 border-b border-slate-200 dark:border-slate-800 mb-5">
                    <span class="w-6 h-6 rounded-full bg-orange-600 text-white text-xs font-bold flex items-center justify-center">1</span>
                    <h3 class="text-base font-bold text-slate-900 dark:text-white">Data Akun Penanggung Jawab</h3>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <!-- Nama Lengkap -->
                    <div>
                        <label for="name" class="block text-xs font-bold uppercase tracking-wider text-slate-700 dark:text-slate-300 mb-1.5">
                            Nama Lengkap Penanggung Jawab <span class="text-rose-500">*</span>
                        </label>
                        <input id="name" type="text" name="name" value="{{ old('name') }}" required
                            placeholder="Contoh: Hendro Prasetyo"
                            class="block w-full px-3.5 py-2.5 bg-white dark:bg-slate-800 border border-slate-300 dark:border-slate-700 rounded-xl text-sm text-slate-900 dark:text-white placeholder-slate-400 dark:placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition">
                    </div>

                    <!-- Email -->
                    <div>
                        <label for="email" class="block text-xs font-bold uppercase tracking-wider text-slate-700 dark:text-slate-300 mb-1.5">
                            Alamat Email Aktif <span class="text-rose-500">*</span>
                        </label>
                        <input id="email" type="email" name="email" value="{{ old('email') }}" required
                            placeholder="nama@usaha.com"
                            class="block w-full px-3.5 py-2.5 bg-white dark:bg-slate-800 border border-slate-300 dark:border-slate-700 rounded-xl text-sm text-slate-900 dark:text-white placeholder-slate-400 dark:placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition">
                    </div>

                    <!-- Password dengan Tombol Mata -->
                    <div x-data="{ showPass: false }">
                        <label for="password" class="block text-xs font-bold uppercase tracking-wider text-slate-700 dark:text-slate-300 mb-1.5">
                            Kata Sandi (Password) <span class="text-rose-500">*</span>
                        </label>
                        <div class="relative">
                            <input id="password" :type="showPass ? 'text' : 'password'" name="password" required autocomplete="new-password"
                                placeholder="Minimal 8 karakter"
                                class="block w-full pl-3.5 pr-11 py-2.5 bg-white dark:bg-slate-800 border border-slate-300 dark:border-slate-700 rounded-xl text-sm text-slate-900 dark:text-white placeholder-slate-400 dark:placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition">
                            <button type="button" @click="showPass = !showPass"
                                class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-slate-400 hover:text-slate-600 dark:hover:text-slate-200 transition focus:outline-none"
                                :title="showPass ? 'Sembunyikan kata sandi' : 'Tampilkan kata sandi'"
                                tabindex="-1">
                                <i class="fa-solid text-sm" :class="showPass ? 'fa-eye-slash text-orange-600 dark:text-orange-400' : 'fa-eye'"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Password Confirmation dengan Tombol Mata -->
                    <div x-data="{ showConfirm: false }">
                        <label for="password_confirmation" class="block text-xs font-bold uppercase tracking-wider text-slate-700 dark:text-slate-300 mb-1.5">
                            Konfirmasi Kata Sandi <span class="text-rose-500">*</span>
                        </label>
                        <div class="relative">
                            <input id="password_confirmation" :type="showConfirm ? 'text' : 'password'" name="password_confirmation" required
                                placeholder="Ulangi kata sandi"
                                class="block w-full pl-3.5 pr-11 py-2.5 bg-white dark:bg-slate-800 border border-slate-300 dark:border-slate-700 rounded-xl text-sm text-slate-900 dark:text-white placeholder-slate-400 dark:placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition">
                            <button type="button" @click="showConfirm = !showConfirm"
                                class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-slate-400 hover:text-slate-600 dark:hover:text-slate-200 transition focus:outline-none"
                                :title="showConfirm ? 'Sembunyikan konfirmasi kata sandi' : 'Tampilkan konfirmasi kata sandi'"
                                tabindex="-1">
                                <i class="fa-solid text-sm" :class="showConfirm ? 'fa-eye-slash text-orange-600 dark:text-orange-400' : 'fa-eye'"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- BAGIAN 2: DATA USAHA (UMKM / KOPERASI) -->
            <div>
                <div class="flex items-center gap-2 pb-3 border-b border-slate-200 dark:border-slate-800 mb-5">
                    <span class="w-6 h-6 rounded-full bg-orange-600 text-white text-xs font-bold flex items-center justify-center">2</span>
                    <h3 class="text-base font-bold text-slate-900 dark:text-white">Data Profil Usaha</h3>
                </div>

                <div class="space-y-5">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <!-- Nama Usaha -->
                        <div>
                            <label for="nama_usaha" class="block text-xs font-bold uppercase tracking-wider text-slate-700 dark:text-slate-300 mb-1.5">
                                Nama UMKM / Koperasi <span class="text-rose-500">*</span>
                            </label>
                            <input id="nama_usaha" type="text" name="nama_usaha" value="{{ old('nama_usaha') }}" required
                                placeholder="Contoh: Kopi Senopati Heritage"
                                class="block w-full px-3.5 py-2.5 bg-white dark:bg-slate-800 border border-slate-300 dark:border-slate-700 rounded-xl text-sm text-slate-900 dark:text-white placeholder-slate-400 dark:placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition">
                        </div>

                        <!-- Jenis Usaha -->
                        <div>
                            <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 dark:text-slate-300 mb-1.5">
                                Jenis Usaha <span class="text-rose-500">*</span>
                            </label>
                            <div class="grid grid-cols-2 gap-3 pt-0.5">
                                <label class="flex items-center gap-2.5 p-2.5 border border-slate-300 dark:border-slate-700 rounded-xl cursor-pointer hover:bg-slate-50 dark:hover:bg-slate-800/60 has-[:checked]:border-orange-600 has-[:checked]:bg-orange-50/60 dark:has-[:checked]:bg-orange-950/40 dark:has-[:checked]:border-orange-500 has-[:checked]:text-orange-900 dark:has-[:checked]:text-orange-200 transition">
                                    <input type="radio" name="jenis" value="umkm" {{ old('jenis', 'umkm') === 'umkm' ? 'checked' : '' }} class="text-orange-600 focus:ring-orange-500 dark:bg-slate-800 dark:border-slate-600">
                                    <span class="text-xs sm:text-sm font-semibold text-slate-800 dark:text-slate-200">UMKM</span>
                                </label>
                                <label class="flex items-center gap-2.5 p-2.5 border border-slate-300 dark:border-slate-700 rounded-xl cursor-pointer hover:bg-slate-50 dark:hover:bg-slate-800/60 has-[:checked]:border-orange-600 has-[:checked]:bg-orange-50/60 dark:has-[:checked]:bg-orange-950/40 dark:has-[:checked]:border-orange-500 has-[:checked]:text-orange-900 dark:has-[:checked]:text-orange-200 transition">
                                    <input type="radio" name="jenis" value="koperasi" {{ old('jenis') === 'koperasi' ? 'checked' : '' }} class="text-orange-600 focus:ring-orange-500 dark:bg-slate-800 dark:border-slate-600">
                                    <span class="text-xs sm:text-sm font-semibold text-slate-800 dark:text-slate-200">Koperasi</span>
                                </label>
                            </div>
                        </div>
                    </div>

                    <!-- Nomor Kontak / WhatsApp -->
                    <div>
                        <label for="kontak" class="block text-xs font-bold uppercase tracking-wider text-slate-700 dark:text-slate-300 mb-1.5">
                            Nomor Kontak / WhatsApp Usaha <span class="text-rose-500">*</span>
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-orange-600 dark:text-orange-400 font-bold text-xs sm:text-sm">
                                <i class="fa-brands fa-whatsapp mr-1"></i> +62
                            </div>
                            <input id="kontak" type="text" name="kontak" value="{{ old('kontak') }}" required
                                placeholder="81234567890"
                                class="block w-full pl-20 pr-3.5 py-2.5 bg-white dark:bg-slate-800 border border-slate-300 dark:border-slate-700 rounded-xl text-sm text-slate-900 dark:text-white placeholder-slate-400 dark:placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition">
                        </div>
                        <p class="text-[11px] text-slate-500 dark:text-slate-400 mt-1">Nomor ini digunakan untuk komunikasi konfirmasi pesanan pelanggan dari website promosi Anda.</p>
                    </div>

                    <!-- Alamat Lengkap -->
                    <div>
                        <label for="alamat" class="block text-xs font-bold uppercase tracking-wider text-slate-700 dark:text-slate-300 mb-1.5">
                            Alamat Lengkap Usaha <span class="text-rose-500">*</span>
                        </label>
                        <textarea id="alamat" name="alamat" rows="2" required
                            placeholder="Jl. Nama Jalan No. XX, Kelurahan, Kecamatan, Kota/Kabupaten, Provinsi"
                            class="block w-full px-3.5 py-2.5 bg-white dark:bg-slate-800 border border-slate-300 dark:border-slate-700 rounded-xl text-sm text-slate-900 dark:text-white placeholder-slate-400 dark:placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition">{{ old('alamat') }}</textarea>
                    </div>
                </div>
            </div>

            <!-- BAGIAN 3: BERKAS & DOKUMEN PENDUKUNG (OPSIONAL) -->
            <div>
                <div class="flex items-center gap-2 pb-3 border-b border-slate-200 dark:border-slate-800 mb-5">
                    <span class="w-6 h-6 rounded-full bg-orange-600 text-white text-xs font-bold flex items-center justify-center">3</span>
                    <h3 class="text-base font-bold text-slate-900 dark:text-white">Logo & Dokumen Pendukung (Opsional)</h3>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <!-- Upload Logo -->
                    <div class="p-4 border border-dashed border-slate-300 dark:border-slate-700 rounded-xl bg-slate-50 dark:bg-slate-800/40">
                        <label for="logo" class="block text-xs font-bold uppercase tracking-wider text-slate-700 dark:text-slate-300 mb-1">
                            Logo UMKM / Koperasi
                        </label>
                        <p class="text-[11px] text-slate-500 dark:text-slate-400 mb-2">Format: JPG, PNG, WEBP. Maksimal 2 MB.</p>
                        <input id="logo" type="file" name="logo" accept="image/png,image/jpeg,image/webp"
                            class="block w-full text-xs text-slate-500 dark:text-slate-400 file:mr-3 file:py-2 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-orange-600 file:text-white hover:file:bg-orange-700 file:cursor-pointer">
                    </div>

                    <!-- Upload Dokumen Pendukung -->
                    <div class="p-4 border border-dashed border-slate-300 dark:border-slate-700 rounded-xl bg-slate-50 dark:bg-slate-800/40">
                        <label for="dokumen_pendukung" class="block text-xs font-bold uppercase tracking-wider text-slate-700 dark:text-slate-300 mb-1">
                            Dokumen Pendukung (KTP / Legalitas)
                        </label>
                        <p class="text-[11px] text-slate-500 dark:text-slate-400 mb-2">Opsional: Foto KTP / NIB / Surat PKM. Maks 2 MB.</p>
                        <input id="dokumen_pendukung" type="file" name="dokumen_pendukung" accept="image/png,image/jpeg,image/webp,application/pdf"
                            class="block w-full text-xs text-slate-500 dark:text-slate-400 file:mr-3 file:py-2 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-slate-700 dark:file:bg-slate-600 file:text-white hover:file:bg-slate-800 dark:hover:file:bg-slate-500 file:cursor-pointer">
                    </div>
                </div>
            </div>

            <!-- Submit Button -->
            <div class="pt-4 border-t border-slate-200 dark:border-slate-800">
                <button type="submit" class="w-full flex items-center justify-center gap-2 py-3.5 px-6 border border-transparent rounded-xl shadow-lg text-sm font-bold text-white bg-gradient-to-r from-orange-600 to-amber-600 hover:from-orange-700 hover:to-amber-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500 transition shadow-orange-600/30">
                    <i class="fa-solid fa-paper-plane"></i>
                    <span>Kirim Formulir Pendaftaran Mitra</span>
                </button>
                <p class="text-center text-xs text-slate-500 dark:text-slate-400 mt-3">
                    Dengan mendaftar, Anda menyetujui syarat & ketentuan publikasi direktori Mitra PKM.
                </p>
            </div>
        </form>

        <div class="mt-6 pt-6 border-t border-slate-200 dark:border-slate-800 text-center">
            <p class="text-xs text-slate-600 dark:text-slate-400">
                Sudah memiliki akun terdaftar?
                <a href="{{ route('login') }}" class="font-bold text-orange-600 dark:text-orange-400 hover:text-orange-700 dark:hover:text-orange-300 hover:underline">
                    Masuk ke Akun Anda &rarr;
                </a>
            </p>
        </div>

    </div>
</div>
@endsection
