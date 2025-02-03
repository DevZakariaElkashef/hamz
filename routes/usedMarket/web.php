<?php

use App\Http\Controllers\usedMarket\Admin\AdminController;
use App\Http\Controllers\usedMarket\Admin\AuthController;
use App\Http\Controllers\usedMarket\Admin\CategoryController;
use App\Http\Controllers\usedMarket\Admin\CommentController;
use App\Http\Controllers\usedMarket\Admin\ComplainController;
use App\Http\Controllers\usedMarket\Admin\FavouriteController;
use App\Http\Controllers\usedMarket\Admin\NotificationController;
use App\Http\Controllers\usedMarket\Admin\LangController;
use App\Http\Controllers\usedMarket\Admin\ProductController;
use App\Http\Controllers\usedMarket\Admin\SubCategoryController;
use App\Http\Controllers\usedMarket\Admin\UserController;
use App\Http\Controllers\usedMarket\Admin\HomeController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/lang/set/{lang}', [LangController::class, 'set'])->name('usedMarket.lang');
Route::group(['prefix' => '/'], function () {
    Route::get('/', [HomeController::class, 'index'])->name('usedMarket.home');
    Route::get('/MentanecMode', [AdminController::class, 'MentanecMode'])->name('usedMarket.MentanecMode');
    Route::get('/login', [AuthController::class, 'login'])->name('usedMarket.login');
    Route::get('/logout', [AuthController::class, 'logout'])->name('usedMarket.logout');
    Route::post('/login', [AuthController::class, 'signIn'])->name('usedMarket.signIn');
    Route::post('/signUp', [AuthController::class, 'signUp'])->name('usedMarket.signUp');
    Route::group(['prefix' => '/usedMarket', ], function () {
        Route::get('/', [AdminController::class, 'index'])->name('usedMarket.admin');
        /**
         * Route For User Controller
         */
        Route::group(
            ['prefix' => '/users'],
            function () {
                Route::get('/{status}', [UserController::class, 'index'])->name('usedMarket.users');
                Route::get('/search/searchUser', [UserController::class, 'searchUser'])->name('usedMarket.searchUser');
                Route::get('/user/addUser', [UserController::class, 'addUser'])->name('usedMarket.addUser');
                Route::post('/', [UserController::class, 'store'])->name('usedMarket.users.store');
                Route::post('/importExcel', [UserController::class, 'importExcel'])->name('usedMarket.users.importExcel');
                Route::delete('/', [UserController::class, 'delete'])->name('usedMarket.users.delete');
                Route::PUT('/', [UserController::class, 'update'])->name('usedMarket.users.update');
                Route::PUT('/verify', [UserController::class, 'verify'])->name('usedMarket.users.verify');
                Route::get('/editUser/{id}', [UserController::class, 'edit'])->name('usedMarket.users.edit');
                Route::get('/accepet/{id}', [UserController::class, 'accepet'])->name('usedMarket.users.accepet');
                Route::get('/rejecet/{id}', [UserController::class, 'rejecet'])->name('usedMarket.users.rejecet');
            }
        );

        /**
         * Route For admins Controller
         */
        Route::group(
            ['prefix' => '/admins'],
            function () {
                Route::get('/', [AdminController::class, 'indexAdmins'])->name('usedMarket.admins');
                Route::get('/addAdmin', [AdminController::class, 'addAdmin'])->name('usedMarket.addAdmin');
                Route::post('/', [AdminController::class, 'store'])->name('usedMarket.admins.store');
                Route::delete('/', [AdminController::class, 'delete'])->name('usedMarket.admins.delete');
                Route::PUT('/', [AdminController::class, 'update'])->name('usedMarket.admins.update');
                Route::PUT('/verify', [AdminController::class, 'verify'])->name('usedMarket.admins.verify');
                Route::get('/editAdmin/{id}', [AdminController::class, 'edit'])->name('usedMarket.admins.edit');
            }
        );
        /**
         * Route For categories Controller
         */
        Route::group(
            ['prefix' => '/categories'],
            function () {
                Route::get('/', [CategoryController::class, 'index'])->name('usedMarket.categories');
                Route::get('/addCategory', [CategoryController::class, 'addCategory'])->name('usedMarket.addCategory');
                Route::post('/', [CategoryController::class, 'store'])->name('usedMarket.categories.store');
                Route::delete('/', [CategoryController::class, 'delete'])->name('usedMarket.categories.delete');
                Route::PUT('/', [CategoryController::class, 'update'])->name('usedMarket.categories.update');
                Route::get('/editCategory/{id}', [CategoryController::class, 'edit'])->name('usedMarket.categories.edit');
            }
        );
        /**
         * Route For categories Controller
         */
        Route::group(
            ['prefix' => '/subCategories'],
            function () {
                Route::get('/', [SubCategoryController::class, 'index'])->name('usedMarket.subCategories');
                Route::get('/addsubCategories', [SubCategoryController::class, 'addsubCategories'])->name('usedMarket.addsubCategories');
                Route::post('/', [SubCategoryController::class, 'store'])->name('usedMarket.subCategories.store');
                Route::delete('/', [SubCategoryController::class, 'delete'])->name('usedMarket.subCategories.delete');
                Route::PUT('/', [SubCategoryController::class, 'update'])->name('usedMarket.subCategories.update');
                Route::PUT('/verify', [SubCategoryController::class, 'verify'])->name('usedMarket.subCategories.verify');
                Route::get('/editsubCategories/{id}', [SubCategoryController::class, 'edit'])->name('usedMarket.subCategories.edit');
            }
        );


        /**
         * Route For categories Controller
         */
        Route::group(
            ['prefix' => '/products'],
            function () {
                Route::get('/{status}', [ProductController::class, 'index'])->name('usedMarket.products');
                Route::get('/addProduct', [ProductController::class, 'addProduct'])->name('usedMarket.addProduct');
                Route::post('/', [ProductController::class, 'store'])->name('usedMarket.products.store');
                Route::delete('/', [ProductController::class, 'delete'])->name('usedMarket.products.delete');
                Route::PUT('/', [ProductController::class, 'update'])->name('usedMarket.products.update');
                Route::PUT('/verify', [ProductController::class, 'verify'])->name('usedMarket.products.verify');
                Route::get('/editProduct/{id}', [ProductController::class, 'edit'])->name('usedMarket.products.edit');
                Route::get('/product/accepet/{id}', [ProductController::class, 'accepetAds'])->name('usedMarket.products.accepet');
                Route::get('/product/rejecet/{id}', [ProductController::class, 'rejecet'])->name('usedMarket.products.rejecet');
                Route::get('/product/blockAds/{id}', [ProductController::class, 'blockAds'])->name('usedMarket.products.blockAds');
                Route::get('/product/discriminationAdsAction/{id}', [ProductController::class, 'discriminationAdsAction'])->name('usedMarket.products.discriminationAdsAction');
                Route::post('/product/subCategories', [ProductController::class, 'subCategories'])->name('usedMarket.products.subCategories');
            }
        );
        /**
         * Route for Comments
         */
        Route::group(
            ['prefix' => '/comments'],
            function () {
                Route::get('/', [CommentController::class, 'comments'])->name('usedMarket.comments');
                Route::get('/commentsMembers', [CommentController::class, 'commentsMembers'])->name('usedMarket.commentsMembers');
                Route::get('/view/{id}', [CommentController::class, 'adsCommentes'])->name('usedMarket.adsCommentes');
                Route::get('/userCommentes/{id}', [CommentController::class, 'userCommentes'])->name('usedMarket.userCommentes');
                Route::delete('/', [CommentController::class, 'delete'])->name('usedMarket.comments.delete');
            }
        );
        /**
         * Route for complains
         */
        Route::group(
            ['prefix' => '/complains'],
            function () {
                Route::get('/', [ComplainController::class, 'complains'])->name('usedMarket.complains');
                Route::get('/old', [ComplainController::class, 'old'])->name('usedMarket.complains.old');
                Route::delete('/delete', [ComplainController::class, 'delete'])->name('usedMarket.complains.delete');
                Route::get('/show/{id}', [ComplainController::class, 'show'])->name('usedMarket.complains.show');
                Route::get('/read-all', [ComplainController::class, 'read_all'])->name('usedMarket.complains.read_all');
            }
        );
        /**
         * Route for favourie
         */
        Route::group(
            ['prefix' => '/favourite'],
            function () {
                Route::get('/', [FavouriteController::class, 'favourite'])->name('usedMarket.favourite');
                Route::delete('/', [FavouriteController::class, 'delete'])->name('usedMarket.favourite.delete');
            }
        );

        /**
         * Route For notifications Controller
         */
        Route::group(
            ['prefix' => '/notifications'],
            function () {
                Route::get('/', [NotificationController::class, 'index'])->name('usedMarket.notifications');
                Route::post('/', [NotificationController::class, 'store'])->name('usedMarket.notifications.store');
            }
        );

    });
});
