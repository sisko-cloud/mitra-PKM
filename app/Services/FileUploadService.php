<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class FileUploadService
{
    /**
     * Upload file secara aman.
     *
     * - Jika BLOB_READ_WRITE_TOKEN tersedia (produksi Vercel), file disimpan
     *   permanen di Vercel Blob dan yang dikembalikan adalah URL absolut.
     * - Jika tidak, file disimpan di disk lokal dan yang dikembalikan adalah
     *   path relatif (kompatibel dengan data lama).
     *
     * @param  UploadedFile|null  $file
     * @param  string  $directory  Subfolder (mis. 'logos', 'dokumen', 'heroes', 'products')
     * @param  string  $disk  Disk lokal: 'public' untuk gambar, 'local' untuk dokumen privat
     * @return string|null URL absolut (Blob) atau path relatif, null jika gagal
     */
    public static function upload(?UploadedFile $file, string $directory = 'uploads', string $disk = 'public'): ?string
    {
        if (! $file || ! $file->isValid()) {
            return null;
        }

        $cleanDir = trim($directory, '/');
        $isPrivate = $disk === 'local' || $cleanDir === 'dokumen';

        if ($isPrivate && app()->environment('production') && ! VercelBlobService::enabled(false)) {
            Log::warning('BLOB_READ_WRITE_TOKEN_PRIVATE belum dikonfigurasi. Dokumen pendukung akan tersimpan sementara di /tmp dan dapat hilang.');
        }

        // Penyimpanan permanen untuk deployment serverless.
        if (VercelBlobService::enabled(! $isPrivate)) {
            $url = VercelBlobService::upload($file, $cleanDir, ! $isPrivate);

            if ($url) {
                return $url;
            }

            // Jangan diam-diam menulis ke /tmp saat Blob dikonfigurasi tetapi gagal,
            // karena file akan hilang setelah instance serverless di-restart.
            Log::error("Upload ke Vercel Blob gagal untuk direktori [{$cleanDir}]. Periksa token dan koneksi store.");

            return null;
        }

        // Local / development: gunakan disk Laravel.
        try {
            $path = $file->store($cleanDir, $disk);

            if ($path) {
                return $path;
            }
        } catch (\Throwable $e) {
            Log::warning("Upload ke disk [{$disk}] gagal: " . $e->getMessage() . '. Mencoba fallback serverless.');
        }

        // Fallback terakhir hanya untuk gambar publik (bukan dokumen privat).
        if (! $isPrivate) {
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
                Log::error('Fallback storage upload gagal: ' . $fallbackError->getMessage());
            }
        }

        return null;
    }

    /**
     * Hapus file dari Vercel Blob atau disk lokal dengan aman.
     */
    public static function delete(?string $path, string $disk = 'public'): void
    {
        if (! $path) {
            return;
        }

        // URL absolut berarti file berada di Vercel Blob.
        if (preg_match('#^https?://#i', $path)) {
            VercelBlobService::delete($path);

            return;
        }

        try {
            if (Storage::disk($disk)->exists($path)) {
                Storage::disk($disk)->delete($path);
            }
        } catch (\Throwable $e) {
            Log::warning("Gagal menghapus file dari disk [{$disk}]: " . $e->getMessage());
        }

        // Dokumen privat bisa tersimpan di disk 'local' meskipun pemanggil
        // menggunakan disk default. Coba juga di disk satunya.
        $otherDisk = $disk === 'local' ? 'public' : 'local';

        try {
            if (Storage::disk($otherDisk)->exists($path)) {
                Storage::disk($otherDisk)->delete($path);
            }
        } catch (\Throwable $e) {
            Log::warning("Gagal menghapus file dari disk [{$otherDisk}]: " . $e->getMessage());
        }

        // Fallback lama: file publik di /tmp.
        $tmpPath = '/tmp/storage/app/public/' . ltrim($path, '/');

        if (file_exists($tmpPath)) {
            @unlink($tmpPath);
        }
    }

    /**
     * URL publik untuk path relatif lama maupun URL absolut dari Vercel Blob.
     */
    public static function url(?string $path, ?string $fallback = null): string
    {
        if (blank($path)) {
            return $fallback ? asset($fallback) : '';
        }

        if (preg_match('#^https?://#i', $path)) {
            return $path;
        }

        return asset('storage/' . ltrim($path, '/'));
    }
}
