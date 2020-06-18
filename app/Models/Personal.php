<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Personal extends Model
{
    public function clasificador(){
    	return $this->belongsTo('App\Models\Clasificador');
    }
}
