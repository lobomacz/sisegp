<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateActividadDocumentoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('actividad_documento', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('actividad_id');
            $table->bigInteger('documento_id');
            $table->timestamps();

            $table->foreign('actividad_id')->references('id')->on('actividades')->onDelete('cascade');
            $table->foreign('documento_id')->references('id')->on('documentos')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('actividad_documento');
    }
}
