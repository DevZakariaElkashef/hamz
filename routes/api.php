<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ProfileController;
use App\Http\Controllers\Mall\Web\HomeController;

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
});



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

