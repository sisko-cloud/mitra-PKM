<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Mitra PKM') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

        <!-- Tailwind via CDN: halaman auth tidak lagi bergantung pada build Vite,
             sehingga tetap tampil normal di serverless maupun saat development. -->
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
    </head>
    <body class="font-sans text-slate-800 antialiased">
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-slate-100">
            <div>
                <a href="/" class="inline-flex items-center justify-center w-16 h-16 rounded-2xl bg-emerald-600 text-white shadow-lg shadow-emerald-600/30">
                    <x-application-logo class="w-9 h-9 fill-current text-white" />
                </a>
            </div>

            <div class="w-full sm:max-w-md mt-6 px-6 py-6 bg-white shadow-xl shadow-slate-200/50 border border-slate-200 overflow-hidden sm:rounded-2xl">
                {{ $slot }}
            </div>
        </div>
        @include('partials.password-toggle')
    </body>
</html>
