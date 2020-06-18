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
            $table->unsignedBigInteger('periodo_unidad_id');
            //$table->unsignedInteger('unidad_gestion_id');
            //$table->enum('tipo', ['anl', 'tri']);
            $table->date('fecha_inicio');
            $table->date('fecha_final');
            $table->integer('trimestre')->nullable();
            $table->decimal('monto_aprobado', 11, 2)->nullable();
            $table->boolean('aprobado')->default(false);
            $table->boolean('activo')->default(false);  // disponible para elaborar planes trimestrales
            $table->boolean('cerrado')->default(false); // actividades ejecutadas y con informes
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
