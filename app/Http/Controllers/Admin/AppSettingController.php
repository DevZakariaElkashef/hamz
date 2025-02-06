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
        $this->middleware('can:hamz.applications.index')->only(['commission', 'commission_dtore']);
    }

    public function term()
    {
        $term = AppSetting::where('app', 'all')
        ->where('key', 'term')->first();
        return view("settings.terms.index", compact('term'));
    }

    public function term_store(AppSettingRequest $request)
    {
        $term = AppSetting::all()->where('key', 'term')->first();
        if ($term) {
            $term->value_ar = $request->value_ar;
            $term->value_en = $request->value_en;
            $term->app = 'all';
            $term->save();
        } else {
            $term = AppSetting::create([
                'key' => 'term',
                'value_ar' => $request->value_ar,
                'value_en' => $request->value_en,
            ]);
            $term->app = 'all';
            $term->save();
        }
        return to_route('terms.index')->with('success', __("main.updated_successffully"));

    }

    public function commission()
    {
        $commission = AppSetting::whereIn('key', [
            'commission_resale', 'commission_booth', 'commission_mall', 'commission_rfoof',
            'desc_resale', 'desc_rfoof',
        ])->get();
        return view("settings.commission", compact('commission'));
    }

    public function commission_store(CommissionRequest $request)
    {
        $keys = [
            'commission_booth',
            'commission_mall',
            'commission_resale',
            'commission_rfoof',
            'desc_resale',
            'desc_rfoof',
        ];
        foreach ($keys as $key) {
            $row = AppSetting::where('key', $key)->first();

            $parts = explode('_', $key);
            $app = $parts[1] ?? '';

            if (str_starts_with($key, 'commission')) {
                if ($row) {
                    $row->value_ar = $request["$app-value"];
                    $row->value_en = $request["$app-value"];
                    $row->app = $app;
                    $row->save();
                }else {
                    $commission = AppSetting::create([
                        'key' => $key,
                        'value_ar' => $request["$app-value"],
                        'value_en' => $request["$app-value"],
                    ]);
                    $commission->app = $app;
                    $commission->save();
                }

            } elseif (str_starts_with($key, 'desc')) {
                if ($row) {
                    $row->value_ar = $request["$app-desc-ar"];
                    $row->value_en = $request["$app-desc-en"];
                    $row->app = $app;
                    $row->save();
                }else {
                    $row = AppSetting::create([
                        'key' => $key,
                        'value_ar' => $request["$app-desc-ar"],
                        'value_en' => $request["$app-desc-en"]
                    ]);
                    $row->app = $app;
                    $row->save();
                }
            }
            // $commission = AppSetting::where('key', $key)->first();
            // if ($commission) {
            //     // Update existing commission
            //     $commission->value_ar = $request[$key];
            //     $commission->value_en = $request[$key];
            //     $commission->app = $app; // Update the app if necessary
            //     $commission->save();
            // } else {
            //     // Create new commission entry
            //     $commission = AppSetting::create([
            //         'key' => $key,
            //         'value_ar' => $request["$app-value"],
            //         'value_en' => $request["$app-value"],
            //     ]);
            //     $commission->app = $app;
            //     $commission->save();
            // }
        }

        return to_route('commission.index')->with('success', __("main.updated_successffully"));
    }

    public function saller_link()
    {
        $saller_link = AppSetting::where('app', 'all')
        ->where('key', 'saller_link')->first();
        return view("settings.saller_link.index", compact('saller_link'));
    }

    public function saller_link_store(Request $request)
    {
        $saller_link = AppSetting::all()->where('key', 'saller_link')->first();
        if ($saller_link) {
            $saller_link->value_ar = $request->value;
            $saller_link->value_en = $request->value;
            $saller_link->app = 'all';
            $saller_link->save();
        } else {
            $saller_link = AppSetting::create([
                'key' => 'saller_link',
                'value_ar' => $request->value,
                'value_en' => $request->value,
            ]);
            $saller_link->app = 'all';
            $saller_link->save();
        }
        return to_route('saller_link.index')->with('success', __("main.updated_successffully"));

    }
    /*
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
    */
}
