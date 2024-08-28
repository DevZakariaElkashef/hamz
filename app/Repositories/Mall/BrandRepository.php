<?php

namespace App\Repositories\Mall;

use App\Models\Brand;
use App\Traits\ImageUploadTrait;

class BrandRepository {
    use ImageUploadTrait;
    protected $limit;

    public function __construct()
    {
        $this->limit = config('app.pg_limit');
    }

    public function index($request)
    {
        $brands = Brand::query();

        if ($request->filled('start_at')) {
            $brands->whereDate('created_at', '>=', $request->start_at);
        }

        if ($request->filled('end_at')) {
            $brands->whereDate('created_at', '<=', $request->end_at);
        }

        if ($request->filled('section_id')) {
            $brands->where('section_id', $request->section_id);
        }

        if ($request->filled('is_active')) {
            $brands->where('is_active', $request->is_active);
        }

        $brands = $brands->mall()->paginate($this->limit);

        return $brands;
    }


    public function search($request)
    {
        return Brand::mall()->search($request->search)->paginate($this->limit);
    }

    public function brand($request)
    {
        $data = $request->except('image');

        if ($request->hasFile('image')) {
            $data['image'] =  $this->uploadImage($request->file('image'), 'brands');
        }

        $data['appp'] = 'mall';

        $brand = Brand::create($data);

        if ($request->has('images')) {
            foreach ($request->images as $image) {
                $brand->images()->create([
                    'path' => $this->uploadImage($image, 'brands')
                ]);
            }
        }

        return $brand;
    }


    public function update($request, $brand)
    {
        $data = $request->except('image');

        if ($request->hasFile('image')) {
            $data['image'] =  $this->uploadImage($request->file('image'), 'brands', $brand->image);
        }


        if ($request->has('images')) {
            foreach ($request->images as $image) {
                $brand->images()->create([
                    'path' => $this->uploadImage($image, 'brands')
                ]);
            }
        }

        if (!$request->has('delivery_type')) {
            $brand->update(['delivery_type' => 0]);
        }

        if (!$request->has('pick_up')) {
            $brand->update(['pick_up' => 0]);
        }

        $brand->update($data);

        return $brand;
    }


    public function delete($brand)
    {
        $brand->delete();
        return true;
    }

    public function deleteSelection($request)
    {
        $ids = explode(',', $request->ids);
        Brand::whereIn('id', $ids)->delete();
        return true;
    }
}
