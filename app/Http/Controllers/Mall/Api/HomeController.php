<?php

namespace App\Http\Controllers\Mall\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Mall\ProductInHomeResource;
use App\Http\Resources\Mall\SectionResource;
use App\Http\Resources\Mall\SliderResource;
use App\Models\Product;
use App\Models\Section;
use App\Models\Slider;
use App\Traits\ApiResponse;

class HomeController extends Controller
{
    use ApiResponse;

    public function index()
    {
        $ad = Slider::mall()->fixed()->first();
        
        $data = [
            'ad' => $ad ? new SliderResource($ad) : null,
            'sliders' => SliderResource::collection(Slider::mall()->active()->get()),
            'sections' => SectionResource::collection(Section::mall()->active()->with('stores')->latest()->take(4)->get()),
            'most_recent' => ProductInHomeResource::collection(Product::mall()->active()->latest()->take(4)->get()),
            'most_sale' => [],
        ];

        return $this->sendResponse(200, $data);
    }
}
