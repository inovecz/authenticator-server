<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Admin\LoginController;

Route::get('/', static fn() => redirect('/auth'));
Route::get('/auth', static fn() => view('welcome'))->name('login');

Route::get('/reset-password/{token}', static function ($token) {
    return view('auth.reset-password', ['token' => $token]);
})->middleware('guest')->name('password.reset');

Route::prefix('admin')
    ->group(function () {
        Route::get('/', static fn() => view('admin.auth.login'))->name('admin.loginPage');
        Route::post('/login', [LoginController::class, 'loginPost'])->name('admin.login');
        Route::middleware(['auth:admin'])->group(function () {
            Route::get('/dashboard', [AdminController::class, 'showDashboard'])->name('dashboard');
            Route::get('/users', static fn() => view('admin.users'))->name('users-list');
            Route::get('/settings', static fn() => view('admin.settings'))->name('settings');
            Route::get('/blacklists', static fn() => view('admin.blacklists'))->name('blacklists');
            Route::get('/login-attempts', static fn() => view('admin.login_attempts'))->name('loginAttempts');
            Route::post('logout', [LoginController::class, 'logoutPost'])->name('admin.logout');
        });
    });
