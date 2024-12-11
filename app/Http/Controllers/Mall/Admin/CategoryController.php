<?php

namespace App\Http\Controllers\Mall\Admin;

use App\Models\Store;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Exports\Mall\CategoryExport;
use App\Http\Controllers\Controller;
use App\Imports\Mall\CategoryImport;
use Maatwebsite\Excel\Facades\Excel;
use App\Repositories\Mall\CategoryRepository;
use App\Http\Requests\Mall\Web\CategoryRequest;
use Maatwebsite\Excel\Validators\ValidationException;

class CategoryController extends Controller
{
    protected $categoryRepository;

    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;

        // autherization
        $this->middleware('can:mall.categories.index')->only('index');
        $this->middleware('can:mall.categories.create')->only(['create', 'store']);
        $this->middleware('can:mall.categories.update')->only(['edit', 'update']);
        $this->middleware('can:mall.categories.delete')->only('destroy');
        $this->middleware('can:mall.categories.export')->only('export');
        $this->middleware('can:mall.categories.import')->only('import');
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $categories = $this->categoryRepository->index($request);
        $stores = Store::mall()->active()->get();
        return view('mall.categories.index', compact('categories', 'stores'));
    }

    public function search(Request $request)
    {
        $categories = $this->categoryRepository->search($request);
        return view('mall.categories.table', compact('categories'))->render();
    }

    public function export(Request $request)
    {
        return Excel::download(new CategoryExport($request), 'categories.xlsx');
    }

    public function import(Request $request)
    {
        try {
            Excel::import(new CategoryImport, $request->file('file'));

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


    public function getCategoriesBySection(Request $request)
    {
        $items = Category::whereHas('store', function ($store) use ($request) {
            $store->where("section_id", $request->sectionId);
        })->get();

        return view('mall.layouts._options', compact('items'))->render();
    }

    public function getCategoriesBystore(Request $request)
    {
        $items = Category::where("store_id", $request->storeId)->get();
        return view('mall.layouts._options', compact('items'))->render();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $stores = Store::mall()->active()->get();
        $categories = Category::checkVendor($request->user())->mall()->active()->get();
        return view("mall.categories.create", compact('stores', 'categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CategoryRequest $request)
    {
        $this->categoryRepository->store($request); // store category
        return to_route('mall.categories.index')->with('success', __("main.created_successffully"));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return to_route('mall.categories.edit');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, Category $category)
    {
        $stores = Store::mall()->active()->get();
        $categories = Category::checkVendor($request->user())->mall()->active()->where('id', '!=', $category->id)->get();
        return view('mall.categories.edit', compact('category', 'stores', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CategoryRequest $request, Category $category)
    {
        $this->categoryRepository->update($request, $category);
        return to_route('mall.categories.index')->with('success', __("main.updated_successffully"));
    }

    public function toggleStatus(Request $request, Category $category)
    {
        $category->update(['is_active' => $request->is_active]);
        return response()->json([
            'success' => true,
            'message' => __("main.updated_successffully")
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        $this->categoryRepository->delete($category);
        return to_route('mall.categories.index')->with('success', __("main.delete_successffully"));
    }

    public function delete(Request $request)
    {
        $this->categoryRepository->deleteSelection($request);
        return to_route('mall.categories.index')->with('success', __("main.delete_successffully"));
    }
}
