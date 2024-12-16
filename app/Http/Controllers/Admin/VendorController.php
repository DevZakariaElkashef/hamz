<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Exports\VendorExport;
use App\Imports\VendorImport;
use App\Models\User as Vendor;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use App\Repositories\VendorRepository;
use App\Http\Requests\Admin\VendorRequest;
use Maatwebsite\Excel\Validators\ValidationException;

class VendorController extends Controller
{
    protected $vendorRepository;

    public function __construct(VendorRepository $vendorRepository)
    {
        $this->middleware('can:hamz.vendors.index')->only(['index']);
        $this->middleware('can:hamz.vendors.create')->only(['create', 'store']);
        $this->middleware('can:hamz.vendors.update')->only(['edit', 'update']);
        $this->middleware('can:hamz.vendors.delete')->only(['destroy']);


        $this->vendorRepository = $vendorRepository;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $vendors = $this->vendorRepository->index($request);
        $cities = $this->vendorRepository->cities();
        return view('vendors.index', compact('vendors', 'cities'));
    }

    public function search(Request $request)
    {
        $vendors = $this->vendorRepository->search($request);
        return view('vendors.table', compact('vendors'))->render();
    }

    public function export(Request $request)
    {
        return Excel::download(new VendorExport($request), 'vendors.xlsx');
    }

    public function import(Request $request)
    {
        try {
            Excel::import(new VendorImport, $request->file('file'));

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
        $cities = $this->vendorRepository->cities();
        return view("vendors.create", compact('cities'));
    }


    public function join()
    {
        $cities = $this->vendorRepository->cities();
        return view("vendors.join", compact('cities'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(VendorRequest $request)
    {
        $this->vendorRepository->store($request); // store vendor
        return to_route('vendors.index')->with('success', __("main.created_successffully"));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return to_route('vendors.edit');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Vendor $vendor)
    {
        $cities = $this->vendorRepository->cities();
        return view('vendors.edit', compact('vendor', 'cities'));
    }

    public function toggleStatus(Request $request, Vendor $vendor)
    {
        $vendor->update(['is_active' => $request->is_active]);
        return response()->json([
            'success' => true,
            'message' => __("main.updated_successffully")
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(VendorRequest $request, Vendor $vendor)
    {
        $this->vendorRepository->update($request, $vendor);
        return to_route('vendors.index')->with('success', __("main.updated_successffully"));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Vendor $vendor)
    {
        $this->vendorRepository->delete($vendor);
        return to_route('vendors.index')->with('success', __("main.delete_successffully"));
    }

    public function delete(Request $request)
    {
        $this->vendorRepository->deleteSelection($request);
        return to_route('vendors.index')->with('success', __("main.delete_successffully"));
    }
}
