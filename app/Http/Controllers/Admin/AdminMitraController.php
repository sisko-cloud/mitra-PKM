<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Mitra;
use App\Notifications\OwnerStatusChangedNotification;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class AdminMitraController extends Controller
{
    public function index(Request $request): View
    {
        $search = $request->query('q');
        $jenis = $request->query('jenis');

        $query = Mitra::with('user')->latest('urutan_tampil')->latest();

        if (! empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('nama_usaha', 'like', "%{$search}%")
                  ->orWhere('slug', 'like', "%{$search}%")
                  ->orWhere('alamat', 'like', "%{$search}%");
            });
        }

        if (! empty($jenis) && in_array($jenis, ['umkm', 'koperasi'])) {
            $query->where('jenis', $jenis);
        }

        $mitras = $query->paginate(12)->withQueryString();

        return view('admin.mitras.index', compact('mitras', 'search', 'jenis'));
    }

    public function toggleActive(int $id): RedirectResponse
    {
        $mitra = Mitra::with('user')->findOrFail($id);
        $mitra->is_active = ! $mitra->is_active;
        $mitra->save();

        if (! $mitra->is_active && $mitra->user) {
            $mitra->user->update(['status' => 'suspended']);
            $mitra->user->notify(new OwnerStatusChangedNotification('suspended'));
        } elseif ($mitra->is_active && $mitra->user) {
            $mitra->user->update(['status' => 'approved']);
            $mitra->user->notify(new OwnerStatusChangedNotification('approved'));
        }

        $statusText = $mitra->is_active ? 'diaktifkan kembali' : 'dinonaktifkan (ditangguhkan)';
        return back()->with('success', "Status mitra '{$mitra->nama_usaha}' berhasil {$statusText}.");
    }

    public function toggleVisibility(int $id): RedirectResponse
    {
        $mitra = Mitra::findOrFail($id);
        $mitra->is_visible_on_home = ! $mitra->is_visible_on_home;
        $mitra->save();

        $text = $mitra->is_visible_on_home ? 'ditampilkan di beranda' : 'disembunyikan dari beranda';
        return back()->with('success', "Mitra '{$mitra->nama_usaha}' berhasil {$text}.");
    }

    public function updateOrder(Request $request, int $id): RedirectResponse
    {
        $request->validate([
            'urutan_tampil' => ['required', 'integer', 'min:0'],
        ]);

        $mitra = Mitra::findOrFail($id);
        $mitra->update(['urutan_tampil' => $request->urutan_tampil]);

        return back()->with('success', "Urutan tampil mitra '{$mitra->nama_usaha}' diperbarui menjadi {$request->urutan_tampil}.");
    }

    public function destroy(int $id): RedirectResponse
    {
        $mitra = Mitra::with('user')->findOrFail($id);
        $nama = $mitra->nama_usaha;

        // Hapus file logo dan dokumen dari disk
        if ($mitra->logo && Storage::disk('public')->exists($mitra->logo)) {
            Storage::disk('public')->delete($mitra->logo);
        }
        if ($mitra->dokumen_pendukung && Storage::disk('public')->exists($mitra->dokumen_pendukung)) {
            Storage::disk('public')->delete($mitra->dokumen_pendukung);
        }

        // Hapus user terkait (cascades mitras, website_contents, products, contacts)
        if ($mitra->user) {
            $mitra->user->delete();
        } else {
            $mitra->delete();
        }

        return redirect()->route('admin.mitras.index')
            ->with('success', "Mitra '{$nama}' dan seluruh datanya berhasil dihapus dari sistem.");
    }
}
