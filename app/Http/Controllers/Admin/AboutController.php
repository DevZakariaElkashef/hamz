<?php

namespace App\Http\Controllers\Admin;

use App\Models\About;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AppSettingRequest;
use App\Models\AppSetting;
use App\Repositories\AboutRepository;

class AboutController extends Controller
{
    public $aboutRepository;

    public function __construct(AboutRepository $aboutRepository)
    {
        $this->middleware('can:hamz.applications.index')->only(['index', 'store']);
        $this->aboutRepository = $aboutRepository;
    }

    public function index()
    {
        $about = $this->aboutRepository->index();
        return view("settings.about", compact('about'));
    }

    public function store(AppSettingRequest $request)
    {
        $this->aboutRepository->store($request);

        return to_route('abouts.index')->with('success', __("main.updated_successffully"));
    }
}
