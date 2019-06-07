<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ActividadPlanProducto extends Model
{
    //
    protected $table = 'actividad_plan_producto';

    public function actividades(){
    	return $this->belongsTo('App/Models/Actividad');
    }

    public function planProducto(){
    	return $this->belongsTo('App/Models/PlanProducto');
    }

}
