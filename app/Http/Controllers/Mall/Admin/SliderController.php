<?php

namespace App\Http\Controllers\Mall\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Mall\Web\SliderRequest;
use App\Models\Slider;
use App\Repositories\Mall\SliderRepository;
use Illuminate\Http\Request;

class SliderController extends Controller
{
    protected $sliderRepository;

    public function __construct(SliderRepository $sliderRepository)
    {
        $this->sliderRepository = $sliderRepository;

        // autherization
        $this->middleware('can:mall.sliders.index')->only('index');
        $this->middleware('can:mall.sliders.create')->only(['create', 'store']);
        $this->middleware('can:mall.sliders.update')->only(['edit', 'update']);
        $this->middleware('can:mall.sliders.delete')->only('destroy');
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $sliders = $this->sliderRepository->index($request);
        return view('mall.sliders.index', compact('sliders'));
    }

    public function search(Request $request)
    {
        $sliders = $this->sliderRepository->search($request);
        return view('mall.sliders.table', compact('sliders'))->render();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view("mall.sliders.create");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SliderRequest $request)
    {
        $this->sliderRepository->store($request); // store slider
        return to_route('mall.sliders.index')->with('success', __("main.created_successffully"));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return to_route('mall.sliders.edit');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Slider $slider)
    {
        return view('mall.sliders.edit', compact('slider'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SliderRequest $request, Slider $slider)
    {
        $this->sliderRepository->update($request, $slider);
        return to_route('mall.sliders.index')->with('success', __("main.updated_successffully"));
    }

    public function toggleStatus(Request $request, Slider $slider)
    {
        $slider->update(['is_active' => $request->is_active]);
        return response()->json([
            'success' => true,
            'message' => __("main.updated_successffully"),
        ]);
    }

    public function toggleFixedStatus(Request $request, Slider $slider)
    {
        $slider->update(['is_fixed' => $request->is_active]);

        if ($request->is_active) {
            $this->sliderRepository->updateOtherSliders($slider->id);
        }

        return response()->json([
            'success' => true,
            'message' => __("main.updated_successffully"),
            'refresh' => true,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Slider $slider)
    {
        $this->sliderRepository->delete($slider);
        return to_route('mall.sliders.index')->with('success', __("main.delete_successffully"));
    }

    public function delete(Request $request)
    {
        $this->sliderRepository->deleteSelection($request);
        return to_route('mall.sliders.index')->with('success', __("main.delete_successffully"));
    }
}
