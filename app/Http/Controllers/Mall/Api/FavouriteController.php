<?php

namespace App\Http\Controllers\Mall\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Mall\Api\ProductFavouriteRequest;
use App\Http\Requests\Mall\Api\StoreFavouriteRequest;
use App\Models\Favourite;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class FavouriteController extends Controller
{
    use ApiResponse;

    public function productIndex(Request $request)
    {
        // return 
    }

    public function productFavourite(ProductFavouriteRequest $request)
    {
        $check = Favourite::where('product_id', $request->product_id)->first();
        if ($check) {
            $check->delete();
            $message = __("mall.product_delete_from_favourite");
        } else {
            Favourite::create([
                'user_id' => $request->user()->id,
                'product_id' => $request->product_id
            ]);
            $message = __("mall.product_added_to_favourite");
        }

        return $this->sendResponse(200, '', $message);
    }

    public function storeFavourite(StoreFavouriteRequest $request)
    {
        $check = Favourite::where('store_id', $request->store_id)->first();
        if ($check) {
            $check->delete();
            $message = __("mall.store_delete_from_favourite");
        } else {
            Favourite::create([
                'user_id' => $request->user()->id,
                'store_id' => $request->store_id
            ]);
            $message = __("mall.store_added_to_favourite");
        }
        return $this->sendResponse(200, '', $message);
    }
}
