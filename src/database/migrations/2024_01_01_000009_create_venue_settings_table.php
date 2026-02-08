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
        if (!Schema::hasTable('venue_settings')) {
            Schema::create('venue_settings', function (Blueprint $table) {
                $table->id();
                $table->string('nas_id')->unique()->index(); // New column
                $table->string('name'); // New column
                $table->string('logo_path')->nullable(); // Existing, kept
                $table->string('background_image_path')->nullable(); // Existing, kept
                $table->string('primary_color')->default('#007bff'); // Replaces primary_color_hex
                $table->text('welcome_message')->nullable(); // Existing, kept
                $table->boolean('is_active')->default(true); // Existing, kept
                $table->timestamps();
                
                // Indexes
                $table->index('nas_ip_address');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('venue_settings');
    }
};
