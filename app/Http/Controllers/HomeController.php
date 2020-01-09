<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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
    public function index()
    {
        return view('home', ['backroute' => 'Home']);
    }

    public function digitacion(){

        return view('landingpage.digitacion', ['backroute' => 'Digitacion']);
    }

    public function gestion(){

        $funcionario = Auth::user()->funcionario;

        return view('landingpage.gestion', ['backroute' => 'Gestion', 'funcionario' => $funcionario]);
    }

    public function reportes(){
        return view('landingpage.reportes', ['backroute' => 'Reportes']);
    }

}
