@extends('layouts.public')

@section('title', 'Masuk Akun - Mitra PKM')

@section('content')
<div class="min-h-[80vh] flex flex-col justify-center py-12 sm:px-6 lg:px-8">
    <div class="sm:mx-auto sm:w-full sm:max-w-md text-center">
        <div class="inline-flex items-center justify-center w-14 h-14 rounded-2xl bg-emerald-600 text-white shadow-lg shadow-emerald-600/30 text-2xl font-black mb-4">
            <i class="fa-solid fa-lock"></i>
        </div>
        <h2 class="text-3xl font-extrabold text-slate-900 tracking-tight">Masuk ke Portal Mitra PKM</h2>
        <p class="mt-2 text-sm text-slate-600">
            Akses dashboard pengelolaan website promosi UMKM & Koperasi Anda
        </p>
    </div>

    <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-md">
        <div class="bg-white py-8 px-4 shadow-xl shadow-slate-200/50 sm:rounded-2xl sm:px-10 border border-slate-200">
            
            @if (app()->environment('local'))
                <!-- Quick Demo Credentials Callout (hanya tampil di lingkungan lokal) -->
                <div class="mb-6 p-3.5 bg-emerald-50 border border-emerald-200 rounded-xl text-xs text-emerald-900 leading-relaxed">
                    <div class="font-bold flex items-center gap-1.5 mb-1 text-emerald-800">
                        <i class="fa-solid fa-key"></i> Akun Bawaan untuk Pengujian Lokal:
                    </div>
                    <div class="space-y-0.5">
                        <div>&bull; <strong>Superadmin:</strong> <code class="bg-emerald-100 px-1 py-0.5 rounded text-emerald-900 font-mono">admin@mitrapkm.id</code> / <code class="bg-emerald-100 px-1 py-0.5 rounded text-emerald-900 font-mono">password123</code></div>
                        <div>&bull; <strong>Owner Disetujui:</strong> <code class="bg-emerald-100 px-1 py-0.5 rounded text-emerald-900 font-mono">owner1@kopisenopati.id</code> / <code class="bg-emerald-100 px-1 py-0.5 rounded text-emerald-900 font-mono">password123</code></div>
                        <div>&bull; <strong>Owner Pending:</strong> <code class="bg-emerald-100 px-1 py-0.5 rounded text-emerald-900 font-mono">pending@batikprabu.com</code> / <code class="bg-emerald-100 px-1 py-0.5 rounded text-emerald-900 font-mono">password123</code></div>
                    </div>
                </div>
            @endif

            <!-- Session Status & Errors -->
            @if (session('status'))
                <div class="mb-4 text-xs font-semibold text-emerald-600 bg-emerald-50 p-3 rounded-lg border border-emerald-200">
                    {{ session('status') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="mb-4 text-xs font-medium text-rose-600 bg-rose-50 p-3 rounded-lg border border-rose-200 space-y-1">
                    @foreach ($errors->all() as $error)
                        <div>&bull; {{ $error }}</div>
                    @endforeach
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}" class="space-y-5">
                @csrf

                <!-- Email -->
                <div>
                    <label for="email" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                        Alamat Email
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400 text-sm">
                            <i class="fa-regular fa-envelope"></i>
                        </div>
                        <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                            class="block w-full pl-10 pr-3 py-2.5 border border-slate-300 rounded-xl text-sm placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition">
                    </div>
                </div>

                <!-- Password -->
                <div>
                    <div class="flex items-center justify-between mb-1.5">
                        <label for="password" class="block text-xs font-bold uppercase tracking-wider text-slate-700">
                            Kata Sandi
                        </label>
                    </div>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400 text-sm">
                            <i class="fa-solid fa-lock"></i>
                        </div>
                        <input id="password" type="password" name="password" required autocomplete="current-password"
                            class="block w-full pl-10 pr-3 py-2.5 border border-slate-300 rounded-xl text-sm placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition">
                    </div>
                </div>

                <!-- Remember Me -->
                <div class="flex items-center justify-between text-xs">
                    <label class="flex items-center gap-2 cursor-pointer text-slate-600">
                        <input type="checkbox" name="remember" class="w-4 h-4 rounded text-emerald-600 focus:ring-emerald-500 border-slate-300">
                        <span>Ingat saya di perangkat ini</span>
                    </label>
                </div>

                <div>
                    <button type="submit" class="w-full flex justify-center py-3 px-4 border border-transparent rounded-xl shadow-md text-sm font-bold text-white bg-emerald-600 hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500 transition shadow-emerald-600/30">
                        Masuk Sekarang <i class="fa-solid fa-arrow-right ml-2 mt-1"></i>
                    </button>
                </div>
            </form>

            <div class="mt-6 pt-6 border-t border-slate-200 text-center">
                <p class="text-xs text-slate-600">
                    Belum mendaftarkan usaha Anda?
                    <a href="{{ route('register') }}" class="font-bold text-emerald-600 hover:text-emerald-700 hover:underline">
                        Daftar sebagai Mitra Baru &rarr;
                    </a>
                </p>
            </div>

        </div>
    </div>
</div>
@endsection
