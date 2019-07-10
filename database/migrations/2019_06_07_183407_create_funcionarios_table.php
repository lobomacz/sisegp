<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFuncionariosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('funcionarios', function (Blueprint $table) {
            $table->increments('id');
            $table->string('cedula', 16)->nullable(false);
            $table->string('primer_nombre',25)->nullable(false);
            $table->string('segundo_nombre', 25);
            $table->string('primer_apellido', 25)->nullable(false);
            $table->string('segundo_apellido', 25);
            $table->enum('sexo', ['masculino', 'femenino']);
            $table->date('fecha_nacimiento');
            $table->unsignedInteger('unidad_gestion_id')->nullable(false);
            $table->string('cargo', 25);
            $table->string('correo', 25)->nullable(false);
            $table->boolean('activo')->default(true);
            $table->boolean('habilitado')->default(true);
            $table->timestamps();

            $table->foreign('unidad_gestion_id')->references('id')->on('unidad_gestions');
            $table->unique('correo');
            $table->unique('cedula');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('funcionarios');
    }
}
