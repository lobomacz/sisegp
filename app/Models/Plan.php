<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{

    protected $guarded = ['id', 'aprobado', 'activo', 'cerrado'];


    public function periodo(){
    	return $this->belongsTo('App\Models\PeriodoUnidad');
    }

    /*
    public function unidadGestion(){
    	return $this->belongsTo('App\Models\UnidadGestion');
    }

    
    public function resultados(){
        return $this->belongsToMany('App\Models\Resultado')->withTimestamps()->withPivot('balance');
    }
    */

    public function productos(){
    	return $this->belongsToMany('App\Models\Producto')->withTimestamps()->withPivot('meta', 'consolidado_anual', 'logros','situacion_inicial','situacion_resultado','dificultades','soluciones');
    }

    public function actividades(){
        return $this->belongsToMany('App\Models\Actividad')->withTimestamps()->withPivot('fecha_programada','ejecutada','fecha_ejecutada');
    }

    public function personal(){
        return $this->belongsToMany('App\Models\Personal')->withPivot('personas', 'salario')->withTimestamps();
    }

    public function documentos(){
        return $this->belongsToMany('App\Models\Documento')->withTimestamps();
    }

}
