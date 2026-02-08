<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PortalController;

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
    return redirect()->route('dashboard');
});

// Dashboard
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

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

Route::get('/portal/login', [PortalController::class, 'loginPage'])->name('portal.login');
Route::post('/portal/login', [PortalController::class, 'login'])->name('portal.login.submit');

Route::get('/mock/logon', [PortalController::class, 'mockRouterLogon'])->name('mock.logon');
