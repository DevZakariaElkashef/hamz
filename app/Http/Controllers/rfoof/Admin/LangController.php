<?php

namespace App\Http\Controllers\rfoof\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LangController extends Controller
{
    public function set($lang)
    {
        $languages = ['en', 'ar'];
        if (!in_array($lang, $languages)) {
            $lang = "ar";
        }
        app()->setLocale($lang);
        session()->put('lang', $lang);
        return back();
    }
}
