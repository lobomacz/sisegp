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
    }
}
