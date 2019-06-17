<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUnidadGestionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('unidad_gestions', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('estructura_id');
            $table->string('nombre', 100)->nullable(false);
            $table->timestamps();
            $table->boolean('direccion_coordinacion');
            $table->integer('unidad_gestion_id');

            $table->foreign('estructura_id')->references('id')->on('estructuras')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('unidad_gestions');
    }
}
