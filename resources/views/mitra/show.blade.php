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
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,400;1,600&display=swap" rel="stylesheet">
    <script>
        if (localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    </script>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
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
        /* Smooth custom scrollbar */
        ::-webkit-scrollbar { width: 8px; height: 8px; }
        ::-webkit-scrollbar-track { background: #f1f5f9; }
        ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 4px; }
        ::-webkit-scrollbar-thumb:hover { background: #94a3b8; }
    </style>
</head>
<body class="font-sans antialiased bg-slate-50 text-slate-800 dark:bg-slate-950 dark:text-slate-100 selection:bg-emerald-600 selection:text-white transition-colors duration-200"
      x-data="{ 
          mobileNav: false,
          isDark: document.documentElement.classList.contains('dark'),
          toggleTheme() {
              this.isDark = !this.isDark;
              if (this.isDark) {
                  document.documentElement.classList.add('dark');
                  localStorage.theme = 'dark';
              } else {
                  document.documentElement.classList.remove('dark');
                  localStorage.theme = 'light';
              }
          }
      }">

    <!-- PREVIEW NOTICE BAR -->
    @if (!empty($isPreview) && $isPreview)
        <div class="bg-amber-500 text-slate-950 px-4 py-2 text-xs font-bold flex items-center justify-between sticky top-0 z-50 shadow-md">
            <span class="flex items-center gap-2">
                <i class="fa-solid fa-eye animate-bounce"></i>
                <span>MODE PRATINJAU WEBSITE: Tinjau tampilan sebelum atau sesudah publikasi.</span>
            </span>
            <a href="{{ route('owner.dashboard') }}" class="px-3 py-1 bg-slate-900 text-white rounded-lg hover:bg-slate-800 transition text-[11px]">
                <i class="fa-solid fa-arrow-left mr-1"></i> Kembali ke Dashboard Editor
            </a>
        </div>
    @endif

    <!-- STICKY HEADER NAVIGATION -->
    <header class="bg-white/95 dark:bg-slate-900/95 backdrop-blur-md border-b border-slate-200/80 dark:border-slate-800 sticky {{ !empty($isPreview) && $isPreview ? 'top-8' : 'top-0' }} z-40 shadow-xs transition-colors">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16 sm:h-20">

                <!-- Logo & Business Name -->
                <a href="#beranda" class="flex items-center gap-3 group shrink-0">
                    @if ($mitra->logo)
                        <img src="{{ asset('storage/' . $mitra->logo) }}" alt="Logo" class="w-10 h-10 sm:w-12 sm:h-12 rounded-2xl object-cover border border-slate-200 dark:border-slate-700 shadow-xs">
                    @else
                        <div class="w-10 h-10 sm:w-12 sm:h-12 rounded-2xl bg-gradient-to-tr from-emerald-600 to-teal-500 text-white flex items-center justify-center font-black text-lg shadow-sm">
                            {{ substr($mitra->nama_usaha, 0, 2) }}
                        </div>
                    @endif
                    <div>
                        <span class="text-base sm:text-lg font-extrabold text-slate-900 dark:text-white tracking-tight block leading-tight group-hover:text-emerald-600 dark:group-hover:text-emerald-400 transition">
                            {{ $mitra->nama_usaha }}
                        </span>
                        <div class="flex items-center gap-1.5 -mt-0.5">
                            <span class="text-[10px] uppercase font-bold text-emerald-700 dark:text-emerald-300 bg-emerald-100 dark:bg-emerald-950/60 px-1.5 py-0.2 rounded">
                                {{ $mitra->jenis }}
                            </span>
                            <span class="text-[10px] text-slate-400 font-medium">Binaan PKM</span>
                        </div>
                    </div>
                </a>

                <!-- 4 Sections Nav Links (Desktop) -->
                <nav class="hidden md:flex items-center gap-8 text-sm font-semibold text-slate-600 dark:text-slate-300">
                    <a href="#beranda" class="hover:text-emerald-600 dark:hover:text-emerald-400 transition">Beranda</a>
                    <a href="#tentang" class="hover:text-emerald-600 dark:hover:text-emerald-400 transition">Tentang Kami</a>
                    <a href="#produk" class="hover:text-emerald-600 dark:hover:text-emerald-400 transition">Katalog Produk</a>
                    <a href="#kontak" class="hover:text-emerald-600 dark:hover:text-emerald-400 transition">Kontak & Lokasi</a>
                </nav>

                <!-- Actions Right -->
                <div class="flex items-center gap-2 sm:gap-3">
                    <!-- Light / Dark Mode Toggle Button -->
                    <button @click="toggleTheme()"
                            type="button"
                            class="p-2 sm:p-2.5 rounded-xl text-slate-500 hover:text-slate-800 dark:text-slate-400 dark:hover:text-slate-100 hover:bg-slate-100 dark:hover:bg-slate-800 transition focus:outline-none"
                            :title="isDark ? 'Beralih ke Tema Terang' : 'Beralih ke Tema Gelap'">
                        <i class="fa-solid text-base" :class="isDark ? 'fa-sun text-amber-400' : 'fa-moon text-slate-600'"></i>
                    </button>

                    @if ($waNumber)
                        <a href="https://wa.me/{{ $waNumber }}?text={{ urlencode('Halo ' . $mitra->nama_usaha . ', saya melihat website promosi Anda dan ingin bertanya mengenai produk.') }}"
                           target="_blank"
                           class="hidden sm:inline-flex items-center gap-2 px-4 py-2.5 bg-gradient-to-r from-emerald-600 to-teal-600 hover:from-emerald-700 hover:to-teal-700 text-white font-bold text-xs sm:text-sm rounded-xl shadow-md transition shadow-emerald-600/20">
                            <i class="fa-brands fa-whatsapp text-base"></i>
                            <span>Hubungi Kami</span>
                        </a>
                    @endif

                    <a href="{{ route('home') }}" class="text-xs text-slate-500 dark:text-slate-400 hover:text-emerald-600 dark:hover:text-emerald-400 font-medium hidden lg:inline-flex items-center gap-1 border-l pl-3 ml-2 border-slate-200 dark:border-slate-800">
                        <i class="fa-solid fa-arrow-left text-[10px]"></i> Portal PKM
                    </a>

                    <!-- Mobile Hamburger -->
                    <button @click="mobileNav = !mobileNav" class="md:hidden p-2 rounded-xl text-slate-700 dark:text-slate-200 hover:bg-slate-100 dark:hover:bg-slate-800 transition focus:outline-none" aria-label="Menu Navigasi">
                        <i class="fa-solid fa-bars text-xl" x-show="!mobileNav"></i>
                        <i class="fa-solid fa-xmark text-xl" x-show="mobileNav" x-cloak></i>
                    </button>
                </div>

            </div>
        </div>

        <!-- Mobile Drawer -->
        <div x-show="mobileNav" x-cloak class="md:hidden border-t border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900 px-4 py-3 space-y-2 text-sm font-semibold shadow-lg">
            <a href="#beranda" @click="mobileNav = false" class="block py-2 text-slate-700 dark:text-slate-200 hover:text-emerald-600 dark:hover:text-emerald-400">Beranda</a>
            <a href="#tentang" @click="mobileNav = false" class="block py-2 text-slate-700 dark:text-slate-200 hover:text-emerald-600 dark:hover:text-emerald-400">Tentang Kami</a>
            <a href="#produk" @click="mobileNav = false" class="block py-2 text-slate-700 dark:text-slate-200 hover:text-emerald-600 dark:hover:text-emerald-400">Katalog Produk</a>
            <a href="#kontak" @click="mobileNav = false" class="block py-2 text-slate-700 dark:text-slate-200 hover:text-emerald-600 dark:hover:text-emerald-400">Kontak & Lokasi</a>
            @if ($waNumber)
                <div class="pt-2 border-t border-slate-100 dark:border-slate-800">
                    <a href="https://wa.me/{{ $waNumber }}" target="_blank" class="w-full inline-flex items-center justify-center gap-2 py-2.5 bg-emerald-600 text-white rounded-xl font-bold text-xs shadow-sm">
                        <i class="fa-brands fa-whatsapp text-base"></i> Hubungi via WhatsApp
                    </a>
                </div>
            @endif
        </div>
    </header>

    <!-- SECTION 1: BERANDA / HERO BANNER -->
    <section id="beranda" class="relative bg-slate-950 text-white overflow-hidden">
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
            <!-- Badge -->
            <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-emerald-500/20 border border-emerald-400/40 text-emerald-300 text-xs sm:text-sm font-semibold mb-6 backdrop-blur-xs shadow-xs">
                <i class="fa-solid fa-award text-emerald-400"></i>
                <span>Mitra Resmi Binaan Program Kreativitas Mahasiswa (PKM)</span>
            </div>

            <!-- Big Title -->
            <h1 class="text-3xl sm:text-5xl lg:text-6xl font-black tracking-tight text-white mb-6 leading-tight">
                {{ $content?->judul ?? $mitra->nama_usaha }}
            </h1>

            <!-- Tagline -->
            <p class="text-sm sm:text-lg lg:text-xl text-slate-200 max-w-2xl mx-auto leading-relaxed mb-10 font-normal">
                {{ $content?->tagline ?? 'Menyajikan produk dan layanan terbaik dengan integritas mutu dan pemberdayaan potensi lokal.' }}
            </p>

            <!-- CTA Buttons -->
            <div class="flex flex-col sm:flex-row items-center justify-center gap-3.5 max-w-md sm:max-w-none mx-auto">
                @if ($waNumber)
                    <a href="https://wa.me/{{ $waNumber }}?text={{ urlencode('Halo ' . $mitra->nama_usaha . ', saya tertarik dengan produk Anda di website promosi resmi.') }}"
                       target="_blank"
                       class="w-full sm:w-auto inline-flex items-center justify-center gap-2.5 px-8 py-4 bg-gradient-to-r from-emerald-600 to-teal-600 hover:from-emerald-500 hover:to-teal-500 text-white font-extrabold text-sm sm:text-base rounded-2xl shadow-xl shadow-emerald-600/30 transition transform hover:-translate-y-0.5">
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

    <!-- SECTION 2: TENTANG KAMI / PROFIL, SEJARAH, VISI & MISI -->
    <section id="tentang" class="py-20 sm:py-28 bg-white dark:bg-slate-950 border-b border-slate-200 dark:border-slate-800 transition-colors">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-3xl mx-auto mb-16">
                <span class="text-xs font-bold uppercase tracking-wider text-emerald-600 dark:text-emerald-400 mb-2 block">Profil & Integritas Usaha</span>
                <h2 class="text-2xl sm:text-3xl lg:text-4xl font-extrabold text-slate-900 dark:text-white tracking-tight">Tentang {{ $mitra->nama_usaha }}</h2>
                <div class="w-16 h-1 bg-gradient-to-r from-emerald-500 to-teal-400 mx-auto mt-4 rounded-full"></div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 lg:gap-12 items-start">
                <!-- Deskripsi & Sejarah (7 Cols) -->
                <div class="lg:col-span-7 space-y-8">
                    <!-- Deskripsi Usaha -->
                    <div>
                        <h3 class="text-lg sm:text-xl font-bold text-slate-900 dark:text-white mb-3 flex items-center gap-2">
                            <i class="fa-solid fa-circle-info text-emerald-600 dark:text-emerald-400 text-lg"></i>
                            <span>Profil Usaha</span>
                        </h3>
                        <p class="text-slate-600 dark:text-slate-300 text-sm sm:text-base leading-relaxed whitespace-pre-line">
                            {{ $content?->deskripsi ?? 'Kami adalah unit usaha yang berdedikasi tinggi dalam menghadirkan produk berkualitas serta berkontribusi bagi pertumbuhan ekonomi masyarakat sekitar.' }}
                        </p>
                    </div>

                    <!-- Sejarah Usaha / Latar Belakang PKM -->
                    @if ($content?->sejarah)
                        <div class="bg-slate-50 dark:bg-slate-900/60 border-l-4 border-emerald-600 dark:border-emerald-400 p-6 rounded-r-2xl border border-slate-200/60 dark:border-slate-800">
                            <h3 class="text-base font-bold text-slate-900 dark:text-white mb-2 flex items-center gap-2">
                                <i class="fa-solid fa-landmark text-emerald-600 dark:text-emerald-400"></i>
                                <span>Sejarah Singkat & Kemitraan PKM</span>
                            </h3>
                            <p class="text-slate-600 dark:text-slate-300 text-xs sm:text-sm leading-relaxed whitespace-pre-line">
                                {{ $content->sejarah }}
                            </p>
                        </div>
                    @endif
                </div>

                <!-- Visi & Misi Card (5 Cols) -->
                <div class="lg:col-span-5">
                    <div class="bg-gradient-to-br from-emerald-950 via-teal-950 to-slate-950 text-white rounded-3xl p-8 sm:p-10 shadow-xl relative overflow-hidden border border-emerald-900/40">
                        <div class="absolute -right-8 -top-8 w-40 h-40 bg-emerald-500/15 rounded-full blur-2xl"></div>

                        <h3 class="text-lg sm:text-xl font-extrabold mb-6 flex items-center gap-2 text-white border-b border-white/10 pb-4">
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
    <section id="produk" class="py-20 sm:py-28 bg-slate-50 dark:bg-slate-900 border-b border-slate-200 dark:border-slate-800 transition-colors">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row md:items-end justify-between gap-4 mb-14 pb-4 border-b border-slate-200 dark:border-slate-800">
                <div>
                    <span class="text-xs font-bold uppercase tracking-wider text-emerald-600 dark:text-emerald-400 mb-2 block">Etalase & Katalog</span>
                    <h2 class="text-2xl sm:text-3xl lg:text-4xl font-extrabold text-slate-900 dark:text-white tracking-tight">Katalog Produk & Galeri Karya</h2>
                    <p class="text-xs sm:text-sm text-slate-500 dark:text-slate-400 mt-1">Pilih produk yang Anda sukai dan pesan langsung via WhatsApp.</p>
                </div>
                <div class="text-xs font-semibold text-slate-500 dark:text-slate-400">
                    Menampilkan <strong>{{ $mitra->products->count() }}</strong> penawaran unggulan
                </div>
            </div>

            @if ($mitra->products->count() === 0)
                <div class="text-center py-16 bg-white dark:bg-slate-950 rounded-3xl border border-slate-200 dark:border-slate-800 shadow-xs max-w-md mx-auto">
                    <i class="fa-solid fa-box-open text-4xl text-slate-300 dark:text-slate-600 mb-3 block"></i>
                    <h3 class="font-bold text-slate-700 dark:text-slate-200 text-sm">Etalase Sedang Dalam Penyiapan</h3>
                    <p class="text-xs text-slate-400 dark:text-slate-500 mt-1">Pemilik usaha belum menambahkan item produk ke katalog.</p>
                </div>
            @else
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 sm:gap-8">
                    @foreach ($mitra->products as $product)
                        <div class="bg-white dark:bg-slate-950 rounded-3xl border border-slate-200 dark:border-slate-800 shadow-xs hover:shadow-xl hover:border-emerald-300 dark:hover:border-emerald-500 transition-all duration-300 overflow-hidden flex flex-col justify-between group">
                            <div>
                                <!-- Foto Produk dengan aspect ratio tetap -->
                                <div class="h-56 sm:h-60 bg-slate-100 dark:bg-slate-900 overflow-hidden relative">
                                    @if ($product->foto)
                                        <img src="{{ Str::startsWith($product->foto, 'http') ? $product->foto : asset('storage/' . $product->foto) }}"
                                             alt="{{ $product->nama }}"
                                             class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center text-slate-300 dark:text-slate-700 bg-slate-100 dark:bg-slate-900">
                                            <i class="fa-regular fa-image text-5xl"></i>
                                        </div>
                                    @endif

                                    <!-- Price Tag Badge -->
                                    <div class="absolute bottom-3 left-3 bg-slate-950/85 backdrop-blur-xs text-white px-3.5 py-1.5 rounded-xl font-extrabold text-xs sm:text-sm shadow-md">
                                        @if ($product->harga)
                                            Rp {{ number_format($product->harga, 0, ',', '.') }}
                                        @else
                                            <span class="text-xs font-semibold text-emerald-400">Hubungi Kami</span>
                                        @endif
                                    </div>
                                </div>

                                <!-- Body Info -->
                                <div class="p-6">
                                    <h3 class="text-base sm:text-lg font-bold text-slate-900 dark:text-white group-hover:text-emerald-600 dark:group-hover:text-emerald-400 transition mb-2 line-clamp-1">
                                        {{ $product->nama }}
                                    </h3>
                                    <p class="text-xs sm:text-sm text-slate-500 dark:text-slate-400 leading-relaxed line-clamp-3">
                                        {{ $product->deskripsi ?? 'Produk berkualitas dari ' . $mitra->nama_usaha . '.' }}
                                    </p>
                                </div>
                            </div>

                            <!-- WhatsApp Direct Conversion CTA Button -->
                            <div class="p-6 pt-0">
                                @if ($waNumber)
                                    @php
                                        $msg = 'Halo ' . $mitra->nama_usaha . ', saya tertarik memesan produk: "' . $product->nama . '" yang tertera di website promosi resmi Anda.';
                                    @endphp
                                    <a href="https://wa.me/{{ $waNumber }}?text={{ urlencode($msg) }}"
                                       target="_blank"
                                       class="w-full inline-flex items-center justify-center gap-2 py-3 px-4 bg-gradient-to-r from-emerald-600 to-teal-600 hover:from-emerald-700 hover:to-teal-700 text-white font-bold text-xs sm:text-sm rounded-xl shadow-md transition shadow-emerald-600/20 group-hover:shadow-emerald-600/30">
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
    <section id="kontak" class="py-20 sm:py-28 bg-white dark:bg-slate-950 transition-colors">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-3xl mx-auto mb-16">
                <span class="text-xs font-bold uppercase tracking-wider text-emerald-600 dark:text-emerald-400 mb-2 block">Informasi & Lokasi</span>
                <h2 class="text-2xl sm:text-3xl lg:text-4xl font-extrabold text-slate-900 dark:text-white tracking-tight">Hubungi & Kunjungi Kami</h2>
                <div class="w-16 h-1 bg-gradient-to-r from-emerald-500 to-teal-400 mx-auto mt-4 rounded-full"></div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-10">

                <!-- Detail Kontak & Medsos (5 Cols) -->
                <div class="lg:col-span-5 space-y-6">

                    <!-- Info Box -->
                    <div class="bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-3xl p-6 sm:p-8 space-y-5 text-xs sm:text-sm">
                        <!-- Alamat -->
                        <div class="flex items-start gap-3.5">
                            <div class="w-10 h-10 rounded-xl bg-emerald-100 dark:bg-emerald-950/60 text-emerald-700 dark:text-emerald-300 flex items-center justify-center shrink-0 text-base">
                                <i class="fa-solid fa-location-dot"></i>
                            </div>
                            <div>
                                <span class="text-slate-400 dark:text-slate-500 font-bold uppercase text-[10px] block">Alamat Usaha:</span>
                                <span class="font-semibold text-slate-800 dark:text-slate-200 leading-relaxed block mt-0.5">
                                    {{ $contact?->alamat ?? $mitra->alamat }}
                                </span>
                            </div>
                        </div>

                        <!-- WhatsApp Direct -->
                        <div class="flex items-start gap-3.5">
                            <div class="w-10 h-10 rounded-xl bg-gradient-to-tr from-emerald-600 to-teal-500 text-white flex items-center justify-center shrink-0 text-lg shadow-sm">
                                <i class="fa-brands fa-whatsapp"></i>
                            </div>
                            <div>
                                <span class="text-slate-400 dark:text-slate-500 font-bold uppercase text-[10px] block">WhatsApp Pemesanan:</span>
                                <a href="https://wa.me/{{ $waNumber }}" target="_blank" class="font-bold text-emerald-700 dark:text-emerald-400 hover:underline block mt-0.5 text-base">
                                    +{{ $waNumber }}
                                </a>
                            </div>
                        </div>

                        <!-- Jam Buka -->
                        @if ($contact?->jam_operasional)
                            <div class="flex items-start gap-3.5">
                                <div class="w-10 h-10 rounded-xl bg-amber-100 dark:bg-amber-950/60 text-amber-700 dark:text-amber-300 flex items-center justify-center shrink-0 text-base">
                                    <i class="fa-solid fa-clock"></i>
                                </div>
                                <div>
                                    <span class="text-slate-400 dark:text-slate-500 font-bold uppercase text-[10px] block">Jam Operasional:</span>
                                    <span class="font-semibold text-slate-800 dark:text-slate-200 block mt-0.5">
                                        {{ $contact->jam_operasional }}
                                    </span>
                                </div>
                            </div>
                        @endif

                        <!-- Email & Telepon -->
                        @if ($contact?->email || $contact?->telepon)
                            <div class="pt-3 border-t border-slate-200 dark:border-slate-800 grid grid-cols-1 sm:grid-cols-2 gap-3 text-xs">
                                @if ($contact->email)
                                    <div>
                                        <span class="text-slate-400 dark:text-slate-500 block text-[10px] font-bold uppercase">Email:</span>
                                        <span class="font-semibold text-slate-700 dark:text-slate-300">{{ $contact->email }}</span>
                                    </div>
                                @endif
                                @if ($contact->telepon)
                                    <div>
                                        <span class="text-slate-400 dark:text-slate-500 block text-[10px] font-bold uppercase">Telepon:</span>
                                        <span class="font-semibold text-slate-700 dark:text-slate-300">{{ $contact->telepon }}</span>
                                    </div>
                                @endif
                            </div>
                        @endif
                    </div>

                    <!-- Media Sosial Links -->
                    @if ($contact?->instagram || $contact?->facebook || $contact?->tiktok)
                        <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-3xl p-6">
                            <span class="text-xs font-bold uppercase tracking-wider text-slate-400 dark:text-slate-500 block mb-3">Ikuti Media Sosial Kami:</span>
                            <div class="flex items-center gap-3">
                                @if ($contact->instagram)
                                    <a href="https://instagram.com/{{ ltrim($contact->instagram, '@') }}" target="_blank"
                                       class="w-11 h-11 rounded-xl bg-pink-50 dark:bg-pink-950/40 text-pink-600 dark:text-pink-400 hover:bg-pink-600 hover:text-white flex items-center justify-center text-lg transition shadow-xs">
                                        <i class="fa-brands fa-instagram"></i>
                                    </a>
                                @endif
                                @if ($contact->facebook)
                                    <a href="https://facebook.com/{{ $contact->facebook }}" target="_blank"
                                       class="w-11 h-11 rounded-xl bg-blue-50 dark:bg-blue-950/40 text-blue-600 dark:text-blue-400 hover:bg-blue-600 hover:text-white flex items-center justify-center text-lg transition shadow-xs">
                                        <i class="fa-brands fa-facebook"></i>
                                    </a>
                                @endif
                                @if ($contact->tiktok)
                                    <a href="https://tiktok.com/@{{ ltrim($contact->tiktok, '@') }}" target="_blank"
                                       class="w-11 h-11 rounded-xl bg-slate-100 dark:bg-slate-800 text-slate-900 dark:text-slate-100 hover:bg-slate-900 hover:text-white flex items-center justify-center text-lg transition shadow-xs">
                                        <i class="fa-brands fa-tiktok"></i>
                                    </a>
                                @endif
                            </div>
                        </div>
                    @endif

                </div>

                <!-- Google Maps Embed (7 Cols) -->
                <div class="lg:col-span-7">
                    <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-3xl overflow-hidden shadow-xs h-full min-h-[360px] sm:min-h-[420px] flex flex-col">
                        <div class="p-4 bg-slate-50 dark:bg-slate-800/80 border-b border-slate-200 dark:border-slate-800 text-xs font-semibold text-slate-600 dark:text-slate-300 flex items-center gap-2">
                            <i class="fa-solid fa-map-location-dot text-emerald-600 dark:text-emerald-400"></i> Peta Lokasi Gerai / Usaha
                        </div>
                        <div class="flex-grow bg-slate-100 dark:bg-slate-950 relative min-h-[300px]">
                            @if (!empty($contact?->maps_embed))
                                <iframe src="{{ $contact->maps_embed }}"
                                        width="100%" height="100%" style="border:0; min-height: 360px;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade">
                                </iframe>
                            @else
                                <div class="w-full h-full min-h-[300px] flex flex-col items-center justify-center text-slate-400 dark:text-slate-500 p-8 text-center">
                                    <i class="fa-solid fa-map-pin text-4xl mb-3 text-slate-300 dark:text-slate-600"></i>
                                    <span class="font-bold text-slate-600 dark:text-slate-300 text-sm">Peta Google Maps Belum Disematkan</span>
                                    <p class="text-xs text-slate-400 dark:text-slate-500 max-w-sm mt-1">
                                        {{ $contact?->alamat ?? $mitra->alamat }}
                                    </p>
                                    @if ($waNumber)
                                        <a href="https://wa.me/{{ $waNumber }}?text={{ urlencode('Halo, boleh minta petunjuk arah lokasi usaha ' . $mitra->nama_usaha . '?') }}" target="_blank"
                                           class="mt-4 px-4 py-2 bg-gradient-to-r from-emerald-600 to-teal-600 text-white rounded-xl text-xs font-bold inline-flex items-center gap-1.5 shadow-sm">
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
               class="flex items-center gap-3 px-5 py-3.5 bg-gradient-to-r from-emerald-600 to-teal-600 hover:from-emerald-500 hover:to-teal-500 text-white rounded-full shadow-2xl shadow-emerald-600/50 transition duration-300 transform hover:scale-105 font-bold text-sm">
                <i class="fa-brands fa-whatsapp text-2xl animate-pulse"></i>
                <span class="hidden sm:inline">Pesan via WhatsApp</span>
            </a>
        </aside>
    @endif

    <!-- FOOTER RESMI "DIDUKUNG OLEH MITRA PKM" -->
    <footer class="bg-slate-950 text-slate-400 border-t border-slate-900 py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center text-xs">
            <div class="mb-4">
                <span class="text-white font-extrabold text-base">{{ $mitra->nama_usaha }}</span>
                <p class="text-slate-500 text-xs mt-0.5">{{ $contact?->alamat ?? $mitra->alamat }}</p>
            </div>

            <div class="pt-6 border-t border-slate-900 flex flex-col sm:flex-row items-center justify-between gap-4">
                <p>&copy; {{ date('Y') }} {{ $mitra->nama_usaha }}. Seluruh hak cipta dilindungi.</p>
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
