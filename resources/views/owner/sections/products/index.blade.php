@extends('layouts.app')

@section('title', 'Kelola Produk & Galeri')

@section('content')
<div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

    <!-- Breadcrumb & Top Bar -->
    <div class="mb-6 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <a href="{{ route('owner.dashboard') }}" class="inline-flex items-center gap-1.5 text-xs font-semibold text-slate-500 hover:text-orange-600 transition">
            <i class="fa-solid fa-arrow-left"></i> Kembali ke Dashboard
        </a>
        <div class="flex items-center gap-3">
            <a href="{{ route('owner.preview') }}#produk" target="_blank" class="text-xs font-semibold text-orange-600 hover:underline">
                <i class="fa-regular fa-eye mr-1"></i> Pratinjau Etalase
            </a>
            <a href="{{ route('owner.products.create') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-orange-600 hover:bg-orange-700 text-white font-bold text-xs sm:text-sm rounded-xl shadow-md shadow-orange-600/20 transition">
                <i class="fa-solid fa-plus"></i> Tambah Produk Baru
            </a>
        </div>
    </div>

    <!-- Products Card -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 sm:p-8">
        <div class="flex items-center gap-3 pb-4 border-b border-slate-200 mb-6">
            <div class="w-10 h-10 rounded-xl bg-indigo-100 text-indigo-700 flex items-center justify-center font-black text-lg">
                3
            </div>
            <div>
                <h1 class="text-xl font-bold text-slate-900">Section 3: Produk & Galeri Etalase</h1>
                <p class="text-xs text-slate-500">Kelola daftar penawaran produk atau galeri karya usaha Anda yang ditampilkan di website promosi.</p>
            </div>
        </div>

        @if ($products->count() === 0)
            <div class="text-center py-12 border-2 border-dashed border-slate-200 rounded-2xl bg-slate-50">
                <div class="w-16 h-16 rounded-2xl bg-indigo-50 text-indigo-500 flex items-center justify-center text-3xl mx-auto mb-3">
                    <i class="fa-solid fa-box-open"></i>
                </div>
                <h3 class="text-base font-bold text-slate-800">Belum Ada Produk Ditambahkan</h3>
                <p class="text-xs text-slate-500 max-w-sm mx-auto mt-1 mb-6">Mulai isi etalase promosi Anda dengan menambahkan produk unggulan pertama.</p>
                <a href="{{ route('owner.products.create') }}" class="inline-flex items-center gap-2 px-5 py-2.5 bg-orange-600 hover:bg-orange-700 text-white font-bold text-xs sm:text-sm rounded-xl shadow-md transition">
                    <i class="fa-solid fa-plus"></i> Tambah Produk Pertama
                </a>
            </div>
        @else
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach ($products as $product)
                    <div class="border border-slate-200 rounded-2xl overflow-hidden bg-white shadow-xs hover:shadow-md transition flex flex-col justify-between group">
                        <div>
                            <!-- Foto Produk -->
                            <div class="h-44 bg-slate-100 relative overflow-hidden">
                                @if ($product->foto)
                                    <img src="{{ Str::startsWith($product->foto, ['http', 'data:']) ? $product->foto : asset('storage/' . $product->foto) }}" 
                                         alt="{{ $product->nama }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-300"
                                         onerror="this.onerror=null; this.parentElement.innerHTML='<div class=\'w-full h-full flex items-center justify-center text-slate-400 bg-slate-100\'><i class=\'fa-regular fa-image text-3xl\'></i></div>'">
                                @else
                                    <div class="w-full h-full flex items-center justify-center text-slate-400 bg-slate-100">
                                        <i class="fa-regular fa-image text-3xl"></i>
                                    </div>
                                @endif
                                <div class="absolute top-2 left-2 bg-slate-900/80 backdrop-blur-xs text-white text-[10px] px-2 py-0.5 rounded-md font-bold">
                                    Urutan: #{{ $product->urutan }}
                                </div>
                            </div>

                            <!-- Info Produk -->
                            <div class="p-4">
                                <h3 class="font-bold text-slate-900 text-sm mb-1 line-clamp-1">{{ $product->nama }}</h3>
                                <div class="text-orange-700 font-extrabold text-sm mb-2">
                                    @if ($product->harga)
                                        Rp {{ number_format($product->harga, 0, ',', '.') }}
                                    @else
                                        <span class="text-slate-400 font-normal text-xs italic">Harga berdasarkan pesanan</span>
                                    @endif
                                </div>
                                <p class="text-xs text-slate-500 line-clamp-2 leading-relaxed">
                                    {{ $product->deskripsi ?? 'Tidak ada deskripsi produk.' }}
                                </p>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="p-4 pt-0 border-t border-slate-100 mt-3 flex items-center justify-between gap-2">
                            <a href="{{ route('owner.products.edit', $product->id) }}" class="flex-1 text-center py-2 px-3 rounded-lg bg-slate-50 hover:bg-orange-50 text-slate-700 hover:text-orange-700 text-xs font-semibold border border-slate-200 transition">
                                <i class="fa-solid fa-pen text-[10px] mr-1"></i> Ubah
                            </a>
                            <form method="POST" action="{{ route('owner.products.destroy', $product->id) }}"
                                data-confirm="Apakah Anda yakin ingin menghapus produk '{{ $product->nama }}'? Data yang telah dihapus tidak dapat dipulihkan."
                                data-title="Hapus Produk"
                                data-confirm-text="Ya, Hapus"
                                data-destructive="true">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="py-2 px-3 rounded-lg bg-rose-50 hover:bg-rose-100 text-rose-600 text-xs font-semibold border border-rose-200 transition">
                                    <i class="fa-regular fa-trash-can"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

</div>
@endsection
