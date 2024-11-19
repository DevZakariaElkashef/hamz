<?php

namespace App\Http\Controllers\Earn\Admin;

use App\Models\Package;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\Earn\PackageRepository;
use App\Http\Requests\Earn\Web\PackageRequest;

class PackageController extends Controller
{
    protected $packageRepository;

    public function __construct(PackageRepository $packageRepository)
    {
        $this->packageRepository = $packageRepository;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $packages = $this->packageRepository->index($request);
        return view('earn.packages.index', compact('packages'));
    }

    public function search(Request $request)
    {
        $packages = $this->packageRepository->search($request);
        return view('earn.packages.table', compact('packages'))->render();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view("earn.packages.create");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PackageRequest $request)
    {
        $this->packageRepository->store($request); // store package
        return to_route('earn.packages.index')->with('success', __("main.created_successffully"));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return to_route('earn.packages.edit');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Package $package)
    {
        return view('earn.packages.edit', compact('package'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PackageRequest $request, Package $package)
    {
        $this->packageRepository->update($request, $package);
        return to_route('earn.packages.index')->with('success', __("main.updated_successffully"));
    }

    public function toggleStatus(Request $request, Package $package)
    {
        $package->update(['is_active' => $request->is_active]);
        return response()->json([
            'success' => true,
            'message' => __("main.updated_successffully")
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Package $package)
    {
        $this->packageRepository->delete($package);
        return to_route('earn.packages.index')->with('success', __("main.delete_successffully"));
    }

    public function delete(Request $request)
    {
        $this->packageRepository->deleteSelection($request);
        return to_route('earn.packages.index')->with('success', __("main.delete_successffully"));
    }
}
