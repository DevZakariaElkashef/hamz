<?php

use App\Http\Controllers\Admin\SubscripeController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Earn\Admin\HomeController;
use App\Http\Controllers\Earn\Admin\ViewController;
use App\Http\Controllers\Earn\Admin\VideoController;
use App\Http\Controllers\Mall\Admin\ImageController;
use App\Http\Controllers\Earn\Admin\SliderController;
use App\Http\Controllers\Earn\Admin\PackageController;
use App\Http\Controllers\Earn\Admin\CategoryController;
use App\Http\Controllers\Earn\Admin\SubscriptionController;


Route::middleware('auth')->group(function () {



    Route::get('/', [HomeController::class, 'index'])->name('earn.home');


    // images
    Route::delete('delete-image', [ImageController::class, 'destroy'])->name('images.destroy');
    // images

    Route:: as('earn.')->group(function () {
        /**start Slider Routes */
        Route::resource('sliders', SliderController::class);
        Route::get('search-sliders', [SliderController::class, 'search'])->name('sliders.search');
        Route::get('sliders-toggle-status/{slider}', [SliderController::class, 'toggleStatus'])->name('slider.toggleStatus');
        Route::get('sliders-toggle-fixed-status/{slider}', [SliderController::class, 'toggleFixedStatus'])->name('slider.toggleFixedStatus');
        Route::delete('delete-sliders', [SliderController::class, 'delete'])->name('sliders.delete');
        /**end Slider Routes */


        /**start Slider Routes */
        Route::resource('categories', CategoryController::class);
        Route::get('search-categories', [CategoryController::class, 'search'])->name('categories.search');
        Route::get('categories-toggle-status/{category}', [CategoryController::class, 'toggleStatus'])->name('categories.toggleStatus');
        Route::get('categories-export', [CategoryController::class, 'export'])->name('categories.export');
        Route::post('categories-import', [CategoryController::class, 'import'])->name('categories.import');
        Route::get('categories-by-store', [CategoryController::class, 'getCategoriesBystore'])->name('categories.byStore');
        Route::get('categories-by-section', [CategoryController::class, 'getCategoriesBySection'])->name('categories.bySection');
        Route::delete('delete-categories', [CategoryController::class, 'delete'])->name('categories.delete');


        /**start Slider Routes */
        Route::resource('packages', PackageController::class);
        Route::get('search-packages', [PackageController::class, 'search'])->name('packages.search');
        Route::get('packages-toggle-status/{package}', [PackageController::class, 'toggleStatus'])->name('package.toggleStatus');
        Route::delete('delete-packages', [PackageController::class, 'delete'])->name('packages.delete');
        /**end Slider Routes */


        /**start Slider Routes */
        Route::resource('subscriptions', SubscriptionController::class);
        Route::get('search-subscriptions', [SubscriptionController::class, 'search'])->name('subscriptions.search');
        Route::get('subscriptions-toggle-status/{subscription}', [SubscriptionController::class, 'toggleStatus'])->name('subscription.toggleStatus');
        Route::delete('delete-subscriptions', [SubscriptionController::class, 'delete'])->name('subscriptions.delete');
        /**end Slider Routes */


        /**start Slider Routes */
        Route::resource('videos', VideoController::class);
        Route::get('videos-notactive', [VideoController::class, 'notactive'])->name('videos.notactive');
        Route::get('videos-unpaid', [VideoController::class, 'unpaid'])->name('videos.unpaid');
        Route::get('videos-paid', [VideoController::class, 'paid'])->name('videos.paid');

        Route::middleware('earn')->group(function () {
            Route::get('search-videos', [VideoController::class, 'search'])->name('videos.search');
            Route::get('videos-toggle-status/{video}', [VideoController::class, 'toggleStatus'])->name('video.toggleStatus');
            Route::delete('delete-videos', [VideoController::class, 'delete'])->name('videos.delete');
        });
        /**end Slider Routes */


        /**start Slider Routes */
        Route::resource('views', ViewController::class);
        Route::middleware('earn')->group(function () {
            Route::get('search-views', [ViewController::class, 'search'])->name('views.search');
            Route::get('views-toggle-status/{view}', [ViewController::class, 'toggleStatus'])->name('view.toggleStatus');
            Route::delete('delete-views', [ViewController::class, 'delete'])->name('views.delete');
        });
        /**end Slider Routes */
    });
});

Route:: as('earn.')->group(function () {
    /**start Slider Routes */
    // Route::resource('subscripe', SubscripeController::class)->only('create', 'store')->middleware('auth');
    Route::get('subscripe/create/{video_id}', [SubscripeController::class, 'create'])->name('subscripe.create')->middleware('auth');
    Route::post('subscripe/store/{video_id}', [SubscripeController::class, 'store'])->name('subscripe.store')->middleware('auth');
    Route::get('subscripe-callback', [SubscripeController::class, 'callBack'])->name('subscripe.callback');
    Route::get('subscripe-success', [SubscripeController::class, 'success'])->name('subscripe.success');
    Route::get('subscripe-error', [SubscripeController::class, 'error'])->name('subscripe.error');
    /**end Slider Routes */
});


