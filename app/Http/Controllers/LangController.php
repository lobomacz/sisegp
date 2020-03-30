<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LangController extends Controller
{
    //
    public function lang(Request $request, $lang){

        \App::setLocale($lang);

        \Session::put('applang', $lang);

        return redirect($request->backroute);
    }
}
