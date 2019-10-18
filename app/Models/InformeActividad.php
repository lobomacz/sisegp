<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InformeActividad extends Model
{
    //
    public function actividad(){
    	return $this->belongsTo('App/Models/Actividad');
    }

    public function documentos(){
    	return $this->belongsToMany('App/Models/Documento');
    }

    public function fotos(){
    	return $this->belongsToMany('App/Models/Foto');
    }
}
