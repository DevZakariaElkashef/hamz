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
        $brands = Brand::filter($request)->mall()->with('store')->paginate($request->per_page ?? $this->limit);

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

        $data['app'] = 'mall';
        unset($data['_token']);
        $brand = Brand::create($data);

        return $brand;
    }


    public function update($request, $brand)
    {
        $data = $request->except('image');

        if ($request->hasFile('image')) {
            $data['image'] =  $this->uploadImage($request->file('image'), 'brands', $brand->image);
        }
        unset($data['_token'], $data['_method']);
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
