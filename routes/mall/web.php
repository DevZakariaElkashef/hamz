<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Mall\Web\HomeController;

Route::get('/', [HomeController::class, 'index'])->name('mall.home');
