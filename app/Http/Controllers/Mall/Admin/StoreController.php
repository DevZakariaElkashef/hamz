<?php

namespace App\Http\Controllers\Mall\Admin;

use App\Exports\Mall\StoreExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\Mall\Web\StoreRequest;
use App\Imports\Mall\StoreImport;
use App\Models\City;
use App\Models\Section;
use App\Models\Store;
use App\Models\User;
use App\Repositories\Mall\StoreRepository;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Validators\ValidationException;

class StoreController extends Controller
{
    protected $storeRepository;

    public function __construct(StoreRepository $storeRepository)
    {
        $this->storeRepository = $storeRepository;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $stores = $this->storeRepository->index($request);
        $sections = Section::mall()->active()->get();
        return view('mall.stores.index', compact('stores', 'sections'));
    }

    public function search(Request $request)
    {
        $stores = $this->storeRepository->search($request);
        return view('mall.stores.table', compact('stores'))->render();
    }

    public function getStoresBySection(Request $request)
    {
        $items = Store::where('section_id', $request->sectionId)->get();
        return view("mall.layouts._options", compact('items'))->render();
    }

    public function export(Request $request)
    {
        return Excel::download(new StoreExport($request), 'stores.xlsx');
    }

    public function import(Request $request)
    {
        try {
            Excel::import(new StoreImport, $request->file('file'));

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
        $sections = Section::active()->mall()->get();
        $users = User::active()->get();
        $cities = City::active()->get();
        return view("mall.stores.create", compact('sections', 'users', 'cities'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request)
    {
        $this->storeRepository->store($request); // store store
        return to_route('mall.stores.index')->with('success', __("main.created_successffully"));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return to_route('mall.stores.edit');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, Store $store)
    {
        abort_if($request->user()->role_id == 3 && $store->user_id != $request->user()->id, 403);

        $sections = Section::active()->mall()->get();
        $users = User::active()->get();
        $cities = City::active()->get();
        return view('mall.stores.edit', compact('store', 'sections', 'users', 'cities'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreRequest $request, Store $store)
    {
        $this->storeRepository->update($request, $store);
        return to_route('mall.stores.index')->with('success', __("main.updated_successffully"));
    }

    public function toggleStatus(Request $request, Store $store)
    {
        $store->update(['is_active' => $request->is_active]);
        return response()->json([
            'success' => true,
            'message' => __("main.updated_successffully"),
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Store $store)
    {
        $this->storeRepository->delete($store);
        return to_route('mall.stores.index')->with('success', __("main.delete_successffully"));
    }

    public function delete(Request $request)
    {
        $this->storeRepository->deleteSelection($request);
        return to_route('mall.stores.index')->with('success', __("main.delete_successffully"));
    }
}
