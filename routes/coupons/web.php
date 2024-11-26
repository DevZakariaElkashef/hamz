<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Mall\Admin\ImageController;
use App\Http\Controllers\Coupon\Admin\HomeController;
use App\Http\Controllers\Coupon\Admin\CouponController;
use App\Http\Controllers\Coupon\Admin\SliderController;
use App\Http\Controllers\Coupon\Admin\PackageController;
use App\Http\Controllers\Coupon\Admin\CategoryController;

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
    Route::get('search-coupons', [CouponController::class, 'search'])->name('coupons.search');
    Route::get('coupons-toggle-status/{coupon}', [CouponController::class, 'toggleStatus'])->name('coupon.toggleStatus');
    Route::get('coupons-export', [CouponController::class, 'export'])->name('coupons.export');
    Route::post('coupons-import', [CouponController::class, 'import'])->name('coupons.import');
    Route::delete('delete-coupons', [CouponController::class, 'delete'])->name('coupons.delete');
    /**end Slider Routes */



    /**start Slider Routes */
    Route::resource('packages', PackageController::class);
    Route::get('search-packages', [PackageController::class, 'search'])->name('packages.search');
    Route::get('packages-toggle-status/{package}', [PackageController::class, 'toggleStatus'])->name('package.toggleStatus');
    Route::delete('delete-packages', [PackageController::class, 'delete'])->name('packages.delete');
    /**end Slider Routes */
});
