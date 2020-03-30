<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Alimentador inicial de la tabla Users con el registro del superadministrador
        DB::table('funcionarios')->insert([
            'rol_id' => 1,
        	'cedula' => '000-000000-00000',
        	'primer_nombre' => 'Administrador',
        	'primer_apellido' => 'Administrador',
        	'cargo' => 'Administrador',
        	'correo' => 'lobomacz@gmail.com',
            'sexo' => 'masculino',
            'fecha_nacimiento' => date('Y-m-d'),
        ]);

        DB::table('funcionarios')->insert([
            'rol_id' => 5,
            'cedula' => '601-130579-0000J',
            'primer_nombre' => 'Marvin',
            'primer_apellido' => 'Córdoba',
            'cargo' => 'Técnico',
            'correo' => 'lobomacz@yahoo.com',
            'sexo' => 'masculino',
            'fecha_nacimiento' => '1979-05-13',
            'unidad_gestion_id' => 3,
        ]);

        DB::table('funcionarios')->insert([
            'rol_id' => 3,
            'cedula' => '601-161275-0001A',
            'primer_nombre' => 'Franklin',
            'primer_apellido' => 'Brooks',
            'cargo' => 'Director',
            'correo' => 'fbrooksvargas_2013@yahoo.com',
            'sexo' => 'masculino',
            'fecha_nacimiento' => date('Y-m-d'),
            'unidad_gestion_id' => 3,
        ]);

        DB::table('funcionarios')->insert([
            'rol_id' => 4,
            'cedula' => '601-080179-0001K',
            'primer_nombre' => 'Danilo',
            'primer_apellido' => 'Chang',
            'cargo' => 'Director Ejecutivo',
            'correo' => 'danilo.chang@gmail.com',
            'sexo' => 'masculino',
            'fecha_nacimiento' => date('Y-m-d'),
            'unidad_gestion_id' => 1,
        ]);

        DB::table('funcionarios')->insert([
            'rol_id' => 2,
            'cedula' => '603-180356-1000F',
            'primer_nombre' => 'Manuel',
            'primer_apellido' => 'Zapata',
            'cargo' => 'Director de Finanzas',
            'correo' => 'mzapata@yahoo.com',
            'sexo' => 'masculino',
            'fecha_nacimiento' => date('Y-m-d'),
            'unidad_gestion_id' => 2,
        ]);

        DB::table('users')->insert([
        	'funcionario_id' => 1,
        	'name' => 'Administrador',
        	'email' => 'lobomacz@gmail.com',
        	'password' => bcrypt('madmacz'),
        ]);

        DB::table('users')->insert([
            'funcionario_id' => 2,
            'name' => 'Marvin Cordoba',
            'email' => 'lobomacz@yahoo.com',
            'password' => bcrypt('madmacz'),
        ]);

        DB::table('users')->insert([
            'funcionario_id' => 3,
            'name' => 'Franklin Brooks',
            'email' => 'fbrooksvargas_2013@yahoo.com',
            'password' => bcrypt('madmacz'),
        ]);

        DB::table('users')->insert([
            'funcionario_id' => 4,
            'name' => 'Danilo Chang',
            'email' => 'danilo.chang@gmail.com',
            'password' => bcrypt('madmacz'),
        ]);

        DB::table('users')->insert([
            'funcionario_id' => 5,
            'name' => 'Manuel Zapata',
            'email' => 'mzapata@yahoo.com',
            'password' => bcrypt('madmacz'),
        ]);

        //$this->call(RolesTableSeeder::class);

    }
}
