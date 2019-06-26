<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePlanProductoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('plan_producto', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('plan_id');
            $table->bitInteger('producto_id');
            $table->integer('meta')->nullable(false);
            $table->integer('logros')->default(0);
            $table->string('situacion_inicial', 500);
            $table->string('situacion_resultado', 500);
            $table->string('dificultades', 500);
            $table->string('soluciones', 500);
            $table->timestamps();

            $table->foreign('plan_id')->references('id')->on('plans')->onDelete('cascade');
            $table->foreign('producto_id')->references('id')->on('productos');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('plan_producto');
    }
}
