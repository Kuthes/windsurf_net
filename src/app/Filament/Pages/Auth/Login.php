<?php

namespace App\Filament\Pages\Auth;

use Filament\Pages\Auth\Login as BaseLogin;

class Login extends BaseLogin
{
    protected function getRedirectUrl(): string
    {
        return route('dashboard');
    }

    public function mount(): void
    {
        parent::mount();
        // Force the intended URL to be the dashboard, creating a fresh start
        session()->put('url.intended', route('dashboard'));
    }
}
