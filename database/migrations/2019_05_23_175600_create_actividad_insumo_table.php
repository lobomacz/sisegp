<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateActividadInsumoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('actividad_insumo', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();
            $table->bigInteger('actividad_id');
            $table->bigInteger('insumo_id');
            $table->integer('unidad_medida_id');
            $table->decimal('costo_unitario', 11, 2);
            $table->decimal('cantidad', 9, 2);
            $table->boolean('solicitado');
            $table->boolean('utilizado');

            $table->primary('id');
            $table->foreign('actividad_id')->references('id')->on('actividades')->onDelete('cascade');
            $table->foreign('insumo_id')->references('id')->on('insumos');
            $table->foreign('unidad_medida_id')->references('id')->on('unidad_medidas');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('actividad_insumo');
    }
}
