<?php

namespace App\Http\Controllers;

use App\LogActivity;
use Illuminate\Http\Request;

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
        // aggiungo il log di attività
        LogActivity::addLog('Dashboard View');

        return view('home');
    }
}
