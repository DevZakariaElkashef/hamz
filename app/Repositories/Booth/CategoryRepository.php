<?php

namespace App\Repositories\Booth;

use App\Models\Category;
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
        $categorys = Category::booth()->filter($request)->active();
        if (auth()->user()->role->name == 'seller') {
            $store = Store::active()->booth()->where('user_id', $user->id)->first();
            $categorys = Category::checkVendor($store->id);
        }
        $categorys = $categorys->paginate($request->per_page ?? $this->limit);

        return $categorys;
    }


    public function search($request)
    {
        return Category::booth()->search($request->search)->paginate($request->per_page ?? $this->limit);
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
        $data['app'] = 'booth';
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
        Category::whereIn('id', $ids)->delete();
        return true;
    }
}
