<?php

namespace App\Http\Controllers\Mall\Api;

use App\Models\Store;
use App\Models\Slider;
use App\Models\Section;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\Mall\ProductInHomeResource;
use App\Http\Resources\Mall\StoreRecource;
use App\Http\Resources\Mall\SliderResource;
use App\Http\Resources\Mall\SectionResource;
use App\Models\Product;

class SectionController extends Controller
{
    use ApiResponse;

    public function index()
    {
        $sections = SectionResource::collection(Section::mall()->active()->latest()->get());

        return $this->sendResponse(200, $sections);
    }

    public function show(Section $section)
    {
        $data = [
            'ad' => '',
            'sliders' => SliderResource::collection(Slider::mall()->active()->get()),
            'stores' => StoreRecource::collection($section->stores()->active()->get()),
            'most_recent' => ProductInHomeResource::collection(Product::inSection($section->id)->active()->take(6)->get()),
            'most_sale' => []
        ];

        return $this->sendResponse(200, $data);
    }
}
