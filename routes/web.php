<?php

use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminMitraController;
use App\Http\Controllers\Admin\AdminSettingController;
use App\Http\Controllers\Admin\AdminVerificationController;
use App\Http\Controllers\Owner\OwnerAboutController;
use App\Http\Controllers\Owner\OwnerContactController;
use App\Http\Controllers\Owner\OwnerDashboardController;
use App\Http\Controllers\Owner\OwnerHeroController;
use App\Http\Controllers\Owner\OwnerProductController;
use App\Http\Controllers\Owner\OwnerSettingController;
use App\Http\Controllers\Owner\OwnerStatusController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PublicHomeController;
use App\Http\Controllers\PublicMitraWebsiteController;
use App\Http\Controllers\PublicStorageController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes - Mitra PKM
|--------------------------------------------------------------------------
*/

// 1. Halaman Utama Publik
Route::get('/', [PublicHomeController::class, 'index'])->name('home');

// 2. Website Promosi Publik Mitra (Read-Only tanpa login)
Route::get('/mitra/{slug}', [PublicMitraWebsiteController::class, 'show'])->name('mitra.show');

// Storage route fallback for serverless deployments
Route::get('/storage/{path}', [PublicStorageController::class, 'show'])->where('path', '.*')->name('public.storage');

// Redirect cerdas /dashboard ke peran masing-masing
Route::get('/dashboard', function () {
    $user = auth()->user();
    if ($user->isSuperAdmin()) {
        return redirect()->route('admin.dashboard');
    }
    if ($user->isApproved()) {
        return redirect()->route('owner.dashboard');
    }
    return redirect()->route('owner.status');
})->middleware(['auth'])->name('dashboard');

// 3. Rute Status Akun Owner (Pending / Rejected / Suspended)
Route::middleware(['auth'])->group(function () {
    Route::get('/owner/status', [OwnerStatusController::class, 'index'])->name('owner.status');
    Route::post('/owner/status/resubmit', [OwnerStatusController::class, 'resubmit'])->name('owner.status.resubmit');

    // Profile standard
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// 4. Rute Dashboard Owner / Editor (Wajib login & status approved)
Route::middleware(['auth', 'owner.approved'])->prefix('owner')->name('owner.')->group(function () {
    Route::get('/dashboard', [OwnerDashboardController::class, 'index'])->name('dashboard');

    // Section 1: Beranda / Judul & Sampul
    Route::get('/hero', [OwnerHeroController::class, 'edit'])->name('hero.edit');
    Route::post('/hero', [OwnerHeroController::class, 'update'])->name('hero.update');

    // Section 2: Tentang / Deskripsi & Visi-Misi
    Route::get('/about', [OwnerAboutController::class, 'edit'])->name('about.edit');
    Route::post('/about', [OwnerAboutController::class, 'update'])->name('about.update');

    // Section 3: Produk / Galeri (CRUD)
    Route::get('/products', [OwnerProductController::class, 'index'])->name('products.index');
    Route::get('/products/create', [OwnerProductController::class, 'create'])->name('products.create');
    Route::post('/products', [OwnerProductController::class, 'store'])->name('products.store');
    Route::get('/products/{id}/edit', [OwnerProductController::class, 'edit'])->name('products.edit');
    Route::put('/products/{id}', [OwnerProductController::class, 'update'])->name('products.update');
    Route::delete('/products/{id}', [OwnerProductController::class, 'destroy'])->name('products.destroy');

    // Section 4: Kontak & Lokasi
    Route::get('/contact', [OwnerContactController::class, 'edit'])->name('contact.edit');
    Route::post('/contact', [OwnerContactController::class, 'update'])->name('contact.update');

    // Pengaturan & Publikasi
    Route::get('/settings', [OwnerSettingController::class, 'edit'])->name('settings.edit');
    Route::post('/settings', [OwnerSettingController::class, 'update'])->name('settings.update');
    Route::post('/settings/publish', [OwnerSettingController::class, 'togglePublish'])->name('settings.publish');
    Route::get('/preview', [OwnerSettingController::class, 'preview'])->name('preview');
});

// 5. Rute Superadmin (Wajib login & role superadmin)
Route::middleware(['auth', 'superadmin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

    // Verifikasi Pendaftar
    Route::get('/verifications', [AdminVerificationController::class, 'index'])->name('verifications.index');
    Route::get('/verifications/{id}', [AdminVerificationController::class, 'show'])->name('verifications.show');
    Route::get('/verifications/{id}/document', [AdminVerificationController::class, 'document'])->name('verifications.document');
    Route::post('/verifications/{id}/approve', [AdminVerificationController::class, 'approve'])->name('verifications.approve');
    Route::post('/verifications/{id}/reject', [AdminVerificationController::class, 'reject'])->name('verifications.reject');

    // Kelola Mitra
    Route::get('/mitras', [AdminMitraController::class, 'index'])->name('mitras.index');
    Route::post('/mitras/{id}/toggle-active', [AdminMitraController::class, 'toggleActive'])->name('mitras.toggle-active');
    Route::post('/mitras/{id}/toggle-visibility', [AdminMitraController::class, 'toggleVisibility'])->name('mitras.toggle-visibility');
    Route::post('/mitras/{id}/update-order', [AdminMitraController::class, 'updateOrder'])->name('mitras.update-order');
    Route::delete('/mitras/{id}', [AdminMitraController::class, 'destroy'])->name('mitras.destroy');

    // Pengaturan Halaman Awal
    Route::get('/settings', [AdminSettingController::class, 'index'])->name('settings.index');
    Route::post('/settings', [AdminSettingController::class, 'update'])->name('settings.update');
});

// 6. Rute Autentikasi Laravel Breeze
require __DIR__.'/auth.php';
