<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Services\FileUploadService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class OwnerStatusController extends Controller
{
    public function index(): View|RedirectResponse
    {
        $user = Auth::user();

        // Jika sudah disetujui, langsung arahkan ke dashboard editor
        if ($user->isApproved()) {
            return redirect()->route('owner.dashboard');
        }

        $mitra = $user->mitra;
        $notifications = $user->notifications()->take(5)->get();

        return view('owner.status', compact('user', 'mitra', 'notifications'));
    }

    public function resubmit(Request $request): RedirectResponse
    {
        $user = Auth::user();

        if (! $user->isRejected()) {
            return redirect()->route('owner.status');
        }

        $request->validate([
            'nama_usaha' => ['required', 'string', 'max:255'],
            'jenis' => ['required', 'in:umkm,koperasi'],
            'alamat' => ['required', 'string'],
            'kontak' => ['required', 'string', 'max:50'],
            'logo' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'dokumen_pendukung' => ['nullable', 'file', 'mimes:jpg,jpeg,png,webp,pdf', 'max:2048'],
        ], [
            'nama_usaha.required' => 'Nama usaha wajib diisi.',
            'alamat.required' => 'Alamat usaha wajib diisi.',
            'kontak.required' => 'Nomor kontak / WhatsApp wajib diisi.',
            'logo.max' => 'Ukuran logo maksimal 2 MB.',
            'dokumen_pendukung.max' => 'Ukuran dokumen maksimal 2 MB.',
        ]);

        $mitra = $user->mitra;

        $updateData = [
            'nama_usaha' => $request->nama_usaha,
            'jenis' => $request->jenis,
            'alamat' => $request->alamat,
            'kontak' => $request->kontak,
        ];

        // Ganti logo jika diunggah baru
        if ($request->hasFile('logo')) {
            if ($mitra && $mitra->logo) {
                FileUploadService::delete($mitra->logo);
            }
            $newLogo = FileUploadService::upload($request->file('logo'), 'logos');
            if ($newLogo) {
                $updateData['logo'] = $newLogo;
            }
        }

        // Ganti dokumen jika diunggah baru
        if ($request->hasFile('dokumen_pendukung')) {
            if ($mitra && $mitra->dokumen_pendukung) {
                FileUploadService::delete($mitra->dokumen_pendukung, 'local');
            }
            $newDokumen = FileUploadService::upload($request->file('dokumen_pendukung'), 'dokumen', 'local');
            if ($newDokumen) {
                $updateData['dokumen_pendukung'] = $newDokumen;
            }
        }

        if ($mitra) {
            $mitra->update($updateData);
        }

        // Kembalikan status menjadi pending dan hapus alasan penolakan
        $user->update([
            'status' => 'pending',
            'rejection_reason' => null,
        ]);

        return redirect()->route('owner.status')->with('success', 'Data perbaikan berhasil dikirim ulang! Akun Anda kini kembali dalam antrean verifikasi Superadmin.');
    }
}
