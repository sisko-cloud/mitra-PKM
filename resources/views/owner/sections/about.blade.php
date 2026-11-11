@extends('layouts.app')

@section('title', 'Edit Section 2: Tentang & Visi Misi')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

    <!-- Breadcrumb & Back -->
    <div class="mb-6 flex items-center justify-between">
        <a href="{{ route('owner.dashboard') }}" class="inline-flex items-center gap-1.5 text-xs font-semibold text-slate-500 hover:text-orange-600 transition">
            <i class="fa-solid fa-arrow-left"></i> Kembali ke Dashboard
        </a>
        <a href="{{ route('owner.preview') }}#tentang" target="_blank" class="text-xs font-semibold text-orange-600 hover:underline">
            <i class="fa-regular fa-eye mr-1"></i> Pratinjau Section Ini
        </a>
    </div>

    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 sm:p-8">
        <div class="flex items-center gap-3 pb-4 border-b border-slate-200 mb-6">
            <div class="w-10 h-10 rounded-xl bg-amber-100 text-amber-700 flex items-center justify-center font-black text-lg">
                2
            </div>
            <div>
                <h1 class="text-xl font-bold text-slate-900">Section 2: Tentang / Profil Usaha, Sejarah, & Visi Misi</h1>
                <p class="text-xs text-slate-500">Bangun kepercayaan calon pelanggan dan mitra dengan menceritakan profil dan nilai keunggulan usaha Anda.</p>
            </div>
        </div>

        <form id="about-form" method="POST" action="{{ route('owner.about.update') }}" enctype="multipart/form-data" class="space-y-6">
            @csrf

            <!-- Deskripsi Usaha -->
            <div>
                <label for="deskripsi" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                    Deskripsi Ringkas Usaha
                </label>
                <textarea id="deskripsi" name="deskripsi" rows="4"
                    placeholder="Ceritakan bidang usaha, produk atau jasa utama, serta target pasar yang Anda layani..."
                    class="block w-full px-3.5 py-2.5 border border-slate-300 rounded-xl text-sm placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition">{{ old('deskripsi', $content->deskripsi) }}</textarea>
                <p class="text-[11px] text-slate-500 mt-1">Gunakan paragraf yang mudah dibaca dan komunikatif.</p>
            </div>

            <!-- Sejarah Usaha -->
            <div>
                <label for="sejarah" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                    Sejarah Singkat & Latar Belakang Kemitraan PKM
                </label>
                <textarea id="sejarah" name="sejarah" rows="3"
                    placeholder="Contoh: Berawal dari program PKM Kewirausahaan mahasiswa tahun 2023, kami berinovasi mengembangkan olahan pangan lokal..."
                    class="block w-full px-3.5 py-2.5 border border-slate-300 rounded-xl text-sm placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition">{{ old('sejarah', $content->sejarah) }}</textarea>
                <p class="text-[11px] text-slate-500 mt-1">Jelaskan bagaimana usaha Anda dirintis dan peran pendampingan program PKM.</p>
            </div>

            <!-- Visi & Misi -->
            <div>
                <label for="visi_misi" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                    Visi & Misi Usaha
                </label>
                <textarea id="visi_misi" name="visi_misi" rows="4"
                    placeholder="Visi: ...&#10;&#10;Misi:&#10;1. ...&#10;2. ..."
                    class="block w-full px-3.5 py-2.5 border border-slate-300 rounded-xl text-sm placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition font-sans">{{ old('visi_misi', $content->visi_misi) }}</textarea>
                <p class="text-[11px] text-slate-500 mt-1">Anda dapat menggunakan poin penomoran untuk misi usaha.</p>
            </div>

            <!-- Upload Struktur Organisasi -->
            <div x-data="{
                preview: '',
                hasExisting: {{ $content->struktur_organisasi ? 'true' : 'false' }},
                hapus: false,
                pickFile() { this.$refs.fileInput.click(); },
                onFileChange(e) {
                    const file = e.target.files[0];
                    if (!file) return;
                    if (file.size > 3 * 1024 * 1024) { alert('Ukuran file maksimal 3 MB'); e.target.value = ''; return; }
                    const reader = new FileReader();
                    reader.onload = (ev) => { this.preview = ev.target.result; this.hapus = false; };
                    reader.readAsDataURL(file);
                },
                removeImage() {
                    this.preview = '';
                    this.hapus = true;
                    this.$refs.fileInput.value = '';
                }
            }">
                <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                    <i class="fa-solid fa-sitemap text-orange-600 mr-1"></i> Struktur Organisasi
                </label>
                <p class="text-[11px] text-slate-500 mb-3">Upload gambar/bagan struktur organisasi usaha Anda (JPG, PNG, WebP — maks 3 MB).</p>

                <input type="hidden" name="hapus_struktur" :value="hapus ? '1' : '0'">
                <input type="file" name="struktur_organisasi" accept="image/*" x-ref="fileInput" class="hidden" @change="onFileChange($event)">

                {{-- Preview Area --}}
                <div class="mb-3">
                    <template x-if="preview">
                        <div class="relative group">
                            <img :src="preview" alt="Pratinjau Struktur Organisasi"
                                class="w-full max-h-80 object-contain rounded-xl border border-slate-200 bg-slate-50 p-2">
                            <button type="button" @click="removeImage()"
                                class="absolute top-2 right-2 bg-red-600 hover:bg-red-700 text-white rounded-full w-7 h-7 flex items-center justify-center text-xs shadow-md opacity-0 group-hover:opacity-100 transition"
                                title="Hapus Gambar">
                                <i class="fa-solid fa-xmark"></i>
                            </button>
                        </div>
                    </template>
                    <template x-if="!preview && !hapus && hasExisting">
                        <div class="relative group">
                            <img src="{{ $content->struktur_organisasi }}" alt="Struktur Organisasi"
                                class="w-full max-h-80 object-contain rounded-xl border border-slate-200 bg-slate-50 p-2">
                            <button type="button" @click="removeImage()"
                                class="absolute top-2 right-2 bg-red-600 hover:bg-red-700 text-white rounded-full w-7 h-7 flex items-center justify-center text-xs shadow-md opacity-0 group-hover:opacity-100 transition"
                                title="Hapus Gambar">
                                <i class="fa-solid fa-xmark"></i>
                            </button>
                        </div>
                    </template>
                </div>

                {{-- Upload / Replace Button --}}
                <button type="button" @click="pickFile()"
                    class="inline-flex items-center gap-2 px-4 py-2 border border-dashed border-slate-400 rounded-xl text-xs font-semibold text-slate-600 hover:border-orange-500 hover:text-orange-600 hover:bg-orange-50 transition">
                    <i class="fa-solid fa-cloud-arrow-up"></i>
                    <span x-text="(preview || (hasExisting && !hapus)) ? 'Ganti Gambar' : 'Upload Gambar Struktur'"></span>
                </button>
                @error('struktur_organisasi')
                    <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Action Buttons -->
            <div class="pt-4 border-t border-slate-200 flex items-center justify-between">
                <a href="{{ route('owner.dashboard') }}" class="px-4 py-2.5 border border-slate-300 rounded-xl text-slate-700 text-xs font-semibold hover:bg-slate-50 transition">
                    Batal
                </a>
                <button type="submit" class="inline-flex items-center gap-2 px-6 py-2.5 bg-orange-600 hover:bg-orange-700 text-white font-bold text-xs sm:text-sm rounded-xl shadow-md transition shadow-orange-600/30">
                    <i class="fa-solid fa-floppy-disk"></i> Simpan Section Tentang
                </button>
            </div>
        </form>
    </div>

</div>
@endsection
