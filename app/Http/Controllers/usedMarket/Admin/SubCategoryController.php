<?php

namespace App\Http\Controllers\usedMarket\Admin;

use App\Models\Category;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use App\Traits\ImageUploadTrait;
use App\Http\Controllers\Controller;
use App\Http\Requests\usedMarket\SubCategory\AddRequest;
use App\Http\Requests\usedMarket\SubCategory\UpdateRequest;

class SubCategoryController extends Controller
{
    use ImageUploadTrait;
    public function index()
    {
        $categories = SubCategory::usedMarket()->paginate();
        return view('usedMarket.SubCategory.index', compact('categories'));
    }
    public function addsubCategories()
    {
        $categories = Category::usedMarket()->get();
        return view('usedMarket.SubCategory.create', compact('categories'));
    }

    public function store(AddRequest $request)
    {
        $imageName = $this->uploadImage($request->file('image'), 'subCategory');
        SubCategory::create([
            'name_ar' => $request->name_ar,
            'name_en' => $request->name_en,
            'image' => $imageName,
            'category_id' => $request->category_id,
            'app' => 'usedMarket'
        ]);
        return redirect()->route('usedMarket.subCategories')->with('success', __('messages.add_category'));
    }


    public function edit($id)
    {
        $categories = Category::get();
        $category = SubCategory::findOrFail($id);
        return view('usedMarket.SubCategory.edit', compact('category', 'categories'));
    }

    public function update(UpdateRequest $request)
    {
        $category = SubCategory::findOrFail($request->sub_category_id);
        $imageName = $category->image;
        if ($request->image) {
            $imageName = $this->uploadImage($request->file('image'), 'subCategory', $category->image);
        }
        $category->update([
            'name_ar' => $request->name_ar,
            'name_en' => $request->name_en,
            'image' => $imageName,
            'category_id' => $request->category_id
        ]);
        return redirect()->route('usedMarket.subCategories')->with('success', __('messages.edit_category'));
    }

    public function delete (Request $request)
    {
        $category = SubCategory::findOrFail($request->new_id);
        if ($category->bank_photo) {
            unlink(public_path($category->image));
        }
        $category->delete();
        return redirect()->route('usedMarket.subCategories')->with('success', __('messages.delete_category'));
    }
}
