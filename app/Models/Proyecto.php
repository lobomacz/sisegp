<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Proyecto extends Model
{

    public function programa(){
    	return $this->belongsTo('App\Models\Programa');
    }

    public function unidadesGestion(){
    	return $this->belongsToMany('App\Models\UnidadGestion');
    }

    public function sectorDesarrollo(){
    	return $this->belongsTo('App\Models\SectorDesarrollo');
    }

    public function comunidades(){
    	return $this->belongsToMany('App\Models\Comunidad');
    }

    public function resultados(){
        return $this->hasMany('App\Models\Resultado');
    }
}
