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
        	'cedula' => '000-000000-00000',
        	'primer_nombre' => 'Administrador',
        	'primer_apellido' => 'Administrador',
        	'cargo' => 'Administrador',
        	'correo' => 'lobomacz@gmail.com',
        ]);

        DB::table('users')->insert([
        	'funcionario_id' => 1,
        	'name' => 'Administrador',
        	'email' => 'lobomacz@gmail.com',
        	'password' => bcrypt('madmacz'),
        ]);

        $this->call(RolesTableSeeder::class);
    }
}
