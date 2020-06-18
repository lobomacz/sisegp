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
            $table->unsignedBigInteger('plan_id');
            $table->unsignedBigInteger('producto_id');
            $table->decimal('meta', 7, 2);
            $table->enum('consolidado_anual',['sumatoria','porcentaje','maxima', 'promedio','permanente']);
            $table->decimal('logros', 7, 2)->nullable();
            $table->string('situacion_inicial', 500)->nullable();
            $table->string('situacion_resultado', 500)->nullable();
            $table->string('dificultades', 500)->default('ninguna');
            $table->string('soluciones', 500)->nullable();
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
        Schema::dropIfExists('plan_producto');
    }
}
