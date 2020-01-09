<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rol extends Model
{
    public function funcionarios(){
    	return $this->belongsToMany('App\Models\Funcionario');
    }

    public function permiso(){
    	return $this->hasOne('App\Models\Permiso');
    }
}
