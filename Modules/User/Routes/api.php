<?php

use Illuminate\Http\Request;
use Modules\User\Http\Controllers\Authentication\LoginController;
use Modules\User\Http\Controllers\Authentication\LogoutController;
use Modules\User\Http\Controllers\Authentication\RegisterController;

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

Route::name('accounts.')->prefix('accounts')->group(function () {
    Route::post(
        '/sign-up',
        RegisterController::class
    )->name('sign-up');

    Route::post(
        '/login',
        LoginController::class
    )->name('login');

    Route::middleware(['auth:sanctum'])->group(function () {
        Route::get(
            '/logout',
            LogoutController::class
        )->name('logout');

    });
});
