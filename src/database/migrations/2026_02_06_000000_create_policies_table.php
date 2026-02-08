<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('policies', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            
            // Limits
            $table->integer('concurrency_limit')->nullable();
            $table->integer('max_devices_limit')->nullable();
            $table->integer('daily_session_count')->nullable();
            
            // Timeouts & Intervals (stored in seconds or minutes, UI handles conversion)
            $table->integer('session_timeout')->nullable();
            $table->string('session_timeout_unit')->default('Minutes');
            $table->integer('idle_timeout')->nullable();
            $table->string('idle_timeout_unit')->default('Minutes');
            $table->integer('validity_interval')->nullable();
            $table->string('validity_interval_unit')->default('Days');
            
            // Quotas
            $table->integer('total_time_quota')->nullable();
            $table->string('total_time_quota_unit')->default('Minutes');
            $table->integer('daily_time_quota')->nullable();
            $table->string('daily_time_quota_unit')->default('Minutes');
            
            $table->bigInteger('total_bandwidth_quota')->nullable();
            $table->string('total_bandwidth_quota_unit')->default('MB');
            $table->bigInteger('daily_bandwidth_quota')->nullable();
            $table->string('daily_bandwidth_quota_unit')->default('MB');
            
            // Rate Limits
            $table->integer('download_rate')->nullable();
            $table->string('download_rate_unit')->default('Mbps');
            $table->integer('upload_rate')->nullable();
            $table->string('upload_rate_unit')->default('Mbps');
            
            // Flags
            $table->boolean('auto_renewal')->default(false);
            $table->boolean('is_default')->default(false);
            
            $table->string('filter_id')->nullable();
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('policies');
    }
};
