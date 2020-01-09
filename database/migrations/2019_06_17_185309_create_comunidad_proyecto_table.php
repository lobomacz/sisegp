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
            $table->integer('adolescentes_masculinos')->default(0);
            $table->integer('adolescentes_femeninos')->default(0);
            $table->integer('jovenes_masculinos')->default(0);
            $table->integer('jovenes_femeninos')->default(0);
            $table->integer('hombres')->default(0);
            $table->integer('mujeres')->default(0);
            $table->integer('miskitu')->default(0);
            $table->integer('mestizo')->default(0);
            $table->integer('rama')->default(0);
            $table->integer('creole')->default(0);
            $table->integer('garifuna')->default(0);
            $table->integer('ulwa')->default(0);
            $table->integer('ancianos')->default(0);
            $table->integer('discapacitados')->default(0);
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
        Schema::dropIfExists('comunidad_proyecto');
    }
}
