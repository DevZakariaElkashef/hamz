<?php

namespace App\Http\Controllers\usedMarket\Api;

use App\Models\Car;
use App\Models\City;
use App\Models\Term;
use App\Models\About;
use App\Models\Color;
use App\Models\Contact;
use App\Models\Policie;
use App\Models\Setting;
use App\Traits\GeneralTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use App\Http\Controllers\Controller;
use App\Http\Resources\Usedmarket\CityResource;
use App\Http\Resources\Usedmarket\ColorResource;
use App\Http\Resources\Usedmarket\HomeResources;
use App\Http\Requests\Usedmarket\Api\ContactRequest;

class DataController extends Controller
{
    use GeneralTrait;
    public function __construct()
    {
        App::setLocale(request()->header('lang') ?? 'ar');
    }
    public function dataRgister()
    {
        try {
            $cities = CityResource::collection(City::get());
            $cars = HomeResources::collection(Car::get());
            $colors = ColorResource::collection(Color::get());
            return $this->returnData("data", ['cars' => $cars, 'colors' => $colors, 'cities' => $cities], __('api.returnData'));
        } catch (\Throwable $th) {
            return $this->returnError(403, $th->getMessage());
        }
    }
    public function about()
    {
        try {
            $about = About::first();
            return $this->returnData("data", ['about' => $about->value()], __('api.returnData'));
        } catch (\Throwable $th) {
            return $this->returnError(403, $th->getMessage());
        }
    }
    public function terms()
    {
        try {
            $terms = Term::first();
            return $this->returnData("data", ['terms' => $terms->value()], __('api.returnData'));
        } catch (\Throwable $th) {
            return $this->returnError(403, $th->getMessage());
        }
    }
    public function policies()
    {
        try {
            $policies = Policie::first();
            return $this->returnData("data", ['policies' => $policies->value()], __('api.returnData'));
        } catch (\Throwable $th) {
            return $this->returnError(403, $th->getMessage());
        }
    }
    public function splaches()
    {
        // try {
        //     $splaches = Splach::get();

        //     return $this->returnData("data", ['splaches' => SplashResource::collection($splaches)], __('api.returnData'));
        // } catch (\Throwable $th) {
        //     return $this->returnError(403, $th->getMessage());
        // }
    }
    public function helpCenter()
    {
        // try {
        //     $splaches = HelpCenter::get();

        //     return $this->returnData("data", ['helpCenter' => helpCenterResource::collection($splaches)], __('api.returnData'));
        // } catch (\Throwable $th) {
        //     return $this->returnError(403, $th->getMessage());
        // }
    }
    public function searchHelpCenter(Request $request)
    {
        // try {
        //     $splaches = HelpCenter::where(function ($query) use ($request) {
        //         $query->where('title_ar', 'LIKE', '%' . $request->search . '%')->orWhere('title_en', 'LIKE', '%' . $request->search . '%')->orWhere('title_ku', 'LIKE', '%' . $request->search . '%');
        //     })->get();

        //     return $this->returnData("data", ['helpCenter' => helpCenterResource::collection($splaches)], __('api.returnData'));
        // } catch (\Throwable $th) {
        //     return $this->returnError(403, $th->getMessage());
        // }
    }
    public function info()
    {
        try {
            $user_id = request()->user() ? request()->user()->id : "";
            $user_random_key = request()->user() ? request()->user()->user_random_key : "";
            $setting = Setting::first();
            $shareLink = 'استعمل رمز الدعوة الخاص بي ' . $user_random_key . ' و احصل علي 1000 IQD دينار لرحلتك الاولي، حمل التطبيق الان ';
            return $this->returnData("data", ['phone' => $setting->phone, 'email' => $setting->email, 'whatsapp' => $setting->whatsapp, 'support_id' => $user_id, 'shareLink' => $shareLink, 'quests' => asset('uploads/' . $setting->quests)], __('api.returnData'));
        } catch (\Throwable $th) {
            return $this->returnError(403, $th->getMessage());
        }
    }
    public function generalCars()
    {
        try {
            $cars = HomeResources::collection(Car::get());
            return $this->returnData("data", ["cars" => $cars], __('api.returnData'));
        } catch (\Throwable $th) {
            return $this->returnError(403, $th->getMessage());
        }
    }
    public function cities()
    {
        try {
            $cities = CityResource::collection(City::get());
            return $this->returnData("data", ["cities" => $cities], __('api.returnData'));
        } catch (\Throwable $th) {
            return $this->returnError(403, $th->getMessage());
        }
    }
    public function contactUs(ContactRequest $request)
    {
        try {
            Contact::create($request->all());

            return $this->returnSuccess(200, __('api.contactSuccess'));
        } catch (\Throwable $th) {
            return $this->returnError(403, $th->getMessage());
        }
    }
}
