<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Helper function to format bytes
        if (!function_exists('formatBytes')) {
            function formatBytes($bytes, $precision = 2)
            {
                $units = array('B', 'KB', 'MB', 'GB', 'TB');
                
                for ($i = 0; $bytes > 1024 && $i < count($units) - 1; $i++) {
                    $bytes /= 1024;
                }
                
                return round($bytes, $precision) . ' ' . $units[$i];
            }
        }
    }
}
