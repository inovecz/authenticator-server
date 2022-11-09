<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Admin\LoginController;

Route::get('/', static fn() => redirect('/auth'));
Route::get('/auth', static fn() => view('welcome'));

Route::prefix('admin')
    ->group(function () {
        Route::get('/', static fn() => view('admin.auth.login'));
        Route::post('/login', [LoginController::class, 'loginPost'])->name('admin.login');
        //Route::post('/login', fn() => dd(request()))->name('admin.login');
        Route::middleware(['guard:admin', 'auth'])->group(function (){
            Route::get('/dashboard', [AdminController::class, 'showDashboard'])->name('dashboard');
            Route::get('/users', static fn() => view('admin.users'))->name('users-list');
            Route::get('/settings', static fn() => view('admin.settings'))->name('settings');
            Route::get('/blacklists', static fn() => view('admin.blacklists'))->name('blacklists');
        });
    });
