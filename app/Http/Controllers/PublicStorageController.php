<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;

class PublicStorageController extends Controller
{
    /**
     * Sajikan HANYA gambar publik (logo, hero, foto produk) untuk deployment
     * serverless. Dokumen pendukung (KTP/legalitas) tidak pernah disajikan
     * lewat route publik ini.
     */
    public function show(string $path)
    {
        // Sanitasi path untuk mencegah directory traversal.
        $cleanPath = str_replace(['..', '\\'], ['', '/'], $path);
        $cleanPath = ltrim($cleanPath, '/');

        // Allowlist: hanya folder gambar publik dan ekstensi gambar.
        $isPublicImage = preg_match('#^(logos|heroes|products)/[A-Za-z0-9._-]+$#', $cleanPath)
            && preg_match('/\.(jpg|jpeg|png|webp|gif)$/i', $cleanPath);

        if (! $isPublicImage) {
            abort(404);
        }

        // 1. Disk public Laravel (development / data lama).
        try {
            if (Storage::disk('public')->exists($cleanPath)) {
                return response()->file(Storage::disk('public')->path($cleanPath), [
                    'Cache-Control' => 'public, max-age=86400',
                ]);
            }
        } catch (\Throwable $e) {
            // Lanjut ke fallback /tmp.
        }

        // 2. Fallback serverless lama.
        $tmpPath = '/tmp/storage/app/public/' . $cleanPath;

        if (is_file($tmpPath)) {
            return response()->file($tmpPath, [
                'Cache-Control' => 'public, max-age=86400',
            ]);
        }

        // 3. Placeholder agar UI tidak menampilkan broken image.
        $svg = <<<SVG
<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 200 200" width="200" height="200">
    <rect width="200" height="200" fill="#f8fafc"/>
    <circle cx="100" cy="80" r="32" fill="#cbd5e1"/>
    <path d="M40 160 C40 120, 160 120, 160 160 Z" fill="#94a3b8"/>
    <text x="50%" y="185" dominant-baseline="middle" text-anchor="middle" font-family="-apple-system, BlinkMacSystemFont, Segoe UI, Roboto, Helvetica, Arial, sans-serif" font-size="12" font-weight="600" fill="#64748b">Mitra PKM</text>
</svg>
SVG;

        return response($svg, 200, [
            'Content-Type' => 'image/svg+xml',
            'Cache-Control' => 'public, max-age=86400',
        ]);
    }
}
