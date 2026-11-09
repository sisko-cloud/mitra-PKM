<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Services\FileUploadService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class OwnerProductController extends Controller
{
    public function index(): View
    {
        $mitra = Auth::user()->mitra;
        $products = $mitra->products()->orderBy('urutan', 'asc')->get();

        return view('owner.sections.products.index', compact('mitra', 'products'));
    }

    public function create(): View
    {
        $mitra = Auth::user()->mitra;
        return view('owner.sections.products.create', compact('mitra'));
    }

    public function store(Request $request): RedirectResponse
    {
        $mitra = Auth::user()->mitra;

        $request->validate([
            'nama' => ['required', 'string', 'max:255'],
            'deskripsi' => ['nullable', 'string', 'max:1000'],
            'harga' => ['nullable', 'numeric', 'min:0'],
            'foto' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'urutan' => ['nullable', 'integer', 'min:0'],
        ], [
            'nama.required' => 'Nama produk / galeri wajib diisi.',
            'foto.max' => 'Ukuran foto maksimal 2 MB.',
            'foto.mimes' => 'Format foto harus berupa JPG, PNG, atau WEBP.',
        ]);

        $fotoPath = null;
        if ($request->hasFile('foto')) {
            $fotoPath = FileUploadService::upload($request->file('foto'), 'products');
        }

        $nextUrutan = $request->filled('urutan')
            ? (int) $request->urutan
            : ($mitra->products()->max('urutan') ?? 0) + 1;

        Product::create([
            'mitra_id' => $mitra->id,
            'nama' => $request->nama,
            'deskripsi' => $request->deskripsi,
            'harga' => $request->harga,
            'foto' => $fotoPath,
            'urutan' => $nextUrutan,
        ]);

        return redirect()->route('owner.products.index')
            ->with('success', "Produk '{$request->nama}' berhasil ditambahkan ke etalase!");
    }

    public function edit(int $id): View
    {
        $mitra = Auth::user()->mitra;
        $product = $mitra->products()->findOrFail($id);

        return view('owner.sections.products.edit', compact('mitra', 'product'));
    }

    public function update(Request $request, int $id): RedirectResponse
    {
        $mitra = Auth::user()->mitra;
        $product = $mitra->products()->findOrFail($id);

        $request->validate([
            'nama' => ['required', 'string', 'max:255'],
            'deskripsi' => ['nullable', 'string', 'max:1000'],
            'harga' => ['nullable', 'numeric', 'min:0'],
            'foto' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'urutan' => ['nullable', 'integer', 'min:0'],
        ], [
            'nama.required' => 'Nama produk wajib diisi.',
            'foto.max' => 'Ukuran foto maksimal 2 MB.',
            'foto.mimes' => 'Format foto harus berupa JPG, PNG, atau WEBP.',
        ]);

        $fotoPath = $product->foto;
        if ($request->hasFile('foto')) {
            // Hapus file lama jika ada
            if ($product->foto) {
                FileUploadService::delete($product->foto);
            }
            $uploaded = FileUploadService::upload($request->file('foto'), 'products');
            if ($uploaded) {
                $fotoPath = $uploaded;
            }
        }

        $product->update([
            'nama' => $request->nama,
            'deskripsi' => $request->deskripsi,
            'harga' => $request->harga,
            'foto' => $fotoPath,
            'urutan' => $request->filled('urutan') ? (int) $request->urutan : $product->urutan,
        ]);

        return redirect()->route('owner.products.index')
            ->with('success', "Produk '{$product->nama}' berhasil diperbarui!");
    }

    public function destroy(int $id): RedirectResponse
    {
        $mitra = Auth::user()->mitra;
        $product = $mitra->products()->findOrFail($id);

        if ($product->foto && Storage::disk('public')->exists($product->foto)) {
            Storage::disk('public')->delete($product->foto);
        }

        $nama = $product->nama;
        $product->delete();

        return redirect()->route('owner.products.index')
            ->with('success', "Produk '{$nama}' berhasil dihapus.");
    }
}
