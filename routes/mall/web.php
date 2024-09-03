<?php

use App\Http\Controllers\Mall\Admin\AttributeController;
use App\Http\Controllers\Mall\Admin\BrandController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Mall\Admin\CityController;
use App\Http\Controllers\Mall\Admin\HomeController;
use App\Http\Controllers\Mall\Admin\ImageController;
use App\Http\Controllers\Mall\Admin\StoreController;
use App\Http\Controllers\Mall\Admin\SliderController;
use App\Http\Controllers\Mall\Admin\SectionController;
use App\Http\Controllers\Mall\Admin\CategoryController;
use App\Http\Controllers\Mall\Admin\OptionController;
use App\Http\Controllers\Mall\Admin\ProductController;

Route::get('/', [HomeController::class, 'index'])->name('mall.home');


// images
Route::delete('delete-image', [ImageController::class, 'destroy'])->name('images.destroy');
// images

Route::as('mall.')->group(function () {
/**start Slider Routes */
    Route::resource('sliders', SliderController::class);
    Route::get('search-sliders', [SliderController::class, 'search'])->name('sliders.search');
    Route::get('sliders-toggle-status/{slider}', [SliderController::class, 'toggleStatus'])->name('slider.toggleStatus');
    Route::delete('delete-sliders', [SliderController::class, 'delete'])->name('sliders.delete');
/**end Slider Routes */


/**start Slider Routes */
    Route::resource('sections', SectionController::class);
    Route::get('search-sections', [SectionController::class, 'search'])->name('sections.search');
    Route::get('sections-toggle-status/{section}', [SectionController::class, 'toggleStatus'])->name('sections.toggleStatus');
    Route::delete('delete-sections', [SectionController::class, 'delete'])->name('sections.delete');
/**end Slider Routes */


/**start Slider Routes */
Route::resource('cities', CityController::class);
Route::get('search-cities', [CityController::class, 'search'])->name('cities.search');
Route::get('cities-toggle-status/{city}', [CityController::class, 'toggleStatus'])->name('cities.toggleStatus');
Route::delete('delete-cities', [CityController::class, 'delete'])->name('cities.delete');
/**end Slider Routes */


/**start Slider Routes */
    Route::resource('stores', StoreController::class);
    Route::get('search-stores', [StoreController::class, 'search'])->name('stores.search');
    Route::get('stores-toggle-status/{store}', [StoreController::class, 'toggleStatus'])->name('stores.toggleStatus');
    Route::get('stores-by-section', [StoreController::class, 'getStoresBySection'])->name('stores.bySection');
    Route::delete('delete-stores', [StoreController::class, 'delete'])->name('stores.delete');
/**end Slider Routes */


/**start Slider Routes */
Route::resource('categories', CategoryController::class);
Route::get('search-categories', [CategoryController::class, 'search'])->name('categories.search');
Route::get('categories-toggle-status/{category}', [CategoryController::class, 'toggleStatus'])->name('categories.toggleStatus');
Route::get('categories-by-store', [CategoryController::class, 'getCategoriesBystore'])->name('categories.byStore');
Route::get('categories-by-section', [CategoryController::class, 'getCategoriesBySection'])->name('categories.bySection');
Route::delete('delete-categories', [CategoryController::class, 'delete'])->name('categories.delete');


/**start Slider Routes */
Route::resource('brands', BrandController::class);
Route::get('search-brands', [BrandController::class, 'search'])->name('brands.search');
Route::get('brands-toggle-status/{brand}', [BrandController::class, 'toggleStatus'])->name('brands.toggleStatus');
Route::get('brands-by-store', [BrandController::class, 'getBrandsBystore'])->name('brands.byStore');
Route::get('brands-by-section', [BrandController::class, 'getbrandsBySection'])->name('brands.bySection');
Route::delete('delete-brands', [BrandController::class, 'delete'])->name('brands.delete');


/**start Slider Routes */
Route::resource('attributes', AttributeController::class);
Route::get('search-attributes', [AttributeController::class, 'search'])->name('attributes.search');
Route::get('attributes-toggle-status/{attribute}', [AttributeController::class, 'toggleStatus'])->name('attributes.toggleStatus');
Route::delete('delete-attributes', [AttributeController::class, 'delete'])->name('attributes.delete');


/**start Slider Routes */
Route::resource('options', OptionController::class);
Route::get('search-options', [OptionController::class, 'search'])->name('options.search');
Route::get('options-toggle-status/{option}', [OptionController::class, 'toggleStatus'])->name('options.toggleStatus');
Route::get('options-by-attribute', [OptionController::class, 'getOptionsByAttribute'])->name('options.byAttribute');
Route::delete('delete-options', [OptionController::class, 'delete'])->name('options.delete');


/**start Slider Routes */
Route::resource('products', ProductController::class);
Route::get('search-products', [ProductController::class, 'search'])->name('products.search');
Route::get('products-toggle-status/{product}', [ProductController::class, 'toggleStatus'])->name('products.toggleStatus');
Route::delete('delete-products', [ProductController::class, 'delete'])->name('products.delete');
/**end Slider Routes */
});
