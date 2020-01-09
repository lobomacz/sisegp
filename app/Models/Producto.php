<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    public function resultado(){
    	return $this->belongsTo('App\Models\Resultado');
    }

    public function unidadMedida(){
    	return $this->belongsTo('App\Models\UnidadMedida');
    }

    public function actividades(){
    	return $this->hasMany('App\Models\Actividad');
    }

    public function planes(){
        return $this->belongsToMany('App\Models\Plan');
    }
}
