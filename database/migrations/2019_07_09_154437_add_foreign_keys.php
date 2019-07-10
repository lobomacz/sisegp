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
        });

        Schema::table('proyectos', function(Blueprint $table){
            $table->foreign('programa_id')->references('id')->on('programas')->onDelete('cascade');
            $table->foreign('sector_desarrollo_id')->references('id')->on('sector_desarrollos');
        });

        Schema::table('resultados', function(Blueprint $table){
            $table->foreign('proyecto_id')->references('id')->on('proyectos')->onDelete('cascade');
            $table->foreign('unidad_medida_id')->references('id')->on('unidad_medidas');
        });

        Schema::table('productos', function(Blueprint $table){
            $table->foreign('resultado_id')->references('id')->on('resultados')->onDelete('cascade');
            $table->foreign('unidad_medida_id')->references('id')->on('unidad_medidas');
        });

        Schema::table('actividades', function(Blueprint $table){
            $table->foreign('producto_id')->references('id')->on('productos');
        });

        Schema::table('actividad_insumo', function(Blueprint $table){
            $table->foreign('actividad_id')->references('id')->on('actividades')->onDelete('cascade');
            $table->foreign('insumo_id')->references('id')->on('insumos');
            $table->foreign('unidad_medida_id')->references('id')->on('unidad_medidas');
        });

        Schema::table('insumos', function(Blueprint $table){
            $table->foreign('clasificador_id')->references('id')->on('clasificadors');
            $table->foreign('unidad_medida_id')->references('id')->on('unidad_medidas');
        });

        Schema::table('programa_unidad_gestion', function(Blueprint $table){
            $table->foreign('programa_id')->references('id')->on('programas')->onDelete('cascade');
            $table->foreign('unidad_gestion_id')->references('id')->on('unidad_gestions')->onDelete('cascade');
        });

        Schema::table('proyecto_unidad_gestion', function(Blueprint $table){
            $table->foreign('proyecto_id')->references('id')->on('proyectos')->onDelete('cascade');
            $table->foreign('unidad_gestion_id')->references('id')->on('unidad_gestions')->onDelete('cascade');
        });

        Schema::table('plans', function(Blueprint $table){
            $table->foreign('periodo_id')->references('id')->on('periodos')->onDelete('cascade');
            $table->foreign('unidad_gestion_id')->references('id')->on('unidad_gestions')->onDelete('cascade');
        });

        Schema::table('plan_producto', function(Blueprint $table){
            $table->foreign('plan_id')->references('id')->on('plans')->onDelete('cascade');
            $table->foreign('producto_id')->references('id')->on('productos');
        });

        Schema::table('actividad_plan_producto', function(Blueprint $table){
            $table->foreign('plan_producto_id')->references('id')->on('plan_producto')->onDelete('cascade');
            $table->foreign('actividad_id')->references('id')->on('actividades');
        });

        Schema::table('solicituds', function(Blueprint $table){
            $table->foreign('actividad_insumo_id')->references('id')->on('actividad_insumo');
            $table->foreign('funcionario_id')->references('id')->on('funcionarios');
            $table->foreign('unidad_gestion_id')->references('id')->on('unidad_gestions');
        });

        Schema::table('funcionario_rol', function(Blueprint $table){
            $table->foreign('funcionario_id')->references('id')->on('funcionarios')->onDelete('cascade');
            $table->foreign('rol_id')->references('id')->on('rols');
        });

        /*

        Schema::table('', function(Blueprint $table){
            
        });

        Schema::table('', function(Blueprint $tabble){
            
        });

        Schema::table('', function(Blueprint $tabble){
            
        });

        Schema::table('', function(Blueprint $tabble){
            
        });

        Schema::table('', function(Blueprint $tabble){
            
        });

        Schema::table('', function(Blueprint $tabble){
            
        });

        Schema::table('', function(Blueprint $tabble){
            
        });

        Schema::table('', function(Blueprint $tabble){
            
        });

        Schema::table('', function(Blueprint $tabble){
            
        });

        Schema::table('', function(Blueprint $tabble){
            
        });

        Schema::table('', function(Blueprint $tabble){
            
        });

        Schema::table('', function(Blueprint $tabble){
            
        });

        Schema::table('', function(Blueprint $tabble){
            
        });

        Schema::table('', function(Blueprint $tabble){
            
        });

        Schema::table('', function(Blueprint $tabble){
            
        });

        Schema::table('', function(Blueprint $tabble){
            
        });

        Schema::table('', function(Blueprint $tabble){
            
        });

        Schema::table('', function(Blueprint $tabble){
            
        });

        Schema::table('', function(Blueprint $tabble){
            
        });

        Schema::table('', function(Blueprint $tabble){
            
        });

        Schema::table('', function(Blueprint $tabble){
            
        });

        Schema::table('', function(Blueprint $tabble){
            
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
