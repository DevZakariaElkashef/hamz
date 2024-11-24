<?php

namespace App\Http\Controllers\Earn\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Earn\Web\SliderRequest;
use App\Models\Slider;
use App\Repositories\Earn\SliderRepository;
use Illuminate\Http\Request;

class SliderController extends Controller
{
    protected $sliderRepository;

    public function __construct(SliderRepository $sliderRepository)
    {
        $this->sliderRepository = $sliderRepository;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $sliders = $this->sliderRepository->index($request);
        return view('earn.sliders.index', compact('sliders'));
    }

    public function search(Request $request)
    {
        $sliders = $this->sliderRepository->search($request);
        return view('earn.sliders.table', compact('sliders'))->render();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view("earn.sliders.create");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SliderRequest $request)
    {
        $this->sliderRepository->store($request); // store slider
        return to_route('earn.sliders.index')->with('success', __("main.created_successffully"));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return to_route('earn.sliders.edit');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Slider $slider)
    {
        return view('earn.sliders.edit', compact('slider'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SliderRequest $request, Slider $slider)
    {
        $this->sliderRepository->update($request, $slider);
        return to_route('earn.sliders.index')->with('success', __("main.updated_successffully"));
    }

    public function toggleStatus(Request $request, Slider $slider)
    {
        $slider->update(['is_active' => $request->is_active]);
        return response()->json([
            'success' => true,
            'message' => __("main.updated_successffully")
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Slider $slider)
    {
        $this->sliderRepository->delete($slider);
        return to_route('earn.sliders.index')->with('success', __("main.delete_successffully"));
    }

    public function delete(Request $request)
    {
        $this->sliderRepository->deleteSelection($request);
        return to_route('earn.sliders.index')->with('success', __("main.delete_successffully"));
    }
}