<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProgramaUnidadGestionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('programa_unidad_gestion', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();
            $table->integer('programa_id');
            $table->integer('unidad_gestion_id');

            $table->foreign('programa_id')->references('id')->on('programas')->onDelete('cascade');
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
        Schema::dropIfExists('programa_unidad_gestion');
    }
}
