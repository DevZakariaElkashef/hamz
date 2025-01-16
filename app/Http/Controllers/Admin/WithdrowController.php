<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Withdrow;
use App\Repositories\WithdrowRepository;
use Illuminate\Http\Request;

class WithdrowController extends Controller
{
    protected $withdrowRepository;

    public function __construct(WithdrowRepository $withdrowRepository)
    {
        $this->withdrowRepository = $withdrowRepository;

        // autherization
        $this->middleware('can:hamz.withdrows.index');
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $withdrows = $this->withdrowRepository->index($request);
        return view('withdrows.index', compact('withdrows'));
    }

    public function search(Request $request)
    {
        $withdrows = $this->withdrowRepository->search($request);
        return view('withdrows.table', compact('withdrows'))->render();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        abort(404);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        abort(404);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return to_route('withdrows.edit');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Withdrow $withdrow)
    {
        return view('withdrows.edit', compact('withdrow'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Withdrow $withdrow)
    {
        $this->withdrowRepository->update($request, $withdrow);
        return to_route('withdrows.index')->with('success', __("main.updated_successffully"));
    }

    public function toggleStatus(Request $request, Withdrow $withdrow)
    {
        $old_status = $withdrow->status;
        $withdrow->update(['status' => $request->status]);
        $wallet = ($withdrow->wallet_type == '0') ? 'wallet' : 'watch_and_earn_wallet';

        $user = User::findOrFail($withdrow->user_id);
        $amount = 0;
        if($withdrow->wallet_type == '1' && $withdrow->withdraw_type == '0') {
            $amount = $withdrow->amount;
        }

        if($withdrow->status == '1' && $old_status != '1') {
            $user->update([
                "wallet" => $user->wallet + $amount,
                "$wallet" => $user->$wallet - $withdrow->amount
            ]);
        } elseif($withdrow->status != '1' && $old_status == '1') {
            $user->update([
                "wallet" => $user->wallet - $amount,
                "$wallet" => $user->$wallet + $withdrow->amount
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => __("main.updated_successffully"),
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Withdrow $withdrow)
    {
        $this->withdrowRepository->delete($withdrow);
        return to_route('withdrows.index')->with('success', __("main.delete_successffully"));
    }

    public function delete(Request $request)
    {
        $this->withdrowRepository->deleteSelection($request);
        return to_route('withdrows.index')->with('success', __("main.delete_successffully"));
    }
}
