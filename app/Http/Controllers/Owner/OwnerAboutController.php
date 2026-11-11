<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\WebsiteContent;
use App\Services\FileUploadService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\View\View;

class OwnerAboutController extends Controller
{
    public function edit(): View
    {
        $mitra = Auth::user()->mitra;
        $content = $mitra->websiteContent ?? new WebsiteContent(['mitra_id' => $mitra->id]);

        return view('owner.sections.about', compact('mitra', 'content'));
    }

    public function update(Request $request): RedirectResponse
    {
        $mitra = Auth::user()->mitra;

        $request->validate([
            'deskripsi' => ['nullable', 'string', 'max:2000'],
            'sejarah' => ['nullable', 'string', 'max:2000'],
            'visi_misi' => ['nullable', 'string', 'max:2000'],
            'struktur_organisasi' => ['nullable', 'image', 'max:3072'],
        ]);

        $content = $mitra->websiteContent;
        if (! $content) {
            $content = new WebsiteContent(['mitra_id' => $mitra->id, 'judul' => $mitra->nama_usaha]);
        }

        $content->deskripsi = $request->deskripsi;
        $content->sejarah = $request->sejarah;
        $content->visi_misi = $request->visi_misi;

        // Handle hapus gambar struktur
        if ($request->boolean('hapus_struktur')) {
            if ($content->struktur_organisasi && ! Str::startsWith($content->struktur_organisasi, ['http', 'data:'])) {
                FileUploadService::delete($content->struktur_organisasi);
            }
            $content->struktur_organisasi = null;
        } elseif ($request->hasFile('struktur_organisasi')) {
            $file = $request->file('struktur_organisasi');

            if ($content->struktur_organisasi && ! Str::startsWith($content->struktur_organisasi, ['http', 'data:'])) {
                FileUploadService::delete($content->struktur_organisasi);
            }

            $mime = $file->getMimeType() ?: 'image/jpeg';
            $raw = @file_get_contents($file->getRealPath());
            if ($raw && strlen($raw) <= 3 * 1024 * 1024) {
                $content->struktur_organisasi = 'data:' . $mime . ';base64,' . base64_encode($raw);
            } else {
                $content->struktur_organisasi = FileUploadService::upload($file, 'struktur');
            }
        }

        $content->save();

        return back()->with('success', 'Section Tentang & Visi Misi berhasil diperbarui!');
    }
}
