<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class OwnerContactController extends Controller
{
    public function edit(): View
    {
        $mitra = Auth::user()->mitra;
        $contact = $mitra->contact ?? new Contact(['mitra_id' => $mitra->id]);

        return view('owner.sections.contact', compact('mitra', 'contact'));
    }

    public function update(Request $request): RedirectResponse
    {
        $mitra = Auth::user()->mitra;

        $request->validate([
            'alamat' => ['nullable', 'string', 'max:500'],
            'telepon' => ['nullable', 'string', 'max:50'],
            'whatsapp' => ['required', 'string', 'max:50'],
            'email' => ['nullable', 'email', 'max:255'],
            'instagram' => ['nullable', 'string', 'max:100'],
            'facebook' => ['nullable', 'string', 'max:100'],
            'tiktok' => ['nullable', 'string', 'max:100'],
            'jam_operasional' => ['nullable', 'string', 'max:255'],
            'maps_embed' => ['nullable', 'string', 'max:2000'],
        ], [
            'whatsapp.required' => 'Nomor WhatsApp wajib diisi untuk tombol konversi langsung.',
        ]);

        $contact = $mitra->contact;
        if (! $contact) {
            $contact = new Contact(['mitra_id' => $mitra->id]);
        }

        // Sanitasi embed google maps (ambil src jika user mem-paste full iframe code)
        $mapsEmbed = $request->maps_embed;
        if (! empty($mapsEmbed) && preg_match('/src=["\']([^"\']+)["\']/', $mapsEmbed, $matches)) {
            $mapsEmbed = $matches[1];
        }

        $contact->alamat = $request->alamat;
        $contact->telepon = $request->telepon;
        $contact->whatsapp = preg_replace('/[^0-9]/', '', $request->whatsapp);
        $contact->email = $request->email;
        $contact->instagram = $request->instagram;
        $contact->facebook = $request->facebook;
        $contact->tiktok = $request->tiktok;
        $contact->jam_operasional = $request->jam_operasional;
        $contact->maps_embed = $mapsEmbed;
        $contact->save();

        return back()->with('success', 'Section Kontak & Lokasi berhasil diperbarui!');
    }
}
