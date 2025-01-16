<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Traits\ApiResponse;

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
}
