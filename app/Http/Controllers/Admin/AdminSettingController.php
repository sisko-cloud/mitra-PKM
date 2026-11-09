<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SiteSetting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AdminSettingController extends Controller
{
    public function index(): View
    {
        $settings = [
            'hero_title' => SiteSetting::get('hero_title', 'Mitra PKM'),
            'hero_description' => SiteSetting::get('hero_description', 'Direktori resmi dan platform etalase promosi digital UMKM & Koperasi binaan Program Kreativitas Mahasiswa (PKM).'),
            'hero_badge' => SiteSetting::get('hero_badge', 'Platform Resmi Etalase UMKM & Koperasi PKM'),
            'contact_email' => SiteSetting::get('contact_email', 'admin@mitrapkm.id'),
            'contact_phone' => SiteSetting::get('contact_phone', '+6281234567890'),
        ];

        return view('admin.settings.index', compact('settings'));
    }

    public function update(Request $request): RedirectResponse
    {
        $request->validate([
            'hero_title' => ['required', 'string', 'max:255'],
            'hero_description' => ['required', 'string', 'max:1000'],
            'hero_badge' => ['nullable', 'string', 'max:255'],
            'contact_email' => ['nullable', 'email', 'max:255'],
            'contact_phone' => ['nullable', 'string', 'max:50'],
        ], [
            'hero_title.required' => 'Judul halaman utama wajib diisi.',
            'hero_description.required' => 'Deskripsi halaman utama wajib diisi.',
        ]);

        SiteSetting::set('hero_title', $request->hero_title);
        SiteSetting::set('hero_description', $request->hero_description);
        SiteSetting::set('hero_badge', $request->hero_badge);
        SiteSetting::set('contact_email', $request->contact_email);
        SiteSetting::set('contact_phone', $request->contact_phone);

        return back()->with('success', 'Pengaturan halaman awal dan informasi kontak berhasil diperbarui!');
    }
}
