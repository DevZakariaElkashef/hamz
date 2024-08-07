<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Mall\Api\HomeController;
use App\Http\Controllers\Mall\Api\SectionController;
use App\Http\Controllers\Mall\Api\StoreController;

Route::get('home', [HomeController::class, 'index']);

/**Begain Section Routes */
Route::get('sections', [SectionController::class, 'index']);
Route::get('sections/{section}', [SectionController::class, 'show']);
/**End Section Routes */

/**Start Stores Routes */
Route::get('stores', [StoreController::class, 'index']);
Route::get('stores/{store}', [StoreController::class, 'show']);
/**End Stores Routes */
