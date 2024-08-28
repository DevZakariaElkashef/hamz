<?php

namespace App\Http\Controllers\Mall\Admin;

use App\Models\Attribute;
use App\Models\Store;
use App\Models\Product;
use App\Models\Section;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\Mall\ProductRepository;
use App\Http\Requests\Mall\Web\ProductRequest;
use App\Models\Brand;
use App\Models\Category;

class ProductController extends Controller
{
    protected $productRepository;

    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $products = $this->productRepository->index($request);
        return view('mall.products.index', compact('products'));
    }

    public function search(Request $request)
    {
        $products = $this->productRepository->search($request);
        return view('mall.products.table', compact('products'))->render();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $sections = Section::mall()->active()->get();
        $stores = Store::mall()->active()->get();
        $categories = Category::mall()->active()->get();
        $brands = Brand::mall()->active()->get();
        $attributes = Attribute::mall()->get();
        return view("mall.products.create", compact('sections', 'stores', 'categories', 'brands', 'attributes'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductRequest $request)
    {
        $this->productRepository->store($request); // store product
        return to_route('mall.products.index')->with('success', __("mall.created_successffully"));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return to_route('mall.products.edit');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        return view('mall.products.edit', compact('product'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProductRequest $request, Product $product)
    {
        $this->productRepository->update($request, $product);
        return to_route('mall.products.index')->with('success', __("mall.updated_successffully"));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        $this->productRepository->delete($product);
        return to_route('mall.products.index')->with('success', __("mall.delete_successffully"));
    }

    public function delete(Request $request)
    {
        $this->productRepository->deleteSelection($request);
        return to_route('mall.products.index')->with('success', __("mall.delete_successffully"));
    }
}
