<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\time; 

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $times = time::all();
        return view('viewTime', compact('times'));
    }
}
