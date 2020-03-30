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
            $table->string('cedula', 16);
            $table->string('primer_nombre',45);
            $table->string('segundo_nombre', 45)->nullable();
            $table->string('primer_apellido', 45);
            $table->string('segundo_apellido', 45)->nullable();
            $table->enum('sexo', ['masculino', 'femenino']);
            $table->date('fecha_nacimiento');
            $table->unsignedInteger('unidad_gestion_id')->nullable();
            $table->string('cargo', 45);
            $table->string('correo', 45);
            $table->boolean('activo')->default(true);
            $table->unsignedInteger('rol_id');
            //$table->boolean('habilitado')->default(true);
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
        Schema::dropIfExists('funcionarios');
    }
}
