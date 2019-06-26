<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comunidad extends Model
{
    public function municipio(){
    	return $this->belongsTo('App/Models/Municipio');
    }

    public function proyectos(){
    	return $this->belongsToMany('App/Models/Proyecto');
    }
}
