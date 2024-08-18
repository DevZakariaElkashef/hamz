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
        return to_route('mall.sliders.index')->with('success', __("mall.created_successffully"));
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
        return to_route('mall.sliders.index')->with('success', __("mall.updated_successffully"));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Slider $slider)
    {
        $this->sliderRepository->delete($slider);
        return to_route('mall.sliders.index')->with('success', __("mall.delete_successffully"));
    }

    public function delete(Request $request)
    {
        $this->sliderRepository->deleteSelection($request);
        return to_route('mall.sliders.index')->with('success', __("mall.delete_successffully"));
    }
}
