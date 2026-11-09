@extends('layouts.app')

@section('title', 'Edit Section 4: Kontak & Lokasi')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

    <!-- Breadcrumb & Back -->
    <div class="mb-6 flex items-center justify-between">
        <a href="{{ route('owner.dashboard') }}" class="inline-flex items-center gap-1.5 text-xs font-semibold text-slate-500 hover:text-emerald-600 transition">
            <i class="fa-solid fa-arrow-left"></i> Kembali ke Dashboard
        </a>
        <a href="{{ route('owner.preview') }}#kontak" target="_blank" class="text-xs font-semibold text-emerald-600 hover:underline">
            <i class="fa-regular fa-eye mr-1"></i> Pratinjau Section Ini
        </a>
    </div>

    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 sm:p-8">
        <div class="flex items-center gap-3 pb-4 border-b border-slate-200 mb-6">
            <div class="w-10 h-10 rounded-xl bg-amber-100 text-amber-700 flex items-center justify-center font-black text-lg">
                4
            </div>
            <div>
                <h1 class="text-xl font-bold text-slate-900">Section 4: Kontak, Media Sosial & Lokasi Peta</h1>
                <p class="text-xs text-slate-500">Hubungkan calon pembeli langsung ke WhatsApp, lokasi toko fisik di Google Maps, dan akun media sosial Anda.</p>
            </div>
        </div>

        <form method="POST" action="{{ route('owner.contact.update') }}" class="space-y-6">
            @csrf

            <!-- WhatsApp Direct Conversion (Primary) -->
            <div class="p-4 bg-emerald-50 border border-emerald-200 rounded-xl">
                <label for="whatsapp" class="block text-xs font-bold uppercase tracking-wider text-emerald-900 mb-1.5">
                    Nomor WhatsApp Direct <span class="text-rose-500">* (Wajib untuk Tombol Konversi)</span>
                </label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-emerald-700 font-bold text-sm">
                        <i class="fa-brands fa-whatsapp text-lg mr-1.5"></i> +62
                    </div>
                    <input id="whatsapp" type="text" name="whatsapp" value="{{ old('whatsapp', $contact->whatsapp ?? $mitra->kontak) }}" required
                        placeholder="81234567890"
                        class="block w-full pl-24 pr-3.5 py-2.5 border border-emerald-300 rounded-xl text-sm placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 bg-white transition">
                </div>
                <p class="text-[11px] text-emerald-800 mt-1.5">
                    Nomor ini menjadi tautan otomatis tombol "Hubungi Penjual via WhatsApp" di setiap kartu produk dan tombol melayang (floating WA) di website promosi Anda.
                </p>
            </div>

            <!-- Alamat & Telepon Kantor -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label for="telepon" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                        Telepon Kantor / Tambahan
                    </label>
                    <input id="telepon" type="text" name="telepon" value="{{ old('telepon', $contact->telepon) }}"
                        placeholder="Contoh: 021-7208899"
                        class="block w-full px-3.5 py-2.5 border border-slate-300 rounded-xl text-sm placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition">
                </div>

                <div>
                    <label for="email" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                        Email Usaha
                    </label>
                    <input id="email" type="email" name="email" value="{{ old('email', $contact->email ?? $mitra->user?->email) }}"
                        placeholder="halo@usaha.com"
                        class="block w-full px-3.5 py-2.5 border border-slate-300 rounded-xl text-sm placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition">
                </div>
            </div>

            <!-- Jam Operasional -->
            <div>
                <label for="jam_operasional" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                    Jam Operasional / Buka Toko
                </label>
                <input id="jam_operasional" type="text" name="jam_operasional" value="{{ old('jam_operasional', $contact->jam_operasional ?? 'Senin - Sabtu: 08:00 - 17:00 WIB') }}"
                    placeholder="Contoh: Setiap Hari: 09:00 - 21:00 WIB"
                    class="block w-full px-3.5 py-2.5 border border-slate-300 rounded-xl text-sm placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition">
            </div>

            <!-- Alamat Lengkap Fisik -->
            <div>
                <label for="alamat" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                    Alamat Lengkap Usaha / Gerai
                </label>
                <textarea id="alamat" name="alamat" rows="2"
                    class="block w-full px-3.5 py-2.5 border border-slate-300 rounded-xl text-sm placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition">{{ old('alamat', $contact->alamat ?? $mitra->alamat) }}</textarea>
            </div>

            <!-- Media Sosial -->
            <div class="border-t border-slate-200 pt-5">
                <h3 class="text-xs font-bold uppercase tracking-wider text-slate-700 mb-3">Akun Media Sosial Usaha</h3>
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <div>
                        <label for="instagram" class="block text-[11px] font-semibold text-slate-600 mb-1">
                            <i class="fa-brands fa-instagram text-pink-600 mr-1"></i> Instagram
                        </label>
                        <input id="instagram" type="text" name="instagram" value="{{ old('instagram', $contact->instagram) }}"
                            placeholder="@nama_usaha"
                            class="block w-full px-3 py-2 border border-slate-300 rounded-lg text-xs focus:ring-emerald-500 focus:border-emerald-500">
                    </div>

                    <div>
                        <label for="facebook" class="block text-[11px] font-semibold text-slate-600 mb-1">
                            <i class="fa-brands fa-facebook text-blue-600 mr-1"></i> Facebook
                        </label>
                        <input id="facebook" type="text" name="facebook" value="{{ old('facebook', $contact->facebook) }}"
                            placeholder="Halaman Usaha"
                            class="block w-full px-3 py-2 border border-slate-300 rounded-lg text-xs focus:ring-emerald-500 focus:border-emerald-500">
                    </div>

                    <div>
                        <label for="tiktok" class="block text-[11px] font-semibold text-slate-600 mb-1">
                            <i class="fa-brands fa-tiktok text-slate-900 mr-1"></i> TikTok
                        </label>
                        <input id="tiktok" type="text" name="tiktok" value="{{ old('tiktok', $contact->tiktok) }}"
                            placeholder="@nama_tiktok"
                            class="block w-full px-3 py-2 border border-slate-300 rounded-lg text-xs focus:ring-emerald-500 focus:border-emerald-500">
                    </div>
                </div>
            </div>

            <!-- Embed Google Maps -->
            <div class="border-t border-slate-200 pt-5">
                <label for="maps_embed" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                    Embed Peta Google Maps (Iframe / URL)
                </label>
                <textarea id="maps_embed" name="maps_embed" rows="3"
                    placeholder="Tempelkan URL embed Google Maps atau kode &lt;iframe src=&quot;https://www.google.com/maps/embed?...&quot;&gt;&lt;/iframe&gt;..."
                    class="block w-full px-3.5 py-2.5 border border-slate-300 rounded-xl text-xs font-mono placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition">{{ old('maps_embed', $contact->maps_embed) }}</textarea>
                <p class="text-[11px] text-slate-500 mt-1">
                    Buka Google Maps &rarr; Cari lokasi usaha Anda &rarr; Klik Bagikan (Share) &rarr; Pilih "Sematkan peta" (Embed a map) &rarr; Salin URL atau kode iframe ke kolom ini.
                </p>
            </div>

            <!-- Action Buttons -->
            <div class="pt-4 border-t border-slate-200 flex items-center justify-between">
                <a href="{{ route('owner.dashboard') }}" class="px-4 py-2.5 border border-slate-300 rounded-xl text-slate-700 text-xs font-semibold hover:bg-slate-50 transition">
                    Batal
                </a>
                <button type="submit" class="inline-flex items-center gap-2 px-6 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs sm:text-sm rounded-xl shadow-md transition shadow-emerald-600/30">
                    <i class="fa-solid fa-floppy-disk"></i> Simpan Section Kontak
                </button>
            </div>
        </form>
    </div>

</div>
@endsection
