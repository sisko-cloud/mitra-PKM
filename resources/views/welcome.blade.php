@extends('layouts.public')

@section('title', 'Mitra PKM - Direktori & Etalase Promosi UMKM dan Koperasi')

@section('content')

<!-- HERO SECTION PUBLIK (EDITABLE BY SUPERADMIN) -->
<section class="relative bg-gradient-to-b from-emerald-900 via-teal-900 to-slate-900 text-white py-16 sm:py-24 px-4 sm:px-6 lg:px-8 overflow-hidden">
    <!-- Ambient glow decorative circles -->
    <div class="absolute -top-24 -left-24 w-96 h-96 bg-emerald-500/20 rounded-full blur-3xl pointer-events-none"></div>
    <div class="absolute top-1/2 -right-24 w-96 h-96 bg-teal-400/15 rounded-full blur-3xl pointer-events-none"></div>

    <div class="max-w-5xl mx-auto text-center relative z-10">
        <!-- Top Badge -->
        <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-emerald-500/20 border border-emerald-400/30 text-emerald-300 text-xs sm:text-sm font-semibold mb-6 shadow-xs backdrop-blur-xs">
            <i class="fa-solid fa-certificate text-emerald-400"></i>
            <span>{{ $heroBadge }}</span>
        </div>

        <!-- Big Hero Title -->
        <h1 class="text-4xl sm:text-6xl lg:text-7xl font-black tracking-tight text-white mb-6 leading-tight">
            {{ $heroTitle }}
        </h1>

        <!-- Subtitle / Description -->
        <p class="text-base sm:text-xl text-slate-200 max-w-3xl mx-auto leading-relaxed mb-10 font-normal">
            {{ $heroDescription }}
        </p>

        <!-- Search Bar & Filter Section -->
        <div class="max-w-3xl mx-auto">
            <form method="GET" action="{{ route('home') }}#katalog" class="bg-white p-2 sm:p-2.5 rounded-2xl sm:rounded-3xl shadow-2xl flex flex-col sm:flex-row items-center gap-2 text-slate-800 border border-white/20">
                <div class="relative flex-1 w-full flex items-center">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400 text-base">
                        <i class="fa-solid fa-magnifying-glass"></i>
                    </div>
                    <input type="text" name="q" value="{{ $search }}"
                        placeholder="Cari produk kuliner, kriya, batik, kopi, atau nama mitra..."
                        class="w-full pl-11 pr-4 py-3 text-sm sm:text-base border-0 focus:ring-0 text-slate-800 placeholder-slate-400 rounded-xl focus:outline-none">
                </div>

                <div class="flex items-center gap-2 w-full sm:w-auto shrink-0">
                    <select name="jenis" class="text-xs sm:text-sm font-semibold bg-slate-100 hover:bg-slate-200 text-slate-700 py-3 px-4 rounded-xl border-0 focus:ring-0 cursor-pointer">
                        <option value="">Semua Usaha</option>
                        <option value="umkm" {{ $filterJenis === 'umkm' ? 'selected' : '' }}>UMKM</option>
                        <option value="koperasi" {{ $filterJenis === 'koperasi' ? 'selected' : '' }}>Koperasi</option>
                    </select>

                    <button type="submit" class="flex-1 sm:flex-none inline-flex items-center justify-center gap-2 px-6 py-3 bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-sm rounded-xl sm:rounded-2xl shadow-md transition shadow-emerald-600/30">
                        <span>Cari Mitra</span>
                    </button>
                </div>
            </form>

            @if ($search || $filterJenis)
                <div class="mt-3 flex items-center justify-center gap-2 text-xs text-slate-300">
                    <span>Menampilkan hasil pencarian untuk: <strong>"{{ $search ?: $filterJenis }}"</strong></span>
                    <a href="{{ route('home') }}#katalog" class="text-emerald-400 hover:underline ml-1 font-semibold">
                        [Hapus Filter]
                    </a>
                </div>
            @endif
        </div>

        <!-- Quick Stats under search -->
        <div class="mt-12 pt-8 border-t border-white/10 flex flex-wrap items-center justify-center gap-8 sm:gap-16 text-center text-xs sm:text-sm text-slate-300">
            <div>
                <span class="block text-2xl sm:text-3xl font-extrabold text-white mb-0.5">{{ $totalMitraCount }}</span>
                <span>Mitra Terverifikasi</span>
            </div>
            <div>
                <span class="block text-2xl sm:text-3xl font-extrabold text-emerald-400 mb-0.5">100%</span>
                <span>Binaan PKM Resmi</span>
            </div>
            <div>
                <span class="block text-2xl sm:text-3xl font-extrabold text-teal-300 mb-0.5">Direct</span>
                <span>WhatsApp Terintegrasi</span>
            </div>
        </div>
    </div>
</section>

<!-- KATALOG DIREKTORI MITRA (GRID KARTU MITRA) -->
<section id="katalog" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">

    <!-- Section Heading -->
    <div class="flex flex-col md:flex-row md:items-end justify-between gap-4 mb-10 pb-4 border-b border-slate-200">
        <div>
            <div class="inline-flex items-center gap-1.5 text-xs font-bold uppercase tracking-wider text-emerald-600 mb-1">
                <i class="fa-solid fa-cubes"></i> Direktori Etalase
            </div>
            <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">Katalog Mitra PKM Aktif</h2>
            <p class="text-sm text-slate-500 mt-1">Jelajahi dan buka website promosi mandiri setiap mitra UMKM & Koperasi di bawah ini.</p>
        </div>

        <!-- Category Pills Filter -->
        <div class="flex items-center gap-2 text-xs font-semibold overflow-x-auto pb-1">
            <a href="{{ route('home', ['q' => $search]) }}#katalog"
               class="px-4 py-2 rounded-xl transition {{ empty($filterJenis) ? 'bg-slate-900 text-white shadow-xs' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
                Semua Mitra
            </a>
            <a href="{{ route('home', ['jenis' => 'umkm', 'q' => $search]) }}#katalog"
               class="px-4 py-2 rounded-xl transition {{ $filterJenis === 'umkm' ? 'bg-blue-600 text-white shadow-xs' : 'bg-blue-50 text-blue-700 hover:bg-blue-100' }}">
                <i class="fa-solid fa-shop mr-1"></i> UMKM
            </a>
            <a href="{{ route('home', ['jenis' => 'koperasi', 'q' => $search]) }}#katalog"
               class="px-4 py-2 rounded-xl transition {{ $filterJenis === 'koperasi' ? 'bg-purple-600 text-white shadow-xs' : 'bg-purple-50 text-purple-700 hover:bg-purple-100' }}">
                <i class="fa-solid fa-users-rectangle mr-1"></i> Koperasi
            </a>
        </div>
    </div>

    <!-- Empty State -->
    @if ($mitras->count() === 0)
        <div class="bg-white rounded-3xl border border-slate-200 p-12 text-center shadow-xs">
            <div class="w-20 h-20 rounded-3xl bg-slate-100 text-slate-400 flex items-center justify-center text-4xl mx-auto mb-4">
                <i class="fa-solid fa-store-slash"></i>
            </div>
            <h3 class="text-xl font-bold text-slate-800 mb-2">Belum Ada Mitra Ditemukan</h3>
            <p class="text-sm text-slate-500 max-w-md mx-auto mb-6">
                @if ($search || $filterJenis)
                    Tidak ada mitra yang cocok dengan kata kunci pencarian Anda. Silakan coba kata kunci lain.
                @else
                    Belum ada mitra UMKM atau Koperasi yang terverifikasi dan aktif di sistem saat ini.
                @endif
            </p>
            @if ($search || $filterJenis)
                <a href="{{ route('home') }}#katalog" class="inline-flex items-center gap-2 px-5 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs sm:text-sm rounded-xl shadow-md transition">
                    <i class="fa-solid fa-rotate-left"></i> Lihat Semua Mitra
                </a>
            @else
                <a href="{{ route('register') }}" class="inline-flex items-center gap-2 px-5 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs sm:text-sm rounded-xl shadow-md transition">
                    <i class="fa-solid fa-plus-circle"></i> Jadilah Mitra Pertama Kami
                </a>
            @endif
        </div>
    @else
        <!-- Grid Jejeran Kartu Mitra (Card Grid) -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 sm:gap-8">
            @foreach ($mitras as $mitra)
                <a href="{{ route('mitra.show', ['slug' => $mitra->slug]) }}"
                   class="group bg-white rounded-3xl border border-slate-200 shadow-xs hover:shadow-xl hover:border-emerald-300 transition duration-300 flex flex-col justify-between overflow-hidden relative">

                    <div>
                        <!-- Sampul Card (Hero / Gradient Banner) -->
                        <div class="h-36 sm:h-40 bg-gradient-to-tr from-slate-800 to-emerald-900 relative overflow-hidden">
                            @if ($mitra->websiteContent?->hero_image)
                                <img src="{{ Str::startsWith($mitra->websiteContent->hero_image, 'http') ? $mitra->websiteContent->hero_image : asset('storage/' . $mitra->websiteContent->hero_image) }}"
                                     alt="{{ $mitra->nama_usaha }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-500 opacity-80 group-hover:opacity-100">
                            @else
                                <div class="w-full h-full flex items-center justify-center text-white/20">
                                    <i class="fa-solid fa-store text-5xl"></i>
                                </div>
                            @endif

                            <div class="absolute inset-0 bg-gradient-to-t from-slate-950/80 via-transparent to-transparent"></div>

                            <!-- Badge Jenis Usaha -->
                            <div class="absolute top-3 left-3">
                                <span class="px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider shadow-sm {{ $mitra->jenis === 'umkm' ? 'bg-blue-600 text-white' : 'bg-purple-600 text-white' }}">
                                    {{ $mitra->jenis }}
                                </span>
                            </div>

                            <!-- Verified PKM Badge -->
                            <div class="absolute top-3 right-3">
                                <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-emerald-500 text-slate-950 shadow-sm">
                                    <i class="fa-solid fa-circle-check text-[10px]"></i> Terverifikasi
                                </span>
                            </div>
                        </div>

                        <!-- Card Body -->
                        <div class="p-6 relative">
                            <!-- Logo Avatar Overlap -->
                            <div class="-mt-12 mb-4 flex items-center justify-between">
                                @if ($mitra->logo)
                                    <img src="{{ asset('storage/' . $mitra->logo) }}" alt="{{ $mitra->nama_usaha }}"
                                         class="w-16 h-16 rounded-2xl object-cover bg-white p-1 border-2 border-white shadow-md">
                                @else
                                    <div class="w-16 h-16 rounded-2xl bg-emerald-600 text-white font-black text-2xl flex items-center justify-center border-2 border-white shadow-md">
                                        {{ substr($mitra->nama_usaha, 0, 2) }}
                                    </div>
                                @endif

                                <span class="text-xs text-slate-400 font-semibold flex items-center gap-1">
                                    <i class="fa-solid fa-boxes-stacked text-emerald-600"></i>
                                    {{ $mitra->products->count() }} Produk
                                </span>
                            </div>

                            <!-- Nama Mitra -->
                            <h3 class="text-lg font-bold text-slate-900 group-hover:text-emerald-600 transition tracking-tight mb-1.5 line-clamp-1">
                                {{ $mitra->nama_usaha }}
                            </h3>

                            <!-- Tagline / Deskripsi Singkat -->
                            <p class="text-xs text-slate-500 leading-relaxed line-clamp-2 mb-4">
                                {{ $mitra->websiteContent?->tagline ?? $mitra->websiteContent?->deskripsi ?? 'Kunjungi website promosi resmi untuk melihat penawaran produk.' }}
                            </p>

                            <!-- Alamat Singkat -->
                            <div class="flex items-center gap-1.5 text-xs text-slate-400 truncate">
                                <i class="fa-solid fa-location-dot text-emerald-600 shrink-0"></i>
                                <span class="truncate">{{ $mitra->alamat }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Card Footer: Direct CTA -->
                    <div class="p-4 bg-slate-50 border-t border-slate-100 flex items-center justify-between text-xs">
                        <span class="font-bold text-slate-700 group-hover:text-emerald-700 transition flex items-center gap-1">
                            Buka Website Promosi <i class="fa-solid fa-arrow-right text-[10px] group-hover:translate-x-1 transition-transform"></i>
                        </span>
                        <span class="text-emerald-600 font-bold bg-emerald-50 px-2 py-1 rounded-md text-[11px] border border-emerald-100">
                            <i class="fa-brands fa-whatsapp"></i> Chat WA
                        </span>
                    </div>

                </a>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="mt-12">
            {{ $mitras->links() }}
        </div>
    @endif

</section>

<!-- SECTION TENTANG PROGRAM PKM & AJAKAN BERGABUNG -->
<section id="tentang-pkm" class="bg-slate-100 border-t border-slate-200 py-16 sm:py-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-gradient-to-r from-emerald-800 to-teal-900 rounded-3xl p-8 sm:p-14 text-white shadow-xl flex flex-col lg:flex-row items-center justify-between gap-8">
            <div class="max-w-2xl">
                <span class="px-3 py-1 rounded-full bg-emerald-500/20 text-emerald-300 text-xs font-bold uppercase tracking-wider border border-emerald-400/30 mb-3 inline-block">
                    Inisiatif Pemberdayaan PKM
                </span>
                <h3 class="text-2xl sm:text-3xl font-extrabold mb-3 leading-snug">
                    Pemilik UMKM atau Pengurus Koperasi Binaan PKM?
                </h3>
                <p class="text-sm sm:text-base text-slate-200 leading-relaxed">
                    Dapatkan website promosi modern dengan 4 section lengkap (Beranda, Profil, Katalog Produk, Kontak & Google Maps) serta terhubung langsung ke WhatsApp Anda secara gratis.
                </p>
            </div>
            <div class="shrink-0 flex flex-col sm:flex-row gap-3 w-full lg:w-auto">
                <a href="{{ route('register') }}" class="px-6 py-3.5 bg-emerald-500 hover:bg-emerald-400 text-slate-950 font-bold text-sm rounded-xl text-center shadow-lg transition shadow-emerald-500/30">
                    <i class="fa-solid fa-plus-circle mr-1.5"></i> Daftar Sekarang
                </a>
                <a href="{{ route('login') }}" class="px-6 py-3.5 bg-white/10 hover:bg-white/20 text-white font-bold text-sm rounded-xl text-center border border-white/20 transition">
                    Masuk Akun
                </a>
            </div>
        </div>
    </div>
</section>

@endsection
