<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Insumo extends Model
{
    //

    public function actividades(){
    	return $this->belognsToMany('App/Models/Actividad');
    }

    public function clasificador(){
    	return $this->belongsTo('App/Models/Clasificador');
    }

    public function unidadBase(){
    	return $this->belongsTo('App/Models/UnidadMedida');
    }
}
