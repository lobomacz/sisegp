<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Solicitud extends Model
{
    //

    public function solicitante(){
    	return $this->belongsTo('App/Models/Funcionario');
    }

    public function actividadInsumo(){
    	return $this->belongsTo('App/Models/ActividadInsumo');
    }

    public function especificaciones(){
    	return $this->hasMany('App/Models/EspecificacionesSolicitud');
    }

    public function documentos(){
    	return $this->belongsToMany('App/Models/Documentos');
    }
}
