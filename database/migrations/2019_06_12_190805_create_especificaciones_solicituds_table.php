<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEspecificacionesSolicitudsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('especificaciones_solicituds', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();
            $table->bigInteger('solicitud_id');
            $table->integer('item')->nullable(false);
            $table->string('codigo', 5)->nullable(false);
            $table->string('descripcion', 100)->nullable(false);
            $table->integer('unidad_medida_id');
            $table->float('cantidad', 8, 2)->nullable(false);

            $table->foreign('solicitud_id')->references('id')->on('solicituds');
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
        Schema::dropIfExists('especificaciones_solicituds');
    }
}
