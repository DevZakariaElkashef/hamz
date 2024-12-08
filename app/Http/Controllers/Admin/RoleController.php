<?php

namespace App\Http\Controllers\Admin;

use App\Models\Role;
use App\Models\Permission;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\RoleRepository;
use App\Http\Requests\Admin\RoleRequest;

class RoleController extends Controller
{
    protected $roleRepository;

    public function __construct(RoleRepository $roleRepository)
    {
        $this->middleware('can:hamz.roles.index')->only(['index']);
        $this->middleware('can:hamz.roles.create')->only(['create', 'store']);
        $this->middleware('can:hamz.roles.update')->only(['edit', 'update']);
        $this->middleware('can:hamz.roles.delete')->only(['destroy']);

        $this->roleRepository = $roleRepository;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $roles = $this->roleRepository->index($request);
        return view('roles.index', compact('roles'));
    }

    public function search(Request $request)
    {
        $roles = $this->roleRepository->search($request);
        return view('roles.table', compact('roles'))->render();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Fetch all permissions from the database
        $permissions = Permission::all();  // Retrieves all permissions

        // Group the permissions by the first part and the second part
        $groupedPermissions = [];

        foreach ($permissions as $permission) {
            $parts = explode('.', $permission->name);  // Assuming the column is 'name'

            if (count($parts) >= 2) {
                $group = $parts[0];  // First part (group1)
                $subgroup = $parts[1];  // Second part (group1-0)

                // Group permissions by the first part, then by second part
                if (!isset($groupedPermissions[$group])) {
                    $groupedPermissions[$group] = [];
                }
                $groupedPermissions[$group][$subgroup][] = $permission;
            }
        }

        return view("roles.create", compact('groupedPermissions'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(RoleRequest $request)
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
    public function edit(Role $role)
    {
        // Fetch all permissions from the database
        $permissions = Permission::all();

        // Group the permissions by the first part and the second part
        $groupedPermissions = [];

        foreach ($permissions as $permission) {
            $parts = explode('.', $permission->name); // Assuming the column is 'name'

            if (count($parts) >= 2) {
                $group = $parts[0]; // First part (group1)
                $subgroup = $parts[1]; // Second part (group1-0)

                // Group permissions by the first part, then by the second part
                if (!isset($groupedPermissions[$group])) {
                    $groupedPermissions[$group] = [];
                }
                $groupedPermissions[$group][$subgroup][] = $permission;
            }
        }

        // Fetch permissions already assigned to the role
        $assignedPermissions = $role->permissions->pluck('id')->toArray();

        return view("roles.edit", compact('role', 'groupedPermissions', 'assignedPermissions'));
    }

    public function toggleStatus(Request $request, Role $role)
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
    public function update(RoleRequest $request, Role $role)
    {
        $this->roleRepository->update($request, $role);
        return to_route('roles.index')->with('success', __("main.updated_successffully"));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Role $role)
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
