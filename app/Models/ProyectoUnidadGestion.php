<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProyectoUnidadGestion extends Model
{
    //
	protected $table = 'proyecto_unidad_gestion';

	public function unidades_gestion(){
		return $this->belongsTo('App/Models/UnidadGestion');
	}

	public function proyectos(){
		return $this->belongsTo('App/Models/Proyecto');
	}

}
