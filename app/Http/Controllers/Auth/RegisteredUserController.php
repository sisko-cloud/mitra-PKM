<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Mitra;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            // Data Akun
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],

            // Data Usaha
            'nama_usaha' => ['required', 'string', 'max:255'],
            'jenis' => ['required', 'in:umkm,koperasi'],
            'alamat' => ['required', 'string'],
            'kontak' => ['required', 'string', 'max:50'],
            'logo' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'dokumen_pendukung' => ['nullable', 'file', 'mimes:jpg,jpeg,png,webp,pdf', 'max:2048'],
        ], [
            'name.required' => 'Nama penanggung jawab wajib diisi.',
            'email.required' => 'Alamat email wajib diisi.',
            'email.unique' => 'Email ini sudah terdaftar di sistem.',
            'password.required' => 'Password wajib diisi.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
            'nama_usaha.required' => 'Nama UMKM / Koperasi wajib diisi.',
            'jenis.required' => 'Pilih jenis usaha (UMKM atau Koperasi).',
            'alamat.required' => 'Alamat usaha wajib diisi.',
            'kontak.required' => 'Nomor kontak / WhatsApp wajib diisi.',
            'logo.max' => 'Ukuran file logo maksimal 2 MB.',
            'logo.mimes' => 'Format logo harus berupa JPG, PNG, atau WEBP.',
            'dokumen_pendukung.max' => 'Ukuran dokumen maksimal 2 MB.',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'owner',
            'status' => 'pending',
        ]);

        // Upload Logo
        $logoPath = null;
        if ($request->hasFile('logo')) {
            $logoPath = $request->file('logo')->store('logos', 'public');
        }

        // Upload Dokumen Pendukung
        $dokumenPath = null;
        if ($request->hasFile('dokumen_pendukung')) {
            $dokumenPath = $request->file('dokumen_pendukung')->store('dokumen', 'public');
        }

        // Generate slug unik
        $baseSlug = Str::slug($request->nama_usaha);
        $slug = $baseSlug;
        $counter = 1;
        while (Mitra::where('slug', $slug)->exists()) {
            $slug = $baseSlug . '-' . $counter++;
        }

        Mitra::create([
            'user_id' => $user->id,
            'nama_usaha' => $request->nama_usaha,
            'jenis' => $request->jenis,
            'alamat' => $request->alamat,
            'kontak' => $request->kontak,
            'logo' => $logoPath,
            'dokumen_pendukung' => $dokumenPath,
            'slug' => $slug,
            'is_active' => true,
            'is_published' => false,
            'is_visible_on_home' => false,
            'urutan_tampil' => 0,
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect()->route('owner.status')->with('success', 'Pendaftaran berhasil dikirim! Akun Anda sedang dalam proses verifikasi oleh Superadmin.');
    }
}
