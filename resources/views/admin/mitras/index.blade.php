@extends('layouts.app')

@section('title', 'Kelola Direktori Mitra')

@section('content')
<div class="w-full px-4 sm:px-6 lg:px-8 py-8">

    <!-- Header & Search -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-6">
        <div>
            <h1 class="text-2xl font-bold text-slate-900 tracking-tight">Kelola Direktori Mitra PKM</h1>
            <p class="text-xs sm:text-sm text-slate-500 mt-0.5">Atur status aktif, urutan kartu etalase di halaman utama, dan kelola data mitra.</p>
        </div>

        <form method="GET" action="{{ route('admin.mitras.index') }}" class="flex items-center gap-2">
            <select name="jenis" onchange="this.form.submit()" class="text-xs border border-slate-300 rounded-xl py-2 px-3 focus:ring-orange-500">
                <option value="">Semua Jenis</option>
                <option value="umkm" {{ $jenis === 'umkm' ? 'selected' : '' }}>UMKM</option>
                <option value="koperasi" {{ $jenis === 'koperasi' ? 'selected' : '' }}>Koperasi</option>
            </select>
            <div class="relative">
                <input type="text" name="q" value="{{ $search }}" placeholder="Cari nama usaha, slug, alamat..."
                    class="w-56 sm:w-72 pl-9 pr-3 py-2 text-xs border border-slate-300 rounded-xl focus:ring-orange-500 focus:border-orange-500">
                <i class="fa-solid fa-magnifying-glass absolute left-3 top-2.5 text-xs text-slate-400"></i>
            </div>
            <button type="submit" class="px-3 py-2 bg-slate-900 text-white text-xs font-bold rounded-xl hover:bg-slate-800 transition">
                Cari
            </button>
        </form>
    </div>

    <!-- Table Card -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
        @if ($mitras->count() === 0)
            <div class="text-center py-12 text-slate-500 text-xs">
                <i class="fa-regular fa-folder-open text-3xl mb-2 text-slate-400 block"></i>
                Tidak ada data mitra yang sesuai pencarian.
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs">
                    <thead>
                        <tr class="bg-slate-50 text-slate-500 border-b border-slate-200 uppercase tracking-wider font-semibold">
                            <th class="py-3.5 px-4">Nama Usaha / Link</th>
                            <th class="py-3.5 px-4">Jenis</th>
                            <th class="py-3.5 px-4">Urutan Tampil</th>
                            <th class="py-3.5 px-4 text-center">Tampil di Beranda</th>
                            <th class="py-3.5 px-4 text-center">Status Operasional</th>
                            <th class="py-3.5 px-4 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-slate-700">
                        @foreach ($mitras as $mitra)
                            <tr class="hover:bg-slate-50/80 transition">
                                <td class="py-3.5 px-4">
                                    <div class="flex items-center gap-3">
                                        @if ($mitra->logo)
                                            <img src="{{ asset('storage/' . $mitra->logo) }}" alt="Logo" class="w-9 h-9 rounded-lg object-cover border border-slate-200 shrink-0">
                                        @else
                                            <div class="w-9 h-9 rounded-lg bg-orange-100 text-orange-800 font-bold text-xs flex items-center justify-center shrink-0">
                                                {{ substr($mitra->nama_usaha, 0, 2) }}
                                            </div>
                                        @endif
                                        <div>
                                            <span class="font-bold text-slate-900 block text-sm">{{ $mitra->nama_usaha }}</span>
                                            <a href="{{ route('mitra.show', ['slug' => $mitra->slug]) }}" target="_blank" class="text-orange-600 hover:underline font-mono text-[11px] inline-flex items-center gap-1">
                                                /mitra/{{ $mitra->slug }} <i class="fa-solid fa-arrow-up-right-from-square text-[9px]"></i>
                                            </a>
                                        </div>
                                    </div>
                                </td>

                                <td class="py-3.5 px-4">
                                    <span class="font-bold uppercase text-[10px] px-2 py-0.5 rounded {{ $mitra->jenis === 'umkm' ? 'bg-blue-50 text-blue-700 border border-blue-200' : 'bg-purple-50 text-purple-700 border border-purple-200' }}">
                                        {{ $mitra->jenis }}
                                    </span>
                                </td>

                                <!-- Urutan Tampil (Quick Form) -->
                                <td class="py-3.5 px-4">
                                    <form method="POST" action="{{ route('admin.mitras.update-order', $mitra->id) }}" class="flex items-center gap-1.5">
                                        @csrf
                                        <input type="number" name="urutan_tampil" value="{{ $mitra->urutan_tampil }}" min="0"
                                            class="w-16 px-2 py-1 border border-slate-300 rounded text-xs font-semibold text-center focus:ring-orange-500">
                                        <button type="submit" title="Simpan urutan" class="p-1 text-slate-500 hover:text-orange-600">
                                            <i class="fa-solid fa-check"></i>
                                        </button>
                                    </form>
                                </td>

                                <!-- Toggle Visibilitas di Beranda -->
                                <td class="py-3.5 px-4 text-center">
                                    <form method="POST" action="{{ route('admin.mitras.toggle-visibility', $mitra->id) }}">
                                        @csrf
                                        @if ($mitra->is_visible_on_home)
                                            <button type="submit" title="Klik untuk menyembunyikan dari beranda" class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-orange-100 text-orange-800 hover:bg-orange-200 transition">
                                                <i class="fa-solid fa-eye mr-1"></i> Tampil
                                            </button>
                                        @else
                                            <button type="submit" title="Klik untuk menampilkan di beranda" class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-slate-200 text-slate-600 hover:bg-slate-300 transition">
                                                <i class="fa-solid fa-eye-slash mr-1"></i> Tersembunyi
                                            </button>
                                        @endif
                                    </form>
                                </td>

                                <!-- Toggle Aktif / Suspended -->
                                <td class="py-3.5 px-4 text-center">
                                    <form method="POST" action="{{ route('admin.mitras.toggle-active', $mitra->id) }}"
                                        data-confirm="{{ $mitra->is_active ? 'Nonaktifkan mitra ini? Halaman website promosi dan kartu etalase akan ditangguhkan.' : 'Aktifkan kembali mitra ini?' }}"
                                        data-title="{{ $mitra->is_active ? 'Nonaktifkan Mitra' : 'Aktifkan Mitra' }}"
                                        data-confirm-text="{{ $mitra->is_active ? 'Ya, Nonaktifkan' : 'Ya, Aktifkan' }}">
                                        @csrf
                                        @if ($mitra->is_active)
                                            <button type="submit"
                                                class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-orange-500 text-white hover:bg-orange-600 transition shadow-xs">
                                                <i class="fa-solid fa-circle-check mr-1"></i> Aktif
                                            </button>
                                        @else
                                            <button type="submit"
                                                class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-rose-600 text-white hover:bg-rose-700 transition shadow-xs">
                                                <i class="fa-solid fa-ban mr-1"></i> Dinonaktifkan
                                            </button>
                                        @endif
                                    </form>
                                </td>

                                <!-- Aksi Hapus -->
                                <td class="py-3.5 px-4 text-right whitespace-nowrap">
                                    <form method="POST" action="{{ route('admin.mitras.destroy', $mitra->id) }}"
                                        data-confirm="PENTING: Apakah Anda yakin ingin MENGHAPUS PERMANEN mitra {{ $mitra->nama_usaha }}? Seluruh data website, produk, dan akun akan dihapus."
                                        data-title="Hapus Permanen Mitra"
                                        data-confirm-text="Ya, Hapus Permanen"
                                        data-destructive="true"
                                        class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-1.5 rounded-lg text-rose-500 hover:bg-rose-50 transition" title="Hapus Permanen">
                                            <i class="fa-regular fa-trash-can text-sm"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="p-4 border-t border-slate-200">
                {{ $mitras->links() }}
            </div>
        @endif
    </div>

</div>
@endsection
