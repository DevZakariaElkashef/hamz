<?php

use App\Http\Controllers\rfoof\Api\AuthController;
use App\Http\Controllers\rfoof\Api\HomeController;
use App\Http\Controllers\rfoof\Api\ProductController;
use App\Http\Controllers\rfoof\Api\FavouriteController;
use App\Http\Controllers\rfoof\Api\ChatController;
use App\Http\Controllers\rfoof\Api\NotificationController;
use App\Http\Controllers\rfoof\Api\DataController;
use Illuminate\Support\Facades\Route;

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

Route::group(['middleware' => ['api']], function () {
    Route::get('home', [HomeController::class, 'home']);
    Route::get('categories', [HomeController::class, 'categories']);
    Route::get('otherCategories', [HomeController::class, 'otherCategories']);
    Route::get('subCategories', [HomeController::class, 'subCategories']);
    Route::get('filter', [HomeController::class, 'filter']);
    Route::get('countries', [HomeController::class, 'countries']);
    Route::get('cities', [HomeController::class, 'cities']);
    Route::get('dataCar', [HomeController::class, 'dataCar']);
    Route::get('getModels', [HomeController::class, 'getModels']);

    Route::get('about', [DataController::class, 'about']);
    Route::get('terms', [DataController::class, 'terms']);
    Route::post('contactUs', [DataController::class, 'contactUs']);

});
Route::group(['middleware' => ['api', 'auth:sanctum']], function () {
    Route::get('productComments', [ProductController::class, 'productComments']);
    Route::post('addProduct', [ProductController::class, 'addProduct']);
    Route::post('updateProduct', [ProductController::class, 'updateProduct']);
    Route::get('deleteImage', [ProductController::class, 'deleteImage']);
    Route::get('deleteProduct', [ProductController::class, 'deleteProduct']);
    Route::post('addCommenet', [ProductController::class, 'addCommenet']);
    Route::post('addComplain', [ProductController::class, 'addComplain']);
    Route::get('myAds', [ProductController::class, 'myAds']);
    Route::get('sellerProducts', [ProductController::class, 'sellerProducts']);

    Route::get('getFavourities', [FavouriteController::class, 'getFavourities']);
    Route::get('addfavourite', [FavouriteController::class, 'addfavourite']);

    Route::post('sendMessage', [ChatController::class, 'sendMessage']);
    Route::get('getMessages', [ChatController::class, 'getMessages']);
    Route::get('getChats', [ChatController::class, 'getChats']);

    Route::get('getNotifications', [NotificationController::class, 'getNotifications']);
    Route::get('deleteNotifications', [NotificationController::class, 'deleteNotifications']);
    Route::get('readAll', [NotificationController::class, 'readAll']);
});
