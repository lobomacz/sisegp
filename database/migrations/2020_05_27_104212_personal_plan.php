k<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class PersonalPlan extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('personal_plan', function(Blueprint $table){
            $table->bigIncrements('id');
            $table->unsignedBigInteger('personal_id');
            $table->unsignedBigInteger('plan_id');
            $table->integer('personas')->default(1);
            $table->decimal('salario', 8, 2);
            //$table->decimal('treceavo', 8, 2);
            //$table->decimal('antiguedad', 8, 2);
            //$table->decimal('patronal', 8, 2);
            //$table->decimal('inatec', 8, 2)->default(0.00);
            //$table->decimal('beneficios', 8, 2)->default(0.00);
            //$table->decimal('vacaciones', 8, 2)->default(0.00);
            //$table->decimal('otros_beneficios', 8, 2)->default(0.00);
            //$table->decimal('horas_extra', 8, 2)->default(0.00);
            $table->timestamps();

            $table->foreign('personal_id')->references('id')->on('personals')->onDelete('cascade');
            $table->foreign('plan_id')->references('id')->on('plans')->onDelete('cascade');
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
