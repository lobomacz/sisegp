<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Resultado extends Model
{
	
	protected $guarded = ['id', 'aprobado'];

    public function proyecto(){
    	return $this->belongsTo('App\Models\Proyecto');
    }

    public function unidadMedida(){
    	return $this->belongsTo('App\Models\UnidadMedida');
    }

    public function productos(){
    	return $this->hasMany('App\Models\Producto');
    }
}
