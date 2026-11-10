<nav x-data="{ open: false }" class="bg-white dark:bg-slate-900 border-b border-slate-200 dark:border-slate-800 sticky top-0 z-40 shadow-xs transition-colors duration-200">
    <!-- Primary Navigation Menu (100% Full Width Screen) -->
    <div class="w-full px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16 sm:h-20">
            <div class="flex items-center">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('home') }}" class="flex items-center gap-2.5 group">
                        <x-application-logo class="w-9 h-9 sm:w-10 sm:h-10" />
                        <span class="font-bold text-slate-900 dark:text-white text-base sm:text-lg tracking-tight">Mitra <span class="bg-gradient-to-r from-orange-600 to-amber-500 dark:from-orange-400 dark:to-amber-300 bg-clip-text text-transparent">PKM</span></span>
                    </a>
                </div>

                <!-- Navigation Links (Desktop - lg and above) -->
                <div class="hidden lg:flex items-center space-x-1 xl:space-x-3 ml-6 xl:ml-8 text-xs xl:text-sm font-medium">
                    @if(Auth::user()->isSuperAdmin())
                        <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'text-orange-600 dark:text-orange-400 font-bold bg-orange-50 dark:bg-orange-950/50' : 'text-slate-600 dark:text-slate-300 hover:text-slate-900 dark:hover:text-white hover:bg-slate-50 dark:hover:bg-slate-800' }} px-3 py-2 rounded-xl transition inline-flex items-center gap-1.5">
                            <i class="fa-solid fa-chart-pie text-xs"></i> <span>Ringkasan</span>
                        </a>
                        <a href="{{ route('admin.verifications.index') }}" class="{{ request()->routeIs('admin.verifications.*') ? 'text-orange-600 dark:text-orange-400 font-bold bg-orange-50 dark:bg-orange-950/50' : 'text-slate-600 dark:text-slate-300 hover:text-slate-900 dark:hover:text-white hover:bg-slate-50 dark:hover:bg-slate-800' }} px-3 py-2 rounded-xl transition inline-flex items-center gap-1.5 relative">
                            <i class="fa-solid fa-user-check text-xs"></i> <span>Verifikasi</span>
                            @php
                                $pendingCount = \App\Models\User::where('role', 'owner')->where('status', 'pending')->count();
                            @endphp
                            @if($pendingCount > 0)
                                <span class="px-1.5 py-0.5 text-[10px] font-bold bg-amber-500 text-white rounded-full">{{ $pendingCount }}</span>
                            @endif
                        </a>
                        <a href="{{ route('admin.mitras.index') }}" class="{{ request()->routeIs('admin.mitras.*') ? 'text-orange-600 dark:text-orange-400 font-bold bg-orange-50 dark:bg-orange-950/50' : 'text-slate-600 dark:text-slate-300 hover:text-slate-900 dark:hover:text-white hover:bg-slate-50 dark:hover:bg-slate-800' }} px-3 py-2 rounded-xl transition inline-flex items-center gap-1.5">
                            <i class="fa-solid fa-building text-xs"></i> <span>Kelola Mitra</span>
                        </a>
                        <a href="{{ route('admin.settings.index') }}" class="{{ request()->routeIs('admin.settings.*') ? 'text-orange-600 dark:text-orange-400 font-bold bg-orange-50 dark:bg-orange-950/50' : 'text-slate-600 dark:text-slate-300 hover:text-slate-900 dark:hover:text-white hover:bg-slate-50 dark:hover:bg-slate-800' }} px-3 py-2 rounded-xl transition inline-flex items-center gap-1.5">
                            <i class="fa-solid fa-sliders text-xs"></i> <span>Halaman Awal</span>
                        </a>
                    @elseif(Auth::user()->isApproved())
                        <a href="{{ route('owner.dashboard') }}" class="{{ request()->routeIs('owner.dashboard') ? 'text-orange-600 dark:text-orange-400 font-bold bg-orange-50 dark:bg-orange-950/50' : 'text-slate-600 dark:text-slate-300 hover:text-slate-900 dark:hover:text-white hover:bg-slate-50 dark:hover:bg-slate-800' }} px-2.5 xl:px-3 py-2 rounded-xl transition inline-flex items-center gap-1.5">
                            <i class="fa-solid fa-gauge text-xs"></i> <span>Beranda</span>
                        </a>
                        <a href="{{ route('owner.hero.edit') }}" class="{{ request()->routeIs('owner.hero.*') ? 'text-orange-600 dark:text-orange-400 font-bold bg-orange-50 dark:bg-orange-950/50' : 'text-slate-600 dark:text-slate-300 hover:text-slate-900 dark:hover:text-white hover:bg-slate-50 dark:hover:bg-slate-800' }} px-2.5 xl:px-3 py-2 rounded-xl transition inline-flex items-center gap-1.5">
                            <i class="fa-solid fa-image text-xs"></i> <span>1. Sampul</span>
                        </a>
                        <a href="{{ route('owner.about.edit') }}" class="{{ request()->routeIs('owner.about.*') ? 'text-orange-600 dark:text-orange-400 font-bold bg-orange-50 dark:bg-orange-950/50' : 'text-slate-600 dark:text-slate-300 hover:text-slate-900 dark:hover:text-white hover:bg-slate-50 dark:hover:bg-slate-800' }} px-2.5 xl:px-3 py-2 rounded-xl transition inline-flex items-center gap-1.5">
                            <i class="fa-solid fa-circle-info text-xs"></i> <span>2. Tentang</span>
                        </a>
                        <a href="{{ route('owner.products.index') }}" class="{{ request()->routeIs('owner.products.*') ? 'text-orange-600 dark:text-orange-400 font-bold bg-orange-50 dark:bg-orange-950/50' : 'text-slate-600 dark:text-slate-300 hover:text-slate-900 dark:hover:text-white hover:bg-slate-50 dark:hover:bg-slate-800' }} px-2.5 xl:px-3 py-2 rounded-xl transition inline-flex items-center gap-1.5">
                            <i class="fa-solid fa-boxes-stacked text-xs"></i> <span>3. Produk</span>
                        </a>
                        <a href="{{ route('owner.contact.edit') }}" class="{{ request()->routeIs('owner.contact.*') ? 'text-orange-600 dark:text-orange-400 font-bold bg-orange-50 dark:bg-orange-950/50' : 'text-slate-600 dark:text-slate-300 hover:text-slate-900 dark:hover:text-white hover:bg-slate-50 dark:hover:bg-slate-800' }} px-2.5 xl:px-3 py-2 rounded-xl transition inline-flex items-center gap-1.5">
                            <i class="fa-solid fa-address-book text-xs"></i> <span>4. Kontak</span>
                        </a>
                        <a href="{{ route('owner.settings.edit') }}" class="{{ request()->routeIs('owner.settings.*') ? 'text-orange-600 dark:text-orange-400 font-bold bg-orange-50 dark:bg-orange-950/50' : 'text-slate-600 dark:text-slate-300 hover:text-slate-900 dark:hover:text-white hover:bg-slate-50 dark:hover:bg-slate-800' }} px-2.5 xl:px-3 py-2 rounded-xl transition inline-flex items-center gap-1.5">
                            <i class="fa-solid fa-gear text-xs"></i> <span>Pengaturan</span>
                        </a>
                    @else
                        <a href="{{ route('owner.status') }}" class="text-amber-600 dark:text-amber-400 font-bold px-3 py-2 rounded-xl bg-amber-50 dark:bg-amber-950/50 transition inline-flex items-center gap-1.5">
                            <i class="fa-solid fa-clock text-xs"></i> <span>Status Pendaftaran</span>
                        </a>
                    @endif
                </div>
            </div>

            <!-- Right Nav Actions (Desktop - lg and above) -->
            <div class="hidden lg:flex items-center gap-2 xl:gap-3">
                <!-- Theme Toggle Button -->
                <button type="button" @click="toggleTheme()"
                    class="w-9 h-9 rounded-xl flex items-center justify-center border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800 text-slate-600 dark:text-amber-400 hover:bg-slate-100 dark:hover:bg-slate-700 transition"
                    :title="isDark ? 'Beralih ke Mode Terang' : 'Beralih ke Mode Gelap'"
                    aria-label="Toggle tema terang/gelap">
                    <i class="fa-solid text-xs" :class="isDark ? 'fa-sun text-amber-400' : 'fa-moon text-slate-600'"></i>
                </button>

                @if(Auth::user()->isApproved() && Auth::user()->mitra)
                    <a href="{{ route('owner.preview') }}" target="_blank" class="inline-flex items-center gap-1.5 px-3 py-2 rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 hover:bg-slate-50 dark:hover:bg-slate-700 text-slate-700 dark:text-slate-200 text-xs font-semibold shadow-xs transition">
                        <i class="fa-regular fa-eye text-orange-600 dark:text-orange-400"></i>
                        <span class="hidden xl:inline">Pratinjau</span>
                    </a>
                @endif

                <!-- User Dropdown -->
                <div class="relative" x-data="{ open: false }" @click.away="open = false">
                    <button @click="open = ! open" class="inline-flex items-center gap-2 px-3 py-2 border border-slate-200 dark:border-slate-700 text-xs font-medium rounded-xl text-slate-700 dark:text-slate-200 bg-slate-50 dark:bg-slate-800 hover:bg-slate-100 dark:hover:bg-slate-700 focus:outline-none transition">
                        <div class="w-6 h-6 rounded-full bg-gradient-to-tr from-orange-600 to-amber-500 text-white flex items-center justify-center font-bold text-[10px] uppercase shadow-xs">
                            {{ substr(Auth::user()->name, 0, 1) }}
                        </div>
                        <div class="text-left max-w-[130px] xl:max-w-[170px] truncate">
                            <span class="font-bold text-slate-800 dark:text-slate-100 block leading-tight truncate">{{ Auth::user()->name }}</span>
                            <span class="text-[10px] text-slate-500 dark:text-slate-400 uppercase tracking-wider block truncate">
                                {{ Auth::user()->role === 'superadmin' ? 'Superadmin' : (Auth::user()->mitra ? Auth::user()->mitra->nama_usaha : 'Owner') }}
                            </span>
                        </div>
                        <i class="fa-solid fa-chevron-down text-[10px] text-slate-400 ml-1"></i>
                    </button>

                    <div x-show="open" x-cloak class="origin-top-right absolute right-0 mt-2 w-56 rounded-2xl shadow-xl py-1.5 bg-white dark:bg-slate-800 ring-1 ring-black ring-opacity-5 border border-slate-100 dark:border-slate-700 focus:outline-none z-50">
                        <div class="px-4 py-2.5 border-b border-slate-100 dark:border-slate-700 text-xs text-slate-500 dark:text-slate-400">
                            Masuk sebagai <strong class="block text-slate-800 dark:text-slate-200 truncate">{{ Auth::user()->email }}</strong>
                        </div>
                        <a href="{{ route('home') }}" class="block px-4 py-2 text-xs text-slate-700 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-700 flex items-center gap-2">
                            <i class="fa-solid fa-globe text-slate-400"></i> Lihat Portal Publik
                        </a>
                        @if(Auth::user()->isApproved() && Auth::user()->mitra)
                            <a href="{{ route('owner.preview') }}" target="_blank" class="block px-4 py-2 text-xs text-slate-700 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-700 flex items-center gap-2">
                                <i class="fa-regular fa-eye text-orange-600 dark:text-orange-400"></i> Buka Website Promosi
                            </a>
                        @endif
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="w-full text-left block px-4 py-2 text-xs text-rose-600 dark:text-rose-400 hover:bg-rose-50 dark:hover:bg-rose-950/40 font-semibold flex items-center gap-2">
                                <i class="fa-solid fa-right-from-bracket"></i> Keluar (Logout)
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Hamburger Button & Theme Toggle (Mobile & Tablet - below lg) -->
            <div class="flex items-center lg:hidden gap-1.5">
                <button type="button" @click="toggleTheme()" class="w-9 h-9 rounded-xl flex items-center justify-center border border-slate-200 dark:border-slate-700 text-slate-600 dark:text-amber-400 hover:bg-slate-100 dark:hover:bg-slate-800">
                    <i class="fa-solid text-xs" :class="isDark ? 'fa-sun text-amber-400' : 'fa-moon text-slate-600'"></i>
                </button>
                <button @click="open = ! open" class="w-9 h-9 rounded-xl flex items-center justify-center border border-slate-200 dark:border-slate-700 text-slate-700 dark:text-slate-200 hover:bg-slate-100 dark:hover:bg-slate-800 focus:outline-none">
                    <i class="fa-solid fa-bars text-base" x-show="!open"></i>
                    <i class="fa-solid fa-xmark text-base" x-show="open" x-cloak></i>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu (Mobile & Tablet Drawer) -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden lg:hidden border-t border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900 transition-all">
        <!-- User Info Strip -->
        <div class="p-4 bg-slate-50 dark:bg-slate-800/60 border-b border-slate-200 dark:border-slate-800 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 rounded-xl bg-gradient-to-tr from-orange-600 to-amber-500 text-white flex items-center justify-center font-bold text-sm uppercase shadow-xs">
                    {{ substr(Auth::user()->name, 0, 1) }}
                </div>
                <div class="leading-tight">
                    <div class="text-xs font-bold text-slate-900 dark:text-white">{{ Auth::user()->name }}</div>
                    <div class="text-[11px] text-slate-500 dark:text-slate-400">{{ Auth::user()->email }}</div>
                </div>
            </div>
            @if(Auth::user()->isApproved() && Auth::user()->mitra)
                <a href="{{ route('owner.preview') }}" target="_blank" class="px-3 py-1.5 rounded-lg bg-orange-600 text-white font-bold text-xs flex items-center gap-1 shadow-xs">
                    <i class="fa-regular fa-eye"></i> Pratinjau
                </a>
            @endif
        </div>

        <!-- Menu Links -->
        <div class="py-3 space-y-1 px-4">
            @if(Auth::user()->isSuperAdmin())
                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-2.5 py-2.5 px-3 rounded-xl text-sm font-semibold {{ request()->routeIs('admin.dashboard') ? 'bg-orange-50 dark:bg-orange-950/50 text-orange-600 dark:text-orange-400 font-bold' : 'text-slate-700 dark:text-slate-200 hover:bg-slate-50 dark:hover:bg-slate-800' }}">
                    <i class="fa-solid fa-chart-pie w-5 text-orange-600 dark:text-orange-400"></i> Ringkasan
                </a>
                <a href="{{ route('admin.verifications.index') }}" class="flex items-center justify-between py-2.5 px-3 rounded-xl text-sm font-semibold {{ request()->routeIs('admin.verifications.*') ? 'bg-orange-50 dark:bg-orange-950/50 text-orange-600 dark:text-orange-400 font-bold' : 'text-slate-700 dark:text-slate-200 hover:bg-slate-50 dark:hover:bg-slate-800' }}">
                    <span class="flex items-center gap-2.5">
                        <i class="fa-solid fa-user-check w-5 text-orange-600 dark:text-orange-400"></i> Verifikasi Pendaftar
                    </span>
                    @if($pendingCount > 0)
                        <span class="px-2 py-0.5 text-xs font-bold bg-amber-500 text-white rounded-full">{{ $pendingCount }}</span>
                    @endif
                </a>
                <a href="{{ route('admin.mitras.index') }}" class="flex items-center gap-2.5 py-2.5 px-3 rounded-xl text-sm font-semibold {{ request()->routeIs('admin.mitras.*') ? 'bg-orange-50 dark:bg-orange-950/50 text-orange-600 dark:text-orange-400 font-bold' : 'text-slate-700 dark:text-slate-200 hover:bg-slate-50 dark:hover:bg-slate-800' }}">
                    <i class="fa-solid fa-building w-5 text-orange-600 dark:text-orange-400"></i> Kelola Mitra
                </a>
                <a href="{{ route('admin.settings.index') }}" class="flex items-center gap-2.5 py-2.5 px-3 rounded-xl text-sm font-semibold {{ request()->routeIs('admin.settings.*') ? 'bg-orange-50 dark:bg-orange-950/50 text-orange-600 dark:text-orange-400 font-bold' : 'text-slate-700 dark:text-slate-200 hover:bg-slate-50 dark:hover:bg-slate-800' }}">
                    <i class="fa-solid fa-sliders w-5 text-orange-600 dark:text-orange-400"></i> Atur Halaman Awal
                </a>
            @elseif(Auth::user()->isApproved())
                <a href="{{ route('owner.dashboard') }}" class="flex items-center gap-2.5 py-2.5 px-3 rounded-xl text-sm font-semibold {{ request()->routeIs('owner.dashboard') ? 'bg-orange-50 dark:bg-orange-950/50 text-orange-600 dark:text-orange-400 font-bold' : 'text-slate-700 dark:text-slate-200 hover:bg-slate-50 dark:hover:bg-slate-800' }}">
                    <i class="fa-solid fa-gauge w-5 text-orange-600 dark:text-orange-400"></i> Beranda Editor
                </a>
                <a href="{{ route('owner.hero.edit') }}" class="flex items-center gap-2.5 py-2.5 px-3 rounded-xl text-sm font-semibold {{ request()->routeIs('owner.hero.*') ? 'bg-orange-50 dark:bg-orange-950/50 text-orange-600 dark:text-orange-400 font-bold' : 'text-slate-700 dark:text-slate-200 hover:bg-slate-50 dark:hover:bg-slate-800' }}">
                    <i class="fa-solid fa-image w-5 text-orange-600 dark:text-orange-400"></i> 1. Sampul (Hero)
                </a>
                <a href="{{ route('owner.about.edit') }}" class="flex items-center gap-2.5 py-2.5 px-3 rounded-xl text-sm font-semibold {{ request()->routeIs('owner.about.*') ? 'bg-orange-50 dark:bg-orange-950/50 text-orange-600 dark:text-orange-400 font-bold' : 'text-slate-700 dark:text-slate-200 hover:bg-slate-50 dark:hover:bg-slate-800' }}">
                    <i class="fa-solid fa-circle-info w-5 text-orange-600 dark:text-orange-400"></i> 2. Tentang & Profil
                </a>
                <a href="{{ route('owner.products.index') }}" class="flex items-center gap-2.5 py-2.5 px-3 rounded-xl text-sm font-semibold {{ request()->routeIs('owner.products.*') ? 'bg-orange-50 dark:bg-orange-950/50 text-orange-600 dark:text-orange-400 font-bold' : 'text-slate-700 dark:text-slate-200 hover:bg-slate-50 dark:hover:bg-slate-800' }}">
                    <i class="fa-solid fa-boxes-stacked w-5 text-orange-600 dark:text-orange-400"></i> 3. Katalog Produk
                </a>
                <a href="{{ route('owner.contact.edit') }}" class="flex items-center gap-2.5 py-2.5 px-3 rounded-xl text-sm font-semibold {{ request()->routeIs('owner.contact.*') ? 'bg-orange-50 dark:bg-orange-950/50 text-orange-600 dark:text-orange-400 font-bold' : 'text-slate-700 dark:text-slate-200 hover:bg-slate-50 dark:hover:bg-slate-800' }}">
                    <i class="fa-solid fa-address-book w-5 text-orange-600 dark:text-orange-400"></i> 4. Kontak & Lokasi
                </a>
                <a href="{{ route('owner.settings.edit') }}" class="flex items-center gap-2.5 py-2.5 px-3 rounded-xl text-sm font-semibold {{ request()->routeIs('owner.settings.*') ? 'bg-orange-50 dark:bg-orange-950/50 text-orange-600 dark:text-orange-400 font-bold' : 'text-slate-700 dark:text-slate-200 hover:bg-slate-50 dark:hover:bg-slate-800' }}">
                    <i class="fa-solid fa-gear w-5 text-orange-600 dark:text-orange-400"></i> Pengaturan Website
                </a>
            @else
                <a href="{{ route('owner.status') }}" class="flex items-center gap-2.5 py-2.5 px-3 rounded-xl text-sm font-bold text-amber-600 dark:text-amber-400 bg-amber-50 dark:bg-amber-950/50">
                    <i class="fa-solid fa-clock w-5"></i> Status Pendaftaran
                </a>
            @endif
        </div>

        <!-- Footer Actions -->
        <div class="p-4 border-t border-slate-200 dark:border-slate-800 flex items-center justify-between text-xs">
            <a href="{{ route('home') }}" class="text-slate-600 dark:text-slate-300 hover:text-orange-600 dark:hover:text-orange-400 font-semibold flex items-center gap-1.5">
                <i class="fa-solid fa-globe"></i> Portal Publik
            </a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="font-bold text-rose-600 dark:text-rose-400 hover:underline flex items-center gap-1">
                    <i class="fa-solid fa-right-from-bracket"></i> Keluar
                </button>
            </form>
        </div>
    </div>
</nav>
