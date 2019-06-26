<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Funcionario extends Model
{
    public function unidadGestion(){
    	return $this->belongsTo('App/Models/UnidadGestion');
    }

    public function usuario(){
    	return $this->hasOne('App/User');
    }

    public function rol(){
    	return $this->belongsToMany('App/Models/Rol');
    }

}
