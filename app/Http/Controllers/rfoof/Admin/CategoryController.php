<?php

namespace App\Http\Controllers\rfoof\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\rfoof\Api\category\AddRequest;
use App\Http\Requests\rfoof\Api\category\UpdateRequest;
use App\Traits\ImageUploadTrait;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    use ImageUploadTrait;
    public function index()
    {
        $categories = Category::rfoof()->latest()->paginate();
        return view('rfoof.categories.index', compact('categories'));
    }
    public function addCategory()
    {
        return view('rfoof.categories.create');
    }

    public function store(AddRequest $request)
    {
        $imageName = $imageName = $this->uploadImage($request->file('image'), 'category');
        Category::create([
            'name_ar' => $request->name_ar,
            'name_en' => $request->name_en,
            'image' => $imageName,
            'app' => 'rfoof',
        ]);
        return redirect()->route('rfoof.categories')->with('success', __('messages.add_category'));
    }

    public function edit($id)
    {
        $category = Category::findOrFail($id);
        return view('rfoof.categories.edit', compact('category'));
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
        return redirect()->route('rfoof.categories')->with('success', __('messages.edit_category'));
    }

    public function delete (Request $request)
    {
        $category = Category::findOrFail($request->new_id);
        if ($category->bank_photo) {
            unlink(public_path($category->image));
        }
        $category->delete();
        return redirect()->route('rfoof.categories')->with('success', __('messages.delete_category'));
    }
}