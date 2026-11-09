<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class SuperadminSeeder extends Seeder
{
    public function run(): void
    {
        $email = env('SUPERADMIN_EMAIL', 'admin@mitrapkm.id');
        $name = env('SUPERADMIN_NAME', 'Superadmin Mitra PKM');
        $password = env('SUPERADMIN_PASSWORD', 'password123');

        User::updateOrCreate(
            ['email' => $email],
            [
                'name' => $name,
                'password' => Hash::make($password),
                'role' => 'superadmin',
                'status' => 'approved',
                'email_verified_at' => now(),
            ]
        );
    }
}
