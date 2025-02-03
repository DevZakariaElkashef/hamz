<?php

namespace App\Http\Controllers\rfoof\Admin;

use App\Http\Controllers\Controller;
use App\Models\Complains;
use Illuminate\Http\Request;

class ComplainController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:rfoof.complains.index');
    }

    public function complains()
    {
        $complains = Complains::rfoof()->where('status', 0)->latest()->paginate(10);
        return view('rfoof.complains.index', compact('complains'));
    }
    public function old()
    {
        $complains = Complains::rfoof()->where('status', 1)->latest()->paginate(10);
        return view('rfoof.complains.old', compact('complains'));
    }
    public function delete(Request $request)
    {
        $request->validate([
            'complainId' => 'required|exists:complains,id',
        ]);
        Complains::rfoof()->where('id', $request->complainId)->delete();
        return redirect()->route('rfoof.complains')->with('message', 'تم حذف الشكوي بنجاح');
    }
    public function show($id) {
        $complain = Complains::find($id);
        if($complain){
            $complain->update(['status' => 1]);
            return view('rfoof.complains.show', compact('complain'));
        }
        abort(404);
    }

    public function read_all() {
        Complains::where('app', 'rfoof')
        ->where('status', 0)
        ->update(['status' => 1]);
        return redirect()->route('rfoof.complains')->with('success', __('main.read_all_success'));
    }

}
