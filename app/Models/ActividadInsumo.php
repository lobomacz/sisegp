<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ActividadInsumo extends Model
{
    //

    protected $table = 'actividad_insumo';

    public function unidadMedida(){
    	return $this->belongsTo('App/Models/UnidadMedida');
    }

    public function insumo(){
    	return $this->belongsTo('App/Models/Insumo');
    }

    public function actividad(){
    	return $this->belongsTo('App/Models/Actividad');
    }
}
