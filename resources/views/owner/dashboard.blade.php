@extends('layouts.app')

@section('title', 'Dashboard Editor - ' . $mitra->nama_usaha)

@section('content')
<div class="w-full px-4 sm:px-6 lg:px-8 py-6 sm:py-8">

    <!-- Top Partner Hero Banner (Fully Responsive for Mobile, Tablet, Desktop) -->
    <div class="bg-gradient-to-r from-emerald-800 via-teal-800 to-slate-900 rounded-2xl sm:rounded-3xl p-5 sm:p-8 lg:p-10 text-white shadow-xl mb-8 relative overflow-hidden">
        <!-- Ambient decorative blur -->
        <div class="absolute -right-10 -bottom-10 w-64 h-64 bg-emerald-500/15 rounded-full blur-3xl pointer-events-none"></div>
        <div class="absolute -left-10 -top-10 w-48 h-48 bg-teal-400/10 rounded-full blur-3xl pointer-events-none"></div>

        <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-6 relative z-10">
            <!-- Avatar & Profile Details -->
            <div class="flex flex-col sm:flex-row items-start sm:items-center gap-4 sm:gap-6">
                <div class="shrink-0">
                    @if ($mitra->logo)
                        <img src="{{ asset('storage/' . $mitra->logo) }}" alt="{{ $mitra->nama_usaha }}" class="w-14 h-14 sm:w-20 sm:h-20 rounded-2xl object-cover bg-white p-1 shadow-md border-2 border-emerald-400">
                    @else
                        <div class="w-14 h-14 sm:w-20 sm:h-20 rounded-2xl bg-gradient-to-tr from-emerald-600 to-teal-500 border-2 border-emerald-400/60 text-white flex items-center justify-center font-black text-xl sm:text-2xl shadow-md">
                            {{ substr($mitra->nama_usaha, 0, 2) }}
                        </div>
                    @endif
                </div>

                <div class="min-w-0">
                    <!-- Badges -->
                    <div class="flex items-center gap-1.5 sm:gap-2 mb-2 flex-wrap">
                        <span class="px-2.5 py-0.5 rounded-full text-[10px] sm:text-[11px] font-bold uppercase tracking-wider bg-emerald-500/20 text-emerald-300 border border-emerald-400/30">
                            {{ $mitra->jenis }}
                        </span>
                        @if ($mitra->is_published)
                            <span class="px-2.5 py-0.5 rounded-full text-[10px] sm:text-[11px] font-bold bg-emerald-500 text-slate-950 flex items-center gap-1 shadow-xs">
                                <i class="fa-solid fa-globe text-[10px]"></i> Terpublikasi Live
                            </span>
                        @else
                            <span class="px-2.5 py-0.5 rounded-full text-[10px] sm:text-[11px] font-bold bg-amber-400 text-slate-950 flex items-center gap-1 shadow-xs">
                                <i class="fa-solid fa-file-pen text-[10px]"></i> Mode Draf
                            </span>
                        @endif
                        <span class="px-2.5 py-0.5 rounded-full text-[10px] sm:text-[11px] font-bold bg-emerald-400/20 text-emerald-200">
                            <i class="fa-solid fa-circle-check text-[10px] text-emerald-400 mr-0.5"></i> Terverifikasi PKM
                        </span>
                    </div>

                    <h1 class="text-xl sm:text-2xl lg:text-3xl font-extrabold tracking-tight text-white leading-tight truncate">
                        {{ $mitra->nama_usaha }}
                    </h1>
                    <p class="text-xs sm:text-sm text-slate-200 mt-1 max-w-xl line-clamp-2 leading-relaxed">
                        {{ $mitra->websiteContent?->tagline ?? 'Kelola 4 section website promosi Anda agar menarik minat calon pembeli.' }}
                    </p>
                </div>
            </div>

            <!-- Action Buttons: Pratinjau & Publikasi -->
            <div class="grid grid-cols-2 gap-2 sm:flex sm:items-center sm:gap-2.5 shrink-0 pt-2 lg:pt-0 border-t border-white/10 lg:border-t-0">
                <a href="{{ route('owner.preview') }}" target="_blank" class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl bg-white/10 hover:bg-white/20 backdrop-blur-sm text-white font-semibold text-xs sm:text-sm border border-white/20 transition shadow-xs">
                    <i class="fa-regular fa-eye text-emerald-300"></i>
                    <span>Pratinjau</span>
                </a>

                <form method="POST" action="{{ route('owner.settings.publish') }}" class="w-full sm:w-auto m-0">
                    @csrf
                    @if ($mitra->is_published)
                        <button type="submit" class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl bg-amber-500/20 hover:bg-amber-500/30 text-amber-200 font-semibold text-xs sm:text-sm border border-amber-400/30 transition">
                            <i class="fa-solid fa-pause"></i>
                            <span>Tarik ke Draf</span>
                        </button>
                    @else
                        <button type="submit" class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl bg-gradient-to-r from-emerald-500 to-teal-400 hover:from-emerald-400 hover:to-teal-300 text-slate-950 font-bold text-xs sm:text-sm shadow-lg shadow-emerald-500/30 transition">
                            <i class="fa-solid fa-cloud-arrow-up"></i>
                            <span>Publikasikan Live</span>
                        </button>
                    @endif
                </form>
            </div>
        </div>

        <!-- Live Website Share Bar (Smart Responsive Container) -->
        <div class="mt-6 sm:mt-8 pt-5 sm:pt-6 border-t border-white/10 flex flex-col md:flex-row md:items-center justify-between gap-3 text-xs">
            <div class="flex items-center gap-2 bg-black/25 backdrop-blur-sm border border-white/10 rounded-xl px-3 py-2 text-slate-300 min-w-0 overflow-hidden">
                <i class="fa-solid fa-link text-emerald-400 shrink-0"></i>
                <span class="font-bold text-white shrink-0 hidden sm:inline">Tautan Website:</span>
                <a href="{{ route('mitra.show', ['slug' => $mitra->slug]) }}" target="_blank" class="font-mono text-emerald-300 hover:underline truncate">
                    {{ url('/mitra/' . $mitra->slug) }}
                </a>
            </div>

            <div class="grid grid-cols-2 gap-2 sm:flex sm:items-center sm:gap-2 shrink-0" x-data="{ copied: false }">
                <button @click="navigator.clipboard.writeText('{{ url('/mitra/' . $mitra->slug) }}'); copied = true; setTimeout(() => copied = false, 2500)"
                    class="w-full sm:w-auto inline-flex items-center justify-center gap-1.5 px-3.5 py-2 rounded-xl bg-white/10 hover:bg-white/20 text-white font-medium text-xs transition border border-white/10">
                    <i class="fa-regular fa-copy" x-show="!copied"></i>
                    <i class="fa-solid fa-check text-emerald-300" x-show="copied" x-cloak></i>
                    <span x-text="copied ? 'Tersalin!' : 'Salin Tautan'">Salin Tautan</span>
                </button>
                <a href="https://api.whatsapp.com/send?text={{ urlencode('Kunjungi etalase resmi ' . $mitra->nama_usaha . ': ' . url('/mitra/' . $mitra->slug)) }}" target="_blank"
                    class="w-full sm:w-auto inline-flex items-center justify-center gap-1.5 px-3.5 py-2 rounded-xl bg-gradient-to-r from-emerald-500 to-teal-400 hover:from-emerald-400 hover:to-teal-300 text-slate-950 font-bold text-xs transition shadow-sm">
                    <i class="fa-brands fa-whatsapp text-sm"></i>
                    <span>Bagikan ke WhatsApp</span>
                </a>
            </div>
        </div>
    </div>

    <!-- 4 Section Editor Menu Cards (1 Col Mobile, 2 Cols Tablet, 4 Cols Desktop) -->
    <div class="mb-10">
        <div class="mb-5">
            <h2 class="text-xl sm:text-2xl font-bold text-slate-900 dark:text-white tracking-tight">Kelola 4 Section Website Promosi</h2>
            <p class="text-xs sm:text-sm text-slate-500 dark:text-slate-400 mt-0.5">Sesuaikan setiap bagian halaman promosi Anda agar menarik bagi calon pembeli.</p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6">

            <!-- KARTU 1: SECTION BERANDA / HERO -->
            <div class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-200 dark:border-slate-800 shadow-xs hover:shadow-lg dark:hover:shadow-emerald-950/40 hover:border-emerald-300 dark:hover:border-emerald-700 transition-all p-5 sm:p-6 flex flex-col justify-between group">
                <div>
                    <div class="flex items-center justify-between mb-3.5">
                        <span class="w-8 h-8 rounded-xl bg-emerald-100 dark:bg-emerald-950/60 text-emerald-700 dark:text-emerald-300 font-extrabold text-sm flex items-center justify-center shadow-xs">1</span>
                        <span class="text-[11px] font-bold px-2.5 py-0.5 rounded-lg {{ !empty($mitra->websiteContent?->judul) ? 'bg-emerald-50 dark:bg-emerald-950/50 text-emerald-700 dark:text-emerald-300 border border-emerald-200/60 dark:border-emerald-800/60' : 'bg-slate-100 dark:bg-slate-800 text-slate-500 dark:text-slate-400' }}">
                            {{ !empty($mitra->websiteContent?->judul) ? 'Terisi' : 'Kosong' }}
                        </span>
                    </div>
                    <h3 class="font-bold text-slate-900 dark:text-white text-base sm:text-lg mb-1 group-hover:text-emerald-600 dark:group-hover:text-emerald-400 transition">Beranda & Sampul</h3>
                    <p class="text-xs text-slate-500 dark:text-slate-400 leading-relaxed mb-5 min-h-[2.5rem]">
                        Atur judul utama, tagline usaha, dan gambar sampul utama (hero banner).
                    </p>
                </div>
                <a href="{{ route('owner.hero.edit') }}" class="w-full inline-flex items-center justify-center gap-1.5 py-2.5 px-3 rounded-xl bg-slate-50 dark:bg-slate-800 hover:bg-emerald-600 hover:text-white dark:hover:bg-emerald-600 text-slate-700 dark:text-slate-200 text-xs font-bold transition border border-slate-200 dark:border-slate-700 hover:border-emerald-600 shadow-2xs">
                    <i class="fa-solid fa-pen-to-square"></i> Edit Section 1 &rarr;
                </a>
            </div>

            <!-- KARTU 2: SECTION TENTANG -->
            <div class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-200 dark:border-slate-800 shadow-xs hover:shadow-lg dark:hover:shadow-teal-950/40 hover:border-teal-300 dark:hover:border-teal-700 transition-all p-5 sm:p-6 flex flex-col justify-between group">
                <div>
                    <div class="flex items-center justify-between mb-3.5">
                        <span class="w-8 h-8 rounded-xl bg-teal-100 dark:bg-teal-950/60 text-teal-700 dark:text-teal-300 font-extrabold text-sm flex items-center justify-center shadow-xs">2</span>
                        <span class="text-[11px] font-bold px-2.5 py-0.5 rounded-lg {{ !empty($mitra->websiteContent?->deskripsi) ? 'bg-emerald-50 dark:bg-emerald-950/50 text-emerald-700 dark:text-emerald-300 border border-emerald-200/60 dark:border-emerald-800/60' : 'bg-slate-100 dark:bg-slate-800 text-slate-500 dark:text-slate-400' }}">
                            {{ !empty($mitra->websiteContent?->deskripsi) ? 'Terisi' : 'Kosong' }}
                        </span>
                    </div>
                    <h3 class="font-bold text-slate-900 dark:text-white text-base sm:text-lg mb-1 group-hover:text-teal-600 dark:group-hover:text-teal-400 transition">Tentang & Visi Misi</h3>
                    <p class="text-xs text-slate-500 dark:text-slate-400 leading-relaxed mb-5 min-h-[2.5rem]">
                        Tuliskan profil lengkap usaha, sejarah berdiri, serta visi & misi usaha Anda.
                    </p>
                </div>
                <a href="{{ route('owner.about.edit') }}" class="w-full inline-flex items-center justify-center gap-1.5 py-2.5 px-3 rounded-xl bg-slate-50 dark:bg-slate-800 hover:bg-teal-600 hover:text-white dark:hover:bg-teal-600 text-slate-700 dark:text-slate-200 text-xs font-bold transition border border-slate-200 dark:border-slate-700 hover:border-teal-600 shadow-2xs">
                    <i class="fa-solid fa-pen-to-square"></i> Edit Section 2 &rarr;
                </a>
            </div>

            <!-- KARTU 3: SECTION PRODUK / GALERI -->
            <div class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-200 dark:border-slate-800 shadow-xs hover:shadow-lg dark:hover:shadow-indigo-950/40 hover:border-indigo-300 dark:hover:border-indigo-700 transition-all p-5 sm:p-6 flex flex-col justify-between group">
                <div>
                    <div class="flex items-center justify-between mb-3.5">
                        <span class="w-8 h-8 rounded-xl bg-indigo-100 dark:bg-indigo-950/60 text-indigo-700 dark:text-indigo-300 font-extrabold text-sm flex items-center justify-center shadow-xs">3</span>
                        <span class="text-[11px] font-bold px-2.5 py-0.5 rounded-lg bg-indigo-50 dark:bg-indigo-950/50 text-indigo-700 dark:text-indigo-300 border border-indigo-200/60 dark:border-indigo-800/60">
                            {{ $totalProducts }} Produk
                        </span>
                    </div>
                    <h3 class="font-bold text-slate-900 dark:text-white text-base sm:text-lg mb-1 group-hover:text-indigo-600 dark:group-hover:text-indigo-400 transition">Produk & Galeri</h3>
                    <p class="text-xs text-slate-500 dark:text-slate-400 leading-relaxed mb-5 min-h-[2.5rem]">
                        Kelola katalog produk, foto resolusi tinggi, deskripsi, harga, dan urutan etalase.
                    </p>
                </div>
                <a href="{{ route('owner.products.index') }}" class="w-full inline-flex items-center justify-center gap-1.5 py-2.5 px-3 rounded-xl bg-slate-50 dark:bg-slate-800 hover:bg-indigo-600 hover:text-white dark:hover:bg-indigo-600 text-slate-700 dark:text-slate-200 text-xs font-bold transition border border-slate-200 dark:border-slate-700 hover:border-indigo-600 shadow-2xs">
                    <i class="fa-solid fa-boxes-stacked"></i> Kelola Produk ({{ $totalProducts }}) &rarr;
                </a>
            </div>

            <!-- KARTU 4: SECTION KONTAK & LOKASI -->
            <div class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-200 dark:border-slate-800 shadow-xs hover:shadow-lg dark:hover:shadow-amber-950/40 hover:border-amber-300 dark:hover:border-amber-700 transition-all p-5 sm:p-6 flex flex-col justify-between group">
                <div>
                    <div class="flex items-center justify-between mb-3.5">
                        <span class="w-8 h-8 rounded-xl bg-amber-100 dark:bg-amber-950/60 text-amber-700 dark:text-amber-300 font-extrabold text-sm flex items-center justify-center shadow-xs">4</span>
                        <span class="text-[11px] font-bold px-2.5 py-0.5 rounded-lg {{ !empty($mitra->contact?->whatsapp) ? 'bg-emerald-50 dark:bg-emerald-950/50 text-emerald-700 dark:text-emerald-300 border border-emerald-200/60 dark:border-emerald-800/60' : 'bg-rose-50 dark:bg-rose-950/50 text-rose-700 dark:text-rose-300 border border-rose-200/60 dark:border-rose-800/60' }}">
                            {{ !empty($mitra->contact?->whatsapp) ? 'WhatsApp Siap' : 'Perlu WA' }}
                        </span>
                    </div>
                    <h3 class="font-bold text-slate-900 dark:text-white text-base sm:text-lg mb-1 group-hover:text-amber-600 dark:group-hover:text-amber-400 transition">Kontak & Lokasi</h3>
                    <p class="text-xs text-slate-500 dark:text-slate-400 leading-relaxed mb-5 min-h-[2.5rem]">
                        Atur nomor WhatsApp direct, alamat, jam operasional, medsos, dan peta Google Maps.
                    </p>
                </div>
                <a href="{{ route('owner.contact.edit') }}" class="w-full inline-flex items-center justify-center gap-1.5 py-2.5 px-3 rounded-xl bg-slate-50 dark:bg-slate-800 hover:bg-amber-600 hover:text-white dark:hover:bg-amber-600 text-slate-700 dark:text-slate-200 text-xs font-bold transition border border-slate-200 dark:border-slate-700 hover:border-amber-600 shadow-2xs">
                    <i class="fa-solid fa-address-book"></i> Edit Section 4 &rarr;
                </a>
            </div>

        </div>
    </div>

    <!-- Quick Settings & Status Guide (1 Col Mobile, 3 Cols Tablet/Desktop) -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 sm:gap-6">
        <!-- Settings Quick Link -->
        <div class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-200 dark:border-slate-800 shadow-xs p-5 sm:p-6 transition flex flex-col justify-between">
            <div>
                <h3 class="text-sm font-bold text-slate-900 dark:text-white mb-2 flex items-center gap-2">
                    <div class="w-7 h-7 rounded-lg bg-emerald-100 dark:bg-emerald-950/60 text-emerald-600 dark:text-emerald-400 flex items-center justify-center text-xs">
                        <i class="fa-solid fa-sliders"></i>
                    </div>
                    <span>Pengaturan Website & URL</span>
                </h3>
                <p class="text-xs text-slate-500 dark:text-slate-400 leading-relaxed mb-4">
                    Ubah kustomisasi slug URL (misal: <code class="font-mono text-emerald-600 dark:text-emerald-400 bg-slate-100 dark:bg-slate-800 px-1 py-0.5 rounded">/mitra/{{ $mitra->slug }}</code>) dan status aktifasi website.
                </p>
            </div>
            <a href="{{ route('owner.settings.edit') }}" class="text-xs font-bold text-emerald-600 dark:text-emerald-400 hover:underline inline-flex items-center gap-1">
                Buka Pengaturan Website &rarr;
            </a>
        </div>

        <!-- WhatsApp Direct Info -->
        <div class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-200 dark:border-slate-800 shadow-xs p-5 sm:p-6 transition flex flex-col justify-between">
            <div>
                <h3 class="text-sm font-bold text-slate-900 dark:text-white mb-2 flex items-center gap-2">
                    <div class="w-7 h-7 rounded-lg bg-emerald-100 dark:bg-emerald-950/60 text-emerald-600 dark:text-emerald-400 flex items-center justify-center text-xs">
                        <i class="fa-brands fa-whatsapp"></i>
                    </div>
                    <span>Tombol WhatsApp Direct</span>
                </h3>
                <p class="text-xs text-slate-500 dark:text-slate-400 leading-relaxed mb-2">
                    Setiap pengunjung yang tertarik dengan produk Anda di website promosi dapat langsung menghubungi nomor WhatsApp Anda secara instan:
                </p>
            </div>
            <div class="pt-2">
                <span class="font-bold text-emerald-700 dark:text-emerald-300 text-xs bg-emerald-50 dark:bg-emerald-950/50 border border-emerald-200 dark:border-emerald-800/60 px-3 py-1.5 rounded-xl inline-block">
                    {{ $mitra->contact?->whatsapp ? '+' . $mitra->contact->whatsapp : 'Belum diatur' }}
                </span>
            </div>
        </div>

        <!-- System Notifications -->
        <div class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-200 dark:border-slate-800 shadow-xs p-5 sm:p-6 transition flex flex-col justify-between">
            <div>
                <h3 class="text-sm font-bold text-slate-900 dark:text-white mb-2 flex items-center gap-2">
                    <div class="w-7 h-7 rounded-lg bg-emerald-100 dark:bg-emerald-950/60 text-emerald-600 dark:text-emerald-400 flex items-center justify-center text-xs">
                        <i class="fa-regular fa-bell"></i>
                    </div>
                    <span>Notifikasi Terkini</span>
                </h3>
                @if ($notifications->count() > 0)
                    <div class="space-y-2 text-xs">
                        @foreach ($notifications->take(2) as $notif)
                            <div class="p-2.5 bg-slate-50 dark:bg-slate-800/60 rounded-xl text-slate-700 dark:text-slate-300 border border-slate-100 dark:border-slate-700/60">
                                {{ $notif->data['message'] ?? 'Pemberitahuan akun' }}
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-xs text-slate-400 dark:text-slate-500">Tidak ada notifikasi baru saat ini.</p>
                @endif
            </div>
            <span class="text-[11px] text-slate-400 dark:text-slate-500 block pt-2">
                Status sistem berjalan normal
            </span>
        </div>
    </div>

</div>
@endsection
