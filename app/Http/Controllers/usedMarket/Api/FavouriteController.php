<?php

namespace App\Http\Controllers\usedMarket\Api;

use App\Models\Product;
use App\Models\Favourite;
use App\Traits\GeneralTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use App\Http\Controllers\Controller;
use App\Http\Resources\Usedmarket\ProductResource;

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
            $products = ProductResource::collection(Product::usedMarket()->whereHas('favourities', function ($query) use($request){
                $query->where('user_id', $request->user()->id);
            })->latest()->paginate(10));
            return $this->returnData("data", ["products" => $products], __('main.returnData'));
        } catch (\Throwable $e) {
            return $this->returnError(403, $e->getMessage());
        }
    }
    public function addfavourite(Request $request)
    {
        try{
            $favourite = Favourite::usedMarket()->where(['product_id' => $request->product_id, 'user_id' => $request->user()->id])->first();
            if($favourite)
            {
                $favourite->delete();
                return $this->returnSuccess(200, __('main.deleteFavourite'));
            }
            favourite::create(['product_id' => $request->product_id, 'user_id' => $request->user()->id, 'app' => 'resale']);
            return $this->returnSuccess(200, __('main.addfavourite'));

        } catch (\Throwable $e) {
            return $this->returnError(403, $e->getMessage());
        }
    }
}
