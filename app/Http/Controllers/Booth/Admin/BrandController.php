<?php

namespace App\Http\Controllers\Booth\Admin;

use App\Exports\Booth\BrandExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\Booth\Web\BrandRequest;
use App\Imports\Booth\BrandImport;
use App\Models\Brand;
use App\Models\City;
use App\Models\Section;
use App\Models\Store;
use App\Models\User;
use App\Repositories\Booth\BrandRepository;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Validators\ValidationException;

class BrandController extends Controller
{
    protected $brandRepository;

    public function __construct(BrandRepository $brandRepository)
    {
        $this->brandRepository = $brandRepository;

        // autherization
        $this->middleware('can:booth.brands.index')->only('index');
        $this->middleware('can:booth.brands.create')->only(['create', 'store']);
        $this->middleware('can:booth.brands.update')->only(['edit', 'update']);
        $this->middleware('can:booth.brands.delete')->only('destroy');
        $this->middleware('can:booth.brands.export')->only('export');
        $this->middleware('can:booth.brands.import')->only('import');
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $brands = $this->brandRepository->index($request);
        $sections = Section::booth()->active()->get();
        $stores = Store::booth()->active()->get();
        return view('booth.brands.index', compact('brands', 'sections', 'stores'));
    }

    public function search(Request $request)
    {
        $brands = $this->brandRepository->search($request);
        return view('booth.brands.table', compact('brands'))->render();
    }

    public function getBrandsBySection(Request $request)
    {
        $items = Brand::whereHas('store', function ($store) use ($request) {
            $store->where("section_id", $request->sectionId);
        })->get();

        return view('booth.layouts._options', compact('items'))->render();
    }

    public function getBrandsBystore(Request $request)
    {
        $items = Brand::where("store_id", $request->storeId)->get();
        return view('booth.layouts._options', compact('items'))->render();
    }

    public function export(Request $request)
    {
        return Excel::download(new BrandExport($request), 'brands.xlsx');
    }

    public function import(Request $request)
    {
        try {
            Excel::import(new BrandImport, $request->file('file'));

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
        $sections = Section::active()->booth()->get();
        $users = User::active()->get();
        $cities = City::active()->get();
        $stores = Store::booth()->active()->get();
        return view("booth.brands.create", compact('sections', 'users', 'cities', 'stores'));
    }

    /**
     * Brand a newly created resource in storage.
     */
    public function store(BrandRequest $request)
    {
        $this->brandRepository->brand($request); // brand brand
        return to_route('booth.brands.index')->with('success', __("main.created_successffully"));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return to_route('booth.brands.edit');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Brand $brand)
    {
        $sections = Section::active()->booth()->get();
        $users = User::active()->get();
        $cities = City::active()->get();
        $stores = Store::booth()->active()->get();
        return view('booth.brands.edit', compact('brand', 'sections', 'users', 'cities', 'stores'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(BrandRequest $request, Brand $brand)
    {
        $this->brandRepository->update($request, $brand);
        return to_route('booth.brands.index')->with('success', __("main.updated_successffully"));
    }

    public function toggleStatus(Request $request, Brand $brand)
    {
        $brand->update(['is_active' => $request->is_active]);
        return response()->json([
            'success' => true,
            'message' => __("main.updated_successffully"),
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Brand $brand)
    {
        $this->brandRepository->delete($brand);
        return to_route('booth.brands.index')->with('success', __("main.delete_successffully"));
    }

    public function delete(Request $request)
    {
        $this->brandRepository->deleteSelection($request);
        return to_route('booth.brands.index')->with('success', __("main.delete_successffully"));
    }
}
