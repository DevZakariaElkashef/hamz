<?php

namespace App\Http\Controllers\Api;

use App\Models\Otp;
use App\Models\User;
use App\Traits\GeneralTrait;
use Illuminate\Http\Request;
use App\Traits\ImageUploadTrait;
use Illuminate\Support\Facades\App;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Http\Resources\Usedmarket\UserResource;
use App\Http\Requests\Usedmarket\Api\LoginRequest;
use App\Http\Requests\Usedmarket\Api\RegisterRequest;
use App\Http\Requests\Usedmarket\Api\VerifyOtpRequest;
use App\Http\Requests\Usedmarket\Api\ResendCodeRequest;
use App\Http\Requests\Usedmarket\Api\ResetPasswordRequest;
use App\Http\Requests\Usedmarket\Api\UpdateProfileRequest;
use App\Http\Requests\Usedmarket\Api\ChangePasswordRequest;
use App\Http\Requests\Usedmarket\Api\UpdatePasswordRequest;

class AuthController extends Controller
{
    use GeneralTrait, ImageUploadTrait;

    public function __construct()
    {
        App::setLocale(request()->header('lang'));
    }
    public function register(RegisterRequest $request)
    {
        try {
            if ($request->image) {
                $imageName = time() . 'user.' . $request->image->extension();
                $this->uploadImage($request->image, $imageName, 'users');
            } else {
                $imageName = null;
            }

            $verify = rand(1111, 9999);
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'code' => $request->code,
                'password' => Hash::make($request->password),
                'image' => $imageName,
                'role_id' => 2
            ]);
            Otp::create([
                'otp' => $verify,
                'phone' => $request->phone
            ]);
            return $this->returnData('data', ['phone' => $user->phone, 'code' => $verify], __('main.regiser'));
        } catch (\Throwable $e) {
            return $this->returnError(403, $e->getMessage());
        }
    }
    public function verifyCodePassword(VerifyOtpRequest $request)
    {
        try {

            $otp = Otp::where(['otp' => $request->otp, 'phone' => $request->phone])->first();
            if (!$otp) {
                return $this->returnError(403, __('main.codeNotFound'));
            }
            Otp::where(['otp' => $request->otp, 'phone' => $request->phone])->delete();
            return $this->returnSuccess(200, __('main.verifyCodePassword'));
        } catch (\Throwable $e) {
            return $this->returnError(403, $e->getMessage());
        }
    }
    public function verifyCode(VerifyOtpRequest $request)
    {
        try {
            $otp = Otp::where(['otp' => $request->otp, 'phone' => $request->phone])->first();
            if (!$otp) {
                return $this->returnError(403, __('main.codeNotFound'));
            }
            Otp::where(['otp' => $request->otp, 'phone' => $request->phone])->delete();
            User::where(['phone' => $request->phone])->update(['status' => 1, 'device_token' => $request->device_token]);
            $user = User::where('phone', $request->phone)->first();
            $token = $user->createToken("API TOKEN")->plainTextToken;
            $token = "Bearer " . $token;
            $user->token = $token;
            return $this->returnData("data", ["user" => new UserResource($user), 'isActive' => true], __('main.login'));
        } catch (\Throwable $e) {
            return $this->returnError(403, $e->getMessage());
        }
    }
    public function resetPassword(ResetPasswordRequest $request)
    {
        try {
            $verify = rand(1111, 9999);
            Otp::create([
                'otp' => $verify,
                'phone' => $request->phone
            ]);
            return $this->returnData('data', ['phone' => $request->phone, 'code' => $verify], __('main.regiser'));
        } catch (\Throwable $e) {
            return $this->returnError(403, $e->getMessage());
        }
    }
    public function changePassword(ChangePasswordRequest $request)
    {
        try {
            User::where('phone', $request->phone)->update(['password' => Hash::make($request->password)]);
            return $this->returnSuccess(200, __('main.changePassword'));
        } catch (\Throwable $e) {
            return $this->returnError(403, $e->getMessage());
        }
    }
    public function resendCode(ResendCodeRequest $request)
    {
        try {
            $verify = rand(1111, 9999);
            Otp::create([
                'otp' => $verify,
                'phone' => $request->phone
            ]);
            return $this->returnData('data', ['phone' => $request->phone, 'code' => $verify], __('main.regiser'));
        } catch (\Throwable $e) {
            return $this->returnError(403, $e->getMessage());
        }
    }

    public function login(LoginRequest $request)
    {
        try {
            if (auth()->attempt(['phone' => $request->phone, 'password' => $request->password])) {
                $user = User::where('phone', $request->phone)->first();
                if (!$user->is_active) {
                    $verify = rand(1111, 9999);
                    Otp::where('phone', $request->phone)->delete();
                    Otp::create([
                        'otp' => $verify,
                        'phone' => $request->phone
                    ]);
                    return $this->returnData('data', ['phone' => $request->phone, 'code' => $verify, 'isActive' => false], __('main.regiser'));
                }
                $token = $user->createToken("API TOKEN")->plainTextToken;
                $user->update(['device_token' => $request->device_token]);
                $user->token = "Bearer " . $token;
                return $this->returnData("data", ["user" => new UserResource($user), 'isActive' => true], __('main.login'));
            }
            return $this->returnError(403, __('main.passwordOrPhoneIsWrong'));
        } catch (\Throwable $e) {
            return $this->returnError(403, $e->getMessage());
        }
    }
    public function logout()
    {
        try {
            $user = request()->user();
            User::where('id', request()->user()->id)->update(['device_token' => null]);
            $user->tokens()->where('id', $user->currentAccessToken()->id)->delete();
            return $this->returnSuccess(200, __('main.logout'));
        } catch (\Throwable $e) {
            return $this->returnError(403, $e->getMessage());
        }
    }
    public function deleteAccount()
    {
        try {
            User::where('id', request()->user()->id)->delete();
            return $this->returnSuccess(200, __('main.deleteAccount'));
        } catch (\Throwable $e) {
            return $this->returnError(403, $e->getMessage());
        }
    }
    public function getProfileData()
    {
        try {
            $user = User::where('phone', request()->user()->phone)->first();
            return $this->returnData("data", ["user" => new UserResource($user)], __('main.returnData'));
        } catch (\Throwable $e) {
            return $this->returnError(403, $e->getMessage());
        }
    }
    public function updateProfile(UpdateProfileRequest $request)
    {
        try {
            $user = User::where('phone', $request->user()->phone)->first();
            if ($request->image) {
                $imageName = time() . 'user.' . $request->image->extension();
                $this->uploadImage($request->image, $imageName, 'users');
            }
            $user->update([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'image' => ($request->image) ? $imageName : '',
            ]);
            return $this->returnData("data", ["user" => new UserResource($user)], __('main.updateProfile'));
        } catch (\Throwable $e) {
            return $this->returnError(403, $e->getMessage());
        }
    }
    public function updatePassword(UpdatePasswordRequest $request)
    {
        try {
            $user = User::where('id', $request->user()->id)->first();
            if (!Hash::check($request->current_password, $user->password)) {
                return $this->returnError('403', __('main.notCorrecetPassword'));
            }
            $user->update([
                'password' => Hash::make($request->password),
            ]);
            return $this->returnSuccess(200, __('main.changePassword'));
        } catch (\Throwable $e) {
            return $this->returnError(403, $e->getMessage());
        }
    }
}
