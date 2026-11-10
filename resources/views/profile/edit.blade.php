@extends('layouts.app')

@section('title', 'Pengaturan Profil Pengguna - Mitra PKM')

@section('content')
<div class="w-full px-4 sm:px-6 lg:px-8 py-6 sm:py-8 max-w-5xl mx-auto">

    <!-- Breadcrumb & Header Halaman -->
    <div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <div class="flex items-center gap-2 text-xs font-semibold text-slate-500 dark:text-slate-400 mb-1">
                <a href="{{ Auth::user()->isSuperAdmin() ? route('admin.dashboard') : (Auth::user()->isApproved() ? route('owner.dashboard') : route('owner.status')) }}" class="hover:text-orange-600 dark:hover:text-orange-400 transition flex items-center gap-1">
                    <i class="fa-solid fa-arrow-left"></i> Kembali ke Dashboard
                </a>
                <span>/</span>
                <span class="text-slate-700 dark:text-slate-200">Pengaturan Profil</span>
            </div>
            <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 dark:text-white tracking-tight">
                Pengaturan Profil Akun
            </h1>
            <p class="text-xs sm:text-sm text-slate-500 dark:text-slate-400 mt-0.5">
                Kelola informasi akun pengguna, foto profil avatar, nomor telepon kontak, dan keamanan kata sandi.
            </p>
        </div>

        <div class="flex items-center gap-2">
            @if(Auth::user()->isSuperAdmin())
                <span class="px-3 py-1.5 rounded-xl text-xs font-bold bg-purple-100 dark:bg-purple-950/60 text-purple-700 dark:text-purple-300 border border-purple-200 dark:border-purple-800 flex items-center gap-1.5 shadow-xs">
                    <i class="fa-solid fa-shield-halved"></i> Administrator
                </span>
            @else
                <span class="px-3 py-1.5 rounded-xl text-xs font-bold bg-orange-100 dark:bg-orange-950/60 text-orange-700 dark:text-orange-300 border border-orange-200 dark:border-orange-800 flex items-center gap-1.5 shadow-xs">
                    <i class="fa-solid fa-store"></i> {{ Auth::user()->mitra?->nama_usaha ?? 'Pemilik Usaha' }}
                </span>
            @endif
        </div>
    </div>

    <div class="space-y-6 sm:space-y-8">
        <!-- Section 1: Informasi Profil & Foto Avatar -->
        <div class="bg-white dark:bg-slate-900 rounded-2xl sm:rounded-3xl border border-slate-200 dark:border-slate-800 p-5 sm:p-8 shadow-xs">
            @include('profile.partials.update-profile-information-form')
        </div>

        <!-- Section 2: Keamanan & Perbarui Kata Sandi -->
        <div class="bg-white dark:bg-slate-900 rounded-2xl sm:rounded-3xl border border-slate-200 dark:border-slate-800 p-5 sm:p-8 shadow-xs">
            @include('profile.partials.update-password-form')
        </div>

        <!-- Section 3: Zona Bahaya / Hapus Akun -->
        <div class="bg-white dark:bg-slate-900 rounded-2xl sm:rounded-3xl border border-rose-200 dark:border-rose-900/60 p-5 sm:p-8 shadow-xs">
            @include('profile.partials.delete-user-form')
        </div>
    </div>

</div>
@endsection
