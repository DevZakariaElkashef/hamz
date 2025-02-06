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
        return view('rfoof.index', compact('categoriesCount', 'productsCount'));
    }
}
