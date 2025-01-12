<?php

namespace App\Http\Controllers\rfoof\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\rfoof\Slider\SliderRequest;
use App\Models\Slider;
use App\Traits\ImageUploadTrait;
use Illuminate\Http\Request;

class SliderController extends Controller
{
    use ImageUploadTrait;
    protected $limit;
    public function __construct()
    {
        $this->limit = config('app.pg_limit');

        // autherization
        $this->middleware('can:rfoof.sliders.index')->only('index');
        $this->middleware('can:rfoof.sliders.create')->only(['create', 'store']);
        $this->middleware('can:rfoof.sliders.update')->only(['edit', 'update']);
        $this->middleware('can:rfoof.sliders.delete')->only('destroy');
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $sliders = Slider::filter($request)->rfoof()->paginate($request->per_page ?? $this->limit);
        return view('rfoof.sliders.index', compact('sliders'));
    }

    public function search(Request $request)
    {
        $sliders = Slider::rfoof()->search($request->search)->paginate($request->per_page ?? $this->limit);
        return view('rfoof.sliders.table', compact('sliders'))->render();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view("rfoof.sliders.create");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SliderRequest $request)
    {
        $data = $request->except('image');
        if ($request->hasFile('image')) {
            $data['image'] = $this->uploadImage($request->file('image'), 'sliders');
        }
        $data['app'] = 'rfoof';
        unset($data['_token']);
        $slider = Slider::create($data);

        if ($slider->is_fixed) {
            $this->updateOtherSliders($slider->id);
        }
        return to_route('rfoof.sliders.index')->with('success', __("main.created_successffully"));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return to_route('rfoof.sliders.edit');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Slider $slider)
    {
        return view('rfoof.sliders.edit', compact('slider'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SliderRequest $request, Slider $slider)
    {
        $data = $request->except('image');
        if ($request->hasFile('image')) {
            $data['image'] = $this->uploadImage($request->file('image'), 'sliders', $slider->image);
        }
        unset($data['_token'], $data['_method']);
        $slider->update($data);

        if ($slider->is_fixed) {
            $this->updateOtherSliders($slider->id);
        }
        return to_route('rfoof.sliders.index')->with('success', __("main.updated_successffully"));
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
            $this->updateOtherSliders($slider->id);
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
        if ($slider->image) {
            $this->deleteImage($slider->image);
        }
        $slider->delete();
        return to_route('rfoof.sliders.index')->with('success', __("main.delete_successffully"));
    }

    public function delete(Request $request)
    {
        $ids = explode(',', $request->ids);
        Slider::whereIn('id', $ids)->delete();
        return to_route('rfoof.sliders.index')->with('success', __("main.delete_successffully"));
    }



    public function updateOtherSliders(int $currentSliderId): void
    {
        Slider::whereNot('id', $currentSliderId)->update(['is_fixed' => 0]);
    }
}
