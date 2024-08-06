<?php

namespace App\Traits;

trait ApiResponse
{
    public function sendResponse($code, $data, $message = '')
    {
        return response()->json([
            'code' => $code,
            'data' => $data,
            'message' => $message
        ], $code);
    }
}
