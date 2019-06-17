<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DocumentoSolicitud extends Model
{
    //
    protected $table = 'documento_solicitud';

    public function documento(){
    	return $this->belongsTo('App/Models/Documento');
    }

    public function solicitud(){
    	return $this->belongsTo('App/Models/Solicitud');
    }
}
