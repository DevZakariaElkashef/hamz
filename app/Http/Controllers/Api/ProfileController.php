<?php

namespace App\Http\Controllers\Api;

use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\Mall\UserProfileResource;
use App\Http\Requests\Mall\Api\UpdateProfileRequest;

class ProfileController extends Controller
{
    use ApiResponse;

    public function index(Request $request)
    {
        $user = $request->user();

        $user = new UserProfileResource($user);

        return $this->sendResponse(200, $user);
    }

    public function update(UpdateProfileRequest $request)
    {
        $user = $request->user();
        $user->update($request->validated());
        return $this->sendResponse(200, '', __("mall.updated_successffully"));
    }
}
