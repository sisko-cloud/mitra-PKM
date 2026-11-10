@extends('layouts.app')

@section('title', 'Dashboard Superadmin')

@section('content')
<div class="w-full px-4 sm:px-6 lg:px-8 py-8">

    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-8">
        <div>
            <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-slate-900 text-emerald-400 text-xs font-bold uppercase tracking-wider mb-2">
                <i class="fa-solid fa-shield-halved"></i> Panel Administrator
            </div>
            <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">Ringkasan Platform Mitra PKM</h1>
            <p class="text-sm text-slate-600 mt-1">Pantau pendaftaran mitra baru, status verifikasi berkas, dan aktivitas etalase publik.</p>
        </div>
        <div class="flex items-center gap-2.5">
            <a href="{{ route('admin.verifications.index') }}" class="px-4 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs sm:text-sm rounded-xl shadow-md shadow-emerald-600/20 transition flex items-center gap-2">
                <i class="fa-solid fa-user-check"></i>
                <span>Tinjau Pendaftar ({{ $totalPending }})</span>
            </a>
            <a href="{{ route('home') }}" target="_blank" class="px-4 py-2.5 bg-white hover:bg-slate-50 text-slate-700 font-semibold text-xs sm:text-sm rounded-xl border border-slate-300 shadow-xs transition flex items-center gap-1.5">
                <i class="fa-solid fa-globe text-emerald-600"></i> Portal Publik
            </a>
        </div>
    </div>

    <!-- 5 KPI Summary Cards -->
    <div class="grid grid-cols-2 md:grid-cols-5 gap-4 mb-8">
        <!-- 1. Total Pendaftar -->
        <div class="bg-white rounded-2xl border border-slate-200 p-5 shadow-xs">
            <span class="text-slate-500 text-xs font-semibold uppercase tracking-wider block mb-1">Total Akun Owner</span>
            <div class="flex items-baseline justify-between">
                <span class="text-2xl sm:text-3xl font-extrabold text-slate-900">{{ $totalOwners }}</span>
                <div class="w-8 h-8 rounded-lg bg-slate-100 text-slate-600 flex items-center justify-center text-sm">
                    <i class="fa-solid fa-users"></i>
                </div>
            </div>
            <span class="text-[11px] text-slate-400 mt-2 block">Pendaftar terdaftar</span>
        </div>

        <!-- 2. Menunggu Verifikasi -->
        <div class="bg-amber-50 rounded-2xl border border-amber-200 p-5 shadow-xs relative overflow-hidden">
            <span class="text-amber-800 text-xs font-bold uppercase tracking-wider block mb-1">Menunggu Verifikasi</span>
            <div class="flex items-baseline justify-between">
                <span class="text-2xl sm:text-3xl font-extrabold text-amber-900">{{ $totalPending }}</span>
                <div class="w-8 h-8 rounded-lg bg-amber-500 text-white flex items-center justify-center text-sm animate-pulse">
                    <i class="fa-solid fa-clock"></i>
                </div>
            </div>
            <a href="{{ route('admin.verifications.index', ['status' => 'pending']) }}" class="text-[11px] font-bold text-amber-700 hover:underline mt-2 block">
                Perlu ditinjau &rarr;
            </a>
        </div>

        <!-- 3. Mitra Disetujui -->
        <div class="bg-white rounded-2xl border border-slate-200 p-5 shadow-xs">
            <span class="text-slate-500 text-xs font-semibold uppercase tracking-wider block mb-1">Disetujui</span>
            <div class="flex items-baseline justify-between">
                <span class="text-2xl sm:text-3xl font-extrabold text-emerald-600">{{ $totalApproved }}</span>
                <div class="w-8 h-8 rounded-lg bg-emerald-100 text-emerald-700 flex items-center justify-center text-sm">
                    <i class="fa-solid fa-circle-check"></i>
                </div>
            </div>
            <span class="text-[11px] text-slate-400 mt-2 block">Lolos verifikasi</span>
        </div>

        <!-- 4. Mitra Ditolak -->
        <div class="bg-white rounded-2xl border border-slate-200 p-5 shadow-xs">
            <span class="text-slate-500 text-xs font-semibold uppercase tracking-wider block mb-1">Ditolak</span>
            <div class="flex items-baseline justify-between">
                <span class="text-2xl sm:text-3xl font-extrabold text-rose-600">{{ $totalRejected }}</span>
                <div class="w-8 h-8 rounded-lg bg-rose-100 text-rose-700 flex items-center justify-center text-sm">
                    <i class="fa-solid fa-circle-xmark"></i>
                </div>
            </div>
            <span class="text-[11px] text-slate-400 mt-2 block">Perlu revisi berkas</span>
        </div>

        <!-- 5. Mitra Aktif -->
        <div class="bg-white rounded-2xl border border-slate-200 p-5 shadow-xs col-span-2 md:col-span-1">
            <span class="text-slate-500 text-xs font-semibold uppercase tracking-wider block mb-1">Mitra Live</span>
            <div class="flex items-baseline justify-between">
                <span class="text-2xl sm:text-3xl font-extrabold text-teal-600">{{ $totalActiveMitras }}</span>
                <div class="w-8 h-8 rounded-lg bg-teal-100 text-teal-700 flex items-center justify-center text-sm">
                    <i class="fa-solid fa-store"></i>
                </div>
            </div>
            <span class="text-[11px] text-slate-400 mt-2 block">Aktif di etalase</span>
        </div>
    </div>

    <!-- Quick Antrean Pendaftaran Pending -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 mb-8">
        <div class="flex items-center justify-between pb-4 border-b border-slate-200 mb-5">
            <div>
                <h2 class="text-base font-bold text-slate-900 flex items-center gap-2">
                    <span class="w-2.5 h-2.5 rounded-full bg-amber-500 animate-ping"></span>
                    Antrean Verifikasi Pendaftar Baru
                </h2>
                <p class="text-xs text-slate-500 mt-0.5">Tinjau kelengkapan identitas dan data usaha mitra sebelum memberikan izin promosi.</p>
            </div>
            <a href="{{ route('admin.verifications.index') }}" class="text-xs font-bold text-emerald-600 hover:text-emerald-700 hover:underline">
                Lihat Semua Antrean &rarr;
            </a>
        </div>

        @if ($recentPending->count() === 0)
            <div class="text-center py-8 text-xs text-slate-500">
                <i class="fa-solid fa-circle-check text-emerald-500 text-2xl mb-2 block"></i>
                Semua pendaftaran telah selesai diverifikasi! Tidak ada antrean pending saat ini.
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs">
                    <thead>
                        <tr class="text-slate-500 border-b border-slate-200 uppercase tracking-wider">
                            <th class="py-3 px-3">Usaha / Pemilik</th>
                            <th class="py-3 px-3">Jenis</th>
                            <th class="py-3 px-3">Kontak WhatsApp</th>
                            <th class="py-3 px-3">Alamat</th>
                            <th class="py-3 px-3 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-slate-700">
                        @foreach ($recentPending as $mitra)
                            <tr class="hover:bg-slate-50 transition">
                                <td class="py-3.5 px-3">
                                    <span class="font-bold text-slate-900 block text-sm">{{ $mitra->nama_usaha }}</span>
                                    <span class="text-slate-500 text-[11px]">{{ $mitra->user?->name }} ({{ $mitra->user?->email }})</span>
                                </td>
                                <td class="py-3.5 px-3">
                                    <span class="font-bold uppercase text-[10px] px-2 py-0.5 rounded bg-emerald-100 text-emerald-800">
                                        {{ $mitra->jenis }}
                                    </span>
                                </td>
                                <td class="py-3.5 px-3 font-mono">
                                    {{ $mitra->kontak }}
                                </td>
                                <td class="py-3.5 px-3 max-w-xs truncate text-slate-500">
                                    {{ $mitra->alamat }}
                                </td>
                                <td class="py-3.5 px-3 text-right">
                                    <a href="{{ route('admin.verifications.show', $mitra->id) }}" class="inline-flex items-center gap-1 px-3 py-1.5 bg-emerald-600 hover:bg-emerald-700 text-white font-bold rounded-lg transition shadow-xs">
                                        <i class="fa-solid fa-magnifying-glass text-[10px]"></i> Periksa & Verifikasi
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>

    <!-- Quick Navigation Shortcuts -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white rounded-2xl border border-slate-200 shadow-xs p-6 flex flex-col justify-between">
            <div>
                <div class="w-10 h-10 rounded-xl bg-slate-900 text-white flex items-center justify-center text-lg mb-3">
                    <i class="fa-solid fa-building"></i>
                </div>
                <h3 class="font-bold text-slate-900 text-sm mb-1">Daftar & Kelola Semua Mitra</h3>
                <p class="text-xs text-slate-500 mb-4 leading-relaxed">
                    Atur status operasional mitra, sembunyikan atau tampilkan di beranda, dan kelola urutan kartu.
                </p>
            </div>
            <a href="{{ route('admin.mitras.index') }}" class="text-xs font-bold text-emerald-600 hover:underline">
                Buka Direktori Mitra &rarr;
            </a>
        </div>

        <div class="bg-white rounded-2xl border border-slate-200 shadow-xs p-6 flex flex-col justify-between">
            <div>
                <div class="w-10 h-10 rounded-xl bg-teal-600 text-white flex items-center justify-center text-lg mb-3">
                    <i class="fa-solid fa-sliders"></i>
                </div>
                <h3 class="font-bold text-slate-900 text-sm mb-1">Pengaturan Halaman Utama</h3>
                <p class="text-xs text-slate-500 mb-4 leading-relaxed">
                    Ubah judul hero besar "Mitra PKM", deskripsi singkat direktori, dan kontak pusat bantuan.
                </p>
            </div>
            <a href="{{ route('admin.settings.index') }}" class="text-xs font-bold text-emerald-600 hover:underline">
                Atur Halaman Awal &rarr;
            </a>
        </div>

        <div class="bg-white rounded-2xl border border-slate-200 shadow-xs p-6 flex flex-col justify-between">
            <div>
                <div class="w-10 h-10 rounded-xl bg-emerald-600 text-white flex items-center justify-center text-lg mb-3">
                    <i class="fa-solid fa-globe"></i>
                </div>
                <h3 class="font-bold text-slate-900 text-sm mb-1">Lihat Halaman Publik</h3>
                <p class="text-xs text-slate-500 mb-4 leading-relaxed">
                    Buka tampilan portal publik untuk memeriksa kartu mitra, fitur pencarian, dan tautan etalase.
                </p>
            </div>
            <a href="{{ route('home') }}" target="_blank" class="text-xs font-bold text-emerald-600 hover:underline">
                Kunjungi Portal Utama &rarr;
            </a>
        </div>
    </div>

</div>
@endsection
