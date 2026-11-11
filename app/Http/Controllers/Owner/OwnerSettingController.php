<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\Mitra;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\View\View;

class OwnerSettingController extends Controller
{
    // Daftar reserved keywords agar slug tidak bentrok dengan rute sistem
    protected array $reservedSlugs = [
        'admin', 'owner', 'login', 'register', 'logout', 'dashboard', 'status',
        'api', 'mitra', 'settings', 'profile', 'assets', 'storage', 'public',
    ];

    public function edit(): View
    {
        $mitra = Auth::user()->mitra;
        $publicUrl = route('mitra.show', ['slug' => $mitra->slug]);
        $waShareUrl = 'https://api.whatsapp.com/send?text=' . urlencode("Kunjungi website promosi resmi {$mitra->nama_usaha}: " . $publicUrl);

        return view('owner.settings', compact('mitra', 'publicUrl', 'waShareUrl'));
    }

    public function update(Request $request): RedirectResponse
    {
        $mitra = Auth::user()->mitra;

        $request->validate([
            'slug' => [
                'required',
                'string',
                'min:3',
                'max:100',
                'regex:/^[a-z0-9\-]+$/',
                'unique:mitras,slug,' . $mitra->id,
            ],
            'is_active' => ['nullable', 'boolean'],
        ], [
            'slug.required' => 'Slug URL wajib diisi.',
            'slug.regex' => 'Slug hanya boleh berisi huruf kecil, angka, dan tanda hubung (-).',
            'slug.unique' => 'Slug URL ini sudah digunakan oleh mitra lain.',
        ]);

        $slug = Str::slug($request->slug);

        if (in_array($slug, $this->reservedSlugs)) {
            return back()->withErrors(['slug' => 'Slug tersebut adalah kata kunci cadangan sistem dan tidak dapat digunakan.'])->withInput();
        }

        $mitra->slug = $slug;
        $mitra->is_active = $request->boolean('is_active');
        $mitra->save();

        return back()->with('success', 'Pengaturan website dan URL berhasil disimpan!');
    }

    public function togglePublish(Request $request): RedirectResponse
    {
        $mitra = Auth::user()->mitra;
        $mitra->is_published = ! $mitra->is_published;
        $mitra->save();

        $status = $mitra->is_published ? 'dipublikasikan ke publik' : 'ditarik ke mode draft (pribadi)';
        return back()->with('success', "Website Anda sekarang berhasil {$status}.");
    }

    public function preview(): View
    {
        $mitra = Auth::user()->mitra()->with(['websiteContent', 'products', 'contact'])->firstOrFail();

        // Tampilkan template website dalam mode preview
        return view('mitra.show', [
            'mitra' => $mitra,
            'isPreview' => true,
        ]);
    }
}
