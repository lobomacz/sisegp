<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PeriodoUnidad extends Model
{
    //
    protected $fillable = ['periodo_id', 'unidad_gestion_id'];

    public function periodo(){
    	return $this->belongsTo('App\Models\Periodo');
    }

    public function unidadGestion(){
    	return $this->belongsTo('App\Models\UnidadGestion');
    }

    public function resultados(){
    	return $this->belongsToMany('App\Models\Resultado')->withPivot('balance');
    }

    public function personal(){
        return $this->belongsToMany('App\Models\Personal')->withPivot('personas', 'salario', 'treceavo', 'antiguedad', 'patronal', 'inatec', 'beneficios', 'vacaciones', 'otros_beneficios', 'horas_extra')->withTimestamps();
    }

    public function planes(){
    	return this->hasMany('App\Models\Plan');
    }
}
