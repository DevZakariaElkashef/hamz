<?php

namespace App\Http\Controllers\Mall\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Mall\Api\UpdateCartRequest;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function update(UpdateCartRequest $request)
    {
        $user = $request->user();

        

    }
}
