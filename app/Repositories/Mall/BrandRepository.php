<?php

namespace App\Repositories\Mall;

use App\Models\Brand;
use App\Traits\ImageUploadTrait;

class BrandRepository
{
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

        $brands = $brands->mall()->with('store')->paginate($request->per_page ?? $this->limit);

        return $brands;
    }


    public function search($request)
    {
        return Brand::mall()->search($request->search)->paginate($request->per_page ?? $this->limit);
    }

    public function brand($request)
    {
        $data = $request->except('image');

        if ($request->hasFile('image')) {
            $data['image'] =  $this->uploadImage($request->file('image'), 'brands');
        }

        $data['appp'] = 'mall';

        $brand = Brand::create($data);

        return $brand;
    }


    public function update($request, $brand)
    {
        $data = $request->except('image');

        if ($request->hasFile('image')) {
            $data['image'] =  $this->uploadImage($request->file('image'), 'brands', $brand->image);
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
