<?php

namespace App\Http\Controllers\usedMarket\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Traits\GeneralTrait;
use Illuminate\Support\Facades\App;
use App\Models\Favourite;
use App\Models\Products;
use App\Http\Resources\Api\ProductResource;

class FavouriteController extends Controller
{
    use GeneralTrait;
    public function __construct()
    {
        App::setLocale(request()->header('lang') ?? 'ar');
    }
    public function getFavourities(Request $request)
    {
        try{
            $products = ProductResource::collection(Product::whereHas('favourities', function ($query) use($request){
                $query->where('user_id', $request->user()->id);
            })->latest()->paginate(10));
            return $this->returnData("data", ["products" => $products], __('api.returnData'));
        } catch (\Throwable $e) {
            return $this->returnError(403, $e->getMessage());
        }
    }
    public function addfavourite(Request $request)
    {
        try{
            $favourite = Favourite::where(['product_id' => $request->product_id, 'user_id' => $request->user()->id])->first();
            if($favourite)
            {
                $favourite->delete();
                return $this->returnSuccess(200, __('api.deleteFavourite'));
            }
            favourite::create(['product_id' => $request->product_id, 'user_id' => $request->user()->id]);
            return $this->returnSuccess(200, __('api.addfavourite'));

        } catch (\Throwable $e) {
            return $this->returnError(403, $e->getMessage());
        }
    }
}
