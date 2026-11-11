@extends('layouts.app')

@section('title', 'Edit Section 1: Beranda & Sampul')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

    <!-- Breadcrumb & Back -->
    <div class="mb-6 flex items-center justify-between">
        <a href="{{ route('owner.dashboard') }}" class="inline-flex items-center gap-1.5 text-xs font-semibold text-slate-500 hover:text-orange-600 transition">
            <i class="fa-solid fa-arrow-left"></i> Kembali ke Dashboard
        </a>
        <a href="{{ route('owner.preview') }}#beranda" target="_blank" class="text-xs font-semibold text-orange-600 hover:underline">
            <i class="fa-regular fa-eye mr-1"></i> Pratinjau Section Ini
        </a>
    </div>

    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 sm:p-8">
        <div class="flex items-center gap-3 pb-4 border-b border-slate-200 mb-6">
            <div class="w-10 h-10 rounded-xl bg-orange-100 text-orange-700 flex items-center justify-center font-black text-lg">
                1
            </div>
            <div>
                <h1 class="text-xl font-bold text-slate-900">Section 1: Beranda / Judul & Gambar Sampul</h1>
                <p class="text-xs text-slate-500">Bagian ini adalah tampilan pertama (hero section) yang dilihat pengunjung saat membuka website promosi Anda.</p>
            </div>
        </div>

        <form id="hero-form" method="POST" action="{{ route('owner.hero.update') }}" enctype="multipart/form-data" class="space-y-6">
            @csrf

            <!-- Judul Website -->
            <div>
                <label for="judul" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                    Judul Utama Website Promosi <span class="text-rose-500">*</span>
                </label>
                <input id="judul" type="text" name="judul" value="{{ old('judul', $content->judul ?? $mitra->nama_usaha) }}" required
                    placeholder="Contoh: Kopi Senopati Heritage"
                    class="block w-full px-3.5 py-2.5 border border-slate-300 rounded-xl text-sm placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition">
                <p class="text-[11px] text-slate-500 mt-1">Judul ini juga otomatis digunakan sebagai judul tag SEO browser dan meta pratinjau tautan media sosial.</p>
            </div>

            <!-- Tagline Usaha -->
            <div>
                <label for="tagline" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                    Tagline / Kalimat Pemikat Singkat
                </label>
                <input id="tagline" type="text" name="tagline" value="{{ old('tagline', $content->tagline) }}"
                    placeholder="Contoh: Cita Rasa Kopi Nusantara Autentik dari Petani Lokal ke Cangkir Anda"
                    class="block w-full px-3.5 py-2.5 border border-slate-300 rounded-xl text-sm placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition">
                <p class="text-[11px] text-slate-500 mt-1">Slogan atau pesan utama yang langsung dibaca oleh calon pembeli di bawah judul.</p>
            </div>

            <!-- Gambar Sampul (Hero Image) -->
            <div x-data="{
                previewUrl: null,
                fileChosen(event) {
                    const file = event.target.files[0];
                    if (file) {
                        this.previewUrl = URL.createObjectURL(file);
                    } else {
                        this.previewUrl = null;
                    }
                }
            }">
                <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                    Gambar Sampul Utama (Hero Banner)
                </label>
                <p class="text-xs text-slate-500 mb-3">Format didukung: JPG, JPEG, PNG, WEBP. Maksimal ukuran file: <strong>2 MB</strong>. Tersimpan secara permanen ke basis data.</p>

                <!-- Pratinjau File Baru Dipilih -->
                <div x-show="previewUrl" class="mb-4 relative rounded-xl overflow-hidden border-2 border-orange-400 shadow-md max-h-64" style="display: none;">
                    <img :src="previewUrl" alt="Pratinjau Hero Baru" class="w-full h-56 object-cover">
                    <div class="absolute bottom-2 left-2 bg-orange-600/90 text-white text-[11px] px-2.5 py-1 rounded-md font-bold flex items-center gap-1.5 shadow-sm">
                        <i class="fa-solid fa-sparkles"></i> Pratinjau Gambar Baru (Belum Disimpan)
                    </div>
                </div>

                <!-- Current Image Preview -->
                @if ($content->hero_image)
                    <div x-show="!previewUrl" class="mb-4 relative rounded-xl overflow-hidden border border-slate-200 shadow-xs max-h-64 group">
                        <img src="{{ Str::startsWith($content->hero_image, ['http', 'data:']) ? $content->hero_image : asset('storage/' . $content->hero_image) }}" 
                             alt="Gambar Sampul" class="w-full h-56 object-cover">
                        <div class="absolute bottom-2 left-2 bg-slate-900/80 backdrop-blur-xs text-white text-[11px] px-2.5 py-1 rounded-md font-semibold">
                            <i class="fa-solid fa-image mr-1"></i> Gambar Sampul Aktif Saat Ini
                        </div>
                    </div>
                @endif

                <div class="p-4 border-2 border-dashed border-slate-300 rounded-xl bg-slate-50 hover:bg-slate-100/50 transition">
                    <input id="hero_image" type="file" name="hero_image" accept="image/jpeg,image/png,image/webp"
                        @change="fileChosen($event)"
                        class="block w-full text-xs text-slate-600 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-orange-600 file:text-white hover:file:bg-orange-700 file:cursor-pointer">
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="pt-4 border-t border-slate-200 flex items-center justify-between">
                <a href="{{ route('owner.dashboard') }}" class="px-4 py-2.5 border border-slate-300 rounded-xl text-slate-700 text-xs font-semibold hover:bg-slate-50 transition">
                    Batal
                </a>
                <button type="submit" class="inline-flex items-center gap-2 px-6 py-2.5 bg-orange-600 hover:bg-orange-700 text-white font-bold text-xs sm:text-sm rounded-xl shadow-md transition shadow-orange-600/30">
                    <i class="fa-solid fa-floppy-disk"></i> Simpan Section Beranda
                </button>
            </div>
        </form>
    </div>

</div>
@endsection
