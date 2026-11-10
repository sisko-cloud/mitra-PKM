<?php

namespace Tests\Feature\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;

    public function test_registration_screen_can_be_rendered(): void
    {
        $response = $this->get('/register');

        $response->assertStatus(200);
    }

    public function test_new_users_can_register(): void
    {
        $response = $this->post('/register', [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
            'nama_usaha' => 'Usaha Test',
            'jenis' => 'umkm',
            'alamat' => 'Jl. Test No. 1',
            'kontak' => '081234567890',
        ]);

        $this->assertAuthenticated();
        $response->assertRedirect(route('owner.status'));
    }

    public function test_registration_normalizes_uppercase_email(): void
    {
        $response = $this->post('/register', [
            'name' => 'Test User',
            'email' => 'Test.User@Example.COM',
            'password' => 'password',
            'password_confirmation' => 'password',
            'nama_usaha' => 'Usaha Test',
            'jenis' => 'umkm',
            'alamat' => 'Jl. Test No. 1',
            'kontak' => '081234567890',
        ]);

        $response->assertSessionHasNoErrors();

        $this->assertAuthenticated();
        $this->assertDatabaseHas('users', [
            'email' => 'test.user@example.com',
        ]);
    }
}
