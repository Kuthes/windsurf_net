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
        if (!Schema::hasTable('nas')) {
            Schema::create('nas', function (Blueprint $table) {
                $table->id();
                $table->string('nasname', 128)->default('');
                $table->string('shortname', 32)->default('');
                $table->integer('type')->default(0);
                $table->integer('ports')->nullable();
                $table->string('secret', 60)->default('secret');
                $table->string('community', 50)->nullable();
                $table->string('description', 200)->default('');
                $table->timestamps();
                
                // Indexes for performance
                $table->unique('nasname');
                $table->index('shortname');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('nas');
    }
};
