<?php

namespace App\Http\Controllers\Mall\Admin;

use App\Models\Brand;
use App\Models\Store;
use App\Models\Option;
use App\Models\Product;
use App\Models\Section;
use App\Models\Category;
use App\Models\Attribute;
use Illuminate\Http\Request;
use App\Exports\Mall\ProductExport;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use App\Repositories\Mall\ProductRepository;
use App\Http\Requests\Mall\Web\ProductRequest;
use App\Imports\Mall\ProductImport;
use Maatwebsite\Excel\Validators\ValidationException;

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
        $sections = Section::mall()->active()->get();
        $stores = Store::mall()->active()->get();
        $categories = Category::mall()->active()->get();
        $brands = Brand::mall()->active()->get();

        return view('mall.products.index', compact('products', 'sections', 'stores', 'brands', 'categories'));
    }

    public function search(Request $request)
    {
        $products = $this->productRepository->search($request);
        return view('mall.products.table', compact('products'))->render();
    }

    public function export(Request $request)
    {
        return Excel::download(new ProductExport($request), 'products.xlsx');
    }

    public function import(Request $request)
    {
        try {
            Excel::import(new ProductImport, $request->file('file'));

            return back()->with('success', __("mall.created_successfully"));
        } catch (ValidationException $e) {
            // Get the first failure from the exception
            $failure = $e->failures()[0];

            // Format the error message for the first failed row
            $errorMessage = "Row {$failure->row()}: " . implode(', ', $failure->errors());

            // Flash the error message to the session
            return back()->with('error', $errorMessage);
        } catch (\Exception $e) {
            // Handle any other exceptions that might occur
            return back()->with('error', __("An unexpected error occurred: " . $e->getMessage()));
        }
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
        $options = Option::mall()->get();
        return view("mall.products.create", compact('sections', 'stores', 'categories', 'brands', 'attributes', 'options'));
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
        $sections = Section::mall()->active()->get();
        $stores = Store::mall()->active()->get();
        $categories = Category::mall()->active()->get();
        $brands = Brand::mall()->active()->get();
        $attributes = Attribute::mall()->get();
        $options = Option::mall()->get();

        return view('mall.products.edit', compact('product', 'sections', 'stores', 'categories', 'brands', 'attributes', 'options'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProductRequest $request, Product $product)
    {
        $this->productRepository->update($request, $product);
        return to_route('mall.products.index')->with('success', __("mall.updated_successffully"));
    }

    public function toggleStatus(Request $request, Product $product)
    {
        $product->update(['is_active' => $request->is_active]);
        return response()->json([
            'success' => true,
            'message' => __("mall.updated_successffully")
        ]);
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
