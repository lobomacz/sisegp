<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('productos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();
            $table->bigInteger('resultado_id');
            $table->string('codigo_producto', 5);
            $table->string('descripcion', 400);
            $table->string('formula', 200);
            $table->integer('unidad_medida_id');

            $table->primary('id');
            $table->foreign('resultado_id')->references('id')->on('resultados')->onDelete('cascade');
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
        Schema::dropIfExists('productos');
    }
}
