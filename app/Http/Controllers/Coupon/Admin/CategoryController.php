<?php

namespace App\Http\Controllers\Coupon\Admin;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\Coupon\CategoryExport;
use App\Imports\Coupon\CategoryImport;
use App\Repositories\Coupon\CategoryRepository;
use App\Http\Requests\Coupon\Web\CategoryRequest;
use Maatwebsite\Excel\Validators\ValidationException;

class CategoryController extends Controller
{
    protected $categoryRepository;

    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->middleware('can:coupon.categories.index')->only(['index']);
        $this->middleware('can:coupon.categories.create')->only(['create', 'store']);
        $this->middleware('can:coupon.categories.update')->only(['edit', 'update']);
        $this->middleware('can:coupon.categories.delete')->only(['destroy']);

        $this->categoryRepository = $categoryRepository;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $categories = $this->categoryRepository->index($request);
        return view('coupon.categories.index', compact('categories'));
    }

    public function search(Request $request)
    {
        $categories = $this->categoryRepository->search($request);
        return view('coupon.categories.table', compact('categories'))->render();
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

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::coupon()->active()->get();
        return view("coupon.categories.create", compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CategoryRequest $request)
    {
        $this->categoryRepository->store($request); // store category
        return to_route('coupon.categories.index')->with('success', __("main.created_successffully"));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return to_route('coupon.categories.edit');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        $categories = Category::coupon()->active()->where('id', '!=', $category->id)->get();
        return view('coupon.categories.edit', compact('category', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CategoryRequest $request, Category $category)
    {
        $this->categoryRepository->update($request, $category);
        return to_route('coupon.categories.index')->with('success', __("main.updated_successffully"));
    }

    public function toggleStatus(Request $request, Category $category)
    {
        $category->update(['is_active' => $request->is_active]);
        return response()->json([
            'success' => true,
            'message' => __("main.updated_successffully"),
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        $this->categoryRepository->delete($category);
        return to_route('coupon.categories.index')->with('success', __("main.delete_successffully"));
    }

    public function delete(Request $request)
    {
        $this->categoryRepository->deleteSelection($request);
        return to_route('coupon.categories.index')->with('success', __("main.delete_successffully"));
    }
}
