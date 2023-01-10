<?php

use Modules\Blog\Http\Controllers\API\Posts\IndexPostController;
use Modules\Blog\Http\Controllers\API\Posts\ShowPostController;
use Modules\Blog\Http\Controllers\API\Posts\StorePostController;
use Modules\Blog\Http\Controllers\API\Posts\UpdatePostController;

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
                '/',
                IndexPostController::class
            )->name('index');

            Route::get(
                '/{id}',
                ShowPostController::class
            )->name('show');

            Route::post(
                '/',
                StorePostController::class
            )->name('store');

            Route::patch(
                '/{id}',
                UpdatePostController::class
            )->name('update');

            Route::post(
                '/',
                DestroyPostController::class
            )->name('destroy');
        });
    });
});
