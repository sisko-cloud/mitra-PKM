@extends('layouts.app')

@section('title', 'Dashboard Editor - ' . $mitra->nama_usaha)

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

    <!-- Top Partner Hero Banner -->
    <div class="bg-gradient-to-r from-emerald-800 via-teal-800 to-slate-900 rounded-3xl p-6 sm:p-10 text-white shadow-xl mb-8 relative overflow-hidden">
        <div class="absolute -right-10 -bottom-10 w-64 h-64 bg-emerald-500/10 rounded-full blur-2xl pointer-events-none"></div>

        <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-6 relative z-10">
            <div class="flex items-start sm:items-center gap-4 sm:gap-6">
                @if ($mitra->logo)
                    <img src="{{ media_url($mitra->logo) }}" alt="{{ $mitra->nama_usaha }}" class="w-16 h-16 sm:w-20 sm:h-20 rounded-2xl object-cover bg-white p-1 shadow-md border-2 border-emerald-400">
                @else
                    <div class="w-16 h-16 sm:w-20 sm:h-20 rounded-2xl bg-emerald-600/60 border border-emerald-400/40 text-white flex items-center justify-center font-black text-2xl shadow-md">
                        {{ substr($mitra->nama_usaha, 0, 2) }}
                    </div>
                @endif
                <div>
                    <div class="flex items-center gap-2 mb-1.5 flex-wrap">
                        <span class="px-2.5 py-0.5 rounded-full text-[11px] font-bold uppercase tracking-wider bg-emerald-500/20 text-emerald-300 border border-emerald-400/30">
                            {{ $mitra->jenis }}
                        </span>
                        @if ($mitra->is_published)
                            <span class="px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-emerald-500 text-white flex items-center gap-1">
                                <i class="fa-solid fa-globe text-[10px]"></i> Terpublikasi
                            </span>
                        @else
                            <span class="px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-amber-400 text-slate-900 flex items-center gap-1">
                                <i class="fa-solid fa-file-pen text-[10px]"></i> Mode Draf
                            </span>
                        @endif
                        <span class="px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-emerald-400/20 text-emerald-200">
                            <i class="fa-solid fa-circle-check text-[10px] text-emerald-400 mr-0.5"></i> Terverifikasi PKM
                        </span>
                    </div>
                    <h1 class="text-2xl sm:text-3xl font-extrabold tracking-tight text-white">{{ $mitra->nama_usaha }}</h1>
                    <p class="text-xs sm:text-sm text-slate-300 mt-1 max-w-xl line-clamp-1">
                        {{ $mitra->websiteContent?->tagline ?? 'Kelola 4 section website promosi Anda dengan mudah.' }}
                    </p>
                </div>
            </div>

            <!-- Quick Action Buttons -->
            <div class="flex flex-wrap items-center gap-2.5">
                <a href="{{ route('owner.preview') }}" target="_blank" class="px-4 py-2.5 rounded-xl bg-white/10 hover:bg-white/20 backdrop-blur-sm text-white font-semibold text-xs sm:text-sm border border-white/20 transition flex items-center gap-2 shadow-xs">
                    <i class="fa-regular fa-eye text-emerald-300"></i> Pratinjau
                </a>

                <form method="POST" action="{{ route('owner.settings.publish') }}">
                    @csrf
                    @if ($mitra->is_published)
                        <button type="submit" class="px-4 py-2.5 rounded-xl bg-amber-500/20 hover:bg-amber-500/30 text-amber-200 font-semibold text-xs sm:text-sm border border-amber-400/30 transition flex items-center gap-2">
                            <i class="fa-solid fa-pause"></i> Tarik ke Draf
                        </button>
                    @else
                        <button type="submit" class="px-4 py-2.5 rounded-xl bg-emerald-500 hover:bg-emerald-600 text-slate-950 font-bold text-xs sm:text-sm shadow-lg shadow-emerald-500/30 transition flex items-center gap-2">
                            <i class="fa-solid fa-cloud-arrow-up"></i> Publikasikan Live
                        </button>
                    @endif
                </form>
            </div>
        </div>

        <!-- Live Website Share Bar -->
        <div class="mt-8 pt-6 border-t border-white/10 flex flex-col sm:flex-row sm:items-center justify-between gap-4 text-xs">
            <div class="flex items-center gap-2 text-slate-300 overflow-hidden">
                <span class="font-bold text-white shrink-0"><i class="fa-solid fa-link text-emerald-400 mr-1"></i> Tautan Website:</span>
                <a href="{{ route('mitra.show', ['slug' => $mitra->slug]) }}" target="_blank" class="font-mono text-emerald-300 hover:underline truncate">
                    {{ url('/mitra/' . $mitra->slug) }}
                </a>
            </div>
            <div class="flex items-center gap-2 shrink-0" x-data="{ copied: false }">
                <button @click="navigator.clipboard.writeText('{{ url('/mitra/' . $mitra->slug) }}'); copied = true; setTimeout(() => copied = false, 2500)"
                    class="px-3 py-1.5 rounded-lg bg-white/10 hover:bg-white/20 text-white font-medium text-xs transition flex items-center gap-1.5">
                    <i class="fa-regular fa-copy" x-show="!copied"></i>
                    <i class="fa-solid fa-check text-emerald-300" x-show="copied" x-cloak></i>
                    <span x-text="copied ? 'Tersalin!' : 'Salin Tautan'">Salin Tautan</span>
                </button>
                <a href="https://api.whatsapp.com/send?text={{ urlencode('Kunjungi etalase resmi ' . $mitra->nama_usaha . ': ' . url('/mitra/' . $mitra->slug)) }}" target="_blank"
                    class="px-3 py-1.5 rounded-lg bg-emerald-500 hover:bg-emerald-600 text-slate-950 font-bold text-xs transition flex items-center gap-1.5">
                    <i class="fa-brands fa-whatsapp text-sm"></i> Bagikan ke WhatsApp
                </a>
            </div>
        </div>
    </div>

    <!-- 4 Section Editor Menu Cards -->
    <div class="mb-10">
        <div class="flex items-center justify-between mb-5">
            <div>
                <h2 class="text-xl font-bold text-slate-900 tracking-tight">Kelola 4 Section Website Promosi</h2>
                <p class="text-xs sm:text-sm text-slate-500">Sesuaikan setiap bagian halaman promosi Anda agar menarik bagi calon pembeli.</p>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">

            <!-- KARTU 1: SECTION BERANDA / HERO -->
            <div class="bg-white rounded-2xl border border-slate-200 shadow-xs hover:shadow-md transition p-5 flex flex-col justify-between group">
                <div>
                    <div class="flex items-center justify-between mb-3">
                        <span class="w-8 h-8 rounded-xl bg-emerald-100 text-emerald-700 font-extrabold text-sm flex items-center justify-center">1</span>
                        <span class="text-xs font-semibold px-2 py-0.5 rounded-md {{ !empty($mitra->websiteContent?->judul) ? 'bg-emerald-50 text-emerald-700' : 'bg-slate-100 text-slate-500' }}">
                            {{ !empty($mitra->websiteContent?->judul) ? 'Terisi' : 'Kosong' }}
                        </span>
                    </div>
                    <h3 class="font-bold text-slate-900 text-base mb-1 group-hover:text-emerald-600 transition">Beranda & Sampul</h3>
                    <p class="text-xs text-slate-500 leading-relaxed mb-4">
                        Atur judul utama, tagline usaha, dan gambar sampul utama (hero banner).
                    </p>
                </div>
                <a href="{{ route('owner.hero.edit') }}" class="w-full inline-flex items-center justify-center gap-1.5 py-2 px-3 rounded-xl bg-slate-50 hover:bg-emerald-600 hover:text-white text-slate-700 text-xs font-bold transition border border-slate-200 hover:border-emerald-600">
                    <i class="fa-solid fa-pen-to-square"></i> Edit Section 1 &rarr;
                </a>
            </div>

            <!-- KARTU 2: SECTION TENTANG -->
            <div class="bg-white rounded-2xl border border-slate-200 shadow-xs hover:shadow-md transition p-5 flex flex-col justify-between group">
                <div>
                    <div class="flex items-center justify-between mb-3">
                        <span class="w-8 h-8 rounded-xl bg-teal-100 text-teal-700 font-extrabold text-sm flex items-center justify-center">2</span>
                        <span class="text-xs font-semibold px-2 py-0.5 rounded-md {{ !empty($mitra->websiteContent?->deskripsi) ? 'bg-emerald-50 text-emerald-700' : 'bg-slate-100 text-slate-500' }}">
                            {{ !empty($mitra->websiteContent?->deskripsi) ? 'Terisi' : 'Kosong' }}
                        </span>
                    </div>
                    <h3 class="font-bold text-slate-900 text-base mb-1 group-hover:text-teal-600 transition">Tentang & Visi Misi</h3>
                    <p class="text-xs text-slate-500 leading-relaxed mb-4">
                        Tuliskan profil lengkap usaha, sejarah berdiri, serta visi & misi usaha Anda.
                    </p>
                </div>
                <a href="{{ route('owner.about.edit') }}" class="w-full inline-flex items-center justify-center gap-1.5 py-2 px-3 rounded-xl bg-slate-50 hover:bg-teal-600 hover:text-white text-slate-700 text-xs font-bold transition border border-slate-200 hover:border-teal-600">
                    <i class="fa-solid fa-pen-to-square"></i> Edit Section 2 &rarr;
                </a>
            </div>

            <!-- KARTU 3: SECTION PRODUK / GALERI -->
            <div class="bg-white rounded-2xl border border-slate-200 shadow-xs hover:shadow-md transition p-5 flex flex-col justify-between group">
                <div>
                    <div class="flex items-center justify-between mb-3">
                        <span class="w-8 h-8 rounded-xl bg-indigo-100 text-indigo-700 font-extrabold text-sm flex items-center justify-center">3</span>
                        <span class="text-xs font-semibold px-2 py-0.5 rounded-md bg-indigo-50 text-indigo-700 font-bold">
                            {{ $totalProducts }} Produk
                        </span>
                    </div>
                    <h3 class="font-bold text-slate-900 text-base mb-1 group-hover:text-indigo-600 transition">Produk & Galeri</h3>
                    <p class="text-xs text-slate-500 leading-relaxed mb-4">
                        Kelola katalog produk, foto resolusi tinggi, deskripsi, harga, dan urutan etalase.
                    </p>
                </div>
                <a href="{{ route('owner.products.index') }}" class="w-full inline-flex items-center justify-center gap-1.5 py-2 px-3 rounded-xl bg-slate-50 hover:bg-indigo-600 hover:text-white text-slate-700 text-xs font-bold transition border border-slate-200 hover:border-indigo-600">
                    <i class="fa-solid fa-boxes-stacked"></i> Kelola Produk ({{ $totalProducts }}) &rarr;
                </a>
            </div>

            <!-- KARTU 4: SECTION KONTAK & LOKASI -->
            <div class="bg-white rounded-2xl border border-slate-200 shadow-xs hover:shadow-md transition p-5 flex flex-col justify-between group">
                <div>
                    <div class="flex items-center justify-between mb-3">
                        <span class="w-8 h-8 rounded-xl bg-amber-100 text-amber-700 font-extrabold text-sm flex items-center justify-center">4</span>
                        <span class="text-xs font-semibold px-2 py-0.5 rounded-md {{ !empty($mitra->contact?->whatsapp) ? 'bg-emerald-50 text-emerald-700' : 'bg-rose-50 text-rose-700' }}">
                            {{ !empty($mitra->contact?->whatsapp) ? 'WhatsApp Siap' : 'Perlu WA' }}
                        </span>
                    </div>
                    <h3 class="font-bold text-slate-900 text-base mb-1 group-hover:text-amber-600 transition">Kontak & Lokasi</h3>
                    <p class="text-xs text-slate-500 leading-relaxed mb-4">
                        Atur nomor WhatsApp direct, alamat, jam operasional, medsos, dan peta Google Maps.
                    </p>
                </div>
                <a href="{{ route('owner.contact.edit') }}" class="w-full inline-flex items-center justify-center gap-1.5 py-2 px-3 rounded-xl bg-slate-50 hover:bg-amber-600 hover:text-white text-slate-700 text-xs font-bold transition border border-slate-200 hover:border-amber-600">
                    <i class="fa-solid fa-address-book"></i> Edit Section 4 &rarr;
                </a>
            </div>

        </div>
    </div>

    <!-- Quick Settings & Status Guide -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Settings Quick Link -->
        <div class="bg-white rounded-2xl border border-slate-200 shadow-xs p-6">
            <h3 class="text-sm font-bold text-slate-900 mb-2 flex items-center gap-2">
                <i class="fa-solid fa-sliders text-emerald-600"></i> Pengaturan Website & URL
            </h3>
            <p class="text-xs text-slate-500 leading-relaxed mb-4">
                Ubah kustomisasi slug URL (misal: <code class="font-mono text-emerald-700">/mitra/{{ $mitra->slug }}</code>) dan status aktifasi website.
            </p>
            <a href="{{ route('owner.settings.edit') }}" class="text-xs font-bold text-emerald-600 hover:text-emerald-700 hover:underline inline-flex items-center gap-1">
                Buka Pengaturan Website &rarr;
            </a>
        </div>

        <!-- WhatsApp Direct Info -->
        <div class="bg-white rounded-2xl border border-slate-200 shadow-xs p-6">
            <h3 class="text-sm font-bold text-slate-900 mb-2 flex items-center gap-2">
                <i class="fa-brands fa-whatsapp text-emerald-600"></i> Tombol WhatsApp Direct
            </h3>
            <p class="text-xs text-slate-500 leading-relaxed mb-2">
                Setiap pengunjung yang tertarik dengan produk Anda di website promosi dapat langsung menghubungi nomor WhatsApp Anda secara instan:
            </p>
            <span class="font-bold text-emerald-700 text-xs bg-emerald-50 px-2.5 py-1 rounded-md inline-block">
                {{ $mitra->contact?->whatsapp ? '+' . $mitra->contact->whatsapp : 'Belum diatur' }}
            </span>
        </div>

        <!-- System Notifications -->
        <div class="bg-white rounded-2xl border border-slate-200 shadow-xs p-6">
            <h3 class="text-sm font-bold text-slate-900 mb-2 flex items-center gap-2">
                <i class="fa-regular fa-bell text-emerald-600"></i> Notifikasi Terkini
            </h3>
            @if ($notifications->count() > 0)
                <div class="space-y-2 text-xs">
                    @foreach ($notifications->take(2) as $notif)
                        <div class="p-2 bg-slate-50 rounded-lg text-slate-700">
                            {{ $notif->data['message'] ?? 'Pemberitahuan akun' }}
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-xs text-slate-400">Tidak ada notifikasi baru.</p>
            @endif
        </div>
    </div>

</div>
@endsection
