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
        Schema::dropIfExists('venue_settings');

        Schema::create('venue_settings', function (Blueprint $table) {
            $table->id();
            $table->string('nas_id')->unique()->index();
            $table->string('name');
            $table->string('logo_path')->nullable();
            $table->string('background_image_path')->nullable();
            $table->string('primary_color')->default('#007bff');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('venue_settings');
    }
};
