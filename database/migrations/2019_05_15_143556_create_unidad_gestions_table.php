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
            $table->unsignedInteger('estructura_id');
            $table->string('nombre', 100)->nullable(false);
            $table->boolean('direccion_coordinacion');
            $table->unsignedInteger('unidad_gestion_id');
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
        Schema::dropIfExists('unidad_gestions');
    }
}
