<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateActividadPlanProductoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('actividad_plan_producto', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('plan_producto_id');
            $table->bigInteger('actividad_id');
            $table->date('fecha_programada');
            $table->timestamps();

            $table->foreign('plan_producto_id')->references('id')->on('plan_producto')->onDelete('cascade');
            $table->foreign('actividad_id')->references('id')->on('actividades');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('actividad_plan_producto');
    }
}
