<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Mitra;
use App\Notifications\OwnerStatusChangedNotification;
use App\Services\MitraWebsiteGeneratorService;
use App\Services\VercelBlobService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\StreamedResponse;

class AdminVerificationController extends Controller
{
    public function index(Request $request): View
    {
        $status = $request->query('status', 'all');
        $search = $request->query('q');

        $query = Mitra::with('user')->latest();

        if ($status !== 'all') {
            $query->whereHas('user', function ($q) use ($status) {
                $q->where('status', $status);
            });
        }

        if (! empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('nama_usaha', 'like', "%{$search}%")
                  ->orWhere('alamat', 'like', "%{$search}%")
                  ->orWhereHas('user', function ($uq) use ($search) {
                      $uq->where('name', 'like', "%{$search}%")
                         ->orWhere('email', 'like', "%{$search}%");
                  });
            });
        }

        $mitras = $query->paginate(10)->withQueryString();

        $counts = [
            'all' => Mitra::count(),
            'pending' => Mitra::whereHas('user', fn ($q) => $q->where('status', 'pending'))->count(),
            'approved' => Mitra::whereHas('user', fn ($q) => $q->where('status', 'approved'))->count(),
            'rejected' => Mitra::whereHas('user', fn ($q) => $q->where('status', 'rejected'))->count(),
        ];

        return view('admin.verifications.index', compact('mitras', 'status', 'search', 'counts'));
    }

    public function show(int $id): View
    {
        $mitra = Mitra::with(['user', 'websiteContent', 'products', 'contact'])->findOrFail($id);

        return view('admin.verifications.show', compact('mitra'));
    }

    public function approve(int $id, MitraWebsiteGeneratorService $generator): RedirectResponse
    {
        $mitra = Mitra::with('user')->findOrFail($id);
        $user = $mitra->user;

        // Pastikan status dan pembuatan template berhasil bersama-sama.
        DB::transaction(function () use ($user, $mitra, $generator) {
            $user->update([
                'status' => 'approved',
                'rejection_reason' => null,
            ]);

            // Auto-generate template website 4 section
            $generator->generateTemplate($mitra);
        });

        // Notifikasi tidak boleh menggagalkan proses persetujuan.
        try {
            $user->notify(new OwnerStatusChangedNotification('approved'));
        } catch (\Throwable $e) {
            Log::warning('Notifikasi persetujuan gagal dikirim: ' . $e->getMessage());
        }

        return redirect()->route('admin.verifications.index')
            ->with('success', "Pendaftaran '{$mitra->nama_usaha}' berhasil disetujui! Template website promosi otomatis dibuat dan notifikasi telah dikirim.");
    }

    /**
     * Sajikan dokumen pendukung secara privat (hanya Superadmin).
     */
    public function document(int $id): Response|StreamedResponse
    {
        $mitra = Mitra::findOrFail($id);
        $path = $mitra->dokumen_pendukung;

        abort_if(blank($path), 404, 'Pendaftar tidak mengunggah dokumen pendukung.');

        // Dokumen baru tersimpan di Vercel Blob dengan akses privat.
        if (preg_match('#^https?://#i', $path)) {
            $file = VercelBlobService::download($path);

            abort_if($file === null, 404, 'Dokumen tidak dapat diambil dari penyimpanan.');

            return response($file['body'], 200, [
                'Content-Type' => $file['content_type'],
                'Content-Disposition' => 'inline; filename="' . $file['filename'] . '"',
                'X-Content-Type-Options' => 'nosniff',
                'Cache-Control' => 'private, no-store',
            ]);
        }

        // Dokumen baru tersimpan di disk privat (storage/app/dokumen).
        $disk = Storage::disk('local');

        // Kompatibilitas data lama: dokumen pernah disimpan di disk public.
        if (! $disk->exists($path) && Storage::disk('public')->exists($path)) {
            $disk = Storage::disk('public');
        }

        abort_unless($disk->exists($path), 404, 'Dokumen tidak ditemukan.');

        return $disk->response($path, basename($path), [
            'X-Content-Type-Options' => 'nosniff',
            'Cache-Control' => 'private, no-store',
        ], 'inline');
    }

    public function reject(Request $request, int $id): RedirectResponse
    {
        $request->validate([
            'rejection_reason' => ['required', 'string', 'min:5', 'max:1000'],
        ], [
            'rejection_reason.required' => 'Wajib mengisi alasan penolakan pendaftaran.',
            'rejection_reason.min' => 'Alasan penolakan minimal 5 karakter.',
        ]);

        $mitra = Mitra::with('user')->findOrFail($id);
        $user = $mitra->user;

        $user->update([
            'status' => 'rejected',
            'rejection_reason' => $request->rejection_reason,
        ]);

        // Sembunyikan dari publik bila sempat aktif
        $mitra->update([
            'is_published' => false,
            'is_visible_on_home' => false,
        ]);

        // Notifikasi tidak boleh menggagalkan proses penolakan.
        try {
            $user->notify(new OwnerStatusChangedNotification('rejected', $request->rejection_reason));
        } catch (\Throwable $e) {
            Log::warning('Notifikasi penolakan gagal dikirim: ' . $e->getMessage());
        }

        return redirect()->route('admin.verifications.index')
            ->with('info', "Pendaftaran '{$mitra->nama_usaha}' telah ditolak dengan alasan yang ditentukan. Notifikasi telah dikirim ke owner.");
    }
}
