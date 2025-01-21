<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AppSettingRequest;
use App\Http\Requests\Admin\CommissionRequest;
use App\Models\AppSetting;
use Illuminate\Http\Request;

class AppSettingController extends Controller
{

    public function __construct()
    {
        $this->middleware('can:hamz.applications.index')->only(['index', 'store']);
    }

    public function index()
    {
        $commission = AppSetting::where('app', 'all')
        ->where('key', 'commission')->first();
        return view("settings.commission", compact('commission'));
    }

    public function store(CommissionRequest $request)
    {
        $commission = AppSetting::all()->where('key', 'commission')->first();
        if ($commission) {
            $commission->value_ar = $request->value;
            $commission->value_en = $request->value;
            $commission->app = 'all';
            $commission->save();
        } else {
            $commission = AppSetting::create([
                'key' => 'commission',
                'value_ar' => $request->value,
                'value_en' => $request->value,
            ]);
            $commission->app = 'all';
            $commission->save();
        }

        return to_route('commission.index')->with('success', __("main.updated_successffully"));
    }

    public function commission_auth()
    {
        $commission_auth = AppSetting::where('app', 'all')
        ->where('key', 'commission_auth')->first();
        return view("settings.commission_auth", compact('commission_auth'));
    }

    public function commission_auth_store(AppSettingRequest $request)
    {
        $commission_auth = AppSetting::all()->where('key', 'commission_auth')->first();
        if ($commission_auth) {
            $commission_auth->value_ar = $request->value_ar;
            $commission_auth->value_en = $request->value_en;
            $commission_auth->app = 'all';
            $commission_auth->save();
        } else {
            $commission_auth = AppSetting::create([
                'key' => 'commission_auth',
                'value_ar' => $request->value_ar,
                'value_en' => $request->value_en,
            ]);
            $commission_auth->app = 'all';
            $commission_auth->save();
        }

        return to_route('commission_auth.index')->with('success', __("main.updated_successffully"));
    }
}
