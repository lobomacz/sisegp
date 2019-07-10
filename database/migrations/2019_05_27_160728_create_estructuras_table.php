<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEstructurasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('estructuras', function (Blueprint $table) {
            $table->increments('id');
            $table->char('codigo', 3);
            $table->unsignedInteger('estructura_id');
            $table->string('nombre', 150)->nullable(false);
            $table->boolean('programa');
            $table->boolean('subprograma');
            $table->boolean('proyecto');
            $table->boolean('actividad');
            $table->boolean('obra');
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
        Schema::dropIfExists('estructuras');
    }
}
