<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class OwnerDashboardController extends Controller
{
    public function index(): View
    {
        $user = Auth::user();
        $mitra = $user->mitra()->with(['websiteContent', 'products', 'contact'])->firstOrFail();

        $notifications = $user->notifications()->take(5)->get();

        $totalProducts = $mitra->products()->count();
        $isReady = ! empty($mitra->websiteContent?->judul) && ! empty($mitra->contact?->whatsapp);

        return view('owner.dashboard', compact('user', 'mitra', 'notifications', 'totalProducts', 'isReady'));
    }
}
