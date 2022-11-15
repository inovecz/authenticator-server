<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\API\AuthController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::middleware('guest')->prefix('auth')->group(function() {
    Route::post('/login', [AuthController::class, 'loginPost']);
    Route::post('/register', [AuthController::class, 'registerPost']);
    Route::post('/forgot-password', [AuthController::class, 'forgotPasswordPost']);
    Route::post('/reset-password', [AuthController::class, 'resetPasswordPost'])->name('password.update');
});

Route::get('/email/verify/{id}/{hash}', [AuthController::class, 'verifyEmail'])->middleware(['auth', 'signed'])->name('verification.verify');
Route::post('/email/verification-notification', [AuthController::class, 'sendVerification'])->middleware(['auth', 'throttle:6,1'])->name('verification.send');

Route::middleware(['guard:user', 'auth:sanctum', 'verified'])->group(function () {
    Route::post('/profile', [ProfileController::class, 'updateProfilePost']);
    Route::post('/profile/change-password', [ProfileController::class, 'changePasswordPost']);
});
