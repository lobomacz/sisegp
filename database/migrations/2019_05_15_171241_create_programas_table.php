<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProgramasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('programas', function (Blueprint $table) {
            $table->increments('id');
            $table->string('codigo_programa', 25);
            $table->string('descripcion', 200);
            $table->string('objetivo_general', 1000);
            $table->boolean('finalizado')->default(false);
            $table->date('fecha_finalizado')->nullable();
            $table->timestamps();
            
            $table->unique('codigo_programa');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('programas');
    }
}
