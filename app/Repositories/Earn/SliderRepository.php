<?php

namespace App\Repositories\Earn;

use App\Models\Slider;
use App\Traits\ImageUploadTrait;

class SliderRepository
{
    use ImageUploadTrait;
    protected $limit;

    public function __construct()
    {
        $this->limit = config('app.pg_limit');
    }

    public function index($request)
    {
        $sliders = Slider::filter($request)->earn()->paginate($request->per_page ?? $this->limit);

        return $sliders;
    }


    public function search($request)
    {
        return Slider::earn()->search($request->search)->paginate($request->per_page ?? $this->limit);
    }

    public function store($request)
    {
        $data = $request->except('image');
        if ($request->hasFile('image')) {
            $data['image'] =  $this->uploadImage($request->file('image'), 'sliders');
        }
        $data['app'] = 'earn';
        unset($data['_token']);
        return Slider::create($data);
    }


    public function update($request, $slider)
    {
        $data = $request->except('image');
        if ($request->hasFile('image')) {
            $data['image'] =  $this->uploadImage($request->file('image'), 'sliders', $slider->image);
        }
        unset($data['_token'], $data['_method']);
        $slider->update($data);
        return $slider;
    }

    public function updateOtherSliders(int $currentSliderId): void
    {
        Slider::whereNot('id', $currentSliderId)->update(['is_fixed' => 0]);
    }


    public function delete($slider)
    {
        if ($slider->image) {
            $this->deleteImage($slider->image);
        }

        $slider->delete();
        return true;
    }

    public function deleteSelection($request)
    {
        $ids = explode(',', $request->ids);
        Slider::whereIn('id', $ids)->delete();
        return true;
    }
}
