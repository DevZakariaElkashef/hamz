<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Withdraws\MakeWithdrawRequest;
use App\Models\Order;
use App\Models\User;
use App\Models\Withdrow;
use Illuminate\Support\Facades\DB;

class WalletController extends Controller
{
    public function index()
    {
        $balance = User::select('wallet')->where('role_id', '3')->findOrFail(auth()->id())->wallet;

        $mallProfit = Order::join('stores', 'stores.id', '=', 'orders.store_id')
            ->where('stores.user_id', auth()->id())
            ->where('orders.app', 'mall')
            ->where('orders.order_status_id', '4')
            ->sum(DB::raw('orders.total - (orders.total / 100 * orders.management_ratio)'), 'amount');

        $boothProfit = Order::join('stores', 'stores.id', '=', 'orders.store_id')
            ->where('stores.user_id', auth()->id())
            ->where('orders.app', 'booth')
            ->where('orders.order_status_id', '4')
            ->sum(DB::raw('orders.total - (orders.total / 100 * orders.management_ratio)'), 'amount');

        $withdraws = Withdrow::select('id', 'wallet_type', 'withdraw_type', 'iban', 'amount', 'status', 'created_at')
            ->where('user_id', auth()->user()->id)
            ->paginate($request->per_page ?? 10);

        return view('wallet.index', get_defined_vars());
    }

    /*----------------------------------------------------------------------------------------------------*/

    public function makeWithdraw(MakeWithdrawRequest $request)
    {
        $user = auth()->user();

        if ($user->wallet < $request->amount) {
            session()->flash('error', __("messages.insufficient_balance_wallet"));
            return redirect()->back();
        }

        Withdrow::create([
            'user_id' => auth()->id(),
            'wallet_type' => 0,
            'withdraw_type' => 1,
            'iban' => $request->iban,
            'amount' => $request->amount
        ]);

        session()->flash('success', __("main.withdrow_sent_to_admin"));
        return redirect()->back();
    }
}
