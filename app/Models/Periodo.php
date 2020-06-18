<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Periodo extends Model
{
    protected $keyType = 'string';

    public function periodosUnidades(){
        return $this->hasMany('App\Models\PeriodoUnidad');
    }

    /*
    public function periodoAnterior(){
    	return $this->belongsTo('App\Models\Periodo', 'periodo_anterior');
    }

    public function periodoSiguiente(){
    	return $this->hasOne('App\Models\Periodo', 'periodo_anterior');
    }
    

    public function planes(){
    	return $this->hasMany('App\Models\Plan');
    }
    */
}
