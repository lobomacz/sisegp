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

    public function rol(){
    	return $this->belongsTo('App\Models\Rol');
    }

    public function tieneRol($rol){

    	//$hasRole = $this->rol()->where('descripcion', $rol)->first();

    	return $this->rol->descripcion === $rol;
        
    }

    public function tienePermiso($permiso){

        $permitido = $this->rol->permiso[$permiso] == true;


        /*
        foreach ($this->roles as $rol) {
            if($rol->permiso->$permiso === true){
                $permitido = true;
                break;
            }
        }
        */

        return $permitido;
    	
    }

}
