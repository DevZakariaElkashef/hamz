<?php

namespace App\Http\Controllers\rfoof\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:rfoof.dashboard.index');
    }

    public function index()
    {
        $categoriesCount = Category::rfoof()->active()->count();
        $productsCount = Product::rfoof()->active()->count();
        $acceptProductsCount = Product::rfoof()->active()->where('status', 1)->count();
        $newAds = Product::rfoof()->active()->where('status', 1)
        ->orderBy('created_at', 'DESC')
        ->limit(5)
        ->get();
        $favAds = Product::rfoof()->active()
        ->withCount('commenets')
        ->withAvg('commenets', 'rate')
        ->orderBy('commenets_avg_rate', 'DESC')
        ->limit(5)
        ->get();
        return view('rfoof.index', compact('categoriesCount', 'productsCount', 'acceptProductsCount', 'newAds', 'favAds'));
    }
}
