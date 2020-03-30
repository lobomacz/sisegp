<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Libreria\MenuBuilder;
use Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth', 'language']);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(MenuBuilder $mbuilder)
    {
        return view('home', ['menu_list' => $mbuilder->getMenu()]);
    }

}
