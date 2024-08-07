<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Mall\Web\HomeController;
use App\Http\Controllers\Mall\Web\SliderController;

Route::get('/', [HomeController::class, 'index'])->name('mall.home');

/**start Slider Routes */
Route::as('mall.')->group(function () {
    Route::resource('sliders', SliderController::class);
    Route::get('search-sliders', [SliderController::class, 'search'])->name('sliders.search');
    Route::delete('delete-sliders', [SliderController::class, 'delete'])->name('sliders.delete');
});
/**end Slider Routes */
