<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClasificadorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clasificadors', function (Blueprint $table) {
            $table->string('id', 5);
            $table->timestamps();
            $table->string('clasificador_id', 5);
            $table->string('denominacion')->nullable(false);
            $table->boolean('grupo');
            $table->boolean('subgrupo');
            $table->boolean('renglon');
            $table->boolean('subrenglon');

            $table->primary('id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('clasificadors');
    }
}
