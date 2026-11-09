<?php

namespace App\Http\Controllers;

use App\Models\Mitra;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class PublicMitraWebsiteController extends Controller
{
    public function show(string $slug): View
    {
        $mitra = Mitra::with(['websiteContent', 'products', 'contact', 'user'])
            ->where('slug', $slug)
            ->first();

        if (! $mitra) {
            abort(404, 'Halaman website mitra tidak ditemukan.');
        }

        // Cek apakah pemilik yang login sedang melihat halamannya sendiri atau Superadmin
        $isOwnerOrAdmin = Auth::check() && (
            Auth::id() === $mitra->user_id ||
            Auth::user()->isSuperAdmin()
        );

        // Jika pengunjung umum, pastikan status mitra aktif, terpublikasi, dan user disetujui
        if (! $isOwnerOrAdmin) {
            if (! $mitra->is_active || ! $mitra->is_published || ! $mitra->user || ! $mitra->user->isApproved()) {
                abort(404, 'Website mitra ini sedang tidak aktif atau belum dipublikasikan.');
            }
        }

        return view('mitra.show', [
            'mitra' => $mitra,
            'isPreview' => false,
            'isOwnerOrAdmin' => $isOwnerOrAdmin,
        ]);
    }
}
