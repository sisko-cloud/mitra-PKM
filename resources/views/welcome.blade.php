@extends('layouts.public')

@section('title', 'Mitra PKM - Direktori & Etalase Promosi UMKM dan Koperasi')

@section('content')

<!-- HERO SECTION PUBLIK -->
<section class="relative bg-gradient-to-b from-slate-950 via-orange-950 to-slate-900 text-white py-16 sm:py-24 lg:py-28 px-4 sm:px-6 lg:px-8 overflow-hidden border-b border-orange-900/30">
    <!-- Ambient glow decorative circles -->
    <div class="absolute -top-32 -left-32 w-[30rem] h-[30rem] bg-orange-500/20 rounded-full blur-3xl pointer-events-none"></div>
    <div class="absolute top-1/2 -right-32 w-[30rem] h-[30rem] bg-amber-400/15 rounded-full blur-3xl pointer-events-none"></div>

    <div class="max-w-5xl mx-auto text-center relative z-10">
        <!-- Top Badge -->
        <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-orange-500/15 border border-orange-400/30 text-orange-300 text-xs sm:text-sm font-semibold mb-6 backdrop-blur-sm shadow-xs">
            <span class="w-2 h-2 rounded-full bg-orange-400 animate-ping"></span>
            <span>{{ $heroBadge }}</span>
        </div>

        <!-- Big Hero Title -->
        <h1 class="text-3xl sm:text-5xl lg:text-6xl font-black tracking-tight text-white mb-6 leading-tight">
            {{ $heroTitle }}
        </h1>

        <!-- Subtitle / Description -->
        <p class="text-sm sm:text-lg lg:text-xl text-slate-300 max-w-3xl mx-auto leading-relaxed mb-10 font-normal">
            {{ $heroDescription }}
        </p>

        <!-- Search Bar & Filter Section -->
        <div class="max-w-3xl mx-auto">
            <form method="GET" action="{{ route('home') }}#katalog" class="bg-white dark:bg-slate-900 p-2 sm:p-2.5 rounded-2xl sm:rounded-3xl shadow-2xl flex flex-col sm:flex-row items-center gap-2 text-slate-800 dark:text-slate-100 border border-slate-100 dark:border-slate-800 transition-colors">
                <div class="relative flex-1 w-full flex items-center">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400 dark:text-slate-500 text-sm sm:text-base">
                        <i class="fa-solid fa-magnifying-glass"></i>
                    </div>
                    <input type="text" name="q" value="{{ $search }}"
                        placeholder="Cari produk kopi, batik, mentai, beras, atau nama usaha..."
                        class="w-full pl-11 pr-4 py-3 text-xs sm:text-sm md:text-base bg-transparent border-0 focus:ring-0 text-slate-800 dark:text-slate-100 placeholder-slate-400 dark:placeholder-slate-500 rounded-xl focus:outline-none">
                </div>

                <div class="flex items-center gap-2 w-full sm:w-auto shrink-0">
                    <select name="jenis" class="text-xs sm:text-sm font-semibold bg-slate-100 dark:bg-slate-800 hover:bg-slate-200 dark:hover:bg-slate-700 text-slate-700 dark:text-slate-200 py-3 px-3.5 rounded-xl border-0 focus:ring-0 cursor-pointer transition">
                        <option value="">Semua Usaha</option>
                        <option value="umkm" {{ $filterJenis === 'umkm' ? 'selected' : '' }}>UMKM</option>
                        <option value="koperasi" {{ $filterJenis === 'koperasi' ? 'selected' : '' }}>Koperasi</option>
                    </select>

                    <button type="submit" class="flex-1 sm:flex-none inline-flex items-center justify-center gap-2 px-6 py-3 bg-gradient-to-r from-orange-600 to-amber-600 hover:from-orange-700 hover:to-amber-700 text-white font-bold text-xs sm:text-sm rounded-xl sm:rounded-2xl shadow-md transition shadow-orange-600/30">
                        <span>Cari Mitra</span>
                    </button>
                </div>
            </form>

            @if ($search || $filterJenis)
                <div class="mt-3 flex items-center justify-center gap-2 text-xs text-slate-300">
                    <span>Hasil untuk: <strong>"{{ $search ?: $filterJenis }}"</strong></span>
                    <a href="{{ route('home') }}#katalog" class="text-orange-400 hover:underline ml-1 font-semibold">
                        [Hapus Filter]
                    </a>
                </div>
            @endif
        </div>

        <!-- Quick Stats Metrics -->
        <div class="mt-12 pt-8 border-t border-white/10 grid grid-cols-3 gap-4 max-w-2xl mx-auto text-center">
            <div class="p-3">
                <span class="block text-2xl sm:text-3xl font-extrabold text-white mb-0.5">{{ $totalMitraCount }}</span>
                <span class="text-xs text-slate-400">Mitra Terverifikasi</span>
            </div>
            <div class="p-3">
                <span class="block text-2xl sm:text-3xl font-extrabold text-orange-400 mb-0.5">100%</span>
                <span class="text-xs text-slate-400">Binaan Resmi PKM</span>
            </div>
            <div class="p-3">
                <span class="block text-2xl sm:text-3xl font-extrabold text-amber-300 mb-0.5">Direct</span>
                <span class="text-xs text-slate-400">Pesan via WhatsApp</span>
            </div>
        </div>
    </div>
</section>

<!-- KATALOG DIREKTORI MITRA (GRID KARTU MITRA) -->
<section id="katalog" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 sm:py-20">

    <!-- Section Heading & Filter -->
    <div class="flex flex-col md:flex-row md:items-end justify-between gap-4 mb-10 pb-4 border-b border-slate-200 dark:border-slate-800">
        <div>
            <div class="inline-flex items-center gap-1.5 text-xs font-bold uppercase tracking-wider text-orange-600 dark:text-orange-400 mb-1">
                <i class="fa-solid fa-cubes"></i> Direktori Etalase
            </div>
            <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900 dark:text-white tracking-tight">Katalog Mitra PKM Terverifikasi</h2>
            <p class="text-xs sm:text-sm text-slate-500 dark:text-slate-400 mt-1">Buka dan jelajahi website promosi mandiri setiap mitra UMKM & Koperasi di bawah ini.</p>
        </div>

        <!-- Filter Category Tabs -->
        <div class="flex items-center gap-2 text-xs font-semibold overflow-x-auto pb-1">
            <a href="{{ route('home', ['q' => $search]) }}#katalog"
               class="px-4 py-2 rounded-xl transition whitespace-nowrap {{ empty($filterJenis) ? 'bg-slate-900 text-white dark:bg-orange-600 dark:text-white shadow-xs' : 'bg-slate-100 text-slate-600 hover:bg-slate-200 dark:bg-slate-800 dark:text-slate-300 dark:hover:bg-slate-700' }}">
                Semua Mitra
            </a>
            <a href="{{ route('home', ['jenis' => 'umkm', 'q' => $search]) }}#katalog"
               class="px-4 py-2 rounded-xl transition whitespace-nowrap {{ $filterJenis === 'umkm' ? 'bg-blue-600 text-white shadow-xs' : 'bg-blue-50 text-blue-700 hover:bg-blue-100 dark:bg-blue-950/40 dark:text-blue-300 dark:hover:bg-blue-900/50' }}">
                <i class="fa-solid fa-shop mr-1"></i> UMKM
            </a>
            <a href="{{ route('home', ['jenis' => 'koperasi', 'q' => $search]) }}#katalog"
               class="px-4 py-2 rounded-xl transition whitespace-nowrap {{ $filterJenis === 'koperasi' ? 'bg-purple-600 text-white shadow-xs' : 'bg-purple-50 text-purple-700 hover:bg-purple-100 dark:bg-purple-950/40 dark:text-purple-300 dark:hover:bg-purple-900/50' }}">
                <i class="fa-solid fa-users-rectangle mr-1"></i> Koperasi
            </a>
        </div>
    </div>

    <!-- Empty State -->
    @if ($mitras->count() === 0)
        <div class="bg-white dark:bg-slate-900 rounded-3xl border border-slate-200 dark:border-slate-800 p-12 text-center shadow-xs max-w-lg mx-auto">
            <div class="w-20 h-20 rounded-3xl bg-slate-100 dark:bg-slate-800 text-slate-400 dark:text-slate-500 flex items-center justify-center text-4xl mx-auto mb-4">
                <i class="fa-solid fa-store-slash"></i>
            </div>
            <h3 class="text-lg font-bold text-slate-800 dark:text-slate-100 mb-2">Belum Ada Mitra Ditemukan</h3>
            <p class="text-xs sm:text-sm text-slate-500 dark:text-slate-400 mb-6 leading-relaxed">
                @if ($search || $filterJenis)
                    Tidak ada mitra yang cocok dengan pencarian Anda. Silakan coba kata kunci lain.
                @else
                    Belum ada mitra UMKM atau Koperasi yang terverifikasi dan aktif di sistem saat ini.
                @endif
            </p>
            @if ($search || $filterJenis)
                <a href="{{ route('home') }}#katalog" class="inline-flex items-center gap-2 px-5 py-2.5 bg-orange-600 hover:bg-orange-700 text-white font-bold text-xs sm:text-sm rounded-xl shadow-md transition">
                    <i class="fa-solid fa-rotate-left"></i> Lihat Semua Mitra
                </a>
            @else
                <a href="{{ route('register') }}" class="inline-flex items-center gap-2 px-5 py-2.5 bg-orange-600 hover:bg-orange-700 text-white font-bold text-xs sm:text-sm rounded-xl shadow-md transition">
                    <i class="fa-solid fa-plus-circle"></i> Daftar sebagai Mitra
                </a>
            @endif
        </div>
    @else
        <!-- Grid Jejeran Kartu Mitra (Clean, Balanced Multi-device) -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 sm:gap-8">
            @foreach ($mitras as $mitra)
                <a href="{{ route('mitra.show', ['slug' => $mitra->slug]) }}"
                   class="group bg-white dark:bg-slate-900 rounded-3xl border border-slate-200 dark:border-slate-800 shadow-sm hover:shadow-xl hover:border-orange-300 dark:hover:border-orange-500 transition-all duration-300 flex flex-col justify-between overflow-hidden relative">

                    <div>
                        <!-- Cover Image with Gradient Mask -->
                        <div class="h-44 sm:h-48 bg-gradient-to-tr from-slate-900 via-orange-950 to-slate-900 relative overflow-hidden">
                            @if ($mitra->websiteContent?->hero_image)
                                <img src="{{ Str::startsWith($mitra->websiteContent->hero_image, 'http') ? $mitra->websiteContent->hero_image : asset('storage/' . $mitra->websiteContent->hero_image) }}"
                                     alt="{{ $mitra->nama_usaha }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500 opacity-80 group-hover:opacity-100">
                            @else
                                <div class="w-full h-full flex items-center justify-center text-white/20">
                                    <i class="fa-solid fa-store text-5xl"></i>
                                </div>
                            @endif

                            <div class="absolute inset-0 bg-gradient-to-t from-slate-950/80 via-transparent to-transparent"></div>

                            <!-- Badges on top -->
                            <div class="absolute top-3 left-3">
                                <span class="px-2.5 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider shadow-sm {{ $mitra->jenis === 'umkm' ? 'bg-blue-600 text-white' : 'bg-purple-600 text-white' }}">
                                    {{ $mitra->jenis }}
                                </span>
                            </div>

                            <div class="absolute top-3 right-3">
                                <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-orange-500 text-slate-950 shadow-sm">
                                    <i class="fa-solid fa-circle-check text-[10px]"></i> Binaan PKM
                                </span>
                            </div>
                        </div>

                        <!-- Card Body with Overlapping Avatar -->
                        <div class="p-6 relative">
                            <div class="-mt-12 mb-4 flex items-center justify-between">
                                @if ($mitra->logo)
                                    <img src="{{ Str::startsWith($mitra->logo, ['http', 'data:']) ? $mitra->logo : asset('storage/' . $mitra->logo) }}" alt="{{ $mitra->nama_usaha }}"
                                         class="w-16 h-16 rounded-2xl object-cover bg-white dark:bg-slate-800 p-1 ring-4 ring-white dark:ring-slate-900 shadow-md">
                                @else
                                    <div class="w-16 h-16 rounded-2xl bg-gradient-to-tr from-orange-600 to-amber-500 text-white font-black text-2xl flex items-center justify-center ring-4 ring-white dark:ring-slate-900 shadow-md">
                                        {{ substr($mitra->nama_usaha, 0, 2) }}
                                    </div>
                                @endif

                                <span class="text-xs text-slate-400 dark:text-slate-400 font-semibold flex items-center gap-1 bg-slate-50 dark:bg-slate-800 px-2.5 py-1 rounded-lg border border-slate-100 dark:border-slate-700">
                                    <i class="fa-solid fa-boxes-stacked text-orange-600 dark:text-orange-400"></i>
                                    {{ $mitra->products->count() }} Produk
                                </span>
                            </div>

                            <!-- Title -->
                            <h3 class="text-base sm:text-lg font-bold text-slate-900 dark:text-white group-hover:text-orange-600 dark:group-hover:text-orange-400 transition tracking-tight mb-1.5 line-clamp-1">
                                {{ $mitra->nama_usaha }}
                            </h3>

                            <!-- Tagline / Description -->
                            <p class="text-xs text-slate-500 dark:text-slate-400 leading-relaxed line-clamp-2 mb-4 min-h-[2rem]">
                                {{ $mitra->websiteContent?->tagline ?? $mitra->websiteContent?->deskripsi ?? 'Buka website promosi resmi untuk melihat katalog produk dan info kontak.' }}
                            </p>

                            <!-- Address Row -->
                            <div class="flex items-center gap-1.5 text-xs text-slate-400 dark:text-slate-500 truncate">
                                <i class="fa-solid fa-location-dot text-orange-600 dark:text-orange-400 shrink-0"></i>
                                <span class="truncate">{{ $mitra->alamat }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Card Action Footer -->
                    <div class="p-4 bg-slate-50 dark:bg-slate-800/60 border-t border-slate-100 dark:border-slate-800 flex items-center justify-between text-xs">
                        <span class="font-bold text-slate-700 dark:text-slate-300 group-hover:text-orange-600 dark:group-hover:text-orange-400 transition flex items-center gap-1">
                            Buka Website <i class="fa-solid fa-arrow-right text-[10px] group-hover:translate-x-1 transition-transform"></i>
                        </span>
                        <span class="text-orange-700 dark:text-orange-300 font-bold bg-orange-100 dark:bg-orange-950/60 px-2.5 py-1 rounded-md text-[11px] inline-flex items-center gap-1 border border-orange-200 dark:border-orange-800/50">
                            <i class="fa-brands fa-whatsapp text-orange-600 dark:text-orange-400"></i> Direct WA
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

<!-- CALL TO ACTION: AJAKAN BERGABUNG -->
<section id="tentang-pkm" class="bg-slate-100 dark:bg-slate-950 border-t border-slate-200 dark:border-slate-800 py-16 sm:py-20 transition-colors">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-gradient-to-r from-orange-950 via-amber-950 to-slate-900 rounded-3xl p-8 sm:p-14 text-white shadow-xl flex flex-col lg:flex-row items-center justify-between gap-8 border border-orange-900/40">
            <div class="max-w-2xl text-center lg:text-left">
                <span class="px-3 py-1 rounded-full bg-orange-500/20 text-orange-300 text-xs font-bold uppercase tracking-wider border border-orange-400/30 mb-3 inline-block">
                    Inisiatif Pemberdayaan PKM
                </span>
                <h3 class="text-2xl sm:text-3xl font-extrabold mb-3 leading-snug">
                    Pemilik UMKM atau Pengurus Koperasi Binaan PKM?
                </h3>
                <p class="text-xs sm:text-sm text-slate-300 leading-relaxed">
                    Dapatkan website promosi resmi mandiri dengan 4 section lengkap (Beranda, Profil, Katalog Produk, Kontak & Peta) serta terhubung langsung ke WhatsApp Anda secara gratis.
                </p>
            </div>
            <div class="shrink-0 flex flex-col sm:flex-row gap-3 w-full lg:w-auto">
                <a href="{{ route('register') }}" class="px-6 py-3.5 bg-gradient-to-r from-orange-500 to-amber-400 hover:from-orange-400 hover:to-amber-300 text-slate-950 font-bold text-xs sm:text-sm rounded-xl text-center shadow-lg transition shadow-orange-500/30">
                    <i class="fa-solid fa-plus-circle mr-1.5"></i> Daftar sebagai Mitra
                </a>
                <a href="{{ route('login') }}" class="px-6 py-3.5 bg-white/10 hover:bg-white/20 text-white font-bold text-xs sm:text-sm rounded-xl text-center border border-white/20 transition">
                    Masuk ke Akun
                </a>
            </div>
        </div>
    </div>
</section>

@endsection
