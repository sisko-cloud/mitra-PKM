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
<body class="font-sans antialiased bg-slate-50 text-slate-800 min-h-screen flex flex-col selection:bg-brand-500 selection:text-white">

    <!-- Top Notice Banner -->
    <div class="bg-gradient-to-r from-emerald-700 via-teal-700 to-emerald-800 text-white text-xs sm:text-sm py-2 px-4 text-center font-medium shadow-sm">
        <div class="max-w-7xl mx-auto flex items-center justify-between">
            <span class="inline-flex items-center gap-1.5">
                <span class="w-2 h-2 rounded-full bg-emerald-300 animate-ping"></span>
                <span>Platform Resmi Etalase UMKM & Koperasi Mitra PKM</span>
            </span>
            <div class="hidden md:flex items-center gap-4 text-xs opacity-90">
                <span><i class="fa-solid fa-shield-halved mr-1 text-emerald-300"></i> Terverifikasi Resmi</span>
                <span><i class="fa-solid fa-paper-plane mr-1 text-emerald-300"></i> Terintegrasi WhatsApp Direct</span>
            </div>
        </div>
    </div>

    <!-- Navigation Header -->
    <header class="bg-white border-b border-slate-200 sticky top-0 z-40 shadow-xs backdrop-blur-md bg-white/95">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16 sm:h-20">
                <!-- Logo -->
                <a href="{{ route('home') }}" class="flex items-center gap-3 group">
                    <div class="w-10 h-10 sm:w-11 sm:h-11 rounded-xl bg-gradient-to-tr from-emerald-600 to-teal-500 text-white flex items-center justify-center font-black text-xl shadow-md shadow-emerald-500/20 group-hover:scale-105 transition-transform">
                        <i class="fa-solid fa-store"></i>
                    </div>
                    <div>
                        <span class="text-xl sm:text-2xl font-extrabold text-slate-900 tracking-tight block">Mitra <span class="text-emerald-600">PKM</span></span>
                        <span class="text-[10px] sm:text-xs text-slate-500 font-medium block -mt-1 tracking-wider uppercase">Direktori & Etalase UMKM</span>
                    </div>
                </a>

                <!-- Nav Links -->
                <nav class="hidden md:flex items-center gap-6">
                    <a href="{{ route('home') }}" class="text-sm font-semibold {{ request()->routeIs('home') ? 'text-emerald-600 font-bold' : 'text-slate-600 hover:text-emerald-600' }} transition-colors">
                        Beranda
                    </a>
                    <a href="{{ route('home') }}#katalog" class="text-sm font-semibold text-slate-600 hover:text-emerald-600 transition-colors">
                        Katalog Mitra
                    </a>
                    <a href="{{ route('home') }}#tentang-pkm" class="text-sm font-semibold text-slate-600 hover:text-emerald-600 transition-colors">
                        Tentang PKM
                    </a>
                </nav>

                <!-- Auth Buttons -->
                <div class="flex items-center gap-2 sm:gap-3">
                    @auth
                        @if(Auth::user()->isSuperAdmin())
                            <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center gap-2 px-4 py-2 sm:px-5 sm:py-2.5 rounded-xl bg-slate-900 hover:bg-slate-800 text-white font-semibold text-xs sm:text-sm shadow-sm transition">
                                <i class="fa-solid fa-gauge text-emerald-400"></i>
                                <span>Dashboard Superadmin</span>
                            </a>
                        @elseif(Auth::user()->isApproved())
                            <a href="{{ route('owner.dashboard') }}" class="inline-flex items-center gap-2 px-4 py-2 sm:px-5 sm:py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-semibold text-xs sm:text-sm shadow-sm shadow-emerald-600/30 transition">
                                <i class="fa-solid fa-store"></i>
                                <span>Kelola Website Saya</span>
                            </a>
                        @else
                            <a href="{{ route('owner.status') }}" class="inline-flex items-center gap-2 px-4 py-2 sm:px-5 sm:py-2.5 rounded-xl bg-amber-500 hover:bg-amber-600 text-white font-semibold text-xs sm:text-sm shadow-sm transition">
                                <i class="fa-solid fa-clock"></i>
                                <span>Status Akun</span>
                            </a>
                        @endif
                    @else
                        <a href="{{ route('login') }}" class="px-3.5 py-2 sm:px-4 sm:py-2 rounded-xl text-slate-700 hover:text-emerald-700 font-semibold text-xs sm:text-sm hover:bg-slate-100 transition">
                            Masuk
                        </a>
                        <a href="{{ route('register') }}" class="inline-flex items-center gap-1.5 px-4 py-2 sm:px-5 sm:py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-semibold text-xs sm:text-sm shadow-md shadow-emerald-600/20 hover:shadow-emerald-600/30 transition">
                            <i class="fa-solid fa-plus-circle text-xs"></i>
                            <span>Daftar sebagai Mitra</span>
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="flex-grow">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-slate-900 text-slate-400 border-t border-slate-800 mt-20">
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
                    <div class="mt-6 flex items-center gap-4 text-slate-400">
                        <span class="text-xs bg-slate-800 text-slate-300 px-3 py-1.5 rounded-lg border border-slate-700">
                            <i class="fa-solid fa-graduation-cap text-emerald-400 mr-1.5"></i> Program PKM Kemendikbudristek
                        </span>
                    </div>
                </div>

                <!-- Navigasi Cepat -->
                <div>
                    <h4 class="text-sm font-bold uppercase tracking-wider text-slate-200 mb-4">Navigasi Cepat</h4>
                    <ul class="space-y-2.5 text-sm">
                        <li><a href="{{ route('home') }}" class="hover:text-emerald-400 transition">Beranda Utama</a></li>
                        <li><a href="{{ route('home') }}#katalog" class="hover:text-emerald-400 transition">Katalog Mitra Terverifikasi</a></li>
                        <li><a href="{{ route('register') }}" class="hover:text-emerald-400 transition">Daftar Mitra Baru</a></li>
                        <li><a href="{{ route('login') }}" class="hover:text-emerald-400 transition">Masuk Akun Owner</a></li>
                    </ul>
                </div>

                <!-- Kontak Bantuan -->
                <div>
                    <h4 class="text-sm font-bold uppercase tracking-wider text-slate-200 mb-4">Layanan & Bantuan</h4>
                    <ul class="space-y-2.5 text-sm text-slate-400">
                        <li class="flex items-center gap-2">
                            <i class="fa-regular fa-envelope text-emerald-400"></i>
                            <span>admin@mitrapkm.id</span>
                        </li>
                        <li class="flex items-center gap-2">
                            <i class="fa-brands fa-whatsapp text-emerald-400"></i>
                            <span>+62 812-3456-7890</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <i class="fa-solid fa-location-dot text-emerald-400 mt-1"></i>
                            <span>Sekretariat Pembina PKM Kewirausahaan & Pengabdian Masyarakat</span>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="pt-8 border-t border-slate-800 flex flex-col sm:flex-row items-center justify-between gap-4 text-xs text-slate-500">
                <p>&copy; {{ date('Y') }} <strong>Mitra PKM</strong>. Seluruh hak cipta dilindungi undang-undang.</p>
                <p class="inline-flex items-center gap-1.5">
                    <span>Didukung oleh</span>
                    <span class="text-slate-300 font-semibold">Mitra PKM Framework</span>
                    <span>&bull;</span>
                    <span class="text-emerald-400">Bangga Buatan Indonesia</span>
                </p>
            </div>
        </div>
    </footer>

</body>
</html>
