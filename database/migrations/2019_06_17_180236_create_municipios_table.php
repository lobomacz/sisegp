<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMunicipiosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('municipios', function (Blueprint $table) {
            $table->increments('id');
            $table->enum('region', ['raccn', 'raccs']);
            $table->string('nombre', 50);
            $table->string('nombre_corto', 10);
            $table->float('poblacion', 8, 2)->comment('Poblacion aproximada de fuente oficial.')->nullable();
            $table->float('extension', 8, 2)->comment('En kilometros cuadrados.')->nullable();
            $table->polygon('mapa')->nullable()->comment('Shape para uso en sistema SIG');
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
        Schema::dropIfExists('municipios');
    }
}
