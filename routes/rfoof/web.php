<?php

use App\Http\Controllers\rfoof\Admin\AdminController;
use App\Http\Controllers\rfoof\Admin\AuthController;
use App\Http\Controllers\rfoof\Admin\CategoryController;
use App\Http\Controllers\rfoof\Admin\CommentController;
use App\Http\Controllers\rfoof\Admin\ComplainController;
use App\Http\Controllers\rfoof\Admin\FavouriteController;
use App\Http\Controllers\rfoof\Admin\NotificationController;
use App\Http\Controllers\rfoof\Admin\LangController;
use App\Http\Controllers\rfoof\Admin\ProductController;
use App\Http\Controllers\rfoof\Admin\SubCategoryController;
use App\Http\Controllers\rfoof\Admin\UserController;
use App\Http\Controllers\rfoof\Admin\HomeController;
use App\Http\Controllers\rfoof\Admin\SliderController;
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

Route::get('/lang/set/{lang}', [LangController::class, 'set'])->name('rfoof.lang');


Route::group(['prefix' => '/'], function () {
    Route::get('/', [HomeController::class, 'index'])->name('rfoof.home');
    Route::get('/MentanecMode', [AdminController::class, 'MentanecMode'])->name('rfoof.MentanecMode');
    Route::get('/login', [AuthController::class, 'login'])->name('rfoof.login');
    Route::get('/logout', [AuthController::class, 'logout'])->name('rfoof.logout');
    Route::post('/login', [AuthController::class, 'signIn'])->name('rfoof.signIn');
    Route::post('/signUp', [AuthController::class, 'signUp'])->name('rfoof.signUp');
    /**
         * Route For sliders Controller
         */
        Route::as('rfoof.')->group(function () {
            Route::resource('sliders', SliderController::class);
            Route::get('search-sliders', [SliderController::class, 'search'])->name('sliders.search');
            Route::get('sliders-toggle-status/{slider}', [SliderController::class, 'toggleStatus'])->name('slider.toggleStatus');
            Route::get('sliders-toggle-fixed-status/{slider}', [SliderController::class, 'toggleFixedStatus'])->name('slider.toggleFixedStatus');
            Route::delete('delete-sliders', [SliderController::class, 'delete'])->name('sliders.delete');
        });
    Route::group(['prefix' => '/rfoof', ], function () {
        Route::get('/', [AdminController::class, 'index'])->name('rfoof.admin');
        /**
         * Route For User Controller
         */
        Route::group(
            ['prefix' => '/users'],
            function () {
                Route::get('/{status}', [UserController::class, 'index'])->name('rfoof.users');
                Route::get('/search/searchUser', [UserController::class, 'searchUser'])->name('rfoof.searchUser');
                Route::get('/user/addUser', [UserController::class, 'addUser'])->name('rfoof.addUser');
                Route::post('/', [UserController::class, 'store'])->name('rfoof.users.store');
                Route::post('/importExcel', [UserController::class, 'importExcel'])->name('rfoof.users.importExcel');
                Route::delete('/', [UserController::class, 'delete'])->name('rfoof.users.delete');
                Route::PUT('/', [UserController::class, 'update'])->name('rfoof.users.update');
                Route::PUT('/verify', [UserController::class, 'verify'])->name('rfoof.users.verify');
                Route::get('/editUser/{id}', [UserController::class, 'edit'])->name('rfoof.users.edit');
                Route::get('/accepet/{id}', [UserController::class, 'accepet'])->name('rfoof.users.accepet');
                Route::get('/rejecet/{id}', [UserController::class, 'rejecet'])->name('rfoof.users.rejecet');
            }
        );

        /**
         * Route For admins Controller
         */
        Route::group(
            ['prefix' => '/admins'],
            function () {
                Route::get('/', [AdminController::class, 'indexAdmins'])->name('rfoof.admins');
                Route::get('/addAdmin', [AdminController::class, 'addAdmin'])->name('rfoof.addAdmin');
                Route::post('/', [AdminController::class, 'store'])->name('rfoof.admins.store');
                Route::delete('/', [AdminController::class, 'delete'])->name('rfoof.admins.delete');
                Route::PUT('/', [AdminController::class, 'update'])->name('rfoof.admins.update');
                Route::PUT('/verify', [AdminController::class, 'verify'])->name('rfoof.admins.verify');
                Route::get('/editAdmin/{id}', [AdminController::class, 'edit'])->name('rfoof.admins.edit');
            }
        );
        /**
         * Route For categories Controller
         */
        Route::group(
            ['prefix' => '/categories'],
            function () {
                Route::get('/', [CategoryController::class, 'index'])->name('rfoof.categories');
                Route::get('/addCategory', [CategoryController::class, 'addCategory'])->name('rfoof.addCategory');
                Route::post('/', [CategoryController::class, 'store'])->name('rfoof.categories.store');
                Route::delete('/', [CategoryController::class, 'delete'])->name('rfoof.categories.delete');
                Route::PUT('/', [CategoryController::class, 'update'])->name('rfoof.categories.update');
                Route::get('/editCategory/{id}', [CategoryController::class, 'edit'])->name('rfoof.categories.edit');
            }
        );
        /**
         * Route For categories Controller
         */
        Route::group(
            ['prefix' => '/subCategories'],
            function () {
                Route::get('/', [SubCategoryController::class, 'index'])->name('rfoof.subCategories');
                Route::get('/addsubCategories', [SubCategoryController::class, 'addsubCategories'])->name('rfoof.addsubCategories');
                Route::post('/', [SubCategoryController::class, 'store'])->name('rfoof.subCategories.store');
                Route::delete('/', [SubCategoryController::class, 'delete'])->name('rfoof.subCategories.delete');
                Route::PUT('/', [SubCategoryController::class, 'update'])->name('rfoof.subCategories.update');
                Route::PUT('/verify', [SubCategoryController::class, 'verify'])->name('rfoof.subCategories.verify');
                Route::get('/editsubCategories/{id}', [SubCategoryController::class, 'edit'])->name('rfoof.subCategories.edit');
            }
        );


        /**
         * Route For categories Controller
         */
        Route::group(
            ['prefix' => '/products'],
            function () {
                Route::get('/{status}', [ProductController::class, 'index'])->name('rfoof.products');
                Route::get('/addProduct', [ProductController::class, 'addProduct'])->name('rfoof.addProduct');
                Route::post('/', [ProductController::class, 'store'])->name('rfoof.products.store');
                Route::delete('/', [ProductController::class, 'delete'])->name('rfoof.products.delete');
                Route::PUT('/', [ProductController::class, 'update'])->name('rfoof.products.update');
                Route::PUT('/verify', [ProductController::class, 'verify'])->name('rfoof.products.verify');
                Route::get('/editProduct/{id}', [ProductController::class, 'edit'])->name('rfoof.products.edit');
                Route::get('/product/accepet/{id}', [ProductController::class, 'accepetAds'])->name('rfoof.products.accepet');
                Route::get('/product/rejecet/{id}', [ProductController::class, 'rejecet'])->name('rfoof.products.rejecet');
                Route::get('/product/blockAds/{id}', [ProductController::class, 'blockAds'])->name('rfoof.products.blockAds');
                Route::get('/product/discriminationAdsAction/{id}', [ProductController::class, 'discriminationAdsAction'])->name('rfoof.products.discriminationAdsAction');
                Route::post('/product/subCategories', [ProductController::class, 'subCategories'])->name('rfoof.products.subCategories');
            }
        );
        /**
         * Route for Comments
         */
        Route::group(
            ['prefix' => '/comments'],
            function () {
                Route::get('/', [CommentController::class, 'comments'])->name('rfoof.comments');
                Route::get('/commentsMembers', [CommentController::class, 'commentsMembers'])->name('rfoof.commentsMembers');
                Route::get('/view/{id}', [CommentController::class, 'adsCommentes'])->name('rfoof.adsCommentes');
                Route::get('/userCommentes/{id}', [CommentController::class, 'userCommentes'])->name('rfoof.userCommentes');
                Route::delete('/', [CommentController::class, 'delete'])->name('rfoof.comments.delete');
            }
        );
        /**
         * Route for complains
         */
        Route::group(
            ['prefix' => '/complains'],
            function () {
                Route::get('/{id}', [ComplainController::class, 'complains'])->name('rfoof.complains');
                Route::delete('/', [ComplainController::class, 'delete'])->name('rfoof.complains.delete');
            }
        );
        /**
         * Route for favourie
         */
        Route::group(
            ['prefix' => '/favourite'],
            function () {
                Route::get('/', [FavouriteController::class, 'favourite'])->name('rfoof.favourite');
                Route::delete('/', [FavouriteController::class, 'delete'])->name('rfoof.favourite.delete');
            }
        );

        /**
         * Route For notifications Controller
         */
        Route::group(
            ['prefix' => '/notifications'],
            function () {
                Route::get('/', [NotificationController::class, 'index'])->name('rfoof.notifications');
                Route::post('/', [NotificationController::class, 'store'])->name('rfoof.notifications.store');
            }
        );

    });
});
