<?php

use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('rols')->insert([
        	'descripcion' => 'superusuario',
        ]);

        DB::table('rols')->insert([
        	'descripcion' => 'director',
        ]);

        DB::table('rols')->insert([
        	'descripcion' => 'director-seplan',
        ]);

        DB::table('rols')->insert([
        	'descripcion' => 'director-ejecutivo',
        ]);

        DB::table('rols')->insert([
        	'descripcion' => 'digitador',
        ]);

        DB::table('rols')->insert([
        	'descripcion' => 'digitador-adq',
        ]);


        //Permisos de superusuario
        DB::table('permisos')->insert([
        	'rol_id' => 1,
            'ver_programas' => true,
        	'ingresar_programas' => true,
        	'modificar_programas' => true,
            'ver_proyectos' => true,
        	'ingresar_proyectos' => true, 
        	'modificar_proyectos' => true,
        ]);

        //Permisos de director
        DB::table('permisos')->insert([
        	'rol_id' => 2,
        	'aprobar_planes' => true,
            'gestionar_planes' => true,
            'aprobar_productos' => true,
            'aprobar_resultados' => true,
        	'aprobar_actividades' => true,
        	'cancelar_actividades' => true,
        	'revisar_solicitudes' => true,
        	'anular_solicitudes' => true,
            'ver_programas' => true,
            'ver_proyectos' => true,
            'ver_resultados' => true,
            'ver_productos' => true,
            'ver_actividades' => true,
            'ver_planes' => true,
            'ver_solicitudes' => true,
        ]);

        //Permisos de director-seplan
        DB::table('permisos')->insert([
        	'rol_id' => 3,
        	'cerrar_planes' => true,
        	'aprobar_planes' => true,
            'eliminar_planes' => true,
            'gestionar_planes' => true,
        	'aprobar_actividades' => true,
        	'cancelar_actividades' => true,
        	'revisar_solicitudes' => true,
        	'ingresar_programas' => true,
        	'modificar_programas' => true,
        	'ingresar_proyectos' => true, 
        	'modificar_proyectos' => true,
            'aprobar_resultados' => true,
            'aprobar_productos' => true,
            'ver_programas' => true,
            'ver_proyectos' => true,
            'ver_resultados' => true,
            'ver_productos' => true,
            'ver_actividades' => true,
            'ver_planes' => true,
            'ver_solicitudes' => true,
        ]);

        //Permisos de director-ejecutivo
        DB::table('permisos')->insert([
        	'rol_id' => 4,
        	'autorizar_solicitudes' => true,
        	'anular_solicitudes' => true,
            'ver_programas' => true,
            'ver_proyectos' => true,
            'ver_resultados' => true,
            'ver_productos' => true,
            'ver_actividades' => true,
            'ver_planes' => true,
            'ver_solicitudes' => true,
        ]);

        //Permisos de digitador
        DB::table('permisos')->insert([
        	'rol_id' => 5,
        	'ingresar_planes' => true,
        	'modificar_planes' => true,
        	'ingresar_productos' => true,
        	'modificar_productos' => true,
            'eliminar_productos' => true,
        	'ingresar_resultados' => true,
        	'modificar_resultados' => true,
            'eliminar_resultados' => true,
        	'ingresar_actividades' => true,
        	'modificar_actividades' => true,
            'ejecutar_actividades' => true,
            'eliminar_actividades' => true,
        	'ingresar_solicitudes' => true,
        	'modificar_solicitudes' => true,
        ]);

        //Permisos de digitador-adq
        DB::table('permisos')->insert([
        	'rol_id' => 6,
        	'ingresar_planes' => true,
        	'modificar_planes' => true,
        	'ingresar_productos' => true,
        	'modificar_productos' => true,
            'eliminar_productos' => true,
            'ingresar_resultados' => true,
            'modificar_resultados' => true,
            'eliminar_resultados' => true,
            'ingresar_actividades' => true,
            'modificar_actividades' => true,
            'ejecutar_actividades' => true,
            'eliminar_actividades' => true,
        	'ingresar_solicitudes' => true,
        	'modificar_solicitudes' => true,
        	'procesar_solicitudes' => true,
        ]);


        //$this->call(FuncionarioRolTableSeeder::class);
        $this->call(EstructurasTableSeeder::class);

    }
}
