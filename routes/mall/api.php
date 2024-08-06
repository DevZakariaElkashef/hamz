<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Mall\Api\HomeController;

Route::get('home', [HomeController::class, 'index']);
