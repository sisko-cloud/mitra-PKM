@props([
    'variant' => 'badge', // 'badge', 'mark', 'full'
    'class' => 'w-10 h-10',
])

@if ($variant === 'badge')
    <div {{ $attributes->merge(['class' => $class . ' rounded-2xl bg-gradient-to-tr from-orange-600 via-orange-500 to-amber-500 p-2 shadow-lg shadow-orange-600/25 flex items-center justify-center transition-transform group-hover:scale-105 ring-2 ring-orange-500/20']) }}>
        <svg viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-full h-full text-white">
            <!-- Facet Fill -->
            <path d="M24 7L40 16.2L24 25.5L8 16.2L24 7Z" fill="white" fill-opacity="0.25" />
            <!-- Outer Geometric Hexagon / Store & Book Structure -->
            <path d="M24 7L40 16.2V34.8L24 43L8 34.8V16.2L24 7Z" stroke="white" stroke-width="3.5" stroke-linejoin="round" stroke-linecap="round" />
            <!-- Central Spine -->
            <path d="M24 25.5V43" stroke="white" stroke-width="3.5" stroke-linecap="round" />
            <!-- Interior Roof / Book Seams -->
            <path d="M8 16.2L24 25.5L40 16.2" stroke="white" stroke-width="3.5" stroke-linejoin="round" stroke-linecap="round" />
            <!-- Upward Innovation Chevron (PKM Growth) -->
            <path d="M16 30L24 34.5L32 30" stroke="#FEF08A" stroke-width="3.5" stroke-linejoin="round" stroke-linecap="round" />
            <!-- Apex Star / Node -->
            <circle cx="24" cy="16.5" r="2.75" fill="#FEF08A" />
        </svg>
    </div>
@elseif ($variant === 'mark')
    <div {{ $attributes->merge(['class' => $class . ' flex items-center justify-center']) }}>
        <svg viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-full h-full drop-shadow-sm">
            <defs>
                <linearGradient id="mp-mark-orange" x1="8" y1="7" x2="40" y2="43" gradientUnits="userSpaceOnUse">
                    <stop offset="0%" stop-color="#FB923C" />
                    <stop offset="50%" stop-color="#F97316" />
                    <stop offset="100%" stop-color="#EA580C" />
                </linearGradient>
                <linearGradient id="mp-mark-gold" x1="16" y1="14" x2="32" y2="32" gradientUnits="userSpaceOnUse">
                    <stop offset="0%" stop-color="#FDE047" />
                    <stop offset="100%" stop-color="#F59E0B" />
                </linearGradient>
            </defs>
            <path d="M24 7L40 16.2V34.8L24 43L8 34.8V16.2L24 7Z" fill="#FFF7ED" fill-opacity="0.8" />
            <path d="M24 7L40 16.2L24 25.5L8 16.2L24 7Z" fill="#FED7AA" fill-opacity="0.5" />
            <path d="M24 7L40 16.2V34.8L24 43L8 34.8V16.2L24 7Z" stroke="url(#mp-mark-orange)" stroke-width="3.5" stroke-linejoin="round" stroke-linecap="round" />
            <path d="M24 25.5V43" stroke="url(#mp-mark-orange)" stroke-width="3.5" stroke-linecap="round" />
            <path d="M8 16.2L24 25.5L40 16.2" stroke="url(#mp-mark-orange)" stroke-width="3.5" stroke-linejoin="round" stroke-linecap="round" />
            <path d="M16 30L24 34.5L32 30" stroke="url(#mp-mark-gold)" stroke-width="3.5" stroke-linejoin="round" stroke-linecap="round" />
            <circle cx="24" cy="16.5" r="2.75" fill="url(#mp-mark-gold)" />
        </svg>
    </div>
@else
    <div {{ $attributes->merge(['class' => 'flex items-center gap-3']) }}>
        <div class="{{ $class }} rounded-2xl bg-gradient-to-tr from-orange-600 via-orange-500 to-amber-500 p-2 shadow-lg shadow-orange-600/25 flex items-center justify-center ring-2 ring-orange-500/20">
            <svg viewBox="0 0 48 48" fill="none" class="w-full h-full text-white">
                <path d="M24 7L40 16.2L24 25.5L8 16.2L24 7Z" fill="white" fill-opacity="0.25" />
                <path d="M24 7L40 16.2V34.8L24 43L8 34.8V16.2L24 7Z" stroke="white" stroke-width="3.5" stroke-linejoin="round" stroke-linecap="round" />
                <path d="M24 25.5V43" stroke="white" stroke-width="3.5" stroke-linecap="round" />
                <path d="M8 16.2L24 25.5L40 16.2" stroke="white" stroke-width="3.5" stroke-linejoin="round" stroke-linecap="round" />
                <path d="M16 30L24 34.5L32 30" stroke="#FEF08A" stroke-width="3.5" stroke-linejoin="round" stroke-linecap="round" />
                <circle cx="24" cy="16.5" r="2.75" fill="#FEF08A" />
            </svg>
        </div>
        <div>
            <span class="text-xl font-extrabold text-slate-900 dark:text-white tracking-tight block leading-tight">
                Mitra <span class="bg-gradient-to-r from-orange-500 to-amber-400 bg-clip-text text-transparent">PKM</span>
            </span>
            <span class="text-[10px] text-slate-500 dark:text-slate-400 font-semibold block uppercase tracking-wider">
                Direktori & Etalase Digital
            </span>
        </div>
    </div>
@endif
