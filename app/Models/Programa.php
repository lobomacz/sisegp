<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Programa extends Model
{
    //

    public function proyectos(){
    	return $this->hasMany('App/Models/Proyecto');
    }

    public function unidades_gestion(){
    	return $this->belongsToMany('App/Models/UnidadGestion');
    }
}
