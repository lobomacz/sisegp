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
            $table->unsignedInteger('programa_id');
            $table->string('codigo_proyecto', 25);
            $table->string('descripcion', 400)->charset('utf8');
            $table->date('fecha_inicio')->nullable();
            $table->date('fecha_final')->nullable();
            $table->unsignedInteger('sector_desarrollo_id');
            $table->decimal('monto_presupuesto', 20, 2);
            $table->boolean('en_ejecucion')->default(true);
            $table->boolean('ejecutado')->default(false);
            $table->timestamps();

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
