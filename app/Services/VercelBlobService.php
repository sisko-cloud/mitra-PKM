<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

/**
 * Klien tipis untuk Vercel Blob REST API.
 *
 * Dipakai sebagai penyimpanan permanen di lingkungan serverless Vercel,
 * karena filesystem /tmp bersifat sementara dan tidak dibagi antar instance.
 * Jika BLOB_READ_WRITE_TOKEN tidak di-set (mis. saat development lokal),
 * service ini otomatis nonaktif dan FileUploadService memakai disk lokal.
 */
class VercelBlobService
{
    /**
     * Apakah store untuk jenis file ini sudah dikonfigurasi?
     */
    public static function enabled(bool $public = true): bool
    {
        return filled(self::token($public));
    }

    /**
     * Upload file ke Vercel Blob dan kembalikan URL absolutnya.
     */
    public static function upload(UploadedFile $file, string $directory, bool $public = true): ?string
    {
        $token = self::token($public);

        if (! $token || ! $file->isValid()) {
            return null;
        }

        $pathname = self::buildPathname($file, $directory);
        $mime = $file->getMimeType() ?: 'application/octet-stream';
        $contents = @file_get_contents($file->getRealPath());

        if ($contents === false) {
            Log::error('Vercel Blob: tidak dapat membaca file upload.');

            return null;
        }

        try {
            $response = Http::withToken($token)
                ->withHeaders([
                    'x-api-version' => '12',
                    'x-vercel-blob-access' => $public ? 'public' : 'private',
                    'x-content-type' => $mime,
                    'x-add-random-suffix' => '0',
                    'Content-Type' => $mime,
                ])
                ->timeout(30)
                ->withBody($contents, $mime)
                ->put(self::apiUrl('/?pathname=' . rawurlencode($pathname)));

            if (! $response->successful()) {
                Log::error('Vercel Blob upload gagal.', [
                    'status' => $response->status(),
                    'body' => Str::limit($response->body(), 500),
                    'pathname' => $pathname,
                ]);

                return null;
            }

            return $response->json('url');
        } catch (\Throwable $e) {
            Log::error('Vercel Blob upload exception: ' . $e->getMessage(), [
                'pathname' => $pathname,
            ]);

            return null;
        }
    }

    /**
     * Hapus blob berdasarkan URL absolut yang tersimpan di database.
     */
    public static function delete(?string $url): void
    {
        if (! $url || ! str_starts_with($url, 'http')) {
            return;
        }

        // Coba token yang sesuai dengan jenis store, lalu token lainnya
        // sebagai fallback (mis. untuk data yang dibuat sebelum pemisahan store).
        $tokens = array_values(array_unique(array_filter([
            self::tokenForUrl($url),
            config('services.vercel_blob.private_token'),
            config('services.vercel_blob.token'),
        ])));

        if (empty($tokens)) {
            return;
        }

        foreach ($tokens as $token) {
            try {
                $response = Http::withToken($token)
                    ->withHeaders(['x-api-version' => '12', 'Accept' => 'application/json'])
                    ->timeout(15)
                    ->post(self::apiUrl('/delete'), ['urls' => [$url]]);

                if ($response->successful()) {
                    return;
                }

                $lastStatus = $response->status();
                $lastBody = Str::limit($response->body(), 300);
            } catch (\Throwable $e) {
                $lastException = $e->getMessage();
            }
        }

        Log::warning('Vercel Blob delete gagal.', array_filter([
            'status' => $lastStatus ?? null,
            'body' => $lastBody ?? null,
            'exception' => $lastException ?? null,
        ]));
    }

    /**
     * Ambil isi blob privat (dokumen pendukung) untuk diproksikan lewat controller.
     *
     * @return array{body: string, content_type: string, filename: string}|null
     */
    public static function download(string $url): ?array
    {
        $token = self::tokenForUrl($url) ?: self::token(false) ?: self::token(true);

        if (! $token || ! str_starts_with($url, 'http')) {
            return null;
        }

        try {
            $response = Http::withToken($token)
                ->timeout(30)
                ->get($url);

            if (! $response->successful()) {
                Log::warning('Vercel Blob download gagal.', [
                    'status' => $response->status(),
                    'url' => $url,
                ]);

                return null;
            }

            return [
                'body' => $response->body(),
                'content_type' => $response->header('Content-Type') ?: 'application/octet-stream',
                'filename' => basename(parse_url($url, PHP_URL_PATH) ?: 'dokumen'),
            ];
        } catch (\Throwable $e) {
            Log::warning('Vercel Blob download exception: ' . $e->getMessage());

            return null;
        }
    }

    private static function token(bool $public): ?string
    {
        $token = $public
            ? config('services.vercel_blob.token')
            : config('services.vercel_blob.private_token');

        return filled($token) ? $token : null;
    }

    private static function tokenForUrl(string $url): ?string
    {
        // Host store privat mengandung ".private.blob.vercel-storage.com".
        if (str_contains($url, '.private.blob.')) {
            return self::token(false);
        }

        return self::token(true);
    }

    private static function buildPathname(UploadedFile $file, string $directory): string
    {
        $extension = strtolower($file->getClientOriginalExtension() ?: $file->extension() ?: 'bin');
        $extension = preg_replace('/[^a-z0-9]/', '', $extension) ?: 'bin';

        return trim($directory, '/') . '/' . Str::random(40) . '.' . $extension;
    }

    private static function apiUrl(string $path = ''): string
    {
        return rtrim(config('services.vercel_blob.api_url'), '/') . $path;
    }
}
