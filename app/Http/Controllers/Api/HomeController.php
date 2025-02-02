<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\Api\AppImageResource;
use App\Models\Application;
use App\Models\Slider;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\Api\AboutResource;
use App\Http\Resources\Api\SliderResource;
use App\Http\Resources\Api\TermsResource;
use App\Models\About;
use App\Models\AppSetting;
use App\Models\Term;

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
    public function terms()
    {
        $data = Term::where('is_active',1)->get();
        $terms = $data ? TermsResource::collection($data) : null;
        return $this->sendResponse(200, $terms);
    }
    public function about()
    {
        $about = AppSetting::where('app', 'all')->where('key', 'about_us')->first();
        $data = $about ? AboutResource::make($about) : null;
        return $this->sendResponse(200, $data);
    }
}