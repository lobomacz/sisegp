<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateComunidadsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comunidads', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('municipio_id');
            $table->string('nombre', 100);
            $table->double('lat', 16, 6);
            $table->double('lng', 16, 6);
            $table->point('punto')->nullable()->comment('Para uso en sistema SIG');
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
        Schema::dropIfExists('comunidads');
    }
}
