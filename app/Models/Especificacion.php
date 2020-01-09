<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Especificacion extends Model
{

    public function solicitud(){
    	return $this->belongsTo('App\Models\Solicitud');
    }

    public function unidadMedida(){
    	return $this->belongsTo('App\Models\UnidadMedida');
    }
}
