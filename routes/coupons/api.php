<?php

use App\Http\Controllers\Coupon\Api\HomeController;


Route::group(['middleware' => ['api']], function () {
    Route::get('home', [HomeController::class, 'home']);
    Route::get('categories', [HomeController::class, 'categories']);
    Route::get('coupons/{category_id}', [HomeController::class, 'coupons']);
    // Route::get('subCategories', [HomeController::class, 'subCategories']);
    // Route::get('filter', [HomeController::class, 'filter']);
    // Route::get('countries', [HomeController::class, 'countries']);
    // Route::get('cities', [HomeController::class, 'cities']);
    // Route::get('dataCar', [HomeController::class, 'dataCar']);
    // Route::get('getModels', [HomeController::class, 'getModels']);
    // Route::get('about', [DataController::class, 'about']);
    // Route::get('terms', [DataController::class, 'terms']);
    // Route::post('contactUs', [DataController::class, 'contactUs']);

});
Route::middleware('auth:sanctum')->group(function () {

});
