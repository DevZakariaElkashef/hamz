<?php

namespace App\Http\Controllers\Api;

use App\Models\Slider;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\Api\SliderResource;

class HomeController extends Controller
{
    public function index()
    {
        $ad = Slider::hamz()->fixed()->first();

        $data = [
            'ad' => $ad ? new SliderResource($ad) : null,
            'sliders' => SliderResource::collection(Slider::hamz()->active()->get()),
            // 'apps' => SectionResource::collection(Section::mall()->active()->latest()->take(4)->get()),
        ];

        return $this->sendResponse(200, $data);
    }
}
