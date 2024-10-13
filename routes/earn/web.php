<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Earn\Admin\HomeController;
use App\Http\Controllers\Mall\Admin\ImageController;
use App\Http\Controllers\Earn\Admin\SliderController;
use App\Http\Controllers\Earn\Admin\CategoryController;




Route::get('/', [HomeController::class, 'index'])->name('earn.home');


// images
Route::delete('delete-image', [ImageController::class, 'destroy'])->name('images.destroy');
// images

Route::as('earn.')->group(function () {
    /**start Slider Routes */
    Route::resource('sliders', SliderController::class);
    Route::get('search-sliders', [SliderController::class, 'search'])->name('sliders.search');
    Route::get('sliders-toggle-status/{slider}', [SliderController::class, 'toggleStatus'])->name('slider.toggleStatus');
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
});
