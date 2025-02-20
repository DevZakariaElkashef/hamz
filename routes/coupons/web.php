<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Mall\Admin\ImageController;
use App\Http\Controllers\Coupon\Admin\HomeController;
use App\Http\Controllers\Coupon\Admin\CouponController;
use App\Http\Controllers\Coupon\Admin\SliderController;
use App\Http\Controllers\Coupon\Admin\PackageController;
use App\Http\Controllers\Coupon\Admin\CategoryController;
use App\Http\Controllers\Coupon\Admin\SubscripeController;
use App\Http\Controllers\Coupon\Admin\SubscriptionController;
use App\Http\Controllers\Coupon\Admin\UsedCouponController;

Route::middleware('auth')->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('coupon.home');

    // images
    Route::delete('delete-image', [ImageController::class, 'destroy'])->name('images.destroy');
    // images

    Route::as('coupon.')->group(function () {

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
        /**end Slider Routes */

        /**start Slider Routes */
        Route::resource('coupons', CouponController::class);
        Route::middleware('coupons')->group(function () {
            Route::get('search-coupons', [CouponController::class, 'search'])->name('coupons.search');
            Route::get('coupons-toggle-status/{coupon}', [CouponController::class, 'toggleStatus'])->name('coupon.toggleStatus');
            Route::get('coupons-export', [CouponController::class, 'export'])->name('coupons.export');
            Route::post('coupons-import', [CouponController::class, 'import'])->name('coupons.import');
            Route::delete('delete-coupons', [CouponController::class, 'delete'])->name('coupons.delete');
        });
        /**end Slider Routes */

        /**start Slider Routes */
        Route::group(['prefix' => 'used-coupons', 'as' => 'used-coupons.'], function () {
            Route::get('/', [UsedCouponController::class, 'index'])->name('index');
            Route::get('/search', [UsedCouponController::class, 'search'])->name('search');
            Route::post('/store', [UsedCouponController::class, 'store'])->name('store');
            Route::delete('/destroy/{id}', [UsedCouponController::class, 'destroy'])->name('destroy');
            Route::delete('/delete', [UsedCouponController::class, 'delete'])->name('delete');
        });
        /**end Slider Routes */

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
    });
});

Route::as('coupon.')->group(function () {
    /**start Slider Routes */
    Route::resource('subscripe', SubscripeController::class)->only('create', 'store')->middleware('auth');
    Route::get('subscripe-callback', [SubscripeController::class, 'callBack'])->name('subscripe.callback');
    Route::get('subscripe-success', [SubscripeController::class, 'success'])->name('subscripe.success');
    Route::get('subscripe-error', [SubscripeController::class, 'error'])->name('subscripe.error');
    /**end Slider Routes */
});
