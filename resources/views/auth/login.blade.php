@extends('layouts.public')

@section('title', 'Masuk Akun - Mitra PKM')

@section('content')
<div class="min-h-[80vh] flex flex-col justify-center py-12 sm:px-6 lg:px-8">
    <div class="sm:mx-auto sm:w-full sm:max-w-md text-center">
        <div class="flex justify-center">
            <x-application-logo class="w-16 h-16 mb-4" />
        </div>
        <h2 class="text-3xl font-extrabold text-slate-900 dark:text-white tracking-tight">Masuk ke Portal Mitra PKM</h2>
        <p class="mt-2 text-sm text-slate-600 dark:text-slate-400">
            Akses dashboard pengelolaan website promosi UMKM & Koperasi Anda
        </p>
    </div>

    <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-md">
        <div class="bg-white dark:bg-slate-900 py-8 px-4 sm:px-10 shadow-xl shadow-slate-200/50 dark:shadow-none sm:rounded-2xl border border-slate-200 dark:border-slate-800 transition-colors">
            
            <!-- Quick Demo Credentials Callout -->
            <div class="mb-6 p-3.5 bg-orange-50 dark:bg-orange-950/40 border border-orange-200 dark:border-orange-800/60 rounded-xl text-xs text-orange-900 dark:text-orange-300 leading-relaxed">
                <div class="font-bold flex items-center gap-1.5 mb-1.5 text-orange-800 dark:text-orange-300">
                    <i class="fa-solid fa-key"></i> Akun Bawaan untuk Pengujian:
                </div>
                <div class="space-y-1 text-[11px] sm:text-xs">
                    <div>&bull; <strong>Superadmin:</strong> <code class="bg-orange-100 dark:bg-orange-900/60 px-1 py-0.5 rounded text-orange-900 dark:text-orange-200 font-mono">admin@mitrapkm.id</code> / <code class="bg-orange-100 dark:bg-orange-900/60 px-1 py-0.5 rounded text-orange-900 dark:text-orange-200 font-mono">password123</code></div>
                    <div>&bull; <strong>Owner Disetujui:</strong> <code class="bg-orange-100 dark:bg-orange-900/60 px-1 py-0.5 rounded text-orange-900 dark:text-orange-200 font-mono">owner1@kopisenopati.id</code> / <code class="bg-orange-100 dark:bg-orange-900/60 px-1 py-0.5 rounded text-orange-900 dark:text-orange-200 font-mono">password123</code></div>
                    <div>&bull; <strong>Owner Pending:</strong> <code class="bg-orange-100 dark:bg-orange-900/60 px-1 py-0.5 rounded text-orange-900 dark:text-orange-200 font-mono">pending@batikprabu.com</code> / <code class="bg-orange-100 dark:bg-orange-900/60 px-1 py-0.5 rounded text-orange-900 dark:text-orange-200 font-mono">password123</code></div>
                </div>
            </div>

            <!-- Session Status & Errors -->
            @if (session('status'))
                <div class="mb-4 text-xs font-semibold text-orange-600 dark:text-orange-400 bg-orange-50 dark:bg-orange-950/40 p-3 rounded-lg border border-orange-200 dark:border-orange-800/60">
                    {{ session('status') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="mb-4 text-xs font-medium text-rose-600 dark:text-rose-400 bg-rose-50 dark:bg-rose-950/40 p-3 rounded-lg border border-rose-200 dark:border-rose-800/60 space-y-1">
                    @foreach ($errors->all() as $error)
                        <div>&bull; {{ $error }}</div>
                    @endforeach
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}" class="space-y-5">
                @csrf

                <!-- Email -->
                <div>
                    <label for="email" class="block text-xs font-bold uppercase tracking-wider text-slate-700 dark:text-slate-300 mb-1.5">
                        Alamat Email
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400 text-sm">
                            <i class="fa-regular fa-envelope"></i>
                        </div>
                        <input id="email" type="email" name="email" value="{{ old('email', 'admin@mitrapkm.id') }}" required autofocus
                            class="block w-full pl-10 pr-3 py-2.5 bg-white dark:bg-slate-800 border border-slate-300 dark:border-slate-700 rounded-xl text-sm text-slate-900 dark:text-white placeholder-slate-400 dark:placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition">
                    </div>
                </div>

                <!-- Password dengan Tombol Mata -->
                <div x-data="{ showPass: false }">
                    <div class="flex items-center justify-between mb-1.5">
                        <label for="password" class="block text-xs font-bold uppercase tracking-wider text-slate-700 dark:text-slate-300">
                            Kata Sandi
                        </label>
                    </div>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400 text-sm">
                            <i class="fa-solid fa-lock"></i>
                        </div>
                        <input id="password" :type="showPass ? 'text' : 'password'" name="password" value="password123" required autocomplete="current-password"
                            class="block w-full pl-10 pr-11 py-2.5 bg-white dark:bg-slate-800 border border-slate-300 dark:border-slate-700 rounded-xl text-sm text-slate-900 dark:text-white placeholder-slate-400 dark:placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition">
                        <button type="button" @click="showPass = !showPass"
                            class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-slate-400 hover:text-slate-600 dark:hover:text-slate-200 transition focus:outline-none"
                            :title="showPass ? 'Sembunyikan kata sandi' : 'Tampilkan kata sandi'"
                            tabindex="-1">
                            <i class="fa-solid text-sm" :class="showPass ? 'fa-eye-slash text-orange-600 dark:text-orange-400' : 'fa-eye'"></i>
                        </button>
                    </div>
                </div>

                <!-- Remember Me -->
                <div class="flex items-center justify-between text-xs">
                    <label class="flex items-center gap-2 cursor-pointer text-slate-600 dark:text-slate-400">
                        <input type="checkbox" name="remember" class="w-4 h-4 rounded text-orange-600 focus:ring-orange-500 border-slate-300 dark:border-slate-600 dark:bg-slate-800">
                        <span>Ingat saya di perangkat ini</span>
                    </label>
                </div>

                <div>
                    <button type="submit" class="w-full flex justify-center items-center gap-2 py-3 px-4 border border-transparent rounded-xl shadow-lg text-sm font-bold text-white bg-gradient-to-r from-orange-600 to-amber-600 hover:from-orange-700 hover:to-amber-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500 transition shadow-orange-600/30">
                        <span>Masuk Sekarang</span>
                        <i class="fa-solid fa-arrow-right text-xs"></i>
                    </button>
                </div>
            </form>

            <div class="mt-6 pt-6 border-t border-slate-200 dark:border-slate-800 text-center">
                <p class="text-xs text-slate-600 dark:text-slate-400">
                    Belum mendaftarkan usaha Anda?
                    <a href="{{ route('register') }}" class="font-bold text-orange-600 dark:text-orange-400 hover:text-orange-700 dark:hover:text-orange-300 hover:underline">
                        Daftar sebagai Mitra Baru &rarr;
                    </a>
                </p>
            </div>

        </div>
    </div>
</div>
@endsection
