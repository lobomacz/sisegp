<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInsumosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('insumos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('clasificador_id', 5);
            $table->timestamps();
            $table->string('nombre', 45);
            $table->integer('unidad_medida_id');

            $table->primary('id');
            $table->foreign('clasificador_id')->references('id')->on('clasificadors');
            $table->foreign('unidad_medida_id')->references('id')->on('unidad_medidas');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('insumos');
    }
}
