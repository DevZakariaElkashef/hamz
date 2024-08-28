<?php

namespace App\Http\Controllers\Mall\Admin;

use App\Models\City;
use App\Models\User;
use App\Models\Brand;
use App\Models\Section;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\Mall\BrandRepository;
use App\Http\Requests\Mall\Web\BrandRequest;

class BrandController extends Controller
{
    protected $brandRepository;

    public function __construct(BrandRepository $brandRepository)
    {
        $this->brandRepository = $brandRepository;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $brands = $this->brandRepository->index($request);
        $sections = Section::mall()->active()->get();
        return view('mall.brands.index', compact('brands', 'sections'));
    }

    public function search(Request $request)
    {
        $brands = $this->brandRepository->search($request);
        return view('mall.brands.table', compact('brands'))->render();
    }

    public function getBrandsBySection(Request $request)
    {
        $items = Brand::whereHas('store', function ($store) use($request) {
            $store->where("section_id", $request->sectionId);
        })->get();

        return view('mall.layouts._options', compact('items'))->render();
    }

    public function getBrandsBystore(Request $request)
    {
        $items = Brand::where("store_id", $request->storeId)->get();
        return view('mall.layouts._options', compact('items'))->render();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $sections = Section::active()->mall()->get();
        $users = User::active()->get();
        $cities = City::mall()->active()->get();
        return view("mall.brands.create", compact('sections', 'users', 'cities'));
    }

    /**
     * Brand a newly created resource in storage.
     */
    public function brand(BrandRequest $request)
    {
        $this->brandRepository->brand($request); // brand brand
        return to_route('mall.brands.index')->with('success', __("mall.created_successffully"));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return to_route('mall.brands.edit');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Brand $brand)
    {
        $sections = Section::active()->mall()->get();
        $users = User::active()->get();
        $cities = City::mall()->active()->get();
        return view('mall.brands.edit', compact('brand', 'sections', 'users', 'cities'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(BrandRequest $request, Brand $brand)
    {
        $this->brandRepository->update($request, $brand);
        return to_route('mall.brands.index')->with('success', __("mall.updated_successffully"));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Brand $brand)
    {
        $this->brandRepository->delete($brand);
        return to_route('mall.brands.index')->with('success', __("mall.delete_successffully"));
    }

    public function delete(Request $request)
    {
        $this->brandRepository->deleteSelection($request);
        return to_route('mall.brands.index')->with('success', __("mall.delete_successffully"));
    }
}
