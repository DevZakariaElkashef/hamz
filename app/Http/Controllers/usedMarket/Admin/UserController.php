<?php

namespace App\Http\Controllers\usedMarket\Admin;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use App\Traits\ImageUploadTrait;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\usedMarket\Auth\SignRequest;
use App\Http\Requests\usedMarket\Users\UpdateRequest;

class UserController extends Controller
{
    use ImageUploadTrait;
    private $userModel, $roleModel;
    public function __construct(User $employee, Role $role)
    {
        $this->userModel = $employee;
        $this->roleModel = $role;
    }
    public function index($status)
    {
        $users = $this->userModel->where('status', $status)->RoleIdUser()->latest()->paginate(10);
        return view('admin.users.clients', compact('users', 'status'));
    }
    public function searchUser(Request $request)
    {
        $users = $this->userModel->where(function ($query) use ($request) {
            $query->where('name', 'LIKE', '%' . $request->search . '%')->where('role_id', 2);
        })->latest()->paginate(10);
        return view('admin.users.clients', compact('users'));
    }

    public function addUser()
    {
        return view('admin.users.create');
    }

    public function store(SignRequest $request)
    {
        if ($request->image) {
            $imageName = time() . 'user.' . $request->image->extension();
            $this->uploadImage($request->image, $imageName, 'users');
        } else {
            $imageName = null;
        }
        $this->userModel::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
            'image' => $imageName,
            'role_id' => 4
        ]);

        return redirect(route('users'))->with('message', __('messages.adduser'));
    }

    public function verify(Request $request)
    {
        $admin = $this->userModel->findOrFail($request->user_id);

        $admin->update([
            'status' => ($admin->status == 1) ? 0 : 1,
        ]);

        session()->flash('message', ($admin->status == 1) ? __('messages.verify_user') : __('messages.notverify_user'));
        return redirect()->back();
    }

    public function edit($id)
    {
        $user = $this->userModel->findOrFail($id);
        return view('admin.users.edit', compact('user'));
    }

    public function update(UpdateRequest $request)
    {
        $employee = $this->userModel::findOrFail($request->user_id);
        if ($request->image) {
            $imageName = time() . 'user.' . $request->image->extension();
            $this->uploadImage($request->image, $imageName, 'users');
        }
        ($request->password) ? $password = Hash::make($request->password) : $password = $employee->password;
        $employee->update([
            'f_name' => $request->f_name,
            'l_name' => $request->l_name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => $password,
            'image' => ($request->image) ? $imageName : "",
        ]);
        session()->flash('success', __('messages.edit_user'));
        return redirect(route('users'));
    }

    public function delete(Request $request)
    {
        $this->userModel::where('id', $request->user_id)->delete();
        session()->flash('success', __('messages.delete_user'));
        return back();
    }

    public function accepet($id)
    {
        $this->userModel::where('id', $id)->update(['status' => 1]);
        session()->flash('success', __('messages.accepet_user'));
        return back();
    }
    public function rejecet($id)
    {
        $this->userModel::where('id', $id)->update(['status' => 2]);
        session()->flash('success', __('messages.rejecet_user'));
        return back();
    }
}
