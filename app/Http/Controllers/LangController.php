<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LangController extends Controller
{
    //
    public function lang($lang, $backroute){

        \App::setLocale($lang);

        \Session::put('applang', $lang);

        return redirect()->route($backroute);
    }
}
