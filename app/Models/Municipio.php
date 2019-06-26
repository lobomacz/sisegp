<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Municipio extends Model
{
    public function comunidades(){
    	return $this->hasMany('App/Models/Comunidad');
    }

    public function comunidadesProyectos(){
    	return $this->comunidades()->with('proyectos');
    }
}
