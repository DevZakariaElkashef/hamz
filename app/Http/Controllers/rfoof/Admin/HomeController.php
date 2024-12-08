<?php

namespace App\Http\Controllers\rfoof\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:rfoof.dashboard.index');
    }

    public function index()
    {
        return view('rfoof.index');
    }
}
