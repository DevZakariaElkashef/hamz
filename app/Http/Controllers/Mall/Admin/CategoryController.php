<?php

namespace App\Http\Controllers\Mall\Admin;

use App\Models\Store;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\Mall\CategoryRepository;
use App\Http\Requests\Mall\Web\CategoryRequest;

class CategoryController extends Controller
{
    protected $categoryRepository;

    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
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


    public function getCategoriesBySection(Request $request)
    {
        $items = Category::whereHas('store', function ($store) use($request) {
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
    public function create()
    {
        $stores = Store::mall()->active()->get();
        $categories = Category::mall()->active()->get();
        return view("mall.categories.create", compact('stores', 'categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CategoryRequest $request)
    {
        $this->categoryRepository->store($request); // store category
        return to_route('mall.categories.index')->with('success', __("mall.created_successffully"));
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
    public function edit(Category $category)
    {
        $stores = Store::mall()->active()->get();
        $categories = Category::mall()->active()->where('id', '!=', $category->id)->get();
        return view('mall.categories.edit', compact('category', 'stores', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CategoryRequest $request, Category $category)
    {
        $this->categoryRepository->update($request, $category);
        return to_route('mall.categories.index')->with('success', __("mall.updated_successffully"));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        $this->categoryRepository->delete($category);
        return to_route('mall.categories.index')->with('success', __("mall.delete_successffully"));
    }

    public function delete(Request $request)
    {
        $this->categoryRepository->deleteSelection($request);
        return to_route('mall.categories.index')->with('success', __("mall.delete_successffully"));
    }
}
