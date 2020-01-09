<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFotoInformeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('foto_informe', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('foto_id');
            $table->unsignedBigInteger('informe_id');
            $table->timestamps();

            $table->foreign('foto_id')->references('id')->on('fotos')->onDelete('cascade');
            $table->foreign('informe_id')->references('id')->on('informes')->onDelete('cascade');

            $table->unique(['foto_id', 'informe_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('foto_informe');
    }
}
