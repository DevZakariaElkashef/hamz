<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\ContactUsController;
use App\Http\Controllers\Admin\ContactTypeController;

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

Route::get('/', function () {
    return view('index');
})->name('home');

/**start Slider Routes */
Route::resource('contactTypes', ContactTypeController::class);
Route::get('search-contactTypes', [ContactTypeController::class, 'search'])->name('contactTypes.search');
Route::get('contactTypes-toggle-status/{contactType}', [ContactTypeController::class, 'toggleStatus'])->name('contacttype.toggleStatus');
Route::delete('delete-contactTypes', [ContactTypeController::class, 'delete'])->name('contactTypes.delete');
/**end Slider Routes */

/**start Slider Routes */
Route::resource('contacts', ContactUsController::class);
Route::get('search-contacts', [ContactUsController::class, 'search'])->name('contacts.search');
Route::get('contacts-toggle-status/{contact}', [ContactUsController::class, 'toggleStatus'])->name('contact.toggleStatus');
Route::delete('delete-contacts', [ContactUsController::class, 'delete'])->name('contacts.delete');
/**end Slider Routes */
