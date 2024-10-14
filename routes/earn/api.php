<?php

use App\Http\Controllers\Earn\Api\HomeController;
use App\Http\Controllers\Earn\Api\VideoController;
use App\Http\Controllers\Earn\api\WithdrowController;

Route::middleware('auth:sanctum')->group(function () {
    Route::get('home', [HomeController::class, 'index']);

    Route::prefix('videos')->group(function () {
        Route::get('/', [VideoController::class, 'index']);
        Route::get('/next', [VideoController::class, 'next']);
        Route::get('/finish/{id}', [VideoController::class, 'finish']);
        Route::get('/{id}', [VideoController::class, 'show']);
    });

    Route::prefix('withdrow')->group(function() {
        Route::get('/', [WithdrowController::class, 'index']);
        Route::post('/store', [WithdrowController::class, 'store']);
    });
});
