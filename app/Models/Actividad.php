<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Actividad extends Model
{

    protected $table = 'actividades';

    public function producto(){
    	return $this->belongsTo('App\Models\Producto');
    }

    public function insumos(){
    	return $this->belongsToMany('App\Models\Insumo');
    }

    public function planes(){
    	return $this->belongsToMany('App\Models\Plan');
    }

    public function informe(){
        return $this->hasOne('App\Models\Informe');
    }
}
