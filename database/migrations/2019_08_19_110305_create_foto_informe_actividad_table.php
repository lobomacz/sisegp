<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFotoInformeActividadTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('foto_informe_actividad', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('foto_id');
            $table->unsignedBigInteger('informe_actividad_id');
            $table->timestamps();

            $table->foreign('foto_id')->references('id')->on('fotos')->onDelete('cascade');
            $table->foreign('informe_actividad_id')->references('id')->on('informe_actividads')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('foto_informe_actividad');
    }
}
