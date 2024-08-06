<?php

namespace App\Http\Controllers\Mall\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        return view("mall.index");
    }
}
