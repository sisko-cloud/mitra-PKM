<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\WebsiteContent;
use App\Services\FileUploadService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class OwnerHeroController extends Controller
{
    public function edit(): View
    {
        $mitra = Auth::user()->mitra;
        $content = $mitra->websiteContent ?? new WebsiteContent(['mitra_id' => $mitra->id]);

        return view('owner.sections.hero', compact('mitra', 'content'));
    }

    public function update(Request $request): RedirectResponse
    {
        $mitra = Auth::user()->mitra;

        $request->validate([
            'judul' => ['required', 'string', 'max:255'],
            'tagline' => ['nullable', 'string', 'max:255'],
            'hero_image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ], [
            'judul.required' => 'Judul website wajib diisi.',
            'hero_image.max' => 'Ukuran gambar sampul maksimal 2 MB.',
            'hero_image.mimes' => 'Format gambar harus JPG, JPEG, PNG, atau WEBP.',
        ]);

        $content = $mitra->websiteContent;
        if (! $content) {
            $content = new WebsiteContent(['mitra_id' => $mitra->id]);
        }

        $imagePath = $content->hero_image;
        if ($request->hasFile('hero_image')) {
            // Hapus file lama jika ada
            if ($content->hero_image) {
                FileUploadService::delete($content->hero_image);
            }
            $uploaded = FileUploadService::toBase64($request->file('hero_image'));
            if ($uploaded) {
                $imagePath = $uploaded;
            }
        }

        $content->judul = $request->judul;
        $content->tagline = $request->tagline;
        $content->hero_image = $imagePath;
        $content->save();

        return back()->with('success', 'Section Beranda / Judul berhasil disimpan!');
    }
}
