<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProyectosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('proyectos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();
            $table->integer('programa_id');
            $table->string('codigo_proyecto', 25);
            $table->string('descripcion', 400)->charset('utf8');
            $table->date('fecha_inicio')->nullable();
            $table->date('fecha_final')->nullable();
            $table->decimal('monto_presupuesto', 20, 2);
            $table->boolean('en_ejecucion');
            $table->boolean('ejecutado');

            $table->primary('id');
            $table->foreign('programa_id')->references('id')->on('programas')->onDelete('cascade');
            $table->unique('codigo_proyecto');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('proyectos');
    }
}
