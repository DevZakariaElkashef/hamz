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

        $products = $products->mall()->with('store', 'category', 'brand', 'store.section')->paginate($this->limit);

        return $products;
    }


    public function search($request)
    {
        return Product::mall()->search($request->search)->paginate($this->limit);
    }

    public function store($request)
    {
        // Extract all data except image
        $data = $request->except('image');

        // Handle main image upload
        if ($request->hasFile('image')) {
            $data['image'] = $this->uploadImage($request->file('image'), 'products');
        }

        // Create the product
        $product = Product::create($data);

        // Handle multiple images upload
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $product->images()->create([
                    'path' => $this->uploadImage($image, 'products')
                ]);
            }
        }

        if ($request->filled('attributes')) {
            $attributes = $request->input('attributes');
            $options = $request->options;
            $required = $request->is_required;
            $costs = $request->costs;

            for ($i = 0; $i < count($attributes); $i++) {

                $attributeId = (int) $attributes[$i]; // Cast to integer
                $optionId = (int) $options[$i]; // Cast to integer
                $isRequired = in_array($attributes[$i], $required) ? 1 : 0;
                $additionalPrice = (float) $costs[$i]; // Cast to float

                // Attach the attribute to the product with its option and additional data
                $product->attributes()->attach($attributeId, [
                    'option_id' => $optionId,
                    'is_required' => $isRequired,
                    'additional_price' => $additionalPrice
                ]);
            }
        }
    }


    public function update($request, Product $product)
    {
        // Extract all data except image and images
        $data = $request->except(['image', 'images']);

        // Handle main image update
        if ($request->hasFile('image')) {
            // Upload and update the main image
            $data['image'] = $this->uploadImage($request->file('image'), 'products', $product->image);
        }

        // Update the product details
        $product->update($data);

        // Handle additional images
        if ($request->hasFile('images')) {
            // Upload and attach new images without deleting existing ones
            foreach ($request->file('images') as $image) {
                $product->images()->create([
                    'path' => $this->uploadImage($image, 'products')
                ]);
            }
        }

        // Handle attributes update
        if ($request->filled('attributes')) {
            $attributes = $request->input('attributes');
            $options = $request->options;
            $required = $request->is_required;
            $costs = $request->costs;

            // Detach existing attributes first
            $product->attributes()->detach();

            // Attach updated attributes
            for ($i = 0; $i < count($attributes); $i++) {
                $attributeId = (int) $attributes[$i]; // Cast to integer
                $optionId = (int) $options[$i]; // Cast to integer
                $isRequired = in_array($attributes[$i], $required) ? 1 : 0;
                $additionalPrice = (float) $costs[$i]; // Cast to float

                // Attach the attribute to the product with its option and additional data
                $product->attributes()->attach($attributeId, [
                    'option_id' => $optionId,
                    'is_required' => $isRequired,
                    'additional_price' => $additionalPrice
                ]);
            }
        }

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
