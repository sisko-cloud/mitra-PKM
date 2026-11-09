<?php

namespace App\Http\Controllers;

use App\Models\Mitra;
use App\Models\SiteSetting;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PublicHomeController extends Controller
{
    public function index(Request $request): View
    {
        $search = $request->query('q');
        $filterJenis = $request->query('jenis');

        $heroTitle = SiteSetting::get('hero_title', 'Mitra PKM');
        $heroDescription = SiteSetting::get('hero_description', 'Direktori resmi dan platform etalase promosi digital UMKM & Koperasi mitra Program Kreativitas Mahasiswa (PKM). Temukan produk unggulan dan dukung karya anak bangsa.');
        $heroBadge = SiteSetting::get('hero_badge', 'Platform Resmi Etalase UMKM & Koperasi PKM');

        $query = Mitra::with(['websiteContent', 'products', 'user'])
            ->where('is_active', true)
            ->where('is_published', true)
            ->where('is_visible_on_home', true)
            ->whereHas('user', function ($q) {
                $q->where('status', 'approved');
            })
            ->orderBy('urutan_tampil', 'asc')
            ->latest();

        if (! empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('nama_usaha', 'like', "%{$search}%")
                  ->orWhere('alamat', 'like', "%{$search}%")
                  ->orWhereHas('websiteContent', function ($wq) use ($search) {
                      $wq->where('tagline', 'like', "%{$search}%")
                         ->orWhere('deskripsi', 'like', "%{$search}%");
                  });
            });
        }

        if (! empty($filterJenis) && in_array($filterJenis, ['umkm', 'koperasi'])) {
            $query->where('jenis', $filterJenis);
        }

        $mitras = $query->paginate(9)->withQueryString();

        $totalMitraCount = Mitra::where('is_active', true)
            ->where('is_published', true)
            ->whereHas('user', fn ($q) => $q->where('status', 'approved'))
            ->count();

        return view('welcome', compact(
            'heroTitle',
            'heroDescription',
            'heroBadge',
            'mitras',
            'search',
            'filterJenis',
            'totalMitraCount'
        ));
    }
}
