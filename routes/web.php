<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\TermController;
use App\Http\Controllers\Admin\AboutController;
use App\Http\Controllers\Admin\ClientController;
use App\Http\Controllers\Admin\SocialController;
use App\Http\Controllers\Admin\VendorController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\ContactUsController;
use App\Http\Controllers\Admin\CityController;
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

Route::resource('applications', SettingController::class)->only('index', 'update');
Route::resource('abouts', AboutController::class)->only('index', 'update');

/**start Slider Routes */
Route::resource('socials', SocialController::class);
Route::get('search-socials', [socialController::class, 'search'])->name('socials.search');
Route::get('socials-toggle-status/{social}', [socialController::class, 'toggleStatus'])->name('social.toggleStatus');
Route::delete('delete-socials', [socialController::class, 'delete'])->name('socials.delete');
/**end Slider Routes */

/**start Slider Routes */
Route::resource('terms', TermController::class);
Route::get('search-terms', [TermController::class, 'search'])->name('terms.search');
Route::get('terms-toggle-status/{term}', [TermController::class, 'toggleStatus'])->name('term.toggleStatus');
Route::delete('delete-terms', [TermController::class, 'delete'])->name('terms.delete');
/**end Slider Routes */

/**start Slider Routes */
Route::resource('clients', ClientController::class);
Route::get('search-clients', [ClientController::class, 'search'])->name('clients.search');
Route::get('clients-toggle-status/{client}', [ClientController::class, 'toggleStatus'])->name('clients.toggleStatus');
Route::get('clients-export', [ClientController::class, 'export'])->name('clients.export');
Route::post('clients-import', [ClientController::class, 'import'])->name('clients.import');
Route::delete('delete-clients', [ClientController::class, 'delete'])->name('clients.delete');
/**end Slider Routes */

/**start Slider Routes */
Route::resource('vendors', VendorController::class);
Route::get('search-vendors', [VendorController::class, 'search'])->name('vendors.search');
Route::get('vendors-toggle-status/{vendor}', [VendorController::class, 'toggleStatus'])->name('vendors.toggleStatus');
Route::get('vendors-export', [VendorController::class, 'export'])->name('vendors.export');
Route::post('vendors-import', [VendorController::class, 'import'])->name('vendors.import');
Route::delete('delete-vendors', [VendorController::class, 'delete'])->name('vendors.delete');
/**end Slider Routes */

/**start Slider Routes */
Route::resource('cities', CityController::class);
Route::get('search-cities', [CityController::class, 'search'])->name('cities.search');
Route::get('cities-toggle-status/{city}', [CityController::class, 'toggleStatus'])->name('cities.toggleStatus');
Route::get('cities-export', [CityController::class, 'export'])->name('cities.export');
Route::post('cities-import', [CityController::class, 'import'])->name('cities.import');
Route::delete('delete-cities', [CityController::class, 'delete'])->name('cities.delete');
/**end Slider Routes */
