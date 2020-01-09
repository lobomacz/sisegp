<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInformesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('informes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('actividad_id');
            $table->date('fecha_realizada');
            $table->string('dificultades', 1000);
            $table->string('soluciones', 1000);
            $table->unsignedInteger('beneficiarios_directos');
            $table->unsignedInteger('beneficiarios_indirectos');
            $table->unsignedInteger('hombres');
            $table->unsignedInteger('mujeres');
            $table->unsignedInteger('ninos');
            $table->unsignedInteger('ninas');
            $table->unsignedInteger('jovenes_m');
            $table->unsignedInteger('jovenes_f');
            $table->unsignedInteger('adulto_mayor_m');
            $table->unsignedInteger('adulto_mayor_f');
            $table->unsignedInteger('discapacitados');
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
        Schema::dropIfExists('informes');
    }
}
