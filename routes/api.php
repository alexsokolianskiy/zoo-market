<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\Auth\LoginController;
use App\Http\Controllers\API\Auth\GoogleLoginController;
use App\Http\Controllers\API\Auth\RegisterController;

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
Route::group(['prefix' => 'auth'], function () {
    Route::post('/login', [LoginController::class, 'login'])->name('api.auth.login');
    Route::post('/register', [RegisterController::class, 'register'])->name('api.auth.register');
    Route::post('/confirm-reset', [RegisterController::class, 'confirmReset'])->name('api.auth.reset-tmp');
    Route::get('/google', [GoogleLoginController::class, 'google'])->name('api.auth.google');
    Route::get('/google-callback', [GoogleLoginController::class, 'googleCallback'])->name('api.auth.google.callback');
});
