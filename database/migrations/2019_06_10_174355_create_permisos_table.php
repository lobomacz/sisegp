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
            $table->boolean('administrar_tablas')->default(false);
            $table->boolean('administrar_usuarios')->default(false);
            $table->boolean('eliminar_registros')->default(false);
            $table->boolean('modificar_registros')->default(false);
            $table->boolean('ingresar_planes')->default(false);
            $table->boolean('modificar_planes')->default(false);
            $table->boolean('aprobar_planes')->default(false);
            $table->boolean('cerrar_planes')->default(false);
            $table->boolean('eliminar_planes')->default(false);
            $table->boolean('ingresar_programas')->default(false);
            $table->boolean('modificar_programas')->default(false);
            $table->boolean('ingresar_proyectos')->default(false);
            $table->boolean('modificar_proyectos')->default(false);
            $table->boolean('ingresar_productos')->default(false);
            $table->boolean('modificar_productos')->default(false);
            $table->boolean('aprobar_productos')->default(false);
            $table->boolean('eliminar_productos')->default(false);
            $table->boolean('ingresar_resultados')->default(false);
            $table->boolean('modificar_resultados')->default(false);
            $table->boolean('aprobar_resultados')->default(false);
            $table->boolean('eliminar_resultados')->default(false);
            $table->boolean('ingresar_funcionarios')->default(false);
            $table->boolean('modificar_funcionarios')->default(false);
            $table->boolean('ingresar_actividades')->default(false);
            $table->boolean('modificar_actividades')->default(false);
            $table->boolean('aprobar_actividades')->default(false);
            $table->boolean('cancelar_actividades')->default(false);
            $table->boolean('ejecutar_actividades')->default(false);
            $table->boolean('eliminar_actividades')->default(false);
            $table->boolean('ingresar_solicitudes')->default(false);
            $table->boolean('modificar_solicitudes')->default(false);
            $table->boolean('anular_solicitudes')->default(false);
            $table->boolean('revisar_solicitudes')->default(false);
            $table->boolean('verificar_presupuesto')->default(false);
            $table->boolean('autorizar_solicitudes')->default(false);
            $table->boolean('recepcionar_solicitudes')->default(false);
            
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
        Schema::dropIfExists('permisos');
    }
}
