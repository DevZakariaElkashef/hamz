<?php

namespace App\Http\ViewComposer;

use App\Models\Settings;
use Illuminate\View\View;

class SettingComposer
{
    public function __construct()
    {
    }

    /**
     * Bind data to the view.
     *
     * @param  \Illuminate\View\View  $view
     * @return void
     */
    public function compose(View $view)
    {
        // $view->with("setting", Setting::first());
    }
}
