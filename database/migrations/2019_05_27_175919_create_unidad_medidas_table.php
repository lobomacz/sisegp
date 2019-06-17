<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUnidadMedidasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('unidad_medidas', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->char('abreviatura', 5);
            $table->string('descripcion', 45);
            $table->enum('tipo_escala', ['peso', 'fluido', 'longitud', 'volumen', 'energia', 'otro']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('unidad_medidas');
    }
}
