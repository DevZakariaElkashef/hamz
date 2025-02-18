<?php

use App\Http\Controllers\Api\OrderStoreRatingController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CouponController;
use App\Http\Controllers\Api\HomeController;
use App\Http\Controllers\Api\TransactionContoller;
use App\Http\Controllers\Api\WalletController;

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

Route::middleware('auth:sanctum')->group(function () {
    // -------------------------------
    //          AUTH USER ROUTES
    // -------------------------------
    // Route::post('logout', [AuthController::class, 'logout']);          // User logout
    // Route::get('get_profile', [ProfileController::class, 'index']);   // Get user profile
    // Route::post('update_profile', [ProfileController::class, 'update']); // Update user profile
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('deleteAccount', [AuthController::class, 'deleteAccount']);
    Route::get('getProfileData', [AuthController::class, 'getProfileData']);
    Route::post('updateProfile', [AuthController::class, 'updateProfile']);
    Route::post('updatePassword', [AuthController::class, 'updatePassword']);
    // -------------------------------

    // =============================================================================
    //                           Wallet ROUTES
    // =============================================================================

    Route::get('wallet', [WalletController::class, 'index']);
    Route::get('wallet/withdraws', [WalletController::class, 'withdraws']);
    Route::post('wallet/withdraws/make', [WalletController::class, 'make']);
    Route::get('wallet/transactions', [TransactionContoller::class, 'index']);

    // =============================================================================
    //                           Rate Orders ROUTES
    // =============================================================================
    Route::post('makeRate', [OrderStoreRatingController::class, 'store']);
    Route::post('addCoupon', [CouponController::class, 'addCouponToCart']);
    Route::post('removeCoupon', [CouponController::class, 'removeCouponFromCart']);
});
Route::get('home', [HomeController::class, 'index']);
Route::get('terms', [HomeController::class, 'terms']);
Route::get('about', [HomeController::class, 'about']);
Route::get('vendor-register', [HomeController::class, 'vendor_register']);

Route::get('apps', [HomeController::class, 'get_apps']);



// =============================================================================
//                           AUTH ROUTES FOR GUEST USERS
// =============================================================================
// Route::post('login', [AuthController::class, 'login']);             // User login
// Route::post('register', [AuthController::class, 'register']);       // User registration
// Route::post('verify_otp', [AuthController::class, 'verifyOtp']);    // OTP verification
// Route::post('send_otp', [AuthController::class, 'sendOtp']);        // Send OTP
// Route::post('forget_password', [AuthController::class, 'updatePassword']); // Password reset
Route::post('register', [AuthController::class, 'register']);
Route::post('verifyCode', [AuthController::class, 'verifyCode']);
Route::post('verifyCodePassword', [AuthController::class, 'verifyCodePassword']);
Route::post('resendCode', [AuthController::class, 'resendCode']);
Route::post('resetPassword', [AuthController::class, 'resetPassword']);
Route::post('changePassword', [AuthController::class, 'changePassword']);
Route::post('login', [AuthController::class, 'login']);
// =============================================================================
