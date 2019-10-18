<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInformeActividadsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('informe_actividads', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('actividad_id')->nullable(false);
            $table->date('fecha_realizada')->nullable(false);
            $table->string('dificultades', 1000);
            $table->string('soluciones', 1000);
            $table->unsignedInteger('beneficiarios_directos')->nullable(false);
            $table->unsignedInteger('beneficiarios_indirectos')->nullable(false);
            $table->unsignedInteger('hombres')->nullable(false);
            $table->unsignedInteger('mujeres')->nullable(false);
            $table->unsignedInteger('ninos')->nullable(false);
            $table->unsignedInteger('ninas')->nullable(false);
            $table->unsignedInteger('jovenes_m')->nullable(false);
            $table->unsignedInteger('jovenes_f')->nullable(false);
            $table->unsignedInteger('adulto_mayor_m')->nullable(false);
            $table->unsignedInteger('adulto_mayor_f')->nullable(false);
            $table->unsignedInteger('discapacitados')->nullable(false);
            $table->timestamps();

            $table->foreign('actividad_id')->references('id')->on('actividades')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('informe_actividads');
    }
}
