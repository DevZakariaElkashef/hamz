<?php

namespace App\Http\Controllers\Booth\Admin;

use App\Models\Brand;
use App\Models\Store;
use App\Models\Option;
use App\Models\Product;
use App\Models\Section;
use App\Models\Category;
use App\Models\Attribute;
use Illuminate\Http\Request;
use App\Exports\Booth\ProductExport;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use App\Repositories\Booth\ProductRepository;
use App\Http\Requests\Booth\Web\ProductRequest;
use App\Imports\Booth\ProductImport;
use Maatwebsite\Excel\Validators\ValidationException;

class ProductController extends Controller
{
    protected $productRepository;

    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;

        // autherization
        $this->middleware('can:booth.products.index')->only('index');
        $this->middleware('can:booth.products.create')->only(['create', 'store']);
        $this->middleware('can:booth.products.update')->only(['edit', 'update']);
        $this->middleware('can:booth.products.delete')->only('destroy');
        $this->middleware('can:booth.products.export')->only('export');
        $this->middleware('can:booth.products.import')->only('import');
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $products = $this->productRepository->index($request);
        $sections = Section::booth()->active()->get();
        $stores = Store::booth()->active()->get();
        $categories = Category::booth()->active()->get();
        $brands = Brand::booth()->active()->get();

        return view('booth.products.index', compact('products', 'sections', 'stores', 'brands', 'categories'));
    }

    public function search(Request $request)
    {
        $products = $this->productRepository->search($request);
        return view('booth.products.table', compact('products'))->render();
    }

    public function export(Request $request)
    {
        return Excel::download(new ProductExport($request), 'products.xlsx');
    }

    public function fetchProductDetails(Product $product)
    {
        // Return the product price and image in JSON format
        return response()->json([
            'price' => $product->price,
            'image' => asset($product->image),
        ]);
    }

    public function import(Request $request)
    {
        try {
            Excel::import(new ProductImport, $request->file('file'));

            return back()->with('success', __("main.created_successfully"));
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
        $sections = Section::booth()->active()->get();
        $stores = Store::booth()->active()->get();
        $categories = Category::booth()->active()->get();
        $brands = Brand::booth()->active()->get();
        $attributes = Attribute::booth()->get();
        $options = Option::booth()->get();
        return view("booth.products.create", compact('sections', 'stores', 'categories', 'brands', 'attributes', 'options'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductRequest $request)
    {
        $this->productRepository->store($request); // store product
        return to_route('booth.products.index')->with('success', __("main.created_successffully"));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return to_route('booth.products.edit');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        $sections = Section::booth()->active()->get();
        $stores = Store::booth()->active()->get();
        $categories = Category::booth()->active()->get();
        $brands = Brand::booth()->active()->get();
        $attributes = Attribute::booth()->get();
        $options = Option::booth()->get();

        return view('booth.products.edit', compact('product', 'sections', 'stores', 'categories', 'brands', 'attributes', 'options'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProductRequest $request, Product $product)
    {
        $this->productRepository->update($request, $product);
        return to_route('booth.products.index')->with('success', __("main.updated_successffully"));
    }

    public function toggleStatus(Request $request, Product $product)
    {
        $product->update(['is_active' => $request->is_active]);
        return response()->json([
            'success' => true,
            'message' => __("main.updated_successffully")
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        $this->productRepository->delete($product);
        return to_route('booth.products.index')->with('success', __("main.delete_successffully"));
    }

    public function delete(Request $request)
    {
        $this->productRepository->deleteSelection($request);
        return to_route('booth.products.index')->with('success', __("main.delete_successffully"));
    }
}
