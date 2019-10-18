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

        DB::table('rols')->insert([
        	'descripcion' => 'digitador-presupuesto',
        ]);

        DB::table('rols')->insert([
        	'descripcion' => 'digitador-fin',
        ]);

        //Permisos de superusuario
        DB::table('permisos')->insert([
        	'rol_id' => 1,
        	'administrar_tablas' => true,
        	'administrar_usuarios' => true,
        	'eliminar_registros' => true,
        	'modificar_registros' => true,
        	'ingresar_funcionarios' => true,
        	'modificar_funcionarios' => true,
        	'ingresar_programas' => true,
        	'modificar_programas' => true,
        	'ingresar_proyectos' => true, 
        	'modificar_proyectos' => true,
        ]);

        //Permisos de director
        DB::table('permisos')->insert([
        	'rol_id' => 2,
        	'aprobar_planes' => true,
            'aprobar_productos' => true,
            'aprobar_resultados' => true,
        	'aprobar_actividades' => true,
        	'cancelar_actividades' => true,
        	'revisar_solicitudes' => true,
        	'anular_solicitudes' => true,
        ]);

        //Permisos de director-seplan
        DB::table('permisos')->insert([
        	'rol_id' => 3,
        	'cerrar_planes' => true,
        	'aprobar_planes' => true,
        	'aprobar_actividades' => true,
        	'cancelar_actividades' => true,
        	'revisar_solicitudes' => true,
        	'ingresar_programas' => true,
        	'modificar_programas' => true,
        	'ingresar_proyectos' => true, 
        	'modificar_proyectos' => true,
            'aprobar_resultados' => true,
            'aprobar_productos' => true,
        ]);

        //Permisos de director-ejecutivo
        DB::table('permisos')->insert([
        	'rol_id' => 4,
        	'autorizar_solicitudes' => true,
        	'anular_solicitudes' => true,
        ]);

        //Permisos de digitador
        DB::table('permisos')->insert([
        	'rol_id' => 5,
        	'digitar_planes' => true,
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
        	'digitar_planes' => true,
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
        	'recepcionar_solicitudes' => true,
        ]);

        //Permisos de digitador-presupuesto
        DB::table('permisos')->insert([
        	'rol_id' => 7,
        	'digitar_planes' => true,
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
        	'verificar_presupuesto' => true,
        ]);

        //Permisos de digitador-fin
        DB::table('permisos')->insert([
        	'rol_id' => 7,
        	'digitar_planes' => true,
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
        	'recepcionar_solicitudes' => true,
        ]);

        $this->call(FuncionarioRolTableSeeder::class);

    }
}
