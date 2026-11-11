@extends('layouts.app')

@section('title', 'Ubah Produk - ' . $product->nama)

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
                <i class="fa-solid fa-pen text-sm"></i>
            </div>
            <div>
                <h1 class="text-xl font-bold text-slate-900">Ubah Data Produk</h1>
                <p class="text-xs text-slate-500">Perbarui informasi, harga, atau foto produk.</p>
            </div>
        </div>

        <form id="product-edit-form" method="POST" action="{{ route('owner.products.update', $product->id) }}" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')

            <!-- Nama Produk -->
            <div>
                <label for="nama" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                    Nama Produk / Layanan <span class="text-rose-500">*</span>
                </label>
                <input id="nama" type="text" name="nama" value="{{ old('nama', $product->nama) }}" required
                    class="block w-full px-3.5 py-2.5 border border-slate-300 rounded-xl text-sm placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition">
            </div>

            <!-- Harga & Urutan -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label for="harga" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                        Harga (Rupiah)
                    </label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center text-xs font-bold text-slate-400">Rp</span>
                        <input id="harga" type="number" name="harga" value="{{ old('harga', $product->harga ? (int)$product->harga : '') }}" min="0" step="1000"
                            class="block w-full pl-10 pr-3.5 py-2.5 border border-slate-300 rounded-xl text-sm placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition">
                    </div>
                </div>

                <div>
                    <label for="urutan" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                        Nomor Urut Tampil
                    </label>
                    <input id="urutan" type="number" name="urutan" value="{{ old('urutan', $product->urutan) }}" min="1"
                        class="block w-full px-3.5 py-2.5 border border-slate-300 rounded-xl text-sm placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition">
                </div>
            </div>

            <!-- Deskripsi Produk -->
            <div>
                <label for="deskripsi" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                    Deskripsi Produk
                </label>
                <textarea id="deskripsi" name="deskripsi" rows="3"
                    class="block w-full px-3.5 py-2.5 border border-slate-300 rounded-xl text-sm placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition">{{ old('deskripsi', $product->deskripsi) }}</textarea>
            </div>

            <!-- Foto Produk Saat Ini & Ganti Foto -->
            <div x-data="{
                preview: null,
                hasExisting: {{ $product->foto ? 'true' : 'false' }},
                hapusFoto: false,
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
                    this.hapusFoto = false;
                    const reader = new FileReader();
                    reader.onload = (event) => { this.preview = event.target.result; };
                    reader.readAsDataURL(file);
                },
                removeNewFile() {
                    this.preview = null;
                    this.$refs.fileInput.value = '';
                }
            }">
                <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                    Foto Produk (Maks 2 MB)
                </label>

                <input type="hidden" name="hapus_foto" :value="hapusFoto ? '1' : '0'">

                @if ($product->foto)
                    <div x-show="hasExisting && !hapusFoto && !preview" class="mb-3 flex items-center justify-between p-3 bg-slate-50 border border-slate-200 rounded-xl">
                        <div class="flex items-center gap-4">
                            <img src="{{ Str::startsWith($product->foto, ['http', 'data:']) ? $product->foto : asset('storage/' . $product->foto) }}" 
                                 alt="{{ $product->nama }}" class="w-16 h-16 object-cover rounded-lg shadow-xs border border-slate-200"
                                 onerror="this.parentElement.parentElement.classList.add('hidden')">
                            <div class="text-xs text-slate-500">
                                <span class="font-bold text-slate-800 block">Foto Saat Ini</span>
                                Foto tersimpan permanen di etalase Anda.
                            </div>
                        </div>
                        <button type="button" @click="hapusFoto = true" class="px-3 py-1.5 text-xs text-rose-600 hover:bg-rose-50 rounded-lg border border-rose-200 transition font-semibold">
                            <i class="fa-regular fa-trash-can mr-1"></i> Hapus Foto
                        </button>
                    </div>

                    <div x-show="hapusFoto && !preview" class="mb-3 p-3 bg-rose-50 border border-rose-200 rounded-xl flex items-center justify-between text-xs text-rose-700">
                        <span><i class="fa-solid fa-triangle-exclamation mr-1"></i> Foto akan dihapus saat disimpan.</span>
                        <button type="button" @click="hapusFoto = false" class="underline font-bold text-rose-800 hover:text-rose-900">
                            Batal Hapus
                        </button>
                    </div>
                @endif

                <!-- Live Preview New File -->
                <template x-if="preview">
                    <div class="mb-3 p-3 bg-white border border-slate-200 rounded-xl flex items-center justify-between gap-4 shadow-xs">
                        <div class="flex items-center gap-3">
                            <img :src="preview" alt="Pratinjau Foto Baru" class="w-16 h-16 object-cover rounded-lg border border-slate-200 shadow-xs">
                            <div class="text-xs text-slate-600">
                                <span class="font-bold text-emerald-600 block"><i class="fa-solid fa-check-circle mr-1"></i> Foto Baru Dipilih</span>
                                Akan menggantikan foto lama secara permanen.
                            </div>
                        </div>
                        <button type="button" @click="removeNewFile()" class="px-3 py-1.5 text-xs text-slate-600 hover:bg-slate-100 rounded-lg border border-slate-300 transition font-semibold">
                            <i class="fa-solid fa-xmark mr-1"></i> Batalkan Foto Baru
                        </button>
                    </div>
                </template>

                <div class="p-4 border-2 border-dashed border-slate-300 rounded-xl bg-slate-50">
                    <input id="foto" type="file" name="foto" accept="image/png,image/jpeg,image/webp" x-ref="fileInput" @change="onFileChange($event)"
                        class="block w-full text-xs text-slate-600 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-orange-600 file:text-white hover:file:bg-orange-700 file:cursor-pointer">
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="pt-4 border-t border-slate-200 flex items-center justify-between">
                <a href="{{ route('owner.products.index') }}" class="px-4 py-2.5 border border-slate-300 rounded-xl text-slate-700 text-xs font-semibold hover:bg-slate-50 transition">
                    Batal
                </a>
                <button type="submit" class="inline-flex items-center gap-2 px-6 py-2.5 bg-orange-600 hover:bg-orange-700 text-white font-bold text-xs sm:text-sm rounded-xl shadow-md transition shadow-orange-600/30">
                    <i class="fa-solid fa-floppy-disk"></i> Simpan Perubahan Produk
                </button>
            </div>
        </form>
    </div>

</div>
@endsection
