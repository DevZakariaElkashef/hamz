<?php

namespace App\Http\Controllers\usedMarket\Admin;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use App\Traits\ImageUploadTrait;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\usedMarket\Employee\AddRequest;
use App\Http\Requests\usedMarket\Employee\UpdateRequest;

class AdminController extends Controller
{
    use ImageUploadTrait;
    private $employeeModel, $roleModel, $missionModel, $companyModel;
    public function __construct(User $employee, Role $role)
    {
        $this->employeeModel = $employee;
        $this->roleModel = $role;
    }
    public function index()
    {
        $admins = $this->employeeModel->where(function ($query) {
            $query->where('role_id', '!=', 1)->where('role_id', '!=', 2)->where('role_id', '!=', 3)->where('role_id', '!=', 5);
        })->count();
        $employees = $this->employeeModel->where('role_id', 5)->count();
        $dead_information = 0;
        $graves = 0;
        $contact = 0;
        return view('usedMarket.index', compact('admins', 'employees', 'dead_information', 'graves', 'contact'));
    }
    public function indexAdmins()
    {
        $admins = $this->employeeModel->RoleIdAdmin()->paginate(10);
        return view('admin.admins.index', compact('admins'));
    }

    public function addAdmin()
    {
        return view('admin.admins.create');
    }

    public function store(AddRequest $request)
    {
        $this->employeeModel::create([
            'f_name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
            'role_id' => 4,
            'app' => 'resale'
        ]);
        session()->flash('success', __('messages.add_admin'));
        return redirect(route('admins'));
    }

    public function verify(Request $request)
    {
        $admin = $this->employeeModel->findOrFail($request->admin_id);

        $admin->update([
            'status' => ($admin->status == 1) ? 0 : 1,
        ]);

        session()->flash('success', ($admin->status == 1) ? __('messages.verify_admin') : __('messages.not_active_admin'));
        return redirect()->back();
    }

    public function edit($id)
    {
        $admin = $this->employeeModel->findOrFail($id);
        return view('admin.admins.edit', compact('admin'));
    }

    public function update(UpdateRequest $request)
    {
        $employee = $this->employeeModel::findOrFail($request->admin_id);
        ($request->password) ? $password = Hash::make($request->password) : $password = $employee->password;
        $employee->update([
            'f_name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => $password,
        ]);
        session()->flash('success', __('messages.update_admin'));
        return redirect(route('admins'));
    }

    public function delete(Request $request)
    {
        $this->employeeModel::where('id', $request->admin_id)->delete();
        session()->flash('success', __('messages.delete_admin'));
        return back();
    }
}
