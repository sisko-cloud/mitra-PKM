<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Mitra;
use App\Models\User;
use Illuminate\View\View;

class AdminDashboardController extends Controller
{
    public function index(): View
    {
        $totalOwners = User::where('role', 'owner')->count();
        $totalPending = User::where('role', 'owner')->where('status', 'pending')->count();
        $totalApproved = User::where('role', 'owner')->where('status', 'approved')->count();
        $totalRejected = User::where('role', 'owner')->where('status', 'rejected')->count();
        $totalActiveMitras = Mitra::where('is_active', true)->whereHas('user', function ($q) {
            $q->where('status', 'approved');
        })->count();

        // Pendaftar terbaru
        $recentPending = Mitra::with('user')
            ->whereHas('user', function ($q) {
                $q->where('status', 'pending');
            })
            ->latest()
            ->take(5)
            ->get();

        $recentMitras = Mitra::with('user')
            ->latest()
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'totalOwners',
            'totalPending',
            'totalApproved',
            'totalRejected',
            'totalActiveMitras',
            'recentPending',
            'recentMitras'
        ));
    }
}
