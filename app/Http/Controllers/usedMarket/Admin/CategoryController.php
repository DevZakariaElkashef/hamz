<?php

namespace App\Http\Controllers\usedMarket\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\usedMarket\Api\category\AddRequest;
use App\Http\Requests\usedMarket\Api\category\UpdateRequest;
use App\Traits\ImageUploadTrait;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    use ImageUploadTrait;
    public function index()
    {
        $categories = Category::resale()->latest()->paginate();
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
