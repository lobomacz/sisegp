<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Funcionario extends Model
{
    public function unidadGestion(){
    	return $this->belongsTo('App\Models\UnidadGestion');
    }

    public function usuario(){
    	return $this->hasOne('App\User');
    }

    public function roles(){
    	return $this->belongsToMany('App\Models\Rol');
    }

    public function tieneRol($rol){

    	$hasRole = $this->roles()->where('descripcion', $rol)->first();
    	return ($hasRole != null);
        
    }

    public function tienePermiso($permiso){

        $permitido = false;

        foreach ($this->roles as $rol) {
            if($rol->permiso->$permiso === true){
                $permitido = true;
                break;
            }
        }

        return $permitido;
    	
    }

}
