<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePlansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('plans', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('periodo_id', 4);
            $table->unsignedInteger('unidad_gestion_id');
            $table->enum('tipo_plan', ['anual', 'trimestral']);
            $table->date('fecha_inicio');
            $table->date('fecha_final');
            $table->integer('trimestre')->nullable();
            $table->boolean('aprobado')->default(false);
            $table->boolean('activo')->default(true);
            $table->boolean('cerrado')->default(false);
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
        Schema::dropIfExists('plans');
    }
}
