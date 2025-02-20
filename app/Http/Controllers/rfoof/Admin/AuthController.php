<?php

namespace App\Http\Controllers\rfoof\Admin;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\rfoof\Auth\SignRequest;
use App\Http\Requests\rfoof\Auth\SignUpRequest;

class AuthController extends Controller
{
    private $permissionModel, $roleModel, $userModel, $userPermissionsModel;

    public function __construct(Role $roleModel, User $userModel)
    {
        $this->roleModel = $roleModel;
        $this->userModel = $userModel;
    }
    public function login()
    {
        return view('auth.login');
    }

    public function signIn(SignRequest $request)
    {
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            session()->flash('success', 'تم تسجيل الدخول بنجاح');
            return redirect()->intended(route('admin'));
        }
        session()-flash('error', __('messages.wrong_password'));
        return redirect()->back();
    }

    /*-----------------------------------------------------------------------------------------------*/
    public function signUp(SignUpRequest $request)
    {
        ($request->type == "marketer") ? $type = $this->roleModel::where('name', 'marketer')->first()->id : $type = $this->roleModel::where('name', 'merchant')->first()->id;
        $user = $this->userModel->create([
            'role_id' => $type,
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
            'verified' => 0,
            'app' => 'resale'
        ]);

        $permission = $this->permissionModel->where('name', $request->type)->first()->id;
        $this->userPermissionsModel->create([
            'user_id' => $user->id,
            'permission_id' => $permission,
        ]);
        session()->flash('success', 'تم اضافة الحساب بإنتظار موافقة الادارة');
        return redirect()->back();
    }
    /*-----------------------------------------------------------------------------------------------*/

    public function logout()
    {
        auth()->logout();
        session()->flush();
        return redirect(route('login'));
    }
}
