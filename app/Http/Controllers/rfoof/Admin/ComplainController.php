<?php

namespace App\Http\Controllers\rfoof\Admin;

use App\Http\Controllers\Controller;
use App\Models\Complains;
use Illuminate\Http\Request;

class ComplainController extends Controller
{
    public function complains($status)
    {
        $complains = Complains::rfoof()->where('status', $status)->latest()->paginate(10);
        foreach ($complains as $key => $complain) {
            $complain->update(['status' => 1]);
        }
        return view('rfoof.complains.index', compact('complains', 'status'));
    }
    public function delete(Request $request)
    {
        $request->validate([
            'complainId' => 'required|exists:complains,id',
        ]);
        Complains::where('id', $request->complainId)->delete();
        return back()->with('message', 'تم حذف الشكوي بنجاح');
    }
}
