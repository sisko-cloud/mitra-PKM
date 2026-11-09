<?php

namespace Database\Seeders;

use App\Models\SiteSetting;
use Illuminate\Database\Seeder;

class SiteSettingSeeder extends Seeder
{
    public function run(): void
    {
        $settings = [
            'hero_title' => 'Mitra PKM',
            'hero_description' => 'Direktori resmi dan platform etalase promosi digital UMKM & Koperasi binaan Program Kreativitas Mahasiswa (PKM). Dukung kemandirian ekonomi karya anak bangsa.',
            'hero_badge' => 'Platform Resmi Etalase UMKM & Koperasi PKM',
            'contact_email' => 'admin@mitrapkm.id',
            'contact_phone' => '+6281234567890',
        ];

        foreach ($settings as $key => $value) {
            SiteSetting::updateOrCreate(['key' => $key], ['value' => $value]);
        }
    }
}
