<?php

use App\Http\Controllers\Mall\Api\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Mall\Api\CartController;
use App\Http\Controllers\Mall\Api\HomeController;
use App\Http\Controllers\Mall\Api\StoreController;
use App\Http\Controllers\Mall\Api\ProductController;
use App\Http\Controllers\Mall\Api\ProfileController;
use App\Http\Controllers\Mall\Api\SectionController;

Route::get('home', [HomeController::class, 'index']);


/**Begain Auth For Guest Routes */
Route::post('login', [AuthController::class, 'login']);
Route::post('register', [AuthController::class, 'register']);
Route::post('verify_otp', [AuthController::class, 'verifyOtp']);
Route::post('send_otp', [AuthController::class, 'sendOtp']);
Route::post('forget_password', [AuthController::class, 'updatePassword']);
/**Begain Auth For Guest Routes */

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


/**Start Auth Routes */
Route::middleware(['api', 'auth:sanctum'])->group(function () {

    /**Start Auth User Routes */
    Route::post('logout', [AuthController::class, 'logout']);
    Route::get("get_profile", [ProfileController::class, 'index']);
    Route::post("update_profile", [ProfileController::class, 'update']);
    /**End Auth User Routes */


    /**Start Cart Routes */
    Route::post('update_cart_qty', [CartController::class, 'update']);
    /**End Cart Routes */
});
/**Start Auth Routes */
