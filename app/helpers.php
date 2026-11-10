<?php

use App\Services\FileUploadService;

if (! function_exists('media_url')) {
    /**
     * Resolve a stored media reference to a public URL.
     *
     * Mendukung data lama (path relatif di disk public) dan data baru
     * (URL absolut dari Vercel Blob).
     */
    function media_url(?string $path, ?string $fallback = null): string
    {
        return FileUploadService::url($path, $fallback);
    }
}
