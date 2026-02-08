<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Filament\Http\Responses\Auth\Contracts\LoginResponse as LoginResponseContract;
use App\Http\Responses\LoginResponse;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // $this->app->bind(LoginResponseContract::class, LoginResponse::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        \App\Models\Policy::observe(\App\Observers\PolicyObserver::class);
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
