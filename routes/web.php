<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect('/auth');
});

Route::get('/auth', function () {
    return view('welcome');
});

Route::get('/admin', function () {
    return view('admin.auth.login');
})->name('admin-login');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->prefix('admin')
    ->group(function () {
        Route::get('/dashboard', [AdminController::class, 'showDashboard'])->name('dashboard');
        Route::get('/users', function () {
            return view('admin.users');
        })->name('users-list');
        Route::get('/settings', function () {
            return view('admin.settings');
        })->name('settings');
    });
