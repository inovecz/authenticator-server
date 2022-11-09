<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\API\AuthController;

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
Route::prefix('auth')->group(function() {
    Route::post('login', [AuthController::class, 'loginPost']);
    Route::post('register', [AuthController::class, 'registerPost']);
    Route::post('reset-password', [AuthController::class, 'resetPasswordPost']);
});

Route::middleware(['guard:user', 'auth:sanctum'])->group(function () {
    Route::post('/profile', [ProfileController::class, 'updateProfilePost']);
    Route::post('/profile/change-password', [ProfileController::class, 'changePasswordPost']);
});
