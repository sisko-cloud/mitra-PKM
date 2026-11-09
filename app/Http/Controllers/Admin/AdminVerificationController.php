<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Mitra;
use App\Notifications\OwnerStatusChangedNotification;
use App\Services\MitraWebsiteGeneratorService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

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

        $user->update([
            'status' => 'approved',
            'rejection_reason' => null,
        ]);

        // Auto-generate template website 4 section
        $generator->generateTemplate($mitra);

        // Kirim notifikasi (In-App Database + Email via log)
        $user->notify(new OwnerStatusChangedNotification('approved'));

        return redirect()->route('admin.verifications.index')
            ->with('success', "Pendaftaran '{$mitra->nama_usaha}' berhasil disetujui! Template website promosi otomatis dibuat dan notifikasi telah dikirim.");
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

        // Kirim notifikasi dengan alasan
        $user->notify(new OwnerStatusChangedNotification('rejected', $request->rejection_reason));

        return redirect()->route('admin.verifications.index')
            ->with('info', "Pendaftaran '{$mitra->nama_usaha}' telah ditolak dengan alasan yang ditentukan. Notifikasi telah dikirim ke owner.");
    }
}
