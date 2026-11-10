<?php

namespace Tests\Feature;

use App\Models\Mitra;
use App\Models\User;
use App\Services\VercelBlobService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class SecurityAndStorageTest extends TestCase
{
    use RefreshDatabase;

    public function test_login_page_does_not_expose_demo_credentials(): void
    {
        $this->get(route('login'))
            ->assertOk()
            ->assertDontSee('Akun Bawaan untuk Pengujian')
            ->assertDontSee('password123');
    }

    public function test_public_storage_does_not_serve_private_documents(): void
    {
        Storage::fake('local');
        Storage::disk('local')->put('dokumen/ktp-rahasia.pdf', 'data sensitif');

        $this->get('/storage/dokumen/ktp-rahasia.pdf')->assertNotFound();
    }

    public function test_document_endpoint_requires_superadmin(): void
    {
        $owner = User::factory()->create(['role' => 'owner', 'status' => 'approved']);
        $mitra = $this->createMitra($owner);

        $this->actingAs($owner)
            ->get(route('admin.verifications.document', $mitra->id))
            ->assertForbidden();
    }

    public function test_owner_can_deactivate_website_with_checkbox_unchecked(): void
    {
        $owner = User::factory()->create(['role' => 'owner', 'status' => 'approved']);
        $mitra = $this->createMitra($owner);

        $this->actingAs($owner)
            ->post(route('owner.settings.update'), [
                'slug' => $mitra->slug,
                'is_active' => '0',
            ])
            ->assertSessionHasNoErrors();

        $this->assertFalse($mitra->fresh()->is_active);
    }

    public function test_superadmin_can_open_private_document(): void
    {
        Storage::fake('local');
        Storage::disk('local')->put('dokumen/ktp.pdf', 'data sensitif');

        $admin = User::factory()->create(['role' => 'superadmin', 'status' => 'approved']);
        $owner = User::factory()->create(['role' => 'owner', 'status' => 'approved']);
        $mitra = $this->createMitra($owner);
        $mitra->update(['dokumen_pendukung' => 'dokumen/ktp.pdf']);

        $this->actingAs($admin)
            ->get(route('admin.verifications.document', $mitra->id))
            ->assertOk();
    }

    public function test_private_document_upload_uses_private_blob_store(): void
    {
        config([
            'services.vercel_blob.token' => 'public-token',
            'services.vercel_blob.private_token' => 'private-token',
            'services.vercel_blob.api_url' => 'https://vercel.com/api/blob',
        ]);

        Http::fake([
            'vercel.com/api/blob/*' => Http::response([
                'url' => 'https://store.private.blob.vercel-storage.com/dokumen/ktp.pdf',
            ]),
        ]);

        $file = UploadedFile::fake()->create('ktp.pdf', 100, 'application/pdf');
        $url = VercelBlobService::upload($file, 'dokumen', false);

        $this->assertSame('https://store.private.blob.vercel-storage.com/dokumen/ktp.pdf', $url);

        Http::assertSent(function ($request) {
            return str_contains($request->url(), 'pathname=dokumen')
                && $request->hasHeader('x-vercel-blob-access', 'private')
                && $request->hasHeader('Authorization', 'Bearer private-token');
        });
    }

    private function createMitra(User $owner): Mitra
    {
        return Mitra::create([
            'user_id' => $owner->id,
            'nama_usaha' => 'Mitra Uji Keamanan',
            'jenis' => 'umkm',
            'alamat' => 'Jl. Pengujian No. 1',
            'kontak' => '081200000000',
            'slug' => 'mitra-uji-keamanan',
            'is_active' => true,
            'is_published' => true,
            'is_visible_on_home' => true,
            'urutan_tampil' => 0,
        ]);
    }
}
