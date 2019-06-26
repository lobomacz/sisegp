<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Clasificador extends Model
{
    protected $keyType = 'string';

    public function children(){
    	return $this->hasMany('App/Models/Clasificador');
    }

    public function allChildren(){
    	return $this->children()->with('allChildren');
    }

    public function insumos(){
    	return $this->hasMany('App/Models/Insumo');
    }
}
