<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    public function periodos(){
    	return $this->belongsTo('App/Models/Periodo');
    }

    public function unidadGestion(){
    	return $this->belongsTo('App/Models/UnidadGestion');
    }

    public function planProductos(){
    	return $this->hasMany('App/Models/PlanProducto');
    }

    public function planResultados(){
        return $this->hasMany('App/Models/PlanResultado');
    }

    public function resultados(){
        return $this->belongsToMany('App/Models/Resultado');
    }

    public function productos(){
    	return $this->belongsToMany('App/Models/Producto');
    }

    public function actividades(){
        return $this->belongsToMany('App/Models/Actividad');
    }

    public function serviciosPersonales(){
        return $this->hasMany('App/Models/ServicioPersonal');
    }

}
