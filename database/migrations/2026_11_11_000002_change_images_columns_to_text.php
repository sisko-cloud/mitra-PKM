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
        Schema::table('products', function (Blueprint $table) {
            $table->text('foto')->nullable()->change();
        });

        Schema::table('website_contents', function (Blueprint $table) {
            $table->text('hero_image')->nullable()->change();
        });

        Schema::table('mitras', function (Blueprint $table) {
            $table->text('logo')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->string('foto', 255)->nullable()->change();
        });

        Schema::table('website_contents', function (Blueprint $table) {
            $table->string('hero_image', 255)->nullable()->change();
        });

        Schema::table('mitras', function (Blueprint $table) {
            $table->string('logo', 255)->nullable()->change();
        });
    }
};
