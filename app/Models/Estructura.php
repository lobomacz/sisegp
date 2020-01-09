<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Estructura extends Model
{
    public function dependencias(){
    	return $this->hasMany('App\Models\Estructura');
    }

    public function allDependencias(){
    	return $this->dependencias()->with('allDependencias');
    }

    public function unidadGestion(){
    	return $this->hasOne('App\Models\UnidadGestion');
    }
}
