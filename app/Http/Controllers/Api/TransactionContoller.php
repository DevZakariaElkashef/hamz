<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\TransactionResource;
use App\Models\Order;
use App\Models\Withdrow;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransactionContoller extends Controller
{
    use ApiResponse;

    public function index(Request $request)
    {
        $wallet_type = $request->query('wallet_type', '0');
        $transactions = [];
        if ($wallet_type == '0') {
            $transactions1 = Withdrow::select('withdraw_type AS type', 'amount', DB::raw('NULL AS is_negative'), 'created_at')
                ->where('user_id', auth()->user()->id)
                ->where('wallet_type', $wallet_type)
                ->orWhere(function ($query) {
                    $query->where('user_id', auth()->user()->id)
                        ->where('wallet_type', '1')
                        ->where('withdraw_type', '0');
                })
                ->where('status', '1');

            $transactions2 = Order::select(
                DB::raw('(CASE WHEN app = "mall" THEN 2 ELSE 3 END) AS type'),
                'total As amount',
                DB::raw('(CASE WHEN order_status_id = "5" THEN 0 ELSE 1 END) AS is_negative'),
                'created_at'
            )
                ->where('payment_status', '1')
                ->where(function ($query) {
                    $query->where('order_status_id', '!=', '5')
                        ->where('payment_type', '1');
                })
                ->orWhere(function ($query) {
                    $query->where('order_status_id', '5')
                        ->where('payment_type', '0');
                });

            $transactions = $transactions1->union($transactions2)->latest()->get();
        } elseif ($wallet_type == '1') {
            $transactions = Withdrow::select('withdraw_type AS type', 'amount', DB::raw('NULL AS is_negative'), 'created_at')
                ->where('user_id', auth()->user()->id)
                ->where('wallet_type', $wallet_type)
                ->where('status', '1')
                ->latest()
                ->get();
        }

        return $this->sendResponse(200, TransactionResource::collection($transactions));
    }
}
