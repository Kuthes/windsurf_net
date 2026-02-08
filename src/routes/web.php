<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\HotspotUserController;
use App\Http\Controllers\CaptivePortalController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return redirect('/admin/login');
});

// Development bypass - auto-login as admin
Route::get('/auto-login', function () {
    $user = \App\Models\User::where('email', 'admin@example.com')->first();
    if ($user) {
        \Illuminate\Support\Facades\Auth::login($user);
        return redirect('/admin');
    }
    return 'User not found';
});

// Dashboard
Route::get('/dashboard', [DashboardController::class, 'index'])->middleware('auth')->name('dashboard');

// User Management
Route::prefix('users')->name('users.')->group(function () {
    Route::get('/', [UserController::class, 'index'])->name('index');
    Route::get('/create', [UserController::class, 'create'])->name('create');
    Route::post('/', [UserController::class, 'store'])->name('store');
    Route::get('/{username}', [UserController::class, 'show'])->name('show');
    Route::get('/{username}/edit', [UserController::class, 'edit'])->name('edit');
    Route::put('/{username}', [UserController::class, 'update'])->name('update');
    Route::delete('/{username}', [UserController::class, 'destroy'])->name('destroy');
});

// Hotspot User API
Route::post('/api/hotspot-users', [HotspotUserController::class, 'store'])->name('hotspot-users.store');

// Captive Portal Routes
Route::get('/portal', [CaptivePortalController::class, 'show'])->name('captive-portal.show');
Route::get('/portal/login', [CaptivePortalController::class, 'loginPage'])->name('portal.login');
Route::post('/portal/login', [CaptivePortalController::class, 'login'])->name('captive-portal.login');
Route::get('/portal/success', [CaptivePortalController::class, 'success'])->name('captive-portal.success');
