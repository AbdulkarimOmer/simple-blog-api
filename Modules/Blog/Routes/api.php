<?php

use Modules\Blog\Http\Controllers\API\Posts\ShowPostController;
use Modules\Blog\Http\Controllers\API\Posts\StorePostController;

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

Route::middleware(['auth:sanctum'])->group(function () {
    Route::name('blog.')->prefix('blog')->group(function () {
        Route::name('posts.')->prefix('posts')->group(function () {
            Route::get(
                '/{id}',
                ShowPostController::class
            )->name('show');

            Route::post(
                '/',
                StorePostController::class
            )->name('store');
        });
    });
});
