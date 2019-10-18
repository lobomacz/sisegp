<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UnidadGestion extends Model
{
    //
    
    public function estructura(){
    	return $this->belongsTo('App/Models/Estructura');
    }

    public function dependencias(){
    	return $this->hasMany('App/Models/UnidadGestion');
    }

    public function allDependencias(){
        return $this->dependencias()->with('allDependencias');
    }

    public function funcionarios(){
        return $this->hasMany('App/Models/Funcionario');
    }

    public function programas(){
    	return $this->belongsToMany('App/Models/Programa');
    }

    public function proyectos(){
    	return $this->belongsToMany('App/Models/Proyecto');
    }

    public function asignada(){
        return !($this->programas() == null && $this->proyectos() == null);
    }

    public function planes(){
        return $this->hasMany('App/Models/Plan');
    }

    public function solicitudes(){
        return $this->hasMany('App/Models/Solicitud');
    }
}
