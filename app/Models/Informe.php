<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Informe extends Model
{
    //
    public function actividad(){
    	return $this->belongsTo('App\Models\Actividad');
    }

    public function documento(){
    	return $this->belongsTo('App\Models\Documento');
    }

    public function fotos(){
    	return $this->belongsToMany('App\Models\Foto');
    }
}
