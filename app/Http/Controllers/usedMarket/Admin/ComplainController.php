<?php

namespace App\Http\Controllers\usedMarket\Admin;

use App\Http\Controllers\Controller;
use App\Models\Complains;
use Illuminate\Http\Request;

class ComplainController extends Controller
{

    public function __construct()
    {
        $this->middleware('can:usedmarket.complains.index');
    }

    public function complains()
    {
        $complains = Complains::usedMarket()->where('status', 0)->latest()->paginate(10);
        return view('usedMarket.complains.index', compact('complains'));
    }
    public function old()
    {
        $complains = Complains::usedMarket()->where('status', 1)->latest()->paginate(10);
        return view('usedMarket.complains.old', compact('complains'));
    }
    public function delete(Request $request)
    {
        $request->validate([
            'complainId' => 'required|exists:complains,id',
        ]);
        Complains::usedMarket()->where('id', $request->complainId)->delete();
        return redirect()->route('usedMarket.complains')->with('message', 'تم حذف الشكوي بنجاح');
    }
    public function show($id) {
        $complain = Complains::find($id);
        if($complain){
            $complain->update(['status' => 1]);
            return view('usedMarket.complains.show', compact('complain'));
        }
        abort(404);
    }

    public function read_all() {
        Complains::where('app', 'resale')
        ->where('status', 0)
        ->update(['status' => 1]);
        return redirect()->route('usedMarket.complains')->with('success', __('main.read_all_success'));
    }

}
