# Mitra PKM - Platform Direktori & Penyedia Website Promosi UMKM dan Koperasi

Platform web modern yang berfungsi sebagai direktori publik sekaligus penyedia website promosi mandiri untuk pelaku Usaha Mikro, Kecil, dan Menengah (UMKM) serta Koperasi mitra binaan **Program Kreativitas Mahasiswa (PKM)**. Setiap pemilik usaha (*owner*) yang telah diverifikasi oleh Superadmin secara otomatis mendapatkan website promosi siap pakai dengan 4 *section* yang dapat dikustomisasi dan dibagikan langsung ke publik.

---

## 🚀 Fitur Utama

### 1. Halaman Depan & Direktori Publik (`/`)
- **Hero Banner Dinamis**: Judul besar "Mitra PKM", subjudul, dan label yang dapat dikustomisasi langsung oleh Superadmin.
- **Katalog & Grid Kartu Mitra**: Menampilkan kartu UMKM & Koperasi terverifikasi dengan logo, jenis usaha, deskripsi, dan tombol buka website promosi.
- **Pencarian & Filter**: Pencarian instan berdasarkan nama mitra / kata kunci produk serta filter jenis (Semua, UMKM, Koperasi).
- **Pagination & Empty State**: Navigasi halaman yang rapi dan tampilan informatif saat belum ada mitra atau pencarian nihil.
- **Navigasi Cepat**: Tombol "Daftar sebagai Mitra" dan "Masuk" di *navbar*.

### 2. Alur Pendaftaran & Verifikasi Owner
- **Formulir Pendaftaran Lengkap**:
  - Data akun penanggung jawab: Nama, Email, Kata Sandi.
  - Data profil usaha: Nama UMKM/Koperasi, Jenis Usaha (UMKM/Koperasi), Alamat lengkap, Nomor Kontak/WhatsApp.
  - Berkas pendukung: Unggah Logo (opsional, maks 2 MB) dan Dokumen Legalitas/KTP (opsional, maks 2 MB).
- **Status Akun Otomatis**:
  - `pending`: Akun menunggu verifikasi Superadmin. Pemilik diarahkan ke halaman status `/owner/status` dan belum dapat mengakses dashboard editor.
  - `approved`: Superadmin menyetujui & sistem **otomatis membuat template website 4 section** dan mengirimkan notifikasi.
  - `rejected`: Pendaftaran ditolak dengan alasan yang wajib diisi Superadmin. Owner dapat meninjau alasan penolakan dan **memperbaiki data lalu mengajukan ulang (*resubmit*)**.
  - `suspended`: Mitra dinonaktifkan sementara oleh administrator.

### 3. Website Promosi Publik Mandiri (`/mitra/{slug}`)
- **Akses Publik Tanpa Login**: Cepat, responsif (*mobile, tablet, desktop*), dan ramah SEO.
- **Open Graph Meta Tags**: Otomatis menampilkan judul, deskripsi, dan gambar sampul saat dibagikan ke WhatsApp dan media sosial.
- **4 Section Lengkap**:
  1. **Beranda / Judul & Sampul**: Judul utama, *tagline*, dan gambar *hero banner*.
  2. **Tentang Kami**: Profil usaha, sejarah kemitraan PKM, serta visi dan misi.
  3. **Katalog Produk & Galeri**: Daftar produk dengan foto, deskripsi, harga rupiah, dan tombol **"Pesan via WhatsApp"** dengan pesan template otomatis (*WhatsApp direct conversion*).
  4. **Kontak & Lokasi**: Alamat fisik, nomor WhatsApp, email, media sosial (Instagram, Facebook, TikTok), jam operasional, dan sematan peta **Google Maps**.
- **Fitur Tambahan**: *Smooth scrolling*, tombol *floating* WhatsApp, dan *footer* resmi *"Didukung oleh Mitra PKM"*.

### 4. Dashboard Editor Owner
- Menu per *section*: Beranda, Tentang, Produk (CRUD lengkap & urutan), Kontak & Lokasi.
- Unggah berkas gambar dengan validasi batas 2 MB (format JPG, JPEG, PNG, WEBP) serta penghapusan otomatis berkas lama saat diganti.
- **Pratinjau Website**: Tinjau hasil editan sebelum dipublikasikan ke publik.
- **Publikasi**: Ubah status antara *Draft* (pribadi) atau *Published* (live).
- **Pengaturan Tautan**: Kustomisasi *slug* URL (dengan proteksi *reserved keywords*), tombol **"Salin Tautan"**, dan **"Bagikan ke WhatsApp"**.

### 5. Panel Kontrol Superadmin (`/admin/*`)
- **Dashboard Ringkasan**: Statistik total pendaftar, antrean verifikasi *pending*, mitra disetujui, ditolak, dan mitra aktif.
- **Antrean Verifikasi**: Tinjau dokumen dan identitas pendaftar, tombol setujui (auto-generate template), dan tombol tolak (dengan alasan wajib).
- **Kelola Mitra**: Filter jenis usaha, *toggle* aktif/nonaktif, *toggle* tampil di beranda, atur urutan tampil kartu, dan hapus data secara permanen.
- **Pengaturan Halaman Awal**: Form ubah judul *hero*, deskripsi, label, dan kontak pusat bantuan.

---

## 🛠️ Tech Stack

- **Backend**: Laravel 10 / 11 (PHP 8.1 / 8.2+)
- **Database**: MySQL (didukung SQLite untuk pengujian cepat)
- **Frontend**: Blade + Tailwind CSS (Vite Build & CDN Fallback) + Alpine.js
- **Icons**: Font Awesome 6.5
- **Autentikasi**: Laravel Breeze (Blade Stack) dengan Role-Based Access Control (RBAC)
- **Storage**: Vercel Blob (produksi) + disk lokal/privat (development). Gambar publik memakai store *public*, dokumen KTP/legalitas memakai store *private*.
- **Bahasa UI**: 100% Bahasa Indonesia

---

## 🔑 Akun Bawaan (Default Credentials)

> ⚠️ **Penting untuk produksi:** kredensial demo di bawah hanya untuk pengembangan lokal. Halaman login tidak lagi menampilkan/mengisinya otomatis saat `APP_ENV=production`. Tetap ganti password superadmin setelah deploy.

Sistem telah dilengkapi dengan *seeder* akun bawaan untuk pengujian instan:

| Peran (Role) | Email | Password | Status | Keterangan |
|--------------|-------|----------|--------|------------|
| **Superadmin** | `admin@mitrapkm.id` | `password123` | `approved` | Akses penuh dashboard `/admin` |
| **Owner (Disetujui)** | `owner1@kopisenopati.id` | `password123` | `approved` | Kopi Senopati Heritage (`/mitra/kopi-senopati-heritage`) |
| **Owner (Disetujui)** | `koperasi@tanimakmur.id` | `password123` | `approved` | Koperasi Tani Makmur (`/mitra/koperasi-tani-makmur-mandiri`) |
| **Owner (Pending)** | `pending@batikprabu.com` | `password123` | `pending` | Uji alur persetujuan verifikasi oleh Superadmin |
| **Owner (Ditolak)** | `rejected@dapurbunda.com` | `password123` | `rejected` | Uji halaman alasan penolakan & ajukan ulang |

---

## ⚙️ Panduan Instalasi & Menjalankan Aplikasi

### 1. Kebutuhan Sistem
- PHP >= 8.1 (dengan ekstensi `pdo_mysql`, `mbstring`, `openssl`, `curl`, `fileinfo`)
- MySQL Server (misal melalui Laragon / XAMPP)
- Composer

### 2. Konfigurasi Lingkungan (`.env`)
Pastikan berkas `.env` telah sesuai:
```env
APP_NAME="Mitra PKM"
APP_ENV=local
APP_KEY=base64:1Fe/YQY825/0YUHIRAg9la0OvrLNR8d3rOCSF9l23Ho=
APP_DEBUG=true
APP_URL=http://localhost:8000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=mitra_pkm
DB_USERNAME=root
DB_PASSWORD=

FILESYSTEM_DISK=public
MAIL_MAILER=log
```

### 3. Migrasi & Seeder Database
Jalankan perintah berikut di direktori `mitra-pkm`:
```bash
php artisan migrate:fresh --seed
```

### 4. Membuat Tautan Storage Gambar
```bash
php artisan storage:link
```
*(Di lingkungan Windows, tautan junction direktori `public\storage` terhubung ke `storage\app\public`)*

### 5. Menjalankan Server Lokal
```bash
php artisan serve
```
Buka browser di: **`http://localhost:8000`**

Tanpa `BLOB_READ_WRITE_TOKEN`, upload akan disimpan di disk lokal (`public` untuk gambar, `local` untuk dokumen) sehingga cocok untuk pengembangan.

---

## ☁️ Deployment ke Vercel

1. Import repo ke Vercel (framework: *Other*, output directory: `public`).
2. Set *Environment Variables* di project Vercel:

   | Variable | Contoh / Keterangan |
   |---|---|
   | `APP_KEY` | hasil `php artisan key:generate --show` |
   | `APP_URL` | `https://mitra-pkm.vercel.app` |
   | `DB_CONNECTION` | `pgsql` |
   | `DB_HOST`, `DB_PORT`, `DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD` | kredensial Neon PostgreSQL |
   | `DB_SSLMODE` | `require` |
   | `SESSION_SECURE_COOKIE` | `true` |
   | `BLOB_READ_WRITE_TOKEN` | token store Blob **public** (gambar) |
   | `BLOB_READ_WRITE_TOKEN_PRIVATE` | token store Blob **private** (dokumen) |

3. Buat **dua** Blob store di Vercel → Storage → Blob:
   - Store **public** untuk logo, hero, dan foto produk.
   - Store **private** untuk dokumen pendukung (KTP/legalitas).
   Mode akses store permanen dan tidak bisa diubah setelah dibuat.
4. Jalankan migrasi ke database produksi dari mesin lokal:
   ```bash
   DB_CONNECTION=pgsql DB_HOST=... DB_DATABASE=... DB_USERNAME=... DB_PASSWORD=... \
     php artisan migrate --force
   ```
5. Tanpa kedua token Blob, file hanya tersimpan di `/tmp` dan akan hilang saat serverless *cold start*.

---

## 🧪 Pengujian Otomatis (Automated Testing)

Semua kriteria sukses *end-to-end* telah diuji dengan PHPUnit:
```bash
php artisan test
```
Mencakup alur utama (`MitraPkmFlowTest`), keamanan storage/dokumen, serta test bawaan Laravel Breeze.

**Status Pengujian:** 37 PASSED (117 assertions, 0 failures).

---

## 📂 Struktur Direktori Proyek

```text
mitra-pkm/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Admin/
│   │   │   │   ├── AdminDashboardController.php
│   │   │   │   ├── AdminMitraController.php
│   │   │   │   ├── AdminSettingController.php
│   │   │   │   └── AdminVerificationController.php
│   │   │   ├── Auth/
│   │   │   │   ├── AuthenticatedSessionController.php
│   │   │   │   └── RegisteredUserController.php
│   │   │   ├── Owner/
│   │   │   │   ├── OwnerAboutController.php
│   │   │   │   ├── OwnerContactController.php
│   │   │   │   ├── OwnerDashboardController.php
│   │   │   │   ├── OwnerHeroController.php
│   │   │   │   ├── OwnerProductController.php
│   │   │   │   ├── OwnerSettingController.php
│   │   │   │   └── OwnerStatusController.php
│   │   │   ├── PublicHomeController.php
│   │   │   └── PublicMitraWebsiteController.php
│   │   └── Middleware/
│   │       ├── EnsureOwnerIsApproved.php
│   │       └── EnsureUserIsSuperadmin.php
│   ├── Models/
│   │   ├── Contact.php
│   │   ├── Mitra.php
│   │   ├── Product.php
│   │   ├── SiteSetting.php
│   │   ├── User.php
│   │   └── WebsiteContent.php
│   ├── Notifications/
│   │   └── OwnerStatusChangedNotification.php
│   └── Services/
│       └── MitraWebsiteGeneratorService.php
├── database/
│   ├── migrations/
│   └── seeders/
│       ├── DatabaseSeeder.php
│       ├── DemoMitraSeeder.php
│       ├── SiteSettingSeeder.php
│       └── SuperadminSeeder.php
├── resources/
│   └── views/
│       ├── admin/
│       │   ├── mitras/index.blade.php
│       │   ├── settings/index.blade.php
│       │   ├── verifications/index.blade.php
│       │   ├── verifications/show.blade.php
│       │   └── dashboard.blade.php
│       ├── auth/
│       │   ├── login.blade.php
│       │   └── register.blade.php
│       ├── layouts/
│       │   ├── app.blade.php
│       │   ├── navigation.blade.php
│       │   └── public.blade.php
│       ├── mitra/
│       │   └── show.blade.php
│       ├── owner/
│       │   ├── sections/
│       │   │   ├── products/
│       │   │   │   ├── create.blade.php
│       │   │   │   ├── edit.blade.php
│       │   │   │   └── index.blade.php
│       │   │   ├── about.blade.php
│       │   │   ├── contact.blade.php
│       │   │   └── hero.blade.php
│       │   ├── dashboard.blade.php
│       │   ├── settings.blade.php
│       │   └── status.blade.php
│       └── welcome.blade.php
├── routes/
│   ├── auth.php
│   └── web.php
└── tests/
    └── Feature/
        └── MitraPkmFlowTest.php
```

---

## 🛡️ Keamanan & Aturan Akses
- Password di-hash menggunakan algoritma Bcrypt bawaan Laravel.
- Perlindungan CSRF aktif pada seluruh formulir POST/PUT/DELETE.
- Validasi berkas unggahan: format JPG, JPEG, PNG, WEBP dengan batasan ukuran berkas maksimum 2 MB per file.
- Otomatisasi penghapusan berkas lama dari media penyimpanan (disk lokal maupun Vercel Blob) saat foto sampul, logo, atau produk diperbarui.
- Dokumen pendukung (KTP/legalitas) disimpan di disk privat / Blob privat dan hanya dapat diakses Superadmin melalui route terproteksi; route `/storage/*` hanya melayani gambar publik.
- URL dipaksa HTTPS di production dan cookie session memakai flag `Secure` untuk mencegah *mixed content* dan kebocoran cookie.
- Sanitasi input dan proteksi *slug reserved keywords* untuk mencegah konflik dengan rute sistem (`admin`, `owner`, `login`, `register`, `api`, dll).
- Isolasi otorisasi: Owner hanya dapat melihat dan menyunting website miliknya sendiri melalui *relation scoping* `Auth::user()->mitra`.
