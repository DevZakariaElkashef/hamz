<?php

namespace App\Http\Controllers\Booth\Api;

use App\Models\Store;
use App\Models\Slider;
use App\Models\Section;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\Booth\ProductInHomeResource;
use App\Http\Resources\Booth\StoreRecource;
use App\Http\Resources\Booth\SliderResource;
use App\Http\Resources\Booth\SectionResource;
use App\Models\Product;

class SectionController extends Controller
{
    use ApiResponse;

    public function index()
    {
        $sections = SectionResource::collection(Section::booth()->active()->latest()->get());

        return $this->sendResponse(200, $sections);
    }

    public function show(Section $section)
    {
        $data = [
            'ad' => '',
            'sliders' => SliderResource::collection(Slider::booth()->active()->get()),
            'stores' => StoreRecource::collection($section->stores()->active()->get()),
            'most_recent' => ProductInHomeResource::collection(Product::inSection($section->id)->active()->take(6)->get()),
            'most_sale' => []
        ];

        return $this->sendResponse(200, $data);
    }
}
