<?php

namespace App\Repositories\Coupon;

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
        $sliders = Slider::filter($request)->coupons()->paginate($request->per_page ?? $this->limit);

        return $sliders;
    }

    public function search($request)
    {
        return Slider::coupons()->search($request->search)->paginate($request->per_page ?? $this->limit);
    }

    public function store($request)
    {
        $data = $request->except('image');
        if ($request->hasFile('image')) {
            $data['image'] = $this->uploadImage($request->file('image'), 'sliders');
        }
        $data['app'] = 'coupons';
        unset($data['_token']);
        $slider = Slider::create($data);

        if ($slider->is_fixed) {
            $this->updateOtherSliders($slider->id);
        }

        return $slider;
    }

    public function update($request, $slider)
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

        return $slider;
    }

    public function updateOtherSliders(int $currentSliderId): void
    {
        Slider::whereNot('id', $currentSliderId)->update(['is_fixed' => 0]);
    }

    public function delete($slider)
    {
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
