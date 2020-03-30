<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Programa extends Model
{
	use SoftDeletes;
	
	protected $guarded = ['finalizado', 'fecha_finalizado'];

    public function proyectos(){
    	return $this->hasMany('App\Models\Proyecto');
    }

    public function unidadesGestion(){
    	return $this->belongsToMany('App\Models\UnidadGestion');
    }
}
