<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    @php
        $content = $mitra->websiteContent;
        $contact = $mitra->contact;
        $pageTitle = ($content?->judul ?? $mitra->nama_usaha) . ' - Website Promosi Resmi Mitra PKM';
        $pageDesc = $content?->tagline ?? $content?->deskripsi ?? 'Website promosi resmi ' . $mitra->nama_usaha . ' mitra binaan Program Kreativitas Mahasiswa (PKM).';
        $pageImage = $content?->hero_image
            ? (Str::startsWith($content->hero_image, 'http') ? $content->hero_image : asset('storage/' . $content->hero_image))
            : ($mitra->logo ? asset('storage/' . $mitra->logo) : asset('img/default-hero.jpg'));
        $waNumber = preg_replace('/[^0-9]/', '', $contact?->whatsapp ?? $mitra->kontak);
    @endphp

    <title>{{ $pageTitle }}</title>
    <meta name="description" content="{{ Str::limit($pageDesc, 160) }}">

    <!-- Open Graph / WhatsApp / Facebook Meta Tags -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:title" content="{{ $pageTitle }}">
    <meta property="og:description" content="{{ Str::limit($pageDesc, 200) }}">
    <meta property="og:image" content="{{ $pageImage }}">
    <meta property="og:site_name" content="Mitra PKM">

    <!-- Fonts & Tailwind -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['"Plus Jakarta Sans"', 'sans-serif'],
                    },
                    colors: {
                        brand: {
                            50: '#ecfdf5',
                            100: '#d1fae5',
                            500: '#10b981',
                            600: '#059669',
                            700: '#047857',
                            800: '#065f46',
                            900: '#064e3b',
                        }
                    }
                }
            }
        }
    </script>
    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <style>
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="font-sans antialiased bg-slate-50 text-slate-800 selection:bg-emerald-600 selection:text-white">

    <!-- PREVIEW NOTICE BAR (IF ACCESSED FROM PREVIEW) -->
    @if (!empty($isPreview) && $isPreview)
        <div class="bg-amber-500 text-slate-950 px-4 py-2 text-xs font-bold flex items-center justify-between sticky top-0 z-50 shadow-md">
            <span class="flex items-center gap-2">
                <i class="fa-solid fa-eye animate-bounce"></i>
                <span>MODE PRATINJAU WEBSITE: Ini adalah pratinjau tampilan sebelum atau sesudah publikasi.</span>
            </span>
            <div class="flex items-center gap-3">
                <a href="{{ route('owner.dashboard') }}" class="px-3 py-1 bg-slate-900 text-white rounded-lg hover:bg-slate-800 transition text-[11px]">
                    <i class="fa-solid fa-arrow-left mr-1"></i> Kembali ke Dashboard
                </a>
            </div>
        </div>
    @endif

    <!-- STICKY HEADER NAVIGATION WITH SMOOTH SCROLL -->
    <header class="bg-white/95 backdrop-blur-md border-b border-slate-200 sticky {{ !empty($isPreview) && $isPreview ? 'top-8' : 'top-0' }} z-40 shadow-xs transition-all" x-data="{ mobileMenu: false }">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16 sm:h-20">

                <!-- Logo & Usaha Name -->
                <a href="#beranda" class="flex items-center gap-3 group">
                    @if ($mitra->logo)
                        <img src="{{ asset('storage/' . $mitra->logo) }}" alt="Logo" class="w-10 h-10 sm:w-11 sm:h-11 rounded-xl object-cover border border-slate-200 shadow-xs">
                    @else
                        <div class="w-10 h-10 sm:w-11 sm:h-11 rounded-xl bg-gradient-to-tr from-emerald-600 to-teal-500 text-white flex items-center justify-center font-black text-lg shadow-sm">
                            {{ substr($mitra->nama_usaha, 0, 2) }}
                        </div>
                    @endif
                    <div>
                        <span class="text-base sm:text-lg font-extrabold text-slate-900 tracking-tight block leading-tight group-hover:text-emerald-600 transition">
                            {{ $mitra->nama_usaha }}
                        </span>
                        <div class="flex items-center gap-1.5 -mt-0.5">
                            <span class="text-[10px] uppercase font-bold text-emerald-700 bg-emerald-100 px-1.5 py-0.2 rounded">
                                {{ $mitra->jenis }}
                            </span>
                            <span class="text-[10px] text-slate-400 font-medium">Binaan PKM</span>
                        </div>
                    </div>
                </a>

                <!-- 4 Sections Nav Links (Desktop) -->
                <nav class="hidden md:flex items-center gap-8 text-sm font-semibold text-slate-600">
                    <a href="#beranda" class="hover:text-emerald-600 transition">Beranda</a>
                    <a href="#tentang" class="hover:text-emerald-600 transition">Tentang Kami</a>
                    <a href="#produk" class="hover:text-emerald-600 transition">Katalog Produk</a>
                    <a href="#kontak" class="hover:text-emerald-600 transition">Kontak & Lokasi</a>
                </nav>

                <!-- Header Actions -->
                <div class="flex items-center gap-3">
                    @if ($waNumber)
                        <a href="https://wa.me/{{ $waNumber }}?text={{ urlencode('Halo ' . $mitra->nama_usaha . ', saya melihat website promosi Anda di Mitra PKM dan ingin bertanya mengenai produk.') }}"
                           target="_blank"
                           class="hidden sm:inline-flex items-center gap-2 px-4 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs sm:text-sm rounded-xl shadow-md transition shadow-emerald-600/20">
                            <i class="fa-brands fa-whatsapp text-base"></i>
                            <span>Hubungi Kami</span>
                        </a>
                    @endif

                    <a href="{{ route('home') }}" class="text-xs text-slate-500 hover:text-emerald-600 font-medium hidden lg:inline-flex items-center gap-1 border-l pl-3 ml-2 border-slate-200">
                        <i class="fa-solid fa-arrow-left text-[10px]"></i> Portal Mitra PKM
                    </a>

                    <!-- Mobile Menu Hamburger -->
                    <button @click="mobileMenu = !mobileMenu" class="md:hidden p-2 rounded-lg text-slate-600 hover:bg-slate-100">
                        <i class="fa-solid fa-bars text-xl" x-show="!mobileMenu"></i>
                        <i class="fa-solid fa-xmark text-xl" x-show="mobileMenu" x-cloak></i>
                    </button>
                </div>

            </div>
        </div>

        <!-- Mobile Menu Dropdown -->
        <div x-show="mobileMenu" x-cloak class="md:hidden border-t border-slate-200 bg-white px-4 py-3 space-y-2 text-sm font-semibold">
            <a href="#beranda" @click="mobileMenu = false" class="block py-2 text-slate-700 hover:text-emerald-600">Beranda</a>
            <a href="#tentang" @click="mobileMenu = false" class="block py-2 text-slate-700 hover:text-emerald-600">Tentang Kami</a>
            <a href="#produk" @click="mobileMenu = false" class="block py-2 text-slate-700 hover:text-emerald-600">Katalog Produk</a>
            <a href="#kontak" @click="mobileMenu = false" class="block py-2 text-slate-700 hover:text-emerald-600">Kontak & Lokasi</a>
            @if ($waNumber)
                <div class="pt-2 border-t border-slate-100">
                    <a href="https://wa.me/{{ $waNumber }}" target="_blank" class="w-full inline-flex items-center justify-center gap-2 py-2.5 bg-emerald-600 text-white rounded-xl font-bold text-xs">
                        <i class="fa-brands fa-whatsapp"></i> Hubungi via WhatsApp
                    </a>
                </div>
            @endif
        </div>
    </header>

    <!-- SECTION 1: BERANDA / HERO BANNER -->
    <section id="beranda" class="relative bg-slate-900 text-white overflow-hidden">
        <!-- Background Hero Image with Dark Gradient Overlay -->
        <div class="absolute inset-0 z-0">
            @if ($content?->hero_image)
                <img src="{{ Str::startsWith($content->hero_image, 'http') ? $content->hero_image : asset('storage/' . $content->hero_image) }}"
                     alt="{{ $content->judul ?? $mitra->nama_usaha }}"
                     class="w-full h-full object-cover opacity-35 scale-105 transform">
            @else
                <div class="w-full h-full bg-gradient-to-tr from-emerald-950 via-slate-900 to-slate-950 opacity-90"></div>
            @endif
            <div class="absolute inset-0 bg-gradient-to-t from-slate-950 via-slate-950/60 to-transparent"></div>
        </div>

        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-24 sm:py-36 relative z-10 text-center">
            <!-- Badge Kemitraan -->
            <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-emerald-500/20 border border-emerald-400/40 text-emerald-300 text-xs sm:text-sm font-semibold mb-6 backdrop-blur-xs">
                <i class="fa-solid fa-award text-emerald-400"></i>
                <span>Mitra Resmi Binaan Program Kreativitas Mahasiswa (PKM)</span>
            </div>

            <!-- Big Title -->
            <h1 class="text-3xl sm:text-5xl lg:text-6xl font-black tracking-tight text-white mb-6 leading-tight">
                {{ $content?->judul ?? $mitra->nama_usaha }}
            </h1>

            <!-- Tagline -->
            <p class="text-base sm:text-xl text-slate-200 max-w-2xl mx-auto leading-relaxed mb-10 font-normal">
                {{ $content?->tagline ?? 'Menyajikan produk dan layanan terbaik dengan integritas mutu dan pemberdayaan potensi lokal.' }}
            </p>

            <!-- CTA Buttons -->
            <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
                @if ($waNumber)
                    <a href="https://wa.me/{{ $waNumber }}?text={{ urlencode('Halo ' . $mitra->nama_usaha . ', saya tertarik dengan produk Anda di website promosi.') }}"
                       target="_blank"
                       class="w-full sm:w-auto inline-flex items-center justify-center gap-2.5 px-8 py-4 bg-emerald-600 hover:bg-emerald-500 text-white font-extrabold text-sm sm:text-base rounded-2xl shadow-xl shadow-emerald-600/30 transition transform hover:-translate-y-0.5">
                        <i class="fa-brands fa-whatsapp text-xl"></i>
                        <span>Hubungi via WhatsApp</span>
                    </a>
                @endif

                <a href="#produk"
                   class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-8 py-4 bg-white/10 hover:bg-white/20 backdrop-blur-sm text-white font-bold text-sm sm:text-base rounded-2xl border border-white/20 transition">
                    <i class="fa-solid fa-boxes-stacked text-emerald-400"></i>
                    <span>Jelajahi Produk Kami</span>
                </a>
            </div>
        </div>
    </section>

    <!-- SECTION 2: TENTANG KAMI / DESKRIPSI, SEJARAH, VISI & MISI -->
    <section id="tentang" class="py-20 sm:py-28 bg-white border-b border-slate-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-3xl mx-auto mb-16">
                <span class="text-xs font-bold uppercase tracking-wider text-emerald-600 mb-2 block">Profil & Integritas Usaha</span>
                <h2 class="text-3xl sm:text-4xl font-extrabold text-slate-900 tracking-tight">Tentang {{ $mitra->nama_usaha }}</h2>
                <div class="w-16 h-1 bg-emerald-600 mx-auto mt-4 rounded-full"></div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-start">
                <!-- Deskripsi & Sejarah (7 Cols) -->
                <div class="lg:col-span-7 space-y-8">
                    <!-- Deskripsi Usaha -->
                    <div class="prose prose-slate max-w-none">
                        <h3 class="text-xl font-bold text-slate-900 mb-3 flex items-center gap-2">
                            <i class="fa-solid fa-circle-info text-emerald-600 text-lg"></i>
                            <span>Profil Usaha</span>
                        </h3>
                        <p class="text-slate-600 text-sm sm:text-base leading-relaxed whitespace-pre-line">
                            {{ $content?->deskripsi ?? 'Kami adalah unit usaha yang berdedikasi tinggi dalam menghadirkan produk berkualitas serta berkontribusi bagi pertumbuhan ekonomi masyarakat sekitar.' }}
                        </p>
                    </div>

                    <!-- Sejarah Usaha / Latar Belakang PKM -->
                    @if ($content?->sejarah)
                        <div class="bg-slate-50 border-l-4 border-emerald-600 p-6 rounded-r-2xl">
                            <h3 class="text-base font-bold text-slate-900 mb-2 flex items-center gap-2">
                                <i class="fa-solid fa-landmark text-emerald-600"></i>
                                <span>Sejarah Singkat & Kemitraan PKM</span>
                            </h3>
                            <p class="text-slate-600 text-xs sm:text-sm leading-relaxed whitespace-pre-line">
                                {{ $content->sejarah }}
                            </p>
                        </div>
                    @endif
                </div>

                <!-- Visi & Misi Card (5 Cols) -->
                <div class="lg:col-span-5">
                    <div class="bg-gradient-to-br from-emerald-900 via-teal-900 to-slate-900 text-white rounded-3xl p-8 sm:p-10 shadow-xl relative overflow-hidden">
                        <div class="absolute -right-8 -top-8 w-40 h-40 bg-emerald-500/20 rounded-full blur-2xl"></div>

                        <h3 class="text-xl font-extrabold mb-6 flex items-center gap-2 text-white border-b border-white/10 pb-4">
                            <i class="fa-solid fa-bullseye text-emerald-400"></i>
                            <span>Visi & Misi Kami</span>
                        </h3>

                        <div class="space-y-6 text-xs sm:text-sm text-slate-200 leading-relaxed whitespace-pre-line">
                            @if ($content?->visi_misi)
                                {{ $content->visi_misi }}
                            @else
                                <p><strong>Visi:</strong> Menjadi mitra usaha mandiri yang unggul dan terpercaya di tingkat nasional.</p>
                                <p><strong>Misi:</strong> Menjaga mutu produk, melayani dengan ramah, dan memberdayakan potensi lokal.</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- SECTION 3: PRODUK / GALERI -->
    <section id="produk" class="py-20 sm:py-28 bg-slate-50 border-b border-slate-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row md:items-end justify-between gap-4 mb-14 pb-4 border-b border-slate-200">
                <div>
                    <span class="text-xs font-bold uppercase tracking-wider text-emerald-600 mb-2 block">Etalase & Katalog</span>
                    <h2 class="text-3xl sm:text-4xl font-extrabold text-slate-900 tracking-tight">Katalog Produk & Galeri Karya</h2>
                    <p class="text-xs sm:text-sm text-slate-500 mt-1">Pilih produk yang Anda sukai dan pesan langsung kepada kami via WhatsApp.</p>
                </div>
                <div class="text-xs font-semibold text-slate-500">
                    Menampilkan <strong>{{ $mitra->products->count() }}</strong> penawaran unggulan
                </div>
            </div>

            @if ($mitra->products->count() === 0)
                <div class="text-center py-16 bg-white rounded-3xl border border-slate-200 shadow-xs max-w-md mx-auto">
                    <i class="fa-solid fa-box-open text-4xl text-slate-300 mb-3 block"></i>
                    <h3 class="font-bold text-slate-700 text-sm">Etalase Sedang Dalam Penyiapan</h3>
                    <p class="text-xs text-slate-400 mt-1">Pemilik usaha belum menambahkan item produk ke katalog.</p>
                </div>
            @else
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach ($mitra->products as $product)
                        <div class="bg-white rounded-3xl border border-slate-200 shadow-xs hover:shadow-xl hover:border-emerald-300 transition duration-300 overflow-hidden flex flex-col justify-between group">
                            <div>
                                <!-- Foto Produk -->
                                <div class="h-60 bg-slate-100 overflow-hidden relative">
                                    @if ($product->foto)
                                        <img src="{{ Str::startsWith($product->foto, 'http') ? $product->foto : asset('storage/' . $product->foto) }}"
                                             alt="{{ $product->nama }}"
                                             class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center text-slate-300 bg-slate-100">
                                            <i class="fa-regular fa-image text-5xl"></i>
                                        </div>
                                    @endif

                                    <!-- Price Tag Badge -->
                                    <div class="absolute bottom-3 left-3 bg-slate-950/85 backdrop-blur-xs text-white px-3.5 py-1.5 rounded-xl font-extrabold text-sm shadow-md">
                                        @if ($product->harga)
                                            Rp {{ number_format($product->harga, 0, ',', '.') }}
                                        @else
                                            <span class="text-xs font-semibold text-emerald-400">Hubungi Kami</span>
                                        @endif
                                    </div>
                                </div>

                                <!-- Body Info -->
                                <div class="p-6">
                                    <h3 class="text-lg font-bold text-slate-900 group-hover:text-emerald-600 transition mb-2">
                                        {{ $product->nama }}
                                    </h3>
                                    <p class="text-xs sm:text-sm text-slate-500 leading-relaxed line-clamp-3">
                                        {{ $product->deskripsi ?? 'Produk berkualitas dari ' . $mitra->nama_usaha . '.' }}
                                    </p>
                                </div>
                            </div>

                            <!-- WhatsApp Direct Conversion CTA Button -->
                            <div class="p-6 pt-0">
                                @if ($waNumber)
                                    @php
                                        $msg = 'Halo ' . $mitra->nama_usaha . ', saya tertarik untuk memesan/bertanya mengenai produk: "' . $product->nama . '" yang tertera di website promosi resmi Anda.';
                                    @endphp
                                    <a href="https://wa.me/{{ $waNumber }}?text={{ urlencode($msg) }}"
                                       target="_blank"
                                       class="w-full inline-flex items-center justify-center gap-2 py-3 px-4 bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs sm:text-sm rounded-xl shadow-md transition shadow-emerald-600/20 group-hover:shadow-emerald-600/30">
                                        <i class="fa-brands fa-whatsapp text-base"></i>
                                        <span>Pesan via WhatsApp</span>
                                    </a>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </section>

    <!-- SECTION 4: KONTAK, MEDIA SOSIAL, JAM BUKA & PETA LOKASI -->
    <section id="kontak" class="py-20 sm:py-28 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-3xl mx-auto mb-16">
                <span class="text-xs font-bold uppercase tracking-wider text-emerald-600 mb-2 block">Informasi & Lokasi</span>
                <h2 class="text-3xl sm:text-4xl font-extrabold text-slate-900 tracking-tight">Hubungi & Kunjungi Kami</h2>
                <div class="w-16 h-1 bg-emerald-600 mx-auto mt-4 rounded-full"></div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-10">

                <!-- Detail Kontak & Medsos (5 Cols) -->
                <div class="lg:col-span-5 space-y-6">

                    <!-- Info Box -->
                    <div class="bg-slate-50 border border-slate-200 rounded-3xl p-6 sm:p-8 space-y-5 text-xs sm:text-sm">
                        <!-- Alamat -->
                        <div class="flex items-start gap-3.5">
                            <div class="w-10 h-10 rounded-xl bg-emerald-100 text-emerald-700 flex items-center justify-center shrink-0 text-base">
                                <i class="fa-solid fa-location-dot"></i>
                            </div>
                            <div>
                                <span class="text-slate-400 font-bold uppercase text-[10px] block">Alamat Usaha:</span>
                                <span class="font-semibold text-slate-800 leading-relaxed block mt-0.5">
                                    {{ $contact?->alamat ?? $mitra->alamat }}
                                </span>
                            </div>
                        </div>

                        <!-- WhatsApp Direct -->
                        <div class="flex items-start gap-3.5">
                            <div class="w-10 h-10 rounded-xl bg-emerald-600 text-white flex items-center justify-center shrink-0 text-lg shadow-sm">
                                <i class="fa-brands fa-whatsapp"></i>
                            </div>
                            <div>
                                <span class="text-slate-400 font-bold uppercase text-[10px] block">WhatsApp Pemesanan:</span>
                                <a href="https://wa.me/{{ $waNumber }}" target="_blank" class="font-bold text-emerald-700 hover:underline block mt-0.5 text-base">
                                    +{{ $waNumber }}
                                </a>
                            </div>
                        </div>

                        <!-- Jam Buka -->
                        @if ($contact?->jam_operasional)
                            <div class="flex items-start gap-3.5">
                                <div class="w-10 h-10 rounded-xl bg-amber-100 text-amber-700 flex items-center justify-center shrink-0 text-base">
                                    <i class="fa-solid fa-clock"></i>
                                </div>
                                <div>
                                    <span class="text-slate-400 font-bold uppercase text-[10px] block">Jam Operasional:</span>
                                    <span class="font-semibold text-slate-800 block mt-0.5">
                                        {{ $contact->jam_operasional }}
                                    </span>
                                </div>
                            </div>
                        @endif

                        <!-- Email & Telepon -->
                        @if ($contact?->email || $contact?->telepon)
                            <div class="pt-3 border-t border-slate-200 grid grid-cols-1 sm:grid-cols-2 gap-3 text-xs">
                                @if ($contact->email)
                                    <div>
                                        <span class="text-slate-400 block text-[10px] font-bold uppercase">Email:</span>
                                        <span class="font-semibold text-slate-700">{{ $contact->email }}</span>
                                    </div>
                                @endif
                                @if ($contact->telepon)
                                    <div>
                                        <span class="text-slate-400 block text-[10px] font-bold uppercase">Telepon:</span>
                                        <span class="font-semibold text-slate-700">{{ $contact->telepon }}</span>
                                    </div>
                                @endif
                            </div>
                        @endif
                    </div>

                    <!-- Media Sosial Links -->
                    @if ($contact?->instagram || $contact?->facebook || $contact?->tiktok)
                        <div class="bg-white border border-slate-200 rounded-3xl p-6">
                            <span class="text-xs font-bold uppercase tracking-wider text-slate-400 block mb-3">Ikuti Media Sosial Kami:</span>
                            <div class="flex items-center gap-3">
                                @if ($contact->instagram)
                                    <a href="https://instagram.com/{{ ltrim($contact->instagram, '@') }}" target="_blank"
                                       class="w-11 h-11 rounded-xl bg-pink-50 text-pink-600 hover:bg-pink-600 hover:text-white flex items-center justify-center text-lg transition shadow-xs">
                                        <i class="fa-brands fa-instagram"></i>
                                    </a>
                                @endif
                                @if ($contact->facebook)
                                    <a href="https://facebook.com/{{ $contact->facebook }}" target="_blank"
                                       class="w-11 h-11 rounded-xl bg-blue-50 text-blue-600 hover:bg-blue-600 hover:text-white flex items-center justify-center text-lg transition shadow-xs">
                                        <i class="fa-brands fa-facebook"></i>
                                    </a>
                                @endif
                                @if ($contact->tiktok)
                                    <a href="https://tiktok.com/@{{ ltrim($contact->tiktok, '@') }}" target="_blank"
                                       class="w-11 h-11 rounded-xl bg-slate-100 text-slate-900 hover:bg-slate-900 hover:text-white flex items-center justify-center text-lg transition shadow-xs">
                                        <i class="fa-brands fa-tiktok"></i>
                                    </a>
                                @endif
                            </div>
                        </div>
                    @endif

                </div>

                <!-- Google Maps Embed (7 Cols) -->
                <div class="lg:col-span-7">
                    <div class="bg-white border border-slate-200 rounded-3xl overflow-hidden shadow-xs h-full min-h-[380px] flex flex-col">
                        <div class="p-4 bg-slate-50 border-b border-slate-200 text-xs font-semibold text-slate-600 flex items-center gap-2">
                            <i class="fa-solid fa-map-location-dot text-emerald-600"></i> Peta Lokasi Gerai / Usaha
                        </div>
                        <div class="flex-grow bg-slate-100 relative">
                            @if (!empty($contact?->maps_embed))
                                <iframe src="{{ $contact->maps_embed }}"
                                        width="100%" height="100%" style="border:0; min-height: 380px;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade">
                                </iframe>
                            @else
                                <div class="w-full h-full min-h-[380px] flex flex-col items-center justify-center text-slate-400 p-8 text-center">
                                    <i class="fa-solid fa-map-pin text-4xl mb-3 text-slate-300"></i>
                                    <span class="font-bold text-slate-600 text-sm">Peta Google Maps Belum Disematkan</span>
                                    <p class="text-xs text-slate-400 max-w-sm mt-1">
                                        {{ $contact?->alamat ?? $mitra->alamat }}
                                    </p>
                                    @if ($waNumber)
                                        <a href="https://wa.me/{{ $waNumber }}?text={{ urlencode('Halo, boleh minta petunjuk arah lokasi usaha ' . $mitra->nama_usaha . '?') }}" target="_blank"
                                           class="mt-4 px-4 py-2 bg-emerald-600 text-white rounded-xl text-xs font-bold inline-flex items-center gap-1.5 shadow-sm">
                                            <i class="fa-solid fa-location-arrow"></i> Minta Petunjuk Arah via WA
                                        </a>
                                    @endif
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- FLOATING WHATSAPP BUTTON (CONVERSION CTA) -->
    @if ($waNumber)
        <aside class="fixed bottom-6 right-6 z-50 group" aria-label="Kontak WhatsApp">
            <a href="https://wa.me/{{ $waNumber }}?text={{ urlencode('Halo ' . $mitra->nama_usaha . ', saya melihat website promosi Anda dan ingin memesan produk.') }}"
               target="_blank"
               class="flex items-center gap-3 px-5 py-3.5 bg-emerald-600 hover:bg-emerald-500 text-white rounded-full shadow-2xl shadow-emerald-600/50 transition duration-300 transform hover:scale-105 font-bold text-sm">
                <i class="fa-brands fa-whatsapp text-2xl animate-pulse"></i>
                <span class="hidden sm:inline">Pesan via WhatsApp</span>
            </a>
        </aside>
    @endif

    <!-- FOOTER RESMI "DIDUKUNG OLEH MITRA PKM" -->
    <footer class="bg-slate-900 text-slate-400 border-t border-slate-800 py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center text-xs">
            <div class="mb-4">
                <span class="text-white font-extrabold text-base">{{ $mitra->nama_usaha }}</span>
                <p class="text-slate-500 text-xs mt-0.5">{{ $contact?->alamat ?? $mitra->alamat }}</p>
            </div>

            <div class="pt-6 border-t border-slate-800 flex flex-col sm:flex-row items-center justify-between gap-4">
                <p>&copy; {{ date('Y') }} {{ $mitra->nama_usaha }}. Seluruh hak cipta dilindungi undang-undang.</p>
                <div class="flex items-center gap-2">
                    <span>Didukung oleh</span>
                    <a href="{{ route('home') }}" class="font-bold text-white hover:text-emerald-400 transition inline-flex items-center gap-1.5">
                        <span class="w-2 h-2 rounded-full bg-emerald-400"></span>
                        <span>Mitra PKM Framework</span>
                    </a>
                </div>
            </div>
        </div>
    </footer>

</body>
</html>
