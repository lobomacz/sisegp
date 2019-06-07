<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProgramaUnidadGestion extends Model
{
    //
    protected $table = 'programa_unidad_gestion';

    public function programa(){
    	return $this->belongsTo('App/Models/Programa');
    }

    public function unidadGestion(){
    	return $this->belongsTo('App/Models/UnidadGestion');
    }
    
}
