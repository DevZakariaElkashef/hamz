<?php

use App\Http\Controllers\Earn\Api\HomeController;
use App\Http\Controllers\Earn\Api\VideoController;

Route::middleware('auth:sanctum')->group(function () {
    Route::get('home', [HomeController::class, 'index']);

    Route::prefix('videos')->group(function () {
        Route::get('/', [VideoController::class, 'index']);
        Route::get('/next', [VideoController::class, 'next']);
        Route::get('/finish/{id}', [VideoController::class, 'finish']);
        Route::get('/{id}', [VideoController::class, 'show']);
    });
});
