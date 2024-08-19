<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Mall\Admin\HomeController;
use App\Http\Controllers\Mall\Admin\ImageController;
use App\Http\Controllers\Mall\Admin\SectionController;
use App\Http\Controllers\Mall\Admin\SliderController;
use App\Http\Controllers\Mall\Admin\StoreController;

Route::get('/', [HomeController::class, 'index'])->name('mall.home');


// images
Route::delete('delete-image', [ImageController::class, 'destroy'])->name('images.destroy');
// images

Route::as('mall.')->group(function () {
/**start Slider Routes */
    Route::resource('sliders', SliderController::class);
    Route::get('search-sliders', [SliderController::class, 'search'])->name('sliders.search');
    Route::delete('delete-sliders', [SliderController::class, 'delete'])->name('sliders.delete');
/**end Slider Routes */


/**start Slider Routes */
    Route::resource('sections', SectionController::class);
    Route::get('search-sections', [SectionController::class, 'search'])->name('sections.search');
    Route::delete('delete-sections', [SectionController::class, 'delete'])->name('sections.delete');
/**end Slider Routes */


/**start Slider Routes */
    Route::resource('stores', StoreController::class);
    Route::get('search-stores', [StoreController::class, 'search'])->name('stores.search');
    Route::delete('delete-stores', [StoreController::class, 'delete'])->name('stores.delete');
/**end Slider Routes */
});
