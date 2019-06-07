<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSolicitudGastosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('solicitud_gastos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();
            $table->bigInteger('actividad_insumo_id');
            $table->date('fecha');
            $table->decimal('monto',9,2);
            $table->enum('fuente', ['TESORO','COOPERACIÓN','FONDOS PROPIOS','TRAMITE AMBIENTAL']);
            $table->string('solicitante', 50);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('solicitud_gastos');
    }
}
