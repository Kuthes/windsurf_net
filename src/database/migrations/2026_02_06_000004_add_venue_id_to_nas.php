<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('nas', function (Blueprint $table) {
            $table->foreignId('venue_setting_id')->nullable()->constrained('venue_settings')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('nas', function (Blueprint $table) {
            $table->dropForeign(['venue_setting_id']);
            $table->dropColumn('venue_setting_id');
        });
    }
};
