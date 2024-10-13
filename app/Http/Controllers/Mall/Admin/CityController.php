<?php

namespace App\Http\Controllers\Mall\Admin;

use App\Models\City;
use Illuminate\Http\Request;
use App\Exports\Mall\CityExport;
use App\Imports\Mall\CityImport;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use App\Repositories\Mall\CityRepository;
use App\Http\Requests\Mall\Web\CityRequest;
use Maatwebsite\Excel\Validators\ValidationException;

class CityController extends Controller
{
    protected $cityRepository;

    public function __construct(CityRepository $cityRepository)
    {
        $this->cityRepository = $cityRepository;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $cities = $this->cityRepository->index($request);
        return view('mall.cities.index', compact('cities'));
    }

    public function search(Request $request)
    {
        $cities = $this->cityRepository->search($request);
        return view('mall.cities.table', compact('cities'))->render();
    }

    public function export(Request $request)
    {
        return Excel::download(new CityExport($request), 'cities.xlsx');
    }

    public function import(Request $request)
    {
        try {
            Excel::import(new CityImport, $request->file('file'));

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
        return view("mall.cities.create");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CityRequest $request)
    {
        $this->cityRepository->store($request); // store city
        return to_route('mall.cities.index')->with('success', __("main.created_successffully"));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return to_route('mall.cities.edit');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(City $city)
    {
        return view('mall.cities.edit', compact('city'));
    }

    public function toggleStatus(Request $request, City $city)
    {
        $city->update(['is_active' => $request->is_active]);
        return response()->json([
            'success' => true,
            'message' => __("main.updated_successffully")
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CityRequest $request, City $city)
    {
        $this->cityRepository->update($request, $city);
        return to_route('mall.cities.index')->with('success', __("main.updated_successffully"));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(City $city)
    {
        $this->cityRepository->delete($city);
        return to_route('mall.cities.index')->with('success', __("main.delete_successffully"));
    }

    public function delete(Request $request)
    {
        $this->cityRepository->deleteSelection($request);
        return to_route('mall.cities.index')->with('success', __("main.delete_successffully"));
    }
}
