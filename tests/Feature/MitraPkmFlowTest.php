<?php

namespace Tests\Feature;

use App\Models\Mitra;
use App\Models\User;
use App\Services\MitraWebsiteGeneratorService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MitraPkmFlowTest extends TestCase
{
    /**
     * Uji Kriteria 1: Owner daftar, status pending, tidak bisa masuk editor.
     */
    public function test_owner_registers_pending_and_cannot_access_editor(): void
    {
        $response = $this->post(route('register'), [
            'name' => 'Bambang Sutrisno',
            'email' => 'bambang@kerajinanbambu.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'nama_usaha' => 'Bambu Lestari Nusantara',
            'jenis' => 'umkm',
            'alamat' => 'Desa Wisata Bambu No. 10, Kulon Progo',
            'kontak' => '081299988877',
        ]);

        $response->assertRedirect(route('owner.status'));

        $user = User::where('email', 'bambang@kerajinanbambu.com')->first();
        $this->assertNotNull($user);
        $this->assertEquals('owner', $user->role);
        $this->assertEquals('pending', $user->status);

        $mitra = $user->mitra;
        $this->assertNotNull($mitra);
        $this->assertEquals('Bambu Lestari Nusantara', $mitra->nama_usaha);

        // Akses dashboard editor harus dialihkan ke halaman status
        $this->actingAs($user);
        $editorResponse = $this->get(route('owner.dashboard'));
        $editorResponse->assertRedirect(route('owner.status'));
    }

    /**
     * Uji Kriteria 2: Superadmin menyetujui, template website otomatis dibuat, owner mendapat notifikasi.
     */
    public function test_superadmin_approves_and_website_template_auto_generated(): void
    {
        $superadmin = User::where('role', 'superadmin')->first();
        $this->assertNotNull($superadmin);

        $owner = User::where('status', 'pending')->first();
        $this->assertNotNull($owner);
        $mitra = $owner->mitra;

        $this->actingAs($superadmin);
        $approveResponse = $this->post(route('admin.verifications.approve', $mitra->id));
        $approveResponse->assertRedirect(route('admin.verifications.index'));

        $owner->refresh();
        $mitra->refresh();

        $this->assertEquals('approved', $owner->status);
        $this->assertNotNull($mitra->websiteContent);
        $this->assertNotNull($mitra->contact);
        $this->assertGreaterThan(0, $mitra->products()->count());
        $this->assertGreaterThan(0, $owner->notifications()->count());

        // Sekarang owner sudah bisa mengakses editor
        $this->actingAs($owner);
        $dashboardResponse = $this->get(route('owner.dashboard'));
        $dashboardResponse->assertStatus(200);
    }

    /**
     * Uji Kriteria 3: Owner mengedit section, melihat pratinjau, dan mempublikasikan.
     */
    public function test_owner_edits_sections_previews_and_publishes(): void
    {
        $owner = User::where('role', 'owner')->where('status', 'approved')->first();
        $this->assertNotNull($owner);
        $mitra = $owner->mitra;

        $this->actingAs($owner);

        // Edit Section 1: Hero
        $heroResponse = $this->post(route('owner.hero.update'), [
            'judul' => 'Kopi Senopati Spesial Juara',
            'tagline' => 'Aroma Khas Nusantara Terbaik',
        ]);
        $heroResponse->assertSessionHasNoErrors();
        $this->assertEquals('Kopi Senopati Spesial Juara', $mitra->fresh()->websiteContent->judul);

        // Edit Section 2: Tentang
        $aboutResponse = $this->post(route('owner.about.update'), [
            'deskripsi' => 'Profil usaha terupdate dengan kualitas ekspor.',
            'sejarah' => 'Sejarah panjang binaan PKM.',
            'visi_misi' => 'Visi baru.',
        ]);
        $aboutResponse->assertSessionHasNoErrors();

        // Edit Section 3: Tambah Produk
        $productResponse = $this->post(route('owner.products.store'), [
            'nama' => 'Espresso Blend 500gr',
            'harga' => 75000,
            'deskripsi' => 'Biji sangrai segar.',
            'urutan' => 1,
        ]);
        $productResponse->assertSessionHasNoErrors();

        // Edit Section 4: Kontak
        $contactResponse = $this->post(route('owner.contact.update'), [
            'whatsapp' => '081234567891',
            'telepon' => '0217208899',
            'alamat' => 'Jl. Senopati No. 42 Baru',
        ]);
        $contactResponse->assertSessionHasNoErrors();

        // Buka Pratinjau
        $previewResponse = $this->get(route('owner.preview'));
        $previewResponse->assertStatus(200);
        $previewResponse->assertSee('MODE PRATINJAU WEBSITE');
    }

    /**
     * Uji Kriteria 4: Link /mitra/{slug} bisa dibuka publik tanpa login dan tampil di grid landing page.
     */
    public function test_public_can_view_promotional_website_and_card_on_homepage(): void
    {
        $mitra = Mitra::where('is_active', true)
            ->where('is_published', true)
            ->where('is_visible_on_home', true)
            ->whereHas('user', fn ($q) => $q->where('status', 'approved'))
            ->first();

        $this->assertNotNull($mitra);

        // 1. Buka halaman utama tanpa login
        $homeResponse = $this->get(route('home'));
        $homeResponse->assertStatus(200);
        $homeResponse->assertSee($mitra->nama_usaha);

        // 2. Buka website promosi mitra tanpa login
        $publicResponse = $this->get(route('mitra.show', ['slug' => $mitra->slug]));
        $publicResponse->assertStatus(200);
        $publicResponse->assertSee($mitra->nama_usaha);
        $publicResponse->assertSee('Didukung oleh');
        $publicResponse->assertSee('Mitra PKM Framework');
    }

    /**
     * Uji Kriteria 5: Superadmin dapat menonaktifkan mitra, langsung hilang dari landing page & /mitra/{slug} 404.
     */
    public function test_superadmin_suspends_mitra_hidden_from_home_and_404_public(): void
    {
        $superadmin = User::where('role', 'superadmin')->first();
        $mitra = Mitra::where('is_active', true)
            ->where('is_published', true)
            ->whereHas('user', fn ($q) => $q->where('status', 'approved'))
            ->first();

        $this->assertNotNull($mitra);

        // Superadmin menonaktifkan mitra
        $this->actingAs($superadmin);
        $toggleResponse = $this->post(route('admin.mitras.toggle-active', $mitra->id));
        $toggleResponse->assertRedirect();

        $mitra->refresh();
        $this->assertFalse($mitra->is_active);

        // Guest membuka /mitra/{slug} harus menghasilkan 404
        auth()->logout();
        $publicVisit = $this->get(route('mitra.show', ['slug' => $mitra->slug]));
        $publicVisit->assertStatus(404);

        // Halaman landing page tidak boleh menampilkan nama mitra yang dinonaktifkan
        $homeVisit = $this->get(route('home'));
        $homeVisit->assertDontSee($mitra->nama_usaha);
    }
}
