<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class FileUploadService
{
    /**
     * Upload an uploaded file safely, with automatic fallback and zero-crash guarantee.
     *
     * @param UploadedFile|null $file
     * @param string $directory Subfolder inside disk (e.g. 'logos', 'dokumen', 'heroes', 'products')
     * @param string $disk Storage disk to use (default: 'public')
     * @return string|null Relative file path or null if upload is absent or fails
     */
    public static function upload(?UploadedFile $file, string $directory = 'uploads', string $disk = 'public'): ?string
    {
        if (! $file || ! $file->isValid()) {
            return null;
        }

        $cleanDir = trim($directory, '/');

        // Attempt 1: Normal Laravel Storage disk store
        try {
            $path = $file->store($cleanDir, $disk);
            if ($path) {
                return $path;
            }
        } catch (\Throwable $e) {
            Log::warning("Primary storage upload to [{$disk}] failed: " . $e->getMessage() . ". Attempting serverless fallback.");
        }

        // Attempt 2: Direct write to /tmp serverless storage
        try {
            $tmpRoot = '/tmp/storage/app/public/' . $cleanDir;
            if (! is_dir($tmpRoot)) {
                @mkdir($tmpRoot, 0777, true);
            }

            $extension = $file->getClientOriginalExtension() ?: 'bin';
            $filename = Str::random(40) . '.' . $extension;
            $destination = $tmpRoot . '/' . $filename;

            if (@copy($file->getRealPath(), $destination)) {
                return $cleanDir . '/' . $filename;
            }
        } catch (\Throwable $fallbackError) {
            Log::error("Serverless fallback storage upload failed: " . $fallbackError->getMessage());
        }

        // Return null instead of throwing unhandled 500 error
        return null;
    }

    /**
     * Delete an existing file safely across primary disk and serverless fallback.
     *
     * @param string|null $path
     * @param string $disk
     */
    public static function delete(?string $path, string $disk = 'public'): void
    {
        if (! $path) {
            return;
        }

        try {
            if (Storage::disk($disk)->exists($path)) {
                Storage::disk($disk)->delete($path);
            }
        } catch (\Throwable $e) {
            Log::warning("Could not delete file from storage disk: " . $e->getMessage());
        }

        // Also check in /tmp if applicable
        $tmpPath = '/tmp/storage/app/public/' . ltrim($path, '/');
        if (file_exists($tmpPath)) {
            @unlink($tmpPath);
        }
    }
}
