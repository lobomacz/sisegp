<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Programa extends Model
{
    public function proyectos(){
    	return $this->hasMany('App\Models\Proyecto');
    }

    public function unidadesGestion(){
    	return $this->belongsToMany('App\Models\UnidadGestion');
    }
}
