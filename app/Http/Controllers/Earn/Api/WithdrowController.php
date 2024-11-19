<?php

namespace App\Http\Controllers\Earn\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Earn\Api\StoreWithdrowRequest;
use App\Http\Resources\Earn\WithdrowResource;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class WithdrowController extends Controller
{
    use ApiResponse;

    public function index(Request $request)
    {
        $user = $request->user();

        $data = WithdrowResource::collection($user->withdrows);

        return $this->sendResponse(200, $data);
    }


    public function store(StoreWithdrowRequest $request)
    {
        $user = $request->user();

        $user->withdrows()->create($request->all());

        return $this->sendResponse(200, '', __("main.withdrow_sent_to_admin"));
    }
}
