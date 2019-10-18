<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateActividadInsumoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('actividad_insumo', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('actividad_id');
            $table->unsignedBigInteger('insumo_id');
            $table->unsignedInteger('unidad_medida_id');
            $table->decimal('costo_unitario', 11, 2);
            $table->decimal('cantidad', 9, 2);
            $table->boolean('solicitado')->default(false);
            $table->boolean('utilizado')->default(false);
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
        Schema::dropIfExists('actividad_insumo');
    }
}
