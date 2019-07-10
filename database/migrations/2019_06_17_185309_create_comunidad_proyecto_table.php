<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateComunidadProyectoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comunidad_proyecto', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('comunidad_id');
            $table->unsignedBigInteger('proyecto_id');
            $table->integer('beneficiarios');
            $table->integer('familias');
            $table->integer('ninos');
            $table->integer('ninas');
            $table->integer('adolescentes_masculinos');
            $table->integer('adolescentes_femeninos');
            $table->integer('jovenes_masculinos');
            $table->integer('jovenes_femeninos');
            $table->integer('hombres');
            $table->integer('mujeres');
            $table->integer('miskitu');
            $table->integer('mestizo');
            $table->integer('rama');
            $table->integer('creole');
            $table->integer('garifuna');
            $table->integer('ulwa');
            $table->integer('discapacitados');
            $table->timestamps();

            $table->foreign('comunidad_id')->references('id')->on('comunidads')->onDelete('cascade');
            $table->foreign('proyecto_id')->references('id')->on('proyectos')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('comunidad_proyecto');
    }
}
