<?php

namespace App\Http\Controllers\usedMarket\Admin;

use App\Http\Controllers\Controller;
use App\Models\Commenets;
use App\Models\Product;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function comments()
    {
        $ads = Product::resale()->where('status', '!=', 4)->latest()->paginate(10);
        foreach ($ads as $ad) {
            $ad->countComment = Commenets::where('product_id', $ad->id)->count();
            $ad->rate = Commenets::where('product_id', $ad->id)->avg('rate');
        }
        return view('usedMarket.comments.comments', compact('ads'));
    }

    public function adsCommentes($adsId)
    {
        $comments = Commenets::where('product_id', $adsId)->latest()->paginate(10);
        return view('usedMarket.comments.view', compact('comments'));
    }
    public function userCommentes($seller_id)
    {
        $comments = Commenets::where('seller_id', $seller_id)->orderBy('id', 'DESC')->get();
        return view('usedMarket.comments.viewCommentsUsers', compact('comments'));
    }

    public function delete(Request $request)
    {
        $request->validate([
            'commenetId' => 'required|exists:comments,id',
        ]);

        Commenets::where('id', $request->commenetId)->delete();
        return back()->with('done', 'تم حذف التعليق بنجاح');
    }
}
