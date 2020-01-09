<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SectorDesarrollo extends Model
{
    public function proyectos(){
    	return $this->hasMany('App\Models\Proyecto');
    }
}
