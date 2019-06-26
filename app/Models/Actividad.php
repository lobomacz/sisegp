<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Actividad extends Model
{

    protected $table = 'actividades';

    public function producto(){
    	return $this->belongsTo('App/Models/Producto');
    }

    public function insumos(){
    	return $this->hasMany('App/Models/ActividadInsumo');
    }

    public function planProductos(){
    	return $this->belongsToMany('App/Models/PlanProducto');
    }

    public function documentos(){
        return $this->belongsToMany('App/Models/Documento');
    }

    public function fotos(){
        return $this->belongsToMany('App/Models/Foto');
    }
}
