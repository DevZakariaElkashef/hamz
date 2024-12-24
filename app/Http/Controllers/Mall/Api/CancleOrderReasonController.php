<?php

namespace App\Http\Controllers\Mall\Api;

use App\Http\Controllers\Controller;
use App\Models\CancleOrderReason;
use Illuminate\Http\Request;

class CancleOrderReasonController extends Controller
{
    public function index()
    {
        $reasons = CancleOrderReason::all()->map(function ($reason) {
            return [
                'id' => $reason->id,
                'name' => $reason->{'name_' . app()->getLocale()}
            ];
        });
    }
}
