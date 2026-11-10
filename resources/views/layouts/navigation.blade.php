<nav x-data="{ open: false }" class="bg-white dark:bg-slate-900 border-b border-slate-200 dark:border-slate-800 sticky top-0 z-40 shadow-xs transition-colors duration-200">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('home') }}" class="flex items-center gap-2 group">
                        <div class="w-9 h-9 rounded-xl bg-gradient-to-tr from-emerald-500 to-teal-500 text-white flex items-center justify-center font-black shadow-sm group-hover:scale-105 transition-transform">
                            <i class="fa-solid fa-store text-sm"></i>
                        </div>
                        <span class="font-bold text-slate-900 dark:text-white text-lg tracking-tight">Mitra <span class="bg-gradient-to-r from-emerald-600 to-teal-500 dark:from-emerald-400 dark:to-teal-300 bg-clip-text text-transparent">PKM</span></span>
                    </a>
                </div>

                <!-- Navigation Links (Desktop) -->
                <div class="hidden space-x-6 sm:-my-px sm:ml-8 sm:flex items-center text-sm font-medium">
                    @if(Auth::user()->isSuperAdmin())
                        <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'border-emerald-600 text-emerald-600 dark:text-emerald-400 font-bold' : 'border-transparent text-slate-600 dark:text-slate-300 hover:text-slate-900 dark:hover:text-white hover:border-slate-300 dark:hover:border-slate-700' }} inline-flex items-center px-1 pt-1 border-b-2 h-16 transition">
                            <i class="fa-solid fa-chart-pie mr-2 text-xs"></i> Ringkasan
                        </a>
                        <a href="{{ route('admin.verifications.index') }}" class="{{ request()->routeIs('admin.verifications.*') ? 'border-emerald-600 text-emerald-600 dark:text-emerald-400 font-bold' : 'border-transparent text-slate-600 dark:text-slate-300 hover:text-slate-900 dark:hover:text-white hover:border-slate-300 dark:hover:border-slate-700' }} inline-flex items-center px-1 pt-1 border-b-2 h-16 transition relative">
                            <i class="fa-solid fa-user-check mr-2 text-xs"></i> Verifikasi Pendaftar
                            @php
                                $pendingCount = \App\Models\User::where('role', 'owner')->where('status', 'pending')->count();
                            @endphp
                            @if($pendingCount > 0)
                                <span class="ml-1.5 px-2 py-0.5 text-[10px] font-bold bg-amber-500 text-white rounded-full">{{ $pendingCount }}</span>
                            @endif
                        </a>
                        <a href="{{ route('admin.mitras.index') }}" class="{{ request()->routeIs('admin.mitras.*') ? 'border-emerald-600 text-emerald-600 dark:text-emerald-400 font-bold' : 'border-transparent text-slate-600 dark:text-slate-300 hover:text-slate-900 dark:hover:text-white hover:border-slate-300 dark:hover:border-slate-700' }} inline-flex items-center px-1 pt-1 border-b-2 h-16 transition">
                            <i class="fa-solid fa-building mr-2 text-xs"></i> Kelola Mitra
                        </a>
                        <a href="{{ route('admin.settings.index') }}" class="{{ request()->routeIs('admin.settings.*') ? 'border-emerald-600 text-emerald-600 dark:text-emerald-400 font-bold' : 'border-transparent text-slate-600 dark:text-slate-300 hover:text-slate-900 dark:hover:text-white hover:border-slate-300 dark:hover:border-slate-700' }} inline-flex items-center px-1 pt-1 border-b-2 h-16 transition">
                            <i class="fa-solid fa-sliders mr-2 text-xs"></i> Atur Halaman Awal
                        </a>
                    @elseif(Auth::user()->isApproved())
                        <a href="{{ route('owner.dashboard') }}" class="{{ request()->routeIs('owner.dashboard') ? 'border-emerald-600 text-emerald-600 dark:text-emerald-400 font-bold' : 'border-transparent text-slate-600 dark:text-slate-300 hover:text-slate-900 dark:hover:text-white hover:border-slate-300 dark:hover:border-slate-700' }} inline-flex items-center px-1 pt-1 border-b-2 h-16 transition">
                            <i class="fa-solid fa-gauge mr-2 text-xs"></i> Beranda
                        </a>
                        <a href="{{ route('owner.hero.edit') }}" class="{{ request()->routeIs('owner.hero.*') ? 'border-emerald-600 text-emerald-600 dark:text-emerald-400 font-bold' : 'border-transparent text-slate-600 dark:text-slate-300 hover:text-slate-900 dark:hover:text-white hover:border-slate-300 dark:hover:border-slate-700' }} inline-flex items-center px-1 pt-1 border-b-2 h-16 transition">
                            <i class="fa-solid fa-image mr-2 text-xs"></i> 1. Sampul
                        </a>
                        <a href="{{ route('owner.about.edit') }}" class="{{ request()->routeIs('owner.about.*') ? 'border-emerald-600 text-emerald-600 dark:text-emerald-400 font-bold' : 'border-transparent text-slate-600 dark:text-slate-300 hover:text-slate-900 dark:hover:text-white hover:border-slate-300 dark:hover:border-slate-700' }} inline-flex items-center px-1 pt-1 border-b-2 h-16 transition">
                            <i class="fa-solid fa-circle-info mr-2 text-xs"></i> 2. Tentang
                        </a>
                        <a href="{{ route('owner.products.index') }}" class="{{ request()->routeIs('owner.products.*') ? 'border-emerald-600 text-emerald-600 dark:text-emerald-400 font-bold' : 'border-transparent text-slate-600 dark:text-slate-300 hover:text-slate-900 dark:hover:text-white hover:border-slate-300 dark:hover:border-slate-700' }} inline-flex items-center px-1 pt-1 border-b-2 h-16 transition">
                            <i class="fa-solid fa-boxes-stacked mr-2 text-xs"></i> 3. Produk
                        </a>
                        <a href="{{ route('owner.contact.edit') }}" class="{{ request()->routeIs('owner.contact.*') ? 'border-emerald-600 text-emerald-600 dark:text-emerald-400 font-bold' : 'border-transparent text-slate-600 dark:text-slate-300 hover:text-slate-900 dark:hover:text-white hover:border-slate-300 dark:hover:border-slate-700' }} inline-flex items-center px-1 pt-1 border-b-2 h-16 transition">
                            <i class="fa-solid fa-address-book mr-2 text-xs"></i> 4. Kontak & Lokasi
                        </a>
                        <a href="{{ route('owner.settings.edit') }}" class="{{ request()->routeIs('owner.settings.*') ? 'border-emerald-600 text-emerald-600 dark:text-emerald-400 font-bold' : 'border-transparent text-slate-600 dark:text-slate-300 hover:text-slate-900 dark:hover:text-white hover:border-slate-300 dark:hover:border-slate-700' }} inline-flex items-center px-1 pt-1 border-b-2 h-16 transition">
                            <i class="fa-solid fa-gear mr-2 text-xs"></i> Pengaturan
                        </a>
                    @else
                        <a href="{{ route('owner.status') }}" class="border-amber-500 text-amber-600 dark:text-amber-400 font-bold inline-flex items-center px-1 pt-1 border-b-2 h-16 transition">
                            <i class="fa-solid fa-clock mr-2 text-xs"></i> Status Pendaftaran
                        </a>
                    @endif
                </div>
            </div>

            <!-- Right Nav Actions -->
            <div class="hidden sm:flex sm:items-center sm:ml-6 gap-3">
                <!-- Theme Toggle Button -->
                <button type="button" @click="toggleTheme()"
                    class="w-9 h-9 rounded-xl flex items-center justify-center border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800 text-slate-600 dark:text-amber-400 hover:bg-slate-100 dark:hover:bg-slate-700 transition"
                    :title="isDark ? 'Beralih ke Mode Terang' : 'Beralih ke Mode Gelap'"
                    aria-label="Toggle tema terang/gelap">
                    <i class="fa-solid text-xs" :class="isDark ? 'fa-sun text-amber-400' : 'fa-moon text-slate-600'"></i>
                </button>

                @if(Auth::user()->isApproved() && Auth::user()->mitra)
                    <a href="{{ route('owner.preview') }}" target="_blank" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-800 hover:bg-slate-50 dark:hover:bg-slate-700 text-slate-700 dark:text-slate-200 text-xs font-semibold shadow-xs transition">
                        <i class="fa-regular fa-eye text-emerald-600 dark:text-emerald-400"></i> Pratinjau Website
                    </a>
                @endif

                <!-- User Dropdown -->
                <div class="relative" x-data="{ open: false }" @click.away="open = false">
                    <button @click="open = ! open" class="inline-flex items-center gap-2 px-3 py-2 border border-slate-200 dark:border-slate-700 text-xs font-medium rounded-xl text-slate-700 dark:text-slate-200 bg-slate-50 dark:bg-slate-800 hover:bg-slate-100 dark:hover:bg-slate-700 focus:outline-none transition">
                        <div class="w-6 h-6 rounded-full bg-emerald-600 text-white flex items-center justify-center font-bold text-xs uppercase">
                            {{ substr(Auth::user()->name, 0, 1) }}
                        </div>
                        <div class="text-left">
                            <span class="font-bold text-slate-800 dark:text-slate-100 block leading-tight">{{ Auth::user()->name }}</span>
                            <span class="text-[10px] text-slate-500 dark:text-slate-400 uppercase tracking-wider block">
                                {{ Auth::user()->role === 'superadmin' ? 'Superadmin' : (Auth::user()->mitra ? Auth::user()->mitra->nama_usaha : 'Owner') }}
                            </span>
                        </div>
                        <i class="fa-solid fa-chevron-down text-[10px] text-slate-400 ml-1"></i>
                    </button>

                    <div x-show="open" x-cloak class="origin-top-right absolute right-0 mt-2 w-48 rounded-xl shadow-lg py-1 bg-white dark:bg-slate-800 ring-1 ring-black ring-opacity-5 border border-slate-100 dark:border-slate-700 focus:outline-none z-50">
                        <div class="px-4 py-2 border-b border-slate-100 dark:border-slate-700 text-xs text-slate-500 dark:text-slate-400">
                            Masuk sebagai <strong>{{ Auth::user()->email }}</strong>
                        </div>
                        <a href="{{ route('home') }}" class="block px-4 py-2 text-xs text-slate-700 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-700">
                            <i class="fa-solid fa-globe mr-2 text-slate-400"></i> Lihat Portal Publik
                        </a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="w-full text-left block px-4 py-2 text-xs text-rose-600 dark:text-rose-400 hover:bg-rose-50 dark:hover:bg-rose-950/40 font-semibold">
                                <i class="fa-solid fa-right-from-bracket mr-2"></i> Keluar (Logout)
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Hamburger Button & Theme Toggle (Mobile) -->
            <div class="-mr-2 flex items-center sm:hidden gap-1">
                <button type="button" @click="toggleTheme()" class="p-2 rounded-lg text-slate-500 dark:text-amber-400 hover:bg-slate-100 dark:hover:bg-slate-800">
                    <i class="fa-solid text-xs" :class="isDark ? 'fa-sun text-amber-400' : 'fa-moon text-slate-600'"></i>
                </button>
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-lg text-slate-500 dark:text-slate-300 hover:text-slate-700 dark:hover:text-white hover:bg-slate-100 dark:hover:bg-slate-800 focus:outline-none">
                    <i class="fa-solid fa-bars text-lg" x-show="!open"></i>
                    <i class="fa-solid fa-xmark text-lg" x-show="open" x-cloak></i>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu (Mobile) -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden border-t border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900">
        <div class="pt-2 pb-3 space-y-1 px-4">
            @if(Auth::user()->isSuperAdmin())
                <a href="{{ route('admin.dashboard') }}" class="block py-2 text-sm font-semibold {{ request()->routeIs('admin.dashboard') ? 'text-emerald-600 dark:text-emerald-400' : 'text-slate-600 dark:text-slate-300' }}">
                    <i class="fa-solid fa-chart-pie mr-2"></i> Ringkasan
                </a>
                <a href="{{ route('admin.verifications.index') }}" class="block py-2 text-sm font-semibold {{ request()->routeIs('admin.verifications.*') ? 'text-emerald-600 dark:text-emerald-400' : 'text-slate-600 dark:text-slate-300' }}">
                    <i class="fa-solid fa-user-check mr-2"></i> Verifikasi Pendaftar
                </a>
                <a href="{{ route('admin.mitras.index') }}" class="block py-2 text-sm font-semibold {{ request()->routeIs('admin.mitras.*') ? 'text-emerald-600 dark:text-emerald-400' : 'text-slate-600 dark:text-slate-300' }}">
                    <i class="fa-solid fa-building mr-2"></i> Kelola Mitra
                </a>
                <a href="{{ route('admin.settings.index') }}" class="block py-2 text-sm font-semibold {{ request()->routeIs('admin.settings.*') ? 'text-emerald-600 dark:text-emerald-400' : 'text-slate-600 dark:text-slate-300' }}">
                    <i class="fa-solid fa-sliders mr-2"></i> Atur Halaman Awal
                </a>
            @elseif(Auth::user()->isApproved())
                <a href="{{ route('owner.dashboard') }}" class="block py-2 text-sm font-semibold {{ request()->routeIs('owner.dashboard') ? 'text-emerald-600 dark:text-emerald-400' : 'text-slate-600 dark:text-slate-300' }}">
                    <i class="fa-solid fa-gauge mr-2"></i> Beranda Editor
                </a>
                <a href="{{ route('owner.hero.edit') }}" class="block py-2 text-sm font-semibold {{ request()->routeIs('owner.hero.*') ? 'text-emerald-600 dark:text-emerald-400' : 'text-slate-600 dark:text-slate-300' }}">
                    <i class="fa-solid fa-image mr-2"></i> Section 1: Sampul
                </a>
                <a href="{{ route('owner.about.edit') }}" class="block py-2 text-sm font-semibold {{ request()->routeIs('owner.about.*') ? 'text-emerald-600 dark:text-emerald-400' : 'text-slate-600 dark:text-slate-300' }}">
                    <i class="fa-solid fa-circle-info mr-2"></i> Section 2: Tentang
                </a>
                <a href="{{ route('owner.products.index') }}" class="block py-2 text-sm font-semibold {{ request()->routeIs('owner.products.*') ? 'text-emerald-600 dark:text-emerald-400' : 'text-slate-600 dark:text-slate-300' }}">
                    <i class="fa-solid fa-boxes-stacked mr-2"></i> Section 3: Produk
                </a>
                <a href="{{ route('owner.contact.edit') }}" class="block py-2 text-sm font-semibold {{ request()->routeIs('owner.contact.*') ? 'text-emerald-600 dark:text-emerald-400' : 'text-slate-600 dark:text-slate-300' }}">
                    <i class="fa-solid fa-address-book mr-2"></i> Section 4: Kontak & Lokasi
                </a>
                <a href="{{ route('owner.settings.edit') }}" class="block py-2 text-sm font-semibold {{ request()->routeIs('owner.settings.*') ? 'text-emerald-600 dark:text-emerald-400' : 'text-slate-600 dark:text-slate-300' }}">
                    <i class="fa-solid fa-gear mr-2"></i> Pengaturan Website
                </a>
            @else
                <a href="{{ route('owner.status') }}" class="block py-2 text-sm font-bold text-amber-600 dark:text-amber-400">
                    <i class="fa-solid fa-clock mr-2"></i> Status Pendaftaran
                </a>
            @endif
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-3 border-t border-slate-200 dark:border-slate-800 px-4 bg-slate-50 dark:bg-slate-800/50">
            <div class="text-xs text-slate-500 dark:text-slate-400 font-bold mb-1">{{ Auth::user()->name }}</div>
            <div class="text-xs text-slate-400 dark:text-slate-500 mb-3">{{ Auth::user()->email }}</div>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="w-full text-left py-2 text-xs font-semibold text-rose-600 dark:text-rose-400">
                    <i class="fa-solid fa-right-from-bracket mr-2"></i> Keluar (Logout)
                </button>
            </form>
        </div>
    </div>
</nav>
