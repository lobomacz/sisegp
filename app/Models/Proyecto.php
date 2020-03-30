<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Proyecto extends Model
{
    use SoftDeletes;

    protected $guarded = ['fecha_final', 'ejecutado'];

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
