@extends('layouts.app')

@section('title', 'Atur Halaman Awal & Pengaturan Platform')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

    <div class="mb-6">
        <h1 class="text-2xl font-bold text-slate-900 tracking-tight">Atur Tampilan Halaman Awal Mitra PKM</h1>
        <p class="text-xs sm:text-sm text-slate-500 mt-0.5">Ubah judul hero utama, narasi promosi, dan informasi sekretariat yang tampil pada portal publik.</p>
    </div>

    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 sm:p-8">
        <form method="POST" action="{{ route('admin.settings.update') }}" class="space-y-6">
            @csrf

            <!-- Hero Badge -->
            <div>
                <label for="hero_badge" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                    Label / Badge Atas Hero
                </label>
                <input id="hero_badge" type="text" name="hero_badge" value="{{ old('hero_badge', $settings['hero_badge']) }}"
                    placeholder="Contoh: Platform Resmi Etalase UMKM & Koperasi PKM"
                    class="block w-full px-3.5 py-2.5 border border-slate-300 rounded-xl text-sm placeholder-slate-400 focus:ring-orange-500 focus:border-orange-500">
            </div>

            <!-- Hero Title -->
            <div>
                <label for="hero_title" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                    Judul Utama Halaman Awal (Hero Title) <span class="text-rose-500">*</span>
                </label>
                <input id="hero_title" type="text" name="hero_title" value="{{ old('hero_title', $settings['hero_title']) }}" required
                    placeholder="Mitra PKM"
                    class="block w-full px-3.5 py-2.5 border border-slate-300 rounded-xl text-base font-extrabold text-slate-900 placeholder-slate-400 focus:ring-orange-500 focus:border-orange-500">
                <p class="text-[11px] text-slate-500 mt-1">Judul berukuran besar yang menyambut pengunjung saat membuka halaman depan.</p>
            </div>

            <!-- Hero Description -->
            <div>
                <label for="hero_description" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                    Deskripsi Singkat Halaman Awal <span class="text-rose-500">*</span>
                </label>
                <textarea id="hero_description" name="hero_description" rows="3" required
                    class="block w-full px-3.5 py-2.5 border border-slate-300 rounded-xl text-sm placeholder-slate-400 focus:ring-orange-500 focus:border-orange-500">{{ old('hero_description', $settings['hero_description']) }}</textarea>
                <p class="text-[11px] text-slate-500 mt-1">Penjelasan singkat tentang tujuan platform Mitra PKM untuk UMKM & Koperasi binaan.</p>
            </div>

            <!-- Kontak Bantuan Sekretariat -->
            <div class="border-t border-slate-200 pt-6">
                <h3 class="text-xs font-bold uppercase tracking-wider text-slate-700 mb-4">Informasi Kontak & Layanan Publik</h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label for="contact_email" class="block text-xs font-semibold text-slate-700 mb-1">Email Layanan Platform</label>
                        <input id="contact_email" type="email" name="contact_email" value="{{ old('contact_email', $settings['contact_email']) }}"
                            class="block w-full px-3 py-2 border border-slate-300 rounded-lg text-xs focus:ring-orange-500 focus:border-orange-500">
                    </div>
                    <div>
                        <label for="contact_phone" class="block text-xs font-semibold text-slate-700 mb-1">Telepon / WhatsApp Layanan</label>
                        <input id="contact_phone" type="text" name="contact_phone" value="{{ old('contact_phone', $settings['contact_phone']) }}"
                            class="block w-full px-3 py-2 border border-slate-300 rounded-lg text-xs focus:ring-orange-500 focus:border-orange-500">
                    </div>
                </div>
            </div>

            <div class="pt-4 border-t border-slate-200 flex justify-end">
                <button type="submit" class="inline-flex items-center gap-2 px-6 py-2.5 bg-orange-600 hover:bg-orange-700 text-white font-bold text-xs sm:text-sm rounded-xl shadow-md transition shadow-orange-600/30">
                    <i class="fa-solid fa-floppy-disk"></i> Simpan Pengaturan Halaman Awal
                </button>
            </div>
        </form>
    </div>

</div>
@endsection
