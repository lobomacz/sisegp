<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddForeignKeys extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('unidad_gestions', function(Blueprint $table){
            $table->foreign('estructura_id')->references('id')->on('estructuras');
            $table->foreign('unidad_gestion_id')->references('id')->on('unidad_gestions');
        });

        Schema::table('proyectos', function(Blueprint $table){
            $table->foreign('programa_id')->references('id')->on('programas')->onDelete('cascade');
            $table->foreign('sector_desarrollo_id')->references('id')->on('sector_desarrollos');
        });

        Schema::table('resultados', function(Blueprint $table){
            $table->foreign('proyecto_id')->references('id')->on('proyectos')->onDelete('cascade');
            $table->foreign('unidad_medida_id')->references('id')->on('unidad_medidas')->onDelete('restrict');
        });

        Schema::table('productos', function(Blueprint $table){
            $table->foreign('resultado_id')->references('id')->on('resultados')->onDelete('restrict');
            $table->foreign('unidad_medida_id')->references('id')->on('unidad_medidas')->onDelete('restrict');
        });

        Schema::table('actividades', function(Blueprint $table){
            $table->foreign('producto_id')->references('id')->on('productos')->onDelete('restrict');
        });

        Schema::table('actividad_insumo', function(Blueprint $table){
            $table->foreign('actividad_id')->references('id')->on('actividades')->onDelete('cascade');
            $table->foreign('insumo_id')->references('id')->on('insumos')->onDelete('restrict');
            $table->foreign('unidad_medida_id')->references('id')->on('unidad_medidas')->onDelete('restrict');

            $table->unique(['actividad_id', 'insumo_id']);
        });

        Schema::table('insumos', function(Blueprint $table){
            $table->foreign('clasificador_id')->references('id')->on('clasificadors')->onDelete('set null');
            $table->foreign('unidad_medida_id')->references('id')->on('unidad_medidas')->onDelete('restrict');
        });

        Schema::table('clasificadors', function(Blueprint $table){
            $table->foreign('clasificador_id')->references('id')->on('clasificadors');
        });

        Schema::table('estructuras', function(Blueprint $table){
            $table->foreign('estructura_id')->references('id')->on('estructuras');
        });

        Schema::table('programa_unidad_gestion', function(Blueprint $table){
            $table->foreign('programa_id')->references('id')->on('programas')->onDelete('cascade');
            $table->foreign('unidad_gestion_id')->references('id')->on('unidad_gestions')->onDelete('cascade');

            $table->unique(['programa_id', 'unidad_gestion_id']);
        });

        Schema::table('periodos', function(Blueprint $table){
            //$table->foreign('periodo_anterior')->references('id')->on('periodos');
        });

        Schema::table('proyecto_unidad_gestion', function(Blueprint $table){
            $table->foreign('proyecto_id')->references('id')->on('proyectos')->onDelete('cascade');
            $table->foreign('unidad_gestion_id')->references('id')->on('unidad_gestions')->onDelete('cascade');

            $table->unique(['proyecto_id', 'unidad_gestion_id']);
        });

        Schema::table('plans', function(Blueprint $table){
            $table->foreign('periodo_unidad_id')->references('id')->on('periodo_unidads')->onDelete('restrict');
            //$table->foreign('unidad_gestion_id')->references('id')->on('unidad_gestions')->onDelete('restrict');
        });

        Schema::table('plan_resultado', function(Blueprint $table){
            //$table->foreign('plan_id')->references('id')->on('plans')->onDelete('cascade');
            //$table->foreign('resultado_id')->references('id')->on('resultados')->onDelete('cascade');
            //$table->unique(['plan_id', 'resultado_id']);
        });

        Schema::table('plan_producto', function(Blueprint $table){
            $table->foreign('plan_id')->references('id')->on('plans')->onDelete('cascade');
            $table->foreign('producto_id')->references('id')->on('productos');

            $table->unique(['plan_id', 'producto_id']);
        });

        Schema::table('actividad_plan', function(Blueprint $table){
            $table->foreign('plan_id')->references('id')->on('plans')->onDelete('cascade');
            $table->foreign('actividad_id')->references('id')->on('actividades');

            $table->unique(['plan_id', 'actividad_id']);
        });

        Schema::table('solicituds', function(Blueprint $table){
            $table->foreign('actividad_insumo_id')->references('id')->on('actividad_insumo')->onDelete('restrict');
            $table->foreign('funcionario_id')->references('id')->on('funcionarios')->onDelete('set null');
            $table->foreign('unidad_gestion_id')->references('id')->on('unidad_gestions')->onDelete('restrict');
        });

        Schema::table('funcionarios', function(Blueprint $table){
            $table->foreign('unidad_gestion_id')->references('id')->on('unidad_gestions')->onDelete('set null');
            $table->foreign('rol_id')->references('id')->on('rols')->onDelete('restrict');

            $table->unique('correo');
            $table->unique('cedula');
        });

        /*
        Schema::table('funcionario_rol', function(Blueprint $table){
            $table->foreign('funcionario_id')->references('id')->on('funcionarios')->onDelete('cascade');
            $table->foreign('rol_id')->references('id')->on('rols')->onDelete('cascade');
        });
        */
        
        Schema::table('permisos', function(Blueprint $table){
            $table->foreign('rol_id')->references('id')->on('rols')->onDelete('cascade');
        });

        Schema::table('especificacions', function(Blueprint $table){
            $table->foreign('solicitud_id')->references('id')->on('solicituds');
            $table->foreign('unidad_medida_id')->references('id')->on('unidad_medidas');
        });


        Schema::table('documento_solicitud', function(Blueprint $table){
            $table->foreign('documento_id')->references('id')->on('documentos')->onDelete('cascade');
            $table->foreign('solicitud_id')->references('id')->on('solicituds')->onDelete('cascade');

            $table->unique(['documento_id', 'solicitud_id']);
        });

        Schema::table('comunidads', function(Blueprint $table){
            $table->foreign('municipio_id')->references('id')->on('municipios')->onDelete('cascade');
        });

        Schema::table('comunidad_proyecto', function(Blueprint $table){
            $table->foreign('comunidad_id')->references('id')->on('comunidads')->onDelete('cascade');
            $table->foreign('proyecto_id')->references('id')->on('proyectos')->onDelete('cascade');

            $table->unique(['comunidad_id', 'proyecto_id']);
        });

        Schema::table('actividad_documento', function(Blueprint $table){
            $table->foreign('actividad_id')->references('id')->on('actividades')->onDelete('cascade');
            $table->foreign('documento_id')->references('id')->on('documentos')->onDelete('cascade');

            $table->unique(['actividad_id', 'documento_id']);
        });

        Schema::table('actividad_foto', function(Blueprint $table){
            $table->foreign('actividad_id')->references('id')->on('actividades')->onDelete('cascade');
            $table->foreign('foto_id')->references('id')->on('fotos')->onDelete('cascade');

            $table->unique(['actividad_id', 'foto_id']);
        });

        Schema::table('documento_plan', function(Blueprint $table){
            $table->foreign('documento_id')->references('id')->on('documentos')->onDelete('cascade');
            $table->foreign('plan_id')->references('id')->on('plans')->onDelete('cascade');

            $table->unique(['documento_id', 'plan_id']);
        });

        /*
        Schema::table('servicio_personals', function(Blueprint $table){
            $table->foreign('plan_id')->references('id')->on('plans')->onDelete('cascade');
            $table->foreign('clasificador_id')->references('id')->on('clasificadors');
        });


        Schema::table('', function(Blueprint $table){
            
        });
        */

        Schema::table('users', function(Blueprint $table){

            //Agregado para tener referencia de funcionario por usuario

            $table->foreign('funcionario_id')->references('id')->on('funcionarios')->onDelete('cascade');
            
        });

        /*

        Schema::table('', function(Blueprint $table){
            
        });

        Schema::table('', function(Blueprint $table){
            
        });

        Schema::table('', function(Blueprint $table){
            
        });

        Schema::table('', function(Blueprint $table){
            
        });

        Schema::table('', function(Blueprint $table){
            
        });

        Schema::table('', function(Blueprint $table){
            
        });

        Schema::table('', function(Blueprint $table){
            
        });

        Schema::table('', function(Blueprint $table){
            
        });

        Schema::table('', function(Blueprint $table){
            
        });

        Schema::table('', function(Blueprint $table){
            
        });

        Schema::table('', function(Blueprint $table){
            
        });

        Schema::table('', function(Blueprint $table){
            
        });
        */
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
