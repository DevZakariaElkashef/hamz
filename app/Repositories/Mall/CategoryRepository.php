<?php

namespace App\Repositories\Mall;

use App\Models\Category;
use App\Models\Product;
use App\Models\Store;
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
        $user = auth()->user();
        $categorys = Category::mall()->filter($request)->active();
        if (auth()->user()->role->name == 'seller') {
            $store = Store::active()->mall()->where('user_id', $user->id)->first();
            $storeId = '';
            if ($store) {
                $storeId = $store->id;
            }
            $categorys = Category::checkVendor($storeId);
        }
        $categorys = $categorys->paginate($request->per_page ?? $this->limit);

        return $categorys;
    }


    public function search($request)
    {
        return Category::mall()->search($request->search)->paginate($request->per_page ?? $this->limit);
    }

    public function store($request)
    {
        $data = $request->all();
        // $data = $request->except('image');
        // if ($request->hasFile('image')) {
        //     $data['image'] = $this->uploadImage($request->file('image'), 'categorys');
        // }

        if ($request->user()->role_id == 3) {
            $data['store_id'] = $request->user()->store->id;
        }

        // if (!is_numeric($data['parent_id'])) {
        //     unset($data['parent_id']);
        // }
        unset($data['_token']);
        $data['app'] = 'mall';
        return Category::create($data);
    }


    public function update($request, $category)
    {
        $data = $request->all();
        // $data = $request->except('image');
        // if ($request->hasFile('image')) {
        //     $data['image'] = $this->uploadImage($request->file('image'), 'categorys', $category->image);
        // }
        // if (!is_numeric($data['parent_id'])) {
        //     $data['parent_id'] = null;
        // }
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
        $products = Product::active()->whereIn('category_id', $ids)->count();
        if($products > 0){
            return false;
        }
        Category::whereIn('id', $ids)->delete();
        return true;
    }
}
