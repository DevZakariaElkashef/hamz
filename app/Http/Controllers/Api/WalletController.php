<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Withdraws\MakeWithdrawRequest;
use App\Http\Resources\Earn\WithdrowResource;
use App\Models\User;
use App\Models\Withdrow;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class WalletController extends Controller
{
    use ApiResponse;

    public function index()
    {
        $wallets = User::select('wallet', 'watch_and_earn_wallet')
            ->where('id', auth()->user()->id)
            ->first();

        return $this->sendResponse(200, $wallets);
    }

    public function withdraws(Request $request)
    {
        $wallet_type = $request->query('wallet_type', '0');
        $withdraws = Withdrow::select('id', 'withdraw_type', 'amount', 'status', 'created_at')
            ->where('user_id', auth()->user()->id)
            ->where('wallet_type', $wallet_type)
            ->get();

        return $this->sendResponse(200, WithdrowResource::collection($withdraws));
    }

    public function make(MakeWithdrawRequest $request)
    {
        $wallet = ($request->wallet_type == '0') ? 'wallet' : 'watch_and_earn_wallet';
        $user = auth()->user();

        if($user->$wallet < $request->amount) {
            return $this->sendResponse(400, '', __('messages.insufficient_balance_wallet'));
        }

        Withdrow::create([
            'user_id' => $user->id,
            'wallet_type' => $request->wallet_type,
            'withdraw_type' => $request->withdraw_type,
            'iban' => $request->iban,
            'amount' => $request->amount
        ]);

        return $this->sendResponse(200, '', __("main.withdrow_sent_to_admin"));
    }
}
