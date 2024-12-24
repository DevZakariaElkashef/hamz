<?php

namespace App\Http\Controllers\Mall\Api;

use App\Http\Controllers\Controller;
use App\Models\CancleOrderReason;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class CancleOrderReasonController extends Controller
{
    use ApiResponse;

    public function index()
    {
        $reasons = CancleOrderReason::all()->map(function ($reason) {
            return [
                'id' => $reason->id,
                'name' => $reason->{'name_' . app()->getLocale()}
            ];
        });

        return $this->sendResponse(200, $reasons);
    }
}
