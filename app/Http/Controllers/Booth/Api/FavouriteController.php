<?php

namespace App\Http\Controllers\Booth\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Booth\Api\ProductFavouriteRequest;
use App\Http\Requests\Booth\Api\StoreFavouriteRequest;
use App\Http\Resources\Booth\ProductsInStorePageResource;
use App\Http\Resources\Booth\StoreRecource;
use App\Models\Favourite;
use App\Models\Product;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class FavouriteController extends Controller
{
    use ApiResponse;

    public function productIndex(Request $request)
    {
        $user = $request->user();
        $products = Product::whereIn('id', $user->favourites()->pluck('product_id')->toArray())->get();
        $products = ProductsInStorePageResource::collection($products);
        return $this->sendResponse(200, $products);
    }

    public function storeIndex(Request $request)
    {
        $user = $request->user();
        $stores = Product::whereIn('id', $user->favourites()->pluck('store_id')->toArray())->get();
        $stores = StoreRecource::collection($stores);
        return $this->sendResponse(200, $stores);
    }

    public function toggleProductFavourite(ProductFavouriteRequest $request)
    {
        $check = Favourite::where('product_id', $request->product_id)->first();
        if ($check) {
            $check->delete();
            $message = __("main.product_delete_from_favourite");
        } else {
            Favourite::create([
                'user_id' => $request->user()->id,
                'product_id' => $request->product_id
            ]);
            $message = __("main.product_added_to_favourite");
        }

        return $this->sendResponse(200, '', $message);
    }

    public function toggleStoreFavourite(StoreFavouriteRequest $request)
    {
        $check = Favourite::where('store_id', $request->store_id)->first();
        if ($check) {
            $check->delete();
            $message = __("main.store_delete_from_favourite");
        } else {
            Favourite::create([
                'user_id' => $request->user()->id,
                'store_id' => $request->store_id
            ]);
            $message = __("main.store_added_to_favourite");
        }
        return $this->sendResponse(200, '', $message);
    }
}
