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
            $table->enum('tipo_solicitud', ['gastos','proceso por concurso', 'proceso de ejecución de obra', 'compra menor para bienes', 'compra menor para servicios'])->nullable(false);
            $table->unsignedInteger('unidad_gestion_id');
            $table->unsignedBigInteger('actividad_insumo_id');
            $table->string('justificacion', 400);
            $table->date('fecha');
            $table->decimal('monto',9,2);
            $table->enum('fuente', ['TESORO','COOPERACIÓN','FONDOS PROPIOS','TRAMITE AMBIENTAL']);
            $table->unsignedInteger('funcionario_id');
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
            $table->timestamps();
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
