<?php

namespace App\Http\Controllers\Mall\Api;

use App\Http\Controllers\Controller;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    use ApiResponse;

    public function index()
    {
        $data = [
            'sliders' = 
        ]
        return $this->sendResponse(200, $data);
    }
}
