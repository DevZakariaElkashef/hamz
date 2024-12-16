<?php

namespace App\Http\Controllers\Admin;

use App\Models\Application;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\ApplicationRepository;
use App\Http\Requests\Admin\ApplicationRequest;

class ApplicationController extends Controller
{
    protected $applicationRepository;

    public function __construct(ApplicationRepository $applicationRepository)
    {
        $this->applicationRepository = $applicationRepository;

        // autherization
        $this->middleware('can:hamz.applications.index')->only('index');
        $this->middleware('can:hamz.applications.create')->only(['create', 'store']);
        $this->middleware('can:hams.applications.update')->only(['edit', 'update']);
        $this->middleware('can:hamz.applications.delete')->only('destroy');
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $applications = $this->applicationRepository->index($request);
        return view('applications.index', compact('applications'));
    }

    public function search(Request $request)
    {
        $applications = $this->applicationRepository->search($request);
        return view('applications.table', compact('applications'))->render();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view("applications.create");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ApplicationRequest $request)
    {
        $this->applicationRepository->store($request); // store application
        return to_route('applications.index')->with('success', __("main.created_successffully"));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return to_route('applications.edit');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Application $application)
    {
        return view('applications.edit', compact('application'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ApplicationRequest $request, Application $application)
    {
        $this->applicationRepository->update($request, $application);
        return to_route('applications.index')->with('success', __("main.updated_successffully"));
    }

    public function toggleStatus(Request $request, Application $application)
    {
        $application->update(['is_active' => $request->is_active]);
        return response()->json([
            'success' => true,
            'message' => __("main.updated_successffully"),
        ]);
    }

    public function toggleFixedStatus(Request $request, Application $application)
    {
        $application->update(['is_fixed' => $request->is_active]);

        if ($request->is_active) {
            $this->applicationRepository->updateOtherApplications($application->id);
        }

        return response()->json([
            'success' => true,
            'message' => __("main.updated_successffully"),
            'refresh' => true,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Application $application)
    {
        $this->applicationRepository->delete($application);
        return to_route('applications.index')->with('success', __("main.delete_successffully"));
    }

    public function delete(Request $request)
    {
        $this->applicationRepository->deleteSelection($request);
        return to_route('applications.index')->with('success', __("main.delete_successffully"));
    }
}
