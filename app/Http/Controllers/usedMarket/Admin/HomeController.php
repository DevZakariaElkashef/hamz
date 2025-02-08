<?php

namespace App\Http\Controllers\usedMarket\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{

    public function __construct()
    {
        $this->middleware('can:usedmarket.dashboard.index');
    }

    public function index()
    {
        $categoriesCount = Category::usedMarket()->active()->count();
        $productsCount = Product::usedMarket()->active()->count();
        $acceptProductsCount = Product::usedMarket()->active()->where('status', 1)->count();
        $newAds = Product::usedMarket()->active()->where('status', 1)
        ->orderBy('created_at', 'DESC')
        ->limit(5)
        ->get();
        $favAds = Product::usedMarket()->active()
        ->withCount('commenets')
        ->withAvg('commenets', 'rate')
        ->orderBy('commenets_avg_rate', 'DESC')
        ->limit(5)
        ->get();
        return view('usedMarket.index',  compact('categoriesCount', 'productsCount', 'acceptProductsCount', 'newAds', 'favAds'));
    }
}
