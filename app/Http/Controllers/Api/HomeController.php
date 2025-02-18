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
use Carbon\Carbon;

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
        // $data = Term::where('is_active',1)->get();
        // $terms = $data ? TermsResource::collection($data) : null;
        // return $this->sendResponse(200, $terms);

        $term = AppSetting::where('app', 'all')->where('key', 'term')->first();
        $data = $term ? AboutResource::make($term) : null;
        return $this->sendResponse(200, $data);
    }
    public function about()
    {
        $about = AppSetting::where('app', 'all')->where('key', 'about_us')->first();
        $data = $about ? AboutResource::make($about) : null;
        return $this->sendResponse(200, $data);
    }

    public function vendor_register()  {
        $data = AppSetting::where('app', 'all')->where('key', 'saller_link')->first();
        $data1 = [
            'value' => $data->value_ar,
        ];
        return $this->sendResponse(200, $data1);
    }

    public function get_apps()  {
        $apps = Application::where('is_active', 1)->get();
        $data = [];
        foreach($apps as $app){
            $row = [
                'id' => $app->id,
                'name' => $app->name,
                'logo' => $app->logo ? asset($app->logo) : '',
                'is_active' => $app->is_active,
                'created_at' => Carbon::parse($app->created_at)->format('Y-m-d h:i:s'),
                'updated_at' => Carbon::parse($app->updated_at)->format('Y-m-d h:i:s'),
            ];
            $data[] = $row;
        }
        return $this->sendResponse(200, $data);
    }
}
