<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('website_contents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mitra_id')->constrained('mitras')->onDelete('cascade');
            // Section 1: Beranda / Judul
            $table->string('judul');
            $table->string('tagline')->nullable();
            $table->string('hero_image')->nullable();
            // Section 2: Tentang / Deskripsi
            $table->text('deskripsi')->nullable();
            $table->text('sejarah')->nullable();
            $table->text('visi_misi')->nullable();
            // Draft / Published management
            $table->boolean('is_draft')->default(false);
            $table->json('draft_data')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('website_contents');
    }
};
