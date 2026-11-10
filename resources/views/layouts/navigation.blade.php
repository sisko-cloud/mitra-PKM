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
                        <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'text-orange-600 dark:text-orange-400 font-bold bg-orange-50 dark:bg-orange-950/50' : 'text-slate-600 dark:text-slate-300 hover:text-slate-900 dark:hover:text-white hover:bg-slate-50 dark:hover:bg-slate-800' }} px-3 py-2 rounded-xl transition inline-flex items-center gap-1.5 whitespace-nowrap">
                            <i class="fa-solid fa-chart-pie text-xs"></i> <span>Ringkasan</span>
                        </a>
                        <a href="{{ route('admin.verifications.index') }}" class="{{ request()->routeIs('admin.verifications.*') ? 'text-orange-600 dark:text-orange-400 font-bold bg-orange-50 dark:bg-orange-950/50' : 'text-slate-600 dark:text-slate-300 hover:text-slate-900 dark:hover:text-white hover:bg-slate-50 dark:hover:bg-slate-800' }} px-3 py-2 rounded-xl transition inline-flex items-center gap-1.5 relative whitespace-nowrap">
                            <i class="fa-solid fa-user-check text-xs"></i> <span>Verifikasi</span>
                            @php
                                $pendingCount = \App\Models\User::where('role', 'owner')->where('status', 'pending')->count();
                            @endphp
                            @if($pendingCount > 0)
                                <span class="px-1.5 py-0.5 text-[10px] font-bold bg-amber-500 text-white rounded-full">{{ $pendingCount }}</span>
                            @endif
                        </a>
                        <a href="{{ route('admin.mitras.index') }}" class="{{ request()->routeIs('admin.mitras.*') ? 'text-orange-600 dark:text-orange-400 font-bold bg-orange-50 dark:bg-orange-950/50' : 'text-slate-600 dark:text-slate-300 hover:text-slate-900 dark:hover:text-white hover:bg-slate-50 dark:hover:bg-slate-800' }} px-3 py-2 rounded-xl transition inline-flex items-center gap-1.5 whitespace-nowrap">
                            <i class="fa-solid fa-building text-xs"></i> <span>Kelola Mitra</span>
                        </a>
                        <a href="{{ route('admin.settings.index') }}" class="{{ request()->routeIs('admin.settings.*') ? 'text-orange-600 dark:text-orange-400 font-bold bg-orange-50 dark:bg-orange-950/50' : 'text-slate-600 dark:text-slate-300 hover:text-slate-900 dark:hover:text-white hover:bg-slate-50 dark:hover:bg-slate-800' }} px-3 py-2 rounded-xl transition inline-flex items-center gap-1.5 whitespace-nowrap">
                            <i class="fa-solid fa-sliders text-xs"></i> <span>Halaman Awal</span>
                        </a>
                    @elseif(Auth::user()->isApproved())
                        <a href="{{ route('owner.dashboard') }}" class="{{ request()->routeIs('owner.dashboard') ? 'text-orange-600 dark:text-orange-400 font-bold bg-orange-50 dark:bg-orange-950/50' : 'text-slate-600 dark:text-slate-300 hover:text-slate-900 dark:hover:text-white hover:bg-slate-50 dark:hover:bg-slate-800' }} px-2.5 xl:px-3 py-2 rounded-xl transition inline-flex items-center gap-1.5 whitespace-nowrap">
                            <i class="fa-solid fa-gauge text-xs"></i> <span>Beranda</span>
                        </a>
                        <a href="{{ route('owner.hero.edit') }}" class="{{ request()->routeIs('owner.hero.*') ? 'text-orange-600 dark:text-orange-400 font-bold bg-orange-50 dark:bg-orange-950/50' : 'text-slate-600 dark:text-slate-300 hover:text-slate-900 dark:hover:text-white hover:bg-slate-50 dark:hover:bg-slate-800' }} px-2.5 xl:px-3 py-2 rounded-xl transition inline-flex items-center gap-1.5 whitespace-nowrap">
                            <i class="fa-solid fa-image text-xs"></i> <span>Sampul</span>
                        </a>
                        <a href="{{ route('owner.about.edit') }}" class="{{ request()->routeIs('owner.about.*') ? 'text-orange-600 dark:text-orange-400 font-bold bg-orange-50 dark:bg-orange-950/50' : 'text-slate-600 dark:text-slate-300 hover:text-slate-900 dark:hover:text-white hover:bg-slate-50 dark:hover:bg-slate-800' }} px-2.5 xl:px-3 py-2 rounded-xl transition inline-flex items-center gap-1.5 whitespace-nowrap">
                            <i class="fa-solid fa-circle-info text-xs"></i> <span>Tentang</span>
                        </a>
                        <a href="{{ route('owner.products.index') }}" class="{{ request()->routeIs('owner.products.*') ? 'text-orange-600 dark:text-orange-400 font-bold bg-orange-50 dark:bg-orange-950/50' : 'text-slate-600 dark:text-slate-300 hover:text-slate-900 dark:hover:text-white hover:bg-slate-50 dark:hover:bg-slate-800' }} px-2.5 xl:px-3 py-2 rounded-xl transition inline-flex items-center gap-1.5 whitespace-nowrap">
                            <i class="fa-solid fa-boxes-stacked text-xs"></i> <span>Produk</span>
                        </a>
                        <a href="{{ route('owner.contact.edit') }}" class="{{ request()->routeIs('owner.contact.*') ? 'text-orange-600 dark:text-orange-400 font-bold bg-orange-50 dark:bg-orange-950/50' : 'text-slate-600 dark:text-slate-300 hover:text-slate-900 dark:hover:text-white hover:bg-slate-50 dark:hover:bg-slate-800' }} px-2.5 xl:px-3 py-2 rounded-xl transition inline-flex items-center gap-1.5 whitespace-nowrap">
                            <i class="fa-solid fa-address-book text-xs"></i> <span>Kontak</span>
                        </a>
                        <a href="{{ route('owner.settings.edit') }}" class="{{ request()->routeIs('owner.settings.*') ? 'text-orange-600 dark:text-orange-400 font-bold bg-orange-50 dark:bg-orange-950/50' : 'text-slate-600 dark:text-slate-300 hover:text-slate-900 dark:hover:text-white hover:bg-slate-50 dark:hover:bg-slate-800' }} px-2.5 xl:px-3 py-2 rounded-xl transition inline-flex items-center gap-1.5 whitespace-nowrap">
                            <i class="fa-solid fa-gear text-xs"></i> <span>Pengaturan</span>
                        </a>
                    @else
                        <a href="{{ route('owner.status') }}" class="text-amber-600 dark:text-amber-400 font-bold px-3 py-2 rounded-xl bg-amber-50 dark:bg-amber-950/50 transition inline-flex items-center gap-1.5 whitespace-nowrap">
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
                    <a href="{{ route('owner.preview') }}" target="_blank" class="inline-flex items-center gap-1.5 px-3 py-2 rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 hover:bg-slate-50 dark:hover:bg-slate-700 text-slate-700 dark:text-slate-200 text-xs font-semibold shadow-xs transition whitespace-nowrap">
                        <i class="fa-regular fa-eye text-orange-600 dark:text-orange-400"></i>
                        <span class="hidden xl:inline">Pratinjau</span>
                    </a>
                @endif

                <!-- User Dropdown (Single Line Clean Profile) -->
                <div class="relative" x-data="{ open: false }" @click.away="open = false">
                    <button @click="open = ! open" class="inline-flex items-center gap-2 px-3 py-1.5 border border-slate-200 dark:border-slate-700 text-xs font-semibold rounded-xl text-slate-700 dark:text-slate-200 bg-slate-50 dark:bg-slate-800 hover:bg-slate-100 dark:hover:bg-slate-700 focus:outline-none transition whitespace-nowrap">
                        @if(Auth::user()->avatar_url)
                            <img src="{{ Auth::user()->avatar_url }}" alt="{{ Auth::user()->name }}" class="w-6 h-6 rounded-full object-cover border border-orange-300 dark:border-orange-500 shadow-xs shrink-0">
                        @else
                            <div class="w-6 h-6 rounded-full bg-gradient-to-tr from-orange-600 to-amber-500 text-white flex items-center justify-center font-bold text-[10px] uppercase shadow-xs shrink-0">
                                {{ substr(Auth::user()->name, 0, 1) }}
                            </div>
                        @endif
                        <span class="font-bold text-slate-800 dark:text-slate-100 max-w-[130px] xl:max-w-[170px] truncate leading-none">{{ Auth::user()->name }}</span>
                        <i class="fa-solid fa-chevron-down text-[10px] text-slate-400 ml-0.5"></i>
                    </button>

                    <div x-show="open" x-cloak class="origin-top-right absolute right-0 mt-2 w-60 rounded-2xl shadow-xl py-1.5 bg-white dark:bg-slate-800 ring-1 ring-black ring-opacity-5 border border-slate-100 dark:border-slate-700 focus:outline-none z-50">
                        <div class="px-4 py-2.5 border-b border-slate-100 dark:border-slate-700 text-xs text-slate-500 dark:text-slate-400">
                            Masuk sebagai <strong class="block text-slate-800 dark:text-slate-200 truncate">{{ Auth::user()->name }}</strong>
                            <span class="text-[11px] text-slate-400 dark:text-slate-500 block truncate">{{ Auth::user()->email }}</span>
                        </div>
                        <a href="{{ route('profile.edit') }}" class="block px-4 py-2.5 text-xs text-slate-700 dark:text-slate-200 hover:bg-orange-50 dark:hover:bg-slate-700/80 hover:text-orange-600 dark:hover:text-orange-400 font-semibold flex items-center gap-2.5 transition">
                            <i class="fa-solid fa-user-pen text-orange-600 dark:text-orange-400"></i> Edit Profil & Foto
                        </a>
                        <a href="{{ route('home') }}" class="block px-4 py-2 text-xs text-slate-700 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-700 flex items-center gap-2.5 transition">
                            <i class="fa-solid fa-globe text-slate-400"></i> Lihat Portal Publik
                        </a>
                        @if(Auth::user()->isApproved() && Auth::user()->mitra)
                            <a href="{{ route('owner.preview') }}" target="_blank" class="block px-4 py-2 text-xs text-slate-700 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-700 flex items-center gap-2.5 transition">
                                <i class="fa-regular fa-eye text-orange-600 dark:text-orange-400"></i> Buka Website Promosi
                            </a>
                        @endif
                        <div class="border-t border-slate-100 dark:border-slate-700 my-1"></div>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="w-full text-left block px-4 py-2 text-xs text-rose-600 dark:text-rose-400 hover:bg-rose-50 dark:hover:bg-rose-950/40 font-semibold flex items-center gap-2.5 transition">
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
            <div class="flex items-center gap-3 min-w-0">
                @if(Auth::user()->avatar_url)
                    <img src="{{ Auth::user()->avatar_url }}" alt="{{ Auth::user()->name }}" class="w-10 h-10 rounded-xl object-cover border border-orange-300 dark:border-orange-500 shadow-xs shrink-0">
                @else
                    <div class="w-10 h-10 rounded-xl bg-gradient-to-tr from-orange-600 to-amber-500 text-white flex items-center justify-center font-bold text-sm uppercase shadow-xs shrink-0">
                        {{ substr(Auth::user()->name, 0, 1) }}
                    </div>
                @endif
                <div class="leading-tight min-w-0">
                    <div class="text-xs font-bold text-slate-900 dark:text-white truncate">{{ Auth::user()->name }}</div>
                    <div class="text-[11px] text-slate-500 dark:text-slate-400 truncate">{{ Auth::user()->email }}</div>
                </div>
            </div>
            <div class="flex items-center gap-1.5 shrink-0">
                <a href="{{ route('profile.edit') }}" class="px-2.5 py-1.5 rounded-lg bg-orange-50 dark:bg-orange-950/50 text-orange-600 dark:text-orange-400 border border-orange-200/60 dark:border-orange-800/60 font-bold text-xs flex items-center gap-1 shadow-xs">
                    <i class="fa-solid fa-user-pen"></i> Profil
                </a>
                @if(Auth::user()->isApproved() && Auth::user()->mitra)
                    <a href="{{ route('owner.preview') }}" target="_blank" class="px-2.5 py-1.5 rounded-lg bg-orange-600 text-white font-bold text-xs flex items-center gap-1 shadow-xs">
                        <i class="fa-regular fa-eye"></i> Pratinjau
                    </a>
                @endif
            </div>
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
                    <i class="fa-solid fa-image w-5 text-orange-600 dark:text-orange-400"></i> Sampul
                </a>
                <a href="{{ route('owner.about.edit') }}" class="flex items-center gap-2.5 py-2.5 px-3 rounded-xl text-sm font-semibold {{ request()->routeIs('owner.about.*') ? 'bg-orange-50 dark:bg-orange-950/50 text-orange-600 dark:text-orange-400 font-bold' : 'text-slate-700 dark:text-slate-200 hover:bg-slate-50 dark:hover:bg-slate-800' }}">
                    <i class="fa-solid fa-circle-info w-5 text-orange-600 dark:text-orange-400"></i> Tentang
                </a>
                <a href="{{ route('owner.products.index') }}" class="flex items-center gap-2.5 py-2.5 px-3 rounded-xl text-sm font-semibold {{ request()->routeIs('owner.products.*') ? 'bg-orange-50 dark:bg-orange-950/50 text-orange-600 dark:text-orange-400 font-bold' : 'text-slate-700 dark:text-slate-200 hover:bg-slate-50 dark:hover:bg-slate-800' }}">
                    <i class="fa-solid fa-boxes-stacked w-5 text-orange-600 dark:text-orange-400"></i> Produk
                </a>
                <a href="{{ route('owner.contact.edit') }}" class="flex items-center gap-2.5 py-2.5 px-3 rounded-xl text-sm font-semibold {{ request()->routeIs('owner.contact.*') ? 'bg-orange-50 dark:bg-orange-950/50 text-orange-600 dark:text-orange-400 font-bold' : 'text-slate-700 dark:text-slate-200 hover:bg-slate-50 dark:hover:bg-slate-800' }}">
                    <i class="fa-solid fa-address-book w-5 text-orange-600 dark:text-orange-400"></i> Kontak
                </a>
                <a href="{{ route('owner.settings.edit') }}" class="flex items-center gap-2.5 py-2.5 px-3 rounded-xl text-sm font-semibold {{ request()->routeIs('owner.settings.*') ? 'bg-orange-50 dark:bg-orange-950/50 text-orange-600 dark:text-orange-400 font-bold' : 'text-slate-700 dark:text-slate-200 hover:bg-slate-50 dark:hover:bg-slate-800' }}">
                    <i class="fa-solid fa-gear w-5 text-orange-600 dark:text-orange-400"></i> Pengaturan Website
                </a>
            @else
                <a href="{{ route('owner.status') }}" class="flex items-center gap-2.5 py-2.5 px-3 rounded-xl text-sm font-bold text-amber-600 dark:text-amber-400 bg-amber-50 dark:bg-amber-950/50">
                    <i class="fa-solid fa-clock w-5"></i> Status Pendaftaran
                </a>
            @endif

            <a href="{{ route('profile.edit') }}" class="flex items-center gap-2.5 py-2.5 px-3 rounded-xl text-sm font-semibold {{ request()->routeIs('profile.*') ? 'bg-orange-50 dark:bg-orange-950/50 text-orange-600 dark:text-orange-400 font-bold' : 'text-slate-700 dark:text-slate-200 hover:bg-slate-50 dark:hover:bg-slate-800' }}">
                <i class="fa-solid fa-user-pen w-5 text-orange-600 dark:text-orange-400"></i> Edit Profil & Foto
            </a>
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
