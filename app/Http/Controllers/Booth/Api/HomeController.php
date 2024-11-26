<?php

namespace App\Http\Controllers\Booth\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Booth\ProductInHomeResource;
use App\Http\Resources\Booth\SectionResource;
use App\Http\Resources\Booth\SliderResource;
use App\Models\Product;
use App\Models\Section;
use App\Models\Slider;
use App\Traits\ApiResponse;

class HomeController extends Controller
{
    use ApiResponse;

    public function index()
    {
        $ad = Slider::booth()->fixed()->first();

        $data = [
            'ad' => $ad ? new SliderResource($ad) : null,
            'sliders' => SliderResource::collection(Slider::booth()->active()->get()),
            'sections' => SectionResource::collection(Section::booth()->active()->with('stores')->latest()->take(4)->get()),
            'most_recent' => ProductInHomeResource::collection(Product::booth()->active()->latest()->take(4)->get()),
            'most_sale' => [],
        ];

        return $this->sendResponse(200, $data);
    }
}
