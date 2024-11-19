<?php

namespace App\Http\Controllers\usedMarket\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Product\AddRequest;
use App\Http\Requests\Product\UpdateRequest;
use App\Traits\GeneralTrait;
use App\Traits\ImageUploadTrait;
use App\Traits\MapTrait;
use App\Models\Images;
use App\Models\Products;
use App\Models\Commenets;
use App\Models\Complains;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Str;
use App\Http\Resources\Api\ProductResource;
use App\Http\Resources\Api\UserResource;

class ProductController extends Controller
{
    use GeneralTrait, ImageUploadTrait, MapTrait;
    public function __construct()
    {
        App::setLocale(request()->header('lang') ?? 'ar');
    }
    public function addProduct(AddRequest $request)
    {
        try {
            // Generate a random string
            $randomString = str::random(10);

            $address = $this->getAddressFromLatLong($request->lat, $request->long);
            // Merge additional data into the request data
            $data = array_merge($request->all(), [
                'user_id' => $request->user()->id,
                'unique_number' => $randomString,
                'address_ar' => $address['ar'],
                'address_en' => $address['en'],
            ]);

            // Create the product with the merged data
            $product = Products::create($data);
            foreach ($request->images as $image) {
                $imageName = rand(11111, 99999) . '_ads.' . $image->extension();
                $this->uploadImage($image, $imageName, 'ads');
                Images::create([
                    'product_id' => $product->id,
                    'image' => $imageName,
                ]);
            }
            return $this->returnSuccess(200, __('api.addProduct'));
        } catch (\Throwable $e) {
            return $this->returnError(403, $e->getMessage());
        }
    }
    public function updateProduct(UpdateRequest $request)
    {
        try {
            $product = Products::find($request->product_id);
            $address = $this->getAddressFromLatLong($request->lat, $request->long);
            // Merge additional data into the request data
            $data = array_merge($request->all(), [
                'address_ar' => $address['ar'],
                'address_en' => $address['en'],
            ]);
            $product->update($request->all());
            if($request->images)
            {
                foreach ($request->images as $image) {
                    $imageName = rand(11111, 99999) . '_ads.' . $image->extension();
                    $this->uploadImage($image, $imageName, 'ads');
                    Images::create([
                        'product_id' => $product->id,
                        'image' => $imageName,
                    ]);
                }
            }
            return $this->returnSuccess(200, __('api.updateProduct'));
        } catch (\Throwable $e) {
            return $this->returnError(403, $e->getMessage());
        }
    }
    public function deleteImage(Request $request)
    {
        try{
            $product = Images::find($request->image_id);
            $product->delete();
            return $this->returnSuccess(200, __('api.deleteImage'));
        } catch (\Throwable $e) {
            return $this->returnError(403, $e->getMessage());
        }
    }
    public function deleteProduct(Request $request)
    {
        try{
            $product = Products::find($request->product_id);
            $product->delete();
            return $this->returnSuccess(200, __('api.deleteProduct'));
        } catch (\Throwable $e) {
            return $this->returnError(403, $e->getMessage());
        }
    }
    public function addComplain(Request $request)
    {
        try{
            Complains::create([
                'product_id' => $request->product_id,
                'message' => $request->message,
                'user_id' => $request->user()->id,
            ]);

            return $this->returnSuccess(200, __('api.addComplain'));
        } catch (\Throwable $e) {
            return $this->returnError(403, $e->getMessage());
        }
    }
    public function addCommenet(Request $request)
    {
        try{
            Commenets::create([
                'product_id' => $request->product_id,
                'comment' => $request->message,
                'rate' => $request->rate,
                'user_id' => $request->user()->id,
            ]);

            return $this->returnSuccess(200, __('api.addCommenet'));
        } catch (\Throwable $e) {
            return $this->returnError(403, $e->getMessage());
        }
    }

    public function sellerProducts(Request $request)
    {
        try{
            $seller = User::find($request->seller_id);
            $products = ProductResource::collection(Products::where(['user_id' => $request->seller_id])->latest()->paginate(10));
            return $this->returnData("data", ["seller" => new UserResource($seller), 'products' => $products], __('api.returnData'));
        } catch (\Throwable $e) {
            return $this->returnError(403, $e->getMessage());
        }
    }
    public function myAds(Request $request)
    {
        try{
            $products = ProductResource::collection(Products::where(['user_id' => $request->user()->id])->latest()->paginate(10));
            return $this->returnData("data", ['products' => $products], __('api.returnData'));
        } catch (\Throwable $e) {
            return $this->returnError(403, $e->getMessage());
        }
    }
}
