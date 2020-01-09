<?php

use Illuminate\Database\Seeder;

class FuncionarioRolTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('funcionario_rol')->insert([
        	'funcionario_id' => 1,
        	'rol_id' => 1,
        ]);

        DB::table('funcionario_rol')->insert([
            'funcionario_id' => 2,
            'rol_id' => 5,
        ]);

        DB::table('funcionario_rol')->insert([
            'funcionario_id' => 3,
            'rol_id' => 2,
        ]);

        DB::table('funcionario_rol')->insert([
            'funcionario_id' => 4,
            'rol_id' => 4,
        ]);
    }
}
