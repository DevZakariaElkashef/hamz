<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Mall\Api\CartController;
use App\Http\Controllers\Mall\Api\HomeController;
use App\Http\Controllers\Mall\Api\StoreController;
use App\Http\Controllers\Mall\Api\ProductController;
use App\Http\Controllers\Mall\Api\SectionController;

Route::get('home', [HomeController::class, 'index']);

/**Begain Section Routes */
Route::get('sections', [SectionController::class, 'index']);
Route::get('sections/{section}', [SectionController::class, 'show']);
/**End Section Routes */

/**Start Stores Routes */
Route::get('stores', [StoreController::class, 'index']);
Route::get('stores/{store}', [StoreController::class, 'show']);
/**End Stores Routes */


/**Start Products Routes */
Route::get("products/{product}", [ProductController::class, 'show']);
/**End Products Routes */


/**Start Cart Routes */
Route::post('update_cart_qty', [CartController::class, 'update']);
/**End Cart Routes */
