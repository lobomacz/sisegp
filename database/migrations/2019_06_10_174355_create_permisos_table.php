<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePermisosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('permisos', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('rol_id');
            $table->boolean('administrar_tablas');
            $table->boolean('administrar_usuarios');
            $table->boolean('eliminar_registros');
            $table->boolean('modificar_registros');
            $table->boolean('digitar_planes');
            $table->boolean('modificar_planes');
            $table->boolean('aprobar_planes');
            $table->boolean('ingresar_programas');
            $table->boolean('modificar_programas');
            $table->boolean('ingresar_proyectos');
            $table->boolean('modificar_proyectos');
            $table->boolean('ingresar_funcionarios');
            $table->boolean('modificar_funcionarios');
            $table->boolean('ingresar_actividades');
            $table->boolean('modificar_actividades');
            $table->boolean('aprobar_actividades');
            $table->boolean('cancelar_actividades');
            $table->boolean('digitar_solicitudes_gasto');
            $table->boolean('revisar_solicitudes_gasto');
            $table->boolean('verifica_presupuesto_solicitudes_gasto');
            $table->boolean('autorizar_solicitudes_gasto');
            $table->boolean('recibir_solicitudes_gasto');
            $table->boolean('digitar_solicitudes_adq');
            $table->boolean('autorizar_solicitudes_adq');
            $table->boolean('recibir_solicitudes_adq');
            $table->timestamps();

            $table->foreign('rol_id')->references('id')->on('rols')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('permisos');
    }
}
