<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Application;
use App\Repositories\SettingRepository;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public $settingRepository;

    public function __construct(SettingRepository $settingRepository)
    {
        $this->settingRepository = $settingRepository;
    }

    public function index()
    {
        $application = $this->settingRepository->index();
        return view("settings.index", compact('application'));
    }

    public function update(Request $request, Application $application)
    {
        $this->settingRepository->update($request, $application);

        return to_route('applications.index')->with('success', __("main.updated_successffully"));
    }
}
