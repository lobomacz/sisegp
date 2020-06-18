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
            $table->unsignedBigInteger('producto_id');
            $table->string('codigo', 12);
            $table->string('descripcion', 600);
            $table->enum('fuente_financiamiento', ['tesoro','cooperación','fondos propios','trámite ambiental']);
            $table->decimal('monto_presupuesto', 11, 2);
            $table->decimal('monto_aprobado', 11, 2)->default(0.00);
            $table->decimal('monto_disponible', 11, 2)->default(0.00);
            $table->boolean('aprobada')->default(false);
            $table->boolean('ejecutada')->default(false);
            $table->boolean('cancelada')->default(false); //Al cierre del período, si no está aprobada, será cancelada la actividad.
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
        Schema::dropIfExists('actividades');
    }
}
