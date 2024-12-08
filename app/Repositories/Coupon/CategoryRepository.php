<?php

namespace App\Repositories\Coupon;

use App\Models\Category;
use App\Traits\ImageUploadTrait;

class CategoryRepository
{
    use ImageUploadTrait;
    protected $limit;

    public function __construct()
    {
        $this->limit = config('app.pg_limit');
    }

    public function index($request)
    {
        $categorys = Category::filter($request)->coupons()->with('store')->paginate($request->per_page ?? $this->limit);

        return $categorys;
    }


    public function search($request)
    {
        return Category::coupons()->search($request->search)->paginate($request->per_page ?? $this->limit);
    }

    public function store($request)
    {
        $data = $request->except('image');
        if ($request->hasFile('image')) {
            $data['image'] =  $this->uploadImage($request->file('image'), 'categorys');
        }
        if (!is_numeric($data['parent_id'])) {
            unset($data['parent_id']);
        }
        $data['app'] = 'coupons';
        unset($data['_token']);
        return Category::create($data);
    }


    public function update($request, $category)
    {
        $data = $request->except('image');
        if ($request->hasFile('image')) {
            $data['image'] =  $this->uploadImage($request->file('image'), 'categorys', $category->image);
        }
        if (!is_numeric($data['parent_id'])) {
            $data['parent_id'] = null;
        }
        unset($data['_token'], $data['_method']);
        $category->update($data);
        return $category;
    }


    public function delete($category)
    {
        if ($category->image) {
            $this->deleteImage($category->image);
        }

        $category->delete();
        return true;
    }

    public function deleteSelection($request)
    {
        $ids = explode(',', $request->ids);
        Category::whereIn('id', $ids)->delete();
        return true;
    }
}
