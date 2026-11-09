<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Mitra PKM') }} - @yield('title', 'Dashboard')</title>

    <!-- Fonts & Tailwind -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['"Plus Jakarta Sans"', 'sans-serif'],
                    },
                    colors: {
                        brand: {
                            50: '#ecfdf5',
                            100: '#d1fae5',
                            500: '#10b981',
                            600: '#059669',
                            700: '#047857',
                            800: '#065f46',
                            900: '#064e3b',
                        }
                    }
                }
            }
        }
    </script>
    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <style>
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="font-sans antialiased bg-slate-100 text-slate-800 min-h-screen flex flex-col selection:bg-emerald-500 selection:text-white">

    <!-- Top Navigation Bar -->
    @include('layouts.navigation')

    <!-- Page Heading -->
    @if (isset($header))
        <header class="bg-white border-b border-slate-200 shadow-xs">
            <div class="max-w-7xl mx-auto py-5 px-4 sm:px-6 lg:px-8">
                {{ $header }}
            </div>
        </header>
    @endif

    <!-- Alert Messages (Flash) -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-6 w-full">
        @if (session('success'))
            <div x-data="{ show: true }" x-show="show" class="mb-4 flex items-center justify-between p-4 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-xl shadow-xs">
                <div class="flex items-center gap-3">
                    <i class="fa-solid fa-circle-check text-emerald-600 text-lg"></i>
                    <span class="text-sm font-medium">{{ session('success') }}</span>
                </div>
                <button @click="show = false" class="text-emerald-500 hover:text-emerald-700">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
        @endif

        @if (session('info'))
            <div x-data="{ show: true }" x-show="show" class="mb-4 flex items-center justify-between p-4 bg-sky-50 border border-sky-200 text-sky-800 rounded-xl shadow-xs">
                <div class="flex items-center gap-3">
                    <i class="fa-solid fa-circle-info text-sky-600 text-lg"></i>
                    <span class="text-sm font-medium">{{ session('info') }}</span>
                </div>
                <button @click="show = false" class="text-sky-500 hover:text-sky-700">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
        @endif

        @if (session('error'))
            <div x-data="{ show: true }" x-show="show" class="mb-4 flex items-center justify-between p-4 bg-rose-50 border border-rose-200 text-rose-800 rounded-xl shadow-xs">
                <div class="flex items-center gap-3">
                    <i class="fa-solid fa-triangle-exclamation text-rose-600 text-lg"></i>
                    <span class="text-sm font-medium">{{ session('error') }}</span>
                </div>
                <button @click="show = false" class="text-rose-500 hover:text-rose-700">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
        @endif

        @if ($errors->any())
            <div x-data="{ show: true }" x-show="show" class="mb-4 p-4 bg-rose-50 border border-rose-200 text-rose-800 rounded-xl shadow-xs">
                <div class="flex items-start gap-3">
                    <i class="fa-solid fa-circle-exclamation text-rose-600 text-lg mt-0.5"></i>
                    <div>
                        <span class="text-sm font-semibold block mb-1">Terdapat beberapa kesalahan input:</span>
                        <ul class="list-disc list-inside text-xs space-y-1">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        @endif
    </div>

    <!-- Page Content -->
    <main class="flex-grow pb-16">
        @yield('content')
        {{ $slot ?? '' }}
    </main>

    <!-- Footer Simple -->
    <footer class="bg-white border-t border-slate-200 py-6 text-center text-xs text-slate-500">
        <div class="max-w-7xl mx-auto px-4 flex flex-col sm:flex-row items-center justify-between gap-2">
            <span>&copy; {{ date('Y') }} <strong>Mitra PKM</strong> - Platform Digitalisasi UMKM & Koperasi</span>
            <div class="flex items-center gap-4">
                <a href="{{ route('home') }}" target="_blank" class="text-emerald-600 hover:underline">
                    <i class="fa-solid fa-arrow-up-right-from-square mr-1"></i> Lihat Portal Publik
                </a>
            </div>
        </div>
    </footer>

</body>
</html>
