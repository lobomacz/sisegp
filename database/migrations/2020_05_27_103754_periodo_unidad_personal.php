<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class PeriodoUnidadPersonal extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //Crear tabla de unión para PeriodoUnidad y Personal
        Schema::create('periodo_unidad_personal', function(Blueprint $table){
            $table->bigIncrements('id');
            $table->unsignedBigInteger('periodo_unidad_id');
            $table->unsignedBigInteger('personal_id');
            $table->integer('personas')->default(1);
            $table->decimal('salario', 8, 2);
            $table->decimal('treceavo', 8, 2);
            $table->decimal('antiguedad', 8, 2);
            $table->decimal('patronal', 8, 2);
            $table->decimal('inatec', 8, 2)->default(0.00);
            $table->decimal('beneficios', 8, 2)->default(0.00);
            $table->decimal('vacaciones', 8, 2)->default(0.00);
            $table->decimal('otros_beneficios', 8, 2)->default(0.00);
            $table->decimal('horas_extra', 8, 2)->default(0.00);
            $table->timestamps();

            $table->foreign('periodo_unidad_id')->references('id')->on('periodo_unidads')->onDelete('cascade');
            $table->foreign('personal_id')->references('id')->on('personals')->onDelete('cascade');
        });
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
