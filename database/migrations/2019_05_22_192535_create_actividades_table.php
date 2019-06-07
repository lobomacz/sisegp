<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateActividadesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('actividades', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();
            $table->bigInteger('producto_id');
            $table->string('codigo', 9);
            $table->string('descripcion', 600);
            $table->enum('fuente_financiamiento', ['tesoro','cooperacion','ingresos propios','privado']);
            $table->decimal('monto_presupuesto', 11, 2);
            $table->decimal('monto_aprobado', 11, 2);
            $table->decimal('monto_disponible', 11, 2);
            $table->boolean('solicitada');
            $table->boolean('aprobada');
            $table->boolean('ejecutada');
            $table->boolean('cancelada');

            $table->primary('id');
            $table->foreign('producto_id')->references('id')->on('productos');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('actividades');
    }
}
