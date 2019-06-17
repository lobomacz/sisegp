<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSolicitudsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('solicituds', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();
            $table->enum('tipo_solicitud', ['gastos','proceso por concurso', 'proceso de ejecución de obra', 'compra menor para bienes', 'compra menor para servicios'])->nullable(false);
            $table->integer('unidad_gestion_id');
            $table->bigInteger('actividad_insumo_id');
            $table->string('justificacion', 400);
            $table->date('fecha');
            $table->decimal('monto',9,2);
            $table->enum('fuente', ['TESORO','COOPERACIÓN','FONDOS PROPIOS','TRAMITE AMBIENTAL']);
            $table->integer('funcionario_id');
            $table->string('observaciones', 400);
            $table->float('existencia', 8, 2);
            $table->date('fecha_almacen');
            $table->boolean('revisado_planificacion');
            $table->boolean('revisado_presupuesto');
            $table->boolean('autorizado');
            $table->boolean('aceptado');
            $table->dateTime('fecha_hora_revisado');
            $table->dateTime('fecha_hora_presupuesto');
            $table->dateTime('fecha_hora_autorizado');
            $table->dateTime('fecha_hora_aceptado');

            $table->foreign('actividad_insumo_id')->references('id')->on('actividad_insumo');
            $table->foreign('funcionario_id')->references('id')->on('funcionarios');
            $table->foreign('unidad_gestion_id')->references('id')->on('unidad_gestions');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('solicituds');
    }
}
