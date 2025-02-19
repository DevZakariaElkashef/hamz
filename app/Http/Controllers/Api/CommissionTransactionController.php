<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\AppSetting;
use App\Models\CommissionTransaction;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class CommissionTransactionController extends Controller
{
    public function store(Request $request)
    {

        try {
            $request->validate([
                'transaction_id' => 'required',
                'user_id' => 'required|exists:users,id',
                'product_id' => 'required|exists:products,id',
                'time' => 'required|date',
                'total_amount' => 'nullable|numeric',
            ]);
        }  catch (ValidationException $e) {
            $errorMessage = $e->validator->errors()->first();
            return $this->sendResponse(400, '', $errorMessage);
        }
        $app = Product::find($request->product_id)->app;
        $commission_percentage = AppSetting::where('key', "commission_$app")->first();
        if($commission_percentage){
            $commission_percentage = $commission_percentage->pluck('value_ar');
        }else{
            $commission_percentage = 0;
        }

        $commissionTransaction = CommissionTransaction::create([
            'transaction_id' => $request->transaction_id,
            'user_id' => $request->user_id,
            'product_id' => $request->product_id,
            'time' => $request->time,
            'total_amount' => $request->total_amount,
            'commission_percentage' => $commission_percentage,
            'app' => $app,
        ]);
        // return response()->json(['message' => 'Commission transaction created successfully', 'data' => $commissionTransaction], 201);
        return $this->sendResponse(200, '', __('Commission transaction created successfully'));

    }
}
