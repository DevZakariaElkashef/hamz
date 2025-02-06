<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\SignupRequest;
use App\Providers\RouteServiceProvider;
use App\Repositories\VendorRepository;
use Illuminate\Support\Facades\Auth;

class SignupController extends Controller
{
    protected $vendorRepository;

    public function __construct(VendorRepository $vendorRepository) {
        $this->vendorRepository = $vendorRepository;
    }

    /*----------------------------------------------------------------------------------------------------*/

    public function signupPage()
    {
        $cities = $this->vendorRepository->cities();

        return view("auth.signup", compact('cities'));
    }

    /*----------------------------------------------------------------------------------------------------*/

    public function signup(SignupRequest $request)
    {
        $this->vendorRepository->store($request);
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            return redirect()->intended(RouteServiceProvider::HOME);
        }

        session()->flash('error', __('main.error_accoure'));
        return redirect()->back();
    }
}
