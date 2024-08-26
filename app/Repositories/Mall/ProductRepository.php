<?php

namespace App\Repositories\Mall;

use App\Models\Product;
use App\Traits\ImageUploadTrait;

class ProductRepository
{
    use ImageUploadTrait;
    protected $limit;

    public function __construct()
    {
        $this->limit = config('app.pg_limit');
    }

    public function index($request)
    {
        $products = Product::query();

        if ($request->filled('start_at')) {
            $products->whereDate('created_at', '>=', $request->start_at);
        }

        if ($request->filled('end_at')) {
            $products->whereDate('created_at', '<=', $request->end_at);
        }

        if ($request->filled('is_active')) {
            $products->where('is_active', $request->is_active);
        }

        $products = $products->mall()->paginate($this->limit);

        return $products;
    }


    public function search($request)
    {
        return Product::mall()->search($request->search)->paginate($this->limit);
    }

    public function store($request)
    {
        $data = $request->except('image');
        if ($request->hasFile('image')) {
            $data['image'] =  $this->uploadImage($request->file('image'), 'products');
        }
        return Product::create($data);
    }


    public function update($request, $product)
    {
        $data = $request->except('image');
        if ($request->hasFile('image')) {
            $data['image'] =  $this->uploadImage($request->file('image'), 'products', $product->image);
        }
        $product->update($data);
        return $product;
    }


    public function delete($product)
    {
        $product->delete();
        return true;
    }

    public function deleteSelection($request)
    {
        $ids = explode(',', $request->ids);
        Product::whereIn('id', $ids)->delete();
        return true;
    }
}
