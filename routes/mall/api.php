<?php

use App\Http\Controllers\Mall\Api\CancleOrderReasonController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Mall\Api\CartController;
use App\Http\Controllers\Mall\Api\DeliveryController;
use App\Http\Controllers\Mall\Api\FavouriteController;
use App\Http\Controllers\Mall\Api\HomeController;
use App\Http\Controllers\Mall\Api\OrderController;
use App\Http\Controllers\Mall\Api\StoreController;
use App\Http\Controllers\Mall\Api\ProductController;
use App\Http\Controllers\Mall\Api\SectionController;

// =============================================================================
//                                 HOME ROUTE
// =============================================================================
Route::get('home', [HomeController::class, 'index']);
// =============================================================================






// =============================================================================
//                            SECTION ROUTES
// =============================================================================
Route::get('sections', [SectionController::class, 'index']);        // List all sections
Route::get('sections/{section}', [SectionController::class, 'show']); // Show details of a specific section
// =============================================================================




// =============================================================================
//                             STORES ROUTES
// =============================================================================
Route::get('stores', [StoreController::class, 'index']);            // List all stores
Route::get('stores/{store}', [StoreController::class, 'show']);     // Show details of a specific store
// =============================================================================




// =============================================================================
//                            PRODUCTS ROUTES
// =============================================================================
Route::get('products/{product}', [ProductController::class, 'show']); // Show details of a specific product
// =============================================================================




// =============================================================================
//                            AUTH ROUTES (PROTECTED)
// =============================================================================
Route::middleware(['api', 'auth:sanctum'])->group(function () {





    // -------------------------------
    //            CART ROUTES
    // -------------------------------
    Route::get('view_cart', [CartController::class, 'index']); // get cart
    Route::get('show_cart/{cart}', [CartController::class, 'show']); // get cart
    Route::post('update_cart_qty', [CartController::class, 'update']); // Update cart quantity
    Route::post('delete_cart_item', [CartController::class, 'delete']); // Update cart quantity
    Route::post('clear_cart', [CartController::class, 'destroy']); // get cart
    // -------------------------------



    // -------------------------------
    //            Favourite ROUTES
    // -------------------------------
    Route::get('favourite_products', [FavouriteController::class, 'productIndex']);
    Route::get('favourite_stores', [FavouriteController::class, 'storeIndex']);
    Route::post('toggle_product_favourite', [FavouriteController::class, 'toggleProductFavourite']); // toggleProductFavourite
    Route::post('toggle_store_favourite', [FavouriteController::class, 'toggleStoreFavourite']); // toggleStoreFavourite
    // -------------------------------



    // -------------------------------
    //            Delviery ROUTES
    // -------------------------------
    Route::get('delivery_types', [DeliveryController::class, 'index']);
    Route::get('calcDelivery', [DeliveryController::class, 'calcDelivery']);
    // -------------------------------



    // -------------------------------
    //            Order ROUTES
    // -------------------------------
    Route::get('order_statuses', [OrderController::class, 'viewStatuses']);
    Route::get('my_orders', [OrderController::class, 'index']);
    Route::get('show_orders/{order}', [OrderController::class, 'show']);
    Route::post('make_order', [OrderController::class, 'store']);
    Route::post('cancle-order', [OrderController::class, 'cancle']);
    // -------------------------------


    // cancle order reasons
    Route::get('cancle-order-reasons', [CancleOrderReasonController::class, 'index']);
});
// =============================================================================
