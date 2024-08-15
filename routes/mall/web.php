<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Mall\Admin\HomeController;
use App\Http\Controllers\Mall\Admin\SectionController;
use App\Http\Controllers\Mall\Admin\SliderController;

Route::get('/', [HomeController::class, 'index'])->name('mall.home');

/**start Slider Routes */
Route::as('mall.')->group(function () {
    Route::resource('sliders', SliderController::class);
    Route::get('search-sliders', [SliderController::class, 'search'])->name('sliders.search');
    Route::delete('delete-sliders', [SliderController::class, 'delete'])->name('sliders.delete');
});
/**end Slider Routes */

/**start Slider Routes */
Route::as('mall.')->group(function () {
    Route::resource('sections', SectionController::class);
    Route::get('search-sections', [SectionController::class, 'search'])->name('sections.search');
    Route::delete('delete-sections', [SectionController::class, 'delete'])->name('sections.delete');
});
/**end Slider Routes */
