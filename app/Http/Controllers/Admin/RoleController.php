<?php

namespace App\Http\Controllers\Admin;

use App\Models\Role;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\RoleRepository;
use App\Http\Requests\Admin\RoleRequest;

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
        $roles = Role::whereNotIn('id', [1, 2, 3])->get();
        return view("roles.create", compact('roles'));
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
        return view('roles.edit', compact('role'));
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
