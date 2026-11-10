<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Mitra PKM - Direktori & Etalase Promosi UMKM dan Koperasi')</title>

    <!-- SEO & Open Graph -->
    @yield('meta')

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
                            200: '#a7f3d0',
                            300: '#6ee7b7',
                            400: '#34d399',
                            500: '#10b981',
                            600: '#059669',
                            700: '#047857',
                            800: '#065f46',
                            900: '#064e3b',
                            950: '#022c22',
                        },
                        accent: {
                            50: '#eef2ff',
                            100: '#e0e7ff',
                            500: '#6366f1',
                            600: '#4f46e5',
                            700: '#4338ca',
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
<body class="font-sans antialiased bg-slate-50 text-slate-800 dark:bg-slate-950 dark:text-slate-100 min-h-screen flex flex-col selection:bg-emerald-600 selection:text-white transition-colors duration-200"
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

    <!-- Top Notice Banner -->
    <div class="bg-gradient-to-r from-emerald-900 via-teal-900 to-indigo-950 text-white text-xs py-2 px-4 shadow-xs">
        <div class="max-w-7xl mx-auto flex items-center justify-between">
            <span class="inline-flex items-center gap-2 font-medium">
                <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                <span>Platform Resmi Direktori & Etalase UMKM &bull; Koperasi Mitra PKM</span>
            </span>
            <div class="hidden sm:flex items-center gap-4 text-[11px] text-emerald-200">
                <span><i class="fa-solid fa-shield-halved mr-1 text-emerald-400"></i> Terverifikasi Resmi</span>
                <span><i class="fa-brands fa-whatsapp mr-1 text-emerald-400"></i> Integrasi WhatsApp Direct</span>
            </div>
        </div>
    </div>

    <!-- Navigation Header -->
    <header class="bg-white/90 dark:bg-slate-900/90 backdrop-blur-md border-b border-slate-200/80 dark:border-slate-800/80 sticky top-0 z-40 shadow-xs transition-colors duration-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16 sm:h-20">

                <!-- Logo Brand -->
                <a href="{{ route('home') }}" class="flex items-center gap-3 group shrink-0">
                    <div class="w-10 h-10 sm:w-11 sm:h-11 rounded-2xl bg-gradient-to-tr from-emerald-500 via-teal-500 to-cyan-500 text-white flex items-center justify-center font-black text-xl shadow-lg shadow-emerald-500/25 group-hover:scale-105 transition-transform">
                        <i class="fa-solid fa-store"></i>
                    </div>
                    <div>
                        <span class="text-xl sm:text-2xl font-extrabold text-slate-900 dark:text-white tracking-tight block leading-tight">
                            Mitra <span class="bg-gradient-to-r from-emerald-600 to-teal-500 dark:from-emerald-400 dark:to-teal-300 bg-clip-text text-transparent">PKM</span>
                        </span>
                        <span class="text-[10px] sm:text-xs text-slate-500 dark:text-slate-400 font-semibold block uppercase tracking-wider">
                            Direktori & Etalase Digital
                        </span>
                    </div>
                </a>

                <!-- Desktop Navigation Links -->
                <nav class="hidden md:flex items-center gap-8 text-sm font-semibold">
                    <a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'text-emerald-600 dark:text-emerald-400 font-bold' : 'text-slate-600 dark:text-slate-300 hover:text-emerald-600 dark:hover:text-emerald-400' }} transition">
                        Beranda
                    </a>
                    <a href="{{ route('home') }}#katalog" class="text-slate-600 dark:text-slate-300 hover:text-emerald-600 dark:hover:text-emerald-400 transition">
                        Katalog Mitra
                    </a>
                    <a href="{{ route('home') }}#tentang-pkm" class="text-slate-600 dark:text-slate-300 hover:text-emerald-600 dark:hover:text-emerald-400 transition">
                        Tentang Program PKM
                    </a>
                </nav>

                <!-- Auth Action Buttons (Desktop) -->
                <div class="hidden sm:flex items-center gap-3">
                    <!-- Tema Toggle Button (Desktop) -->
                    <button type="button" @click="toggleTheme()"
                        class="w-10 h-10 rounded-xl flex items-center justify-center border border-slate-200 dark:border-slate-700 bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-amber-400 hover:bg-slate-200 dark:hover:bg-slate-700 transition"
                        :title="isDark ? 'Beralih ke Mode Terang (Light Mode)' : 'Beralih ke Mode Gelap (Dark Mode)'"
                        aria-label="Toggle Mode Terang/Gelap">
                        <i class="fa-solid" :class="isDark ? 'fa-sun text-amber-400 text-base' : 'fa-moon text-slate-600 text-sm'"></i>
                    </button>

                    @auth
                        @if(Auth::user()->isSuperAdmin())
                            <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-slate-900 hover:bg-slate-800 dark:bg-slate-800 dark:hover:bg-slate-700 text-white font-semibold text-xs shadow-sm transition border border-slate-800 dark:border-slate-700">
                                <i class="fa-solid fa-gauge text-emerald-400"></i>
                                <span>Panel Superadmin</span>
                            </a>
                        @elseif(Auth::user()->isApproved())
                            <a href="{{ route('owner.dashboard') }}" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-gradient-to-r from-emerald-600 to-teal-600 hover:from-emerald-700 hover:to-teal-700 text-white font-semibold text-xs shadow-md shadow-emerald-600/20 transition">
                                <i class="fa-solid fa-store"></i>
                                <span>Kelola Website Saya</span>
                            </a>
                        @else
                            <a href="{{ route('owner.status') }}" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-amber-500 hover:bg-amber-600 text-white font-semibold text-xs shadow-sm transition">
                                <i class="fa-solid fa-clock"></i>
                                <span>Status Akun</span>
                            </a>
                        @endif
                    @else
                        <a href="{{ route('login') }}" class="px-4 py-2 text-slate-700 dark:text-slate-200 hover:text-emerald-600 dark:hover:text-emerald-400 font-semibold text-xs rounded-xl hover:bg-slate-100 dark:hover:bg-slate-800 transition">
                            Masuk
                        </a>
                        <a href="{{ route('register') }}" class="inline-flex items-center gap-1.5 px-4 py-2.5 rounded-xl bg-gradient-to-r from-emerald-600 via-teal-600 to-cyan-600 hover:from-emerald-700 hover:to-teal-700 text-white font-bold text-xs shadow-md shadow-emerald-600/25 hover:shadow-emerald-600/35 transition">
                            <i class="fa-solid fa-plus-circle text-xs"></i>
                            <span>Daftar sebagai Mitra</span>
                        </a>
                    @endauth
                </div>

                <!-- Mobile Hamburger & Theme Toggle Button -->
                <div class="flex items-center gap-2 sm:hidden">
                    <button type="button" @click="toggleTheme()"
                        class="p-2 rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-amber-400"
                        aria-label="Toggle tema">
                        <i class="fa-solid text-sm" :class="isDark ? 'fa-sun text-amber-400' : 'fa-moon text-slate-600'"></i>
                    </button>
                    <button @click="mobileNav = !mobileNav" class="p-2.5 rounded-xl text-slate-700 dark:text-slate-200 hover:bg-slate-100 dark:hover:bg-slate-800 transition focus:outline-none" aria-label="Menu Navigasi">
                        <i class="fa-solid fa-bars text-xl" x-show="!mobileNav"></i>
                        <i class="fa-solid fa-xmark text-xl" x-show="mobileNav" x-cloak></i>
                    </button>
                </div>

            </div>
        </div>

        <!-- Mobile Drawer Navigation -->
        <div x-show="mobileNav" x-cloak x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0 -translate-y-2"
             x-transition:enter-end="opacity-100 translate-y-0"
             x-transition:leave="transition ease-in duration-150"
             x-transition:leave-start="opacity-100 translate-y-0"
             x-transition:leave-end="opacity-0 -translate-y-2"
             class="sm:hidden border-t border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900 px-4 py-4 space-y-3 shadow-lg">

            <nav class="space-y-1 text-sm font-semibold">
                <a href="{{ route('home') }}" @click="mobileNav = false" class="block px-3 py-2 rounded-lg {{ request()->routeIs('home') ? 'bg-emerald-50 dark:bg-emerald-950/60 text-emerald-700 dark:text-emerald-400 font-bold' : 'text-slate-700 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-800' }}">
                    <i class="fa-solid fa-house mr-2 text-xs"></i> Beranda Utama
                </a>
                <a href="{{ route('home') }}#katalog" @click="mobileNav = false" class="block px-3 py-2 rounded-lg text-slate-700 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-800">
                    <i class="fa-solid fa-store mr-2 text-xs"></i> Katalog Mitra Terverifikasi
                </a>
                <a href="{{ route('home') }}#tentang-pkm" @click="mobileNav = false" class="block px-3 py-2 rounded-lg text-slate-700 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-800">
                    <i class="fa-solid fa-graduation-cap mr-2 text-xs"></i> Tentang Program PKM
                </a>
            </nav>

            <div class="pt-3 border-t border-slate-100 dark:border-slate-800 flex flex-col gap-2">
                @auth
                    @if(Auth::user()->isSuperAdmin())
                        <a href="{{ route('admin.dashboard') }}" class="w-full py-2.5 px-4 text-center rounded-xl bg-slate-900 dark:bg-slate-800 text-white font-bold text-xs shadow-sm">
                            <i class="fa-solid fa-gauge mr-1.5 text-emerald-400"></i> Panel Superadmin
                        </a>
                    @elseif(Auth::user()->isApproved())
                        <a href="{{ route('owner.dashboard') }}" class="w-full py-2.5 px-4 text-center rounded-xl bg-emerald-600 text-white font-bold text-xs shadow-sm">
                            <i class="fa-solid fa-store mr-1.5"></i> Kelola Website Saya
                        </a>
                    @else
                        <a href="{{ route('owner.status') }}" class="w-full py-2.5 px-4 text-center rounded-xl bg-amber-500 text-white font-bold text-xs shadow-sm">
                            <i class="fa-solid fa-clock mr-1.5"></i> Status Pendaftaran
                        </a>
                    @endif
                @else
                    <a href="{{ route('register') }}" class="w-full py-2.5 px-4 text-center rounded-xl bg-gradient-to-r from-emerald-600 to-teal-600 text-white font-bold text-xs shadow-md">
                        <i class="fa-solid fa-plus-circle mr-1.5"></i> Daftar sebagai Mitra Baru
                    </a>
                    <a href="{{ route('login') }}" class="w-full py-2.5 px-4 text-center rounded-xl border border-slate-300 dark:border-slate-700 text-slate-700 dark:text-slate-200 font-semibold text-xs hover:bg-slate-50 dark:hover:bg-slate-800">
                        Masuk ke Akun Anda
                    </a>
                @endauth
            </div>
        </div>
    </header>

    <!-- Main Body Content -->
    <main class="flex-grow">
        @yield('content')
    </main>

    <!-- Elegant Footer -->
    <footer class="bg-slate-950 text-slate-400 border-t border-slate-800 mt-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 sm:py-16">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8 mb-12">

                <!-- Brand Info -->
                <div class="md:col-span-2">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-10 h-10 rounded-xl bg-emerald-500 text-slate-950 flex items-center justify-center font-black text-xl">
                            <i class="fa-solid fa-store"></i>
                        </div>
                        <span class="text-2xl font-extrabold text-white tracking-tight">Mitra <span class="text-emerald-400">PKM</span></span>
                    </div>
                    <p class="text-slate-400 text-sm leading-relaxed max-w-md">
                        Platform direktori dan penyedia website promosi mandiri untuk UMKM serta Koperasi mitra binaan Program Kreativitas Mahasiswa (PKM). Memberdayakan ekonomi lokal melalui transformasi digital yang inklusif dan berkelanjutan.
                    </p>
                    <div class="mt-6 flex flex-wrap items-center gap-3 text-xs">
                        <span class="bg-slate-900 text-slate-300 px-3 py-1.5 rounded-lg border border-slate-800">
                            <i class="fa-solid fa-graduation-cap text-emerald-400 mr-1.5"></i> Binaan Resmi PKM
                        </span>
                        <span class="bg-slate-900 text-slate-300 px-3 py-1.5 rounded-lg border border-slate-800">
                            <i class="fa-brands fa-whatsapp text-emerald-400 mr-1.5"></i> WhatsApp Direct Conversion
                        </span>
                    </div>
                </div>

                <!-- Navigasi Cepat -->
                <div>
                    <h4 class="text-xs font-bold uppercase tracking-wider text-slate-200 mb-4">Navigasi Utama</h4>
                    <ul class="space-y-2.5 text-xs sm:text-sm">
                        <li><a href="{{ route('home') }}" class="hover:text-emerald-400 transition">Beranda Utama</a></li>
                        <li><a href="{{ route('home') }}#katalog" class="hover:text-emerald-400 transition">Katalog Mitra Terverifikasi</a></li>
                        <li><a href="{{ route('register') }}" class="hover:text-emerald-400 transition">Daftar Mitra Baru</a></li>
                        <li><a href="{{ route('login') }}" class="hover:text-emerald-400 transition">Masuk Akun Owner</a></li>
                    </ul>
                </div>

                <!-- Kontak Bantuan -->
                <div>
                    <h4 class="text-xs font-bold uppercase tracking-wider text-slate-200 mb-4">Sekretariat PKM</h4>
                    <ul class="space-y-2.5 text-xs sm:text-sm text-slate-400">
                        <li class="flex items-center gap-2">
                            <i class="fa-regular fa-envelope text-emerald-400"></i>
                            <span>admin@mitrapkm.id</span>
                        </li>
                        <li class="flex items-center gap-2">
                            <i class="fa-brands fa-whatsapp text-emerald-400"></i>
                            <span>+62 812-3456-7890</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <i class="fa-solid fa-location-dot text-emerald-400 mt-0.5"></i>
                            <span>Sekretariat Pembina PKM Kewirausahaan & Pengabdian Masyarakat</span>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="pt-8 border-t border-slate-900 flex flex-col sm:flex-row items-center justify-between gap-4 text-xs text-slate-500">
                <p>&copy; {{ date('Y') }} <strong>Mitra PKM</strong>. Seluruh hak cipta dilindungi.</p>
                <div class="flex items-center gap-2">
                    <span>Didukung oleh</span>
                    <span class="text-slate-300 font-semibold">Mitra PKM Framework</span>
                    <span>&bull;</span>
                    <span class="text-emerald-400 font-medium">Bangga Buatan Indonesia</span>
                </div>
            </div>
        </div>
    </footer>

</body>
</html>
