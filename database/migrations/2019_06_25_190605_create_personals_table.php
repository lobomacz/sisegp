<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePersonalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('personals', function (Blueprint $table) {
            $table->bigIncrements('id');
            //$table->unsignedBigInteger('plan_id');
            $table->string('clasificador_id');
            $table->string('cargo')->nullable(false);/*
            $table->integer('personas')->default(1);
            $table->decimal('salario', 8, 2);
            $table->decimal('treceavo', 8, 2);
            $table->decimal('antiguedad', 8, 2);
            $table->decimal('patronal', 8, 2);
            $table->decimal('inatec', 8, 2)->default(0.00);
            $table->decimal('beneficios', 8, 2)->default(0.00);
            $table->decimal('vacaciones', 8, 2)->default(0.00);
            $table->decimal('otros_beneficios', 8, 2)->default(0.00);
            $table->decimal('horas_extra', 8, 2)->default(0.00);*/
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
        Schema::dropIfExists('personals');
    }
}
