<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePlansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('plans', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();
            $table->string('periodo_id', 4);
            $table->integer('unidad_gestion_id');
            $table->enum('tipo_plan', ['anual', 'trimestral'])->nullable(false);
            $table->date('fecha_inicio');
            $table->date('fecha_final');
            $table->integer('trimestre');
            $table->boolean('aprobado');
            $table->boolean('activo');
            $table->boolean('cerrado');

            $table->foreign('periodo_id')->references('id')->on('periodos')->onDelete('cascade');
            $table->foreign('unidad_gestion_id')->references('id')->on('unidad_gestions')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('plans');
    }
}
