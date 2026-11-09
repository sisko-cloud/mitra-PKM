<?php

namespace Database\Seeders;

use App\Models\Contact;
use App\Models\Mitra;
use App\Models\Product;
use App\Models\User;
use App\Models\WebsiteContent;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DemoMitraSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Mitra Approved 1: Kopi Senopati Heritage (UMKM)
        $user1 = User::updateOrCreate(
            ['email' => 'owner1@kopisenopati.id'],
            [
                'name' => 'Budi Santoso',
                'password' => Hash::make('password123'),
                'role' => 'owner',
                'status' => 'approved',
                'email_verified_at' => now(),
            ]
        );

        $mitra1 = Mitra::updateOrCreate(
            ['user_id' => $user1->id],
            [
                'nama_usaha' => 'Kopi Senopati Heritage',
                'jenis' => 'umkm',
                'alamat' => 'Jl. Senopati No. 42, Kebayoran Baru, Jakarta Selatan',
                'kontak' => '081234567891',
                'logo' => null,
                'slug' => 'kopi-senopati-heritage',
                'is_active' => true,
                'is_published' => true,
                'is_visible_on_home' => true,
                'urutan_tampil' => 1,
            ]
        );

        WebsiteContent::updateOrCreate(
            ['mitra_id' => $mitra1->id],
            [
                'judul' => 'Kopi Senopati Heritage',
                'tagline' => 'Cita Rasa Kopi Nusantara Autentik dari Petani Lokal ke Cangkir Anda',
                'hero_image' => 'https://images.unsplash.com/photo-1501339847302-ac426a4a7cbb?auto=format&fit=crop&w=1200&q=80',
                'deskripsi' => 'Kopi Senopati Heritage menghadirkan sajian racikan biji kopi pilihan kualitas terbaik dari dataran tinggi Jawa dan Sumatera, diolah dengan teknik roasting modern untuk kenikmatan aroma yang tiada duanya.',
                'sejarah' => 'Berawal dari proyek PKM Kewirausahaan mahasiswa agribisnis pada tahun 2023, kami bermitra langsung dengan 15 kelompok petani kopi lokal demi mewujudkan perdagangan yang adil (fair trade).',
                'visi_misi' => "Visi:\nMenjadi kedai kopi lokal rujukan utama pencinta kopi di Nusantara.\n\nMisi:\n1. Menyajikan kopi berkualitas premium dengan harga terjangkau.\n2. Memberdayakan petani kopi lokal melalui kemitraan berkelanjutan.\n3. Mengedukasi masyarakat mengenai keberagaman kopi Indonesia.",
                'is_draft' => false,
            ]
        );

        Product::updateOrCreate(
            ['mitra_id' => $mitra1->id, 'nama' => 'Paket Signature Kopi Literan + Roti Gula Jawa'],
            [
                'deskripsi' => 'Robusta-arabika murni racikan khas Jawa Barat dipadu roti manis gula aren organik. Cocok untuk stok kantor maupun santai keluarga.',
                'harga' => 65000,
                'foto' => 'https://images.unsplash.com/photo-1541167760496-1628856ab772?auto=format&fit=crop&w=800&q=80',
                'urutan' => 1,
            ]
        );

        Product::updateOrCreate(
            ['mitra_id' => $mitra1->id, 'nama' => 'Cold Brew Gayo Black Honey 250ml'],
            [
                'deskripsi' => 'Ekstrak seduh dingin selama 16 jam menghasilkan body lembut dengan aftertaste floral dan madu alami.',
                'harga' => 32000,
                'foto' => 'https://images.unsplash.com/photo-1517701550927-30cf4ba1dba5?auto=format&fit=crop&w=800&q=80',
                'urutan' => 2,
            ]
        );

        Contact::updateOrCreate(
            ['mitra_id' => $mitra1->id],
            [
                'alamat' => 'Jl. Senopati No. 42, Kebayoran Baru, Jakarta Selatan',
                'telepon' => '0217208899',
                'whatsapp' => '6281234567891',
                'email' => 'halo@kopisenopati.id',
                'instagram' => '@kopisenopati.heritage',
                'facebook' => 'Kopi Senopati Heritage',
                'tiktok' => '@kopisenopati',
                'jam_operasional' => 'Senin - Minggu: 08:00 - 22:00 WIB',
                'maps_embed' => 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3966.2737666245353!2d106.8080!3d-6.2275!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zNsKwMTMnMzkuMCJTIDEwNsKwNDgnMjguOCJF!5e0!3m2!1sid!2sid!4v1620000000000!5m2!1sid!2sid',
            ]
        );

        // 2. Mitra Approved 2: Koperasi Tani Makmur Mandiri (Koperasi)
        $user2 = User::updateOrCreate(
            ['email' => 'koperasi@tanimakmur.id'],
            [
                'name' => 'Siti Rahmawati',
                'password' => Hash::make('password123'),
                'role' => 'owner',
                'status' => 'approved',
                'email_verified_at' => now(),
            ]
        );

        $mitra2 = Mitra::updateOrCreate(
            ['user_id' => $user2->id],
            [
                'nama_usaha' => 'Koperasi Tani Makmur Mandiri',
                'jenis' => 'koperasi',
                'alamat' => 'Desa Sukamaju No. 12, Sleman, D.I. Yogyakarta',
                'kontak' => '081398765432',
                'logo' => null,
                'slug' => 'koperasi-tani-makmur-mandiri',
                'is_active' => true,
                'is_published' => true,
                'is_visible_on_home' => true,
                'urutan_tampil' => 2,
            ]
        );

        WebsiteContent::updateOrCreate(
            ['mitra_id' => $mitra2->id],
            [
                'judul' => 'Koperasi Tani Makmur Mandiri',
                'tagline' => 'Bersama Menyejahterakan Petani, Menghadirkan Hasil Bumi Segar dan Alami',
                'hero_image' => 'https://images.unsplash.com/photo-1500937386664-56d1dfef3854?auto=format&fit=crop&w=1200&q=80',
                'deskripsi' => 'Koperasi produsen agribisnis beranggotakan lebih dari 120 petani lokal. Kami mendistribusikan sayuran hidroponik, beras organik, dan olahan pangan sehat langsung dari kebun petani ke konsumen.',
                'sejarah' => 'Didirikan pada tahun 2021 melalui inisiasi program PKM Penerapan Iptek Fakultas Pertanian untuk mengeliminasi rantai tengkulak dan meningkatkan margin pendapatan petani pedesaan.',
                'visi_misi' => "Visi:\nKoperasi agribisnis percontohan yang modern, transparan, dan berdaya saing global.\n\nMisi:\n1. Menyediakan sarana produksi pertanian bermutu tinggi bagi anggota.\n2. Mengolah komoditas pertanian bernilai tambah tinggi.\n3. Menjamin keterjangkauan produk pangan sehat bagi masyarakat luas.",
                'is_draft' => false,
            ]
        );

        Product::updateOrCreate(
            ['mitra_id' => $mitra2->id, 'nama' => 'Beras Merah Organik Premium 5kg'],
            [
                'deskripsi' => 'Dipanen dari sawah lereng Gunung Merapi dengan irigasi mata air alami bebas pestisida kimia sintetis.',
                'harga' => 88000,
                'foto' => 'https://images.unsplash.com/photo-1586201375761-83865001e31c?auto=format&fit=crop&w=800&q=80',
                'urutan' => 1,
            ]
        );

        Contact::updateOrCreate(
            ['mitra_id' => $mitra2->id],
            [
                'alamat' => 'Desa Sukamaju No. 12, Sleman, D.I. Yogyakarta',
                'telepon' => '0274889911',
                'whatsapp' => '6281398765432',
                'email' => 'kontak@tanimakmur.id',
                'instagram' => '@kop.tanimakmur',
                'facebook' => 'Koperasi Tani Makmur',
                'tiktok' => '@tanimakmurjogja',
                'jam_operasional' => 'Senin - Sabtu: 07:30 - 16:30 WIB',
                'maps_embed' => null,
            ]
        );

        // 3. Mitra Pending: Batik Prabu Nusantara (to test superadmin approval workflow)
        $userPending = User::updateOrCreate(
            ['email' => 'pending@batikprabu.com'],
            [
                'name' => 'Raden Mas Hendro',
                'password' => Hash::make('password123'),
                'role' => 'owner',
                'status' => 'pending',
                'email_verified_at' => now(),
            ]
        );

        Mitra::updateOrCreate(
            ['user_id' => $userPending->id],
            [
                'nama_usaha' => 'Batik Prabu Nusantara',
                'jenis' => 'umkm',
                'alamat' => 'Kampung Batik Laweyan No. 8, Surakarta, Jawa Tengah',
                'kontak' => '085712345678',
                'logo' => null,
                'slug' => 'batik-prabu-nusantara',
                'is_active' => true,
                'is_published' => false,
                'is_visible_on_home' => false,
                'urutan_tampil' => 3,
            ]
        );

        // 4. Mitra Rejected: Dapur Bunda Mentai (to test rejection view & resubmission)
        $userRejected = User::updateOrCreate(
            ['email' => 'rejected@dapurbunda.com'],
            [
                'name' => 'Dewi Lestari',
                'password' => Hash::make('password123'),
                'role' => 'owner',
                'status' => 'rejected',
                'rejection_reason' => 'Foto KTP / identitas usaha buram dan tidak terbaca. Mohon unggah ulang foto yang jelas dan pastikan nomor kontak WhatsApp aktif.',
                'email_verified_at' => now(),
            ]
        );

        Mitra::updateOrCreate(
            ['user_id' => $userRejected->id],
            [
                'nama_usaha' => 'Dapur Bunda Mentai',
                'jenis' => 'umkm',
                'alamat' => 'Jl. Tebet Barat Dalam Raya No. 15, Tebet, Jakarta Selatan',
                'kontak' => '087812340000',
                'logo' => null,
                'slug' => 'dapur-bunda-mentai',
                'is_active' => true,
                'is_published' => false,
                'is_visible_on_home' => false,
                'urutan_tampil' => 4,
            ]
        );
    }
}
