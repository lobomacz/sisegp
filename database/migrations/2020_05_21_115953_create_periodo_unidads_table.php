<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePeriodoUnidadsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('periodo_unidads', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('periodo_id', 4);
            $table->unsignedInteger('unidad_gestion_id');
            $table->boolean('activado')->default(false);
            $table->boolean('abierto')->default(true);
            $table->timestamps();

            $table->foreign('periodo_id')->references('id')->on('periodos')->onDelete('restrict');

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
        Schema::dropIfExists('periodo_unidads');
    }
}
