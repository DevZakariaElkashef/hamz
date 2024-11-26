<?php

namespace App\Repositories\Booth;

use App\Models\User;

class AuthRepository
{
    public function login($phone, $deviceToken)
    {
        $user = User::where('phone', $phone)->first();
        $user->update(['device_token' => $deviceToken]);
        return $user;
    }

    public function register($data)
    {
        $otp = $this->generateOtp();
        User::create(array_merge($data, ['app' => 'booth', 'role_id' => 2, 'otp' => $otp]));
        return $otp;
    }

    public function verify($request)
    {
        $user = User::where('otp', $request['otp'])->first();
        if ($user) {
            $user->update(['is_active' => 1]);
            return true;
        }
        return false;
    }

    public function sendOtp($request)
    {
        $user = User::where("phone", $request['phone'])->first();
        if ($user) {
            $user->update(['otp' => $this->generateOtp()]);
            return true;
        }
        return false;
    }

    public function updatePassword($request)
    {
        $user = User::where("phone", $request['phone'])->first();
        if ($user) {
            $user->update(['password' => $request['password']]);
            return true;
        }
        return false;
    }

    public function logout($user)
    {
        $user->tokens()->delete();
        $user->update(['device_token' => null]);
    }

    private function generateOtp()
    {
        do {
            $otp = random_int(1000, 9999);
        } while (User::where('otp', $otp)->exists());

        return $otp;
    }
}
