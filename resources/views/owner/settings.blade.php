@extends('layouts.app')

@section('title', 'Pengaturan Website & Tautan')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

    <!-- Breadcrumb & Back -->
    <div class="mb-6 flex items-center justify-between">
        <a href="{{ route('owner.dashboard') }}" class="inline-flex items-center gap-1.5 text-xs font-semibold text-slate-500 hover:text-emerald-600 transition">
            <i class="fa-solid fa-arrow-left"></i> Kembali ke Dashboard
        </a>
        <a href="{{ route('owner.preview') }}" target="_blank" class="text-xs font-semibold text-emerald-600 hover:underline">
            <i class="fa-regular fa-eye mr-1"></i> Buka Pratinjau Website
        </a>
    </div>

    <!-- Tautan & Berbagi Promosi Card -->
    <div class="bg-gradient-to-tr from-slate-900 to-emerald-950 text-white rounded-2xl shadow-md p-6 sm:p-8 mb-8 border border-emerald-900/50">
        <h2 class="text-lg font-bold mb-2 flex items-center gap-2">
            <i class="fa-solid fa-share-nodes text-emerald-400"></i> Tautan Website & Bagikan ke Publik
        </h2>
        <p class="text-xs sm:text-sm text-slate-300 leading-relaxed mb-5">
            Website promosi Anda dapat diakses oleh siapa saja tanpa perlu masuk (login). Bagikan link ini ke pelanggan, kartu nama, atau media sosial Anda.
        </p>

        <div class="bg-white/10 border border-white/20 rounded-xl p-3 sm:p-4 flex flex-col sm:flex-row sm:items-center justify-between gap-3 mb-4">
            <div class="font-mono text-xs sm:text-sm text-emerald-300 break-all select-all font-semibold">
                {{ $publicUrl }}
            </div>
            <div class="flex items-center gap-2 shrink-0" x-data="{ copied: false }">
                <button @click="navigator.clipboard.writeText('{{ $publicUrl }}'); copied = true; setTimeout(() => copied = false, 2500)"
                    class="px-3.5 py-2 rounded-lg bg-white/20 hover:bg-white/30 text-white font-bold text-xs transition flex items-center gap-1.5">
                    <i class="fa-regular fa-copy" x-show="!copied"></i>
                    <i class="fa-solid fa-check text-emerald-300" x-show="copied" x-cloak></i>
                    <span x-text="copied ? 'Tersalin!' : 'Salin Link'">Salin Link</span>
                </button>
                <a href="{{ $waShareUrl }}" target="_blank"
                    class="px-3.5 py-2 rounded-lg bg-emerald-500 hover:bg-emerald-600 text-slate-950 font-bold text-xs transition flex items-center gap-1.5">
                    <i class="fa-brands fa-whatsapp text-sm"></i> Bagikan ke WhatsApp
                </a>
            </div>
        </div>

        <div class="flex items-center gap-2 text-[11px] text-slate-400">
            <i class="fa-solid fa-circle-check text-emerald-400"></i>
            <span>Telah dioptimasi dengan Open Graph tags: judul, deskripsi, dan foto otomatis muncul saat dibagikan ke WhatsApp dan sosmed.</span>
        </div>
    </div>

    <!-- Status Publikasi & Pengaturan Slug Card -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 sm:p-8 space-y-8">

        <!-- Form Slug & Status Aktif -->
        <form method="POST" action="{{ route('owner.settings.update') }}" class="space-y-6">
            @csrf

            <div class="flex items-center gap-3 pb-4 border-b border-slate-200">
                <div class="w-10 h-10 rounded-xl bg-slate-100 text-slate-700 flex items-center justify-center font-black text-lg">
                    <i class="fa-solid fa-sliders text-sm"></i>
                </div>
                <div>
                    <h2 class="text-base font-bold text-slate-900">Kustomisasi Alamat URL (Slug) & Status Aktif</h2>
                    <p class="text-xs text-slate-500">Ubah akhiran alamat web agar mudah diingat pelanggan.</p>
                </div>
            </div>

            <!-- Custom Slug -->
            <div>
                <label for="slug" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                    Alamat URL Website Promosi (Slug) <span class="text-rose-500">*</span>
                </label>
                <div class="flex rounded-xl shadow-xs overflow-hidden border border-slate-300 focus-within:ring-2 focus-within:ring-emerald-500 focus-within:border-emerald-500">
                    <span class="inline-flex items-center px-3.5 bg-slate-100 text-slate-500 text-xs font-mono font-medium border-r border-slate-300">
                        {{ url('/mitra') }}/
                    </span>
                    <input id="slug" type="text" name="slug" value="{{ old('slug', $mitra->slug) }}" required
                        placeholder="nama-usaha-anda"
                        class="block w-full px-3 py-2.5 text-sm font-mono text-slate-800 placeholder-slate-400 focus:outline-none border-0">
                </div>
                <p class="text-[11px] text-slate-500 mt-1">Gunakan hanya huruf kecil, angka, dan tanda hubung (-). Pastikan unik dan tidak bentrok dengan mitra lain.</p>
            </div>

            <!-- Toggle Aktifkan Website -->
            <div class="p-4 bg-slate-50 rounded-xl border border-slate-200 flex items-center justify-between">
                <div>
                    <span class="font-bold text-slate-800 text-xs sm:text-sm block">Status Visibilitas Website Mitra</span>
                    <span class="text-xs text-slate-500">Jika dinonaktifkan, pengunjung tidak akan dapat membuka halaman publik mitra ini.</span>
                </div>
                <label class="relative inline-flex items-center cursor-pointer">
                    <input type="hidden" name="is_active" value="0">
                    <input type="checkbox" name="is_active" value="1" {{ $mitra->is_active ? 'checked' : '' }} class="sr-only peer">
                    <div class="w-11 h-6 bg-slate-300 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-emerald-600"></div>
                </label>
            </div>

            <div>
                <button type="submit" class="inline-flex items-center gap-2 px-6 py-2.5 bg-slate-900 hover:bg-slate-800 text-white font-bold text-xs sm:text-sm rounded-xl shadow-md transition">
                    <i class="fa-solid fa-floppy-disk"></i> Simpan Pengaturan URL
                </button>
            </div>
        </form>

        <!-- Toggle Publikasi (Draft vs Published) -->
        <div class="pt-6 border-t border-slate-200">
            <div class="flex items-center justify-between gap-4 flex-wrap">
                <div>
                    <h3 class="font-bold text-slate-900 text-sm">Mode Publikasi Website</h3>
                    <p class="text-xs text-slate-500 mt-0.5">
                        Status saat ini: 
                        @if ($mitra->is_published)
                            <span class="font-bold text-emerald-600 bg-emerald-50 px-2 py-0.5 rounded">TERPUBLIKASI (LIVE)</span>
                        @else
                            <span class="font-bold text-amber-600 bg-amber-50 px-2 py-0.5 rounded">DRAF (PRIBADI)</span>
                        @endif
                    </p>
                </div>

                <form method="POST" action="{{ route('owner.settings.publish') }}">
                    @csrf
                    @if ($mitra->is_published)
                        <button type="submit" class="px-4 py-2 bg-amber-100 hover:bg-amber-200 text-amber-900 font-bold text-xs rounded-xl border border-amber-300 transition">
                            <i class="fa-solid fa-pause mr-1"></i> Ubah Menjadi Draf
                        </button>
                    @else
                        <button type="submit" class="px-5 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs sm:text-sm rounded-xl shadow-md shadow-emerald-600/30 transition">
                            <i class="fa-solid fa-cloud-arrow-up mr-1"></i> Publikasikan Website ke Publik
                        </button>
                    @endif
                </form>
            </div>
        </div>

    </div>

</div>
@endsection
