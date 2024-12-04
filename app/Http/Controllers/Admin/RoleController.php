<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\RoleRepository;

class RoleController extends Controller
{
    protected $roleRepository;

    public function __construct(RoleRepository $roleRepository)
    {
        $this->roleRepository = $roleRepository;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $roles = $this->roleRepository->index($request);
        $cities = $this->roleRepository->cities();
        return view('roles.index', compact('roles', 'cities'));
    }

    public function search(Request $request)
    {
        $roles = $this->roleRepository->search($request);
        return view('roles.table', compact('roles'))->render();
    }

    public function export(Request $request)
    {
        return Excel::download(new EmployeeExport($request), 'roles.xlsx');
    }

    public function import(Request $request)
    {
        try {
            Excel::import(new EmployeeImport, $request->file('file'));

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
        $cities = $this->roleRepository->cities();
        $roles = Role::whereNotIn('id', [1, 2, 3])->get();
        return view("roles.create", compact('cities', 'roles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(EmployeeRequest $request)
    {
        $this->roleRepository->store($request); // store role
        return to_route('roles.index')->with('success', __("main.created_successffully"));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return to_route('roles.edit');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $role)
    {
        $cities = $this->roleRepository->cities();
        return view('roles.edit', compact('role', 'cities'));
    }

    public function toggleStatus(Request $request, User $role)
    {
        $role->update(['is_active' => $request->is_active]);
        return response()->json([
            'success' => true,
            'message' => __("main.updated_successffully")
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(EmployeeRequest $request, User $role)
    {
        $this->roleRepository->update($request, $role);
        return to_route('roles.index')->with('success', __("main.updated_successffully"));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $role)
    {
        $this->roleRepository->delete($role);
        return to_route('roles.index')->with('success', __("main.delete_successffully"));
    }

    public function delete(Request $request)
    {
        $this->roleRepository->deleteSelection($request);
        return to_route('roles.index')->with('success', __("main.delete_successffully"));
    }
}
