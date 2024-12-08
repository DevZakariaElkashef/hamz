<?php

namespace App\Http\Controllers\usedMarket\Admin;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Traits\ImageUploadTrait;
use App\Http\Controllers\Controller;
use App\Http\Requests\usedMarket\category\AddRequest;
use App\Http\Requests\usedMarket\category\UpdateRequest;

class CategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:usedmarket.categories.index')->only(['index']);
        $this->middleware('can:usedmarket.categories.create')->only(['create', 'store']);
        $this->middleware('can:usedmarket.categories.update')->only(['edit', 'update']);
        $this->middleware('can:usedmarket.categories.delete')->only(['destroy']);
    }

    use ImageUploadTrait;
    public function index()
    {
        $categories = Category::usedMarket()->latest()->paginate();
        return view('usedMarket.categories.index', compact('categories'));
    }
    public function addCategory()
    {
        return view('usedMarket.categories.create');
    }

    public function store(AddRequest $request)
    {
        $imageName = $imageName = $this->uploadImage($request->file('image'), 'category');
        Category::create([
            'name_ar' => $request->name_ar,
            'name_en' => $request->name_en,
            'image' => $imageName,
            'app' => 'resale',
        ]);
        return redirect()->route('usedMarket.categories')->with('success', __('messages.add_category'));
    }

    public function edit($id)
    {
        $category = Category::findOrFail($id);
        return view('usedMarket.categories.edit', compact('category'));
    }

    public function update(UpdateRequest $request)
    {
        $category = Category::findOrFail($request->category_id);
        $imageName = $category->image;
        if ($request->image) {
            $imageName = $this->uploadImage($request->file('image'), 'category', $category->image);
        }
        $category->update([
            'name_ar' => $request->name_ar,
            'name_en' => $request->name_en,
            'image' => $imageName,
        ]);
        return redirect()->route('usedMarket.categories')->with('success', __('messages.edit_category'));
    }

    public function delete (Request $request)
    {
        $category = Category::findOrFail($request->new_id);
        if ($category->bank_photo) {
            unlink(public_path($category->image));
        }
        $category->delete();
        return redirect()->route('usedMarket.categories')->with('success', __('messages.delete_category'));
    }
}
