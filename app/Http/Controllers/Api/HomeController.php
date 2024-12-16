<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\Api\AppImageResource;
use App\Models\Application;
use App\Models\Slider;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\Api\SliderResource;

class HomeController extends Controller
{
    use ApiResponse;

    public function index()
    {
        $ad = Slider::hamz()->fixed()->first();

        $data = [
            'ad' => $ad ? new SliderResource($ad) : null,
            'sliders' => SliderResource::collection(Slider::hamz()->active()->scrollable()->get()),
            'apps' => AppImageResource::collection(Application::where('id', '!=', 1)->get()),
        ];

        return $this->sendResponse(200, $data);
    }
}
