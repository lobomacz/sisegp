<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateServicioPersonalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('servicio_personals', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('plan_id');
            $table->string('clasificador_id');
            $table->string('cargo')->nullable(false);
            $table->integer('cantidad_personas')->default(1);
            $table->decimal('salario', 8, 2)->nullable(false);
            $table->decimal('treceavo', 8, 2)->nullable(false);
            $table->decimal('antiguedad', 8, 2)->nullable(false);
            $table->decimal('patronal', 8, 2)->nullable(false);
            $table->decimal('inatec', 8, 2)->nullable(false);
            $table->decimal('beneficios', 8, 2)->default(0.00);
            $table->decimal('vacaciones', 8, 2)->default(0.00);
            $table->decimal('otros_beneficios', 8, 2)->default(0.00);
            $table->decimal('horas_extra', 8, 2)->default(0.00);
            $table->timestamps();

            $table->foreign('plan_id')->references('id')->on('plans')->onDelete('cascade');
            $table->foreign('clasificador_id')->references('id')->on('clasificadors');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('servicio_personals');
    }
}
