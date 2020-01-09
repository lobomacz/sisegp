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
            $table->unsignedInteger('estructura_id')->nullable();
            $table->string('nombre', 150);
            $table->boolean('programa')->default(false);
            $table->boolean('subprograma')->default(false);
            $table->boolean('proyecto')->default(false);
            $table->boolean('actividad')->default(false);
            $table->boolean('obra')->default(false);
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
