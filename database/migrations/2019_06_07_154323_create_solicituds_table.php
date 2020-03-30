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
            $table->date('fecha');
            $table->enum('tipo_solicitud', ['gastos','proceso por concurso', 'proceso de ejecución de obra', 'compra menor para bienes', 'compra menor para servicios'])->nullable(false);
            $table->unsignedInteger('unidad_gestion_id');
            $table->unsignedBigInteger('actividad_insumo_id');
            $table->string('justificacion', 400); //justificación de cantidad y calidad solicitados
            $table->decimal('monto', 11, 2);
            $table->enum('fuente', ['tesoro','cooperación','fondos propios','trámite ambiental']);
            $table->unsignedInteger('funcionario_id')->nullable();
            $table->string('solicitante', 100);
            $table->string('observaciones', 400);
            $table->float('existencia', 8, 2)->nullable();
            $table->date('fecha_almacen')->nullable();
            $table->boolean('revisado')->default(false);
            $table->boolean('autorizado')->default(false);
            $table->boolean('procesado')->default(false);
            $table->boolean('anulado')->default(false);
            $table->dateTime('fecha_hora_revisado')->nullable();
            $table->dateTime('fecha_hora_autorizado')->nullable();
            $table->dateTime('fecha_hora_procesado')->nullable();
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
