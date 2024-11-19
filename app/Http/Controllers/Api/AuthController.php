<?php

namespace App\Http\Controllers\Api;

use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Mall\Api\forgetPasswordRequest;
use App\Repositories\Mall\AuthRepository;
use App\Http\Requests\Mall\Api\LoginRequest;
use App\Http\Requests\Mall\Api\VerifiyRequest;
use App\Http\Requests\Mall\Api\RegisterRequest;
use App\Http\Requests\Mall\Api\SendOtpRequest;
use App\Http\Resources\Mall\AuthenticatedResource;

class AuthController extends Controller
{
    use ApiResponse;

    protected $authRepository;

    public function __construct(AuthRepository $authRepository)
    {
        $this->authRepository = $authRepository;
    }

    public function login(LoginRequest $request)
    {
        $user = $this->authRepository->login($request->phone, $request->device_token);
        $user = new AuthenticatedResource($user);
        return $this->sendResponse(200, $user);
    }

    public function register(RegisterRequest $request)
    {
        $otp = $this->authRepository->register($request->validated());
        return $this->sendResponse(200, $otp, __("main.acount_created_check_otp"));
    }

    public function verifyOtp(VerifiyRequest $request)
    {
        $verified = $this->authRepository->verify($request->all());
        if ($verified) {
            return $this->sendResponse(200, '', __("main.account_verified_success"));
        }
        return $this->sendResponse(200, '', __("main.error_accoure"));
    }

    public function sendOtp(SendOtpRequest $request)
    {
        $sended = $this->authRepository->sendOtp($request->validated());
        if ($sended) {
            return $this->sendResponse(200, '', __("main.otp_send_success"));
        }
        return $this->sendResponse(200, '', __("main.error_accoure"));
    }

    public function updatePassword(forgetPasswordRequest $request)
    {
        $udpated = $this->authRepository->updatePassword($request->validated());
        if ($udpated) {
            return $this->sendResponse(200, '', __("main.updated_successffully"));
        }
        return $this->sendResponse(200, '', __("main.error_accoure"));
    }

    public function logout(Request $request)
    {
        $user = $request->user();
        $this->authRepository->logout($user);

        return $this->sendResponse(200, '', __("main.logout_success"));
    }
}
