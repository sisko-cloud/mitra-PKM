@extends('layouts.app')

@section('title', 'Edit Section 2: Tentang & Visi Misi')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

    <!-- Breadcrumb & Back -->
    <div class="mb-6 flex items-center justify-between">
        <a href="{{ route('owner.dashboard') }}" class="inline-flex items-center gap-1.5 text-xs font-semibold text-slate-500 hover:text-emerald-600 transition">
            <i class="fa-solid fa-arrow-left"></i> Kembali ke Dashboard
        </a>
        <a href="{{ route('owner.preview') }}#tentang" target="_blank" class="text-xs font-semibold text-emerald-600 hover:underline">
            <i class="fa-regular fa-eye mr-1"></i> Pratinjau Section Ini
        </a>
    </div>

    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 sm:p-8">
        <div class="flex items-center gap-3 pb-4 border-b border-slate-200 mb-6">
            <div class="w-10 h-10 rounded-xl bg-teal-100 text-teal-700 flex items-center justify-center font-black text-lg">
                2
            </div>
            <div>
                <h1 class="text-xl font-bold text-slate-900">Section 2: Tentang / Profil Usaha, Sejarah, & Visi Misi</h1>
                <p class="text-xs text-slate-500">Bangun kepercayaan calon pelanggan dan mitra dengan menceritakan profil dan nilai keunggulan usaha Anda.</p>
            </div>
        </div>

        <form method="POST" action="{{ route('owner.about.update') }}" class="space-y-6">
            @csrf

            <!-- Deskripsi Usaha -->
            <div>
                <label for="deskripsi" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                    Deskripsi Ringkas Usaha
                </label>
                <textarea id="deskripsi" name="deskripsi" rows="4"
                    placeholder="Ceritakan bidang usaha, produk atau jasa utama, serta target pasar yang Anda layani..."
                    class="block w-full px-3.5 py-2.5 border border-slate-300 rounded-xl text-sm placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition">{{ old('deskripsi', $content->deskripsi) }}</textarea>
                <p class="text-[11px] text-slate-500 mt-1">Gunakan paragraf yang mudah dibaca dan komunikatif.</p>
            </div>

            <!-- Sejarah Usaha -->
            <div>
                <label for="sejarah" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                    Sejarah Singkat & Latar Belakang Kemitraan PKM
                </label>
                <textarea id="sejarah" name="sejarah" rows="3"
                    placeholder="Contoh: Berawal dari program PKM Kewirausahaan mahasiswa tahun 2023, kami berinovasi mengembangkan olahan pangan lokal..."
                    class="block w-full px-3.5 py-2.5 border border-slate-300 rounded-xl text-sm placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition">{{ old('sejarah', $content->sejarah) }}</textarea>
                <p class="text-[11px] text-slate-500 mt-1">Jelaskan bagaimana usaha Anda dirintis dan peran pendampingan program PKM.</p>
            </div>

            <!-- Visi & Misi -->
            <div>
                <label for="visi_misi" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                    Visi & Misi Usaha
                </label>
                <textarea id="visi_misi" name="visi_misi" rows="4"
                    placeholder="Visi: ...&#10;&#10;Misi:&#10;1. ...&#10;2. ..."
                    class="block w-full px-3.5 py-2.5 border border-slate-300 rounded-xl text-sm placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition font-sans">{{ old('visi_misi', $content->visi_misi) }}</textarea>
                <p class="text-[11px] text-slate-500 mt-1">Anda dapat menggunakan poin penomoran untuk misi usaha.</p>
            </div>

            <!-- Action Buttons -->
            <div class="pt-4 border-t border-slate-200 flex items-center justify-between">
                <a href="{{ route('owner.dashboard') }}" class="px-4 py-2.5 border border-slate-300 rounded-xl text-slate-700 text-xs font-semibold hover:bg-slate-50 transition">
                    Batal
                </a>
                <button type="submit" class="inline-flex items-center gap-2 px-6 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs sm:text-sm rounded-xl shadow-md transition shadow-emerald-600/30">
                    <i class="fa-solid fa-floppy-disk"></i> Simpan Section Tentang
                </button>
            </div>
        </form>
    </div>

</div>
@endsection
