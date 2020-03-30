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
            $table->string('codigo', 45);
            $table->string('acronimo', 25);
            $table->string('descripcion', 250)->charset('utf8');
            $table->string('objetivo', 1000)->charset('utf8')->nullable();
            $table->date('fecha_inicio');
            $table->date('fecha_final')->nullable();
            $table->unsignedInteger('sector_desarrollo_id');
            $table->decimal('presupuesto', 20, 2);
            $table->boolean('ejecutado')->default(false);
            $table->timestamps();
            $table->softDeletes();

            $table->unique('codigo');
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
