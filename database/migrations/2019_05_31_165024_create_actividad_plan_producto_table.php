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
            $table->unsignedBigInteger('plan_producto_id');
            $table->unsignedBigInteger('actividad_id');
            $table->date('fecha_programada');
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
        Schema::dropIfExists('actividad_plan_producto');
    }
}
