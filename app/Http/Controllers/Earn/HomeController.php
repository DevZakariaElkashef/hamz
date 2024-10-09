<?php

namespace App\Http\Controllers\Earn;

use App\Http\Controllers\Controller;
use App\Http\Resources\Earn\CategoryResource;
use App\Http\Resources\Earn\SliderResource;
use App\Http\Resources\Earn\VideoResource;
use App\Models\Category;
use App\Models\Slider;
use App\Models\Video;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    use ApiResponse;

    public function index(Request $request)
    {
        $fixedSldier = Slider::earn()->active()->fixed()->first();
        $sliders = Slider::earn()->active()->scrollable()->get();

        $categories = Category::earn()->active()->has('videos')->get();
        $videos = Video::query()
            ->earn()
            ->active()
            ->where(function ($q) use ($request) {
                $q->whereDoesntHave('viewed', function ($query) use ($request) {
                    $query->where('user_id', $request->user()->id); // Assuming the user is authenticated
                })->orWhereHas('viewed', function ($view) use ($request) {
                    $view->where('user_id', $request->user()->id)->where('status', 0);
                });
            })
            ->when($request->category_id, function ($query) use ($request) {
                $query->where('category_id', $request->category_id);
            })
            ->get();

        $data = [
            'fixed_slider' => new SliderResource($fixedSldier),
            'sliders' => SliderResource::collection($sliders),
            'categories' => CategoryResource::collection($categories),
            'videos' => VideoResource::collection($videos),
        ];

        return $this->sendResponse(200, $data);
    }
}
