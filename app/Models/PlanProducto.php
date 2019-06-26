<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PlanProducto extends Model
{
    //
    protected $table = 'plan_producto';

    public function plan(){
    	return $this->belongsTo('App/Models/Plan');
    }

    public function producto(){
    	return $this->belongsTo('App/Models/Producto');
    }

    public function actividadesPlanProductos(){
    	return $this->hasMany('App/Models/ActividadPlanProducto');
    }

    public function actividades(){
    	return $this->belongsToMany('App/Models/Actividad');
    }
}
