<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Mall\Admin\CityController;
use App\Http\Controllers\Mall\Admin\HomeController;
use App\Http\Controllers\Mall\Admin\ImageController;
use App\Http\Controllers\Mall\Admin\StoreController;
use App\Http\Controllers\Mall\Admin\SliderController;
use App\Http\Controllers\Mall\Admin\SectionController;
use App\Http\Controllers\Mall\Admin\CategoryController;
use App\Http\Controllers\Mall\Admin\ProductController;

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
Route::resource('cities', CityController::class);
Route::get('search-cities', [CityController::class, 'search'])->name('cities.search');
Route::delete('delete-cities', [CityController::class, 'delete'])->name('cities.delete');
/**end Slider Routes */


/**start Slider Routes */
    Route::resource('stores', StoreController::class);
    Route::get('search-stores', [StoreController::class, 'search'])->name('stores.search');
    Route::delete('delete-stores', [StoreController::class, 'delete'])->name('stores.delete');
/**end Slider Routes */


/**start Slider Routes */
Route::resource('categories', CategoryController::class);
Route::get('search-categories', [CategoryController::class, 'search'])->name('categories.search');
Route::delete('delete-categories', [CategoryController::class, 'delete'])->name('categories.delete');


/**start Slider Routes */
Route::resource('products', ProductController::class);
Route::get('search-products', [ProductController::class, 'search'])->name('products.search');
Route::delete('delete-products', [ProductController::class, 'delete'])->name('products.delete');
/**end Slider Routes */
});
