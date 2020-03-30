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
            $table->string('codigo', 45);
            $table->string('acronimo', 25);
            $table->string('descripcion', 250)->charset('utf8');
            $table->string('objetivo', 1000)->charset('utf8')->nullable();
            $table->boolean('finalizado')->default(false);
            $table->date('fecha_finalizado')->nullable();
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
        Schema::dropIfExists('programas');
    }
}
