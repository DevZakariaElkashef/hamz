<?php
use App\Http\Controllers\Earn\HomeController;
use App\Http\Controllers\Earn\VideoController;

Route::middleware('auth:sanctum')->group(function () {
    Route::get('home', [HomeController::class, 'index']);

    Route::prefix('videos')->group(function () {
        Route::get('/', [VideoController::class, 'index']);
        Route::get('/next', [VideoController::class, 'next']);
        Route::get('/{id}', [VideoController::class, 'show']);
    });
});
