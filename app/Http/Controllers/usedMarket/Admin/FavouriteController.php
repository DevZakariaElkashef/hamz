<?php

namespace App\Http\Controllers\usedMarket\Admin;

use App\Http\Controllers\Controller;
use App\Models\Favourite;
use Illuminate\Http\Request;

class FavouriteController extends Controller
{
    public function favourite()
    {
        $favourites = Favourite::usedMarket()->latest()->paginate(10);
        return view('usedMarket.favourite.index', compact('favourites'));
    }
    public function delete(Request $request)
    {
        $request->validate([
            'favouriteId' => 'required|exists:favourites,id'
        ]);
        $favourite = Favourite::find($request->favouriteId);
        $favourite->delete();
        return back()->with('done', 'تم حذف المفضله بنجاح');
    }
}
