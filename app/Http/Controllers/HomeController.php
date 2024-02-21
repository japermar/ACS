<?php

namespace App\Http\Controllers;

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
        $user = auth()->user();
        $grupos = $user->grupos()->get()->toArray();
        $actividades = $user->actividades()->get()->toArray();
//        var_dump($grupos);
        return view('home', compact(['grupos', 'user', 'actividades']));
    }
}
