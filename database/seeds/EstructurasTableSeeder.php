<?php

use Illuminate\Database\Seeder;

class EstructurasTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //ESTRUCTURA PROGRAMATICA

        DB::table('estructuras')->insert([
        	'codigo' => '001',
        	'nombre' => 'ACTIVIDADES CENTRALES',
        	'programa' => true,
        ]);

        DB::table('estructuras')->insert([
        	'codigo' => '027',
        	'nombre' => 'SERVICIO REGIONAL DE FINANZAS',
        	'programa' => true,
        ]);

        DB::table('estructuras')->insert([
        	'codigo' => '028',
        	'nombre' => 'SERVICIO REGIONAL DE PLANIFICACION',
        	'programa' => true,
        ]);

        DB::table('estructuras')->insert([
        	'codigo' => '101',
        	'estructura_id' => 1,
        	'nombre' => 'DIRECCION SUPERIOR',
        	'actividad' => true,
        ]);

        DB::table('estructuras')->insert([
        	'codigo' => '271',
        	'estructura_id' => 2,
        	'nombre' => 'DIRECCION Y COORDINACION',
        	'actividad' => true,
        ]);

        DB::table('estructuras')->insert([
        	'codigo' => '281',
        	'estructura_id' => 3,
        	'nombre' => 'DIRECCION Y COORDINACION',
        	'actividad' => true,
        ]);


        //UNIDADES DE GESTION

        DB::table('unidad_gestions')->insert([
        	'estructura_id' => 4,
            'acronimo' => 'DISUP',
        	'nombre' => 'DIRECCION SUPERIOR',
        	'direccion_coordinacion' => true,
        ]);

        DB::table('unidad_gestions')->insert([
        	'estructura_id' => 5,
            'acronimo' => 'SERFIN',
        	'nombre' => 'SECRETARIA REGIONAL DE FINANZAS',
        	'direccion_coordinacion' => true,
        ]);

        DB::table('unidad_gestions')->insert([
        	'estructura_id' => 6,
            'acronimo' => 'SEPLAN',
        	'nombre' => 'SECRETARIA REGIONAL DE PLANIFICACION',
        	'direccion_coordinacion' => true,
        ]);



        $this->call(UsersTableSeeder::class);
    }
}
