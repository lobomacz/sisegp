<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    //
    public function periodos(){
    	return $this->belongsTo('App/Models/Periodo');
    }

    public function unidadGestion(){
    	return $this->belongsTo('App/Models/UnidadGestion');
    }

    public function planProductos(){
    	return $this->hasMany('App/Models/PlanProducto');
    }

    public function productos(){
    	return $this->belongsToMany('App/Models/Producto');
    }
}
