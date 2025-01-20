<?php

namespace App\Http\Controllers\rfoof\Api;

use App\Http\Resources\rfoof\CommentResource;
use App\Models\User;
use App\Models\Image;
use App\Models\Product;
use App\Traits\MapTrait;
use App\Models\Commenets;
use App\Models\Complains;
use Illuminate\Support\Str;
use App\Traits\GeneralTrait;
use Illuminate\Http\Request;
use App\Traits\ImageUploadTrait;
use Illuminate\Support\Facades\App;
use App\Http\Controllers\Controller;
use App\Http\Resources\rfoof\UserResource;
use App\Http\Resources\rfoof\ProductResource;
use App\Http\Requests\rfoof\Product\AddRequest;
use App\Http\Requests\rfoof\Product\UpdateRequest;

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
                'app' => 'rfoof'
            ]);

            // Create the product with the merged data
            $product = Product::create($data);
            $publicPath = public_path("uploads/adsImages/");
            foreach ($request->images as $image) {
                $imageName = rand(11111, 99999) . "_$product->id" . "_ads." . $image->extension();
                // Move the new image to the public directory
                $image->move($publicPath, $imageName);
                Image::create([
                    'product_id' => $product->id,
                    'image' => $imageName,
                ]);
            }
            return $this->returnSuccess(200, __('main.addProduct'));
        } catch (\Throwable $e) {
            return $this->returnError(403, $e->getMessage());
        }
    }
    public function updateProduct(UpdateRequest $request)
    {
        try {
            $product = Product::find($request->product_id);
            $address = $this->getAddressFromLatLong($request->lat, $request->long);
            // Merge additional data into the request data
            $data = array_merge($request->all(), [
                'address_ar' => $address['ar'],
                'address_en' => $address['en'],
            ]);
            $product->update($request->all());
            if($request->images)
            {
                $publicPath = public_path("uploads/adsImages/");
                foreach ($request->images as $image) {
                    $imageName = rand(11111, 99999) ."_$product->id". '_ads.' . $image->extension();
                    // Move the new image to the public directory
                    $image->move($publicPath, $imageName);
                    Image::create([
                        'product_id' => $product->id,
                        'image' => $imageName,
                    ]);
                }
            }
            return $this->returnSuccess(200, __('main.updateProduct'));
        } catch (\Throwable $e) {
            return $this->returnError(403, $e->getMessage());
        }
    }
    public function deleteImage(Request $request)
    {
        try{
            $product = Image::find($request->image_id);
            $product->delete();
            return $this->returnSuccess(200, __('main.deleteImage'));
        } catch (\Throwable $e) {
            return $this->returnError(403, $e->getMessage());
        }
    }
    public function deleteProduct(Request $request)
    {
        try{
            $product = Product::find($request->product_id);
            $product->delete();
            return $this->returnSuccess(200, __('main.deleteProduct'));
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
                'app' => 'rfoof'
            ]);

            return $this->returnSuccess(200, __('main.addComplain'));
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
                'app' => 'rfoof'
            ]);

            return $this->returnSuccess(200, __('main.addCommenet'));
        } catch (\Throwable $e) {
            return $this->returnError(403, $e->getMessage());
        }
    }

    public function productComments(Request $request)
    {
        try{
            $comments = Commenets::where('product_id', $request->product_id)->get();
            $data = CommentResource::collection($comments);
            return $this->returnData("data", ["comments" => $data], __('main.returnData'));
        } catch (\Throwable $e) {
            return $this->returnError(403, $e->getMessage());
        }
    }

    public function sellerProducts(Request $request)
    {
        try{
            $seller = User::find($request->seller_id);
            $products = ProductResource::collection(Product::rfoof()->where(['user_id' => $request->seller_id])->latest()->paginate(10));
            return $this->returnData("data", ["seller" => new UserResource($seller), 'products' => $products], __('main.returnData'));
        } catch (\Throwable $e) {
            return $this->returnError(403, $e->getMessage());
        }
    }
    public function myAds(Request $request)
    {
        try{
            $products = ProductResource::collection(Product::rfoof()->where(['user_id' => $request->user()->id])->latest()->paginate(10));
            return $this->returnData("data", ['products' => $products], __('main.returnData'));
        } catch (\Throwable $e) {
            return $this->returnError(403, $e->getMessage());
        }
    }
}
