@extends('layouts.app')

@section('title', 'Tambah Produk Baru')

@section('content')
<div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

    <!-- Breadcrumb & Back -->
    <div class="mb-6">
        <a href="{{ route('owner.products.index') }}" class="inline-flex items-center gap-1.5 text-xs font-semibold text-slate-500 hover:text-orange-600 transition">
            <i class="fa-solid fa-arrow-left"></i> Kembali ke Daftar Produk
        </a>
    </div>

    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 sm:p-8">
        <div class="flex items-center gap-3 pb-4 border-b border-slate-200 mb-6">
            <div class="w-10 h-10 rounded-xl bg-indigo-100 text-indigo-700 flex items-center justify-center font-black text-lg">
                <i class="fa-solid fa-plus text-sm"></i>
            </div>
            <div>
                <h1 class="text-xl font-bold text-slate-900">Tambah Produk / Galeri Baru</h1>
                <p class="text-xs text-slate-500">Tambahkan barang atau jasa yang ingin dipromosikan di website mitra Anda.</p>
            </div>
        </div>

        <form method="POST" action="{{ route('owner.products.store') }}" enctype="multipart/form-data" class="space-y-6">
            @csrf

            <!-- Nama Produk -->
            <div>
                <label for="nama" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                    Nama Produk / Layanan <span class="text-rose-500">*</span>
                </label>
                <input id="nama" type="text" name="nama" value="{{ old('nama') }}" required
                    placeholder="Contoh: Paket Kopi Robusta Premium 250gr"
                    class="block w-full px-3.5 py-2.5 border border-slate-300 rounded-xl text-sm placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition">
            </div>

            <!-- Harga & Urutan -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label for="harga" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                        Harga (Rupiah) <span class="text-slate-400 font-normal lowercase">(opsional)</span>
                    </label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center text-xs font-bold text-slate-400">Rp</span>
                        <input id="harga" type="number" name="harga" value="{{ old('harga') }}" min="0" step="1000"
                            placeholder="50000"
                            class="block w-full pl-10 pr-3.5 py-2.5 border border-slate-300 rounded-xl text-sm placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition">
                    </div>
                </div>

                <div>
                    <label for="urutan" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                        Nomor Urut Tampil <span class="text-slate-400 font-normal lowercase">(angka)</span>
                    </label>
                    <input id="urutan" type="number" name="urutan" value="{{ old('urutan', 1) }}" min="1"
                        class="block w-full px-3.5 py-2.5 border border-slate-300 rounded-xl text-sm placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition">
                </div>
            </div>

            <!-- Deskripsi Produk -->
            <div>
                <label for="deskripsi" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                    Deskripsi Singkat Produk
                </label>
                <textarea id="deskripsi" name="deskripsi" rows="3"
                    placeholder="Jelaskan spesifikasi, keunggulan, bahan baku, atau pilihan varian..."
                    class="block w-full px-3.5 py-2.5 border border-slate-300 rounded-xl text-sm placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition">{{ old('deskripsi') }}</textarea>
            </div>

            <!-- Foto Produk -->
            <div x-data="{
                preview: null,
                onFileChange(e) {
                    const file = e.target.files[0];
                    if (!file) {
                        this.preview = null;
                        return;
                    }
                    if (file.size > 2 * 1024 * 1024) {
                        alert('Ukuran file maksimal 2 MB.');
                        e.target.value = '';
                        this.preview = null;
                        return;
                    }
                    const reader = new FileReader();
                    reader.onload = (event) => { this.preview = event.target.result; };
                    reader.readAsDataURL(file);
                },
                removeFile() {
                    this.preview = null;
                    this.$refs.fileInput.value = '';
                }
            }">
                <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                    Foto Produk / Galeri
                </label>
                <p class="text-xs text-slate-500 mb-2">Format yang didukung: JPG, PNG, WEBP. Maksimal ukuran file: <strong>2 MB</strong>.</p>
                <div class="p-4 border-2 border-dashed border-slate-300 rounded-xl bg-slate-50">
                    <input id="foto" type="file" name="foto" accept="image/png,image/jpeg,image/webp" x-ref="fileInput" @change="onFileChange($event)"
                        class="block w-full text-xs text-slate-600 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-orange-600 file:text-white hover:file:bg-orange-700 file:cursor-pointer">
                </div>

                <!-- Live Preview -->
                <template x-if="preview">
                    <div class="mt-3 p-3 bg-white border border-slate-200 rounded-xl flex items-center justify-between gap-4 shadow-xs">
                        <div class="flex items-center gap-3">
                            <img :src="preview" alt="Pratinjau Foto Produk" class="w-16 h-16 object-cover rounded-lg border border-slate-200 shadow-xs">
                            <div class="text-xs text-slate-600">
                                <span class="font-bold text-emerald-600 block"><i class="fa-solid fa-check-circle mr-1"></i> Foto Siap Diunggah</span>
                                Disimpan permanen ke etalase Anda.
                            </div>
                        </div>
                        <button type="button" @click="removeFile()" class="px-3 py-1.5 text-xs text-rose-600 hover:bg-rose-50 rounded-lg border border-rose-200 transition font-semibold">
                            <i class="fa-solid fa-xmark mr-1"></i> Batal
                        </button>
                    </div>
                </template>
            </div>

            <!-- Action Buttons -->
            <div class="pt-4 border-t border-slate-200 flex items-center justify-between">
                <a href="{{ route('owner.products.index') }}" class="px-4 py-2.5 border border-slate-300 rounded-xl text-slate-700 text-xs font-semibold hover:bg-slate-50 transition">
                    Batal
                </a>
                <button type="submit" class="inline-flex items-center gap-2 px-6 py-2.5 bg-orange-600 hover:bg-orange-700 text-white font-bold text-xs sm:text-sm rounded-xl shadow-md transition shadow-orange-600/30">
                    <i class="fa-solid fa-plus"></i> Simpan Produk
                </button>
            </div>
        </form>
    </div>

</div>
@endsection
