@extends('layouts.app')

@section('title', 'Verifikasi Pendaftar Mitra')

@section('content')
<div class="w-full max-w-[1800px] mx-auto px-4 sm:px-6 lg:px-10 xl:px-12 py-8">

    <!-- Header & Search -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-6">
        <div>
            <h1 class="text-2xl font-bold text-slate-900 tracking-tight">Verifikasi Pendaftar Mitra PKM</h1>
            <p class="text-xs sm:text-sm text-slate-500 mt-0.5">Tinjau permohonan pendaftaran UMKM & Koperasi untuk disetujui atau ditolak.</p>
        </div>

        <!-- Search Form -->
        <form method="GET" action="{{ route('admin.verifications.index') }}" class="flex items-center gap-2">
            <input type="hidden" name="status" value="{{ $status }}">
            <div class="relative">
                <input type="text" name="q" value="{{ $search }}" placeholder="Cari nama usaha, pemilik, email..."
                    class="w-64 sm:w-80 pl-9 pr-3 py-2 text-xs border border-slate-300 rounded-xl focus:ring-emerald-500 focus:border-emerald-500">
                <i class="fa-solid fa-magnifying-glass absolute left-3 top-2.5 text-xs text-slate-400"></i>
            </div>
            <button type="submit" class="px-3.5 py-2 bg-slate-900 text-white text-xs font-bold rounded-xl hover:bg-slate-800 transition">
                Cari
            </button>
            @if ($search)
                <a href="{{ route('admin.verifications.index', ['status' => $status]) }}" class="px-2.5 py-2 text-xs text-slate-500 hover:text-slate-800">
                    Reset
                </a>
            @endif
        </form>
    </div>

    <!-- Status Tabs -->
    <div class="flex items-center gap-2 border-b border-slate-200 mb-6 overflow-x-auto text-xs font-semibold pb-1">
        <a href="{{ route('admin.verifications.index', ['status' => 'all', 'q' => $search]) }}"
           class="px-4 py-2 rounded-t-lg transition border-b-2 {{ $status === 'all' ? 'border-emerald-600 text-emerald-700 bg-emerald-50/50' : 'border-transparent text-slate-600 hover:text-slate-900' }}">
            Semua ({{ $counts['all'] }})
        </a>
        <a href="{{ route('admin.verifications.index', ['status' => 'pending', 'q' => $search]) }}"
           class="px-4 py-2 rounded-t-lg transition border-b-2 flex items-center gap-1.5 {{ $status === 'pending' ? 'border-amber-500 text-amber-800 bg-amber-50/50 font-bold' : 'border-transparent text-slate-600 hover:text-slate-900' }}">
            <span class="w-2 h-2 rounded-full bg-amber-500"></span>
            Menunggu Verifikasi ({{ $counts['pending'] }})
        </a>
        <a href="{{ route('admin.verifications.index', ['status' => 'approved', 'q' => $search]) }}"
           class="px-4 py-2 rounded-t-lg transition border-b-2 {{ $status === 'approved' ? 'border-emerald-600 text-emerald-700 bg-emerald-50/50' : 'border-transparent text-slate-600 hover:text-slate-900' }}">
            Disetujui ({{ $counts['approved'] }})
        </a>
        <a href="{{ route('admin.verifications.index', ['status' => 'rejected', 'q' => $search]) }}"
           class="px-4 py-2 rounded-t-lg transition border-b-2 {{ $status === 'rejected' ? 'border-rose-600 text-rose-700 bg-rose-50/50' : 'border-transparent text-slate-600 hover:text-slate-900' }}">
            Ditolak ({{ $counts['rejected'] }})
        </a>
    </div>

    <!-- Table Card -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
        @if ($mitras->count() === 0)
            <div class="text-center py-12 text-slate-500 text-xs">
                <i class="fa-regular fa-folder-open text-3xl mb-2 text-slate-400 block"></i>
                Tidak ada data pendaftaran mitra pada kriteria ini.
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs">
                    <thead>
                        <tr class="bg-slate-50 text-slate-500 border-b border-slate-200 uppercase tracking-wider font-semibold">
                            <th class="py-3.5 px-4">Tanggal Daftar</th>
                            <th class="py-3.5 px-4">Nama Usaha</th>
                            <th class="py-3.5 px-4">Jenis</th>
                            <th class="py-3.5 px-4">Pemilik & Kontak</th>
                            <th class="py-3.5 px-4">Status Akun</th>
                            <th class="py-3.5 px-4 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-slate-700">
                        @foreach ($mitras as $mitra)
                            <tr class="hover:bg-slate-50/80 transition">
                                <td class="py-3.5 px-4 text-slate-500 whitespace-nowrap">
                                    {{ $mitra->created_at->format('d M Y, H:i') }}
                                </td>
                                <td class="py-3.5 px-4">
                                    <div class="flex items-center gap-3">
                                        @if ($mitra->logo)
                                            <img src="{{ asset('storage/' . $mitra->logo) }}" alt="Logo" class="w-8 h-8 rounded-lg object-cover border border-slate-200 shrink-0">
                                        @else
                                            <div class="w-8 h-8 rounded-lg bg-slate-100 text-slate-500 font-bold flex items-center justify-center shrink-0">
                                                {{ substr($mitra->nama_usaha, 0, 2) }}
                                            </div>
                                        @endif
                                        <div>
                                            <span class="font-bold text-slate-900 block">{{ $mitra->nama_usaha }}</span>
                                            <span class="text-slate-400 font-mono text-[11px]">/mitra/{{ $mitra->slug }}</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-3.5 px-4">
                                    <span class="font-bold uppercase text-[10px] px-2 py-0.5 rounded {{ $mitra->jenis === 'umkm' ? 'bg-blue-50 text-blue-700 border border-blue-200' : 'bg-purple-50 text-purple-700 border border-purple-200' }}">
                                        {{ $mitra->jenis }}
                                    </span>
                                </td>
                                <td class="py-3.5 px-4">
                                    <span class="font-semibold text-slate-800 block">{{ $mitra->user?->name }}</span>
                                    <span class="text-slate-500 block">{{ $mitra->user?->email }}</span>
                                    <span class="text-emerald-700 font-mono text-[11px] block mt-0.5"><i class="fa-brands fa-whatsapp"></i> {{ $mitra->kontak }}</span>
                                </td>
                                <td class="py-3.5 px-4 whitespace-nowrap">
                                    @php $st = $mitra->user?->status ?? 'pending'; @endphp
                                    @if ($st === 'approved')
                                        <span class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-emerald-100 text-emerald-800 inline-flex items-center gap-1">
                                            <i class="fa-solid fa-check"></i> Disetujui
                                        </span>
                                    @elseif ($st === 'rejected')
                                        <span class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-rose-100 text-rose-800 inline-flex items-center gap-1">
                                            <i class="fa-solid fa-xmark"></i> Ditolak
                                        </span>
                                    @elseif ($st === 'suspended')
                                        <span class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-slate-200 text-slate-800 inline-flex items-center gap-1">
                                            <i class="fa-solid fa-ban"></i> Suspended
                                        </span>
                                    @else
                                        <span class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-amber-100 text-amber-800 inline-flex items-center gap-1 animate-pulse">
                                            <i class="fa-solid fa-clock"></i> Pending
                                        </span>
                                    @endif
                                </td>
                                <td class="py-3.5 px-4 text-right whitespace-nowrap">
                                    <a href="{{ route('admin.verifications.show', $mitra->id) }}" class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-slate-900 hover:bg-slate-800 text-white font-bold rounded-lg transition shadow-xs">
                                        <span>Periksa</span> <i class="fa-solid fa-arrow-right text-[10px]"></i>
                                    </a>
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
