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
        return view('usedMarket.index', compact('categoriesCount', 'productsCount'));
    }
}
