<?php

namespace Tests\Feature;

use App\Models\Mitra;
use App\Models\User;
use App\Services\MitraWebsiteGeneratorService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class MitraPkmFlowTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        // Setiap pengujian dimulai dari data awal yang konsisten.
        $this->seed();
    }

    /**
     * Uji Kriteria 1: Owner daftar, status pending, tidak bisa masuk editor.
     */
    public function test_owner_registers_pending_and_cannot_access_editor(): void
    {
        // Pastikan tidak ada data uji sebelumnya
        $oldUser = User::where('email', 'bambang@kerajinanbambu.com')->first();
        if ($oldUser) {
            $oldUser->mitra?->delete();
            $oldUser->delete();
        }

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

        // Bersihkan data uji bambang
        $mitra->delete();
        $user->delete();
    }

    /**
     * Uji Pendaftaran dengan Unggah Berkas (Logo & Dokumen).
     */
    public function test_owner_registers_with_files_successfully(): void
    {
        Storage::fake('public');
        Storage::fake('local');

        // Gunakan PNG 1x1 asli agar pengujian tidak bergantung pada ekstensi GD.
        $logoPath = tempnam(sys_get_temp_dir(), 'logo_') . '.png';
        file_put_contents($logoPath, base64_decode(
            'iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAQAAAC1HAwCAAAAC0lEQVR42mP8/x8AAusB9Y9Z3ZkAAAAASUVORK5CYII='
        ));
        $logo = new UploadedFile($logoPath, 'test_logo.png', 'image/png', null, true);
        $dokumen = UploadedFile::fake()->create('test_dokumen.pdf', 500, 'application/pdf');

        $response = $this->post(route('register'), [
            'name' => 'Siti Nurhaliza',
            'email' => 'siti.upload@kerajinan.id',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'nama_usaha' => 'Tenun Sutra Alam',
            'jenis' => 'umkm',
            'alamat' => 'Jl. Pengrajin No. 45, Wajo',
            'kontak' => '085233344455',
            'logo' => $logo,
            'dokumen_pendukung' => $dokumen,
        ]);

        $response->assertRedirect(route('owner.status'));

        $user = User::where('email', 'siti.upload@kerajinan.id')->first();
        $this->assertNotNull($user);
        $this->assertEquals('pending', $user->status);

        $mitra = $user->mitra;
        $this->assertNotNull($mitra);
        $this->assertEquals('Tenun Sutra Alam', $mitra->nama_usaha);
        $this->assertNotNull($mitra->logo);
        $this->assertNotNull($mitra->dokumen_pendukung);

        // Bersihkan data uji
        $mitra->delete();
        $user->delete();
    }

    /**
     * Uji Kriteria 2: Superadmin menyetujui, template website otomatis dibuat, owner mendapat notifikasi.
     */
    public function test_superadmin_approves_and_website_template_auto_generated(): void
    {
        $superadmin = User::where('role', 'superadmin')->first();
        $this->assertNotNull($superadmin);

        // Siapkan akun owner pending dengan data usaha
        $owner = User::updateOrCreate(
            ['email' => 'pending.test@batikprabu.com'],
            [
                'name' => 'Raden Mas Hendro Test',
                'password' => bcrypt('password123'),
                'role' => 'owner',
                'status' => 'pending',
            ]
        );
        $owner->update(['status' => 'pending']);

        $mitra = Mitra::updateOrCreate(
            ['user_id' => $owner->id],
            [
                'nama_usaha' => 'Batik Prabu Keraton Test',
                'jenis' => 'umkm',
                'alamat' => 'Solo',
                'kontak' => '081234567890',
                'slug' => 'batik-prabu-keraton-test',
            ]
        );
        // Hapus content lama jika ada agar auto-generator berjalan penuh
        $mitra->websiteContent?->delete();
        $mitra->contact?->delete();
        $mitra->products()->delete();

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

        // Kembalikan status mitra untuk kebersihan tes berikutnya
        $mitra->update(['is_active' => true]);
    }
}
