<?php

namespace App\Http\Controllers\usedMarket\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HomeController extends Controller
{

    public function __construct()
    {
        $this->middleware('can:usedmarket.dashboard.index');
    }

    public function index()
    {
        return view('usedMarket.index');
    }
}
