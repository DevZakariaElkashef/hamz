<?php

namespace App\Traits;

trait ApiResponse
{
    public function sendResponse($code, $data, $message = '', $status = true)
    {
        $status = $code == 200 ? true : false;
        
        return response()->json([
            'status' => $status,
            'message' => $message,
            'data' => $data,
        ], $code);
    }
}
