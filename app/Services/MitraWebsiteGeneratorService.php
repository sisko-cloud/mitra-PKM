<?php

namespace App\Services;

use App\Models\Contact;
use App\Models\Mitra;
use App\Models\Product;
use App\Models\WebsiteContent;
use Illuminate\Support\Str;

class MitraWebsiteGeneratorService
{
    /**
     * Otomatis membuat template website 4 section saat owner disetujui.
     */
    public function generateTemplate(Mitra $mitra): void
    {
        // 1. Pastikan slug unik
        if (empty($mitra->slug)) {
            $baseSlug = Str::slug($mitra->nama_usaha);
            $slug = $baseSlug;
            $counter = 1;
            while (Mitra::where('slug', $slug)->where('id', '!=', $mitra->id)->exists()) {
                $slug = $baseSlug . '-' . $counter++;
            }
            $mitra->slug = $slug;
        }

        $mitra->is_active = true;
        $mitra->is_published = true;
        $mitra->is_visible_on_home = true;
        $mitra->save();

        // 2. Section 1 (Beranda/Judul) & Section 2 (Tentang/Deskripsi)
        if (! $mitra->websiteContent) {
            WebsiteContent::create([
                'mitra_id' => $mitra->id,
                'judul' => $mitra->nama_usaha,
                'tagline' => 'Solusi Terpercaya Produk ' . strtoupper($mitra->jenis) . ' Berkualitas Binaan PKM',
                'hero_image' => 'https://images.unsplash.com/photo-1542744094-3a31f272c490?auto=format&fit=crop&w=1200&q=80',
                'deskripsi' => 'Kami adalah ' . strtoupper($mitra->jenis) . ' yang berfokus menghadirkan karya, produk, dan pelayanan berkualitas terbaik langsung kepada pelanggan dan masyarakat luas.',
                'sejarah' => 'Tumbuh dan berkembang melalui inisiatif Program Kreativitas Mahasiswa (PKM) untuk memajukan potensi ekonomi lokal serta memperluas jangkauan pasar digital.',
                'visi_misi' => "Visi:\nMenjadi mitra usaha lokal yang mandiri, berdaya saing nasional, dan dipercaya oleh masyarakat.\n\nMisi:\n1. Menyediakan produk bermutu tinggi dengan harga kompetitif.\n2. Mengedepankan kepuasan pelanggan melalui pelayanan ramah dan responsif.\n3. Berkontribusi positif terhadap pemberdayaan ekonomi masyarakat sekitar.",
                'is_draft' => false,
            ]);
        }

        // 3. Section 3 (Produk / Galeri Default jika belum ada)
        if ($mitra->products()->count() === 0) {
            Product::create([
                'mitra_id' => $mitra->id,
                'nama' => 'Produk Unggulan ' . $mitra->nama_usaha,
                'deskripsi' => 'Produk andalan kami dengan kualitas terbaik dan bahan baku pilihan, siap dikirim ke tempat Anda.',
                'harga' => 50000,
                'foto' => 'https://images.unsplash.com/photo-1526170375885-4d8ecf77b99f?auto=format&fit=crop&w=800&q=80',
                'urutan' => 1,
            ]);
        }

        // 4. Section 4 (Kontak & Lokasi)
        if (! $mitra->contact) {
            Contact::create([
                'mitra_id' => $mitra->id,
                'alamat' => $mitra->alamat,
                'telepon' => $mitra->kontak,
                'whatsapp' => preg_replace('/[^0-9]/', '', $mitra->kontak),
                'email' => $mitra->user ? $mitra->user->email : null,
                'instagram' => null,
                'facebook' => null,
                'tiktok' => null,
                'jam_operasional' => 'Senin - Sabtu: 08:00 - 17:00 WIB',
                'maps_embed' => null,
            ]);
        }
    }
}
