<?php

namespace App\Http\Controllers\Mall\Api;

use App\Models\Slider;
use App\Models\Product;
use App\Models\Section;
use App\Models\OrderItem;
use App\Traits\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\Mall\SliderResource;
use App\Http\Resources\Mall\SectionResource;
use App\Http\Resources\Mall\ProductInHomeResource;

class HomeController extends Controller
{
    use ApiResponse;

    public function index()
    {
        $ad = Slider::mall()->fixed()->first();
        $mostSaledProductIds = OrderItem::mostSoldByApp('mall')->pluck('product_id')->toArray();
        $mostSaledProducts = Product::whereIn('id', $mostSaledProductIds)->get();

        $data = [
            'ad' => $ad ? new SliderResource($ad) : null,
            'sliders' => SliderResource::collection(Slider::mall()->active()->scrollable()->get()),
            'sections' => SectionResource::collection(Section::mall()->active()->with('stores')->latest()->take(4)->get()),
            'most_recent' => ProductInHomeResource::collection(Product::mall()->active()->latest()->take(4)->get()),
            'most_sale' => ProductInHomeResource::collection($mostSaledProducts),
        ];

        return $this->sendResponse(200, $data);
    }
}
