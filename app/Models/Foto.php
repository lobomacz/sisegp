<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Foto extends Model
{
	protected $guarded = ['id'];
	
    protected $directorio = '/fotos';
}
