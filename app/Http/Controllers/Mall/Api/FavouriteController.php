<?php

namespace App\Http\Controllers\Mall\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Mall\Api\ProductFavouriteRequest;
use App\Http\Requests\Mall\Api\StoreFavouriteRequest;
use App\Http\Resources\Mall\ProductsInStorePageResource;
use App\Http\Resources\Mall\StoreRecource;
use App\Models\Favourite;
use App\Models\Product;
use App\Models\Store;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class FavouriteController extends Controller
{
    use ApiResponse;

    public function productIndex(Request $request)
    {
        $user = $request->user();
        $products = Product::whereIn('id', $user->mallFavourites()->pluck('product_id')->toArray())->get();
        $products = ProductsInStorePageResource::collection($products);
        return $this->sendResponse(200, $products);
    }

    public function storeIndex(Request $request)
    {
        $user = $request->user();
        $stores = Store::whereIn('id', $user->mallFavourites()->pluck('store_id')->toArray())->get();
        $stores = StoreRecource::collection($stores);
        return $this->sendResponse(200, $stores);
    }

    public function toggleProductFavourite(ProductFavouriteRequest $request)
    {
        $check = Favourite::where('product_id', $request->product_id)
        ->where('app', "mall")->first();
        if ($check) {
            $check->delete();
            $message = __("main.product_delete_from_favourite");
        } else {
            Favourite::create([
                'user_id' => $request->user()->id,
                'product_id' => $request->product_id,
                'app' => "mall"
            ]);
            $message = __("main.product_added_to_favourite");
        }

        return $this->sendResponse(200, '', $message);
    }

    public function toggleStoreFavourite(StoreFavouriteRequest $request)
    {
        $check = Favourite::where('store_id', $request->store_id)
        ->where('app', "mall")->first();
        if ($check) {
            $check->delete();
            $message = __("main.store_delete_from_favourite");
        } else {
            Favourite::create([
                'user_id' => $request->user()->id,
                'store_id' => $request->store_id,
                'app' => "mall"
            ]);
            $message = __("main.store_added_to_favourite");
        }
        return $this->sendResponse(200, '', $message);
    }
}
