<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class PeriodoUnidadResultado extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('periodo_unidad_resultado', function(Blueprint $table){

            $table->bigIncrements('id');
            $table->unsignedBigInteger('periodo_unidad_id');
            $table->unsignedBigInteger('resultado_id');
            $table->string('balance', 2000)->nullable();

            $table->foreign('periodo_unidad_id')->references('id')->on('periodo_unidads')->onDelete('cascade');
            $table->foreign('resultado_id')->references('id')->on('resultados')->onDelete('set_null');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
