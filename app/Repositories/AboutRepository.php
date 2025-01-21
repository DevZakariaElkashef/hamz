<?php

namespace App\Repositories;

use App\Models\About;
use App\Models\AppSetting;
use App\Traits\ImageUploadTrait;

class AboutRepository
{
    use ImageUploadTrait;

    public function index()
    {
        $about = AppSetting::where('app', 'all')
        ->where('key', 'about_us')->first();

        return $about;
    }

    public function store($request)
    {
        $about = AppSetting::all()->where('key', 'about_us')->first();
        if ($about) {
            $about->value_ar = $request->value_ar;
            $about->value_en = $request->value_en;
            $about->app = 'all';
            $about->save();
        } else {
            $about = AppSetting::create([
                'key' => 'about_us',
                'value_ar' => $request->value_ar,
                'value_en' => $request->value_en,
            ]);
            $about->app = 'all';
            $about->save();
        }
        return $about;
    }
}
