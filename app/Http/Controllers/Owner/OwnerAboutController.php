<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\WebsiteContent;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
        ]);

        $content = $mitra->websiteContent;
        if (! $content) {
            $content = new WebsiteContent(['mitra_id' => $mitra->id, 'judul' => $mitra->nama_usaha]);
        }

        $content->deskripsi = $request->deskripsi;
        $content->sejarah = $request->sejarah;
        $content->visi_misi = $request->visi_misi;
        $content->save();

        return back()->with('success', 'Section Tentang & Visi Misi berhasil diperbarui!');
    }
}
