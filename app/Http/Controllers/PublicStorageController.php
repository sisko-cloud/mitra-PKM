<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class PublicStorageController extends Controller
{
    /**
     * Serve uploaded storage files with fallback support for serverless environments.
     */
    public function show(string $path)
    {
        // Sanitize path to prevent directory traversal
        $cleanPath = str_replace(['..', '\\'], ['', '/'], $path);
        $cleanPath = ltrim($cleanPath, '/');

        // 1. Check primary storage path (local / default disk)
        $primaryPath = storage_path('app/public/' . $cleanPath);
        if (file_exists($primaryPath) && is_file($primaryPath)) {
            return response()->file($primaryPath);
        }

        // 2. Check /tmp serverless storage path
        $tmpPath = '/tmp/storage/app/public/' . $cleanPath;
        if (file_exists($tmpPath) && is_file($tmpPath)) {
            return response()->file($tmpPath);
        }

        // 3. Fallback placeholder for images so UI doesn't break
        if (preg_match('/\.(jpg|jpeg|png|webp|gif|svg)$/i', $cleanPath)) {
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

        abort(404);
    }
}
